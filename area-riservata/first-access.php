<?php
require("../wp-load.php");
require("./src/functions.php");

if (!isset($_SESSION)) {
    session_start();
}


$encryptedUUID = $_GET['token'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbMD = connect_to_md();
    if (isset($_POST['firstAccessPassword']) && $_POST['firstAccessPassword'] != '') {
        $newPassword = $_POST['firstAccessPassword'];
        $check = check_strong_password($newPassword);
        if ($check != 1) {
            $alert = $check;
        } else {
            $user = check_user_session($dbMD);
            $amministratore     = $user[0]->AMMINISTRATORE;
            $superadmin         = $user[0]->SUPERADMIN;
            $istituzione        = $user[0]->ID_ISTITUZIONE;
            $oldPwd             = $user[0]->PASSWORD;
            $encryptedPWD = generate_sha_pwd($dbMD, $newPassword);
            if ($oldPwd != $encryptedPWD) {
                $uuid = $user[0]->ID;
                $change = change_password_first_login($dbMD, $encryptedUUID, $encryptedPWD);
                if ($change) {
                    if (($amministratore == 1) && ($superadmin == 0)) {
                        $updateConfig   = update_password_mdconfig($dbMD, $newPassword, $istituzione);
                        $updateSoftware = update_password_mdsoftware($dbMD, $encryptedPWD, $uuidIstituzione);
                    }
                    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] .  "/area-riservata/login");
                    exit();
                } else {
                    $alert = $dbMD->show_errors;
                }
            } else {
                $alert = "La password non può essere uguale a quella già esistente";
            }
        }
    }
}
get_header();
?>

<section>
    <div class="container">
        <h4 class="text-center">Cambia la password prima di effettuare il login</h4>

        <form action="" method="POST">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <label for="firstAccessPassword">Nuova Password</label>
                    <input type="password" name="firstAccessPassword" id="firstAccessPassword">
                    <input type="checkbox" name="showPwd" id="showPwd"> <label for="showPwd">Mostra la password</label>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3"></div>
                <div class="col-md-6 text-right">
                    <?php if (isset($alert)) { ?>
                        <div class='alert alert-warning mt-3'><?php echo $alert ?></div>
                    <?php } ?>
                    <input type="submit" name="firstAccessSubmit" value="Imposta Nuova Password">
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
    passwordInput = document.getElementById('firstAccessPassword');

    passwordToggle.addEventListener('change', function() {

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }

    });
</script>