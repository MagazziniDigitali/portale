<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<?php
require("../src/debug.php");

$g_loginIstituzione="";
$g_nomeIstituzione="";
$g_idIstituzione="";


// function insert_servizio_TD($row, $dbNBN, $dbMD, $dbHarvest)
function insert_servizio($row, $dbNBN, $dbMD, $dbHarvest, $servizioAbilitato)
{
  global $g_loginIstituzione, $g_nomeIstituzione, $g_idIstituzione;

    $num_campi	     = $row[1];
    $nomeDatasource  = $row[2];
    $url             = $row[3];
    $contatti        = $row[4];
    $format          = $row[5];
    $set             = $row[6];
    $userEmbargo     = null; //$row[7];
    $pwdEmbargo      = null; //$row[8];
    $userNBN         = $row[9];
    $pwdNBN          = $row[10];
    // $servizioAbilitato='td';
    $ipNBN            = '*.*.*.*';
    global $WH_LOG_INFO;
 
    // return ("Inserimento servizio fallito");
    wh_log($WH_LOG_INFO, "g_loginIstituzione = $g_loginIstituzione");
    $subnamespaceID  = retrieve_id_subnamespace_for_istituzione($dbNBN, $g_loginIstituzione); 
    wh_log($WH_LOG_INFO, "subnamespaceID = $subnamespaceID");
    if(empty($subnamespaceID))
    {
      // echo "subnamespaceID non presente in NBN. Inserisco il subnamespace (Istituto)";
      $insertSubnamespace     = insert_into_nbn_subnamespace($dbNBN, $g_loginIstituzione, $g_nomeIstituzione);
      if ($insertSubnamespace != 1)
          // return "errore nell'inserimento del subnamespace $g_loginIstituzione";
          // return "-->".$insertSubnamespace;
          $error = check_db_error($dbNBN);
          if (strpos($error, "Duplicate entry") === false )
            return "2->".$error; //"Non posso inserire dtasource '$nomeDatasource'";
  
    }

    $idDatasource = retrieve_id_datasource_for_istituzione($dbNBN, $subnamespaceID, $url);
    if(empty($idDatasource))
    {
      // echo "Datasource non esiste, dobbiamo aggiungere ad Istituto un nuovo datasource";
      $insertDatasource     = insert_into_nbn_datasource($dbNBN, $nomeDatasource, $url, $subnamespaceID, $servizioAbilitato);
      if ($insertDatasource != 1)
        {
        $error = check_db_error($dbNBN);
        if (strpos($error, "Duplicate entry") === false )
          return "3->".$error; //"Non posso inserire dtasource '$nomeDatasource'";
        }
      $idDatasource = retrieve_id_datasource_for_istituzione($dbNBN, $subnamespaceID, $url);
      }

    $idAgent = retrieve_id_agent_nbn($dbNBN, $subnamespaceID, $idDatasource);
    if(empty($idAgent))
    {
      $insertAgent  = insert_into_nbn_agent($dbNBN, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, 
                  $idDatasource, $subnamespaceID, $servizioAbilitato);
      if ($insertAgent != 1)
      {
        $error = check_db_error($dbNBN);
        if (strpos($error, "Duplicate entry") === false ){
          
          return "4->insert_into_nbn_agent ".$error  . "$nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, $idDatasource, $subnamespaceID, $servizioAbilitato"; 
        }    
      }
    }


      //INSERT service INTO MD services 
      $insertServizio     = insert_into_md_servizi($dbMD, $g_idIstituzione, $servizioAbilitato);
      if ($insertServizio != 1)
      {
        $error = check_db_error($dbMD);
        if (strpos($error, "Duplicate entry") === false ){
          // return "Non posso inserire il servizio servizioAbilitato nella tabella dei servizi";
          return "5->".$error;
        }    
      }

      //INSERT service INTO HARVEST
      $insertAnagrafe         = insert_into_harvest_anagrafe($dbHarvest, $g_idIstituzione, $idDatasource, $g_loginIstituzione, 
                        $url, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $servizioAbilitato);
      if ($insertAnagrafe != 1)
        {
        $error = check_db_error($dbHarvest);
        if (strpos($error, "Duplicate entry") === false ){
          // return "Non posso inserire il record per il servizio in harvest.anagrafe ";
          return "6->".$error;
        }    
        }
  return "";
} // end insert_servizio


