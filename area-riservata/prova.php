<?php
  require("../wp-load.php");
  require("./src/functions.php");
  require("./src/lib/bagit.php");

  session_start();
  $dbMD = connect_to_md();

  //HAI GIÀ BAGIT
  //form upload BAGIT -> carica -> /mnt/areaTemporanea/Ingest/PIVA -> se la cartella PIVA non esiste, la crea, altrimenti carica direttamente il bagit già fatto

  //HAI UN EPUB/PDF
  //form di upload PDF/EPUB + input name="" per i metadati
  //creazione del json con metadati in /data
  //comprimere in [nome][timestamp in millisecondi].zip
  //salvare i bagit in /mnt/areaTemporanea/Ingest/[PIVA]
  //tutti gli utenti dell'istituzione possono fare questa operazione (gestore sia user normale)

  //includere fusso di Argentino

  //PER IL MOMENTO NO MA PROBABILE:
  //gestire possibilità di caricamento di una zip con all'interno migliaia di bagit
  //spacchettare e uploadare sotto PIVA

  //aggiungere a /superadmin/add-istituzione:
  //due form, uno per l'iscrizione a TD e uno per EJ
  
  $dbHarvest      = connect_to_harvest();
  $dbNBN          = connect_to_nbn();

  $uuidUtente         = generate_uuid($dbMD);
  $admin              = 0;
  $superadmin         = 0;
  $ipAutorizzati      = '*.*.*.*';

  $gestore = insert_new_user($dbMD, $uuidUtente, 'ciaologin', 'ciaopassword', 'ciaocognome', 'ciaonome', 'ciaocodiceFiscale', 'ciaoemail', $admin, $superadmin, $ipAutorizzati, 'aa40fed9-4fa1-11eb-ae2d-000c29e2d309');

  var_dump($gestore);
  echo '<br> echo: ' . $gestore . '<br>';

  var_dump($uuidUtente);
  echo '<br> echo: ' . $uuidUtente;

  if($gestore == 1) {
    echo '<br><br>YEEEEEEEES';
  } elseif ($gestore == 0) {
    echo '<br><br>NAGG A MARO';
  }

  get_header();
?>

<?php
    get_footer();
?>