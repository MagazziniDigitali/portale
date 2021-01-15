<?php
    include("../../wp-load.php");
    require("../src/functions.php");

    session_start();

    $dbMD           = connect_to_md();
    $dbHarvest      = connect_to_harvest();
    $dbNBN          = connect_to_nbn();

    $allRegions = retrieve_regions($dbMD);
  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        if(isset($_POST['nome']) && $_POST['nome'] != '') {
            $istituzioneNome = $_POST['nome'];
        }
        if(isset($_POST['indirizzo']) && $_POST['indirizzo'] != '') {
           $istituzioneIndirizzo = $_POST['indirizzo'];
        }
        if(isset($_POST['telefono']) && $_POST['telefono'] != '') {
           $istituzioneTelefono = $_POST['telefono'];
        }
        if(isset($_POST['nomeContatto']) && $_POST['nomeContatto'] != '') {
           $istituzioneNomeContatto = $_POST['nomeContatto'];
        }
        if(isset($_POST['note']) && $_POST['note'] != '') {
           $istituzioneNote = $_POST['note'];
        }
        if(isset($_POST['url']) && $_POST['url'] != '') {
           $istituzioneUrl = $_POST['url'];
        }
        if(isset($_POST['regioneID']) && $_POST['regioneID'] != '' && $_POST['regioneID'] != 'regione') {
            $idRegione = $_POST['regioneID'];
        } else {
            $alert = "Inserire una regione";
        }
        if(isset($_POST['piva']) && $_POST['piva'] != '') {
           $istituzionePiva = $_POST['piva'];
        }

        if(isset($_POST['utenteNome']) && $_POST['utenteNome'] != '') {
            $nome = $_POST['utenteNome'];
        }
        if(isset($_POST['utenteCognome']) && $_POST['utenteCognome'] != '') {
            $cognome = $_POST['utenteCognome'];
        }
        if(isset($_POST['utenteCodicefiscale']) && $_POST['utenteCodicefiscale'] != '') {
            $codiceFiscale = $_POST['utenteCodicefiscale'];
        }
        if(isset($_POST['utenteEmail']) && $_POST['utenteEmail'] != '') {
           $email = $_POST['utenteEmail'];
        }

        if(isset($_POST['nomeLogin']) && $_POST['nomeLogin'] != '') {
            $login = $_POST['nomeLogin'];
        }
        if(isset($_POST['password']) && $_POST['password'] != '') {
            $password = $_POST['password'];
        }

        $uuidIstituzione        = generate_uuid($dbMD);
        $altaRisoluzione        = 0;

        $istituzione = insert_new_istituzione($dbMD, $uuidIstituzione, $login, $password, $istituzioneNome, $istituzioneIndirizzo, $istituzioneTelefono, $istituzioneNomeContatto, $istituzioneNote, $istituzioneUrl, $idRegione, $istituzionePiva, $altaRisoluzione);

        if($istituzione == 0){

            $error = insert_new_istituzione_check_errors($dbMD);

        } else {

            $uuidUtente         = generate_uuid($dbMD);
            $admin              = 1;
            $superadmin         = 0;
            $ipAutorizzati      = '*.*.*.*';

            $gestore = insert_new_user($dbMD, $uuidUtente, $login, $password, $cognome, $nome, $codiceFiscale, $email, $admin, $superadmin, $ipAutorizzati, $uuidIstituzione);

            if($gestore == 1){
                if ((isset($_POST['tesiNomeDatasource']) && $_POST['tesiNomeDatasource'] != '')||(isset($_POST['journalNomeDatasource']) && $_POST['journalNomeDatasource'] != '')) {

                    if(isset($_POST['tesiNomeDatasource']) && $_POST['tesiNomeDatasource'] != ''){

                        $tesiNomeDatasource = $_POST['tesiNomeDatasource'];
                        $servizioAbilitato  = 'td';

                        if (isset($_POST['tesiUrlOai']) && $_POST['tesiUrlOai'] != '') {
                            $tesiUrlOai = $_POST['tesiUrlOai'];
                        }
                        if (isset($_POST['tesiContatti']) && $_POST['tesiContatti'] != '') {
                        $tesiContatti = $_POST['tesiContatti'];
                        }
                        if (isset($_POST['tesiFormatMetadati']) && $_POST['tesiFormatMetadati'] != '') {
                        $tesiFormatMetadati = $_POST['tesiFormatMetadati'];
                        }
                        if (isset($_POST['tesiSetMetadati']) && $_POST['tesiSetMetadati'] != '') {
                        $tesiSetMetadati = $_POST['tesiSetMetadati'];
                        }
                        if (isset($_POST['tesiUtenzaEmbargo']) && $_POST['tesiUtenzaEmbargo'] != '') {
                        $tesiUtenzaEmbargo = $_POST['tesiUtenzaEmbargo'];
                        }
                        if (isset($_POST['tesiPwdEmbargo']) && $_POST['tesiPwdEmbargo'] != '') {
                        $tesiPwdEmbargo = $_POST['tesiPwdEmbargo'];
                        }
                        if (isset($_POST['tesiUserApiNBN']) && $_POST['tesiUserApiNBN'] != '') {
                        $tesiUserApiNBN = $_POST['tesiUserApiNBN'];
                        }
                        if (isset($_POST['tesiPwdApiNBN']) && $_POST['tesiPwdApiNBN'] != '') {
                        $tesiPwdApiNBN = $_POST['tesiPwdApiNBN'];
                        }
                        if (isset($_POST['tesiIpApiNBN']) && $_POST['tesiIpApiNBN'] != '') {
                        $tesiIpApiNBN = $_POST['tesiIpApiNBN'];
                        }

                        //INSERT INTO MD
                        if (empty($tesiServizioAttivo)) {
                            $insertServizio     = insert_into_md_servizi($dbMD, $uuidIstituzione, $servizioAbilitato);
                        }
                    
                        //INSERT INTO NBN
                        $checkSubnamespace      = check_istituzione_exist_nbn_subnamespace($dbNBN, $login, $istituzioneNome);
                    
                        if($checkSubnamespace == 0){
                            $insertSubnamespace     = insert_into_nbn_subnamespace($dbNBN, $login, $istituzioneNome);
                        }
                        
                        $subnamespaceID         = retrieve_id_subnamespace_for_istituzione($dbNBN, $login, $istituzioneNome);
                        $checkDatasource        = check_datasource_into_nbn($dbNBN, $tesiNomeDatasource, $tesiUrlOai);
                    
                        if($checkDatasource == 0){
                            $insertDatasource     = insert_into_nbn_datasource($dbNBN, $tesiNomeDatasource, $tesiUrlOai, $subnamespaceID, 'td');
                        } else {
                            $alertTesi = 'Nome datasource e url datasource già presenti';
                        }
                    
                        $idDatasource           = retrieve_id_datasource_for_istituzione($dbNBN, $tesiNomeDatasource, $subnamespaceID, $tesiUrlOai);
                        $insertAgent            = insert_into_nbn_agent($dbNBN, $tesiNomeDatasource, $tesiUrlOai, $tesiUserApiNBN, $tesiPwdApiNBN, $tesiIpApiNBN, $idDatasource, $subnamespaceID, $servizioAbilitato);
                    
                        //INSERT INTO HARVEST
                    
                        $insertAnagrafe         = insert_into_harvest_anagrafe($dbHarvest, $uuidIstituzione, $idDatasource, $login, $tesiUrlOai, $tesiContatti, $tesiFormatMetadati, $tesiSetMetadati, $tesiUtenzaEmbargo, $tesiPwdEmbargo, $servizioAbilitato);
                    
                        if ($insertAnagrafe == 1) {
                    
                            $journalUserApiNBN    = '';
                            $journalPwdApiNBN     = '';
                    
                            send_notice_nbn_email_to_admin($dbMD, $tesiUserApiNBN, $tesiPwdApiNBN, $journalUserApiNBN, $journalPwdApiNBN);

                            //echo "<script>window.location.href = 'http://localhost/local/area-riservata/superadmin/add-istituzione'</script>";
                            echo "<script>window.location.href = 'http://md-collaudo.depositolegale.it/area-riservata/superadmin/add-istituzione'</script>";

                        }
                    }

                    if(isset($_POST['journalNomeDatasource']) && $_POST['journalNomeDatasource'] != ''){

                        $journalNomeDatasource  = $_POST['journalNomeDatasource'];
                        $servizioAbilitato      = 'ej';
                        $journalUtenzaEmbargo   = '';
                        $journalPwdEmbargo      = '';

                        if (isset($_POST['journalUrlOai']) && $_POST['journalUrlOai'] != '') {
                            $journalUrlOai = $_POST['journalUrlOai'];
                        }
                        if (isset($_POST['journalContatti']) && $_POST['journalContatti'] != '') {
                            $journalContatti = $_POST['journalContatti'];
                        }
                        if (isset($_POST['journalFormatMetadati']) && $_POST['journalFormatMetadati'] != '') {
                            $journalFormatMetadati = $_POST['journalFormatMetadati'];
                        }
                        if (isset($_POST['journalSetMetadati']) && $_POST['journalSetMetadati'] != '') {
                            $journalSetMetadati = $_POST['journalSetMetadati'];
                        }
                        if (isset($_POST['journalUserApiNBN']) && $_POST['journalUserApiNBN'] != '') {
                            $journalUserApiNBN = $_POST['journalUserApiNBN'];
                        }
                        if (isset($_POST['journalPwdApiNBN']) && $_POST['journalPwdApiNBN'] != '') {
                            $journalPwdApiNBN = $_POST['journalPwdApiNBN'];
                        }
                        if (isset($_POST['journalIpApiNBN']) && $_POST['journalIpApiNBN'] != '') {
                            $journalIpApiNBN = $_POST['journalIpApiNBN'];
                        }

                        if (empty($journalServizioAttivo)) {

                            $insertServizio = insert_into_md_servizi($dbMD, $uuidIstituzione, $servizioAbilitato);

                        }
                    
                        //INSERT INTO NBN
                        $checkSubnamespace = check_istituzione_exist_nbn_subnamespace($dbNBN, $login, $istituzioneNome);
                    
                        if($checkSubnamespace == 0){
                    
                            $insertSubnamespace = insert_into_nbn_subnamespace($dbNBN, $login, $istituzioneNome);
                    
                        }
                    
                        $subnamespaceID         = retrieve_id_subnamespace_for_istituzione($dbNBN, $login, $istituzioneNome);
                        $checkDatasource        = check_datasource_into_nbn($dbNBN, $journalNomeDatasource, $journalUrlOai);
                    
                        if($checkDatasource == 0){
                    
                            $insertDatasource = insert_into_nbn_datasource($dbNBN, $journalNomeDatasource, $journalUrlOai, $subnamespaceID, 'ej');
                    
                        } else {
                    
                            $alertJournal = 'Nome datasource e url datasource già presenti';
                            
                        }
                    
                        $idDatasource = retrieve_id_datasource_for_istituzione($dbNBN, $journalNomeDatasource, $subnamespaceID, $journalUrlOai);
                    
                        $insertAgent = insert_into_nbn_agent($dbNBN, $journalNomeDatasource, $journalUrlOai, $journalUserApiNBN, $journalPwdApiNBN, $journalIpApiNBN, $idDatasource, $subnamespaceID, $servizioAbilitato);
                    
                    
                        //INSERT INTO HARVEST
                    
                        $insertAnagrafe = insert_into_harvest_anagrafe($dbHarvest, $uuidIstituzione, $idDatasource, $login, $journalUrlOai, $journalContatti, $journalFormatMetadati, $journalSetMetadati, $journalUtenzaEmbargo, $journalPwdEmbargo, $servizioAbilitato);
                    
                        if ($insertAnagrafe == 1) {
                    
                            $tesiUserApiNBN = '';
                            $tesiPwdApiNBN  = '';
                    
                            $mail = send_notice_nbn_email_to_admin($dbMD, $tesiUserApiNBN, $tesiPwdApiNBN, $journalUserApiNBN, $journalPwdApiNBN);

                            echo "<script>window.location.href = 'http://localhost/local/area-riservata/superadmin/add-istituzione'</script>";
                            //echo "<script>window.location.href = 'http://md-collaudo.depositolegale.it/area-riservata/superadmin/add-istituzione'</script>";
                        }

                    }

                } else {
                    echo "<script>window.location.href = 'http://localhost/local/area-riservata/superadmin/add-istituzione'</script>";
                    //echo "<script>window.location.href = 'http://md-collaudo.depositolegale.it/area-riservata/superadmin/add-istituzione'</script>";
                }
            }
            

        }

    }

    get_header();

