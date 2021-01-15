<?php
    require("../wp-load.php");
    require("./src/functions.php");

    session_start();

    redirect_if_not_logged_in();
    redirect_if_logged_in();
?>
