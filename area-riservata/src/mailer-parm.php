<?php 


function mailParm(){
    $mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', 'cedf82b4d4c1b2', 'f06ef4a6a9b766', 'from@example.com', 'Magazzini Digitali');
    return $mail;
}

//  
?>