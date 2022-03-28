<?php

/**28/03/2022 */

/** TEMPLATE file di configurazione Maggazini digitali per ambiente di sviluppo local **/

/** Nome Ambiente */

define( 'AMBIENTE_APPLICATIVO', 'local' );

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



/** Database MD local**/
define( 'DB_HOST_MD', $db_server );
define( 'DB_NAME_MD', 'db_MD_name_local' );
define( 'DB_USER_MD', 'db_MD_user_local' );
define( 'DB_PASSWORD_MD', 'db_MD_password_local' );

/** Database NBN local**/
define( 'DB_HOST_NBN', $db_server );
define( 'DB_NAME_NBN', 'db_NBN_name_local' );
define( 'DB_USER_NBN', 'db_NBN_user_local' );
define( 'DB_PASSWORD_NBN', 'db_NBN_password_local' );

/** Database Harvest local**/
define( 'DB_HOST_HARVEST', $db_server );
define( 'DB_NAME_HARVEST', 'db_HARVEST_name_local' );
define( 'DB_USER_HARVEST', 'db_NBN_user_local' );
define( 'DB_PASSWORD_HARVEST', 'db_NBN_password_local' );


define('SOAP_CLIENT_AUTH_SW_local','http://localhost:8080/MagazziniDigitaliServices/services/AuthenticationSoftwarePort?wsdl');
define('SOAP_CLIENT_AUTH_CHK_local','http://localhost:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl');
define('SOAP_CLIENT_INI_S_local','http://localhost:8080/MagazziniDigitaliServices/services/InitSendMDPort?wsdl');
define('SOAP_CLIENT_END_S_local','http://localhost:8080/MagazziniDigitaliServices/services/EndSendMDPort?wsdl');

?>