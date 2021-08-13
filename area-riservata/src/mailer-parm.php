<?php 


function mailParm(){
    $mail =null;
    $ambiente_applicativo = strtolower(AMBIENTE_APPLICATIVO);

    if($ambiente_applicativo =='local' || $ambiente_applicativo =='locale')
   {
        // Hassan -- $mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', 'cedf82b4d4c1b2', 'f06ef4a6a9b766', 'from@example.com', 'Magazzini Digitali');
        $mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', '1f91b011dc94cf', '8c11c1be3e7a23', 'from@example.com', 'Magazzini Digitali');
    }
    else if($ambiente_applicativo =='collaudo')
   {
       $mail = init_phpmailer("smtp.gmail.com", 587, 'tls', 'magazzinidigitalitest@gmail.com', 'umXj01Z&2qw#Bign', 'magazzinidigitalitest@gmail.com', 'Magazzini Digitali');
   }
   else if($ambiente_applicativo =='esercizio')
   {
       $mail = init_phpmailer("smtp.gmail.com", 587, 'tls', 'magazzinidigitalitest@gmail.com', 'umXj01Z&2qw#Bign', 'magazzinidigitalitest@gmail.com', 'Magazzini Digitali');
   }
   return $mail;
}


//  
?>