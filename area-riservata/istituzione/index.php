<?php
   include_once("../../wp-load.php");
   include_once("../src/functions.php");


         if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

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
         <h5>Utenti registrati:</h5>
         <?php if ($checkUserPerIstituzione == 0) { ?>
            <h6>Non ci sono utenti da mostrare</h6>
         <?php } else {
            include("show-users.php");
         } ?>
      </div>

      <?php
$_isviewonly=true;
 include_once("signup-services.php");
 ?>
  

      <div id="signupServices">
         <h5>Registra l'istituzione ai servizi:</h5>
         <div class="row">
          <div class="col-md-4"><input style="background: cadetblue;" name="gotosignupTesiDottorato" type="button" value="Tesi di Dottorato" class="col-md-12 mt-3 float-left" onclick="location.href='signup-services#tesiDottorato';" /></div>
          <div class="col-md-4"><input style="background: cadetblue;" name="gotosignupEJournal" type="button" value="e-Journal" class="col-md-12 mt-3 float-left" onclick="location.href='signup-services#eJournal';" /></div>
          <div class="col-md-4"><input style="background: cadetblue;" name="gotosignupEBook" type="button" value="e-Book" class="col-md-12 mt-3 float-left" onclick="location.href='signup-services#eBook';" /></div>
          </div>
           <!-- <a  href="signup-services#tesiDottorato">Tesi di Dottorato</a>, <a href="signup-services#eJournal">e-Journal</a>, <a href="signup-services#eBook">e-Book</a> -->
      </div>
      
  

   </div>
</section>


      
<?php }
    get_footer(); 
?>