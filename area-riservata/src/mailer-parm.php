<?php 


function mailParm(){
    $mail =null;
    if(strtolower(AMBIENTE_APPLICATIVO)=='locale')
   {
        $mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', 'cedf82b4d4c1b2', 'f06ef4a6a9b766', 'from@example.com', 'Magazzini Digitali');
   }
    else if(strtolower(AMBIENTE_APPLICATIVO)=='collaudo')
   {
       $mail = init_phpmailer("smtp.gmail.com", 587, 'tls', 'magazzinidigitalitest@gmail.com', 'umXj01Z&2qw#Bign', 'magazzinidigitalitest@gmail.com', 'Magazzini Digitali');
   }
   else if(strtolower(AMBIENTE_APPLICATIVO)=='esercizio')
   {
       $mail = init_phpmailer("smtp.gmail.com", 587, 'tls', 'magazzinidigitalitest@gmail.com', 'umXj01Z&2qw#Bign', 'magazzinidigitalitest@gmail.com', 'Magazzini Digitali');
   }
   return $mail;
}


//  
?>