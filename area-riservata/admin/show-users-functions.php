<?php

function removeUser($dbMD)
{
  //delete_user();
  if(isset($_POST['uuid'])){
    $uuid = $_POST['uuid'];
  }
  if (isset($_POST['idIstituzione'])) {
    $idIstituzione = $_POST['idIstituzione'];
  }
  $encryptedUUID = encrypt_string($uuid);
  delete_user($dbMD, $encryptedUUID, $idIstituzione);
  echo "<script>window.location.href = '/area-riservata/'</script>";
} // end removeUser()

function updateUser($dbMD)
{
  if(isset($_POST['pwd'])){
    $pwd = $_POST['pwd'];
  }
  if(isset($_POST['cognome'])){
    $cognome = $_POST['cognome'];
  }
  if(isset($_POST['nome'])){
    $nome = $_POST['nome'];
  }
  if(isset($_POST['codiceFiscale'])){
    $codiceFiscale = $_POST['codiceFiscale'];
  }
  if(isset($_POST['email'])){
    $email = $_POST['email'];
  }
  if(isset($_POST['ipAutorizzati']) && isset($_POST['ipAutorizzati']) != ''){
    $ipAutorizzati = $_POST['ipAutorizzati'];
  } else {
    $ipAutorizzati = '*.*.*.*';
  }
  if(isset($_POST['uuid'])){
    $uuid = $_POST['uuid'];
  }
  if (isset($_POST['gestoreIstituzione'])) {
    $gestoreIstituzione = $_POST['gestoreIstituzione'];
  }
  if (isset($_POST['idIstituzione'])) {
    $idIstituzione = $_POST['idIstituzione'];
  }
  if ($_POST['password'] == '') {
    $encryptedUUID = encrypt_string($uuid);
    $update = update_user($dbMD, $encryptedUUID, $pwd, $cognome, $nome, $codiceFiscale, $email, $ipAutorizzati);
    if ($gestoreIstituzione == 1){
      echo '<script>
        cnf = confirm("Questa operazione renderà questo utente gestore di istituzione, togliendolo all\'attuale gestore. Vuoi continuare?");
        if (cnf) {window.location.href = "/area-riservata/changed-role?n=' . $encryptedUUID . '&i=' . $idIstituzione . '" }
      </script>';
    }
    echo "<script>window.location.href = '/area-riservata/'</script>";
  } elseif (isset($_POST['password']) && $_POST['password'] != ''){
    $password = $_POST['password'];
    $check = check_strong_password($password);
    if($check != 1){
      $alert = $check;
    } else {
      $password = generate_sha_pwd($dbMD, $password);
      if ($pwd != $password){
        $pwd = $password;
        $encryptedUUID = encrypt_string($uuid);
        $update = update_user($dbMD, $encryptedUUID, $pwd, $cognome, $nome, $codiceFiscale, $email, $ipAutorizzati);
        if ($gestoreIstituzione == 1){
          echo '<script>
            cnf = confirm("Questa operazione renderà questo utente gestore di istituzione, togliendolo all\'attuale gestore. Vuoi continuare?");
            if (cnf) {window.location.href = "/area-riservata/changed-role?n=' . $encryptedUUID . '&i=' . $idIstituzione . '" }
          </script>';
        }
        echo "<script>window.location.href = '/area-riservata/'</script>";
      } else {
        $alert = "La password non può essere uguale a quella già esistente";
      }
    }
  }

} // End updateUser()

function addUser($dbMD) 
{
  $newUserLogin = $_POST['newUserLogin'];
  $newUserPassword = $_POST['newUserPassword'];
  $check = check_strong_password($newUserPassword);
  if($check != 1){
     $error = $check;
  } 
  else {
    if(isset($_POST['newUserNome']) && $_POST['newUserNome'] != '') {
        $newUserNome = $_POST['newUserNome'];
    }
    if(isset($_POST['newUserCognome']) && $_POST['newUserCognome'] != '') {
        $newUserCognome = $_POST['newUserCognome'];
    }
    if(isset($_POST['newUserCodiceFiscale']) && $_POST['newUserCodiceFiscale'] != '') {
        $newUserCodiceFiscale = $_POST['newUserCodiceFiscale'];
    }
    if(isset($_POST['newUserEmail']) && $_POST['newUserEmail'] != '') {
        $newUserEmail = $_POST['newUserEmail'];
    }
    if(isset($_POST['newUserIpAutorizzati']) && $_POST['newUserIpAutorizzati'] != '') {
        $newUserIpAutorizzati = $_POST['newUserIpAutorizzati'];
    } else {
        $newUserIpAutorizzati = '*.*.*.*';
    }
    if(isset($_POST['id_Ist_modalNewUser'])) {
        $idIstituzione = $_POST['id_Ist_modalNewUser'];
    }
    $uuid               = generate_uuid($dbMD);
    $uuid               = $uuid . '-F';
    $admin              = 0;
    $superadmin         = 0;
    $newUser = insert_new_user($dbMD, $uuid, $newUserLogin, $newUserPassword, $newUserCognome, $newUserNome, $newUserCodiceFiscale, $newUserEmail, $admin, $superadmin, $newUserIpAutorizzati, $idIstituzione);
    if(!$newUser){
        $error = insert_new_user_check_errors($dbMD);
    } else {
        $encryptedUuid = encrypt_string($uuid);
        send_confirmation_email_to_user($newUserCognome, $newUserNome, $newUserEmail, $encryptedUuid, $newUserLogin, $newUserPassword);
        echo "<script>window.location.href = '/area-riservata/admin/'</script>";
    }
  } // end else
} // End addUser()

