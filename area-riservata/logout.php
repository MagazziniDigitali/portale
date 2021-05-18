<?php
    require("../wp-load.php");
    require("./src/functions.php");

          if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    
    do_logout();
?>