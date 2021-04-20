<?php
  require("../wp-load.php");
  require("./src/functions.php");

  session_start();

  $dbMD = connect_to_md();
  redirect_if_logged_in();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['loginNewPwd']) && $_POST['loginNewPwd'] != ''){

      $loginNewPwd = $_POST['loginNewPwd'];

      $user = check_user_exists($dbMD, $loginNewPwd);

      $uuidUser           = $user[0]->ID;
      $pwd                = $user[0]->PASSWORD;
      $cognome            = $user[0]->COGNOME;
      $nome               = $user[0]->NOME;
      $email              = $user[0]->EMAIL;
      $login              = $user[0]->LOGIN;
      $amministratore     = $user[0]->AMMINISTRATORE;
      $superadmin         = $user[0]->SUPERADMIN;
      $istituzione        = $user[0]->ID_ISTITUZIONE;

      if(!$user) {

          $error = "Username o e-mail non valida";

      } else {

        if (isset($_POST['pwdNewPwd']) && $_POST['pwdNewPwd'] != ''){

          $password = $_POST['pwdNewPwd'];
          $check = check_strong_password($password);

          if($check != 1){

            $error = $check;

          } else {

            $passwordSHA = generate_sha_pwd($dbMD, $password);

            if ($pwd != $passwordSHA){

              $pwd = $passwordSHA;
              
              $encryptedUUID = encrypt_string($uuidUser);

              $update = change_password($dbMD, $encryptedUUID, $pwd);

              if ($update == 1){

                if (($amministratore == 1) && ($superadmin == 0)){
                  
                  $updateConfig = update_password_mdconfig($dbMD, $password, $istituzione);
                  $updateSoftware = update_password_mdsoftware($dbMD, $pwd, $uuidIstituzione);

                }
                  
                send_change_password_email($dbMD, $nome, $cognome, $email, $login, $password);

                echo "<script>window.location.href = 'http://localhost/local/area-riservata/'</script>";
  
              }

            } else {

              $error = "La password non può essere uguale a quella già esistente";

            }
          }
        }

          

      }

    } else {

      $error = "Inserire username o email";

    }
      
  }
  
  get_header();
?>

<section>
    <div class="container">
        <form action="" method="post">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <label for="loginNewPwd">Inserisci username o e-mail</label>
                    <input name="loginNewPwd" type="text">
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <label for="pwdNewPwd">Inserisci nuova password</label>
                    <input name="pwdNewPwd" id="pwdNewPwd" type="password">
                    <input type="checkbox" name="showPwd" id="showPwd"> <label for="showPwd">Mostra la password</label>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <?php if(isset($error)) { ?>
                        <div class='alert alert-warning mt-3'><?php echo $error ?></div>
                    <?php } ?>
                    <input name="submit" type="submit" value="Cambia password" class="mt-3 float-right"/>
                </div>
                <div class="col-md-3"></div>
            </div>
        </form>
    </div> 
</section>

<?php 
    get_footer();
?>

<script>
    passwordToggle = document.getElementById('showPwd');
    passwordInput = document.getElementById('pwdNewPwd');

    passwordToggle.addEventListener('change', function() {
        
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
    
    });
</script>