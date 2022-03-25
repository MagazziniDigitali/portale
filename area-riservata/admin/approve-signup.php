<?php
    $allRegions = retrieve_regions($dbMD);

    $result = show_istituzioni_to_be_approved($dbMD);

    if (isset($_POST['rejectSubmission'])) {
        if (isset($_POST['preRegUuid'])) {
            $preRegID = $_POST['preRegUuid'];
        }
        if (isset($_POST['preRegUtenteEmail'])) {
            $preRegUtenteEmail = $_POST['preRegUtenteEmail'];
        }
        if (isset($_POST['preRegUtenteNome'])) {
            $preRegUtenteNome = $_POST['preRegUtenteNome'];
        }
        if (isset($_POST['preRegUtenteCognome'])) {
            $preRegUtenteCognome = $_POST['preRegUtenteCognome'];
        }
        reject_submission($dbMD, $preRegID, $preRegUtenteEmail, $preRegUtenteNome, $preRegUtenteCognome);
        echo "<script>window.location.href = '/area-riservata/admin/'</script>";

    } elseif (isset($_POST['acceptSubmission'])) {
        // Utente
        if (isset($_POST['preRegUtenteEmail'])) {
            $preRegUtenteEmail = $_POST['preRegUtenteEmail'];
        }
        if (isset($_POST['preRegUtenteNome'])) {
            $preRegUtenteNome = $_POST['preRegUtenteNome'];
        }
        if (isset($_POST['preRegUtenteCognome'])) {
            $preRegUtenteCognome = $_POST['preRegUtenteCognome'];
        }
        if (isset($_POST['preRegUtenteCodicefiscale'])) {
            $preRegUtenteCodicefiscale = $_POST['preRegUtenteCodicefiscale'];
        }
        // Istituzione
        if (isset($_POST['preRegIstituzionePiva'])) {
            $preRegIstituzionePiva = $_POST['preRegIstituzionePiva'];
        }
        if (isset($_POST['preRegIstituzioneNome'])) {
            $preRegIstituzioneNome = $_POST['preRegIstituzioneNome'];
        }
        if (isset($_POST['preRegIstituzioneIndirizzo'])) {
            $preRegIstituzioneIndirizzo = $_POST['preRegIstituzioneIndirizzo'];
        }
        if (isset($_POST['preRegIdRegione'])) {
            $preRegIdRegione = $_POST['preRegIdRegione'];
        }
        if (isset($_POST['preRegIstituzioneUrl'])) {
            $preRegIstituzioneUrl = $_POST['preRegIstituzioneUrl'];
        }
        if (isset($_POST['preRegIstituzioneTelefono'])) {
            $preRegIstituzioneTelefono = $_POST['preRegIstituzioneTelefono'];
        }
        if (isset($_POST['preRegIstituzioneNomeContatto'])) {
            $preRegIstituzioneNomeContatto = $_POST['preRegIstituzioneNomeContatto'];
        }
        if (isset($_POST['preRegIstituzioneNote'])) {
            $preRegIstituzioneNote = $_POST['preRegIstituzioneNote'];
        }
        if (isset($_POST['preRegRivisteAperte'])) {
            $preRegRivisteAperte = $_POST['preRegRivisteAperte'];
        }
        if (isset($_POST['preRegRivisteRistrette'])) {
            $preRegRivisteRistrette = $_POST['preRegRivisteRistrette'];
        }
        if (isset($_POST['preRegEbookAperte'])) {
            $preRegEbookAperte = $_POST['preRegEbookAperte'];
        }
        if (isset($_POST['preRegEbookRistrette'])) {
            $preRegEbookRistrette = $_POST['preRegEbookRistrette'];
        }
        if (isset($_POST['preRegAltro'])) {
            $preRegAltro = $_POST['preRegAltro'];
        }

        // Accesso
        if (isset($_POST['preRegUuid'])) {
            $preRegUuid = $_POST['preRegUuid'];
        }
        $preRegNomeLogin = '';
        if (isset($_POST['preRegNomeLogin']) && $_POST['preRegNomeLogin'] != '') {
            $preRegNomeLogin = $_POST['preRegNomeLogin'];
        }
        else {
            $alertNome = "Nome utente errato";
        }
        $preRegPassword = '';
        if (isset($_POST['preRegPassword']) && $_POST['preRegPassword'] != '') {
            $preRegPassword = $_POST['preRegPassword'];
        }
        else {
            $alertPwd = "Password errata";
        }
        if (($preRegNomeLogin != '') && ($preRegPassword != '')) {
            $checkLogin = check_login_istituzione($dbMD, $preRegNomeLogin);
            if($checkLogin==0){
                $uuidIstituzione            = generate_uuid($dbMD);
                $uuidUtente                 = generate_uuid($dbMD);
                $admin                      = 1;
                $superadmin                 = 0;
                $preRegAltaRisoluzione      = 0;
                $preRegTesiDottorato        = 0;
                $ipAutorizzati              = '*.*.*.*';

                $insertIstituzione = insert_new_istituzione($dbMD, $uuidIstituzione, $preRegNomeLogin, $preRegPassword, $preRegIstituzioneNome, $preRegIstituzioneIndirizzo, $preRegIstituzioneTelefono, $preRegIstituzioneNomeContatto, $preRegIstituzioneNote, $preRegIstituzioneUrl, $preRegIdRegione, $preRegIstituzionePiva, $preRegAltaRisoluzione);
                if ($insertIstituzione != 1){
                    $errorIstituzione = insert_new_istituzione_check_errors($dbMD);
                } else {
                    $insertGestoreIstituzione = insert_new_gestore_istituzione($dbMD, $uuidUtente, $preRegNomeLogin, $preRegPassword, $preRegUtenteCognome, $preRegUtenteNome, $admin, $uuidIstituzione, $preRegUtenteCodicefiscale, $preRegUtenteEmail, $superadmin, $ipAutorizzati);
                    if ($insertGestoreIstituzione != 1){
                        $errorUtente = insert_new_gestore_istituzione_check_errors($dbMD);
                    } else {
                        $uuidSoftware = generate_uuid($dbMD);
                        $insertSoftware = insert_new_software($dbMD, $uuidSoftware, $uuidIstituzione, $preRegNomeLogin, $preRegPassword, $preRegIstituzioneNome);
                        if ($insertGestoreIstituzione == 1){
                            $insertSoftwareConfig = insert_new_software_config($dbMD, $uuidSoftware, $preRegPassword, $preRegIstituzionePiva);
                        }
                    }
                }
                if ($insertIstituzione && $insertGestoreIstituzione){
                    set_checkdifase_to_approved($dbMD, $preRegUuid);
                    send_approved_signup_email($preRegUtenteEmail, $preRegUtenteNome, $preRegUtenteCognome, $preRegNomeLogin, $preRegPassword);
                    echo "<script>window.location.href = '/area-riservata/admin/'</script>";
                }
            } else {
                $errorUtente = 'Nome per il login già in uso';
            }
        } else {
            $errorIstituzione = "Inserire nome per il login e/o password";
        }
    }
