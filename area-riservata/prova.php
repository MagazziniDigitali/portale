<?php
  require("../wp-load.php");
  require("./src/functions.php");
  require("./src/lib/bagit.php");

  session_start();
  $dbMD = connect_to_md();

  $user = check_user_session($dbMD);
  var_dump($user);
  die();

  //1. possibilità in cui superadmin cambia la password del gestore istituzione
  //2. possibilità in cui il gestore istituzione cambi la password al proprio account
  //3. possibilità in cui il gestore istituzione abdichi al ruolo e lo ceda a un altro utente
  

  get_header();  

?>

<?php
    get_footer();
?>
