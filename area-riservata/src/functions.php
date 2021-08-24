<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'send-email/Exception.php';
require 'send-email/PHPMailer.php';
require 'send-email/SMTP.php';
require 'mailer-parm.php';//hassan vado a includele  il modulo mailer-local per mandare le mail tramite mailtrap

function check_db_error($db){

    $error = $db->last_error;
    $last_query = $db->last_query;        

    return $error;
}
    
function connect_to_md(){
    //$dbMD = new wpdb('newuser','password','md','localhost');
    $dbMD = new wpdb(DB_USER_MD,DB_PASSWORD_MD,DB_NAME_MD,DB_HOST_MD);
    return $dbMD;
}

function connect_to_harvest(){
  //  $dbHarvest = new wpdb('newuser','password','harvest','localhost');
    $dbHarvest = new wpdb(DB_USER_HARVEST,DB_PASSWORD_HARVEST,DB_NAME_HARVEST,DB_HOST_HARVEST);
    return $dbHarvest;
}

function connect_to_nbn(){
  //  $dbNBN = new wpdb('newuser','password','nbn','localhost');
    $dbNBN = new wpdb(DB_USER_NBN,DB_PASSWORD_NBN,DB_NAME_NBN,DB_HOST_NBN);
    return $dbNBN;
}

function init_phpmailer($host, $port, $secure, $username, $password, $sendFromEmail, $sendFromName) {
    $mail = new PHPMailer;
    $mail->isSMTP(); 
    $mail->SMTPDebug = 0;
    $mail->Host = $host;
    $mail->Port = $port;
    $mail->SMTPSecure = $secure;
    $mail->SMTPAuth = true;
    $mail->Username = $username;
    $mail->Password = $password;
    $mail->setFrom($sendFromEmail, $sendFromName);

    return $mail;
}

function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
        else unlink("$dir/$file");
    }
    rmdir($dir);
}

function prepareEncryptDecrypt() {
    $secretKey = 'k03B!$RUKyf29tB8$gwU98$sx';
    $secretIv  = '*i5cEtrTY7y3^#DParP%eib&T';

    $key = hash('sha256', $secretKey);
    $iv  = substr(hash('sha256', $secretIv), 0, 16);

    return [$key, $iv]; 
}

function encrypt_string($string) {
    $secretKey = 'k03B!$RUKyf29tB8$gwU98$sx';
    $secretIv  = '*i5cEtrTY7y3^#DParP%eib&T'; 
    $method    = 'AES-256-CBC';

    $keyIv = prepareEncryptDecrypt();
    return base64_encode(openssl_encrypt($string, $method, $keyIv[0], 0, $keyIv[1]));
}

function decrypt_string($string) {
    $secretKey = 'k03B!$RUKyf29tB8$gwU98$sx';
    $secretIv  = '*i5cEtrTY7y3^#DParP%eib&T'; 
    $method    = 'AES-256-CBC';

    $keyIv = prepareEncryptDecrypt();
    return openssl_decrypt(base64_decode($string), $method, $keyIv[0], 0, $keyIv[1]);
}

function generate_uuid($dbMD){

    $uuidPrepared = $dbMD->get_row("SELECT UUID() AS uuid");
    $uuid = $uuidPrepared->uuid;

    return $uuid;
}

function generate_sha_pwd($dbMD, $string){

    $preparedQuery = $dbMD->prepare("SELECT SHA2('%s', 256) AS pass", $string);
    $result = $dbMD->get_results($preparedQuery);

    $hashedPwd = $result[0]->pass;

    return $hashedPwd;
}

function estimate_progressive($dbMD){
    $progressivePrepared = $dbMD->get_row("SELECT MAX(PROGRESSIVO) AS 'MaximumValue' FROM MDPreRegistrazione");
    $progressive = intval($progressivePrepared->MaximumValue);

    return $progressive;
}

function redirect_if_not_logged_in(){
    if (!$_SESSION['role']){
        header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/area-riservata/login");
        die();
    }
}

function redirect_if_logged_in(){

    if (!empty($_SESSION)) {

    if($_SESSION['role'] == 'superadmin') {
        header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/area-riservata/admin/");
        die();
    } elseif($_SESSION['role'] == 'admin_istituzione') {
        header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/area-riservata/istituzione/");
        die();
    } elseif($_SESSION['role'] == 'user_istituzione') {
        header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/area-riservata/user/");
        die();
    }
    
    }
}

function retrieve_regions($dbMD) {
    $regions = $dbMD->get_results("SELECT ID, NOMEREGIONE FROM regioni WHERE NOMEREGIONE IS NOT NULL");
    return $regions;
}

function retrieve_all_istituzioni_id_login($dbMD) {
    $istituzioni = $dbMD->get_results("SELECT ID, LOGIN FROM MDIstituzione;");
    return $istituzioni;
}

function retrieve_login_istituzione($dbMD, $uuid){

    $preparedQuery = $dbMD->prepare("SELECT LOGIN, NOME FROM MDIstituzione WHERE ID='%s'", $uuid);
    $login = $dbMD->get_results($preparedQuery);

    return $login;
}

function retrieve_user_for_login($dbMD, $username, $password){

    $preparedQuery = $dbMD->prepare("SELECT * FROM MDUtenti WHERE LOGIN='%s' AND PASSWORD=SHA2('%s', 256) LIMIT 1", $username, $password);
    $user = $dbMD->get_results($preparedQuery);

    return $user;
}

function retrieve_user_by_id_istituzione($dbMD, $id){

    $preparedQuery = $dbMD->prepare("SELECT * FROM MDUtenti WHERE SUPERADMIN <> '%d' AND SUPERADMIN <> '%d' AND ID_ISTITUZIONE='%s' ORDER BY AMMINISTRATORE DESC", 1, 2, $id);
    $user = $dbMD->get_results($preparedQuery);

    return $user;
}

function retrieve_amministratore_by_id_istituzione($dbMD, $id){

    $preparedQuery = $dbMD->prepare("SELECT * FROM MDUtenti WHERE SUPERADMIN <> '%d' AND SUPERADMIN <> '%d' AND AMMINISTRATORE ='%d' AND ID_ISTITUZIONE='%s'  ORDER BY AMMINISTRATORE DESC", 1, 2,1, $id);
    $user = $dbMD->get_results($preparedQuery);

    return $user;
}

function retrieve_user_by_id($dbMD, $id){

    $preparedQuery = $dbMD->prepare("SELECT * FROM MDUtenti WHERE SUPERADMIN <> '%d' AND SUPERADMIN <> '%d' AND ID='%s' ORDER BY AMMINISTRATORE DESC", 1, 2, $id);
    $user = $dbMD->get_results($preparedQuery);

    return $user;
}

function change_role($dbMD, $encryptedUUID, $admin){

    $uuidDecrypted = decrypt_string($encryptedUUID);

    if ($admin == 1) {

        $newUuidDecrypted = $uuidDecrypted . '-F';

        $updateDB = $dbMD->update(
            'MDUtenti',
            array(
                'AMMINISTRATORE'    => $admin,
                'ID'                => $newUuidDecrypted
            ),
            array(
                'ID'                => $uuidDecrypted
            )
        );
    } else {

        $updateDB = $dbMD->update(
            'MDUtenti',
            array(
                'AMMINISTRATORE'    => $admin
            ),
            array(
                'ID'                => $uuidDecrypted
            )
        );

    }

}

