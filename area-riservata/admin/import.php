<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>

  function PreOpenDeleteServiceModal(rimuoviServizio, userNBN, idSubNamespace, nomeDatasource, idDatasource) {
    $(".modal-body #rimuoviServizio_modalDeleteService").val($userNBN);
    $(".modal-body #userNBN_modalDeleteService").val($userNBN);
    $(".modal-body #idSubNamespace_modalDeleteService").val($idSubNamespace);
    $(".modal-body #nomeDatasource_modalDeleteService").val($nomeDatasource);
    $(".modal-body #idDatasource_modalDeleteService").val($idDatasource);
  }

  $("#aprovaCancellazioneServizio").click(function(e) {
    console.log(this);
    console.log("aprovaCancellazioneServizio");
    
    var _rimuoviServizio=$(".modal-body #rimuoviServizio_modalDeleteService").val(rimuoviServizio);
    var _userNBN=$(".modal-body #userNBN_modalDeleteService").val(userNBN);
    var _idSubNamespace=$(".modal-body #idSubNamespace_modalDeleteService").val(idSubNamespace);
    var _nomeDatasource=$(".modal-body #nomeDatasource_modalDeleteService").val(nomeDatasource);
    var _idDatasource=$(".modal-body #idDatasource_modalDeleteService").val(idDatasource);

    jQuery.ajax({
      type: "POST",
      url: 'import.php',
      dataType: 'json',
      data: {
        _rimuovi_servizio: _rimuovi_servizio, // eg "rimuoviTesi"
        userNBN: _userNBN,
        idSubNamespace: _idSubNamespace,
        nomeDatasource: _nomeDatasource,
        idDatasource: _idDatasource,
      },
    });
  });


</script>


<?php
include("../../wp-load.php");
require("../src/functions.php");
require("../src/Htpasswd.php");
define('SITE_ROOT', realpath(dirname(__FILE__)));

if (!isset($_SESSION)) {
  session_start();
}
redirect_if_not_logged_in();

include_once("import_functions.php");

$g_loginIstituzione = "";
$g_nomeIstituzione = "";
$g_idIstituzione = "";

if ($_SESSION['role'] == 'superadmin') {

  $dbMD       = connect_to_md();
  $dbNBN      = connect_to_nbn();
  $dbHarvest  = connect_to_harvest();
  // test();
  if (isset($_POST["ApprovaUser"])) {
    if (isset($_POST['argument'])) {
      $_iduser = $_POST['argument'];
      set_approve_to_true_import($dbMD, $_iduser);
    }
  }

  if (isset($_POST["SendMailToUser"])) {
    send_mail_to_user($dbMD);
  }

  if (isset($_POST["UpladFile"])) {
    upload_file($dbNBN, $dbMD, $dbHarvest);
  } // End if (isset($_POST["UpladFile"]))
}  // End if ($_SESSION['role'] == 'superadmin')

get_header();
?>
 <header id="homeHeader" class="entry-header welcomePad has-text-align-center">
        <div class="entry-header-inner section-inner medium">
           <!-- <h4 class="entry-title">Benvenuto <strong><?php echo ($_SESSION['name'] . ' ' . $_SESSION['surname']); ?></strong> (SuperAdmin)</h4> -->
            <h5 class="text-center">Import Istituzioni</h5>
        </div>
    </header>
  <div class="container margin-top-15">
   <!-- <p>Benvenuto <strong><?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?></strong></p> -->
    <form action="" method="post" enctype="multipart/form-data">
      Seleziona un file* da caricare:
      <input type="file" accept=".csv" name="file" id="file">
      <input type="submit" value="Carica File" name="UpladFile">
    </form>

    <h6>
      * i file da importare devono essere in formato csv.
    </h6>
  </div>
  <div class="container">
    <div id="showAllUser">
      <h5>Lista Istituzioni Importate:
        <div id="buttons" style="display: none;">
          <button type="button" class="btn btn-outline-secondary" onclick="" disabled>
            <i class="icon-remove icon-2x" title="cancella Istituto"></i>
          </button>
          <button type="button" class="btn btn-outline-secondary" onclick="" disabled>
            <i class="icon-list icon-2x" title="approva Istituto"></i>
          </button>
          <button type="button" class="btn btn-outline-secondary" onclick="" disabled>
            <i class="icon-envelope-alt icon-2x" title="invia mail al risponsabile dell'istituto"></i>
          </button>
        </div>
      </h5>

      <?php
      $isImport = 1;
      include("show-users.php"); ?>
    </div>
  </div>
<?php
get_footer();
?>

<script>
  $(".form-check-input").change(function() {

    if ($('input:checked').length > 0) {
      $("#buttons").show();
    } else {
      $("#buttons").hide();
    }
  });

  $(".utente-mail").click(function(e) {
    console.log(this);4
    console.log(this.id);
    jQuery.ajax({
      type: "POST",
      url: 'import.php',
      dataType: 'json',
      data: {
        SendMailToUser: 'SendMailToUser',
        argument: this.id
      },

    });
  });

  $(".utente-approva").click(function(e) {
    console.log(this);
    console.log(this.id);
    jQuery.ajax({
      type: "POST",
      url: 'import.php',
      dataType: 'json',
      data: {
        ApprovaUser: 'ApprovaUser',
        argument: this.id
      },

    });
  });




</script>
