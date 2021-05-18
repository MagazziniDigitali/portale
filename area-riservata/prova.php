<?php
  require("../wp-load.php");
  require("./src/functions.php");
  require("./src/lib/bagit.php");

  session_start();
  $dbMD = connect_to_md();

  $uuidUtente         = generate_uuid($dbMD);
  $admin              = 1;
  $superadmin         = 0;
  $ipAutorizzati      = '*.*.*.*';

  $gestore = insert_new_gestore_istituzione($dbMD, $uuidUtente, "testFinale", "testFinale1234!", "testFinale", "testFinaleNomeGestore", $admin, "a443a565-a37f-11eb-be89-080027c7eb61", "testFinaleCF", "piscopo@almaviva.it", $superadmin, $ipAutorizzati);

  if ($gestore == 1) {

    echo "assa fa";
    die();

  } else {

    echo "Errore inserimento gestore: " . insert_new_gestore_istituzione_check_errors($dbMD) . "<br><br>";
    echo "Last Result: " . "<br>" . var_dump($dbMD->last_error) . "<br><br>";
    echo "Last Query: " . $dbMD->last_query . "<br><br>";
    die();

  }
  
  //1. possibilità in cui superadmin cambia la password del gestore istituzione
  //2. possibilità in cui il gestore istituzione cambi la password al proprio account
  //3. possibilità in cui il gestore istituzione abdichi al ruolo e lo ceda a un altro utente
  

  get_header();  

?>

<?php
    get_footer();
?>