function insert_istituzione($row, $dbMD)
{
  global $g_loginIstituzione, $g_nomeIstituzione, $g_idIstituzione;

  $num_campi       = $row[1];
  $g_nomeIstituzione = $nome            = $row[2];
  $indirizzo       = $row[3];
  $tel             = $row[4];
  $nomeContatto    = $row[5];
  $url             = $row[6];
  $piva            = $row[7];
  $regione         = $row[8];
  $g_loginIstituzione = $nomeLogin       = $row[9];
  $password        = $row[10];
  $preRegUtenteCognome= $row[11];
  $preRegUtenteNome= $row[12];
  $UtenteCodicefiscale=$row[13];
  $UtenteEmail     =$row[14];


    //  break; //hassan
  // $checkLogin = check_login_istituzione($dbMD, $nome);
  // if(empty($checkLogin)){
// return "Inserimento Istituto $nomeLogin fallito";

  $g_idIstituzione = retrieve_id_istituzione($dbMD, $nomeLogin);
  if(empty($g_idIstituzione)){

      $uuidIstituzione            = generate_uuid($dbMD);
      $uuidUtente                 = generate_uuid($dbMD) . '-F';
      $admin                      = 1;
      $superadmin                 = 0;
      $preRegAltaRisoluzione      = 0;
      $preRegTesiDottorato        = 0;
      $ipAutorizzati              = '*.*.*.*';
      $g_idIstituzione              =$uuidIstituzione;

      $insertIstituzione = insert_new_istituzione($dbMD, $uuidIstituzione, $nomeLogin, $password, $nome, 
                              $indirizzo, $tel, $nomeContatto, "", $url, $regione, $piva, $preRegAltaRisoluzione);
      if ($insertIstituzione != 1)
          return insert_new_istituzione_check_errors($dbMD);

      $insertIstituzioneImport = insert_into_md_MDIstituzioneImport($dbMD,$uuidIstituzione,$uuidUtente);
      if ($insertIstituzioneImport != 1)
        return check_db_error($dbMD);

      $insertGestoreIstituzione = insert_new_gestore_istituzione($dbMD, $uuidUtente, $nomeLogin, $password, $preRegUtenteCognome, $preRegUtenteNome, $admin, $uuidIstituzione, $UtenteCodicefiscale, $UtenteEmail, $superadmin, $ipAutorizzati);
      if ($insertGestoreIstituzione != 1)
          return insert_new_gestore_istituzione_check_errors($dbMD);

      $uuidSoftware = generate_uuid($dbMD);
      $insertSoftware = insert_new_software($dbMD, $uuidSoftware, $uuidIstituzione, $nomeLogin, $password, $nome);

      if ($insertSoftware != 1)
        return check_db_error($dbMD);

      $insertSoftwareConfig = insert_new_software_config($dbMD, $uuidSoftware, $password, $piva);
      if ($insertSoftwareConfig < 1)
        return check_db_error($dbMD);
  } // end if(empty($checkLogin))
  return "";
} // End insert_istituzione

?>


