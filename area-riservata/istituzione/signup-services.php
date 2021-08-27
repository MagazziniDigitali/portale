<?php
include_once("../../wp-load.php");;
include_once("../src/functions.php");
include_once("../src/Htpasswd.php");
include_once("../src/debug.php");
include_once("signup-services-functions.php");

if (!isset($_SESSION)) {
  session_start();
}

redirect_if_not_logged_in();

if ($_SESSION['role'] == 'admin_istituzione') {

  $dbMD           = connect_to_md();
  $dbHarvest      = connect_to_harvest();
  $dbNBN          = connect_to_nbn();

  $uuidIstituzione    = check_istituizone_session($dbMD);
  $istituzione        = retrieve_login_istituzione($dbMD, $uuidIstituzione);
  $loginIstituzione   = $istituzione[0]->LOGIN;
  $nomeIstituzione    = $istituzione[0]->NOME;

  if (!isset($_isviewonly)) {
    $_isviewonly = false;
  }



  if (isset($_POST['signupTesiDottorato']))
    signupTesiDottorato($dbMD, $dbHarvest, $dbNBN, $uuidIstituzione, $loginIstituzione, $nomeIstituzione);
  elseif (isset($_POST['signupJournal']))
    signupJournal($dbMD, $dbHarvest, $dbNBN, $uuidIstituzione, $loginIstituzione, $nomeIstituzione);
  elseif (isset($_POST['signupBook']))
    signupBook($dbMD, $dbHarvest, $dbNBN, $uuidIstituzione, $loginIstituzione, $nomeIstituzione);
  
  elseif (isset($_POST['modificaTesi']))
    modificaServizio($dbHarvest, $dbNBN, $uuidIstituzione, $loginIstituzione, "td");
  elseif (isset($_POST['modificaJournal']))
    modificaServizio($dbHarvest, $dbNBN, $uuidIstituzione, $loginIstituzione, "ej");
  elseif (isset($_POST['modificaBook']))
    modificaServizio($dbHarvest, $dbNBN, $uuidIstituzione, $loginIstituzione, "eb");

  elseif (isset($_POST['rimuoviTesi']))
    rimuoviServizio($dbNBN, $dbHarvest, "td"); // $uuidIstituzione, $loginIstituzione, 
  elseif (isset($_POST['rimuoviJournal']))
    rimuoviServizio($dbNBN, $dbHarvest, "ej");
  elseif (isset($_POST['rimuoviBook']))
    rimuoviServizio($dbNBN, $dbHarvest, "eb");



  $tesiServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $uuidIstituzione, 'td');
  $journalServizioAttivo  = check_if_istituzione_signed_for_service($dbMD, $uuidIstituzione, 'ej');
  $bookServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $uuidIstituzione, 'eb');

  if (!empty($tesiServizioAttivo)) {
    $subnamespaceID = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
    $idDatasource   = retrieve_id_datasource($dbNBN, $subnamespaceID, 'td');
    $tesiAll        = select_agent_ngn_and_anagrafe_harvest($dbNBN, $dbHarvest, 'td', $subnamespaceID, $idDatasource);
  }

  if (!empty($journalServizioAttivo)) {

    $subnamespaceID = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
    $idDatasource   = retrieve_id_datasource($dbNBN, $subnamespaceID, 'ej');
    $journalAll     = select_agent_ngn_and_anagrafe_harvest($dbNBN, $dbHarvest, 'ej', $subnamespaceID, $idDatasource);
  }

  if (!empty($bookServizioAttivo)) {

    $subnamespaceID = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
    $idDatasource   = retrieve_id_datasource($dbNBN, $subnamespaceID, 'eb');
    $bookAll        = select_agent_ngn($dbNBN, 'eb', $subnamespaceID);
  }

  get_header();
