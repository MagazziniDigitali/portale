<?php
   require("../../wp-load.php");;
   require("../src/functions.php");

         if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

   $dbMD = connect_to_md();
   redirect_if_logged_in();

   $encryptedUuid = $_GET['token'];
   $decryptedUuid = decrypt_string($encryptedUuid);

   $validatedEmail = check_email_validata($dbMD, $decryptedUuid);

   if ($validatedEmail == 0){
       send_notice_email_to_admin($dbMD);
       set_email_validata_to_true($dbMD, $decryptedUuid);
       get_header();
?>

<section>
   <div class="container">
      <p>La tua e-mail è stata confermata.</p>
      <p>La richiesta di registrazione è stata inoltrata e a breve verrà presa in carico.</p>
   </div>
</section>

<?php  get_footer(); } else { 
    get_header();
?>

<section>
   <div class="container">
      <p>La tua e-mail è già stata confermata.</p>
      <p>La richiesta di registrazione è stata inoltrata e a breve verrà presa in carico.</p>
   </div>
</section>

<?php 
    get_footer();
} ?>