<?php
/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file viene utilizzato, durante l’installazione, dallo script
 * di creazione di wp-config.php. Non è necessario utilizzarlo solo via web
 * puoi copiare questo file in «wp-config.php» e riempire i valori corretti.
 *
 * Questo file definisce le seguenti configurazioni:
 *
 * * Impostazioni MySQL
 * * Chiavi Segrete
 * * Prefisso Tabella
 * * ABSPATH
 *
 * * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Impostazioni MySQL - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/var/www/html/local/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'new_bncf' );

/** Nome utente del database MySQL */
define( 'DB_USER', 'newuser' );

/** Password del database MySQL */
define( 'DB_PASSWORD', 'password' );

/** Hostname MySQL  */
define( 'DB_HOST', 'localhost' );

/** Charset del Database da utilizzare nella creazione delle tabelle. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Il tipo di Collazione del Database. Da non modificare se non si ha idea di cosa sia. */
define('DB_COLLATE', '');





/**#@+

/** Nome Ambiente */
define( 'AMBIENTE_APPLICATIVO', 'locale' );
/** Nome Ambiente Collaudo */
//define( 'AMBIENTE_APPLICATIVO', 'collaudo' );
/** Nome Ambiente Esercizio */
//define( 'AMBIENTE_APPLICATIVO', 'esercizio' );

define('SOAP_CLIENT_AUTH_SW_LOCALE','http://192.168.254.159:8080/MagazziniDigitaliServices/services/AuthenticationSoftwarePort?wsdl');

// define('SOAP_CLIENT_AUTH_SW_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/AuthenticationSoftwarePort?wsdl');

// define('SOAP_CLIENT_AUTH_SW_ESERCIZIO','http://localhost:8080/MagazziniDigitaliServices/services/AuthenticationSoftwarePort?wsdl');

define('SOAP_CLIENT_AUTH_CHK_LOCALE','http://192.168.254.159:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl');

// define('SOAP_CLIENT_AUTH_CHK_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl');

// define('SOAP_CLIENT_AUTH_CHK_ESERCIZIO','http://localhost:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl');

define('SOAP_CLIENT_INI_S_LOCALE','http://192.168.254.159:8080/MagazziniDigitaliServices/services/InitSendMDPort?wsdl');

// define('SOAP_CLIENT_INI_S_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/InitSendMDPort?wsdl');

// define('SOAP_CLIENT_INI_S_ESERCIZIO','http://localhost/MagazziniDigitaliServices/services/InitSendMDPort?wsdl');

define('SOAP_CLIENT_END_S_LOCALE','http://192.168.254.159:8080/MagazziniDigitaliServices/services/EndSendMDPort?wsdl');

// define('SOAP_CLIENT_END_S_COLLAUDO','http://192.168.254.159:8080/MagazziniDigitaliServices/services/EndSendMDPort?wsdl');

// define('SOAP_CLIENT_END_S_ESERCIZIO','http://localhost/MagazziniDigitaliServices/services/EndSendMDPort?wsdl');

/**#@+
 * Chiavi Univoche di Autenticazione e di Salatura.
 *
 * Modificarle con frasi univoche differenti!
 * È possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 * È possibile cambiare queste chiavi in qualsiasi momento, per invalidare tuttii cookie esistenti. Ciò forzerà tutti gli utenti ad effettuare nuovamente il login.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '-BGfwASFM+wGD#Yo*5_Fz@d$ ONeR^@!>v!Q5dH5$(t0T{Hn}0&Wu38vn:k/IRl~' );
define( 'SECURE_AUTH_KEY',  '`E<l#_:OtP)zsLbtR0*ibe>SL`=mb3[S%%%hZ1PdI9n-8N2jeI@r_-:w92ZF*N@%' );
define( 'LOGGED_IN_KEY',    'mptTf`Y:hs7/2m7r:U{`upNGk#Sn<;&(323J`1;^CL.[@UH6O8!g7/hw9IP`h}Tj' );
define( 'NONCE_KEY',        '!A<q,Ib1APOgYA%f8+R4Cn#U1l/scboNV/(Dx7S(Wt!|Wxz2{[1:Kc>O}f0.vr>E' );
define( 'AUTH_SALT',        'Q.(}.5aaU]sy2bRVS/<T7~%;4WlUppL`;LpL,! vI/=->Cpt7Tl>al5KU#`n;Y6b' );
define( 'SECURE_AUTH_SALT', 'MyxF+/1*(JP|HB5T#%Mlt=Q-I-n%M?uQ>+|In91JuD8DXBs:n6I>jrRS<h!JIp]Z' );
define( 'LOGGED_IN_SALT',   'T0X(U0GmD8{,5+!n#^;BF}U(6kewSvaeGP7%XWQ?2Z>85kIK[ }R{fvAhjG!F ]d' );
define( 'NONCE_SALT',       '93uGXv6Za1=6BiVN=~=?ObC1QuFnr%*@ke$0wDsI@Azj(Z_UK,52-xU-nsz*Vw+A' );

/**#@-*/

/**
 * Prefisso Tabella del Database WordPress.
 *
 * È possibile avere installazioni multiple su di un unico database
 * fornendo a ciascuna installazione un prefisso univoco.
 * Solo numeri, lettere e sottolineatura!
 */
$table_prefix = 'wp_';

/**
 * Per gli sviluppatori: modalità di debug di WordPress.
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi durante lo sviluppo
 * È fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all’interno dei loro ambienti di sviluppo.
 *
 * Per informazioni sulle altre costanti che possono essere utilizzate per il debug,
 * leggi la documentazione
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', true);

/* Finito, interrompere le modifiche! Buon blogging. */

/** Path assoluto alla directory di WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Imposta le variabili di WordPress ed include i file. */
require_once(ABSPATH . 'wp-settings.php');	

define('FS_METHOD','direct');