?>

<section>
   <div class="container">

   <?php if(isset($error)) { ?>
      <div class='alert alert-warning mt-3 mb-5'><?php echo $error ?></div>
   <?php } ?>

    <form action="" method="POST">
        <!-- Anagrafica Istituzione -->
        <div class="row">
            <div class="col-md-12">
                <h6 class="mt-4 mb-4">Anagrafica Istituzione</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="nome">Nome istituto</label>
                <input name="nome" type="text" >
            </div>
            <div class="col-md-6">
                <label for="piva">Partita IVA istituto</label>
                <input name="piva" type="text" >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="indirizzo">Indirizzo istituto</label>
                <input name="indirizzo" type="text" >
            </div>
            <div class="col-md-6">
                <label for="regioneID">Regione</label>
                <select name="regioneID" class="selectSignup" >
                    <option value="regione">Scegli una regione</option>

                    <?php foreach($allRegions as $regionsElement){ ?>
                        <option value="<?php echo $regionsElement->ID ?>"><?php echo $regionsElement->NOMEREGIONE ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="telefono">Telefono istituto</label>
                <input name="telefono" type="text" >
            </div>
            <div class="col-md-6">
                <label for="url">URL istituto</label>
                <input name="url" type="text" >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="nomeContatto">Nome contatto istituto</label>
                <input name="nomeContatto" type="text" >
            </div>
            <div class="col-md-6">
                <label for="note">Note</label>
                <input name="note" type="text" >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="altro">Altro</label>
                <input name="altro" type="text" >
            </div>
            <div class="col-md-6"></div>
        </div>
        <!-- Anagrafica Utente Istituzione -->
        <div class="row">
            <div class="col-md-12">
                <h6 class="mt-4 mb-4">Anagrafica del gestore dell'istituzione</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="utenteNome">Nome gestore dell'istituzione</label>
                <input name="utenteNome" type="text" >
            </div>
            <div class="col-md-6">
                <label for="utenteCognome">Cognome gestore dell'istituzione</label>
                <input name="utenteCognome" type="text" >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="utenteEmail">E-mail gestore dell'istituzione</label>
                <input name="utenteEmail" type="email" >
            </div>
            <div class="col-md-6">
                <label for="utenteCodicefiscale">Codice fiscale gestore dell'istituzione</label>
                <input name="utenteCodicefiscale" type="text" required>
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
                <label for="nomeLogin">Nome per il login</label>
                <input name="nomeLogin" type="text">
                <?php if(isset($alertNome)) { ?>
                    <div class='alert alert-warning'><?php echo $alertNome ?></div>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <label for="password">Password</label>
                <input name="password" type="password" id="password">
                <input type="checkbox" name="showPwd" id="showPwd"> <label for="showPwd">Mostra la password</label>

                <?php if(isset($alertPwd)) { ?>
                    <div class='alert alert-warning'><?php echo $alertPwd ?></div>
                <?php } ?>

            </div>
        </div>
            
            <!-- Iscrizione tesi di dottorato -->
        <div class="row">
            <div class="col-md-12">
                <h6 class="mt-4 mb-4">Iscrizione alle tesi di dottorato</h6>
                <?php if(isset($alertTesi)) { ?>
                    <div class='alert alert-warning'><?php echo $alertTesi ?></div>
                <?php } ?>
            </div>
        </div>
        <?php if(isset($alertTesi)) { ?>
            <div class='alert alert-warning'><?php echo $alertTesi ?></div>
        <?php } ?>
        <div class="row">
            <div class="col-md-6">
                <label for="tesiNomeDatasource">Nome Datasource (Obbligatorio se si iscrive l'istituzione al servizio)</label>
                <input type="text" name="tesiNomeDatasource" id="tesiNomeDatasource">
            </div>
            <div class="col-md-6">
                <label for="tesiUrlOai">URL sito OAI (Obbligatorio se si iscrive l'istituzione al servizio)</label>
                <input type="text" name="tesiUrlOai" id="tesiUrlOai">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="tesiContatti">Contatti (Obbligatorio se si iscrive l'istituzione al servizio)</label>
                <input type="text" name="tesiContatti" id="tesiContatti">
            </div>
            <div class="col-md-6">
                <label for="tesiFormatMetadati">Format dei metadati (Obbligatorio se si iscrive l'istituzione al servizio)</label>
                <input type="text" name="tesiFormatMetadati" id="tesiFormatMetadati">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="tesiSetMetadati">Set dei metadati (Obbligatorio se si iscrive l'istituzione al servizio)</label>
                <input type="text" name="tesiSetMetadati" id="tesiSetMetadati">
            </div>
            <div class="col-md-6">
                <label for="tesiUtenzaEmbargo">Utenza per accesso embargo</label>
                <input type="text" name="tesiUtenzaEmbargo" id="tesiUtenzaEmbargo">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="tesiPwdEmbargo">Password per accesso embargo</label>
                <input type="text" name="tesiPwdEmbargo" id="tesiPwdEmbargo">
            </div>
            <div class="col-md-6">
                <label for="tesiUserApiNBN">User per API NBN (Obbligatorio se si iscrive l'istituzione al servizio)</label>
                <input type="text" name="tesiUserApiNBN" id="tesiUserApiNBN">
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-6">
                <label for="tesiPwdApiNBN">Password per API NBN (Obbligatorio se si iscrive l'istituzione al servizio)</label>
                <input type="text" name="tesiPwdApiNBN" id="tesiPwdApiNBN">
            </div>
            <div class="col-md-6">
                <label for="tesiIpApiNBN">IP per API NBN (Obbligatorio se si iscrive l'istituzione al servizio)</label>
                <input type="text" name="tesiIpApiNBN" id="tesiIpApiNBN">
            </div>
        </div>

        <!-- Iscrizione eJournal -->
        <div class="row">
            <div class="col-md-12">
                <h6 class="mt-4 mb-4">Iscrizione agli eJournal</h6>
                <?php if(isset($alertJournal)) { ?>
                    <div class='alert alert-warning'><?php echo $alertJournal ?></div>
                <?php } ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <label for="journalNomeDatasource">Nome Datasource (Obbligatorio se si iscrive l'istituzione all'eJournal)</label>
                <input type="text" name="journalNomeDatasource" id="journalNomeDatasource">
            </div>
            <div class="col-md-6">
                <label for="journalUrlOai">URL sito OAI (Obbligatorio se si iscrive l'istituzione all'eJournal)</label>
                <input type="text" name="journalUrlOai" id="journalUrlOai">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="journalContatti">Contatti (Obbligatorio se si iscrive l'istituzione all'eJournal)</label>
                <input type="text" name="journalContatti" id="journalContatti">
            </div>
            <div class="col-md-6">
                <label for="journalFormatMetadati">Format dei metadati (Obbligatorio se si iscrive l'istituzione all'eJournal)</label>
                <input type="text" name="journalFormatMetadati" id="journalFormatMetadati">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="journalSetMetadati">Set dei metadati (Obbligatorio se si iscrive l'istituzione all'eJournal)</label>
                <input type="text" name="journalSetMetadati" id="journalSetMetadati">
            </div>
            <div class="col-md-6">
                <label for="journalUserApiNBN">User per API NBN (Obbligatorio se si iscrive l'istituzione all'eJournal)</label>
                <input type="text" name="journalUserApiNBN" id="journalUserApiNBN">
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-6">
                <label for="journalPwdApiNBN">Password per API NBN (Obbligatorio se si iscrive l'istituzione all'eJournal)</label>
                <input type="text" name="journalPwdApiNBN" id="journalPwdApiNBN">
            </div>
            <div class="col-md-6">
                <label for="journalIpApiNBN">IP per API NBN (Obbligatorio se si iscrive l'istituzione all'eJournal)</label>
                <input type="text" name="journalIpApiNBN" id="journalIpApiNBN">
            </div>
        </div>

        <!-- Submit Actions -->
        <div class="row mt-5">
            <div class="col-md-12 text-right">
                <input type="submit" name="submit" value="Crea nuova istituzione" class="btnAcceptSub"/>
            </div>
        </div>
    </form>


   </div>
</section>

<?php
   get_footer(); 
?>

<script>
    passwordToggle = document.getElementById('showPwd');
    passwordInput = document.getElementById('password');

    passwordToggle.addEventListener('change', function() {
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    
    }
);
</script>