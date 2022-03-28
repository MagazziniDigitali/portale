<?php

/**28/03/2022 */

/** TEMPLATE file di configurazione Maggazini digitali per ambiente di sviluppo collaudo **/

/** Nome Ambiente */

define( 'AMBIENTE_APPLICATIVO', 'collaudo' );

$db_server='127.0.0.1';


// WORDPRESS
// ------------------
// ** Impostazioni MySQL - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define( 'DB_NAME', 'db_name' );

/** Nome utente del database MySQL */
define( 'DB_USER', 'db-user' );

/** Password del database MySQL */
define( 'DB_PASSWORD', 'db_password' );

/** Hostname MySQL  */
define( 'DB_HOST', $db_server );

/** Charset del Database da utilizzare nella creazione delle tabelle. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Il tipo di Collazione del Database. Da non modificare se non si ha idea di cosa sia. */
define('DB_COLLATE', '');



/** Database MD Collaudo**/
define( 'DB_HOST_MD', $db_server );
define( 'DB_NAME_MD', 'db_MD_name_collaudo' );
define( 'DB_USER_MD', 'db_MD_user_collaudo' );
define( 'DB_PASSWORD_MD', 'db_MD_password_collaudo' );

/** Database NBN Collaudo**/
define( 'DB_HOST_NBN', $db_server );
define( 'DB_NAME_NBN', 'db_NBN_name_collaudo' );
define( 'DB_USER_NBN', 'db_NBN_user_collaudo' );
define( 'DB_PASSWORD_NBN', 'db_NBN_password_collaudo' );

/** Database Harvest Collaudo**/
define( 'DB_HOST_HARVEST', $db_server );
define( 'DB_NAME_HARVEST', 'db_HARVEST_name_collaudo' );
define( 'DB_USER_HARVEST', 'db_NBN_user_collaudo' );
define( 'DB_PASSWORD_HARVEST', 'db_NBN_password_collaudo' );


define('SOAP_CLIENT_AUTH_SW_COLLAUDO','http://localhost:8080/MagazziniDigitaliServices/services/AuthenticationSoftwarePort?wsdl');
define('SOAP_CLIENT_AUTH_CHK_COLLAUDO','http://localhost:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl');
define('SOAP_CLIENT_INI_S_COLLAUDO','http://localhost:8080/MagazziniDigitaliServices/services/InitSendMDPort?wsdl');
define('SOAP_CLIENT_END_S_COLLAUDO','http://localhost:8080/MagazziniDigitaliServices/services/EndSendMDPort?wsdl');

?>