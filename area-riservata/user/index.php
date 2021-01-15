<?php
   require("../../wp-load.php");;
   require("../src/functions.php");

   session_start();

   redirect_if_not_logged_in();

   if($_SESSION['role'] == 'user_istituzione'){

      $dbMD = connect_to_md();
      
      get_header();

?>

<section>
   <div class="container">
      <p>Benvenuto <strong><?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?></strong></p>

      <?php if($_SESSION['istituzione'] != 'istituzioneBase') { ?>
         <p>Istituzione di appartenenza: <?php echo $_SESSION['istituzione'] ?></p>
      <?php } ?>

      <a href="http://localhost/local/area-riservata/logout">Logout</a>
   </div>
</section>
      
<?php }
    get_footer(); 
?>