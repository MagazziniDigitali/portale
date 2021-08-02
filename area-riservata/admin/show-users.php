<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function PreOpenModal(idIstituzione, loginIstLogin, loginIstName) {
  document.getElementById("InsertIstForm").reset();
  $(".modal-body #id_Ist_modal").val( idIstituzione );
// var idIstituzioneHtml = document.getElementById('id_Ist_modal');
// idIstituzioneHtml.value = idIstituzione;
$(".modal-body #Ist_login_modal").val( loginIstLogin );
// var loginIstLoginHtml = document.getElementById('Ist_login_modal');
// loginIstLoginHtml.value = loginIstLogin;
$(".modal-body #Ist_name_modal").val( loginIstName );
//  var loginIstNameHtml = document.getElementById('Ist_name_modal');
//  loginIstNameHtml.value = loginIstName;
}
function PreOpeninsertUserModal(idIstituzione) {
  document.getElementById("InsertUserForm").reset();
  $(".modal-body #id_Ist_modalNewUser").val( idIstituzione );
}
</script>
<?php
if(isset($isImport)&&$isImport==1){
$uniqueIdIst = $dbMD->get_results("SELECT ID_ISTITUZIONE FROM MDUtenti WHERE SUPERADMIN <> 1 AND SUPERADMIN <> 2 and ID_ISTITUZIONE in (SELECT `ID_Istituto` FROM   `MDIstituzioneImport` where `Inviato`=0 and `Approvato`=0  GROUP BY `ID_Istituto`) GROUP BY ID_ISTITUZIONE");
}else{ 
  $uniqueIdIst = $dbMD->get_results("SELECT ID_ISTITUZIONE FROM MDUtenti WHERE SUPERADMIN <> 1 AND SUPERADMIN <> 2 and ID_ISTITUZIONE not in (SELECT `ID_Istituto` FROM   `MDIstituzioneImport` where `Inviato`=0 and `Approvato`=0  GROUP BY `ID_Istituto`) GROUP BY ID_ISTITUZIONE"); 
//  $uniqueIdIst = $dbMD->get_results("SELECT ID_ISTITUZIONE FROM MDUtenti WHERE SUPERADMIN <> 1 AND SUPERADMIN <> 2 GROUP BY ID_ISTITUZIONE");
}
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['removeUser'])) {

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

    } elseif (isset($_POST['updateUser'])) {

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
    }
 
    if (isset($_POST['modificaTesi'])){

      if (isset($_POST['nomeDatasource'])){
        $nomeDatasource = $_POST['nomeDatasource'];
      }
      if (isset($_POST['url'])){
        $url = $_POST['url'];
      }
      if (isset($_POST['contatti'])){
        $contatti = $_POST['contatti'];
      }
      if (isset($_POST['format'])){
        $format = $_POST['format'];
      }
      if (isset($_POST['set'])){
        $set = $_POST['set'];
      }
      if (isset($_POST['userEmbargo'])){
        $userEmbargo = $_POST['userEmbargo'];
      }
      if (isset($_POST['pwdEmbargo'])){
        $pwdEmbargo = $_POST['pwdEmbargo'];
      }
      if (isset($_POST['userNBN'])){
        $userNBN = $_POST['userNBN'];
      }
      if (isset($_POST['pwdNBN'])){
        $pwdNBN = $_POST['pwdNBN'];
      }
      if (isset($_POST['ipNBN'])){
        $ipNBN = $_POST['ipNBN'];
      }
      if (isset($_POST['idSubNamespace'])){
        $idSubNamespace = $_POST['idSubNamespace'];
      }
      if (isset($_POST['idDatasource'])){
        $idDatasource = $_POST['idDatasource'];
      }
      if (isset($_POST['id_Ist'])){
        $idIst = $_POST['id_Ist'];
      }
      if (isset($_POST['harvest_name'])){
        $loginIstLogin = $_POST['harvest_name'];
      }
      $updateDatasource   = update_datasource_nbn_mod($dbNBN, $nomeDatasource, $url, $idSubNamespace, $idDatasource);
  
      if ($updateDatasource == 1) {
  
        $updateAgent      = update_agent_nbn_mod($dbNBN, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, 'td', $idSubNamespace, $idDatasource);
  
        if ($updateAgent  == 1){
  
          $updateHarvest  = update_anagrafe_harvest_mod($dbHarvest, $idIst, $loginIstLogin, $nomeDatasource, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $url, 'td', $idDatasource);
          
          if ($updateHarvest == 1){
  
            echo "<script>window.location.href = '/area-riservata/admin/'</script>";
           // echo "<script>window.location.href = 'http://md-collaudo.depositolegale.it/area-riservata/istituzione/signup-services'</script>";
  
          }
  
        }
  
      }
  
    }
  
    if (isset($_POST['modificaJournal'])){
  
      if (isset($_POST['nomeDatasource'])){
        $nomeDatasource = $_POST['nomeDatasource'];
      }
      if (isset($_POST['url'])){
        $url = $_POST['url'];
      }
      if (isset($_POST['contatti'])){
        $contatti = $_POST['contatti'];
      }
      if (isset($_POST['format'])){
        $format = $_POST['format'];
      }
      if (isset($_POST['set'])){
        $set = $_POST['set'];
      }
      if (isset($_POST['userEmbargo'])){
        $userEmbargo = $_POST['userEmbargo'];
      }
      if (isset($_POST['pwdEmbargo'])){
        $pwdEmbargo = $_POST['pwdEmbargo'];
      }
      if (isset($_POST['userNBN'])){
        $userNBN = $_POST['userNBN'];
      }
      if (isset($_POST['pwdNBN'])){
        $pwdNBN = $_POST['pwdNBN'];
      }
      if (isset($_POST['ipNBN'])){
        $ipNBN = $_POST['ipNBN'];
      }
      if (isset($_POST['idSubNamespace'])){
        $idSubNamespace = $_POST['idSubNamespace'];
      }
      if (isset($_POST['idDatasource'])){
        $idDatasource = $_POST['idDatasource'];
      }
      if (isset($_POST['id_Ist'])){
        $idIst = $_POST['id_Ist'];
      }
      if (isset($_POST['harvest_name'])){
        $loginIstLogin = $_POST['harvest_name'];
      }
  
      $updateDatasource   = update_datasource_nbn_mod($dbNBN, $nomeDatasource, $url, $idSubNamespace, $idDatasource);
  
      if ($updateDatasource == 1) {
  
        $updateAgent      = update_agent_nbn_mod($dbNBN, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, 'ej', $idSubNamespace, $idDatasource);
  
        if ($updateAgent == 1){
  
          $updateHarvest  = update_anagrafe_harvest_mod($dbHarvest, $idIst, $loginIstLogin, $nomeDatasource, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $url, 'ej', $idDatasource);
          
          if ($updateHarvest == 1){
  
            echo "<script>window.location.href = '/area-riservata/admin/'</script>";
           // echo "<script>window.location.href = 'http://md-collaudo.depositolegale.it/area-riservata/istituzione/signup-services'</script>";
  
          }
  
        }
  
      }
  
    }
  
    if (isset($_POST['modificaBook'])){
  
      if (isset($_POST['nomeDatasourceBook'])){
        $nomeDatasourceBook = $_POST['nomeDatasourceBook'];
      }
      if (isset($_POST['urlBook'])){
        $urlBook = $_POST['urlBook'];
      }
      if (isset($_POST['userNBNBook'])){
        $userNBNBook = $_POST['userNBNBook'];
      }
      if (isset($_POST['pwdNBNBook'])){
        $pwdNBNBook = $_POST['pwdNBNBook'];
      }
      if (isset($_POST['ipNBNBook'])){
        $ipNBNBook = $_POST['ipNBNBook'];
      }
      if (isset($_POST['idSubNamespaceBook'])){
        $idSubNamespaceBook = $_POST['idSubNamespaceBook'];
      }
      if (isset($_POST['idDatasourceBook'])){
        $idDatasourceBook = $_POST['idDatasourceBook'];
      }
  
      $checkNameDatasource = check_nbn_datasourceName_exists_modify($dbNBN, $nomeDatasourceBook, $idDatasourceBook);
  
      if ($checkNameDatasource == 0) {
  
        $updateDatasource   = update_datasource_nbn_mod($dbNBN, $nomeDatasourceBook, $urlBook, $idSubNamespaceBook, $idDatasourceBook);
  
        if ($updateDatasource == 1) {
  
          $updateAgent      = update_agent_nbn_mod($dbNBN, $nomeDatasourceBook, $urlBook, $userNBNBook, $pwdNBNBook, $ipNBNBook, 'eb', $idSubNamespaceBook, $idDatasourceBook);
  
          if ($updateAgent == 1){
  
            echo "<script>window.location.href = '/area-riservata/admin/'</script>";
          //  echo "<script>window.location.href = 'http://md-collaudo.depositolegale.it/area-riservata/istituzione/signup-services'</script>";
  
          }
  
        }
  
      } else {
  
        $alertBookModify = 'Nome Datasource già in uso';
        
      }
  
    }




    if (isset($_POST['inseriscinewUserLoginModal'])){

    if(isset($_POST['newUserLogin'])) {
      $newUserLogin = $_POST['newUserLogin'];
  }
  if(isset($_POST['newUserPassword']) && $_POST['newUserPassword'] != '') {

      $newUserPassword = $_POST['newUserPassword'];
      $check = check_strong_password($newUserPassword);

      if($check != 1){

         $error = $check;

      } else {
          
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
      }

  }
}


   
    if (isset($_POST['inserisciServizio'])){

      if (isset($_POST['nomeDatasource'])){
        $nomeDatasource = $_POST['nomeDatasource'];
      }
      if (isset($_POST['url'])){
        $url = $_POST['url'];
      }
      if (isset($_POST['contatti'])){
        $contatti = $_POST['contatti'];
      }
      if (isset($_POST['format'])){
        $format = $_POST['format'];
      }
      if (isset($_POST['set'])){
        $set = $_POST['set'];
      }
      if (isset($_POST['userEmbargo'])){
        $userEmbargo = $_POST['userEmbargo'];
      }
      if (isset($_POST['pwdEmbargo'])){
        $pwdEmbargo = $_POST['pwdEmbargo'];
      }
      if (isset($_POST['userNBN'])){
        $userNBN = $_POST['userNBN'];
      }
      if (isset($_POST['pwdNBN'])){
        $pwdNBN = $_POST['pwdNBN'];
      }
      if (isset($_POST['ipNBN']) && $_POST['ipNBN'] != '') {
        $ipNBN = $_POST['ipNBN'];
      }
      if (isset($_POST['id_Ist'])){
        $idIst = $_POST['id_Ist'];
      }
      if (isset($_POST['harvest_name'])){
        $loginIstLogin = $_POST['harvest_name'];
      }
      if (isset($_POST['selectType'])) {
        $servizioAbilitato = $_POST['selectType'];
      }
  
      if (isset($_POST['id_Ist_modal'])) {
        $uuidIstituzione = $_POST['id_Ist_modal'];
      }
  
      if (isset($_POST['Ist_name_modal'])) {
        $nomeIstituzione = $_POST['Ist_name_modal'];
      }
  
      if (isset($_POST['Ist_login_modal'])) {
        $loginIstituzione = $_POST['Ist_login_modal'];
      }
  

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
  
    }
    
  }   

  foreach($uniqueIdIst as $key=>$results) {

    $idIst = $results->ID_ISTITUZIONE;

    $loginIst = retrieve_login_istituzione($dbMD, $idIst);
    $tesiServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $idIst, 'td');
    $journalServizioAttivo  = check_if_istituzione_signed_for_service($dbMD, $idIst, 'ej');
    $bookServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $idIst, 'eb');
  if(!empty($loginIst)){
  
    $loginIstLogin = $loginIst[0]->LOGIN;
    $loginIstName = $loginIst[0]->NOME;

    

  
    if (!empty($tesiServizioAttivo)) {

      $subnamespaceID = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstLogin, $loginIstName);
      $idDatasource   = retrieve_id_datasource($dbNBN, $subnamespaceID, 'td');
      if($idDatasource){
      $tesiAll        = select_agent_ngn_and_anagrafe_harvest($dbNBN, $dbHarvest, 'td', $subnamespaceID, $idDatasource);
      }
    }


  if (!empty($journalServizioAttivo)) {

    $subnamespaceID = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstLogin, $loginIstName);
    $idDatasource   = retrieve_id_datasource($dbNBN, $subnamespaceID, 'ej');

    if($idDatasource){
      $journalAll   = select_agent_ngn_and_anagrafe_harvest($dbNBN, $dbHarvest, 'ej', $subnamespaceID, $idDatasource);
      }
    
  }

  if (!empty($bookServizioAttivo)) {

    $subnamespaceID = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstLogin, $loginIstName);
    $idDatasource   = retrieve_id_datasource($dbNBN, $subnamespaceID, 'eb');

    if($idDatasource){
      $bookAll      = select_agent_ngn($dbNBN, 'eb', $subnamespaceID);
      }
    
  }

  


    $users = retrieve_user_by_id_istituzione($dbMD, $idIst);
}
    ?>

    <div class="card">
      <div class="card-header" id="heading<?php echo $key ?>">     
      <?php if(isset($isImport)&&$isImport==1){?>
      <input class="form-check-input" type="checkbox" value="" id="<?php echo $idIst ?>">
      <?php } ?>
        <button class="btn" data-toggle="collapse" data-target="#collapse_ist<?php echo $key ?>" aria-expanded="false" aria-controls="collapse_ist<?php echo $key ?>">
          <?php if ($loginIstLogin == 'istituzioneBase'){ ?>
              <h5 class="m-0">Utenti non appartenenti a un'istituzione</h5>
          <?php } else { ?>
              <h5 class="m-0"><?php echo $loginIstName ?></h5>
          <?php } ?>
        </button> 
        <?php
