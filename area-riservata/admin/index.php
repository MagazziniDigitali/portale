<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function PreOpeninsertIstituModal(idIstituzione) {
        document.getElementById("InsertIstituForm").reset();
    }
</script>
<?php
include("../../wp-load.php");
require("../src/functions.php");

if (!isset($_SESSION)) {
    session_start();
}

redirect_if_not_logged_in();

if ($_SESSION['role'] == 'superadmin') {

    $dbMD       = connect_to_md();
    $dbNBN      = connect_to_nbn();
    $dbHarvest  = connect_to_harvest();

    $pendingPreReg = check_istituzioni_to_be_approved($dbMD);



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['inserisciformSignupCustom'])) {
            $preRegIstituzionePiva = '';
            if (isset($_POST['pivaSignupCustom']) && $_POST['pivaSignupCustom'] != '') {
                $preRegIstituzionePiva = $_POST['pivaSignupCustom'];
            }
            $preRegIstituzionePassword = '';
            if (isset($_POST['passwordSignupCustom']) && $_POST['passwordSignupCustom'] != '') {
                $preRegIstituzionePassword = $_POST['passwordSignupCustom'];
            }
            $preRegIstituzioneNome = '';
            if (isset($_POST['istitutoSignupCustom']) && $_POST['istitutoSignupCustom'] != '') {
                $preRegIstituzioneNome = $_POST['istitutoSignupCustom'];
            }
            $preRegIstituzioneIndirizzo = '';
            if (isset($_POST['indirizzoSignupCustom']) && $_POST['indirizzoSignupCustom'] != '') {
                $preRegIstituzioneIndirizzo = $_POST['indirizzoSignupCustom'];
            }
            $preRegIstituzioneTelefono = '';
            if (isset($_POST['telefonoSignupCustom']) && $_POST['telefonoSignupCustom'] != '') {
                $preRegIstituzioneTelefono = $_POST['telefonoSignupCustom'];
            }
            $preRegIstituzioneNomeContatto = '';
            if (isset($_POST['nomeContattoSignupCustom']) && $_POST['nomeContattoSignupCustom'] != '') {
                $preRegIstituzioneNomeContatto = $_POST['nomeContattoSignupCustom'];
            }
            $preRegIstituzioneNote = '';
            if (isset($_POST['noteSignupCustom']) && $_POST['noteSignupCustom'] != '') {
                $preRegIstituzioneNote = $_POST['noteSignupCustom'];
            }
            $preRegIstituzioneUrl = '';
            if (isset($_POST['urlSignupCustom']) && $_POST['urlSignupCustom'] != '') {
                $preRegIstituzioneUrl = $_POST['urlSignupCustom'];
            }
            $preRegIstituzioneRegione = '';
            if (isset($_POST['regioneSignupCustom']) && $_POST['regioneSignupCustom'] != '' && $_POST['regioneSignupCustom'] != 'regione') {
                $preRegIstituzioneRegione = $_POST['regioneSignupCustom'];
            } else {
                $alert = "Inserire una regione";
            }

            $preRegUtenteCognome = '';
            if (isset($_POST['cognomeUtenteSignupCustom']) && $_POST['cognomeUtenteSignupCustom'] != '') {
                $preRegUtenteCognome = $_POST['cognomeUtenteSignupCustom'];
            }
            $preRegUtenteNome = '';
            if (isset($_POST['nomeUtenteSignupCustom']) && $_POST['nomeUtenteSignupCustom'] != '') {
                $preRegUtenteNome = $_POST['nomeUtenteSignupCustom'];
            }
            $preRegUtenteCodiceFiscale = '';
            if (isset($_POST['cfUtenteSignupCustom']) && $_POST['cfUtenteSignupCustom'] != '') {
                $preRegUtenteCodiceFiscale = $_POST['cfUtenteSignupCustom'];
            }
            $preRegUtenteEmail = '';
            if (isset($_POST['emailUtenteSignupCustom']) && $_POST['emailUtenteSignupCustom'] != '') {
                $preRegUtenteEmail = $_POST['emailUtenteSignupCustom'];
            }
            $preRegNomeLogin = '';
            if (isset($_POST['preRegNomeLogin']) && $_POST['preRegNomeLogin'] != '') {
                $preRegNomeLogin = $_POST['preRegNomeLogin'];
            } else {
                $alertNome = "Nome utente errato";
            }
            $preRegPassword = '';
            if (isset($_POST['preRegPassword']) && $_POST['preRegPassword'] != '') {
                $preRegPassword = $_POST['preRegPassword'];
            } else {
                $alertPwd = "Password errata";
            }


            if (($preRegNomeLogin != '') && ($preRegPassword != '')) {
                $checkLogin = check_login_istituzione($dbMD, $preRegNomeLogin);
                if ($checkLogin == 0) { // Nuova istituzione
                    $uuidIstituzione            = generate_uuid($dbMD);
                    $uuidUtente                 = generate_uuid($dbMD);
                    $admin                      = 1;
                    $superadmin                 = 0;
                    $preRegAltaRisoluzione      = 0;
                    $preRegTesiDottorato        = 0;
                    $ipAutorizzati              = '*.*.*.*';
                    $insertIstituzione = insert_new_istituzione($dbMD, $uuidIstituzione, $preRegNomeLogin, $preRegPassword, $preRegIstituzioneNome, $preRegIstituzioneIndirizzo, $preRegIstituzioneTelefono, $preRegIstituzioneNomeContatto, $preRegIstituzioneNote, $preRegIstituzioneUrl, $preRegIdRegione, $preRegIstituzionePiva, $preRegAltaRisoluzione);
                    if ($insertIstituzione != 1) {
                        $errorIstituzione = insert_new_istituzione_check_errors($dbMD);
                    } else {
                        $insertGestoreIstituzione = insert_new_gestore_istituzione($dbMD, $uuidUtente, $preRegNomeLogin, $preRegPassword, $preRegUtenteCognome, $preRegUtenteNome, $admin, $uuidIstituzione, $preRegUtenteCodicefiscale, $preRegUtenteEmail, $superadmin, $ipAutorizzati);
                        if ($insertGestoreIstituzione != 1) {
                            $errorUtente = insert_new_gestore_istituzione_check_errors($dbMD);
                        } else {
                            $uuidSoftware = generate_uuid($dbMD);
                            $insertSoftware = insert_new_software($dbMD, $uuidSoftware, $uuidIstituzione, $preRegNomeLogin, $preRegPassword, $preRegIstituzioneNome);
                            if ($insertGestoreIstituzione == 1) {
                                $insertSoftwareConfig = insert_new_software_config($dbMD, $uuidSoftware, $preRegPassword, $preRegIstituzionePiva);
                            }
                        }
                    }
                    if ($insertIstituzione && $insertGestoreIstituzione) {
                        send_approved_signup_email($preRegUtenteEmail, $preRegUtenteNome, $preRegUtenteCognome, $preRegNomeLogin, $preRegPassword);
                        echo "<script>window.location.href = '/area-riservata/admin/'</script>";
                    }
                } // Emd Nuova istituzione
                else {
                    $errorUtente = 'Nome per il login già in uso';
                }
            } // End if preRegistrazione
        } // End if(isset($_POST['inserisciformSignupCustom']))
    } // End if POST
    get_header();