function select_gestore($dbMD, $idIstituzione){

    $preparedQuery = $dbMD->prepare("SELECT ID, AMMINISTRATORE FROM MDUtenti WHERE ID_ISTITUZIONE='%s' AND AMMINISTRATORE='%d' AND SUPERADMIN='%d';", $idIstituzione, 1, 0);
    $user = $dbMD->get_results($preparedQuery);

    return $user;

}

function retrieve_sid(){
//getenv ==> da testare
$md_env =getenv('AMBIENTE_APPLICATIVO');
   // $md_env = apache_getenv('MD_ENVIRONMENT');

    if ($md_env == 'collaudo') {

        $sid = "memc.sess." . session_id();

    } else {
        
        $sid = "memc.sess.key." . session_id();

    }

    return $sid;
}

function retrieve_memcached_session_variables($sid){

    $mc = new Memcached();
    $mc->addServer("localhost", 11211);
    
    $mcSession = $mc->get($sid);

    return $mcSession;

}

function retrieve_ip_logged_user(){

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

        $ip = $_SERVER['HTTP_CLIENT_IP'];

    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        
    } else {

        $ip = $_SERVER['REMOTE_ADDR'];
        
    }

    return $ip;

}

function do_login($dbMD, $user){

    session_regenerate_id(true);

    $userID             = $user[0]->ID;
    $username           = $user[0]->LOGIN;
    $admin              = $user[0]->AMMINISTRATORE;
    $superadmin         = $user[0]->SUPERADMIN;
    $name               = $user[0]->NOME;
    $surname            = $user[0]->COGNOME;
    $istUUID            = $user[0]->ID_ISTITUZIONE;
    $ip                 = retrieve_ip_logged_user();
    $istituzione        = retrieve_login_istituzione($dbMD, $istUUID);

    $istituzioneLong    = $istituzione[0]->NOME;

    $ebook = check_if_istituzione_signed_for_service($dbMD, $istUUID, 'eb');

    $_SESSION['username']           = $username;
    $_SESSION['name']               = $name;
    $_SESSION['surname']            = $surname;
    $_SESSION['IP']                 = $ip;
    $_SESSION['istituzione']        = $istituzioneLong;
    $_SESSION['uuidIst']            = $istUUID;

    if($ebook){
        $_SESSION['ebook']          = 'y';
    } else {
        $_SESSION['ebook']          = 'n';
    }

    $stickyBit = substr($userID, -2);

    if ($superadmin == 1 && $admin == 0){

        $_SESSION['role'] = 'superadmin';

        if ($stickyBit == '-F'){

            $encryptedUUID = encrypt_string($userID);
            header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/area-riservata/first-access?token=" . $encryptedUUID);
            exit();
            
        } else {

            header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/area-riservata/admin/");
            exit();
            
        }

    } elseif ($superadmin == 0 && $admin == 1){

        $_SESSION['role'] = 'admin_istituzione';

        if ($stickyBit == '-F'){

            $encryptedUUID = encrypt_string($userID);
            header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/area-riservata/first-access?token=" . $encryptedUUID);
            exit();
            
        } else {

            header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/area-riservata/istituzione/");
            exit();

        }

    } elseif ($superadmin == 0 && $admin == 0){

        $_SESSION['role'] = 'user_istituzione';

        if ($stickyBit == '-F'){

            $encryptedUUID = encrypt_string($userID);
            header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/area-riservata/first-access?token=" . $encryptedUUID);
            exit();
            
        } else {

            header("Location: " . "http://" . $_SERVER['HTTP_HOST'] .  "/area-riservata/user/");
            exit();
            
        }

    }
    
}

function do_logout(){

    $destroy = session_destroy();
    $unset = session_unset();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/area-riservata/login");

}

function do_signup($dbMD, $uuid, $istitutoPiva, $istitutoPassword, $istitutoNome, $istitutoIndirizzo, $istitutoTelefono, $istitutoNomeContatto, $istitutoNote, $istitutoUrl, $istitutoRegione, $utenteCognome, $utenteNome, $utenteCodiceFiscale, $utenteEmail) {

    $progessivo = estimate_progressive($dbMD);
    $progessivo += 1;

    $altaRisoluzione = 0;
    $tesiDottorato = 0;
    $checkidfase = 'attesa validazione';

    $insertPreReg = $dbMD->insert(
        'MDPreRegistrazione',
        array(
            'ID'                               => $uuid,
            'PROGRESSIVO'                      => $progessivo,
            'ISTITUZIONE_NOME'                 => $istitutoNome,
            'ISTITUZIONE_INDIRIZZO'            => $istitutoIndirizzo,
            'ISTITUZIONE_TELEFONO'             => $istitutoTelefono,
            'ISTITUZIONE_NOME_CONTATTO'        => $istitutoNomeContatto,
            'ISTITUZIONE_NOTE'                 => $istitutoNote,
            'ISTITUZIONE_URL'                  => $istitutoUrl,
            'ISTITUZIONE_PIVA'                 => $istitutoPiva,
            'UTENTE_COGNOME'                   => $utenteCognome,
            'UTENTE_NOME'                      => $utenteNome,
            'UTENTE_CODICEFISCALE'             => $utenteCodiceFiscale,
            'UTENTE_EMAIL'                     => $utenteEmail,
            'ID_REGIONE'                       => $istitutoRegione,
            'ALTA_RISOLUZIONE'                 => $altaRisoluzione,
            'TESI_DOTTORATO'                   => $tesiDottorato,
            'CHECKIDFASE'                      => $checkidfase
        )
    );

    return $insertPreReg;

}



function signup_insert_check_errors($dbMD){
    
    $error = $dbMD->last_error;

    $duplicate = "Duplicate entry";

    $cannotAddRowForeign = "Cannot add or update a child row: a foreign key constraint fails";
    $regionValueNotPermitted = "FOREIGN KEY (`ID_REGIONE`) REFERENCES `regioni` (`ID`))";

    $uuidError = " 'MDPreRegistrazione.PRIMARY'";

    if (strpos($error, $cannotAddRowForeign) !== false && strpos($error, $regionValueNotPermitted) !== false){
        $errorMessage = "Valore per il campo regione non valido";
        return $errorMessage;
    }
    if (strpos($error, $duplicate) !== false && strpos($error, $uuidError) !== false){
        $errorMessage = "UUID già presente";
        return $errorMessage;
    }

}

function change_password_first_login($dbMD, $encryptedUUID, $password){

    $uuidDecrypted = decrypt_string($encryptedUUID);

    $stickyBit = substr($uuidDecrypted, -2);

    if ($stickyBit == '-F'){

        $uuid = rtrim($uuidDecrypted, '-F');

    }
    
    $updateDB = $dbMD->update(
        'MDUtenti',
        array(
            'ID'        => $uuid,
            'PASSWORD'  => $password
        ),
        array(
            'ID'        => $uuidDecrypted
        )
    );

    return $updateDB;

    
}

function reject_submission($dbMD, $uuid, $utenteEmail, $utenteNome, $utenteCognome){

    set_checkdifase_to_rejected($dbMD, $uuid);

    send_rejected_signup_email($utenteEmail, $utenteNome, $utenteCognome);
    
}

function check_istituzioni_to_be_approved($dbMD){

    $checkidfase = 'attesa validazione';

    $preparedQuery = $dbMD->prepare("SELECT COUNT(*) as count FROM MDPreRegistrazione WHERE EMAIL_VALIDATA=1 AND CHECKIDFASE='%s';", $checkidfase);
    $result = $dbMD->get_results($preparedQuery);

    $resultCount = intval($result[0]->count);

    return $resultCount;
}

