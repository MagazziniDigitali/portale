<?php
   include("../../wp-load.php");
   require("../src/functions.php");

         if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

   $dbMD = connect_to_md();

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      if(isset($_POST['superadminUsername']) && $_POST['superadminUsername'] != '') {
         $login = $_POST['superadminUsername'];
      }
      if(isset($_POST['superadminPassword']) && $_POST['superadminPassword'] != '') {
         $password = $_POST['superadminPassword'];
      }
      if(isset($_POST['superadminNome']) && $_POST['superadminNome'] != '') {
         $nome = $_POST['superadminNome'];
      }
      if(isset($_POST['superadminCognome']) && $_POST['superadminCognome'] != '') {
         $cognome = $_POST['superadminCognome'];
      }
      if(isset($_POST['superadminCodiceFiscale']) && $_POST['superadminCodiceFiscale'] != '') {
         $codiceFiscale = $_POST['superadminCodiceFiscale'];
      }
      if(isset($_POST['superadminEmail']) && $_POST['superadminEmail'] != '') {
         $email = $_POST['superadminEmail'];
      }

      //$istituzione = check_istituzione(db);

      $uuid           = generate_uuid($dbMD);
      $admin          = 0;
      $superadmin     = 1;
      $ipAutorizzati  = '*.*.*.*';
      $idIstituzione  = 'ISTITUZIONE-BASE';

      $superadmin = insert_new_user($dbMD, $uuid, $login, $password, $cognome, $nome, $codiceFiscale, $email, $admin, $superadmin, $ipAutorizzati, $idIstituzione);

      if(!$superadmin){
         $error = insert_new_user_check_errors($dbMD);
      }

   }

   get_header();

?>

<section>
   <div class="container">

   <?php if(isset($error)) { ?>
      <div class='alert alert-warning mt-3 mb-5'><?php echo $error ?></div>
   <?php } ?>

      <form action="" method="POST">
         <div class="row">
            <div class="col-md-6">
               <label for="superadminUsername">Username</label>
               <input type="text" name="superadminUsername" id="superadminUsername">
            </div>
            <div class="col-md-6">
               <label for="superadminPassword">Password</label>
               <input type="password" name="superadminPassword" id="superadminPassword">
               <input type="checkbox" name="showPwd" id="showPwd"> <label for="showPwd">Mostra la password</label>
            </div>
         </div>
         <div class="row">
            <div class="col-md-6">
               <label for="superadminNome">Nome</label>
               <input type="text" name="superadminNome" id="superadminNome">
            </div>
            <div class="col-md-6">
               <label for="superadminCognome">Cognome</label>
               <input type="text" name="superadminCognome" id="superadminCognome">
            </div>
         </div>
         <div class="row">
            <div class="col-md-6">
               <label for="superadminCodiceFiscale">Codice Fiscale</label>
               <input type="text" name="superadminCodiceFiscale" id="superadminCodiceFiscale">
            </div>
            <div class="col-md-6">
               <label for="superadminEmail">E-mail</label>
               <input type="email" name="superadminEmail" id="superadminEmail">
            </div>
         </div>
         <div class="row mt-3">
            <div class="col-md-12 text-right">
               <input type="submit" value="Inserisci">
            </div>
         </div>
      </form>
   </div>
</section>

<?php
   get_footer(); 
?>

<script>
    passwordToggle = document.getElementById('showPwd');
    passwordInput = document.getElementById('superadminPassword');

    passwordToggle.addEventListener('change', function() {
        
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
    
    });
</script>