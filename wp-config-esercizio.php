<?php

/**28/05/2021 */

/** file di configurazione Maggazini digitali per ambiente di sviluppo esercizio **/



/** Nome Ambiente */

define( 'AMBIENTE_APPLICATIVO', 'esercizio' );


/** Database MD Esercizio**/
define( 'DB_HOST_MD', 'localhost' );
define( 'DB_NAME_MD', 'MagazziniDigitali3' );
define( 'DB_USER_MD', 'md_ese' );
define( 'DB_PASSWORD_MD', 'md_ese_pwd_2021' );



/** Database NBN Esercizio**/
define( 'DB_HOST_NBN', 'localhost' );
define( 'DB_NAME_NBN', 'nbn' );
define( 'DB_USER_NBN', 'md_ese' );
define( 'DB_PASSWORD_NBN', 'md_ese_pwd_2021' );



/** Database Harvest Esercizio**/
define( 'DB_HOST_HARVEST', 'localhost' );
define( 'DB_NAME_HARVEST', 'harvest' );
define( 'DB_USER_HARVEST', 'md_ese' );
define( 'DB_PASSWORD_HARVEST', 'md_ese_pwd_2021' );



define('SOAP_CLIENT_AUTH_SW_ESERCIZIO','http://localhost:8080/MagazziniDigitaliServices/services/AuthenticationSoftwarePort?wsdl');
define('SOAP_CLIENT_AUTH_CHK_ESERCIZIO','http://localhost:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl');
define('SOAP_CLIENT_INI_S_ESERCIZIO','http://localhost/MagazziniDigitaliServices/services/InitSendMDPort?wsdl');
define('SOAP_CLIENT_END_S_ESERCIZIO','http://localhost/MagazziniDigitaliServices/services/EndSendMDPort?wsdl');

?>