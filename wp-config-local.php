<?php

/**28/05/2021 */

/** file di configurazione Maggazini digitali per ambiente di sviluppo locale **/



/** Nome Ambiente */
define( 'AMBIENTE_APPLICATIVO', 'locale' );


/** Database MD locale**/
define( 'DB_HOST_MD', 'localhost' );
define( 'DB_NAME_MD', 'md' );
define( 'DB_USER_MD', 'newuser' );
define( 'DB_PASSWORD_MD', 'password' );



/** Database NBN locale**/
define( 'DB_HOST_MD', 'localhost' );
define( 'DB_NAME_MD', 'md' );
define( 'DB_USER_MD', 'newuser' );
define( 'DB_PASSWORD_MD', 'password' );



/** Database Harvest locale**/
define( 'DB_HOST_HARVEST', 'localhost' );
define( 'DB_NAME_HARVEST', 'md' );
define( 'DB_USER_HARVEST', 'newuser' );
define( 'DB_PASSWORD_HARVEST', 'password' );




define('SOAP_CLIENT_AUTH_SW_LOCALE','http://192.168.254.159:8080/MagazziniDigitaliServices/services/AuthenticationSoftwarePort?wsdl');

define('SOAP_CLIENT_AUTH_CHK_LOCALE','http://192.168.254.159:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl');

define('SOAP_CLIENT_INI_S_LOCALE','http://192.168.254.159:8080/MagazziniDigitaliServices/services/InitSendMDPort?wsdl');

define('SOAP_CLIENT_END_S_LOCALE','http://192.168.254.159:8080/MagazziniDigitaliServices/services/EndSendMDPort?wsdl');

?>