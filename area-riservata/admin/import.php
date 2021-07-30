<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
.container-tb {
  padding: 2rem 0rem;
}

h4 {
  margin: 2rem 0rem 1rem;
}

.table-image td, .table-image th {
  vertical-align: middle;
}
</style>
<?php
   include("../../wp-load.php");
   require("../src/functions.php");
   define ('SITE_ROOT', realpath(dirname(__FILE__)));

         if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

   redirect_if_not_logged_in();
   
   if($_SESSION['role'] == 'superadmin'){

      $dbMD       = connect_to_md();
      $dbNBN      = connect_to_nbn();
      $dbHarvest  = connect_to_harvest();


      if ( isset($_POST["UpladFile"]) ) {

        if ( isset($_FILES["file"])) {

                 //if there was an error uploading the file
             if ($_FILES["file"]["error"] > 0) {
               //  echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
               echo "<div class='p-3 mb-2 bg-danger text-white'> No file selected </div> <br />";
             }
             else {
                if (!file_exists(SITE_ROOT."/upload/")) {
                    mkdir(SITE_ROOT."/upload/", 0777, true);
                  }
     
                      //if file already exists
                  if (file_exists(SITE_ROOT."/upload/" . $_FILES["file"]["name"])) {
                 echo "<div class='p-3 mb-2 bg-danger text-white'>".$_FILES["file"]["name"] . " already exists. </div> ";
                  }
                  else {
                         //Store file in directory "upload" with the name of "uploaded_file.txt"
                 $storagename = SITE_ROOT."/upload/" . $_FILES["file"]["name"];
                 move_uploaded_file($_FILES["file"]["tmp_name"], $storagename);
                 if ( isset($storagename) && $file = fopen(   $storagename , "r" ) ) {
                    $handle = fopen($storagename, "r");
                    // Optionally, you can keep the number of the line where
                    // the loop its currently iterating over
                    $lineNumber = 1;
                    $lineInsert=1;
                    $idIstituzione   ="";
                    $loginIstituzione ="";
                    $nomeIstituzione  ="";
                    
                    
                      
                    while (($raw_string = fgets($handle)) !== false) {
                            if ($lineNumber > 1 ) 
                            {  
                            
                                // Parse the raw csv string: "1, a, b, c"
                                $row = str_getcsv($raw_string,"|");
        
                                $tipo       	 = $row[0];
                                switch ( $tipo ) {
                                    case "ISTITUZIONE":
                                        $num_campi	     = $row[1];
                                        $nome   	       = $row[2];
                                        $indirizzo       = $row[3];
                                        $tel             = $row[4];
                                        $nomeContatto    = $row[5];
                                        $url             = $row[6];
                                        $piva            = $row[7];
                                        $regione         = $row[8];
                                        $nomeLogin       = $row[9];
                                        $password        = $row[10];
                                        $preRegUtenteCognome= $row[11];
                                        $preRegUtenteNome= $row[12];
                                        $UtenteCodicefiscale=$row[13];
                                         $UtenteEmail     =$row[14];

                                          //  break; //hassan
                                        $checkLogin = check_login_istituzione($dbMD, $nome);
                
                                        if(empty($checkLogin)){
                                
                                            $uuidIstituzione            = generate_uuid($dbMD);
                                            $uuidUtente                 = generate_uuid($dbMD);
                                            $admin                      = 1;
                                            $superadmin                 = 0;
                                            $preRegAltaRisoluzione      = 0;
                                            $preRegTesiDottorato        = 0;
                                            $ipAutorizzati              = '*.*.*.*';
                                            $idIstituzione              =$uuidIstituzione;
                                            $loginIstituzione           =$nomeLogin;
                                            $nomeIstituzione            =$nome;
                                
                                            $insertIstituzione = insert_new_istituzione($dbMD, $uuidIstituzione, $nomeLogin, $password, $nome, $indirizzo, $tel, $nomeContatto, "", $url, $regione, $piva, $preRegAltaRisoluzione);
                                
                                            if ($insertIstituzione != 1){
                                
                                                $errorIstituzione = insert_new_istituzione_check_errors($dbMD);
                                
                                            } else {
                                
                                                $insertIstituzioneImport = insert_into_md_MDIstituzioneImport($dbMD,$uuidIstituzione,$uuidUtente);
                                                $insertGestoreIstituzione = insert_new_gestore_istituzione($dbMD, $uuidUtente, $nomeLogin, $password, $preRegUtenteCognome, $preRegUtenteNome, $admin, $uuidIstituzione, $UtenteCodicefiscale, $UtenteEmail, $superadmin, $ipAutorizzati);
                                
                                                if ($insertGestoreIstituzione != 1){
                                
                                                    $errorUtente = insert_new_gestore_istituzione_check_errors($dbMD);
                                
                                                } else {
                                
                                                    $uuidSoftware = generate_uuid($dbMD);
                                
                                                    $insertSoftware = insert_new_software($dbMD, $uuidSoftware, $uuidIstituzione, $nomeLogin, $password, $nome);
                                
                                
                                                    if ($insertGestoreIstituzione == 1){
                                
                                                        $insertSoftwareConfig = insert_new_software_config($dbMD, $uuidSoftware, $password, $piva);
                                
                                                    }
                                
                                                }
                                
                                                
                                            }
                                
                                    }
                                      break;
                                    case "UTENTE":
                                        $num_campi	     = $row[1];
                                        $nomeUser   	   = $row[2];
                                        $conomeUser      = $row[3];
                                        $userEmail       = $row[4];
                                        $userLogin       = $row[5];
                                        $userPassword    = $row[6];
                                        $userCodiceFiscale = $row[7];
                                        $regione         = $row[8];
                                      // break; //hassan
                                        $uuid               = generate_uuid($dbMD);
                                        $uuid               = $uuid . '-F';
                                        $admin              = 0;
                                        $superadmin         = 0;
                                        $userIpAutorizzati  = '*.*.*.*';
                                        $newUser = insert_new_user($dbMD, $uuid, $userLogin, $userPassword, $conomeUser, $nomeUser, $userCodiceFiscale, $userEmail, $admin, $superadmin, $userIpAutorizzati, $idIstituzione);
                                        $insertIstituzioneImport = insert_into_md_MDIstituzioneImport($dbMD,$idIstituzione,$uuid);
                                        break;
                                    case "ISCRITTO_SERVIZIO_NBN":
                                    case "ISCRITTO_SERVIZIO_TD":
                                    case "ISCRITTO_SERVIZIO_EJ":
                                    case "ISCRITTO_SERVIZIO_EB":
                                      break;
                                     case "SERVIZIO_NBN":
                                     break;
                                     case "SERVIZIO_TD":
                                        $num_campi	     = $row[1];
                                        $nomeDatasource  = $row[2];
                                        $url             = $row[3];
                                        $contatti        = $row[4];
                                        $format          = $row[5];
                                        $set             = $row[6];
                                        $userEmbargo     = $row[7];
                                        $pwdEmbargo      = $row[8];
                                        $userNBN         = $row[9];
                                        $pwdNBN          = $row[10];
                                        $servizioAbilitato='td';
                                        $ipNBN            = '*.*.*.*';
                                        // break;//hassan
                                   //INSERT INTO MD
                                   $insertServizio     = insert_into_md_servizi($dbMD, $idIstituzione, $servizioAbilitato);
                                   $insertSubnamespace     = insert_into_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
                                 $subnamespaceID         = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
                                   $insertDatasource     = insert_into_nbn_datasource($dbNBN, $nomeDatasource, $url, $subnamespaceID, $servizioAbilitato);
                                 $idDatasource           = retrieve_id_datasource_for_istituzione($dbNBN, $nomeDatasource, $subnamespaceID, $url);
                                 $insertAgent            = insert_into_nbn_agent($dbNBN, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, $idDatasource, $subnamespaceID, $servizioAbilitato);
                                 //INSERT INTO HARVEST
                                 $insertAnagrafe         = insert_into_harvest_anagrafe($dbHarvest, $idIstituzione, $idDatasource, $loginIstituzione, $url, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $servizioAbilitato);
                                      break;
                                     case "SERVIZIO_EJ":
                                        $num_campi	     = $row[1];
                                        $nomeDatasource  = $row[2];
                                        $url             = $row[3];
                                        $contatti        = $row[4];
                                        $format          = $row[5];
                                        $set             = $row[6];
                                        $userEmbargo     = $row[7];
                                        $pwdEmbargo      = $row[8];
                                        $userNBN         = $row[9];
                                        $pwdNBN          = $row[10];
                                        $servizioAbilitato='ej';
                                        $ipNBN            = '*.*.*.*';
                                        break;//hassan
                                   //INSERT INTO MD
                                   $insertServizio     = insert_into_md_servizi($dbMD, $idIstituzione, $servizioAbilitato);
                                   $insertSubnamespace     = insert_into_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
                                 $subnamespaceID         = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
                                   $insertDatasource     = insert_into_nbn_datasource($dbNBN, $nomeDatasource, $url, $subnamespaceID, $servizioAbilitato);
                                 $idDatasource           = retrieve_id_datasource_for_istituzione($dbNBN, $nomeDatasource, $subnamespaceID, $url);
                                 $insertAgent            = insert_into_nbn_agent($dbNBN, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, $idDatasource, $subnamespaceID, $servizioAbilitato);
                                 //INSERT INTO HARVEST
                                 $insertAnagrafe         = insert_into_harvest_anagrafe($dbHarvest, $idIstituzione, $idDatasource, $loginIstituzione, $url, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $servizioAbilitato);
                                      break;

                                     case "SERVIZIO_EB":
                                        $num_campi	     = $row[1];
                                        $nomeDatasource  = $row[2];
                                        $url             = $row[3];
                                        $contatti        = $row[4];
                                        $format          = $row[5];
                                        $set             = $row[6];
                                        $userEmbargo     = $row[7];
                                        $pwdEmbargo      = $row[8];
                                        $userNBN         = $row[9];
                                        $pwdNBN          = $row[10];
                                        $servizioAbilitato='eb';
                                        $ipNBN            = '*.*.*.*';
                                        break; //hassan
                                   //INSERT INTO MD
                                   $insertServizio     = insert_into_md_servizi($dbMD, $idIstituzione, $servizioAbilitato);
                                   $insertSubnamespace     = insert_into_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
                                 $subnamespaceID         = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
                                   $insertDatasource     = insert_into_nbn_datasource($dbNBN, $nomeDatasource, $url, $subnamespaceID, $servizioAbilitato);
                                 $idDatasource           = retrieve_id_datasource_for_istituzione($dbNBN, $nomeDatasource, $subnamespaceID, $url);
                                 $insertAgent            = insert_into_nbn_agent($dbNBN, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, $idDatasource, $subnamespaceID, $servizioAbilitato);
                                 //INSERT INTO HARVEST
                                 $insertAnagrafe         = insert_into_harvest_anagrafe($dbHarvest, $idIstituzione, $idDatasource, $loginIstituzione, $url, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $servizioAbilitato);
                                      break;
                                          default:
                                          break;

        }
                           
    }
                        $lineNumber++;
                    }
                    
                    fclose($handle);
                    echo "<div class='p-3 mb-2 bg-success text-white'>The file has been inserted successfully </div> <br />";
                 }
                 }
             }
          } else {
                  echo "<div class='p-3 mb-2 bg-danger text-white'> No file selected </div> <br />";
          }
     }
      

}
      
      get_header();
      

   ?>