function inserisciServizio($dbMD, $dbNBN, $dbHarvest)
{
  if (isset($_POST['nomeDatasource']))
    $nomeDatasource = $_POST['nomeDatasource'];
  if (isset($_POST['url']))
    $url = $_POST['url'];
  if (isset($_POST['contatti']))
    $contatti = $_POST['contatti'];
  if (isset($_POST['format']))
    $format = $_POST['format'];
  if (isset($_POST['set']))
    $set = $_POST['set'];
  if (isset($_POST['userEmbargo']))
    $userEmbargo = $_POST['userEmbargo'];
  if (isset($_POST['pwdEmbargo']))
    $pwdEmbargo = $_POST['pwdEmbargo'];
  if (isset($_POST['userNBN']))
    $userNBN = $_POST['userNBN'];
  if (isset($_POST['pwdNBN']))
    $pwdNBN = $_POST['pwdNBN'];
  if (isset($_POST['ipNBN']) && $_POST['ipNBN'] != '') 
    $ipNBN = $_POST['ipNBN'];
  if (isset($_POST['id_Ist']))
    $idIst = $_POST['id_Ist'];
  if (isset($_POST['harvest_name']))
    $loginIstLogin = $_POST['harvest_name'];
  if (isset($_POST['selectType'])) 
    $servizioAbilitato = $_POST['selectType'];
  if (isset($_POST['id_Ist_modal'])) 
    $uuidIstituzione = $_POST['id_Ist_modal'];
  if (isset($_POST['Ist_name_modal'])) 
    $nomeIstituzione = $_POST['Ist_name_modal'];
  if (isset($_POST['Ist_login_modal']))
    $loginIstituzione = $_POST['Ist_login_modal'];


  $tesiServizioAttivo ='';
  if($servizioAbilitato=='td'){
    $tesiServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $uuidIstituzione, 'td');
  }else if($servizioAbilitato=='ej'){
    $tesiServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $uuidIstituzione, 'ej');
  }else if($servizioAbilitato=='eb'){
    $tesiServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $uuidIstituzione, 'eb');
  }
 
  //INSERT INTO MD
  if (empty($tesiServizioAttivo)) {
    $insertServizio     = insert_into_md_servizi($dbMD, $uuidIstituzione, $servizioAbilitato);
  }
  //INSERT INTO NBN
  $checkSubnamespace      = check_istituzione_exist_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
  if($checkSubnamespace == 0){
    $insertSubnamespace     = insert_into_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
  }
  $subnamespaceID         = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
  $checkDatasource        = check_datasource_into_nbn($dbNBN, $nomeDatasource, $url);
  if($checkDatasource == 0){
    $insertDatasource     = insert_into_nbn_datasource($dbNBN, $nomeDatasource, $url, $subnamespaceID, $servizioAbilitato);
  } else {
    $alertTesi = 'Nome datasource e url datasource già presenti';
  }
  $idDatasource           = retrieve_id_datasource_for_istituzione($dbNBN, $nomeDatasource, $subnamespaceID, $url);
  $insertAgent            = insert_into_nbn_agent($dbNBN, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, $idDatasource, $subnamespaceID, $servizioAbilitato);

  //INSERT INTO HARVEST
  $insertAnagrafe         = insert_into_harvest_anagrafe($dbHarvest, $uuidIstituzione, $idDatasource, $loginIstituzione, $url, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $servizioAbilitato);
  if ($insertAnagrafe == 1) {
    $journalUserApiNBN    = '';
    $journalPwdApiNBN     = '';
    $bookUserApiNBN       = '';
    $bookPwdApiNBN        = '';
    send_notice_nbn_email_to_admin($dbMD, $userNBN, $pwdNBN, $journalUserApiNBN, $journalPwdApiNBN, $bookUserApiNBN, $bookPwdApiNBN);
    echo "<script>window.location.href = '/area-riservata/admin/'</script>";
   // echo "<script>window.location.href = 'http://md-collaudo.depositolegale.it/area-riservata/istituzione/signup-services'</script>";
  }
} // End inserisciServizio


  
