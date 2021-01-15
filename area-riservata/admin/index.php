<?php
   include("../../wp-load.php");
   require("../src/functions.php");

   session_start();

   redirect_if_not_logged_in();
   
   if($_SESSION['role'] == 'superadmin'){

      $dbMD = connect_to_md();
      
      $pendingPreReg = check_istituzioni_to_be_approved($dbMD);

      get_header();

   ?>

   <section>
      <div class="container">
         <p>Benvenuto <strong><?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?></strong></p>
         <?php if($_SESSION['istituzione'] != 'istituzioneBase') { ?>
            <p>Istituzione di appartenenza: <?php echo $_SESSION['istituzione'] ?></p>
         <?php } ?>

         <div id="accordionRichiesteSignup">
            <!-- Controllo richieste da approvare -->
            <?php
               if($pendingPreReg == 0){ ?>
                  
                  <h5>Non ci sono richieste di registrazione da approvare</h5>

               <?php } else { 
                  
                  if($pendingPreReg == 1){ ?>

                     <h5>C'è una richiesta di registrazione da approvare</h5>

                     <?php include("approve-signup.php"); ?>

                  <?php } else { ?> 

                     <h5>Ci sono <?php echo $pendingPreReg ?> richieste di registrazione da approvare</h5>
                  
                     <?php include("approve-signup.php"); ?>

                  <?php } ?>
                  
               <?php } ?>
         </div>

         <div id="addUser">
            <h5>Aggiungi un utente</h5>
            <?php include("add-user.php"); ?>
         </div>

         <div id="showAllUser">
            <h5>Lista utenti</h5>
            <?php include("show-users.php"); ?>
         </div>
      </div>
   </section>
      
<?php 
}
    get_footer(); 
?>