?>

    <div class="container">
        
        <?php
            foreach($result as $key=>$results) {
                $preRegID                          = $results->ID;
                $preRegProgressivo                 = $results->PROGRESSIVO;
                $preRegDataPreiscrizione           = $results->DATA_PREISCRIZIONE;
                $preRegUtenteEmail                 = $results->UTENTE_EMAIL;
                $preRegUtenteNome                  = $results->UTENTE_NOME;
                $preRegUtenteCognome               = $results->UTENTE_COGNOME;
                $preRegUtenteCodicefiscale         = $results->UTENTE_CODICEFISCALE;
                $preRegUtenteNote                  = $results->UTENTE_NOTE ;
                $preRegIstituzionePiva             = $results->ISTITUZIONE_PIVA;
                $preRegIstituzioneNome             = $results->ISTITUZIONE_NOME;
                $preRegIstituzioneIndirizzo        = $results->ISTITUZIONE_INDIRIZZO;
                $preRegIdRegione                   = $results->ID_REGIONE;
                $preRegIstituzioneUrl              = $results->ISTITUZIONE_URL;
                $preRegIstituzioneTelefono         = $results->ISTITUZIONE_TELEFONO ;
                $preRegIstituzioneNomeContatto     = $results->ISTITUZIONE_NOME_CONTATTO;
                $preRegIstituzioneNote             = $results->ISTITUZIONE_NOTE;
                $preRegAltaRisoluzione             = $results->ALTA_RISOLUZIONE;
                $preRegTesiDottorato               = $results->TESI_DOTTORATO;
                $preRegRivisteAperte               = $results->RIVISTE_APERTE;
                $preRegRivisteRistrette            = $results->RIVISTE_RISTRETTE;
                $preRegEbookAperte                 = $results->EBOOK_APERTE;
                $preRegEbookRistrette              = $results->EBOOK_RISTRETTE;
                $preRegAltro                       = $results->ALTRO;
                $preRegEmailValidata               = $results->EMAIL_VALIDATA;
                $preRegIdIstituzione               = $results->ID_ISTITUZIONE;
                $preRegIdUtente                    = $results->ID_UTENTE;
                $preRegDataEmailvalidata1          = $results->DATA_EMAILVALIDATA1;
                $preRegCheckidfase                 = $results->CHECKIDFASE;
                $preRegDataEmailvalidata2          = $results->DATA_EMAILVALIDATA2;
                $preRegDataPrescrizione            = $results->DATA_PRESCRIZIONE;
        ?>
        <div class="card">            
            <div class="card-header" id="heading<?php echo $key ?>">
                
                <button class="btn" type="button" data-toggle="collapse" data-target="#collapse<?php echo $key ?>" aria-expanded="false" aria-controls="collapse<?php echo $key ?>">
                    <h5 class="m-0">Istituzione: <?php echo $preRegIstituzioneNome ?></h5>
                </button>
                
            </div>

            <div id="collapse<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">

                <?php if(isset($errorIstituzione)) { ?>
                    <div class='alert alert-warning mt-3 mb-5'><?php echo $errorIstituzione ?></div>
                <?php } ?>

                <?php if(isset($errorUtente)) { ?>
                    <div class='alert alert-warning mt-3 mb-5'><?php echo $errorUtente ?></div>
                <?php } ?>

                <div class="card-body">
                    <form action="" method="POST">
                        <input type="hidden" name="preRegUuid" value="<?php echo $preRegID?>">
                        <!-- Anagrafica Istituzione -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mt-4 mb-4">Anagrafica Istituzione</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="preRegIstituzioneNome">Nome istituto</label>
                                <input name="preRegIstituzioneNome" type="text" value="<?php echo $preRegIstituzioneNome ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="preRegIstituzionePiva">Partita IVA istituto</label>
                                <input name="preRegIstituzionePiva" type="text" value="<?php echo $preRegIstituzionePiva ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="preRegIstituzioneIndirizzo">Indirizzo istituto</label>
                                <input name="preRegIstituzioneIndirizzo" type="text" value="<?php echo $preRegIstituzioneIndirizzo ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="preRegIdRegione">Regione</label>
                                <select name="preRegIdRegione" class="selectSignup" >
                                    <option value="<?php echo $preRegIdRegione ?>"><?php echo $allRegions[$preRegIdRegione-1]->NOMEREGIONE ?></option>

                                    <?php foreach($allRegions as $regionsElement){ ?>
                                        <option value="<?php echo $regionsElement->ID ?>"><?php echo $regionsElement->NOMEREGIONE ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="preRegIstituzioneTelefono">Telefono istituto</label>
                                <input name="preRegIstituzioneTelefono" type="text" value="<?php echo $preRegIstituzioneTelefono ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="preRegIstituzioneUrl">URL istituto</label>
                                <input name="preRegIstituzioneUrl" type="text" value="<?php echo $preRegIstituzioneUrl ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="preRegIstituzioneNomeContatto">Nome contatto istituto</label>
                                <input name="preRegIstituzioneNomeContatto" type="text" value="<?php echo $preRegIstituzioneNomeContatto ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="preRegIstituzioneNote">Note</label>
                                <input name="preRegIstituzioneNote" type="text" value="<?php echo $preRegIstituzioneNote ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="preRegRivisteAperte">Riviste aperte</label>
                                <input name="preRegRivisteAperte" type="text" value="<?php echo $preRegRivisteAperte ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="preRegRivisteRistrette">Riviste ristrette</label>
                                <input name="preRegRivisteRistrette" type="text" value="<?php echo $preRegRivisteRistrette ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="preRegEbookAperte">E-book aperte</label>
                                <input name="preRegEbookAperte" type="text" value="<?php echo $preRegEbookAperte ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="preRegEbookRistrette">E-book ristrette</label>
                                <input name="preRegEbookRistrette" type="text" value="<?php echo $preRegEbookRistrette ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="preRegAltro">Altro</label>
                                <input name="preRegAltro" type="text" value="<?php echo $preRegAltro ?>">
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                        <!-- <div class="row mt-3">
                            <div class="col-md-12">
                                <input type="hidden" name="preRegAltaRisoluzione" value="0">
                                <input name="preRegAltaRisoluzione" id="preRegAltaRisoluzione" type="checkbox" value="1" <?php echo ($preRegAltaRisoluzione==1 ? 'checked' : '');?> >
                                <label for="preRegAltaRisoluzione">Alta risoluzione</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="preRegTesiDottorato" value="0">
                                <input name="preRegTesiDottorato" type="checkbox" value="<?php echo $preRegTesiDottorato ?>" <?php echo ($preRegTesiDottorato==1 ? 'checked' : '');?> >
                                <label for="preRegTesiDottorato">Tesi dottorato</label>
                            </div>
                        </div> -->
                        <!-- Anagrafica Utente Istituzione -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mt-4 mb-4">Anagrafica del gestore dell'istituzione</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="preRegUtenteNome">Nome gestore dell'istituzione</label>
                                <input name="preRegUtenteNome" type="text" value="<?php echo $preRegUtenteNome ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="preRegUtenteCognome">Cognome gestore dell'istituzione</label>
                                <input name="preRegUtenteCognome" type="text" value="<?php echo $preRegUtenteCognome ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="preRegUtenteEmail">E-mail gestore dell'istituzione</label>
                                <input name="preRegUtenteEmail" type="email" value="<?php echo $preRegUtenteEmail ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="preRegUtenteCodicefiscale">Codice fiscale gestore dell'istituzione</label>
                                <input name="preRegUtenteCodicefiscale" type="text" value="<?php echo $preRegUtenteCodicefiscale ?>" required>
                            </div>
                        </div>
                        <!-- Impostazione Nome Utente e Password -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mt-4 mb-4">Assegnazione nome per il login e password</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="preRegNomeLogin">Nome per il login</label>
                                <input name="preRegNomeLogin" type="text">
                                <?php if(isset($alertNome)) { ?>
                                    <div class='alert alert-warning'><?php echo $alertNome ?></div>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <label for="preRegPassword">Password</label>
                                <input name="preRegPassword" type="password" >
                                <!-- <input type="checkbox" name="showPwd" id="showPwd"> <label for="showPwd">Mostra la password</label> -->

                                <?php if(isset($alertPwd)) { ?>
                                    <div class='alert alert-warning'><?php echo $alertPwd ?></div>
                                <?php } ?>

                            </div>
                        </div>
                        <!-- Submit Actions -->
                        <div class="row mt-5">
                            <div class="col-md-12 text-right">
                                <input type="submit" name="rejectSubmission" value="Rifiuta" class="btnRejectSub mr-3"/>
                                <input type="submit" name="acceptSubmission" value="Accetta" class="btnAcceptSub"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

            
        <?php } ?>
        
    </div>

<script>
   passwordToggle = document.getElementById('showPwd');
   passwordInput = document.getElementById('password');
   
   passwordToggle.addEventListener('change', function(){

       if (passwordInput.type === 'password') {
           passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
   });
</script>