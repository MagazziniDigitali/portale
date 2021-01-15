<?php
  require("../../wp-load.php");;
  require("../src/functions.php");

  session_start();

  redirect_if_not_logged_in();

  if($_SESSION['role'] == 'admin_istituzione'){


  $dbMD           = connect_to_md();
  $dbHarvest      = connect_to_harvest();
  $dbNBN          = connect_to_nbn();

  $uuidIstituzione    = check_istituizone_session($dbMD);
  $istituzione        = retrieve_login_istituzione($dbMD, $uuidIstituzione);
  
  $loginIstituzione   = $istituzione[0]->LOGIN;
  $nomeIstituzione    = $istituzione[0]->NOME;

  $tesiServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $uuidIstituzione, 'td');
  $journalServizioAttivo  = check_if_istituzione_signed_for_service($dbMD, $uuidIstituzione, 'ej');


  if (isset($_POST['signupTesiDottorato'])) {

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

    if($checkSubnamespace == 0){
      $insertSubnamespace     = insert_into_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);
    }
    
    $subnamespaceID         = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
    $checkDatasource        = check_datasource_into_nbn($dbNBN, $tesiNomeDatasource, $tesiUrlOai);

    if($checkDatasource == 0){
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

      send_notice_nbn_email_to_admin($dbMD, $tesiUserApiNBN, $tesiPwdApiNBN, $journalUserApiNBN, $journalPwdApiNBN);

      echo "<script>window.location.href = 'http://localhost/local/area-riservata/istituzione/signup-services'</script>";

    }

  }

  if (isset($_POST['signupJournal'])) {

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

    if($checkSubnamespace == 0){

      $insertSubnamespace   = insert_into_nbn_subnamespace($dbNBN, $loginIstituzione, $nomeIstituzione);

    }

    $subnamespaceID         = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione, $nomeIstituzione);
    $checkDatasource        = check_datasource_into_nbn($dbNBN, $journalNomeDatasource, $journalUrlOai);

    if($checkDatasource == 0){

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

      $mail = send_notice_nbn_email_to_admin($dbMD, $tesiUserApiNBN, $tesiPwdApiNBN, $journalUserApiNBN, $journalPwdApiNBN);

      echo "<script>window.location.href = 'http://localhost/local/area-riservata//istituzione/signup-services'</script>";

    }
  }

  if (isset($_POST['modificaTesi'])){

    if (isset($_POST['nomeDatasource'])){
      $nomeDatasource = $_POST['nomeDatasource'];
    }
    if (isset($_POST['url'])){
      $url = $_POST['url'];
    }
    if (isset($_POST['contatti'])){
      $contatti = $_POST['contatti'];
    }
    if (isset($_POST['format'])){
      $format = $_POST['format'];
    }
    if (isset($_POST['set'])){
      $set = $_POST['set'];
    }
    if (isset($_POST['userEmbargo'])){
      $userEmbargo = $_POST['userEmbargo'];
    }
    if (isset($_POST['pwdEmbargo'])){
      $pwdEmbargo = $_POST['pwdEmbargo'];
    }
    if (isset($_POST['userNBN'])){
      $userNBN = $_POST['userNBN'];
    }
    if (isset($_POST['pwdNBN'])){
      $pwdNBN = $_POST['pwdNBN'];
    }
    if (isset($_POST['ipNBN'])){
      $ipNBN = $_POST['ipNBN'];
    }
    if (isset($_POST['idSubNamespace'])){
      $idSubNamespace = $_POST['idSubNamespace'];
    }
    if (isset($_POST['idDatasource'])){
      $idDatasource = $_POST['idDatasource'];
    }

    $updateDatasource   = update_datasource_nbn($dbNBN, $loginIstituzione, $nomeIstituzione, $nomeDatasource, $url, $idSubNamespace, $idDatasource);

    if ($updateDatasource == 1) {

      $updateAgent      = update_agent_nbn($dbNBN, $loginIstituzione, $nomeIstituzione, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, 'td', $idSubNamespace, $idDatasource);

      if ($updateAgent  == 1){

        $updateHarvest  = update_anagrafe_harvest($dbHarvest, $uuidIstituzione, $loginIstituzione, $nomeIstituzione, $nomeDatasource, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $url, 'td', $idDatasource);
        
        if ($updateHarvest == 1){

          echo "<script>window.location.href = 'http://localhost/local/area-riservata/istituzione/signup-services'</script>";

        }

      }

    }

  }

  if (isset($_POST['modificaJournal'])){

    if (isset($_POST['nomeDatasource'])){
      $nomeDatasource = $_POST['nomeDatasource'];
    }
    if (isset($_POST['url'])){
      $url = $_POST['url'];
    }
    if (isset($_POST['contatti'])){
      $contatti = $_POST['contatti'];
    }
    if (isset($_POST['format'])){
      $format = $_POST['format'];
    }
    if (isset($_POST['set'])){
      $set = $_POST['set'];
    }
    if (isset($_POST['userEmbargo'])){
      $userEmbargo = $_POST['userEmbargo'];
    }
    if (isset($_POST['pwdEmbargo'])){
      $pwdEmbargo = $_POST['pwdEmbargo'];
    }
    if (isset($_POST['userNBN'])){
      $userNBN = $_POST['userNBN'];
    }
    if (isset($_POST['pwdNBN'])){
      $pwdNBN = $_POST['pwdNBN'];
    }
    if (isset($_POST['ipNBN'])){
      $ipNBN = $_POST['ipNBN'];
    }
    if (isset($_POST['idSubNamespace'])){
      $idSubNamespace = $_POST['idSubNamespace'];
    }
    if (isset($_POST['idDatasource'])){
      $idDatasource = $_POST['idDatasource'];
    }

    $updateDatasource   = update_datasource_nbn($dbNBN, $loginIstituzione, $nomeIstituzione, $nomeDatasource, $url, $idSubNamespace, $idDatasource);

    if ($updateDatasource == 1) {

      $updateAgent      = update_agent_nbn($dbNBN, $loginIstituzione, $nomeIstituzione, $nomeDatasource, $url, $userNBN, $pwdNBN, $ipNBN, 'ej', $idSubNamespace, $idDatasource);

      if ($updateAgent == 1){

        $updateHarvest  = update_anagrafe_harvest($dbHarvest, $uuidIstituzione, $loginIstituzione, $nomeIstituzione, $nomeDatasource, $contatti, $format, $set, $userEmbargo, $pwdEmbargo, $url, 'ej', $idDatasource);
        
        if ($updateHarvest == 1){

          echo "<script>window.location.href = 'http://localhost/local/area-riservata/istituzione/signup-services'</script>";

        }

      }

    }

  }

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

  get_header();