?>

    <header class="entry-header has-text-align-center header-footer-group" style="background: white;">


        <div class="entry-header-inner section-inner medium">

            <h1 class="entry-title">Home SuperAdmin</h1>
        </div><!-- .entry-header-inner -->

    </header>
    <section>
        <div class="container">
            <p>Benvenuto <strong><?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?></strong></p>
            <?php if ($_SESSION['istituzione'] != 'istituzioneBase') { ?>
                <p>Istituzione di appartenenza: <?php echo $_SESSION['istituzione'] ?></p>
            <?php } ?>

            <div id="accordionRichiesteSignup">
                <!-- Controllo richieste da approvare -->
                <?php
                if ($pendingPreReg == 0) { ?>

                    <h5>Non ci sono richieste di registrazione da approvare</h5>

                    <?php } else {

                    if ($pendingPreReg == 1) { ?>

                        <h5>C'è una richiesta di registrazione da approvare</h5>

                        <?php include("approve-signup.php"); ?>

                    <?php } else { ?>

                        <h5>Lista richieste di registrazione da approvare: <?php echo $pendingPreReg ?> </h5>

                        <?php include("approve-signup.php"); ?>

                    <?php } ?>

                <?php } ?>
            </div>

            <!-- <div id="addUser">
            <h5>Aggiungi un utente</h5>
            <?php //include("add-user.php"); 
            ?>
         </div> -->

            <div id="showAllUser">
                <h5>Lista Istituzioni:
                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#insertIstituModal" onclick="PreOpeninsertIstituModal()"> <!-- '< PreOpeninsertIstituModal(?php echo $idIst ?>')"> -->
                        <i class="icon-plus icon-2x" title="Aggiungi un nuovo Istituto"></i>
                    </button>
                </h5>
                <?php include("show-users.php"); ?>
            </div>
        </div>
    </section>

    <!-- Modal inserisci istituto -->
    <div class="modal fade" id="insertIstituModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="insertIstModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="" method="post" id="InsertIstituForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertIstModalLabel" style="margin-right: 2.5rem;margin-bottom: 2rem;">Inserisci Istituto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- <form action="" method="post"> -->
                        <input type="hidden" name="id_Ist_modalNewUser" id="id_Ist_modalNewUser" value="">

                        <div class="row">
                            <div class="col-md-12">
                                <h6>Anagrafica Istituzione</h6>
                            </div>
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
                                    <?php foreach ($allRegions as $regionsElement) { ?>
                                        <option value="<?php echo $regionsElement->ID ?>"><?php echo $regionsElement->NOMEREGIONE ?></option>
                                    <?php } ?>
                                </select>
                                <?php if (isset($alert)) { ?>
                                    <div class='alert alert-warning mt-3'><?php echo $alert ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Anagrafica Utente</h6>
                            </div>
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
                        <!-- </form> -->
                        <br>
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
                                <?php if (isset($alertNome)) { ?>
                                    <div class='alert alert-warning'><?php echo $alertNome ?></div>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <label for="preRegPassword">Password</label>
                                <input name="preRegPassword" type="password" id="password">
                                <!-- <input type="checkbox" name="showPwd" id="showPwd"> <label for="showPwd">Mostra la password</label> -->

                                <?php if (isset($alertPwd)) { ?>
                                    <div class='alert alert-warning'><?php echo $alertPwd ?></div>
                                <?php } ?>

                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="row col-md-12">
                            <div class="col-md-6"><input style="background: darkgrey;" type="button" data-dismiss="modal" name="Chiudi" value="Chiudi" class="mt-3 float-left"></div>
                            <div class="col-md-6"><input type="submit" name="inserisciformSignupCustom" value="Inserisci" class="mt-3 float-right"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
} // End if($_SESSION['role'] == 'superadmin')
get_footer();
?>

<script>
    passwordToggle = document.getElementById('showPwd');
    passwordInput = document.getElementById('passwordCustom');

    passwordToggle.addEventListener('change', function() {

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }

    });
</script>