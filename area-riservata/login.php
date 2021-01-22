<?php
    require("../wp-load.php");
    require("./src/functions.php");

    session_start();

    redirect_if_logged_in();
    $dbMD   = connect_to_md();
    $dbNBN  = connect_to_nbn();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if(isset($_POST['usernameCustom']) && $_POST['usernameCustom'] != '') {
            $username = $_POST['usernameCustom'];
        }
        
        if(isset($_POST['passwordCustom']) && $_POST['passwordCustom'] != '') {
            $password = $_POST['passwordCustom'];
        }

        $user = retrieve_user_for_login($dbMD, $username, $password);

        if (!$user) {
            
            $alert = "Nome utente o password errata";

        } else {

            do_login($dbMD, $user);

        }
   
    }

    get_header();
?>

<section>
    <div class="container">
        <form id="formCustom" action="" method="POST">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <label for="usernameCustom">Username</label>
                    <input type="text" name="usernameCustom" id="usernameCustom" required>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <label for="passwordCustom">Password</label>
                    <input type="password" name="passwordCustom" id="passwordCustom" required>
                    <input type="checkbox" name="showPwd" id="showPwd"> <label for="showPwd">Mostra la password</label>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <?php if(isset($alert)) { ?>
                        <div class='alert alert-warning mt-3'><?php echo $alert ?></div>
                    <?php } ?>
                    <input name="submit" type="submit" value="Login" class="mt-3 float-right"/>
                </div>
                <div class="col-md-3"></div>
            </div>
        </form>
        <div class="row mt-5">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center">
                <p><a href="./recover-password">Password dimenticata?</a> <small>||</small> <a href="./signup">Registrati</a></p>
            </div>    
            <div class="col-md-3"></div>
        </div>
    </div>
</section>

<?php 
    get_footer();
?>

<script>
    passwordToggle = document.getElementById('showPwd');
    passwordInput = document.getElementById('passwordCustom');

    passwordToggle.addEventListener('change', function() {
        
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
    
    });
</script>