<?php

/** 28/05/2021 */

/** file di configurazione Maggazini digitali per ambiente di esercizio **/
/** Nome Ambiente */

define( 'AMBIENTE_APPLICATIVO', 'esercizio' );
$db_server='192.168.7.83';


// WORDPRESS
// ------------------
define( 'DB_NAME', 'wp_portale' );

/** Nome utente del database MySQL */
define( 'DB_USER', 'md_ese' );

/** Password del database MySQL */
define( 'DB_PASSWORD', 'md_ese_pwd_2021' );

/** Hostname MySQL  */
define( 'DB_HOST', $db_server );

/** Charset del Database da utilizzare nella creazione delle tabelle. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Il tipo di Collazione del Database. Da non modificare se non si ha idea di cosa sia. */
define('DB_COLLATE', '');



// MAGAZZINI DIGITALI
// ------------------

/** Database MD Esercizio**/
define( 'DB_HOST_MD', $db_server );
define( 'DB_NAME_MD', 'MagazziniDigitali3' );
define( 'DB_USER_MD', 'md_ese' );
define( 'DB_PASSWORD_MD', 'md_ese_pwd_2021' );

/** Database NBN Esercizio**/
define( 'DB_HOST_NBN', $db_server );
define( 'DB_NAME_NBN', 'nbn' );
define( 'DB_USER_NBN', 'md_ese' );
define( 'DB_PASSWORD_NBN', 'md_ese_pwd_2021' );


/** Database Harvest Esercizio**/
define( 'DB_HOST_HARVEST', $db_server );
define( 'DB_NAME_HARVEST', 'harvest' );
define( 'DB_USER_HARVEST', 'md_ese' );
define( 'DB_PASSWORD_HARVEST', 'md_ese_pwd_2021' );


/** Web Services **/
define('SOAP_CLIENT_AUTH_SW_ESERCIZIO','http://localhost:8080/MagazziniDigitaliServices/services/AuthenticationSoftwarePort?wsdl');
define('SOAP_CLIENT_AUTH_CHK_ESERCIZIO','http://localhost:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl');
define('SOAP_CLIENT_INI_S_ESERCIZIO','http://localhost:8080/MagazziniDigitaliServices/services/InitSendMDPort?wsdl');
define('SOAP_CLIENT_END_S_ESERCIZIO','http://localhost:8080/MagazziniDigitaliServices/services/EndSendMDPort?wsdl');

?>