?>

  <section>
    <div class="container">

      <!-- <div id="tesiDottorato">

      <?php if (empty($tesiServizioAttivo)) {  ?>
        <?php if (!$_isviewonly) { ?>

        <h5>Registra l'istituzione al servizio di Tesi di Dottorato</h5>

        <?php if (isset($alertTesi)) { ?>
            <div class='alert alert-warning'><?php echo $alertTesi ?></div>
        <?php } ?>

        <form action="" method="post">
          <div class="row">
            <div class="col-md-6">
              <label for="tesiNomeDatasource">Nome Datasource</label>
              <input type="text" name="tesiNomeDatasource" required id="tesiNomeDatasource">
            </div>
            <div class="col-md-6">
              <label for="tesiUrlOai">URL sito OAI</label>
              <input type="text" name="tesiUrlOai" required id="tesiUrlOai">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="tesiContatti">Contatti</label>
              <input type="text" name="tesiContatti" required id="tesiContatti">
            </div>
            <div class="col-md-6">
              <label for="tesiFormatMetadati">Format dei metadati</label>
              <input type="text" name="tesiFormatMetadati" required id="tesiFormatMetadati">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="tesiSetMetadati">Set dei metadati</label>
              <input type="text" name="tesiSetMetadati" required id="tesiSetMetadati">
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
              <label for="tesiUserApiNBN">User per API NBN</label>
              <input type="text" name="tesiUserApiNBN" required id="tesiUserApiNBN">
            </div>
          </div>
          <div class="row"> 
            <div class="col-md-6">
              <label for="tesiPwdApiNBN">Password per API NBN</label>
              <input type="text" name="tesiPwdApiNBN" required id="tesiPwdApiNBN">
            </div>
            <div class="col-md-6">
              <label for="tesiIpApiNBN">IP per API NBN</label>
              <input type="text" name="tesiIpApiNBN" required id="tesiIpApiNBN">
            </div>
          </div>

          <div class="row">
            <div class="col-md-12"><input name="signupTesiDottorato" type="submit" value="Registra" class="mt-3 float-right"/></div>
          </div>
        </form>
        <?php } ?>
        <?php } else { ?>

        <h5>Sei già iscritto al servizio di Tesi di Dottorato</h5>

        <?php foreach ($tesiAll as $key => $results) {
          $nomeDatasource     = $results->agent_name;
          $url                = $results->baseurl;
          $contatti           = $results->harvest_contact;
          $format             = $results->harvest_format;
          $set                = $results->harvest_set;
          $userEmbargo        = $results->harvest_userEmbargo;
          $pwdEmbargo         = $results->harvest_pwdEmbargo;
          $userNBN            = $results->user;
          $pwdNBN             = $results->pass;
          $ipNBN              = $results->IP;
          $idSubNamespace     = $results->subNamespaceID;
          $idDatasource       = $results->datasourceID;
        ?>
          <div id="infoTesi">
          <?php if (isset($alert)) { ?>
            <div class='alert alert-warning'><?php echo $alert ?></div>
          <?php } ?>

              <form action="" method="post">
                <input type="hidden" name="idSubNamespace" value="<?php echo $idSubNamespace ?>">
                <input type="hidden" name="idDatasource" value="<?php echo $idDatasource ?>">
                  <div class="row">
                      <div class="col-md-6">
                          <label for="nomeDatasource">Nome Datasource</label>
                          <input name="nomeDatasource" value="<?php echo $nomeDatasource ?>" type="text">
                      </div>
                      <div class="col-md-6">
                          <label for="url">URL sito OAI</label>
                          <input name="url" value="<?php echo $url ?>" type="text">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <label for="contatti">Contatti</label>
                          <input name="contatti" value="<?php echo $contatti ?>" type="text">
                      </div>
                      <div class="col-md-6">
                          <label for="format">Format dei metadati</label>
                          <input name="format" value="<?php echo $format ?>" type="text">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <label for="set">Set dei metadati</label>
                          <input name="set" value="<?php echo $set ?>" type="text">
                      </div>
                      <div class="col-md-6">
                          <label for="userEmbargo">Utenza per accesso embargo</label>
                          <input name="userEmbargo" value="<?php echo $userEmbargo ?>" type="text">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <label for="pwdEmbargo">Password per accesso embargo</label>
                          <input name="pwdEmbargo" value="<?php echo $pwdEmbargo ?>" type="text">
                      </div>
                      <div class="col-md-6">
                          <label for="userNBN">User per API NBN</label>
                          <input name="userNBN" value="<?php echo $userNBN ?>" type="text">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <label for="pwdNBN">Password per API NBN</label>
                          <input name="pwdNBN" value="<?php echo $pwdNBN ?>" type="text">
                      </div>
                      <div class="col-md-6">
                          <label for="ipNBN">IP per API NBN</label>
                          <input name="ipNBN" value="<?php echo $ipNBN ?>" type="text">
                      </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12"><input name="modificaTesi" type="submit" value="Modifica" class="mt-3 float-right"/></div>
                  </div>
              </form>
              
          </div>

        <?php } ?>

      <?php } ?>
    </div> -->


      <?php if ($_isviewonly) { ?>

        <h5>Servizi registrati:</h5>

      <?php } ?>

      <div id="tesiDottorato">
        <?php if ((!$_isviewonly) && (empty($tesiServizioAttivo))) { ?>
          <div id="tesi" class="mb-5">

            <h5>Registra l'istituzione al servizio Tesi di Dottorato</h5>

            <?php if (isset($alertTesi)) { ?>
              <div class='alert alert-warning'><?php echo $alertTesi ?></div>
            <?php } ?>
            <form action="" method="post">
              <div class="row">
                <div class="col-md-6">
                  <label for="tesiNomeDatasource">Nome Datasource</label>
                  <input type="text" name="tesiNomeDatasource" required id="tesiNomeDatasource">
                </div>
                <div class="col-md-6">
                  <label for="tesiUrlOai">URL sito OAI</label>
                  <input type="text" name="tesiUrlOai" required id="tesiUrlOai">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="tesiContatti">Contatti</label>
                  <input type="text" name="tesiContatti" required id="tesiContatti">
                </div>
                <div class="col-md-6">
                  <label for="tesiFormatMetadati">Format dei metadati</label>
                  <input type="text" name="tesiFormatMetadati" required id="tesiFormatMetadati">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="tesiSetMetadati">Set dei metadati</label>
                  <input type="text" name="tesiSetMetadati" required id="tesiSetMetadati">
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
                  <label for="tesiUserApiNBN">User per API NBN</label>
                  <input type="text" name="tesiUserApiNBN" required id="tesiUserApiNBN">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="tesiPwdApiNBN">Password per API NBN</label>
                  <input type="text" name="tesiPwdApiNBN" required id="tesiPwdApiNBN">
                </div>
                <div class="col-md-6">
                  <label for="tesiIpApiNBN">IP per API NBN</label>
                  <input type="text" name="tesiIpApiNBN" required id="tesiIpApiNBN">
                </div>
              </div>

              <div class="row">
                <div class="col-md-12"><input name="signupTesiDottorato" type="submit" value="Registra" class="mt-3 float-right" /></div>
              </div>
            </form>
          </div>
        <?php } ?>


        <?php if (!empty($tesiServizioAttivo) || !empty($journalServizioAttivo) || !empty($bookServizioAttivo)) { ?>
          <h4>Servizi: </h4>
        <?php } ?>

        <?php if (!empty($tesiServizioAttivo)) { ?>
          <div id="infotesi">

            <h5>Tesi di Dottorato </h5>

            <?php foreach ($tesiAll as $key => $results) {
              $nomeDatasource_td     = $results->agent_name;
              $url_td                = $results->baseurl;
              $contatti_td           = $results->harvest_contact;
              $format_td             = $results->harvest_format;
              $set_td                = $results->harvest_set;
              $userEmbargo_td        = $results->harvest_userEmbargo;
              $pwdEmbargo_td         = $results->harvest_pwdEmbargo;
              $userNBN_td            = $results->user;
              $pwdNBN_td             = $results->pass;
              $ipNBN_td              = $results->IP;
              $idSubNamespace_td     = $results->subNamespaceID;
              $idDatasource_td       = $results->datasourceID;
            ?>

              <div class="card">
                <div class="card-header" id="heading<?php echo $key ?>">

                  <button class="btn" data-toggle="collapse" data-target="#collapse_tesi<?php echo $key ?>" aria-expanded="false" aria-controls="collapse_tesi<?php echo $key ?>">
                    <h5 class="m-0"><?php echo $nomeDatasource_td ?></h5>
                  </button>

                </div>

                <div id="collapse_tesi<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">
                  <div class="card-body">
                    <form action="" method="post">
                      <input type="hidden" name="idSubNamespace_td" value="<?php echo $idSubNamespace_td ?>">
                      <input type="hidden" name="idDatasource_td" value="<?php echo $idDatasource_td ?>">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="nomeDatasource_td">Nome Datasource</label>
                          <input name="nomeDatasource_td" value="<?php echo $nomeDatasource_td ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="url_td">URL sito OAI</label>
                          <input name="url_td" value="<?php echo $url_td ?>" type="text">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="contatti_td">Contatti</label>
                          <input name="contatti_td" value="<?php echo $contatti_td ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="format_td">Format dei metadati</label>
                          <input name="format_td" value="<?php echo $format_td ?>" type="text">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="set_td">Set dei metadati</label>
                          <input name="set_td" value="<?php echo $set_td ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="userEmbargo_td">Utenza per accesso embargo</label>
                          <input name="userEmbargo_td" value="<?php echo $userEmbargo_td ?>" type="text">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="pwdEmbargo_td">Password per accesso embargo</label>
                          <input name="pwdEmbargo_td" value="<?php echo $pwdEmbargo_td ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="userNBN_td">User per API NBN</label>
                          <input name="userNBN_td" value="<?php echo $userNBN_td ?>" type="text">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="pwdNBN_td">Password per API NBN</label>
                          <input name="pwdNBN_td" value="<?php echo $pwdNBN_td ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="ipNBN_td">IP per API NBN</label>
                          <input name="ipNBN_td" value="<?php echo $ipNBN_td ?>" type="text">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">

                        <?php
                        // 26/08/2021 Only omy dev D B for naow since I've implemented cascade on NBN db 
                        $ambiente = getenv('AMBIENTE_APPLICATIVO'); // Get Il Nome Del AMBIENTE  \r\n
                        if($ambiente == "local")
                        {?>
                          <input type="submit" name="rimuoviTesi" value="Rimuovi tesi" class="mt-3 btnRejectSub mr-3" />
                        <?php } ?>
  
                        <input type="submit" name="modificaTesi" value="Modifica" class="mt-3 float-right">
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            <?php } ?>
          </div>
        <?php } ?>







        <?php if (!$_isviewonly) { ?>
          <div id="eJournal" class="mb-5">

            <h5>Registra l'istituzione al servizio e-Journal</h5>

            <?php if (isset($alertJournal)) { ?>
              <div class='alert alert-warning'><?php echo $alertJournal ?></div>
            <?php } ?>
            <form action="" method="post">
              <div class="row">
                <div class="col-md-6">
                  <label for="journalNomeDatasource">Nome Datasource</label>
                  <input required type="text" name="journalNomeDatasource" id="journalNomeDatasource">
                </div>
                <div class="col-md-6">
                  <label for="journalUrlOai">URL sito OAI</label>
                  <input required type="text" name="journalUrlOai" id="journalUrlOai">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="journalContatti">Contatti</label>
                  <input required type="text" name="journalContatti" id="journalContatti">
                </div>
                <div class="col-md-6">
                  <label for="journalFormatMetadati">Format dei metadati</label>
                  <input required type="text" name="journalFormatMetadati" id="journalFormatMetadati">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="journalSetMetadati">Set dei metadati</label>
                  <input required type="text" name="journalSetMetadati" id="journalSetMetadati">
                </div>
                <div class="col-md-6">
                  <label for="journalUserApiNBN">User per API NBN</label>
                  <input required type="text" name="journalUserApiNBN" id="journalUserApiNBN">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="journalPwdApiNBN">Password per API NBN</label>
                  <input required type="text" name="journalPwdApiNBN" id="journalPwdApiNBN">
                </div>
                <div class="col-md-6">
                  <label for="journalIpApiNBN">IP per API NBN</label>
                  <input required type="text" name="journalIpApiNBN" id="journalIpApiNBN">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12"><input name="signupJournal" type="submit" value="Registra" class="mt-3 float-right" /></div>
              </div>
            </form>
          </div>
        <?php } ?>

        <?php if (!empty($journalServizioAttivo)) { ?>
          <div id="infoJournal">

            <h5>e-Journal </h5>

            <?php foreach ($journalAll as $key => $results) {

              $nomeDatasource_ej     = $results->agent_name;
              $url_ej                = $results->baseurl;
              $contatti_ej           = $results->harvest_contact;
              $format_ej             = $results->harvest_format;
              $set_ej                = $results->harvest_set;
              $userEmbargo_ej        = $results->harvest_userEmbargo;
              $pwdEmbargo_ej         = $results->harvest_pwdEmbargo;
              $userNBN_ej            = $results->user;
              $pwdNBN_ej             = $results->pass;
              $ipNBN_ej              = $results->IP;
              $idSubNamespace_ej     = $results->subNamespaceID;
              $idDatasource_ej       = $results->datasourceID;

            ?>

              <div class="card">
                <div class="card-header" id="heading<?php echo $key ?>">

                  <button class="btn" data-toggle="collapse" data-target="#collapse_journal<?php echo $key ?>" aria-expanded="false" aria-controls="collapse_journal<?php echo $key ?>">
                    <h5 class="m-0"><?php echo $nomeDatasource_ej ?></h5>
                  </button>

                </div>

                <div id="collapse_journal<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">
                  <div class="card-body">
                    <form action="" method="post">
                      <input type="hidden" name="idSubNamespace_ej" value="<?php echo $idSubNamespace_ej ?>">
                      <input type="hidden" name="idDatasource_ej" value="<?php echo $idDatasource_ej ?>">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="nomeDatasource_ej">Nome Datasource</label>
                          <input name="nomeDatasource_ej" value="<?php echo $nomeDatasource_ej ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="url_ej">URL sito OAI</label>
                          <input name="url_ej" value="<?php echo $url_ej ?>" type="text">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="contatti_ej">Contatti</label>
                          <input name="contatti_ej" value="<?php echo $contatti_ej ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="format_ej">Format dei metadati</label>
                          <input name="format_ej" value="<?php echo $format_ej ?>" type="text">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="set_ej">Set dei metadati</label>
                          <input name="set_ej" value="<?php echo $set_ej ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="userEmbargo_ej">Utenza per accesso embargo</label>
                          <input name="userEmbargo_ej" value="<?php echo $userEmbargo_ej ?>" type="text">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="pwdEmbargo_ej">Password per accesso embargo</label>
                          <input name="pwdEmbargo_ej" value="<?php echo $pwdEmbargo_ej ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="userNBN_ej">User per API NBN</label>
                          <input name="userNBN_ej" value="<?php echo $userNBN_ej ?>" type="text">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="pwdNBN_ej">Password per API NBN</label>
                          <input name="pwdNBN_ej" value="<?php echo $pwdNBN_ej ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="ipNBN_ej">IP per API NBN</label>
                          <input name="ipNBN_ej" value="<?php echo $ipNBN_ej ?>" type="text">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <?php
                          // 26/08/2021 Only omy dev D B for naow since I've implemented cascade on NBN db 
                          $ambiente = getenv('AMBIENTE_APPLICATIVO'); // Get Il Nome Del AMBIENTE  \r\n
                          if($ambiente == "local")
                          {?>
                            <input type="submit" name="rimuoviJournal" value="Rimuovi Journal" class="mt-3 btnRejectSub mr-3" />
                          <?php } ?>

                          <input type="submit" name="modificaJournal" value="Modifica" class="mt-3 float-right">
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            <?php } ?>
          </div>
        <?php } ?>
        <?php if (!$_isviewonly) { ?>
          <div id="eBook" class="mb-5">
            <h5>Registra l'istituzione al servizio e-Book</h5>
            <?php if (isset($alertBook)) { ?>
              <div class='alert alert-warning'><?php echo $alertBook ?></div>
            <?php } ?>
            <form action="" method="post">
              <div class="row">
                <div class="col-md-6">
                  <label for="bookNomeDatasource">Nome Datasource</label>
                  <input required type="text" name="bookNomeDatasource" id="bookNomeDatasource">
                </div>
                <div class="col-md-6">
                  <label for="bookUrlOai">URL sito OAI</label>
                  <input required type="text" name="bookUrlOai" id="bookUrlOai">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="bookUserApiNBN">User per API NBN</label>
                  <input required type="text" name="bookUserApiNBN" id="bookUserApiNBN">
                </div>
                <div class="col-md-6">
                  <label for="bookPwdApiNBN">Password per API NBN</label>
                  <input required type="text" name="bookPwdApiNBN" id="bookPwdApiNBN">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="bookIpApiNBN">IP per API NBN</label>
                  <input required type="text" name="bookIpApiNBN" id="bookIpApiNBN">
                </div>
                <div class="col-md-6"></div>
              </div>
              <div class="row">
                <div class="col-md-12"><input name="signupBook" type="submit" value="Registra" class="mt-3 float-right" /></div>
              </div>
            </form>
          </div>
        <?php } ?>

        <?php if (!empty($bookServizioAttivo)) { ?>
          <div id="infoBook">
            <h5>e-Book </h5>
            <?php foreach ($bookAll as $keyBook => $results) {
              $nomeDatasource_eb     = $results->agent_name;
              $url_eb                = $results->baseurl;
              $userNBN_eb            = $results->user;
              $pwdNBN_eb             = $results->pass;
              $ipNBN_eb              = $results->IP;
              $idSubNamespace_eb     = $results->subNamespaceID;
              $idDatasource_eb       = $results->datasourceID;

            ?>
              <div class="card">
                <div class="card-header" id="heading<?php echo $keyBook ?>">
                  <button class="btn" data-toggle="collapse" data-target="#collapse_Book<?php echo $keyBook ?>" aria-expanded="false" aria-controls="collapse_Book<?php echo $keyBook ?>">
                    <h5 class="m-0"><?php echo $nomeDatasource_eb ?></h5>
                  </button>
                </div>
                <div id="collapse_Book<?php echo $keyBook ?>" class="collapse" aria-labelledby="heading<?php echo $keyBook ?>">
                  <div class="card-body">

                    <?php if (isset($alertBookModify)) { ?>
                      <div class='alert alert-warning'><?php echo $alertBookModify ?></div>
                    <?php } ?>

                    <form action="" method="post">
                      <input type="hidden" name="idSubNamespace_eb" value="<?php echo $idSubNamespace_eb ?>">
                      <input type="hidden" name="idDatasource_eb" value="<?php echo $idDatasource_eb ?>">
                      
                      <div class="row">
                        <div class="col-md-6">
                          <label for="nomeDatasource_eb">Nome Datasource</label>
                          <input name="nomeDatasource_eb" value="<?php echo $nomeDatasource_eb ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="url_eb">URL sito OAI</label>
                          <input name="url_eb" value="<?php echo $url_eb ?>" type="text">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <label for="userNBN_eb">User per API NBN</label>
                          <input name="userNBN_eb" value="<?php echo $userNBN_eb ?>" type="text">
                        </div>
                        <div class="col-md-6">
                          <label for="pwdNBN_eb">Password per API NBN</label>
                          <input name="pwdNBN_eb" value="<?php echo $pwdNBN_eb ?>" type="text">
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6">
                          <label for="ipNBN_eb">IP per API NBN</label>
                          <input name="ipNBN_eb" value="<?php echo $ipNBN_eb ?>" type="text">
                        </div>
                        <div class="col-md-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <?php
                          // 26/08/2021 Only omy dev D B for naow since I've implemented cascade on NBN db 
                          $ambiente = getenv('AMBIENTE_APPLICATIVO'); // Get Il Nome Del AMBIENTE  \r\n
                          if($ambiente == "local")
                          {?>
                            <input type="submit" name="rimuoviBook" value="Rimuovi e-Book" class="mt-3 btnRejectSub mr-3" />
                          <?php } ?>

                          <input type="submit" name="modificaBook" value="Modifica" class="mt-3 float-right">
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>

  </section>

<?php
  if (!$_isviewonly) {

    get_footer();
  }
} // End if($_SESSION['role'] == 'admin_istituzione')

//================================
// 20/08/2021 Argentino
// Funzioni varie per avere una logica compatta

function signupTesiDottorato($dbMD, $dbHarvest, $dbNBN, $uuidIstituzione, $loginIstituzione, $nomeIstituzione)
{ // Argentino
  if (isset($_POST['tesiNomeDatasource']) && $_POST['tesiNomeDatasource'] != '') {
    $tesiNomeDatasource = $_POST['tesiNomeDatasource'];
  }
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

  $servizioAbilitato      = 'td';

  //INSERT INTO MD
  if (empty($tesiServizioAttivo)) {
    $insertServizio     = insert_into_md_servizi($dbMD, $uuidIstituzione, $servizioAbilitato);
  }
  //INSERT INTO NBN
  $checkSubnamespace      = check_istituzione_exist_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
  if ($checkSubnamespace == 0) {
    $insertSubnamespace     = insert_into_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
  }
  $subnamespaceID         = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
  $checkDatasource        = check_datasource_into_nbn($dbNBN, $tesiNomeDatasource, $tesiUrlOai);
  if ($checkDatasource == 0) {
    $insertDatasource     = insert_into_nbn_datasource($dbNBN, $tesiNomeDatasource, $tesiUrlOai, $subnamespaceID, $servizioAbilitato);
  } else {
    $alertTesi = 'Nome datasource e url datasource già presenti';
  }
  $idDatasource           = retrieve_id_datasource_for_istituzione($dbNBN, $tesiNomeDatasource, $subnamespaceID, $tesiUrlOai);
  $insertAgent            = insert_into_nbn_agent($dbNBN, $tesiNomeDatasource, $tesiUrlOai, $tesiUserApiNBN, $tesiPwdApiNBN, $tesiIpApiNBN, $idDatasource, $subnamespaceID, $servizioAbilitato);
  //INSERT INTO HARVEST
  $insertAnagrafe         = insert_into_harvest_anagrafe($dbHarvest, $uuidIstituzione, $idDatasource, $loginIstituzione, $tesiUrlOai, $tesiContatti, $tesiFormatMetadati, $tesiSetMetadati, $tesiUtenzaEmbargo, $tesiPwdEmbargo, $servizioAbilitato);
  if ($insertAnagrafe == 1) {
    $journalUserApiNBN    = '';
    $journalPwdApiNBN     = '';
    $bookUserApiNBN       = '';
    $bookPwdApiNBN        = '';
    send_notice_nbn_email_to_admin($dbMD, $tesiUserApiNBN, $tesiPwdApiNBN, $journalUserApiNBN, $journalPwdApiNBN, $bookUserApiNBN, $bookPwdApiNBN);
    echo "<script>window.location.href = '/area-riservata/istituzione/signup-services'</script>";
  }
} // end signupTesiDottorato

function signupJournal($dbMD, $dbHarvest, $dbNBN, $uuidIstituzione, $loginIstituzione, $nomeIstituzione)
{
  if (isset($_POST['journalNomeDatasource']) && $_POST['journalNomeDatasource'] != '') {
    $journalNomeDatasource = $_POST['journalNomeDatasource'];
  }
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

  $servizioAbilitato      = 'ej';
  $journalUtenzaEmbargo   = '';
  $journalPwdEmbargo      = '';

  //INSERT INTO MD
  if (empty($journalServizioAttivo)) {
    $insertServizio       = insert_into_md_servizi($dbMD, $uuidIstituzione, $servizioAbilitato);
  }
  //INSERT INTO NBN
  $checkSubnamespace      = check_istituzione_exist_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
  if ($checkSubnamespace == 0) {
    $insertSubnamespace   = insert_into_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
  }
  $subnamespaceID         = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
  $checkDatasource        = check_datasource_into_nbn($dbNBN, $journalNomeDatasource, $journalUrlOai);
  if ($checkDatasource == 0) {
    $insertDatasource     = insert_into_nbn_datasource($dbNBN, $journalNomeDatasource, $journalUrlOai, $subnamespaceID, $servizioAbilitato);
  } else {
    $alertJournal         = 'Nome datasource e url datasource già presenti';
  }

  $idDatasource           = retrieve_id_datasource_for_istituzione($dbNBN, $journalNomeDatasource, $subnamespaceID, $journalUrlOai);
  $insertAgent            = insert_into_nbn_agent($dbNBN, $journalNomeDatasource, $journalUrlOai, $journalUserApiNBN, $journalPwdApiNBN, $journalIpApiNBN, $idDatasource, $subnamespaceID, $servizioAbilitato);
  //INSERT INTO HARVEST
  $insertAnagrafe         = insert_into_harvest_anagrafe($dbHarvest, $uuidIstituzione, $idDatasource, $loginIstituzione, $journalUrlOai, $journalContatti, $journalFormatMetadati, $journalSetMetadati, $journalUtenzaEmbargo, $journalPwdEmbargo, $servizioAbilitato);
  if ($insertAnagrafe == 1) {
    $tesiUserApiNBN       = '';
    $tesiPwdApiNBN        = '';
    $bookUserApiNBN       = '';
    $bookPwdApiNBN        = '';
    send_notice_nbn_email_to_admin($dbMD, $tesiUserApiNBN, $tesiPwdApiNBN, $journalUserApiNBN, $journalPwdApiNBN, $bookUserApiNBN, $bookPwdApiNBN);
    echo "<script>window.location.href = '/area-riservata/istituzione/signup-services'</script>";
  }
} // end signupJournal()

function signupBook($dbMD, $dbHarvest, $dbNBN, $uuidIstituzione, $loginIstituzione, $nomeIstituzione)
{
  if (isset($_POST['bookNomeDatasource']) && $_POST['bookNomeDatasource'] != '') {
    $bookNomeDatasource = $_POST['bookNomeDatasource'];
  }
  if (isset($_POST['bookUrlOai']) && $_POST['bookUrlOai'] != '') {
    $bookUrlOai = $_POST['bookUrlOai'];
  }
  if (isset($_POST['bookUserApiNBN']) && $_POST['bookUserApiNBN'] != '') {
    $bookUserApiNBN = $_POST['bookUserApiNBN'];
  }
  if (isset($_POST['bookPwdApiNBN']) && $_POST['bookPwdApiNBN'] != '') {
    $bookPwdApiNBN = $_POST['bookPwdApiNBN'];
  }
  if (isset($_POST['bookIpApiNBN']) && $_POST['bookIpApiNBN'] != '') {
    $bookIpApiNBN = $_POST['bookIpApiNBN'];
  }
  $checkNameDatasource = check_nbn_datasourceName_exists($dbNBN, $bookNomeDatasource);
  if ($checkNameDatasource == 0) {
    $servizioAbilitato   = 'eb';
    $bookUtenzaEmbargo   = '';
    $bookPwdEmbargo      = '';
    //INSERT INTO MD
    if (empty($bookServizioAttivo)) {
      $insertServizio       = insert_into_md_servizi($dbMD, $uuidIstituzione, $servizioAbilitato);
    }
    //INSERT INTO NBN
    $checkSubnamespace      = check_istituzione_exist_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
    if ($checkSubnamespace == 0) {
      $insertSubnamespace   = insert_into_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
    }
    $subnamespaceID         = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
    $checkDatasource        = check_datasource_into_nbn($dbNBN, $bookNomeDatasource, $bookUrlOai);
    if ($checkDatasource == 0) {
      $insertDatasource     = insert_into_nbn_datasource($dbNBN, $bookNomeDatasource, $bookUrlOai, $subnamespaceID, $servizioAbilitato);
    } else {
      $alertJournal         = 'Nome datasource e url datasource già presenti';
    }
    $idDatasource           = retrieve_id_datasource_for_istituzione($dbNBN, $bookNomeDatasource, $subnamespaceID, $bookUrlOai);
    $insertAgent            = insert_into_nbn_agent($dbNBN, $bookNomeDatasource, $bookUrlOai, $bookUserApiNBN, $bookPwdApiNBN, $bookIpApiNBN, $idDatasource, $subnamespaceID, $servizioAbilitato);
    if ($insertAgent == 1) {
      $tesiUserApiNBN       = '';
      $tesiPwdApiNBN        = '';
      $journalUserApiNBN    = '';
      $journalPwdApiNBN     = '';
      $mail = send_notice_nbn_email_to_admin(
        $dbMD,
        $tesiUserApiNBN,
        $tesiPwdApiNBN,
        $journalUserApiNBN,
        $journalPwdApiNBN,
        $bookUserApiNBN,
        $bookPwdApiNBN
      );
      $_SESSION['ebook']    = 'y';
      echo "<script>window.location.href = '/area-riservata/istituzione/signup-services'</script>";
    }
  } else {
    $alertBook = 'Nome Datasource già in uso';
  }
} // End signupBook()

// // 23/08/2021  Argentino
// function modificaServizio($dbHarvest, $dbNBN, $uuidIstituzione, $loginIstituzione, $nomeIstituzione, $servizio, $nomeServizio) // $dbMD, 
// {
//   global $WH_LOG_INFO;

//   if (isset($_POST["nomeDatasource_$servizio"]))
//     $nomeDatasource = $_POST["nomeDatasource_$servizio"];
//   if (isset($_POST["url_$servizio"]))
//     $url = $_POST["url_$servizio"];

//   if ($servizio != "eb")
//   {
//     if (isset($_POST["contatti_$servizio"]))
//       $contatti = $_POST["contatti_$servizio"];
//     if (isset($_POST["format_$servizio"]))
//       $format = $_POST["format_$servizio"];
//     if (isset($_POST["set_$servizio"]))
//       $set = $_POST["set_$servizio"];
//     if (isset($_POST["userEmbargo_$servizio"]))
//       $userEmbargo = $_POST["userEmbargo_$servizio"];
//     if (isset($_POST["pwdEmbargo_$servizio"]))
//       $pwdEmbargo = $_POST["pwdEmbargo_$servizio"];
//   }
  
//   if (isset($_POST["userNBN_$servizio"]))
//     $userNBN = $_POST["userNBN_$servizio"];
//   if (isset($_POST["pwdNBN_$servizio"]))
//     $pwdNBN = $_POST["pwdNBN_$servizio"];
//   if (isset($_POST["ipNBN_$servizio"]))
//     $ipNBN = $_POST["ipNBN_$servizio"];
//   if (isset($_POST["idSubNamespace_$servizio"]))
//     $idSubNamespace = $_POST["idSubNamespace_$servizio"];
//   if (isset($_POST["idDatasource_$servizio"]))
//     $idDatasource = $_POST["idDatasource_$servizio"];

//   // Prendiamo i dati dell'agent prima delle modifiche
//   // per gestire basic authentication di apache
//   $agent = retrieve_agent_nbn($dbNBN, $idSubNamespace, $idDatasource);
//   if (!$agent) { // Signal some error
//     echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Agent mancante. Aggiornamento fallito per servizio $servizio</div>";
//     return;
//   }
//   $updateDatasource   = update_datasource_nbn_test($dbNBN, $loginIstituzione, $nomeIstituzione, $nomeDatasource, $url, $idSubNamespace, $idDatasource);
//   if (!$updateDatasource && check_db_error($dbNBN)) { // Signal some error
//     echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Aggiornamento datasouurce fallito per servizio $nomeServizio.</div>";
//     return;
//   }
//   $updateAgent      = update_agent_nbn($dbNBN, $loginIstituzione, $nomeIstituzione, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, $servizio, $idSubNamespace, $idDatasource);
//   if (!$updateAgent && check_db_error($dbNBN)) { // Signal some error
//     echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Aggiornamento agent fallito per servizio $nomeServizio.</div>";
//     return;
//   }
//   if ($servizio != 'eb')
//   {
//     $updateHarvest  = update_anagrafe_harvest($dbHarvest, $uuidIstituzione, $loginIstituzione, $nomeIstituzione, $nomeDatasource, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $url, $servizio, $idDatasource);
//     if (!$updateHarvest && check_db_error($dbHarvest)) { // Signal some error
//       echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Aggiornamento anagrafe harvest fallito per servizio $nomeServizio.</div>";
//       return;
//     }
//   }

//   // 20/08/21
//   // Aggiorniamo la password per la basic authnetication in caso sia stata modificata
//   if ($agent) {
//     $old_user = $agent[0]->user;
//     $old_pwd = $agent[0]->pass;

//     $htpasswd = new Htpasswd('../passwd/.htpasswd_nbn');
//     if ($old_user != $userNBN) { // change of user and pwd
//       // Delete old user
//       $ret = $htpasswd->deleteUser($old_user);
//       wh_log($WH_LOG_INFO, "NBN apache managed basic authentication - Deleted user $old_user ret='$ret'");

//       // Add new user
//       $ret = $htpasswd->addUser($userNBN, $pwdNBN);
//       wh_log($WH_LOG_INFO, "NBN apache managed basic authentication - Added user $userNBN:$pwdNBN,  ret='$ret'");
//     } else if ($old_pwd != $pwdNBN) { // change password of old user
//       // update old user
//       $ret = $htpasswd->updateUser($userNBN, $pwdNBN);
//       wh_log($WH_LOG_INFO, "Updated user $userNBN:$pwdNBN, ret='$ret'");
//     }
//     // else NO CHANGE in user PWD
//   } // End if agent

//   echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Modifica andata a buon fine per servizio $nomeServizio.</div>";
//   // $alertTesi = "Aggiornamento andato a buon fine";
//   // echo "<script>window.location.href = '/area-riservata//istituzione/signup-services'</script>";
// } // End modifica_servizio

?>