<header class="entry-header has-text-align-center header-footer-group" style="background: white;">

	
<div class="entry-header-inner section-inner medium">

  <h1 class="entry-title">Import Istituzioni</h1>
</div><!-- .entry-header-inner -->

</header>
   <section>
      <div class="container">
         <p>Benvenuto <strong><?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?></strong></p>




         <form action="" method="post" enctype="multipart/form-data">
            Seleziona un file* da caricare:
            <input type="file" accept=".csv" name="file" id="file">
            <input type="submit" value="Carica File" name="UpladFile">
        </form>

        <h6>
         * i file da importare devono essere in formato csv.
        </h6>
      </div>
      <div class="container">
         <div id="showAllUser">
            <h5>Lista Istituzioni Importate:
            <div id="buttons" style="display: none;">
            <button type="button" class="btn btn-outline-secondary"  onclick="" disabled >
                   <i class="icon-remove icon-2x" title="cancella Istituto"></i>
                  </button>  
                  <button type="button" class="btn btn-outline-secondary"  onclick="" disabled >
                   <i class="icon-list icon-2x" title="approva Istituto"></i>
                  </button> 
                  <button type="button" class="btn btn-outline-secondary"  onclick="" disabled >
                   <i class="icon-envelope-alt icon-2x" title="invia mail al risponsabile dell'istituto"></i>
                  </button> 
                  </div>
            </h5>

            <?php 
            $isImport=1; include("show-users.php"); ?>
         </div>
      </div>
   </section>

      
<?php 

    get_footer(); 
?>

<script>
$(".form-check-input").change(function(){

  if($('input:checked').length>0)
  {
    $("#buttons").show();
  }else
  {
      $("#buttons").hide();
      }
});
</script>