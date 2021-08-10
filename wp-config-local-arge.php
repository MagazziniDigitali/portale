<?php

/**28/05/2021 */

/** file di configurazione Maggazini digitali per ambiente di sviluppo locale **/



/** Nome Ambiente */
define( 'AMBIENTE_APPLICATIVO', 'local' );


/** Database MD locale**/
define( 'DB_HOST_MD', 'localhost' );
define( 'DB_NAME_MD', 'MagazziniDigitali3_Locale' );
define( 'DB_USER_MD', 'md' );
define( 'DB_PASSWORD_MD', 'md_pwd' );



/** Database NBN locale**/
define( 'DB_HOST_NBN', 'localhost' );
define( 'DB_NAME_NBN', 'nbn' );
define( 'DB_USER_NBN', 'nbn' );
define( 'DB_PASSWORD_NBN', 'AeTh0poo' );



/** Database Harvest locale**/
define( 'DB_HOST_HARVEST', 'localhost' );
define( 'DB_NAME_HARVEST', 'harvest' );
define( 'DB_USER_HARVEST', 'md' );
define( 'DB_PASSWORD_HARVEST', 'md_pwd' );


define('SOAP_CLIENT_AUTH_SW_LOCALE','http://localhost:8080/MagazziniDigitaliServices/services/AuthenticationSoftwarePort?wsdl');
define('SOAP_CLIENT_AUTH_CHK_LOCALE','http://localhost:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl');
define('SOAP_CLIENT_INI_S_LOCALE','http://localhost:8080/MagazziniDigitaliServices/services/InitSendMDPort?wsdl');
define('SOAP_CLIENT_END_S_LOCALE','http://localhost:8080/MagazziniDigitaliServices/services/EndSendMDPort?wsdl');

?>

