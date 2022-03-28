<?php

/**28/05/2021 */

/** file di configurazione Maggazini digitali per ambiente di sviluppo collaudo **/




/** Nome Ambiente */

define( 'AMBIENTE_APPLICATIVO', 'collaudo' );



$db_server='192.168.254.159';


// WORDPRESS
// ------------------
// ** Impostazioni MySQL - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define( 'DB_NAME', 'new_bncf' );

/** Nome utente del database MySQL */
define( 'DB_USER', 'md' );

/** Password del database MySQL */
define( 'DB_PASSWORD', 'md_pwd' );

/** Hostname MySQL  */
define( 'DB_HOST', $db_server );

/** Charset del Database da utilizzare nella creazione delle tabelle. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Il tipo di Collazione del Database. Da non modificare se non si ha idea di cosa sia. */
define('DB_COLLATE', '');



/** Database MD Collaudo**/
define( 'DB_HOST_MD', 'localhost' );
define( 'DB_NAME_MD', 'MagazziniDigitali3_Collaudo' );
define( 'DB_USER_MD', 'md' );
define( 'DB_PASSWORD_MD', 'md_pwd' );

/** Database NBN Collaudo**/
define( 'DB_HOST_NBN', 'localhost' );
define( 'DB_NAME_NBN', 'nbn' );
define( 'DB_USER_NBN', 'md' );
define( 'DB_PASSWORD_NBN', 'md_pwd' );

/** Database Harvest Collaudo**/
define( 'DB_HOST_HARVEST', 'localhost' );
define( 'DB_NAME_HARVEST', 'harvest' );
define( 'DB_USER_HARVEST', 'md' );
define( 'DB_PASSWORD_HARVEST', 'md_pwd' );


define('SOAP_CLIENT_AUTH_SW_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/AuthenticationSoftwarePort?wsdl');
define('SOAP_CLIENT_AUTH_CHK_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl');
define('SOAP_CLIENT_INI_S_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/InitSendMDPort?wsdl');
define('SOAP_CLIENT_END_S_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/EndSendMDPort?wsdl');

?>