function show_istituzioni_to_be_approved($dbMD){

    $checkidfase = 'attesa validazione';

    $preparedQuery = $dbMD->prepare("SELECT * FROM MDPreRegistrazione WHERE EMAIL_VALIDATA=1 AND CHECKIDFASE='%s';", $checkidfase);
    $result = $dbMD->get_results($preparedQuery);

    return $result;
}

function check_users_for_istituzione($dbMD){

    $usrSession = check_istituizone_session($dbMD);

    $admin      = 0;
    $superadmin = 0;

    $preparedQuery = $dbMD->prepare("SELECT COUNT(*) as count FROM MDUtenti WHERE AMMINISTRATORE='%s' AND SUPERADMIN='%s' AND ID_ISTITUZIONE='%s';", $admin, $superadmin, $usrSession);

    $result = $dbMD->get_results($preparedQuery);

    $resultCount = intval($result[0]->count);

    return $resultCount;
}

function show_users_for_istituzione($dbMD){

    $usrSession = check_istituizone_session($dbMD);

    $admin      = 0;
    $superadmin = 0;

    $preparedQuery = $dbMD->prepare("SELECT * FROM MDUtenti WHERE AMMINISTRATORE='%s' AND SUPERADMIN='%s' AND ID_ISTITUZIONE='%s';", 0, 0, $usrSession);
    $result = $dbMD->get_results($preparedQuery);

    return $result;

}

function check_user_exists($dbMD, $string){

    $preparedQuery = $dbMD->prepare("SELECT * FROM MDUtenti WHERE LOGIN='%s' OR EMAIL='%s';", $string, $string);
    $result = $dbMD->get_results($preparedQuery);

    return $result;

}

function check_login_istituzione($dbMD, $login){
    $preparedQuery = $dbMD->prepare("SELECT count(*) FROM MDIstituzione WHERE LOGIN='%s';", $login);
    $result = $dbMD->get_results($preparedQuery);
    foreach ($result as $value) {
        foreach ($value as $key => $val) {
            // echo $key;
            return $val;
        }
    }
    return $result;
}

