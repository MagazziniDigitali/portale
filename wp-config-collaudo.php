<?php

/**28/05/2021 */

/** file di configurazione Maggazini digitali per ambiente di sviluppo collaudo **/




/** Nome Ambiente */

define( 'AMBIENTE_APPLICATIVO', 'collaudo' );

/** Database MD Collaudo**/
define( 'DB_HOST_MD', 'localhost' );
define( 'DB_NAME_MD', 'MagazziniDigitali3_Collaudo' );
define( 'DB_USER_MD', 'md' );
define( 'DB_PASSWORD_MD', 'md_pwd' );


/** Database NBN Collaudo**/
define( 'DB_HOST_MD', 'localhost' );
define( 'DB_NAME_MD', 'nbn' );
define( 'DB_USER_MD', 'md' );
define( 'DB_PASSWORD_MD', 'md_pwd' );


/** Database Harvest Collaudo**/
define( 'DB_HOST_MD', 'localhost' );
define( 'DB_NAME_MD', 'harvest' );
define( 'DB_USER_MD', 'md' );
define( 'DB_PASSWORD_MD', 'md_pwd' );


 define('SOAP_CLIENT_AUTH_SW_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/AuthenticationSoftwarePort?wsdl');

 define('SOAP_CLIENT_AUTH_CHK_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl');

 define('SOAP_CLIENT_INI_S_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/InitSendMDPort?wsdl');

 define('SOAP_CLIENT_END_S_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/EndSendMDPort?wsdl');

?>