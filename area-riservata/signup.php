<?php
   require("../wp-load.php");
   require("./src/functions.php");

         if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
   
   redirect_if_logged_in();
   
   $dbMD = connect_to_md();
   $allRegions = retrieve_regions($dbMD);

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

       $istitutoPiva = '';
       if(isset($_POST['pivaSignupCustom']) && $_POST['pivaSignupCustom'] != '') {
           $istitutoPiva = $_POST['pivaSignupCustom'];
       }
       $istitutoPassword = '';
       if(isset($_POST['passwordSignupCustom']) && $_POST['passwordSignupCustom'] != '') {
           $istitutoPassword = $_POST['passwordSignupCustom'];
       }
       $istitutoNome = '';
       if(isset($_POST['istitutoSignupCustom']) && $_POST['istitutoSignupCustom'] != '') {
           $istitutoNome = $_POST['istitutoSignupCustom'];
       }
       $istitutoIndirizzo = '';
       if(isset($_POST['indirizzoSignupCustom']) && $_POST['indirizzoSignupCustom'] != '') {
           $istitutoIndirizzo = $_POST['indirizzoSignupCustom'];
       }
       $istitutoTelefono = '';
       if(isset($_POST['telefonoSignupCustom']) && $_POST['telefonoSignupCustom'] != '') {
           $istitutoTelefono = $_POST['telefonoSignupCustom'];
       }
       $istitutoNomeContatto = '';
       if(isset($_POST['nomeContattoSignupCustom']) && $_POST['nomeContattoSignupCustom'] != '') {
           $istitutoNomeContatto = $_POST['nomeContattoSignupCustom'];
       }
       $istitutoNote = '';
       if(isset($_POST['noteSignupCustom']) && $_POST['noteSignupCustom'] != '') {
           $istitutoNote = $_POST['noteSignupCustom'];
       }
       $istitutoUrl = '';
       if(isset($_POST['urlSignupCustom']) && $_POST['urlSignupCustom'] != '') {
           $istitutoUrl = $_POST['urlSignupCustom'];
       }
       $istitutoRegione = '';
       if(isset($_POST['regioneSignupCustom']) && $_POST['regioneSignupCustom'] != '' && $_POST['regioneSignupCustom'] != 'regione') {
           $istitutoRegione = $_POST['regioneSignupCustom'];
       } else {
           $alert = "Inserire una regione";
       }

       $utenteCognome = '';
       if(isset($_POST['cognomeUtenteSignupCustom']) && $_POST['cognomeUtenteSignupCustom'] != '') {
           $utenteCognome = $_POST['cognomeUtenteSignupCustom'];
       }
       $utenteNome = '';
       if(isset($_POST['nomeUtenteSignupCustom']) && $_POST['nomeUtenteSignupCustom'] != '') {
           $utenteNome = $_POST['nomeUtenteSignupCustom'];
       }
       $utenteCodiceFiscale = '';
       if(isset($_POST['cfUtenteSignupCustom']) && $_POST['cfUtenteSignupCustom'] != '') {
           $utenteCodiceFiscale = $_POST['cfUtenteSignupCustom'];
       }
       $utenteEmail = '';
       if(isset($_POST['emailUtenteSignupCustom']) && $_POST['emailUtenteSignupCustom'] != '') {
           $utenteEmail = $_POST['emailUtenteSignupCustom'];
       }

       $uuid = generate_uuid($dbMD);

       $signup = do_signup($dbMD, $uuid, $istitutoPiva, $istitutoPassword, $istitutoNome, $istitutoIndirizzo, $istitutoTelefono, $istitutoNomeContatto, $istitutoNote, $istitutoUrl, $istitutoRegione, $utenteCognome, $utenteNome, $utenteCodiceFiscale, $utenteEmail);

       if (!$signup){
           
           $errorSignup = signup_insert_check_errors($dbMD);

        } else{

            $encryptedUuid = encrypt_string($uuid);
            send_confirmation_email_to_institution($utenteCognome, $utenteNome, $utenteEmail, $encryptedUuid);

            header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/local/" . "area-riservata/istituzione/signup-success");
            die();

        }
       
    }

   get_header();

?>

<section>
    <div class="container">

        <?php if(isset($errorSignup)) { ?>
            <div class='alert alert-warning mt-3 mb-5'><?php echo $errorSignup ?></div>
        <?php } ?>

        <form action="" method="POST" id="formSignupCustom" name="formSignupCustom">
            <div class="row">
                <div class="col-md-12"><h3>Anagrafica Istituzione</h3></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="istitutoSignupCustom">Nome istituto</label>
                    <input type="text" name="istitutoSignupCustom" id="istitutoSignupCustom" required>
                </div>
                <div class="col-md-6">
                    <label for="indirizzoSignupCustom">Indirizzo</label>
                    <input type="text" name="indirizzoSignupCustom" id="indirizzoSignupCustom">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="telefonoSignupCustom">Telefono</label>
                    <input type="text" name="telefonoSignupCustom" id="telefonoSignupCustom">
                </div>
                <div class="col-md-6">
                    <label for="nomeContattoSignupCustom">Nome Contatto</label>
                    <input type="text" name="nomeContattoSignupCustom" id="nomeContattoSignupCustom" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="noteSignupCustom">Note</label>
                    <input type="text" name="noteSignupCustom" id="noteSignupCustom">
                </div>
                <div class="col-md-6">
                    <label for="urlSignupCustom">URL Istituto</label>
                    <input type="text" name="urlSignupCustom" id="urlSignupCustom">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="pivaSignupCustom">Partita IVA o Codice Fiscale</label>
                    <input type="text" name="pivaSignupCustom" id="pivaSignupCustom" required>
                </div>
                <div class="col-md-6">
                    <label for="regioneSignupCustom">Regione</label>
                    <select name="regioneSignupCustom" id="regioneSignupCustom" class="selectSignup" required>
                    <option value="regione">Scegli una regione</option>
                    <?php foreach($allRegions as $regionsElement) { ?>
                        <option value="<?php echo $regionsElement->ID ?>"><?php echo $regionsElement->NOMEREGIONE ?></option>
                    <?php } ?>
                </select>
                <?php if(isset($alert)) { ?>
                    <div class='alert alert-warning mt-3'><?php echo $alert ?></div>
                <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12"><h3>Anagrafica Utente</h3></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="cognomeUtenteSignupCustom">Cognome Utente</label>
                    <input type="text" name="cognomeUtenteSignupCustom" id="cognomeUtenteSignupCustom" required>
                </div>
                <div class="col-md-6">
                    <label for="nomeUtenteSignupCustom">Nome utente</label>
                    <input type="text" name="nomeUtenteSignupCustom" id="nomeUtenteSignupCustom" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="cfUtenteSignupCustom">Codice fiscale</label>
                    <input type="text" name="cfUtenteSignupCustom" id="cfUtenteSignupCustom" maxlength="16">
                </div>
                <div class="col-md-6">
                    <label for="emailUtenteSignupCustom">E-mail</label>
                    <input type="email" name="emailUtenteSignupCustom" id="emailUtenteSignupCustom" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input name="submit" type="submit" value="Registrati" class="mt-4 float-right"/>
                </div>
            </div>
        </form>     
    </div>
</section>

<?php
    get_footer();
?>