function generateRandomString() {
    $length = 20;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function change_password($dbMD, $encryptedUUID, $password){

    $uuidDecrypted = decrypt_string($encryptedUUID);
    
    $updateDB = $dbMD->update(
        'MDUtenti',
        array(
            'PASSWORD'  => $password
        ),
        array(
            'ID'        => $uuidDecrypted
        )
    );

    return $updateDB;

}

function check_strong_password($password){

    $uppercase      = preg_match('@[A-Z]@', $password);
    $lowercase      = preg_match('@[a-z]@', $password);
    $number         = preg_match('@[0-9]@', $password);
    $specialChars   = preg_match('@[^\w]@', $password);

    if(!$uppercase){

        $alert = "La password deve contenere almeno un carattere maiuscolo";
        return $alert;

    } elseif (!$lowercase) {

        $alert = "La password deve contenere almeno un carattere minuscolo";
        return $alert;

    } elseif (!$number) {

        $alert = "La password deve contenere almeno un numero";
        return $alert;

    } elseif (!$specialChars) {

        $alert = "La password deve contenere almeno un carattere speciale";
        return $alert;

    } elseif (strlen($password) < 8) {
        
        $alert = "La password dev'essere lunga almeno 8 caratteri";
        return $alert;

    } else {
        return true;
    }
       
}

function check_user_session($dbMD){

    $usrSession = $_SESSION['username'];

    $query          = $dbMD->prepare("SELECT * FROM MDUtenti WHERE LOGIN='%s'", $usrSession);
    $user           = $dbMD->get_results($query);

    return $user;

}

function delete_user($dbMD, $encryptedUUID, $idIstituzione){

    $uuid    = decrypt_string($encryptedUUID);

    $query   = $dbMD->delete(
        'MDUtenti',
        array(
            'ID'                => $uuid,
            'ID_ISTITUZIONE'    => $idIstituzione
        )
    );

}

function update_user($dbMD, $encryptedUUID, $pwd, $cognome, $nome, $codiceFiscale, $email, $ipAutorizzati){

    $uuid = decrypt_string($encryptedUUID);

    $updateDB = $dbMD->update(
        'MDUtenti',
        array(
        'PASSWORD'                 => $pwd,
        'COGNOME'                  => $cognome,
        'NOME'                     => $nome,
        'CODICEFISCALE'            => $codiceFiscale,
        'EMAIL'                    => $email,
        'IP_AUTORIZZATI'           => $ipAutorizzati
        ),
        array(
            'ID'                   => $uuid
        )
    );

    if($updateDB){
        return $updateDB;
    } else {
        $error = $dbMD->show_errors;
        return $error;
    }
}

function check_istituizone_session($dbMD){

    $usrSession = $_SESSION['username'];

    $query          = $dbMD->prepare("SELECT ID_ISTITUZIONE FROM MDUtenti WHERE LOGIN='%s'", $usrSession);
    $idArray        = $dbMD->get_results($query);

    $idIstituzione = $idArray[0]->ID_ISTITUZIONE;

    return $idIstituzione;

}

function check_istituizone_PIVA($dbMD){

    $istSession = $_SESSION['istituzione'];

    $query          = $dbMD->prepare("SELECT PIVA FROM MDIstituzione WHERE NOME='%s'", $istSession);
    $idArray        = $dbMD->get_results($query);

    $pivaIstituzione = $idArray[0]->PIVA;

    return $pivaIstituzione;

}

function convertToReadableSize($size){
    $base = log($size) / log(1024);
    $suffix = array("", " KB", " MB", " GB", " TB");
    $f_base = floor($base);
    return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}

function insert_new_user($dbMD, $uuid, $login, $password, $cognome, $nome, $codiceFiscale, $email, $admin, $superadmin, $ipAutorizzati, $idIstituzione){

    $pwd = generate_sha_pwd($dbMD, $password);
    
    $insertSuperadmin = $dbMD->insert(
        'MDUtenti',
        array(
        'ID'                       => $uuid,
        'LOGIN'                    => $login,
        'PASSWORD'                 => $pwd,
        'COGNOME'                  => $cognome,
        'NOME'                     => $nome,
        'ID_ISTITUZIONE'           => $idIstituzione,
        'AMMINISTRATORE'           => $admin,
        'CODICEFISCALE'            => $codiceFiscale,
        'EMAIL'                    => $email,
        'SUPERADMIN'               => $superadmin,
        'IP_AUTORIZZATI'           => $ipAutorizzati
        )
    );

    return $insertSuperadmin;
}

function insert_new_user_check_errors($dbMD){

    $error = $dbMD->last_error;

    $duplicate = "Duplicate entry";

    $loginError = "'MDUtenti.U_MDUtenti_01'";
    $codiceFiscaleError = "'MDUtenti.U_MDUtenti_02'";
    $loginNULL = "'LOGIN' cannot be null";
    $cognomeNULL = "'COGNOME' cannot be null";
    $nomeNULL = "'NOME' cannot be null";


    if (strpos($error, $duplicate) !== false && strpos($error, $loginError) !== false){
        $errorMessage = "Nome utente già utilizzato";
        return $errorMessage;
    }
    if (strpos($error, $duplicate) !== false && strpos($error, $codiceFiscaleError) !== false){
        $errorMessage = "Codice fiscale già utilizzato";
        return $errorMessage;
    }
    if (strpos($error, $loginNULL) !== false){
        $errorMessage = "L'username non può essere vuoto";
        return $errorMessage;
    }
    if (strpos($error, $cognomeNULL) !== false){
        $errorMessage = "Il cognome non può essere vuoto";
        return $errorMessage;
    }
    if (strpos($error, $cognomeNULL) !== false){
        $errorMessage = "Il nome non può essere vuoto";
        return $errorMessage;
    }

    return $error;
    
}

function insert_new_gestore_istituzione($dbMD, $uuidUtente, $nomeLogin, $password, $utenteCognome, $utenteNome, $admin, $uuidIstituzione, $utenteCodicefiscale, $utenteEmail, $superadmin, $ipAutorizzati){

    $pwd    = generate_sha_pwd($dbMD, $password);
    // $uuid   = $uuidUtente . '-F';

    $insertGestoreIstituzione = $dbMD->insert(
        'MDUtenti',
        array(
        // 'ID'                       => $uuid,
        'ID'                       => $uuidUtente,
        'LOGIN'                    => $nomeLogin,
        'PASSWORD'                 => $pwd,
        'COGNOME'                  => $utenteCognome,
        'NOME'                     => $utenteNome,
        'AMMINISTRATORE'           => $admin,
        'ID_ISTITUZIONE'           => $uuidIstituzione,
        // 'CODICEFISCALE'            => $utenteCodicefiscale,
        'EMAIL'                    => $utenteEmail,
        'SUPERADMIN'               => $superadmin,
        'IP_AUTORIZZATI'           => $ipAutorizzati
        )
    );

    return $insertGestoreIstituzione;

}

function insert_new_gestore_istituzione_check_errors($dbMD){

    $error = $dbMD->last_error;
    $last_query = $dbMD->last_query;        
    $duplicate = "Duplicate entry";

    $cannotAddRowForeign = "Cannot add or update a child row: a foreign key constraint fails";
    $uuidIstituzioneNotMatched = "FOREIGN KEY (`ID_ISTITUZIONE`) REFERENCES `MDIstituzione` (`ID`))";

    $uuidError = "'MDUtenti.PRIMARY'";
    $loginError = "'MDUtenti.U_MDUtenti_01'";
    $codiceFiscaleError = "'MDUtenti.U_MDUtenti_02'";

    if (strpos($error, $cannotAddRowForeign) !== false && strpos($error, $uuidIstituzioneNotMatched) !== false){
        $errorMessage = "UUID dell'Istituzione non valido";
        return $errorMessage;
    }
    if (strpos($error, $duplicate) !== false && strpos($error, $uuidError) !== false){
        $errorMessage = "UUID utente già presente";
        return $errorMessage;
    }
    if (strpos($error, $duplicate) !== false && strpos($error, $loginError) !== false){
        $errorMessage = "Nome utente già presente";
        return $errorMessage;
    }
    if (strpos($error, $duplicate) !== false && strpos($error, $codiceFiscaleError) !== false){
        $errorMessage = "Codice fiscale già presente";
        return $errorMessage;
    }

    return $error;
    
}

function insert_new_istituzione($dbMD, $uuidIstituzione, $nomeLogin, $password, $istituzioneNome, $istituzioneIndirizzo, $istituzioneTelefono, $istituzioneNomeContatto, $istituzioneNote, $istituzioneUrl, $idRegione, $istituzionePiva, $altaRisoluzione){

    $pwd        = generate_sha_pwd($dbMD, $password);
    $pathTmp    = '/mnt/areaTemporanea/Ingest/' . $istituzionePiva;

    $insertIstituzione = $dbMD->insert(
        'MDIstituzione',
        array(
        'ID'                    => $uuidIstituzione,
        'LOGIN'                 => $nomeLogin,
        'PASSWORD'              => $pwd,
        'NOME'                  => $istituzioneNome,
        'INDIRIZZO'             => $istituzioneIndirizzo,
        'TELEFONO'              => $istituzioneTelefono,
        'NOME_CONTATTO'         => $istituzioneNomeContatto,
        'NOTE'                  => $istituzioneNote,
        'URL'                   => $istituzioneUrl,
        'ID_REGIONE'            => $idRegione,
        'PIVA'                  => $istituzionePiva,
        'PATH_TMP'              => $pathTmp,
        'ALTA_RISOLUZIONE'      => $altaRisoluzione,
        'IP_AUTORIZZATI'        => '*.*.*.*.'
        )
    );
    if ($insertIstituzione == 1){
    if (!file_exists($pathTmp)) {
        mkdir($pathTmp, 0774, true);
      }
    }
    return $insertIstituzione;

}

function insert_new_istituzione_check_errors($dbMD){

    $error = $dbMD->last_error;

    $duplicate = "Duplicate entry";

    $cannotAddRowForeign = "Cannot add or update a child row: a foreign key constraint fails";
    $regionValueNotPermitted = "FOREIGN KEY (`ID_REGIONE`) REFERENCES `regioni` (`ID`))";

    $uuidError = "'MDIstituzione.PRIMARY'";
    $pivaError = "'MDIstituzione.U_MDIstituzione_02'";

    if (strpos($error, $cannotAddRowForeign) !== false && strpos($error, $regionValueNotPermitted) !== false){
        $errorMessage = "Valore per il campo regione non valido";
        return $errorMessage;
    }
    if (strpos($error, $duplicate) !== false && strpos($error, $uuidError) !== false){
        $errorMessage = "UUID istituzione già presente";
        return $errorMessage;
    }
    if (strpos($error, $duplicate) !== false && strpos($error, $pivaError) !== false){
        $errorMessage = "Partita IVA già presente";
        return $errorMessage;
    }

    return $error;

}

function insert_new_software($dbMD, $uuidSoftware, $uuidIstituzione, $nomeLogin, $password, $nome){
    
    $pwd          = generate_sha_pwd($dbMD, $password);
    $ip           = '127.0.0.1';
    $bibDepo      = 0;
    $idRights     = null;
    $note         = null;


    $insertMdSoftware = $dbMD->insert(
        'MDSoftware',
        array(
            'ID'                        => $uuidSoftware,
            'NOME'                      => $nome,
            'LOGIN'                     => $nomeLogin,
            'PASSWORD'                  => $pwd,
            'IP_AUTORIZZATI'            => $ip,
            'BIBLIOTECA_DEPOSITARIA'    => $bibDepo,
            'ID_ISTITUZIONE'            => $uuidIstituzione,
            'ID_RIGTHS'                 => $idRights,
            'NOTE'                      => $idRights,
        )
    );

    return $insertMdSoftware;
}

function insert_new_software_config($dbMD, $uuidSoftware, $preRegPassword, $preRegIstituzionePiva) {
                            
    $id         = generate_uuid($dbMD);
    $id1        = generate_uuid($dbMD);
    $id2        = generate_uuid($dbMD);
    $id3        = generate_uuid($dbMD);
    $id4        = generate_uuid($dbMD);
    $id5        = generate_uuid($dbMD);
    $id6        = generate_uuid($dbMD);
    $id7        = generate_uuid($dbMD);
    $rsyncValue = 'rsync://' . $preRegIstituzionePiva . '@md.col.bncf.lan/' . $preRegIstituzionePiva;

    $prepare = $dbMD->prepare("INSERT INTO MDSoftwareConfig
            (ID, ID_SOFTWARE, NOME, DESCRIZIONE, VALUE, ID_NODO)
        VALUES
            ('%s', '%s', 'sendRsyncPwd', 'Password per il collegamento Rsync', '%s', null),
            ('%s', '%s', 'wsdlConfirmDelMD', 'Chiamata Wsdl per indicare l\'avvenuta cancellazione del file dall\'area temporanea dell\'istituto', 'http://md.col.bncf.lan:8080/MagazziniDigitaliServices/services/ConfirmDelMDPort?wsdl', null),
            ('%s', '%s', 'wsdlEndSendMD', 'Chiamata Wsdl per indicare la fine delle operazioni di Trasmissioni dell\'oggetto', 'http://md.col.bncf.lan:8080/MagazziniDigitaliServices/services/EndSendMDPort?wsdl', null),
            ('%s', '%s', 'extFilesUpload', 'Viene indicata la lista delle estensioni files accettati per Upload', 'tar,tar.gz,tgz,warc,warc.gz,mrc', null),
            ('%s', '%s', 'wsdlInitSendMD', 'Chiamata Wsdl per indicare l\'inizio delle operazioni di trasmissione dell\'oggetto', 'http://md.col.bncf.lan:8080/MagazziniDigitaliServices/services/InitSendMDPort?wsdl', null),
            ('%s', '%s', 'removeSource', 'Nel caso in cui il archivio locale e archivio dell\'area Temporanea di MD coincidono è possibile disattivare il trasferimento del materiale mettendo il parametro a false', 'true', null),
            ('%s', '%s', 'sendRsync', 'Dati per il collegamento Rsync verso MD', '%s', null),
            ('%s', '%s', 'wsdlCheckMD', 'Chiamata Wsdl per verificare lo stato dell\'oggetto', 'http://md.col.bncf.lan:8080/MagazziniDigitaliServices/services/CheckMDPort?wsdl', null);
    ", $id, $uuidSoftware, $preRegPassword, $id1, $uuidSoftware, $id2, $uuidSoftware, $id3, $uuidSoftware, $id4, $uuidSoftware, $id5, $uuidSoftware, $id6, $uuidSoftware, $rsyncValue, $id7, $uuidSoftware);
    
    $insertSoftwareConfig = $dbMD->get_results($prepare);

    return $insertSoftwareConfig;

}

function update_password_mdconfig($dbMD, $password, $uuidIstituzione) {

    $selectSoftware = $dbMD->prepare("SELECT ID FROM MDSoftware WHERE ID_ISTITUZIONE='%s'", $uuidIstituzione);
    $uuidSoftware = $dbMD->get_results($selectSoftware);
    $uuidSoftware = $uuidSoftware[0]->ID;

    $updateDB = $dbMD->update(
        'MDSoftwareConfig',
        array(
            'VALUE'         => $password
        ),
        array(
            'NOME'          => 'sendRsyncPwd',
            'ID_SOFTWARE'   => $uuidSoftware
        )
    );

}

function update_password_mdsoftware($dbMD, $password, $uuidIstituzione) {

    $updateDB = $dbMD->update(
        'MDSoftware',
        array(
            'PASSWORD'         => $password
        ),
        array(
            'ID_ISTITUZIONE'   => $uuidIstituzione
        )
    );

}

function retrieve_info_from_mdsoftware($dbMD){

    $uuidIstituzione = $_SESSION['uuidIst'];

    $preparedQuery = $dbMD->prepare("SELECT LOGIN, PASSWORD FROM MDSoftware WHERE ID_ISTITUZIONE='%s'", $uuidIstituzione);

    $info = $dbMD->get_results($preparedQuery);

    return $info;

}

function insert_into_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione) {

    $insert = $dbNBN->insert(
        'subnamespace',
        array(
            'subNamespace'      => $loginIstituzione,
            'inst_name'         => $nomeIstituzione
        )
    );

    return $insert;
}

function check_email_validata($dbMD, $uuid){

    $preparedQuery = $dbMD->prepare("SELECT EMAIL_VALIDATA FROM MDPreRegistrazione WHERE ID='%s'", $uuid);
    $result = $dbMD->get_results($preparedQuery);

    $emailValidata = intval($result[0]->EMAIL_VALIDATA);

    return $emailValidata;

}

function set_email_validata_to_true($dbMD, $uuid){

    $emailValidata = 1;

    $updateDB = $dbMD->update(
        'MDPreRegistrazione',
        array(
            'EMAIL_VALIDATA'     => $emailValidata,
        ),
        array(
            'ID'                 => $uuid
        )
    );
}

function set_email_to_true_import($dbMD, $uuid){

    $inviato = 1;

    $updateDB = $dbMD->update(
        'MDIstituzioneImport',
        array(
            'Inviato'            => (int)$inviato,
        ),
        array(
            'ID_Utente'          => $uuid
        )
    );
}
function set_approve_to_true_import($dbMD, $uuid){

    $approvato = 1;

    $updateDB = $dbMD->update(
        'MDIstituzioneImport',
        array(
            'Approvato'     => (int)$approvato,
        ),
        array(
            'ID_Utente'   => $uuid
        )
    );
    // $error = check_db_error($dbMD);

}
function set_checkdifase_to_rejected($dbMD, $uuid){

    $checkidfase = 'non validata';

    $updateDB = $dbMD->update(
        'MDPreRegistrazione',
        array(
            'CHECKIDFASE'     => $checkidfase,
        ),
        array(
            'ID'              => $uuid
        )
    );
}

function set_checkdifase_to_approved($dbMD, $uuid){

    $checkidfase = 'validata';

    $updateDB = $dbMD->update(
        'MDPreRegistrazione',
        array(
            'CHECKIDFASE'     => $checkidfase,
        ),
        array(
            'ID'              => $uuid
        )
    );
}

function check_istituzione_exist_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione){

    $preparedQuery  = $dbNBN->prepare("SELECT COUNT(*) as count FROM subnamespace WHERE subNamespace='%s' AND inst_name='%s' ", $loginIstituzione, $nomeIstituzione);
    $results        = $dbNBN->get_results($preparedQuery);

    $resultCount = intval($results[0]->count);

    return $resultCount;

}

