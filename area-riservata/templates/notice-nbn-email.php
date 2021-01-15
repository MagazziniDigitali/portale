<?php

    $body = '<h1>Nuovo utente NBN</h1>';
    $body .= '<p>Inserire il seguente utente nell\'NBN password Basic</p>';

    if($tesiUserApiNBN == '' && $tesiPwdApiNBN == ''){
        $body .= '<p><strong>username</strong>: ' . $journalUserApiNBN . '</p>';
        $body .= '<p><strong>password</strong>: '. $journalPwdApiNBN . '</p>';
    } else {
        $body .= '<p><strong>username</strong>: ' . $tesiUserApiNBN . '</p>';
        $body .= '<p><strong>password</strong>: '. $tesiPwdApiNBN . '</p>';
    }
    
?>
