<?php
include_once("../../wp-load.php");
include_once("../src/functions.php");


if (!isset($_SESSION)) {
   session_start();
}

redirect_if_not_logged_in();

if ($_SESSION['role'] != 'admin_istituzione') {
   redirect_if_logged_in();
} else {
   $dbMD = connect_to_md();
   $checkUserPerIstituzione = check_users_for_istituzione($dbMD);
   get_header();
?>
<header id="homeHeader" class="entry-header welcomePad has-text-align-center">
        <div class="entry-header-inner section-inner medium">
        <h5 class="entry-title"><?php echo $_SESSION['istituzione'] ?></h5>
         <h4 class="entry-title">Benvenuto <?php echo ($_SESSION['name'] . ' ' . $_SESSION['surname']); ?></h4>
        </div>
    </header>
      <div class="container margin-top-15">
      <!--   <p class="text-center">Benvenuto <strong><?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?></strong></p>
         <?php if ($_SESSION['istituzione'] != 'istituzioneBase') { ?>
            <p class="text-center">Istituzione di appartenenza: <strong><?php echo $_SESSION['istituzione'] ?></strong></p>
         <?php } ?> -->

         <div id="addUser">
            <h6>Aggiungi un utente</h6>
            <?php include("add-user.php"); ?>
         </div>

         <div id="showUsers">
            <h5>Utenti registrati</h5>
            <div class="divServizi">

            <?php if ($checkUserPerIstituzione == 0) { ?>
               <p>Non ci sono utenti da mostrare</p>
            <?php } else {
               include("show-users.php");
            } ?>
            </div>
         </div>

         <?php
         $_isviewonly = true;
         include_once("signup-services.php");

         ?>


         <div id="signupServices">
            <h6>Registra l'istituzione ai servizi:</h6>
            <div class="row">

               <?php if (empty($tesiServizioAttivo) || empty($tesiAll)) { ?>
                  <div class="col-md-3">
                   <button style="background: cadetblue; height: 85px;" name="gotosignupTesiDottorato" type="button" class="col-md-12 mt-3 float-left" onclick="openInsertModal('td')">
                    Harvest </br> Tesi di Dottorato
                  </button>
                  </div>
               <?php } ?>
                  <!--onclick="location.href='signup-services#eJournal';" -->
               <div class="col-md-3">         
                <button style="background: cadetblue; height: 85px;" name="gotosignupEJournal" type="button" class="col-md-12 mt-3 float-left" onclick="openInsertModal('ej')">
                Harvest </br> e-Journal
                  </button>
                </div>

               <div class="col-md-3">
                <button style="background: cadetblue; height: 85px;" name="gotosignupEBook" type="button" class="col-md-12 mt-3 float-left" onclick="openInsertModal('eb')">
                e-Book
                  </button>
               </div>
               <div class="col-md-3">
                <button style="background: cadetblue; height: 85px;" name="gotosignupNbn" type="button" class="col-md-12 mt-3 float-left" onclick="openInsertModal('nbn')">
                NBN
                    </button>
               </div>

            </div>
            <!-- <a  href="signup-services#tesiDottorato">Tesi di Dottorato</a>, <a href="signup-services#eJournal">e-Journal</a>, <a href="signup-services#eBook">e-Book</a> -->
         </div>




      </div>


<?php }
get_footer();
?>
  <!-- Modal inserisci servizio -->
  <div class="modal fade" id="insertIstModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="insertIstModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form action="" method="post" id="InsertIstForm">
          <div class="modal-header">
            <h5 class="modal-title" id="insertIstModalLabel" style="margin-right: 2.5rem;margin-bottom: 2rem;">Inserisci Servizio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id_Ist_modal" id="id_Ist_modal" value="<?php echo $uuidIstituzione ?>">
            <input type="hidden" name="Ist_name_modal" id="Ist_name_modal" value="<?php echo $_SESSION['istituzione'] ?>">
            <input type="hidden" name="Ist_login_modal" id="Ist_login_modal" value="<?php echo $_SESSION['username'];?>">
            <input type="hidden" name="selectType" id="selectType" value="">

            
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="selectType">Tipo Servizio *</label>
                  <select disabled class="form-control" id="selectionTipoServType" name="selectionTipoServType" style="font-size: 100%;"
                  onchange="onChangeTipoServizio(this)">
                    <option value="">Seleziona Tipo Servizio...</option>
                    <option value="td">Harvest Tesi di Dottorato</option>
                    <option value="ej">Harvest E-Journal</option>
                    <option value="eb">E-Book</option>
                    <option value="nbn">National Bibliography Number</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row" id="alertSelezionaTipo">
                <div class="col-md-12">
                 Seleziona il Tipo di Servizio per inserire i dati
                </div>
            </div>
            <div class="row">
              <div class="col-md-6" id="tsDataSource"> <!--nomeDatasource -->
                <label for="nomeDatasource">Nome Datasource *</label>
                <input name="nomeDatasource" value="" id="nomeDatasource"type="text">
              </div>
              <div class="col-md-6" id="tsSitoOai">
                <label for="url">URL sito <span id="tsSitoOaiLabel">OAI</span> *</label>
                <input name="url" value="" type="text">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6" id="tsContatti">
                <label for="contatti">Contatti *</label>
                <input name="contatti" value="" type="text">
              </div>
              
            </div>
            <div class="row">
            <div class="col-md-6" id="tsFormat">
                <label for="format">Format dei metadati *</label>
                <input name="format" value="" type="text">
              </div>
              <div class="col-md-6" id="tsSet">
                <label for="set">Set dei metadati *</label>
                <input name="set" value="" type="text">
              </div>
             
            </div>
            <div class="row">
            <div class="col-md-6" id="tsEmbargo">
                <label for="userEmbargo">Utenza per accesso embargo *</label>
                <input name="userEmbargo" value="" type="text">
              </div>
              <div class="col-md-6"  id="tsPwdEmbargo">
                <label for="pwdEmbargo">Password per accesso embargo *</label>
                <input name="pwdEmbargo" value="" type="text">
              </div>
            </div>
            <div class="row">
            <div class="col-md-6" id="tsNbnApi">
                <label for="userNBN">User per API NBN *</label>
                <input name="userNBN" value="" type="text">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6" id="tsNbnPsw">
                <label for="pwdNBN">Password per API NBN *</label>
                <input name="pwdNBN" value="" type="text">
              </div>
              <div class="col-md-6" id="tsNbnIp">
                <label for="ipNBN">IP per API NBN *</label>
                <input name="ipNBN" value="" type="text">
              </div>
            </div>
            <div class="row">
                <div  id="infoCampiObbbl" class="col-md-6 margin-top-5">
                <label>I campi segnati da * (asterisco) sono obbligatori</label>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="row col-md-12">
              <div class="col-md-6"><input style="background: darkgrey;" type="button" onclick="closeInsertModal()" name="Chiudi" value="Chiudi" class="mt-3 float-left"></div>
              <div class="col-md-6"><input type="submit" name="inserisciServizio" value="Inserisci" class="mt-3 float-right"></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div> 

  <script>

  function onChangeTipoServizio(tipoServizioField) {
     debugger
     let tipoServizio = tipoServizioField.value;
     showAllFieldsServizio()
     enableField('nomeDatasource')
    switch (tipoServizio) {
      case "nbn": //Lasciare visibili solo campi NBN e Nome Datasource
        hideFields([
                  "tsSitoOaiLabel",
                  "tsContatti",
                  "tsFormat",
                  "tsSet",
                  "tsEmbargo",
                  "tsPwdEmbargo",
                  ]);
        break;
      case "td": {
        disableField('nomeDatasource');
        setIstitutoLoginToDataSource();
        hideFields([ "tsNbnApi",
                  "tsNbnPsw",
                  "tsNbnIp"
                  ]);
      break;
      }
      
      case "ej":
        hideFields([ "tsEmbargo",
                  "tsPwdEmbargo",
                  "tsNbnApi",
                  "tsNbnPsw",
                  "tsNbnIp"
                  ]);
      break;
      case "eb":
        hideFields([ "tsEmbargo",
                  "tsPwdEmbargo",
                  "tsNbnApi",
                  "tsNbnPsw",
                  "tsNbnIp",
                  "tsFormat",
                  "tsSet",
                  ]);
      break;
      default:
      hideAllFieldsServizio()
     // showAllFieldsServizio()
        break;
    }
  }
  function hideFields(fieldIds) {
    if(fieldIds == null || fieldIds == undefined || fieldIds.length == 0)
      return;
    fieldIds.forEach(id => {
      setDisplay(id, "none")
    });
  }
  function showAllFieldsServizio() {
    hideFields(["alertSelezionaTipo"])
    showFields([  "tsSitoOaiLabel",
                  "tsDataSource",
                  "tsSitoOai",
                  "tsContatti",
                  "tsFormat",
                  "tsSet",
                  "tsEmbargo",
                  "tsPwdEmbargo",
                  "tsNbnApi",
                  "tsNbnPsw",
                  "tsNbnIp"]);
  }
  function hideAllFieldsServizio() {
    showFields(["alertSelezionaTipo"])
    hideFields([ "infoCampiObbbl",
                 "tsDataSource",
                 "tsSitoOaiLabel",
                  "tsSitoOai",
                  "tsContatti",
                  "tsFormat",
                  "tsSet",
                  "tsEmbargo",
                  "tsPwdEmbargo",
                  "tsNbnApi",
                  "tsNbnPsw",
                  "tsNbnIp"]);
  }
  function showFields(fieldIds) {
    if(fieldIds == null || fieldIds == undefined || fieldIds.length == 0)
      return;
    fieldIds.forEach(id => {
      setDisplay(id, "inline")
    });
  }
  function setDisplay(id, cssAction) {
    var x = document.getElementById(id);
    x.style.display = cssAction;
  }
  function disableField (id) {
    $('#' + id).prop("readonly", true);
    $('#' + id).addClass("disabilitato");
  }
  function enableField (id) {
   
    $('#' + id).prop("readonly", false);
    $('#' + id).removeClass("disabilitato");

  }
 function onChangeDataSource(dataSourceField) {
  let nomeDataSource = dataSourceField.value;
  }
  function setIstitutoLoginToDataSource() {
    
    var istLogin = $("#Ist_login_modal").val()
    $("#nomeDatasource").val(istLogin)    
  }
  function openInsertModal(servizioSelezionato) {
     
   $("#insertIstModal").modal('show');
   setTimeout(() => {
   $("#selectType").val(servizioSelezionato).trigger('change');
   $("#selectionTipoServType").val(servizioSelezionato).trigger('change');;
   $("#selectionTipoServType option").attr("selected", false);
   $("#selectionTipoServType option[value='"+ servizioSelezionato +"']").attr("selected", true);

   }, 500); //1000 1 sec
  }
  function closeInsertModal() {
   $("#insertIstModal").modal('hide');
  }
   closeInsertModal();
   hideAllFieldsServizio();
</script>