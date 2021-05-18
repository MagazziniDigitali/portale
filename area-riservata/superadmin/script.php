<?php
require("../wp-load.php");
require("./src/functions.php");

      if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

$dbMD = connect_to_md();

$joinPrepare = $dbMD->prepare(
    'SELECT 
        MDIstituzione.LOGIN as loginIst, 
        MDIstituzione.ID as idIst
    FROM MDIstituzione LEFT JOIN MDUtenti 
    ON MDIstituzione.ID = MDUtenti.ID_ISTITUZIONE 
    WHERE MDUtenti.ID_ISTITUZIONE IS NULL 
    ORDER BY MDIstituzione.LOGIN ASC'
);

$join = $dbMD->get_results($joinPrepare);

foreach($join as $key=>$results) {

    $uuidIstituzione            = $results->idIst;
    $login                      = $results->loginIst;

    $newUuidIstituzione         = generate_uuid($dbMD);

    $password                   = generateRandomString();
    $password                   = generate_sha_pwd($dbMD, $password);

    $uuidUser                   = generate_uuid($dbMD);
    $uuidUser                  .= '-F';
    $cognome                    = 'Cognome';
    $nome                       = 'Nome';
    $codiceFiscale              = 'CF' . $key;
    $email                      = '';

    $ipAutorizzati              = '*.*.*.*.';

    $admin                      = 1;
    $superadmin                 = 0;


    $updateIstituzione = $dbMD->update(
        'MDIstituzione',
        array(
            'ID'                    => $newUuidIstituzione,
            'PASSWORD'              => $password,
            'IP_AUTORIZZATI'        => $ipAutorizzati
        ),
        array(
            'ID'                    => $uuidIstituzione
        )
    );

    $user = insert_new_user($dbMD, $uuidUser, $login, $password, $cognome, $nome, $codiceFiscale, $email, $admin, $superadmin, $ipAutorizzati, $newUuidIstituzione);

}