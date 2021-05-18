<?php
   require("../../wp-load.php");;
   require("../src/functions.php");

         if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

   get_header();

?>

<section>
   <div class="container">
      <p>Registrazione completata</p>
      <p>A breve riceverai una e-mail di conferma.</p>
   </div>
</section>
      
<?php
    get_footer(); 
?>