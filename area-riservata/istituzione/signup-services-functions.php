<?php
include_once("../src/Htpasswd.php");
include_once("../src/debug.php");
include_once("../admin/show-users-functions.php");

// 23/08/2021  Argentino
//Modificato il 29/11/2021 almaviva3
//modificaServizio($dbHarvest, $dbNBN, $id_istituzione, 'eb');

function modificaServizio($dbHarvest, $dbNBN, $uuidIstituzione, $servizio) // $dbMD, , $nomeIstituzione
{
  global $WH_LOG_INFO;
  $errorString = "";
  $updateNBN = false;
  if (isset($_POST["nomeDatasource_$servizio"]))
    $nomeDatasource = $_POST["nomeDatasource_$servizio"];
  if (isset($_POST["url_$servizio"]))
    $url = $_POST["url_$servizio"];
    if (isset($_POST["gestoreIstituzioneUser"]))
    $loginIstituzione = $_POST["gestoreIstituzioneUser"];
    if (isset($_POST["idServizio"]))
    $idServizio = $_POST["idServizio"];

    if (isset($_POST["contatti_$servizio"]))
      $contatti = $_POST["contatti_$servizio"];
    if (isset($_POST["format_$servizio"]))
      $format = $_POST["format_$servizio"];
    if (isset($_POST["set_$servizio"]))
      $set = $_POST["set_$servizio"];
    if (isset($_POST["userEmbargo_$servizio"]))
      $userEmbargo = $_POST["userEmbargo_$servizio"];
    if (isset($_POST["pwdEmbargo_$servizio"]))
      $pwdEmbargo = $_POST["pwdEmbargo_$servizio"];
  
  if (isset($_POST["userNBN_$servizio"]))
    $userNBN = $_POST["userNBN_$servizio"];
  if (isset($_POST["pwdNBN_$servizio"]))
    $pwdNBN = $_POST["pwdNBN_$servizio"];
  if (isset($_POST["ipNBN_$servizio"]))
    $ipNBN = $_POST["ipNBN_$servizio"];
  if (isset($_POST["idSubNamespace_$servizio"]))
    $idSubNamespace = $_POST["idSubNamespace_$servizio"];
  if (isset($_POST["idDatasource_$servizio"]))
    $idDatasource = $_POST["idDatasource_$servizio"];

    switch($servizio) {
      case "nbn":
        $descServizio = " National Bibliography Number";
        $updateNBN = true;
        $agent = retrieve_agent_nbn($dbNBN, $idSubNamespace, $idDatasource);

        $updateResult  = update_servizi_nbn($dbNBN, $nomeDatasource, $userNBN, $pwdNBN, $ipNBN, $url, $idSubNamespace, $idDatasource,  $idServizio);
        break;

      case "td":
        $datasource = $loginIstituzione;
        $descServizio = "tesi di dottorato";
        $updateResult  = update_servizi_harvest($dbHarvest, $uuidIstituzione, $datasource, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $url, $servizio, $idServizio); // , $nomeIstituzione
        break;
      case "ej":
        $descServizio = "e-journal";
        
        $datasource = str_replace($loginIstituzione.'.', $loginIstituzione.'.', $nomeDatasource); ;
        $updateResult  = update_servizi_harvest($dbHarvest, $uuidIstituzione, $datasource, $contatti, $format, $set, "", "", $url, $servizio, $idServizio); // , $nomeIstituzione
        break;
      case "eb":
        $descServizio = "e-book";
        $updateResult  = update_servizi_harvest($dbHarvest, $uuidIstituzione, $nomeDatasource, $contatti,"", "", "", "", $url, $servizio, $idServizio);
        break;
      default:
        $descServizio = "Servizio sconosciuto";
        $errorString =  $descServizio . ". ". "Errore interno ";
        break;
    };
    if (!$updateResult) {
      $errorString = "Aggiornamento anagrafe harvest fallito per servizio ". $descServizio;
      wh_log($WH_LOG_INFO, "Errore Aggiornamento abagrafe harvest: ".$updateResult);

    }

    
    //GestioneErrori
    if ($errorString != "") { // Signal some error
      echo "<div class='alert alert-danger alert-dismissible margin-top-15'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>". $errorString ."</div>";
      return;
    } else {
      echo "<div class='alert alert-success alert-dismissible margin-top-15'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Modifica andata a buon fine per servizio $descServizio.</div>";
    }
 
  // 20/08/21
  // Aggiorniamo la password per la basic authnetication in caso sia stata modificata
  if ($updateNBN) {
    $old_user = $agent[0]->user;
    $old_pwd = $agent[0]->pass;

    // $htpasswd = new Htpasswd('../passwd/.htpasswd_nbn');
    $htpasswd = new Htpasswd('../passwd/md_passwd_basic_auth');
    if ($old_user != $userNBN) { // change of user and pwd
      // Delete old user
      $ret = $htpasswd->deleteUser($old_user);
      wh_log($WH_LOG_INFO, "NBN apache managed basic authentication - Deleted user $old_user ret='$ret'");

      // Add new user
      $ret = $htpasswd->addUser($userNBN, $pwdNBN);
      wh_log($WH_LOG_INFO, "NBN apache managed basic authentication - Added user $userNBN:$pwdNBN,  ret='$ret'");
    } else if ($old_pwd != $pwdNBN) { // change password of old user
      // update old user
      $ret = $htpasswd->updateUser($userNBN, $pwdNBN);
      wh_log($WH_LOG_INFO, "Updated user $userNBN:$pwdNBN, ret='$ret'");
    }
    // else NO CHANGE in user PWD
  } // End if agent

  // $alertTesi = "Aggiornamento andato a buon fine";
  // echo "<script>window.location.href = '/area-riservata//istituzione/signup-services'</script>";
} // End modifica_servizio



