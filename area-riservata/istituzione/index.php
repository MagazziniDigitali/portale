<?php
   require("../../wp-load.php");;
   require("../src/functions.php");

   session_start();

   redirect_if_not_logged_in();

   if($_SESSION['role'] != 'admin_istituzione'){

      redirect_if_logged_in();

   } else {

      $dbMD = connect_to_md();

      $checkUserPerIstituzione = check_users_for_istituzione($dbMD);

      get_header();

?>

<section>
   <div class="container">
      <p>Benvenuto <strong><?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?></strong></p>
      <?php if($_SESSION['istituzione'] != 'istituzioneBase') { ?>
         <p>Istituzione di appartenenza: <?php echo $_SESSION['istituzione'] ?></p>
      <?php } ?>
      
      <div id="addUser">
         <h5>Aggiungi un utente</h5>
         <?php include("add-user.php"); ?>
      </div>

      <div id="showUsers">
         <h5>Utenti registrati</h5>
         <?php if ($checkUserPerIstituzione == 0) { ?>
            <h6>Non ci sono utenti da mostrare</h6>
         <?php } else {
            include("show-users.php");
         } ?>
      </div>

      <div id="signupServices">
         <h5>Registra l'istituzione ai servizi <a href="signup-services#tesiDottorato">Tesi di Dottorato</a>, <a href="signup-services#eJournal">e-Journal</a></h5>
      </div>
   </div>
</section>
      
<?php }
    get_footer(); 
?>