if(isset($isImport)&&$isImport==1){?>
               <button type="button" id="<?php echo $idIst ?>" class="btn btn-outline-secondary"   disabled >
                   <i class="icon-remove icon-2x" title="cancella Istituto"></i>
                  </button>  
                  <button type="button" id="<?php echo $idIst ?>" class="btn btn-outline-secondary" disabled>
                   <i class="icon-list icon-2x" title="approva Istituto"></i>
                  </button> 
                  <button type="button" id="<?php echo $idIst ?>" class="btn btn-outline-secondary"  disabled>
                   <i class="icon-envelope-alt icon-2x" title="invia mail al risponsabile dell'istituto"></i>
                  </button> 
                  <?php } ?>
      </div>

      <div id="collapse_ist<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">
          <div class="card-body">

          <h4>Utenti:
          <?php if(!isset($isImport)){ ?>
  <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#insertUserModal" onclick="PreOpeninsertUserModal('<?php echo $idIst ?>')" >
  <i class="icon-plus icon-2x" title="Aggiungi un nuovo Utente"></i>
</button> 
<?php } ?>
</h4>
            <?php foreach($users as $key=>$resultsU) {

              $uuid                = $resultsU->ID;
              $login               = $resultsU->LOGIN;
              $pwd                 = $resultsU->PASSWORD;
              $cognome             = $resultsU->COGNOME;
              $nome                = $resultsU->NOME;
              $idIstituzione       = $resultsU->ID_ISTITUZIONE;
              $admin               = $resultsU->AMMINISTRATORE;
              $codiceFiscale       = $resultsU->CODICEFISCALE;
              $email               = $resultsU->EMAIL;
              $superadmin          = $resultsU->SUPERADMIN;
              $ipAutorizzati       = $resultsU->IP_AUTORIZZATI;

              ?>



            <div class="card">            
            <div class="card-header" id="heading<?php echo $key ?>">
                
              <button class="btn" data-toggle="collapse" data-target="#collapse_utente<?php echo $key ?>" aria-expanded="false" aria-controls="collapse_utente<?php echo $key ?>">
                <h5 class="m-0">   <?php if ($admin == 1) { ?>
                  <h5 class="mt-0">Gestore d'istituzione: <?php echo $login ?></h5>
              <?php } else { ?>
                  <h5 class="mt-0"><?php echo $login ?></h5>
              <?php } ?></h5>
              </button>
              <?php if(isset($isImport)&&$isImport==1){?>
              <button type="button" class="btn btn-outline-secondary utente-cancella" id="<?php echo $uuid ?>" disabled >
                   <i class="icon-remove icon-2x " title="cancella Utente"></i>
                  </button>  
                  <button type="button" class="btn btn-outline-secondary utente-approva"  id="<?php echo $uuid ?>" >
                   <i class="icon-list icon-2x" title="approva Utente"></i>
                  </button> 
                  <button type="button" class="btn btn-outline-secondary utente-mail"  id="<?php echo $uuid ?>" >
                   <i class="icon-envelope-alt icon-2x" title="invia mail all'utente"></i>
                  </button> 
                  <?php } ?>
            </div>

            <div id="collapse_utente<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">
              <div class="card-body">
              <form action="" method="POST" class="mb-4">

                <input type="hidden" name="uuid" value="<?php echo $uuid ?>">
                <input type="hidden" name="pwd" value="<?php echo $pwd ?>">
                <input type="hidden" name="idIstituzione" value="<?php echo $idIstituzione ?>">

                <div class="row">
                  <div class="col-md-6">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" value="<?php echo $nome ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="cognome">Cognome</label>
                    <input type="text" name="cognome" value="<?php echo $cognome ?>">
                  </div>
                </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="email">Email</label>
                      <input type="text" name="email" value="<?php echo $email ?>">
                    </div>
                    <div class="col-md-6">
                      <label for="codiceFiscale">Codice Fiscale</label>
                      <input type="text" name="codiceFiscale" value="<?php echo $codiceFiscale ?>">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <label for="password">Password</label>
                      <input type="password" name="password" id="password" placeholder="Inserisci una nuova password">
                      <?php if(isset($alert)) { ?>
                        <div class='alert alert-warning mt-3'><?php echo $alert ?></div>
                      <?php } ?>
                    </div>

                      <?php if ($admin == 0) { ?>
                        <div class="col-md-6">
                          <label for="ipAutorizzati">IP Autorizzati</label>
                          <input type="text" name="ipAutorizzati" value="<?php echo $ipAutorizzati ?>">
                        </div>
                      <?php } else { ?>
                          <div class="col-md-6"></div>
                      <?php } ?>
                  </div>
                  
                  <?php if ($loginIstLogin != 'istituzioneBase' && $admin == 0) { ?>
                  <div class="row">
                    <div class="col-md-6">
                      <input type="hidden" name="gestoreIstituzione" value="0">
                      <input name="gestoreIstituzione" id="gestoreIstituzione" type="checkbox" value="1">
                      <label for="gestoreIstituzione">Rendi gestore dell'istituzione</label>
                    </div>
                    <div class="col-md-6"></div>
                  </div>
                  <?php } ?>

                  <div class="row">
                    <div class="col-md-12 text-right">
                      <?php if ($admin == 0) { ?>
                        <input name="removeUser" type="submit" value="Rimuovi utente" class="mt-3 btnRejectSub mr-3"/>
                      <?php } ?>
                      <input name="updateUser" type="submit" value="Modifica utente" class="mt-3 btnAcceptSub mr-3"/>
                    </div>
                  </div>

              </form>
              </div>
            </div>
          </div>











            <?php } ?>


  <h4>Servizi:
  <?php if(!isset($isImport)){ ?>
  <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#insertIstModal" onclick="PreOpenModal('<?php echo $idIst ?>', '<?php echo $loginIstLogin ?>', '<?php echo $loginIstName ?>')" >
  <i class="icon-plus icon-2x" title="Aggiungi un nuovo servizio"></i>
</button> 
<?php } ?>
</h4>

   <?php if (!empty($tesiServizioAttivo)) { ?>
      <div id="infotesi">

        <h5>Tesi di Dottorato </h5>

        <?php foreach($tesiAll as $key=>$results) {
          $nomeDatasource     = $results->agent_name;
          $url                = $results->baseurl;
          $contatti           = $results->harvest_contact;
          $format             = $results->harvest_format;
          $set                = $results->harvest_set;
          $userEmbargo        = $results->harvest_userEmbargo;
          $pwdEmbargo         = $results->harvest_pwdEmbargo;
          $userNBN            = $results->user;
          $pwdNBN             = $results->pass;
          $ipNBN              = $results->IP;
          $idSubNamespace     = $results->subNamespaceID;
          $idDatasource       = $results->datasourceID;
          $id_Ist             = $results->id_istituzione;
          $harvest_name       = $results->harvest_name;
        ?>
              
          <div class="card">            
            <div class="card-header" id="heading<?php echo $key ?>">
                
              <button class="btn" data-toggle="collapse" data-target="#collapse_tesi<?php echo $key ?>" aria-expanded="false" aria-controls="collapse_tesi<?php echo $key ?>">
                <h5 class="m-0"><?php echo $nomeDatasource ?></h5>
              </button>
                
            </div>

            <div id="collapse_tesi<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">
              <div class="card-body">
                <form action="" method="post">
                <input type="hidden" name="idSubNamespace" value="<?php echo $idSubNamespace ?>">
                <input type="hidden" name="idDatasource" value="<?php echo $idDatasource ?>">
                <input type="hidden" name="id_Ist" value="<?php echo $id_Ist ?>">
                <input type="hidden" name="harvest_name" value="<?php echo $harvest_name ?>">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="nomeDatasource">Nome Datasource</label>
                      <input name="nomeDatasource" value="<?php echo $nomeDatasource ?>" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="url">URL sito OAI</label>
                      <input name="url" value="<?php echo $url ?>" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="contatti">Contatti</label>
                      <input name="contatti" value="<?php echo $contatti ?>" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="format">Format dei metadati</label>
                      <input name="format" value="<?php echo $format ?>" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="set">Set dei metadati</label>
                      <input name="set" value="<?php echo $set ?>" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="userEmbargo">Utenza per accesso embargo</label>
                      <input name="userEmbargo" value="<?php echo $userEmbargo ?>" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="pwdEmbargo">Password per accesso embargo</label>
                      <input name="pwdEmbargo" value="<?php echo $pwdEmbargo ?>" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="userNBN">User per API NBN</label>
                      <input name="userNBN" value="<?php echo $userNBN ?>" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="pwdNBN">Password per API NBN</label>
                      <input name="pwdNBN" value="<?php echo $pwdNBN ?>" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="ipNBN">IP per API NBN</label>
                      <input name="ipNBN" value="<?php echo $ipNBN ?>" type="text">
                    </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12"><input type="submit" name="modificaTesi" value="Modifica" class="mt-3 float-right"></div> 
                  </div>
                </form>
              </div>
            </div>
          </div>

        <?php } ?>
      </div>
    <?php } ?>

    <?php if (!empty($journalServizioAttivo)) { ?>
      <div id="infoJournal">

        <h5>e-Journal </h5>

        <?php foreach($journalAll as $key=>$results) {

          $nomeDatasource     = $results->agent_name;
          $url                = $results->baseurl;
          $contatti           = $results->harvest_contact;
          $format             = $results->harvest_format;
          $set                = $results->harvest_set;
          $userEmbargo        = $results->harvest_userEmbargo;
          $pwdEmbargo         = $results->harvest_pwdEmbargo;
          $userNBN            = $results->user;
          $pwdNBN             = $results->pass;
          $ipNBN              = $results->IP;
          $idSubNamespace     = $results->subNamespaceID;
          $idDatasource       = $results->datasourceID;

        ?>
              
          <div class="card">            
            <div class="card-header" id="heading<?php echo $key ?>">
                
              <button class="btn" data-toggle="collapse" data-target="#collapse_journal<?php echo $key ?>" aria-expanded="false" aria-controls="collapse_journal<?php echo $key ?>">
                <h5 class="m-0"><?php echo $nomeDatasource ?></h5>
              </button>
                
            </div>

            <div id="collapse_journal<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">
              <div class="card-body">
                <form action="" method="post">
                <input type="hidden" name="idSubNamespace" value="<?php echo $idSubNamespace ?>">
                <input type="hidden" name="idDatasource" value="<?php echo $idDatasource ?>">
                <input type="hidden" name="id_Ist" value="<?php echo $id_Ist ?>">
                <input type="hidden" name="harvest_name" value="<?php echo $harvest_name ?>">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="nomeDatasource">Nome Datasource</label>
                      <input name="nomeDatasource" value="<?php echo $nomeDatasource ?>" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="url">URL sito OAI</label>
                      <input name="url" value="<?php echo $url ?>" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="contatti">Contatti</label>
                      <input name="contatti" value="<?php echo $contatti ?>" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="format">Format dei metadati</label>
                      <input name="format" value="<?php echo $format ?>" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="set">Set dei metadati</label>
                      <input name="set" value="<?php echo $set ?>" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="userEmbargo">Utenza per accesso embargo</label>
                      <input name="userEmbargo" value="<?php echo $userEmbargo ?>" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="pwdEmbargo">Password per accesso embargo</label>
                      <input name="pwdEmbargo" value="<?php echo $pwdEmbargo ?>" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="userNBN">User per API NBN</label>
                      <input name="userNBN" value="<?php echo $userNBN ?>" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="pwdNBN">Password per API NBN</label>
                      <input name="pwdNBN" value="<?php echo $pwdNBN ?>" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="ipNBN">IP per API NBN</label>
                      <input name="ipNBN" value="<?php echo $ipNBN ?>" type="text">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12"><input type="submit" name="modificaJournal" value="Modifica" class="mt-3 float-right"></div>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <?php } ?>
      </div>
    <?php } ?>


    <?php if (!empty($bookServizioAttivo)) { ?>
      <div id="infoBook">
        <h5>e-Book </h5>
        <?php foreach($bookAll as $keyBook=>$results) {
          $nomeDatasourceBook     = $results->agent_name;
          $urlBook                = $results->baseurl;
          $userNBNBook            = $results->user;
          $pwdNBNBook             = $results->pass;
          $ipNBNBook              = $results->IP;
          $idSubNamespaceBook     = $results->subNamespaceID;
          $idDatasourceBook       = $results->datasourceID;
          
          ?>
        <div class="card">
          <div class="card-header" id="heading<?php echo $keyBook ?>">
            <button class="btn" data-toggle="collapse" data-target="#collapse_Book<?php echo $keyBook ?>" aria-expanded="false" aria-controls="collapse_Book<?php echo $keyBook ?>">
              <h5 class="m-0"><?php echo $nomeDatasourceBook ?></h5>
            </button>
          </div>
          <div id="collapse_Book<?php echo $keyBook ?>" class="collapse" aria-labelledby="heading<?php echo $keyBook ?>">
            <div class="card-body">

            <?php if(isset($alertBookModify)) { ?>
              <div class='alert alert-warning'><?php echo $alertBookModify ?></div>
            <?php } ?>

              <form action="" method="post">
                <input type="hidden" name="idSubNamespaceBook" value="<?php echo $idSubNamespaceBook ?>">
                <input type="hidden" name="idDatasourceBook" value="<?php echo $idDatasourceBook ?>">
                <div class="row">
                  <div class="col-md-6">
                    <label for="nomeDatasourceBook">Nome Datasource</label>
                    <input name="nomeDatasourceBook" value="<?php echo $nomeDatasourceBook ?>" type="text">
                  </div>
                  <div class="col-md-6">
                    <label for="urlBook">URL sito OAI</label>
                    <input name="urlBook" value="<?php echo $urlBook ?>" type="text">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="userNBNBook">User per API NBN</label>
                    <input name="userNBNBook" value="<?php echo $userNBNBook ?>" type="text">
                  </div>
                  <div class="col-md-6">
                    <label for="pwdNBNBook">Password per API NBN</label>
                    <input name="pwdNBNBook" value="<?php echo $pwdNBNBook ?>" type="text">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="ipNBNBook">IP per API NBN</label>
                    <input name="ipNBNBook" value="<?php echo $ipNBNBook ?>" type="text">
                  </div>
                  <div class="col-md-6"></div>
                </div>
                <div class="row">
                  <div class="col-md-12"><input type="submit" name="modificaBook" value="Modifica" class="mt-3 float-right"></div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    <?php } ?>


          </div>
      </div>
    </div>



    <!-- Modal inserisci istituto -->
<div class="modal fade" id="insertIstModal" tabindex="-1" data-backdrop="static" data-keyboard="false"  role="dialog" aria-labelledby="insertIstModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form action="" method="post" id="InsertIstForm">
      <div class="modal-header">
        <h5 class="modal-title" id="insertIstModalLabel" style="margin-right: 2.5rem;margin-bottom: 2rem;" >Inserisci Servizio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <!-- <form action="" method="post"> -->
                <input type="hidden" name="id_Ist_modal" id="id_Ist_modal" value="">
                <input type="hidden" name="Ist_name_modal" id="Ist_name_modal" value="">
                <input type="hidden" name="Ist_login_modal" id="Ist_login_modal" value="">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                             <label for="selectType">Tipo Servizio:</label>
                             <select class="form-control" id="selectType" name="selectType" style="font-size: 100%;">
                               <option selected>Seleziona Tipo Servizio...</option>
                               <option value="td">Tesi di Dottorato</option>
                               <option value="ej">E-Journal</option>
                               <option value="eb">E-Book</option>
                             </select>
                        </div> 
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="nomeDatasource">Nome Datasource</label>
                      <input name="nomeDatasource" value="" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="url">URL sito OAI</label>
                      <input name="url" value="" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="contatti">Contatti</label>
                      <input name="contatti" value="" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="format">Format dei metadati</label>
                      <input name="format" value="" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="set">Set dei metadati</label>
                      <input name="set" value="" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="userEmbargo">Utenza per accesso embargo</label>
                      <input name="userEmbargo" value="" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="pwdEmbargo">Password per accesso embargo</label>
                      <input name="pwdEmbargo" value="" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="userNBN">User per API NBN</label>
                      <input name="userNBN" value="" type="text">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="pwdNBN">Password per API NBN</label>
                      <input name="pwdNBN" value="" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="ipNBN">IP per API NBN</label>
                      <input name="ipNBN" value="" type="text">
                    </div>
                  </div>
                <!-- </form> -->
                <br>
      </div>
      <div class="modal-footer">
        <div class="row col-md-12">
                     <div class="col-md-6"><input style="background: darkgrey;" type="button" data-dismiss="modal" name="Chiudi" value="Chiudi" class="mt-3 float-left"></div> 
                     <div class="col-md-6"><input type="submit" name="inserisciServizio" value="Inserisci" class="mt-3 float-right"></div> 
                  </div>
      </div>
      </form>
    </div>
  </div>
</div>


    <!-- Modal inserisci user -->
 <div class="modal fade" id="insertUserModal" tabindex="-1" data-backdrop="static" data-keyboard="false"  role="dialog" aria-labelledby="insertIstModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form action="" method="post" id="InsertUserForm">
      <div class="modal-header">
        <h5 class="modal-title" id="insertIstModalLabel" style="margin-right: 2.5rem;margin-bottom: 2rem;" >Inserisci Utente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <!-- <form action="" method="post"> -->
                <input type="hidden" name="id_Ist_modalNewUser" id="id_Ist_modalNewUser" value="">

                <div class="row">
            <div class="col-md-6">
                <label for="newUserLogin">Username</label>
                <input type="text" name="newUserLogin" required>
            </div>
            <div class="col-md-6">
                <label for="newUserPassword">Password</label>
                <input type="password" name="newUserPassword" id="newUserPassword">
                <input type="checkbox" name="newUserPasswordShow" id="newUserPasswordShow"> <label for="newUserPasswordShow">Mostra la password</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="newUserCognome">Cognome</label>
                <input type="text" name="newUserCognome" required>
            </div>
            <div class="col-md-6">
                <label for="newUserNome">Nome</label>
                <input type="text" name="newUserNome" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="newUserCodiceFiscale">Codice Fiscale</label>
                <input type="text" name="newUserCodiceFiscale" maxlength="16">
            </div>
            <div class="col-md-6">
                <label for="newUserEmail">E-mail</label>
                <input type="email" name="newUserEmail">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="newUserIpAutorizzati">IP Autorizzati</label>
                <input type="text" name="newUserIpAutorizzati" placeholder="Seprare gli IP con una virgola">
            </div>
            </div>
                <!-- </form> -->
                <br>
      </div>
      <div class="modal-footer">
        <div class="row col-md-12">
                     <div class="col-md-6"><input style="background: darkgrey;" type="button" data-dismiss="modal" name="Chiudi" value="Chiudi" class="mt-3 float-left"></div> 
                     <div class="col-md-6"><input type="submit" name="inseriscinewUserLoginModal" value="Inserisci" class="mt-3 float-right"></div> 
                  </div>
      </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>


<script>
  passwordToggle = document.getElementById('newUserPasswordShow');
    passwordInput = document.getElementById('newUserPassword');

    passwordToggle.addEventListener('change', function() {
        
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
    
    });
    </script>