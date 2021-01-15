<?php
   include("../../wp-load.php");
   require("../src/functions.php");

   session_start();

   redirect_if_not_logged_in();
   
   if($_SESSION['role'] == 'admin_istituzione'){

      $dbMD = connect_to_md();

      $user = check_user_session($dbMD);

      $uuid                = $user[0]->ID;
      $login               = $user[0]->LOGIN;
      $pwd                 = $user[0]->PASSWORD;
      $cognome             = $user[0]->COGNOME;
      $nome                = $user[0]->NOME;
      $idIstituzione       = $user[0]->ID_ISTITUZIONE;
      $admin               = $user[0]->AMMINISTRATORE;
      $codiceFiscale       = $user[0]->CODICEFISCALE;
      $email               = $user[0]->EMAIL;
      $superadmin          = $user[0]->SUPERADMIN;
      $ipAutorizzati       = $user[0]->IP_AUTORIZZATI;

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
        
         $encryptedUUID = encrypt_string($uuid);
 
         if ($_POST['password'] == '') {
     
            $update = update_user($dbMD, $encryptedUUID, $pwd, $cognome, $nome, $codiceFiscale, $email, $ipAutorizzati);
 
         } elseif (isset($_POST['password']) && $_POST['password'] != ''){
 
            $password = $_POST['password'];
            $check = check_strong_password($password);
 
            if($check != 1){

               $alert = $check;

            } else {

               $password = generate_sha_pwd($dbMD, $password);
               
               if ($pwd != $password){
                  
                  $pwd = $password;
            
                  $update = update_user($dbMD, $encryptedUUID, $pwd, $cognome, $nome, $codiceFiscale, $email, $ipAutorizzati);

                  echo "<script>window.location.href = 'http://localhost/local/area-riservata/istituzione/profile'</script>";
 
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
      <form action="" method="post">
         <div class="row">
            <div class="col-md-6">
               <label for="username">Username</label>
               <input type="text" name="username" value="<?php echo $login ?>" disabled>
            </div>
            <div class="col-md-6">
               <label for="password">Password</label>
               <input type="password" name="password" id="password" placeholder="Inserisci una nuova password">
               <?php if(isset($alert)) { ?>
                  <div class='alert alert-warning mt-3'><?php echo $alert ?></div>
               <?php } ?>
               <input type="checkbox" name="showPwd" id="showPwd"> <label for="showPwd">Mostra la password</label>
            </div>
         </div>
         <div class="row">
            <div class="col-md-6">
               <label for="cognome">Cognome</label>
               <input name="cognome" type="text" value="<?php echo $cognome ?>">
            </div>
            <div class="col-md-6">
               <label for="nome">Nome</label>
               <input name="nome" type="text" value="<?php echo $nome ?>">
            </div>
         </div>
         <div class="row">
            <div class="col-md-6">
               <label for="codiceFiscale">Codice Fiscale</label>
               <input name="codiceFiscale" type="text" value="<?php echo $codiceFiscale ?>">
            </div>
            <div class="col-md-6">
               <label for="email">E-mail</label>
               <input name="email" type="text" value="<?php echo $email ?>">
            </div>
         </div>
         <div class="row">
                <div class="col-md-12">
                    <input name="submit" type="submit" value="Modifica Anagrafica" class="mt-3 float-right"/>
                </div>
            </div>
      </form>
   </div>
</section>

<?php
   }
   get_footer(); 
?>


<script>
    passwordToggle = document.getElementById('showPwd');
    passwordInput = document.getElementById('password');

    passwordToggle.addEventListener('change', function() {
        
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
    
    });
</script>