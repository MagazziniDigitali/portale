<?php
include_once("../../wp-load.php");
include_once("../src/functions.php");


if (!isset($_SESSION)) {
   session_start();
}

redirect_if_not_logged_in();

if ($_SESSION['role'] != 'admin_istituzione') {
   redirect_if_logged_in();
} else {
   $dbMD = connect_to_md();
   $checkUserPerIstituzione = check_users_for_istituzione($dbMD);
   get_header();
?>

   <section>
      <div class="container">
         <p class="text-center">Benvenuto <strong><?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?></strong></p>
         <?php if ($_SESSION['istituzione'] != 'istituzioneBase') { ?>
            <p class="text-center">Istituzione di appartenenza: <strong><?php echo $_SESSION['istituzione'] ?></strong></p>
         <?php } ?>

         <div id="addUser">
            <h6>Aggiungi un utente</h6>
            <?php include("add-user.php"); ?>
         </div>

         <div id="showUsers">
            <h5>Utenti registrati</h5>
            <div class="divServizi">

            <?php if ($checkUserPerIstituzione == 0) { ?>
               <p>Non ci sono utenti da mostrare</p>
            <?php } else {
               include("show-users.php");
            } ?>
            </div>
         </div>

         <?php
         $_isviewonly = true;
         include_once("signup-services.php");

         ?>


         <div id="signupServices">
            <h6>Registra l'istituzione ai servizi:</h6>
            <div class="row">

               <?php if (empty($tesiServizioAttivo)) { ?>
                  <div class="col-md-3"><input style="background: cadetblue;" name="gotosignupTesiDottorato" type="button" value="Tesi di Dottorato" class="col-md-12 mt-3 float-left" onclick="location.href='signup-services#tesiDottorato';" /></div>
               <?php } ?>

               <div class="col-md-3"><input style="background: cadetblue;" name="gotosignupEJournal" type="button" value="e-Journal" class="col-md-12 mt-3 float-left" onclick="location.href='signup-services#eJournal';" /></div>

               <div class="col-md-3"><input style="background: cadetblue;" name="gotosignupEBook" type="button" value="e-Book" class="col-md-12 mt-3 float-left" onclick="location.href='signup-services#eBook';" /></div>
               <div class="col-md-3"><input style="background: cadetblue;" name="gotosignupNbn" type="button" value="NBN" class="col-md-12 mt-3 float-left" onclick="location.href='signup-services#NBN';" /></div>

            </div>
            <!-- <a  href="signup-services#tesiDottorato">Tesi di Dottorato</a>, <a href="signup-services#eJournal">e-Journal</a>, <a href="signup-services#eBook">e-Book</a> -->
         </div>




      </div>
   </section>



<?php }
get_footer();
?>