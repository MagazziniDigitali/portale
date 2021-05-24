<?php
  require("../../wp-load.php");
  require("../src/functions.php");
  require("../src/lib/bagit.php");

        if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
  redirect_if_not_logged_in();

  if($_SESSION['role'] == 'admin_istituzione'){

    $dbMD = connect_to_md();

    if (isset($_POST['submitBagit'])) {

      if(isset($_POST['checkExrtaction'])) {
        $checkExrtaction = $_POST['checkExrtaction'];
      }
      
      $pivaIstituzione = check_istituizone_PIVA($dbMD);
  
      // CREATE TMP DIR AND UPLOAD FILE IN IT
      $temp_dir_name = generateRandomString();
      $temp_dir = "../src/tmp/" . $temp_dir_name;
      mkdir($temp_dir, 0777);
  
      $file_name = basename($_FILES['fileToUpload']['name']);
  
      $target_temp_name = "../src/tmp/" . $temp_dir_name;
      $target = $target_temp_name . '/' . $file_name;
  
      move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);
  
      if(isset($_POST['nameCreator'])) {
  
        $nameCreator    = $_POST['nameCreator'];
        $selectCreator  = $_POST['selectCreator'];
  
        $userData = count($nameCreator);
      
        $creatorArray = array ();
  
        if ($userData > 0) {
          for ($i=0; $i < $userData; $i++) { 
            if (trim($nameCreator != '') && trim($selectCreator != '')) {
  
              $currentCreator = array();
  
              $select   = $selectCreator[$i];
              $name     = $nameCreator[$i];
  
              $currentCreator["type"] = $select;
              $currentCreator["name"] = $name;
  
              $creatorArray[] = $currentCreator;
  
            }
          }
        }
      }
  
      if(isset($_POST['nameIdentifiers'])) {
  
        $nameIdentifiers    = $_POST['nameIdentifiers'];
        $selectIdentifiers  = $_POST['selectIdentifiers'];
  
        $userData = count($nameIdentifiers);
      
        $identifiersArray = array ();
  
        if ($userData > 0) {
          for ($i=0; $i < $userData; $i++) { 
            if (trim($nameIdentifiers != '') && trim($selectIdentifiers != '')) {
  
              $currentIdentifiers = array();
  
              $select   = $selectIdentifiers[$i];
              $name     = $nameIdentifiers[$i];
  
              $currentIdentifiers["type"] = $select;
              $currentIdentifiers["ID"] = $name;
  
              $identifiersArray[] = $currentIdentifiers;
  
            }
          }
        }
      }

      // CREATE JSON FILE
      $jsonArray = array(
        "title"         => $_POST['titolo'],
        "description"   => $_POST['descrizione'],
        "publisher"     => $_POST['editore'],
        "language"      => $_POST['lingua'],
        "subject"       => $_POST['soggetti'],
        "rights"        => $_POST['licenza'],
        "date"          => $_POST['data'],
        "creator"       => $creatorArray,
        "identifiers"   => $identifiersArray
      );
  
      $json = json_encode($jsonArray);
  
      $stripped_filename = pathinfo($target, PATHINFO_FILENAME);
      $json_file = $stripped_filename . '.' . pathinfo($target)['extension'] . '.metadata';
      $json_target = $target_temp_name . '/' . $json_file;
  
      file_put_contents($json_target, $json);
      // END CREATE JSON FILE
  
      // CREATE BAGIT
      $path_PIVA = '/mnt/areaTemporanea/Ingest/' . $pivaIstituzione;
      if (!file_exists($path_PIVA)) {
        mkdir($path_PIVA, 0777, true);
      }
  
      $path_PIVA_tmp = $path_PIVA . '/tmp/';
      if (!file_exists($path_PIVA_tmp)) {
        mkdir($path_PIVA_tmp, 0777, true);
      }
  
      define('BASE_DIR', $path_PIVA_tmp);
  
      $bag = new BagIt(BASE_DIR);
      
      $bag->addFile($target, $file_name);
      $bag->addFile($json_target, $json_file);
  
      $bag->update();
      
      $timestamp = round(microtime(true) * 1000);
  
      $stripped_filename = BagIt_sanitizeFileName($stripped_filename);
        
      $bag->package($path_PIVA . '/' . $stripped_filename . '-' . $timestamp, 'zip', $stripped_filename);
  
      $path_temp_baginfo = '/mnt/areaTemporanea/Ingest/' . $pivaIstituzione . '/' . $temp_dir_name;
      if (!file_exists($path_temp_baginfo)) {
        mkdir($path_temp_baginfo, 0777, true);
      }
  
      $fileSizeByte = filesize($path_PIVA . '/' . $stripped_filename . '-' . $timestamp . '.zip');
      $fileSizeKb   = convertToReadableSize($fileSizeByte);
  
      $bagInfoString = "";
      if($checkExrtaction) {
        $bagInfoString .= "Bagit-Profile-Identifier: ALLOW_TEXT_EXTRACTION\n";
      }
      $bagInfoString .= "Bagging-Date: " . date("Y-m-d") . "\n";
      $bagInfoString .= "Bag-Size: " . $fileSizeKb . "\n";
      $bagInfoString .= "Source-Organization: " . $_SESSION['istituzione'] . "\n";
      foreach ($identifiersArray as $item ) {
        $bagInfoString .= "Internal-Sender-Identifier: " . $item['type'] . " - " . $item['ID'] . "\n";
      }
      
    
      file_put_contents($path_temp_baginfo . '/bag-info.txt', $bagInfoString);
  
      $zip = new ZipArchive;
      if ($zip->open($path_PIVA . '/' . $stripped_filename . '-' . $timestamp . '.zip') === TRUE) {
        $zip->addFile($path_temp_baginfo . '/bag-info.txt', '/bag-info.txt');
        $zip->close();
      }

      //INVIO A MAGAZZINI DIGITALI

      $infoSoftware = retrieve_info_from_mdsoftware($dbMD);

      foreach ($infoSoftware as $element){
        $loginSoftware = $element->LOGIN;
        $passwordSoftware = $element->PASSWORD;
      }

      $authentication = array(
        "login" => $loginSoftware,
        "password" => $passwordSoftware,
      );

      //SELECT * FROM MagazziniDigitali3_Collaudo.MDFilesTmpError where id_mdfilestmp='e7d9c8fe-abc3-4d02-9fab-8fb94220a522';

      //SELECT * FROM MagazziniDigitali3_Collaudo.MDFilesTmp ORDER BY TRASF_DATASTART DESC LIMIT 1;

      $software = webServiceAuthenticateSoftware($authentication);
    
      if (!isset($software)) {
        echo "<br>Invalid Software authentication";
        return;
      }
    
      $filename = $filename = $path_PIVA . '/' . $stripped_filename . '-' . $timestamp . '.zip';
      $stripped = str_replace("/mnt/areaTemporanea/Ingest/" . $pivaIstituzione . "/", "", $filename);
    
      if($software){
    
        $fTime        = filemtime($filename);
        $md5          = md5_file($filename);
        $md5_base64   = base64_encode($md5);    
        $sha1         = sha1_file($filename);
        $sha1_base64  = base64_encode($sha1);
        $sha2         = hash('sha256', $filename, true);
        $sha2_base64  = base64_encode($sha2);
          
        $readInfoInput = array (
          "software"          => $software,
          "oggettoDigitale"   => array(
            "nomeFile"        => $stripped,
            "digest"          => array (
              array(
                "digestType"  => "MD5",
                "digestValue" => $md5
              ),
              array(
                "digestType"  => "MD5-64Base",
                "digestValue" => $md5_base64
              ),
              array(
                "digestType"  => "SHA1",
                "digestValue" => $sha1
              ),
              array(
                "digestType"  => "SHA1-64Base",
                "digestValue" => $sha1_base64
              ),
              array(
                "digestType"  => "SHA256",
                "digestValue" => $sha2_base64
              ),
              array(
                "digestType"  => "SHA256-64Base",
                "digestValue" => $sha2_base64
              ),
            ),
            "ultimaModifica"  => $fTime,
          ),
        );
        
        $readInfoOutput = webServiceCheckMD($readInfoInput);
        $statoOggettoDigitale = $readInfoOutput->oggettoDigitale->statoOggettoDigitale;
    
        if ($statoOggettoDigitale == "NONPRESENTE") {
            
          $readInfoOutput = initSendOggettoDigitale($filename, $readInfoInput);
          $statoOggettoDigitale = $readInfoOutput->oggettoDigitale->statoOggettoDigitale;
          
          if ($statoOggettoDigitale == "INITTRASF"){
            endSendOggettoDigitale($readInfoOutput);
          }
              
          $readInfoOutput = webServiceCheckMD($readInfoInput);
          $statoOggettoDigitale = $readInfoOutput->oggettoDigitale->statoOggettoDigitale;
    
        }
        
        if ($statoOggettoDigitale == "INITTRASF") {
            
          endSendOggettoDigitale($readInfoOutput);
          
          $readInfoOutput = webServiceCheckMD($readInfoInput);
          $statoOggettoDigitale = $readInfoOutput->oggettoDigitale->statoOggettoDigitale;
    
        }
        
        if ($statoOggettoDigitale == "FINETRASF"){
    
          $idOggettoDigitale = $readInfoOutput->oggettoDigitale->id;
          $successGenerate = "Il bagit è stato caricato con successo<br>Numero di ricevuta: " . $idOggettoDigitale;
    
        } else {

          rmdir_recursive($targetPIVA);
          $alertGenerate = "Il bagit non è stato correttamente trasferito";
          
        }

      }
      
      rmdir_recursive($temp_dir);
      rmdir_recursive($path_PIVA_tmp);
      rmdir_recursive($path_temp_baginfo);
  
      $file_name_zip  = $path_PIVA . '/' . $stripped_filename . '-' . $timestamp . '.zip';
      $file_url_zip   = $stripped_filename . '-' . $timestamp . '.zip';
      
      ob_clean();
  
      //AUTOMATIC BAGIT DOWNLOAD
      header('Content-Type: application/octet-stream');
      header("Content-Transfer-Encoding: Binary");
      header("Content-disposition: attachment; filename=\"".$file_url_zip."\"");
      readfile($file_name_zip);
      exit;
    }
 
    if (isset($_POST['submitUploadedBagit'])) {
  
      $pivaIstituzione = check_istituizone_PIVA($dbMD);
  
      $path_PIVA = realpath('/mnt/areaTemporanea/Ingest/' . $pivaIstituzione);
      if (!file_exists($path_PIVA)) {
        mkdir($path_PIVA, 0777, true);
      }
      
      $file_name = basename($_FILES['fileToUpload']['name']);

      $targetPIVA = $path_PIVA . '/' . $file_name;
      
      if(file_exists($targetPIVA)){
  
        $alert = "Questo file è già presente";
  
      } else {

        $temp_dir_name = generateRandomString();

        $temp_dir = "../src/tmp/" . $temp_dir_name;
        mkdir($temp_dir, 0777);

        $target_temp_name = realpath("../src/tmp/" . $temp_dir_name);
        $target = $target_temp_name . '/' . $file_name;

        $path_info = pathinfo($target);
        
        move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);

        if ($path_info['extension'] == 'zip'){

          $zip = new ZipArchive();
          if($zip->open($target) === TRUE) {
            $count = 0;
            for( $i = 0; $i < $zip->numFiles; $i++ ){
              $stat = $zip->statIndex( $i );
              if ((basename($stat['name']) == 'data') || (basename($stat['name']) == 'bag-info.txt') || (basename($stat['name']) == 'bagit.txt') || (basename($stat['name']) == 'manifest-sha256.txt') || (basename($stat['name']) == 'manifest-sha1.txt')) {
                $count++;
              }
            }

            $zip->close();
          }
          
        } else if ($path_info['extension'] == 'gz') {

          $archive = new PharData($target);
          $count = 0;

          foreach($archive as $file) {

            if ((basename($file) == 'data') || (basename($file) == 'bag-info.txt') || (basename($file) == 'bagit.txt') || (basename($file) == 'manifest-sha256.txt') || (basename($file) == 'manifest-sha1.txt')) {
              $count++;
            }

          }
          
        }

        if ($count == 4){

          rename($target, $targetPIVA);
          rmdir_recursive($temp_dir);
          
          //INVIO A MAGAZZINI DIGITALI

          $infoSoftware = retrieve_info_from_mdsoftware($dbMD);

          foreach ($infoSoftware as $element){
            $loginSoftware = $element->LOGIN;
            $passwordSoftware = $element->PASSWORD;
          }

          $authentication = array(
            "login" => $loginSoftware,
            "password" => $passwordSoftware,
          );
          
          $software = webServiceAuthenticateSoftware($authentication);
        
          if (!isset($software)) {
            echo "<br>Invalid Software authentication";
            return;
          }
        
          $filename = $targetPIVA;
          $stripped = str_replace("/mnt/areaTemporanea/Ingest/" . $pivaIstituzione . "/", "", $filename);
        
          if($software){
        
            $fTime        = filemtime($filename);
            $md5          = md5_file($filename);
            $md5_base64   = base64_encode($md5);    
            $sha1         = sha1_file($filename);
            $sha1_base64  = base64_encode($sha1);
            $sha2         = hash('sha256', $filename, true);
            $sha2_base64  = base64_encode($sha2);

            $readInfoInput = array (
              "software"          => $software,
              "oggettoDigitale"   => array(
                "nomeFile"        => $stripped,
                "digest"          => array (
                  array(
                    "digestType"  => "MD5",
                    "digestValue" => $md5
                  ),
                  array(
                    "digestType"  => "MD5-64Base",
                    "digestValue" => $md5_base64
                  ),
                  array(
                    "digestType"  => "SHA1",
                    "digestValue" => $sha1
                  ),
                  array(
                    "digestType"  => "SHA1-64Base",
                    "digestValue" => $sha1_base64
                  ),
                  array(
                    "digestType"  => "SHA256",
                    "digestValue" => $sha2_base64
                  ),
                  array(
                    "digestType"  => "SHA256-64Base",
                    "digestValue" => $sha2_base64
                  ),
                ),
                "ultimaModifica"  => $fTime,
              ),
            );
            
            $readInfoOutput = webServiceCheckMD($readInfoInput);
            $statoOggettoDigitale = $readInfoOutput->oggettoDigitale->statoOggettoDigitale;
        
            if ($statoOggettoDigitale == "NONPRESENTE") {
                
              $readInfoOutput = initSendOggettoDigitale($filename, $readInfoInput);
              $statoOggettoDigitale = $readInfoOutput->oggettoDigitale->statoOggettoDigitale;
              
              if ($statoOggettoDigitale == "INITTRASF"){
                endSendOggettoDigitale($readInfoOutput);
              }
                  
              $readInfoOutput = webServiceCheckMD($readInfoInput);
              $statoOggettoDigitale = $readInfoOutput->oggettoDigitale->statoOggettoDigitale;
        
            }
            
            if ($statoOggettoDigitale == "INITTRASF") {
                
              endSendOggettoDigitale($readInfoOutput);
              
              $readInfoOutput = webServiceCheckMD($readInfoInput);
              $statoOggettoDigitale = $readInfoOutput->oggettoDigitale->statoOggettoDigitale;
        
            }
            
            if ($statoOggettoDigitale == "FINETRASF"){
        
              $idOggettoDigitale = $readInfoOutput->oggettoDigitale->id;
              $success = "Il bagit è stato caricato con successo<br>Numero di ricevuta: " . $idOggettoDigitale;
        
            } else {

              unlink($targetPIVA);
              $alert = "Il bagit non è stato correttamente trasferito";
              
            }

          } else {
            $alert = "Il bagit non è conforme allo standard";
          }

        } else {
          $alert = "Il formato caricato non è supportato. I formati supportati sono: zip, tar.gz.";
        }
      }
    }
  
    
  
    get_header();
  
  ?> 
  
  <section>
  
      <div class="container">
  
        <h2>Carica Bagit</h2>
  
        <form method="POST" enctype="multipart/form-data" name="uploadBagit" id="uploadBagit">
        
        <div class="row mt-3 mb-3">
            <div class="col-md-12">
                <label for="fileToUpload"></label>
                <input type="file" name="fileToUpload" id="fileToUpload" accept="application/zip, application/gzip">
              </div>
          </div>
  
          <div class="row mb-3">
            <div class="col-md-12">
              <?php if(isset($alert)) { ?>
                <div class='alert alert-warning mt-3'><?php echo $alert ?></div>
              <?php } ?>
              <?php if(isset($success)) { ?>
                <div class='alert alert-success mt-3'><?php echo $success ?></div>
              <?php } ?>
            </div>
          </div>
  
          <div class="row">
            <div class="col-md-12 text-right"><input name="submitUploadedBagit" type="submit" value="Carica BAGIT" id="submitUploadedBagit"></div>
          </div>
        </form>
  
      </div>
  
  
      <div class="container">
  
        <h2>Genera Bagit</h2>

        <div class="row">
          <div class="col-md-12">
            <?php if(isset($alertGenerate)) { ?>
              <div class='alert alert-warning mt-3'><?php echo $alertGenerate ?></div>
            <?php } ?>
            <?php if(isset($successGenerate)) { ?>
              <div id="successGenerate" class='alert alert-success mt-3 d-none'><?php echo $successGenerate ?></div>
            <?php } ?> 
          </div>
        </div>
        
        <form method="POST" enctype="multipart/form-data" name="formBagit" id="formBagit">
          <div class="row">
            <div class="col-md-6">
              <label for="titolo">Titolo</label>
              <input name="titolo" type="text">
            </div>
            <div class="col-md-6">
              <label for="descrizione">Descrizione</label>
              <input name="descrizione" type="text">
            </div>
          </div>
  
          <div class="row">
            <div class="col-md-6">
              <label for="editore">Editore</label>
              <input name="editore" type="text">
            </div>
            <div class="col-md-6">
              <label for="lingua">Lingua ISO 639-2</label>
              <input name="lingua" type="text">
            </div>
          </div>
  
          <div class="row">
            <div class="col-md-6">
              <label for="soggetti">Soggetti o keywords (separati da virgola)</label>
              <input name="soggetti" type="text">
            </div>
            <div class="col-md-6">
              <label for="licenza">Licenza</label>
              <select name="licenza" style="width: 100%;">
                  <option value=""></option>
                  <option value="open access">Open Access</option>
                  <option value="closed access">Closed Access</option>
                </select>
            </div>
          </div>
  
          <div class="row">
            <div class="col-md-6">
              <label for="data">Data di pubblicazione</label>
              <input name="data" type="date">
            </div>
            <div class="col-md-6"></div>
          </div>
  
          <div class="row">
            <div class="col-md-12">
              <h6>Creatori</h6>
            </div>
          </div>
          <div id="dynamic_field_creator">
            <div class="row" id="row0">
              <div class="col-md-2">
                <label for="selectCreator">Tipo</label>
                <select name="selectCreator[]">
                  <option value="author">Author</option>
                  <option value="translator">Translator</option>
                  <option value="contributor">Contributor</option>
                </select>
              </div>
              <div class="col-md-8">
                <label for="nameCreator">Nome e cognome</label>
                <input type="text" name="nameCreator[]" style="width=100%">
              </div>
              <div class="col-md-2 text-right">
                <button type="button" name="deleteCreator" id="0" class="btn_remove btn-danger mt-5">Rimuovi</button>
              </div>
            </div>
          </div>
  
          <div class="row mb-5 mt-5">
            <div class="col-md-12 text-right">
              <button type="button" name="addCreator" id="addCreator">Aggiungi</button>
            </div>
          </div>
  
  
          <div class="row">
            <div class="col-md-12">
              <h6>Identificativi</h6>
            </div>
          </div>
          <div id="dynamic_field_identifiers">
            <div class="row" id="row0">
              <div class="col-md-2">
                <label for="selectIdentifiers">Tipo</label>
                <select name="selectIdentifiers[]">
                  <option value="url">URL</option>
                  <option value="isbn">ISBN</option>
                  <option value="issn">ISSN</option>
                  <option value="doi">DOI</option>
                  <option value="altro">Altro</option>
                </select>
              </div>
              <div class="col-md-8">
                <label for="nameIdentifiers">ID</label>
                <input type="text" name="nameIdentifiers[]" style="width=100%">
              </div>
              <div class="col-md-2 text-right">
                <button type="button" name="deleteIdentifiers" id="0" class="btn_remove_identifiers btn-danger mt-5">Rimuovi</button>
              </div>
            </div>
          </div>
  
          <div class="row mb-5 mt-5">
            <div class="col-md-12 text-right">
              <button type="button" name="addIdentifiers" id="addIdentifiers">Aggiungi</button>
            </div>
          </div>
  
          <div class="row mt-3 mb-3">
            <div class="col-md-12">
                <label for="fileToUpload"></label>
                <input type="file" name="fileToUpload" id="fileToUpload" accept="application/pdf,application/epub+zip">
              </div>
          </div>
  
          <div class="row">
            <div class="col-md-12">
              <input name="checkExrtaction" type="hidden" value="0">
              <input name="checkExrtaction" type="checkbox" value="1">
              <label for="checkExrtaction">Acconsento all'estrazione del testo per l'indicizzazione e la ricerca full-text</label>
            </div>
          </div>
  
          <div class="row">
            <div class="col-md-12 text-right">
              <input name="submitBagit" type="hidden" value="1">
              <button id="submitBagit">CREA BAGIT</button>
            </div>
            <div class="text-center">
              <div id="spinner" class="lds-dual-ring" style="display: none"></div>
            </div>
          </div>
  
        </form>
  
      </div>
  </section>
  
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  
  <script>
    $ = jQuery;
    $(document).ready(function(){
  
      var i = 1;
  
      $("#addCreator").click(function(){
        i++;
        $('#dynamic_field_creator').append('<div class="row" id="row'+i+'"><div class="col-md-2"><label for="selectCreator">Tipo</label><select name="selectCreator[]"><option value="author">Author</option><option value="translator">Translator</option><option value="contributor">Contributor</option>7</select></div><div class="col-md-8"><label for="nameCreator">Nome e cognome</label><input type="text" name="nameCreator[]" style="width=100%"></div><div class="col-md-2 text-right"><button type="button" name="deleteCreator" id="'+i+'" class="btn_remove btn-danger mt-5">Rimuovi</button></div></div>');  
      });
  
      $(document).on('click', '.btn_remove', function(){  
        var button_id = $(this).attr("id");   
        $('#row'+button_id+'').remove();  
      });    
  
      var i = 1;
  
      $("#addIdentifiers").click(function(){
        i++;
        $('#dynamic_field_identifiers').append('<div class="row" id="row'+i+'"> <div class="col-md-2"> <label for="selectIdentifiers">Tipo</label> <select name="selectIdentifiers[]"> <option value="url">URL</option> <option value="isbn">ISBN</option> <option value="issn">ISSN</option> <option value="doi">DOI</option> <option value="altro">Altro</option> </select> </div><div class="col-md-8"> <label for="nameIdentifiers">ID</label> <input type="text" name="nameIdentifiers[]" style="width=100%"> </div><div class="col-md-2 text-right"> <button type="button" name="deleteIdentifiers" id="'+i+'" class="btn_remove_identifiers btn-danger mt-5">Rimuovi</button> </div></div>');
      });
  
      $(document).on('click', '.btn_remove_identifiers', function(){  
        var button_id = $(this).attr("id");   
        $('#row'+button_id+'').remove();  
      });
  
      document.getElementById('formBagit').addEventListener('submit', function() {
  		
        setTimeout(function() {
          //window.location.href = 'http://localhost/local/area-riservata/istituzione/upload-bagit';
          //window.location.href = 'http://md-collaudo.depositolegale.it/area-riservata/istituzione/upload-bagit';
  		  window.location.reload();
        }, 3000);
      })
  
    });
  
  </script>
  
  <style>
    .lds-dual-ring {
      display: inline-block;
      width: 80px;
      height: 80px;
    }
    .lds-dual-ring:after {
      content: " ";
      display: block;
      width: 64px;
      height: 64px;
      margin: 8px;
      border-radius: 50%;
      border: 6px solid #fff;
      border-color: #fff transparent #fff transparent;
      animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
  </style>
  
<?php
  }
    get_footer();
?>