<?php

  $uniqueIdIst = $dbMD->get_results("SELECT ID_ISTITUZIONE FROM MDUtenti WHERE SUPERADMIN <> 1 AND SUPERADMIN <> 2 GROUP BY ID_ISTITUZIONE");

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
  
      $updateDatasource   = update_datasource_nbn($dbNBN, $loginIstLogin, $loginIstName, $nomeDatasource, $url, $idSubNamespace, $idDatasource);
  
      if ($updateDatasource == 1) {
  
        $updateAgent      = update_agent_nbn($dbNBN, $loginIstLogin, $loginIstName, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, 'td', $idSubNamespace, $idDatasource);
  
        if ($updateAgent  == 1){
  
          $updateHarvest  = update_anagrafe_harvest($dbHarvest, $idIst, $loginIstLogin, $loginIstName, $nomeDatasource, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $url, 'td', $idDatasource);
          
          if ($updateHarvest == 1){
  
            echo "<script>window.location.href = '/area-riservata//istituzione/signup-services'</script>";
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
  
      $updateDatasource   = update_datasource_nbn($dbNBN, $loginIstLogin, $loginIstName, $nomeDatasource, $url, $idSubNamespace, $idDatasource);
  
      if ($updateDatasource == 1) {
  
        $updateAgent      = update_agent_nbn($dbNBN, $loginIstLogin, $loginIstName, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, 'ej', $idSubNamespace, $idDatasource);
  
        if ($updateAgent == 1){
  
          $updateHarvest  = update_anagrafe_harvest($dbHarvest, $idIst, $loginIstLogin, $loginIstName, $nomeDatasource, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $url, 'ej', $idDatasource);
          
          if ($updateHarvest == 1){
  
            echo "<script>window.location.href = '/area-riservata//istituzione/signup-services'</script>";
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
  
        $updateDatasource   = update_datasource_nbn($dbNBN, $loginIstLogin, $nomeIstituzione, $nomeDatasourceBook, $urlBook, $idSubNamespaceBook, $idDatasourceBook);
  
        if ($updateDatasource == 1) {
  
          $updateAgent      = update_agent_nbn($dbNBN, $loginIstLogin, $nomeIstituzione, $nomeDatasourceBook, $urlBook, $userNBNBook, $pwdNBNBook, $ipNBNBook, 'eb', $idSubNamespaceBook, $idDatasourceBook);
  
          if ($updateAgent == 1){
  
            echo "<script>window.location.href = '/area-riservata/istituzione/signup-services'</script>";
          //  echo "<script>window.location.href = 'http://md-collaudo.depositolegale.it/area-riservata/istituzione/signup-services'</script>";
  
          }
  
        }
  
      } else {
  
        $alertBookModify = 'Nome Datasource già in uso';
        
      }
  
    }
  }   

  foreach($uniqueIdIst as $key=>$results) {

    $idIst = $results->ID_ISTITUZIONE;

    $loginIst = retrieve_login_istituzione($dbMD, $idIst);
    $tesiServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $idIst, 'td');
    $journalServizioAttivo  = check_if_istituzione_signed_for_service($dbMD, $idIst, 'ej');
    $bookServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $idIst, 'eb');
  
  
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

    ?>

    <div class="card">
      <div class="card-header" id="heading<?php echo $key ?>">
      
        <button class="btn" data-toggle="collapse" data-target="#collapse<?php echo $key ?>" aria-expanded="false" aria-controls="collapse<?php echo $key ?>">
          <?php if ($loginIstLogin == 'istituzioneBase'){ ?>
              <h5 class="m-0">Utenti non appartenenti a un'istituzione</h5>
          <?php } else { ?>
              <h5 class="m-0">Istituzione: <?php echo $loginIstName ?></h5>
          <?php } ?>
        </button>

      </div>

      <div id="collapse<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">
          <div class="card-body">

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

              <?php if ($admin == 1) { ?>
                  <h6 class="mt-0">Gestore d'istituzione: <?php echo $login ?></h6>
              <?php } else { ?>
                  <h6 class="mt-0"><?php echo $login ?></h6>
              <?php } ?>
                
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












            <?php } ?>

<?php if (!empty($tesiServizioAttivo)||!empty($journalServizioAttivo)||!empty($bookServizioAttivo)) { ?>
  <h4>Servizi: </h4>
  <?php } ?>
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
                    <!-- <div class="col-md-12"><input type="submit" name="modificatesi" value="Modifica" class="mt-3 float-right"></div> -->
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
                    <!-- <div class="col-md-12"><input type="submit" name="modificaJournal" value="Modifica" class="mt-3 float-right"></div> -->
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
                  <!-- <div class="col-md-12"><input type="submit" name="modificaBook" value="Modifica" class="mt-3 float-right"></div> -->
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

<?php } ?>