function check_datasource_into_nbn($dbNBN, $nomeDatasource, $urlOai){

    $preparedQuery  = $dbNBN->prepare("SELECT COUNT(*) as count FROM datasource WHERE datasourceName='%s' AND baseurl='%s' ", $nomeDatasource, $urlOai);
    $results        = $dbNBN->get_results($preparedQuery);

    $resultCount = intval($results[0]->count);

    return $resultCount;

}

function check_nbn_datasourceName_exists($dbNBN, $bookNomeDatasource){

    $preparedQuery  = $dbNBN->prepare("SELECT COUNT(*) as count FROM datasource WHERE datasourceName='%s'", $bookNomeDatasource);
    $results        = $dbNBN->get_results($preparedQuery);

    $resultCount = intval($results[0]->count);

    return $resultCount;
}

function check_nbn_datasourceName_exists_modify($dbNBN, $bookNomeDatasource, $datasourceID){

    $preparedQuery  = $dbNBN->prepare("SELECT COUNT(*) as count FROM datasource WHERE datasourceName='%s' AND datasourceID<>'%s'", $bookNomeDatasource, $datasourceID);
    $results        = $dbNBN->get_results($preparedQuery);

    $resultCount = intval($results[0]->count);

    return $resultCount;
}

function retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione) { // , $nomeIstituzione

    $prepareQuery       = $dbNBN->prepare("SELECT subNamespaceID FROM `subnamespace` WHERE subNamespace='%s'  ", $loginIstituzione); // AND inst_name='%s', $nomeIstituzione
    $result             = $dbNBN->get_results($prepareQuery);

    // $error = $dbNBN->last_error;
    // $last_query = $dbNBN->last_query;        

    if($result){
        $subnamespaceID     = $result[0]->subNamespaceID;
        return $subnamespaceID;
    }

    return $result;
    
}

