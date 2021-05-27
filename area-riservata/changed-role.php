<?php
    require("../wp-load.php");
    require("./src/functions.php");
   
          if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    $dbMD = connect_to_md();

    $idIstituzione      = $_GET['i'];
    $newUUID            = $_GET['n'];

    $currentUser        = $_SESSION['role'];

    $oldGestore         = select_gestore($dbMD, $idIstituzione);
    $uuid               = $oldGestore[0]->ID;
    $encryptedUUID      = encrypt_string($uuid);

    $oldAdmin           = 0;
    $newAdmin           = 1;

    //rende il current gestore un utente normale
    change_role($dbMD, $encryptedUUID, $oldAdmin);

    //rende il current utente un gestore istituzione
    change_role($dbMD, $newUUID, $newAdmin);

    //se il current utente era gestore
    if($currentUser == 'admin_istituzione'){
        do_logout();
    } else {
        //header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/local/" . "area-riservata/");
        header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/area-riservata/");
    }
?>