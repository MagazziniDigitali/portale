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

  $insertSoftwareC = insert_new_software_config($dbMD, '07bcadfa-bd1e-49f2-a022-18cc57b72189-AG', 'password', 'piva');

  echo $insertSoftwareC;
?>

<?php
    get_footer();
?>