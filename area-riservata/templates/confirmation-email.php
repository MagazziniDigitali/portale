<?php

    $link =    "http://" . $_SERVER['HTTP_HOST'] ."/area-riservata/istituzione/confirm-email?token=" . $encryptedUuid;
    $body = '<h1>Conferma Registrazione</h1>';
    $body .= '<p>Grazie per esserti registrato!</p>';
    $body .= '<p><a href="'. $link . '">Clicca qui</a> per confermare la e-mail inserita</p>';

?>