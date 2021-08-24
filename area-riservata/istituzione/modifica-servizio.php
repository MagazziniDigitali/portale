<?php
include_once("../src/Htpasswd.php");
include_once("../src/debug.php");

// 23/08/2021  Argentino
function modificaServizio($dbHarvest, $dbNBN, $uuidIstituzione, $loginIstituzione, $servizio, $nomeServizio = null) // $dbMD, , $nomeIstituzione
{
  global $WH_LOG_INFO;

  switch($servizio)
  {
    case "td":
      $descServizio = "tesi di dottorato";
      break;
    case "ej":
      $descServizio = "e-journal";
      break;
    case "eb":
      $descServizio = "e-book";
      break;
    default:
      $descServizio = "Servizio sconosciuto";
      break;
  };


  if (isset($_POST["nomeDatasource_$servizio"]))
    $nomeDatasource = $_POST["nomeDatasource_$servizio"];
  if (isset($_POST["url_$servizio"]))
    $url = $_POST["url_$servizio"];

  if ($servizio != "eb")
  {
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
  }
  
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

  // Prendiamo i dati dell'agent prima delle modifiche
  // per gestire basic authentication di apache
  $agent = retrieve_agent_nbn($dbNBN, $idSubNamespace, $idDatasource);
  if (!$agent) { // Signal some error
    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Agent mancante. Aggiornamento fallito per servizio $servizio</div>";
    return;
  }
  $updateDatasource   = update_datasource_nbn_test($dbNBN, $nomeDatasource, $url, $idSubNamespace, $idDatasource); // $loginIstituzione, $nomeIstituzione, 
  if (!$updateDatasource && check_db_error($dbNBN)) { // Signal some error
    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Aggiornamento datasouurce fallito per servizio $descServizio.</div>";
    return;
  }
  $updateAgent      = update_agent_nbn($dbNBN, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, $servizio, $idSubNamespace, $idDatasource); // , $loginIstituzione, $nomeIstituzione
  if (!$updateAgent && check_db_error($dbNBN)) { // Signal some error
    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Aggiornamento agent fallito per servizio $descServizio.</div>";
    return;
  }
  if ($servizio != 'eb')
  {
    $updateHarvest  = update_anagrafe_harvest($dbHarvest, $uuidIstituzione, $loginIstituzione, $nomeDatasource, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $url, $servizio, $idDatasource); // , $nomeIstituzione
    if (!$updateHarvest && check_db_error($dbHarvest)) { // Signal some error
      echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Aggiornamento anagrafe harvest fallito per servizio $descServizio.</div>";
      return;
    }
  }

  // 20/08/21
  // Aggiorniamo la password per la basic authnetication in caso sia stata modificata
  if ($agent) {
    $old_user = $agent[0]->user;
    $old_pwd = $agent[0]->pass;

    $htpasswd = new Htpasswd('../passwd/.htpasswd_nbn');
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

  echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Modifica andata a buon fine per servizio $descServizio.</div>";
  // $alertTesi = "Aggiornamento andato a buon fine";
  // echo "<script>window.location.href = '/area-riservata//istituzione/signup-services'</script>";
} // End modifica_servizio