// 26/08/2021  Argentino
// Questo f7unziona solo in locale dove ho applicato il CASCADE sulla delete
function rimuoviServizio($dbNBN, $dbHarvest, $uuidIstituzione, $servizio) // $dbMD, , $nomeIstituzione $uuidIstituzione, $loginIstituzione,  , $nomeServizio = null
{
  global $WH_LOG_INFO;
  $errorString = "";
  $updateNBN = false;
 if (isset($_POST["userNBN_$servizio"]))
   $userNBN = $_POST["userNBN_$servizio"];
  if (isset($_POST["idSubNamespace_$servizio"]))
    $idSubNamespace = $_POST["idSubNamespace_$servizio"];
  if (isset($_POST["nomeDatasource_$servizio"]))
    $nomeDatasource = $_POST["nomeDatasource_$servizio"];
  if (isset($_POST["idDatasource_$servizio"]))
    $idDatasource = $_POST["idDatasource_$servizio"];  
  if (isset($_POST["idServizio"]))
    $idServizio = $_POST["idServizio"];

  switch($servizio) {
    case "nbn":
      $descServizio = " National Bibliography Number";
      $updateNBN = true;
      $agent = retrieve_agent_nbn($dbNBN, $idSubNamespace, $idDatasource);
      $deleteResult = delete_servizi_nbn($dbNBN, $uuidIstituzione, $idServizio);
      rimuoviServizioNBNPerServiziNonPresenti($deleteResult, $uuidIstituzione, $servizio);
      break;

    case "td":
      $descServizio = "tesi di dottorato";
      $deleteResult = delete_servizi_harvest($dbHarvest, $uuidIstituzione, $idServizio);
      rimuoviServizioHarvestPerServiziNonPresenti($deleteResult, $dbHarvest, $uuidIstituzione, $servizio);
      break;
    case "ej":
      $descServizio = "e-journal";
      $deleteResult = delete_servizi_harvest($dbHarvest, $uuidIstituzione, $idServizio);
      rimuoviServizioHarvestPerServiziNonPresenti($deleteResult, $dbHarvest, $uuidIstituzione, $servizio);
      break;
    case "eb":
      $descServizio = "e-book";
      $deleteResult = delete_servizi_harvest($dbHarvest, $uuidIstituzione, $idServizio);
      rimuoviServizioHarvestPerServiziNonPresenti($deleteResult, $dbHarvest, $uuidIstituzione, $servizio);
      break;
    default:
      $descServizio = "Servizio sconosciuto";
      $errorString =  $descServizio . ". ". "Errore interno ";
      break;
  };
  if (!$deleteResult) {
    $errorString = "Cancellazione fallita per il servizio ". $descServizio . " di '" . $nomeDatasource ."'" ;
  } 
  if($updateNBN) {
    
  $htpasswd = new Htpasswd('../passwd/md_passwd_basic_auth');
  $ret = $htpasswd->deleteUser($userNBN);
  wh_log($WH_LOG_INFO, "NBN apache managed basic authentication - Deleted user $userNBN ret='$ret'");
  

  wh_log($WH_LOG_INFO, "Rimuovi servizio  '$nomeDatasource' con idDatasource $idDatasource");
  }
  if ($errorString != "") { // Signal some error
    echo "<div class='alert alert-danger alert-dismissible  margin-top-15'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>". $errorString ."</div>";
    return;
  } else {
    echo "<div class='alert alert-success alert-dismissible  margin-top-15'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Cancellazione andata a buon fine per servizio $descServizio di '$nomeDatasource' .</div>";
  }
} // End rimuoviServizio
function iscriviServizioToIstituzione($dbMD, $dbNBN, $dbHarvest) {
  inserisciServizio($dbMD, $dbNBN, $dbHarvest, false);
}
function rimuoviServizioHarvestPerServiziNonPresenti($deleteResult, $dbHarvest, $idIst, $servizio) {
    if($deleteResult) {
    //Controllo su MDServizi
    $serviziPresenti = select_anagrafe_harvest($dbHarvest, $idIst, $servizio);
    if(empty($serviziPresenti)) {
      //Delete su MDServizi
      delete_servizio_md($idIst, $servizio);
    }
  }
}
function rimuoviServizioNBNPerServiziNonPresenti($deleteResult, $idIst, $servizio) {
  if($deleteResult) {
    $dbMD           = connect_to_md();
    $dbNBN          = connect_to_nbn();
  //Controllo su MDServizi
  $loginIstNameNbn = retrieve_id_login_for_istituzione($dbMD, $idIst);
  $subNspaceID = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstNameNbn);
  $dtsourcesID = retrieve_ids_datasources($dbNBN, $subNspaceID, 'nbn');
  $serviziPresenti = []; 
  foreach ($dtsourcesID as $key => $ds){
    $id = $ds->datasourceID;
    $nbnResult = retrieve_agent_nbn($dbNBN, $subNspaceID, $id);
      foreach ($nbnResult as $obj){
        $obj->id_istituzione = $idIst;
        $serviziPresenti[] = $obj;
    }

  }
  if(empty($serviziPresenti)) {
    //Delete su MDServizi
    delete_servizio_md($idIst, $servizio);
  }
}
}