function insert_into_nbn_datasource($dbNBN, $nomeDatasource, $urlOai, $subnamespaceID, $servizioAbilitato) {

    $insert = $dbNBN->insert(
        'datasource',
        array(
            'datasourceName'        => $nomeDatasource,
            'baseurl'               => $urlOai,
            'subNamespaceID'        => $subnamespaceID,
            'materiale'             => $servizioAbilitato
        )
    );

    return $insert;

}

function update_datasource_nbn($dbNBN, $loginIstituzione, $nomeIstituzione, $nomeDatasource, $url, $subnamespaceID, $idDatasource){
    $query = $dbNBN->update(
      'datasource',
      array(
        'datasourceName'        => $nomeDatasource,
        'baseurl'               => $url,
      ),
      array(
        'subNamespaceID'        => $subnamespaceID,
        'datasourceID'          => $idDatasource

      )
    );
    return $query;
}

function update_datasource_nbn_test($dbNBN, $nomeDatasource, $url, $subnamespaceID, $idDatasource){ // $loginIstituzione, $nomeIstituzione, 

    $sql="UPDATE datasource SET datasourceName='" .$nomeDatasource. "', baseurl='" .$url."' WHERE subNamespaceID='".$subnamespaceID. "' and datasourceID='" .$idDatasource."'";

    $query = $dbNBN->query($sql);
    return $query;

}


function update_datasource_nbn_mod($dbNBN, $nomeDatasource, $url, $subnamespaceID, $idDatasource){ // add by Hassan
      
    $query = $dbNBN->update(
      'datasource',
      array(
        'datasourceName'        => $nomeDatasource,
        'baseurl'               => $url,
      ),
      array(
        'subNamespaceID'        => $subnamespaceID,
        'datasourceID'          => $idDatasource

      )
    );

    return $query;
}

function insert_into_nbn_agent($dbNBN, $nomeDatasource, $urlOai, $userApiNBN, $pwdApiNBN, $ipApiNBN, $idDatasource, $subnamespaceID, $servizioAbilitato){

    $insert = $dbNBN->insert(
        'agent',
        array(
            'agent_name'        => $nomeDatasource,
            'baseurl'           => $urlOai,
            'user'              => $userApiNBN,
            'pass'              => $pwdApiNBN,
            'IP'                => $ipApiNBN,
            'subNamespaceID'    => $subnamespaceID,
            'datasourceID'      => $idDatasource,
            'materiale'         => $servizioAbilitato
        )
    );

    return $insert;

}

function update_agent_nbn($dbNBN, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, $servizioAbilitato, $subnamespaceID, $idDatasource){ // , $loginIstituzione, $nomeIstituzione

    $query = $dbNBN->update(
      'agent',
      array(
        'agent_name'        => $nomeDatasource,
        'baseurl'           => $url,
        'user'              => $userNBN,
        'pass'              => $pwdNBN,
        'IP'                => $ipNBN
      ),
      array(
        'subNamespaceID'    => $subnamespaceID,
        'datasourceID'      => $idDatasource,
        'materiale'         => $servizioAbilitato
      )
    );

    return $query;
    
}

function update_agent_nbn_mod($dbNBN, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, $servizioAbilitato, $subnamespaceID, $idDatasource){  // add by Hassan

    $query = $dbNBN->update(
      'agent',
      array(
        'agent_name'        => $nomeDatasource,
        'baseurl'           => $url,
        'user'              => $userNBN,
        'pass'              => $pwdNBN,
        'IP'                => $ipNBN
      ),
      array(
        'subNamespaceID'    => $subnamespaceID,
        'datasourceID'      => $idDatasource,
        'materiale'         => $servizioAbilitato
      )
    );

    return $query;
    
}

function insert_into_md_servizi($dbMD, $idIstituzione, $servizioAbilitato){

    $selectID   = $dbMD->get_row("SELECT MAX(ID) AS 'MaximumValue' FROM MDServizi");
    $id         = intval($selectID->MaximumValue);
    $id        += 1;

    $insert = $dbMD->insert(
        'MDServizi',
        array(
            'id'                    => $id,
            'id_istituzione'        => $idIstituzione,
            'servizio_abilitato'    => $servizioAbilitato
        )
    );

    return $insert;

}

function insert_into_md_MDIstituzioneImport($dbMD, $idIstituzione,$idUtente){

    $selectID   = $dbMD->get_row("SELECT MAX(ID) AS 'MaximumValue' FROM MDIstituzioneImport");
    $id         = intval($selectID->MaximumValue);
    $id        += 1;

    $insert = $dbMD->insert(
        'MDIstituzioneImport',
        array(
            'ID'         => $id ,
            'ID_Istituto'  => $idIstituzione,
            'ID_Utente'  => $idUtente
        )
    );

    return $insert;

}

function retrieve_id_datasource($dbNBN, $subnamespaceID, $servizioAbilitato) {
    $prepareQuery       = $dbNBN->prepare("SELECT datasourceID FROM datasource WHERE materiale='%s' AND subNamespaceID='%s' ", $servizioAbilitato, $subnamespaceID);
   $result             = $dbNBN->get_results($prepareQuery);
    if($result){
        $datasourceID       = $result[0]->datasourceID;
        return $datasourceID;
    }
    return $result;
}

function retrieve_id_istituzione($dbMD, $login) {
    $prepareQuery = $dbMD->prepare("SELECT ID FROM MDIstituzione WHERE login='%s'", $login);
    $result        = $dbMD->get_results($prepareQuery);
    if($result){
        return $result[0]->ID;
    }
    return $result;
}



function retrieve_id_agent_nbn($dbNBN, $subnamespaceID, $idDatasource) {

    $prepareQuery       = $dbNBN->prepare("SELECT agentID FROM agent WHERE subNamespaceID='%s' and datasourceID='%s'", $subnamespaceID, $idDatasource);
    $result             = $dbNBN->get_results($prepareQuery);
    if($result){
        $agentID       = $result[0]->agentID;
        return $agentID;
    }
    return $result;
}

// 20/09/2021 
function retrieve_agent_nbn($dbNBN, $subnamespaceID, $idDatasource) {

    $prepareQuery       = $dbNBN->prepare("SELECT * FROM agent WHERE subNamespaceID='%s' and datasourceID='%s'", $subnamespaceID, $idDatasource);
    $result             = $dbNBN->get_results($prepareQuery);
    return $result;
}





// function retrieve_id_datasource_for_istituzione($dbNBN, $nomeDatasource, $subnamespaceID, $url) {
// Argentino 11/08/2020
function retrieve_id_datasource_for_istituzione($dbNBN, $subnamespaceID, $url) {

    // $prepareQuery       = $dbNBN->prepare("SELECT datasourceID FROM datasource WHERE datasourceName='%s' AND subNamespaceID='%s' AND baseurl='%s' ", $nomeDatasource, $subnamespaceID, $url);
    $prepareQuery       = $dbNBN->prepare("SELECT datasourceID FROM datasource WHERE subNamespaceID='%s' AND baseurl='%s' ", $subnamespaceID, $url);
    $result             = $dbNBN->get_results($prepareQuery);
    // $datasourceID       = $result[0]->datasourceID;
    if($result){
        $datasourceID       = $result[0]->datasourceID;
        return $datasourceID;
    }

    return $result;
   
}