?>

<section>
  <div class="container">

    <div id="tesiDottorato">

      <?php if (empty($tesiServizioAttivo)) {  ?>

        <h5>Registra l'istituzione al servizio di Tesi di Dottorato</h5>

        <?php if(isset($alertTesi)) { ?>
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

        <?php } else { ?>

        <h5>Sei già iscritto al servizio di Tesi di Dottorato</h5>

        <?php foreach($tesiAll as $key=>$results) {
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
          <?php if(isset($alert)) { ?>
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
    </div>

    <div id="eJournal" class="mb-5">

        <h5>Registra l'istituzione al servizio e-Journal</h5>
        
        <?php if(isset($alertJournal)) { ?>
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
            <div class="col-md-12"><input name="signupJournal" type="submit" value="Registra" class="mt-3 float-right"/></div>
          </div>
        </form>            
    </div>
    
    <?php if (!empty($journalServizioAttivo)) { ?>
      <div id="infoJournal">

        <h5>e-Journal già inseriti</h5>

        <?php foreach($journalAll as $key=>$results) {

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
              
          <div class="card">            
            <div class="card-header" id="heading<?php echo $key ?>">
                
              <button class="btn" data-toggle="collapse" data-target="#collapse<?php echo $key ?>" aria-expanded="false" aria-controls="collapse<?php echo $key ?>">
                <h5 class="m-0"><?php echo $nomeDatasource ?></h5>
              </button>
                
            </div>

            <div id="collapse<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">
              <div class="card-body">
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
                    <div class="col-md-12"><input type="submit" name="modificaJournal" value="Modifica" class="mt-3 float-right"></div>
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
  
  get_footer(); 

}
?>