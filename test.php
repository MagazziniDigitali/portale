<?php
 
 $ambiente = getenv('AMBIENTE_APPLICATIVO'); 
 
  echo "<br>AMBIENTE_APPLICATIVO = " . $ambiente;
  
 $user = getenv('APACHE_RUN_USER');
 
  echo "<br>APACHE_RUN_USER = " . $user;
  
 
 
  ?>