function insert_into_harvest_anagrafe($dbHarvest, $uuidIstituzione, $idDatasource, $loginIstituzione, $urlOai, $contatti, $formatMetadati, $setMetadati, $utenzaEmbargo, $pwdEmbargo, $servizioAbilitato){

    $selectID   = $dbHarvest->get_row("SELECT MAX(ID) AS 'MaximumValue' FROM anagrafe");
    $id         = intval($selectID->MaximumValue);
    $id        += 1;

    $insert = $dbHarvest->insert(
        'anagrafe',
        array(
            'id'                        => $id,
            'id_istituzione'            => $uuidIstituzione,
            'id_datasource'             => $idDatasource,
            'harvest_contact'           => $contatti,
            'harvest_format'            => $formatMetadati,
            'harvest_set'               => $setMetadati,
            'harvest_userEmbargo'       => $utenzaEmbargo,
            'harvest_pwdEmbargo'        => $pwdEmbargo,
            'harvest_materiale'         => $servizioAbilitato,
            'harvest_name'              => $loginIstituzione,
            'harvest_url'               => $urlOai
        )
    );

    return $insert;

}

function update_anagrafe_harvest($dbHarvest, $uuidIstituzione, $loginIstituzione, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $url, $servizioAbilitato, $idDatasource){ // , $nomeIstituzione, $nomeDatasource

    $query = $dbHarvest->update(
      'anagrafe',
      array(
        'harvest_contact'           => $contatti,
        'harvest_format'            => $format,
        'harvest_set'               => $set,
        'harvest_userEmbargo'       => $userEmbargo,
        'harvest_pwdEmbargo'        => $pwdEmbargo,
        'harvest_name'              => $loginIstituzione,
        'harvest_url'               => $url
      ),
      array(
        'id_istituzione'            => $uuidIstituzione,
        'id_datasource'             => $idDatasource,
        'harvest_materiale'         => $servizioAbilitato
      )
    );

    return $query;
}



function update_anagrafe_harvest_mod($dbHarvest, $uuidIstituzione, $loginIstituzione, $nomeDatasource, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $url, $servizioAbilitato, $idDatasource){ // add by Hassan

    $query = $dbHarvest->update(
      'anagrafe',
      array(
        'harvest_contact'           => $contatti,
        'harvest_format'            => $format,
        'harvest_set'               => $set,
        'harvest_userEmbargo'       => $userEmbargo,
        'harvest_pwdEmbargo'        => $pwdEmbargo,
        'harvest_name'              => $loginIstituzione,
        'harvest_url'               => $url
      ),
      array(
        'id_istituzione'            => $uuidIstituzione,
        'id_datasource'             => $idDatasource,
        'harvest_materiale'         => $servizioAbilitato
      )
    );

    return $query;
}
function check_if_istituzione_signed_for_service($dbMD, $uuidIstituzione, $servizioAbilitato){

    $prepareQuery       = $dbMD->prepare("SELECT * FROM MDServizi WHERE id_istituzione='%s' AND servizio_abilitato='%s' ", $uuidIstituzione, $servizioAbilitato);
    $result             = $dbMD->get_results($prepareQuery);

    return $result;

}

function retrieve_all_superadmin($dbMD){

    $preparedQuery = $dbMD->prepare("SELECT NOME, COGNOME, EMAIL FROM MDUtenti WHERE AMMINISTRATORE='%d' AND SUPERADMIN='%d'", 0, 1);
    $results       = $dbMD->get_results($preparedQuery);

    return $results;

}

