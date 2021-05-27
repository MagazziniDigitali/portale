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
  }   

  foreach($uniqueIdIst as $key=>$results) {

    $idIst = $results->ID_ISTITUZIONE;

    $loginIst = retrieve_login_istituzione($dbMD, $idIst);

    $loginIstLogin = $loginIst[0]->LOGIN;
    $loginIstName = $loginIst[0]->NOME;

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
          </div>
      </div>
    </div>

<?php } ?>