<?php
   include("../../wp-load.php");
   require("../src/functions.php");
   define ('SITE_ROOT', realpath(dirname(__FILE__)));

  //  global $WH_LOG_ERROR;

         if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

   redirect_if_not_logged_in();
   
      
   if($_SESSION['role'] == 'superadmin'){

      $dbMD       = connect_to_md();
      $dbNBN      = connect_to_nbn();
      $dbHarvest  = connect_to_harvest();



if ( isset($_POST["ApprovaUser"]) ) {
        if(isset($_POST['argument']))
      {
 $_iduser=$_POST['argument'];

 set_approve_to_true_import($dbMD,$_iduser);
       }
     }


      if ( isset($_POST["SendMailToUser"]) ) {
       if(isset($_POST['argument']))
     {
$_iduser=$_POST['argument'];
    $_user = retrieve_user_by_id($dbMD,$_iduser );
    $_uuid                = $_user[0]->ID;
    $_login               = $_user[0]->LOGIN;
    $_pwd                 = $_user[0]->PASSWORD;
    $_cognome             = $_user[0]->COGNOME;
    $_nome                = $_user[0]->NOME;
    $_email               = $_user[0]->EMAIL;
    set_email_to_true_import($dbMD,$_uuid);
        $_encryptedUuid = encrypt_string($_uuid);
        send_confirmation_email_to_user($_cognome, $_nome, $_email, $_encryptedUuid, $_login, $_pwd);
      }
    }

      if ( isset($_POST["UpladFile"]) ) {

        if ( isset($_FILES["file"])) {

                 //if there was an error uploading the file
             if ($_FILES["file"]["error"] > 0) {
               //  echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
              // echo "<div class='p-3 mb-2 bg-danger text-white'> No file selected </div> <br />";
            echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>No file selected.</div>";
            }
             else {
                if (!file_exists(SITE_ROOT."/upload/")) {
                    mkdir(SITE_ROOT."/upload/", 0777, true);
                  }
     
                      //if file already exists
                  if (file_exists(SITE_ROOT."/upload/" . $_FILES["file"]["name"])) {
                //  echo "<div class='p-3 mb-2 bg-danger text-white'>".$_FILES["file"]["name"] . " already exists. </div> ";
                    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>".$_FILES["file"]["name"] . " already exists.</div>";
                    wh_log($WH_LOG_ERROR, $_FILES["file"]["name"] . " already exists.");
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
                    
                    $istituzione_failed="";
                    $almeno_un_servizio_in_errore="";
                    while (($raw_string = fgets($handle)) !== false) {
                            if ($lineNumber > 1 ) 
                            {  
                                // Parse the raw csv string: "1, a, b, c"
                                $row = str_getcsv($raw_string,"|");
                                $tipo       	 = $row[0];
                                switch ( $tipo ) {
                                  case "ISTITUZIONE":
                                    $istituzione_failed = insert_istituzione($row, $dbMD );
                                    break;
                                  case "SERVIZIO_TD":
                                    $servizio_failed = insert_servizio($row, $dbNBN, $dbMD, $dbHarvest, 'td' );
                                    if ($servizio_failed)
                                      {
                                      wh_log($WH_LOG_ERROR, "Failed to insert: ". $servizio_failed ." - " .$raw_string);  
                                      $almeno_un_servizio_in_errore = 1;
                                      }
                                    break;
                                  case "SERVIZIO_EJ":
                                    $servizio_failed = insert_servizio($row, $dbNBN, $dbMD, $dbHarvest, 'ej' );
                                    if ($servizio_failed)
                                    {
                                      wh_log($WH_LOG_ERROR, "Failed to insert: ". $servizio_failed ." - ".$raw_string);  
                                      $almeno_un_servizio_in_errore = 1;
                                    }
                                    break;
                                    case "SERVIZIO_EB":
                                      $servizio_failed = insert_servizio($row, $dbNBN, $dbMD, $dbHarvest, 'eb' );
                                      if ($servizio_failed)
                                      {
                                        wh_log($WH_LOG_ERROR, "Failed to insert: ". $servizio_failed ." - ".$raw_string);  
                                        $almeno_un_servizio_in_errore = 1;
                                      }
                                        break;
                                    default:
                                      break;

                            } // End switch $tipo
                        if (!empty($istituzione_failed))
                          break; // exit wihle
                        } // end if ($lineNumber > 1 ) 
                        $lineNumber++;

                    } // end while
                    
                    fclose($handle);

                    if (!empty($istituzione_failed))
                      echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Fallito l'insertimento dell'Istituzione: " . $istituzione_failed .".</div>";
                    else if (!empty($almeno_un_servizio_in_errore))
                      echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Fallito inserimento di almeno uno dei servizi (vedere import.log).</div>";
                    else 
                      echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>The file has been inserted successfully.</div>";
                  }
                 }
             }
          } else {
                  // echo "<div class='p-3 mb-2 bg-danger text-white'> No file selected </div> <br />";
                  echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>No file selected.</div>";
                  
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
$(".utente-mail").click(function(e){
        console.log(this);
        console.log(this.id);
        jQuery.ajax({
    type: "POST",
    url: 'import.php',
    dataType: 'json',
    data: {SendMailToUser: 'SendMailToUser', argument: this.id},

});
    }); 
    $(".utente-approva").click(function(e){
        console.log(this);
        console.log(this.id);
        jQuery.ajax({
    type: "POST",
    url: 'import.php',
    dataType: 'json',
    data: {ApprovaUser: 'ApprovaUser', argument: this.id},

});
    }); 
</script>