function select_agent_ngn_and_anagrafe_harvest($dbNBN, $dbHarvest, $servizioAbilitato, $subnamespaceID, $datasourceID) {

    $query = $dbNBN->prepare(
        "SELECT nbn.agent.*, harvest.anagrafe.*
        FROM nbn.agent
        LEFT JOIN harvest.anagrafe 
        ON nbn.agent.datasourceID = harvest.anagrafe.id_datasource
        WHERE nbn.agent.materiale = '%s' AND harvest.anagrafe.harvest_materiale = '%s' AND nbn.agent.subNamespaceID='%s'", $servizioAbilitato, $servizioAbilitato, $subnamespaceID);

    $results = $dbNBN->get_results($query);

    return $results;
        
}

function select_agent_ngn($dbNBN, $servizioAbilitato, $subnamespaceID){

    $query = $dbNBN->prepare("SELECT * FROM agent WHERE materiale = '%s' AND subNamespaceID='%s'", $servizioAbilitato, $subnamespaceID);

    $results = $dbNBN->get_results($query);

    return $results;
    
}

/////////////////////////////////SOAP FUNCTIONS//////////////////////////////////////////

//Autentica l'istituzione su Magazzini Digitali e restituisce un oggetto con tutte le info a riguardo 
function webServiceAuthenticateSoftware($authentication){
    $_urlSoap=null;
    if(strtolower(AMBIENTE_APPLICATIVO)=='locale')
    {
        $_urlSoap=SOAP_CLIENT_AUTH_SW_LOCALE;
    }
    else  if(strtolower(AMBIENTE_APPLICATIVO)=='collaudo')
    {
        $_urlSoap=SOAP_CLIENT_AUTH_SW_COLLAUDO;
    }
    else  if(strtolower(AMBIENTE_APPLICATIVO)=='esercizio')
    {
        $_urlSoap=SOAP_CLIENT_AUTH_SW_ESERCIZIO;
    }

    $client = new SoapClient($_urlSoap,array('exceptions' => true,));
  
    try {
      
        $software = $client->authenticationSoftwareOperation($authentication);
  
    } catch (SoapFault $e) {
        var_dump("Returns webServiceAuthenticateSoftware: ");
        var_dump(
            $client->__getLastRequestHeaders(),
            $client->__getLastRequest(),
            $client->__getLastResponseHeaders(),
            $client->__getLastResponse()
        );
    }
    
    return $software;
    
}

//Controlla se il file caricato è presente in Magazzini Digitali e il suo stato.
function webServiceCheckMD($readInfoInput){

    $ReadInfoOutput = 'ERROR';

    try {
        $_urlSoap=null;
        if(strtolower(AMBIENTE_APPLICATIVO)=='locale')
        {
            $_urlSoap=SOAP_CLIENT_AUTH_CHK_LOCALE;
        }
        else  if(strtolower(AMBIENTE_APPLICATIVO)=='collaudo')
        {
            $_urlSoap=SOAP_CLIENT_AUTH_CHK_COLLAUDO;
        }
        else  if(strtolower(AMBIENTE_APPLICATIVO)=='esercizio')
        {
            $_urlSoap=SOAP_CLIENT_AUTH_CHK_ESERCIZIO;
        }
        
    
        $client = new SoapClient($_urlSoap,
            array('exceptions' => true,)
        );
        
        try {
            $ReadInfoOutput = $client->checkMDOperation($readInfoInput);
            
        } catch (SoapFault $e) {
            var_dump("Returns webServiceCheckMD: ");
            var_dump(
                $client->__getLastRequestHeaders(),
                $client->__getLastRequest(),
                $client->__getLastResponseHeaders(),
                $client->__getLastResponse()
                );
        }
        
        return $ReadInfoOutput;
        
    }
    catch ( Exception $e )
    {
        echo "CheckMD web service in errore o non disponibile";
        
    }
    
}

//Inizia l'invio dell'oggetto a Magazzini Digitali
function initSendOggettoDigitale($filename, $readInfoInput){

    try {
        $_urlSoap=null;
        if(strtolower(AMBIENTE_APPLICATIVO)=='locale')
        {
            $_urlSoap=SOAP_CLIENT_INI_S_LOCALE;
        }
        else  if(strtolower(AMBIENTE_APPLICATIVO)=='collaudo')
        {
            $_urlSoap=SOAP_CLIENT_INI_S_COLLAUDO;
        }
        else  if(strtolower(AMBIENTE_APPLICATIVO)=='esercizio')
        {
            $_urlSoap=SOAP_CLIENT_INI_S_ESERCIZIO;
        }
        $client = new SoapClient($_urlSoap,
            array('exceptions' => true,)
            );
        try {
            $ReadInfoOutput = $client->initSendMDOperation($readInfoInput);
        } catch (SoapFault $e) {
            var_dump("Returns initSendOggettoDigitale: ");
            var_dump(
                $client->__getLastRequestHeaders(),
                $client->__getLastRequest(),
                $client->__getLastResponseHeaders(),
                $client->__getLastResponse()
            );
        }
    }
    catch ( Exception $e )
    {
        echo "CheckMD web service in errore o non disponibile";
    }
    return $ReadInfoOutput;
    
}

//Conclude l'invio dell'oggetto a Magazzini Digitali
function endSendOggettoDigitale($checkMdInfoOutput) {
    
    try {
          $endSend = array(
              "readInfoOutput" => $checkMdInfoOutput,
              "esito" => true
          );
          $_urlSoap=null;
          if(strtolower(AMBIENTE_APPLICATIVO)=='locale')
          {
              $_urlSoap=SOAP_CLIENT_END_S_LOCALE;
          }
          else  if(strtolower(AMBIENTE_APPLICATIVO)=='collaudo')
          {
              $_urlSoap=SOAP_CLIENT_END_S_COLLAUDO;
          }
          else  if(strtolower(AMBIENTE_APPLICATIVO)=='esercizio')
          {
              $_urlSoap=SOAP_CLIENT_END_S_ESERCIZIO;
          }

        $client = new SoapClient($_urlSoap,
            array('exceptions' => true,)
        );        
        try {
            $client->endSendMDOperation($endSend);
        } catch (SoapFault $e) {
            var_dump("Returns endSendOggettoDigitale:");
            var_dump(
                $client->__getLastRequestHeaders(),
                $client->__getLastRequest(),
                $client->__getLastResponseHeaders(),
                $client->__getLastResponse()
            );
        }
    }
    catch ( Exception $e )
    {
        echo "CheckMD web service in errore o non disponibile";
    }

}


/////////////////////////////////EMAIL FUNCTIONS//////////////////////////////////////////


function send_confirmation_email_to_institution($utenteCognome, $utenteNome, $utenteEmail, $encryptedUuid) {
    require('./templates/confirmation-email.php');

//    $mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', 'cedf82b4d4c1b2', 'f06ef4a6a9b766', 'from@example.com', 'Magazzini Digitali');
    $mail=mailParm();//va adu usare il mailtrap 
    $mail->addAddress($utenteEmail, $utenteNome . " " . $utenteCognome);
    $mail->Subject = 'Conferma la tua email';
    $mail->msgHTML($body);
    $mail->AltBody = 'HTML messaging not supported';

    if(!$mail->send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

function send_notice_email_to_admin($dbMD){
    require('../templates/notice-email.php');

    $superadmin = retrieve_all_superadmin($dbMD);

   // $mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', 'cedf82b4d4c1b2', 'f06ef4a6a9b766', 'from@example.com', 'Magazzini Digitali');

   $mail=mailParm();//va adu usare il mailtrap 
    foreach($superadmin as $key=>$results) {

        $nome       = $results->NOME;
        $cognome    = $results->COGNOME;
        $email      = $results->EMAIL;

        $mail->addAddress($email, $nome . " " . $cognome);

        $mail->Subject = 'Una istituzione ha effettuato una pre-registrazione';
        $mail->msgHTML($body);
        $mail->AltBody = 'HTML messaging not supported';

        if(!$mail->send()){
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}

function send_notice_nbn_email_to_admin($dbMD, $tesiUserApiNBN, $tesiPwdApiNBN, $journalUserApiNBN, $journalPwdApiNBN, $bookUserApiNBN, $bookPwdApiNBN){
    require('../templates/notice-nbn-email.php');

    $superadmin = retrieve_all_superadmin($dbMD);

    //$mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', 'cedf82b4d4c1b2', 'f06ef4a6a9b766', 'from@example.com', 'Magazzini Digitali');
    $mail=mailParm();//va adu usare il mailtrap 
    foreach($superadmin as $key=>$results) {

        $nome       = $results->NOME;
        $cognome    = $results->COGNOME;
        $email      = $results->EMAIL;

        $mail->addAddress($email, $nome . " " . $cognome);

        $mail->Subject = 'Nuovo utente NBN';
        $mail->msgHTML($body);
        $mail->AltBody = 'HTML messaging not supported';

        if(!$mail->send()){
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}

function send_rejected_signup_email($utenteEmail, $utenteNome, $utenteCognome){
    require('../templates/rejected-signup-email.php');

//    $mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', 'cedf82b4d4c1b2', 'f06ef4a6a9b766', 'from@example.com', 'Magazzini Digitali');
    $mail=mailParm();//va adu usare il mailtrap 
    $mail->addAddress($utenteEmail, $utenteNome . " " . $utenteCognome);
    $mail->Subject = 'Richiesta di registrazione rigettata';
    $mail->msgHTML($body);
    $mail->AltBody = 'HTML messaging not supported';

    if(!$mail->send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

function send_approved_signup_email($utenteEmail, $utenteNome, $utenteCognome, $preRegNomeLogin, $preRegPassword){
    require('../templates/approved-signup-email.php');

   // $mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', 'cedf82b4d4c1b2', 'f06ef4a6a9b766', 'from@example.com', 'Magazzini Digitali');
    $mail=mailParm();//va adu usare il mailtrap 
    $mail->addAddress($utenteEmail, $utenteNome . " " . $utenteCognome);
    $mail->Subject = 'Richiesta di registrazione approvata';
    $mail->msgHTML($body);
    $mail->AltBody = 'HTML messaging not supported';

    if(!$mail->send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

function send_confirmation_email_to_user($utenteCognome, $utenteNome, $utenteEmail, $encryptedUuid, $newUserLogin, $newUserPassword){
    require('../templates/user-registration-email.php');

    //$mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', 'cedf82b4d4c1b2', 'f06ef4a6a9b766', 'from@example.com', 'Magazzini Digitali');
    $mail=mailParm();//va adu usare il mailtrap 
    $mail->addAddress($utenteEmail, $utenteNome . " " . $utenteCognome);
    $mail->Subject = 'Registrazione a Magazzini Digitali';
    $mail->msgHTML($body);
    $mail->AltBody = 'HTML messaging not supported';

    if(!$mail->send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

function send_change_password_email($dbMD, $nameUser, $surnameUser, $mailUser, $login, $password){
    require('./templates/change-password.php');

//    $mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', 'cedf82b4d4c1b2', 'f06ef4a6a9b766', 'from@example.com', 'Magazzini Digitali');
 //   $mail = init_phpmailer("smtp.mailtrap.io", 587, 'tls', 'cedf82b4d4c1b2', 'f06ef4a6a9b766', 'from@example.com', 'Magazzini Digitali');
    $mail=mailParm();

    $mail->addAddress($mailUser, $nameUser . " " . $surnameUser);
    $mail->Subject = 'Nuova password per il login a Magazzini Digitali';
    $mail->msgHTML($body);
    $mail->AltBody = 'HTML messaging not supported';

    if(!$mail->send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

// 20/08/2021
// To debug WP queries
// add_filter('posts_request','debug_post_request'); // debugging sql query of a post
// function debug_post_request($sql_text) {
//    $GLOBALS['debugku'] = $sql_text; //intercept and store the sql<br/>
//    return $sql_text; 
// }
