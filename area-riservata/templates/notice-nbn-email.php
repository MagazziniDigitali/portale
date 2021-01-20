<?php

    $body = '<h1>Nuovo utente NBN</h1>';
    $body .= '<p>Inserire il seguente utente nell\'NBN password Basic</p>';

    if($tesiUserApiNBN == '' && $tesiPwdApiNBN == '' && $bookUserApiNBN == '' && $bookPwdApiNBN == ''){
        $body .= '<p><strong>username</strong>: ' . $journalUserApiNBN . '</p>';
        $body .= '<p><strong>password</strong>: '. $journalPwdApiNBN . '</p>';
    } elseif($tesiUserApiNBN == '' && $tesiPwdApiNBN == '' && $journalUserApiNBN == '' && $journalPwdApiNBN == ''){
        $body .= '<p><strong>username</strong>: ' . $bookUserApiNBN . '</p>';
        $body .= '<p><strong>password</strong>: '. $bookPwdApiNBN . '</p>';
    } elseif($bookUserApiNBN == '' && $bookPwdApiNBN == '' && $journalUserApiNBN == '' && $journalPwdApiNBN == ''){
        $body .= '<p><strong>username</strong>: ' . $tesiUserApiNBN . '</p>';
        $body .= '<p><strong>password</strong>: '. $tesiPwdApiNBN . '</p>';
    }
    
?>
