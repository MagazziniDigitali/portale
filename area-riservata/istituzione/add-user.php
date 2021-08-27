<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        if(isset($_POST['newUserLogin']) && $_POST['newUserLogin'] != '') {
            $newUserLogin = $_POST['newUserLogin'];
            
            if(isset($_POST['newUserPassword']) && $_POST['newUserPassword'] != '') {
            $newUserPassword = $_POST['newUserPassword'];
            }
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

            $uuid               = generate_uuid($dbMD);
            $uuid               = $uuid . '-F';
            $admin              = 0;
            $superadmin         = 0;
            $idIstituzione      = check_istituizone_session($dbMD);

            $newUser = insert_new_user($dbMD, $uuid, $newUserLogin, $newUserPassword, $newUserCognome, $newUserNome, $newUserCodiceFiscale, $newUserEmail, $admin, $superadmin, $newUserIpAutorizzati, $idIstituzione);

            if(!$newUser){
                $error = insert_new_user_check_errors($dbMD);
            } else {

                $encryptedUuid = encrypt_string($uuid);
                send_confirmation_email_to_user($newUserCognome, $newUserNome, $newUserEmail, $encryptedUuid, $newUserLogin, $newUserPassword);

                echo "<script>window.location.href = '/area-riservata/istituzione/'</script>";

            }
        }

    }

?>

<div clas="container">

    <?php if(isset($error)) { ?>
        <div class='alert alert-warning mt-3 mb-5'><?php echo $error ?></div>
    <?php } ?>

    <form action="" method="POST">
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
                <input type="text" name="newUserIpAutorizzati" placeholder="Separare gli IP con una virgola">
            </div>
            <div class="col-md-6"></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 text-right">
               <input type="submit" value="Inserisci">
            </div>
         </div>
    </form>
</div>


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