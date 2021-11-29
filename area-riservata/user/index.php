<?php
   require("../../wp-load.php");;
   require("../src/functions.php");

         if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

   redirect_if_not_logged_in();
   $isEditEnabled = false;
   if($_SESSION['role'] == 'user_istituzione'){

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
       $idIst = $uuidIstituzione;
       $tesiServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $idIst, 'td');
       $journalServizioAttivo  = check_if_istituzione_signed_for_service($dbMD, $idIst, 'ej');
       $bookServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $idIst, 'eb');
       $nbnServizioAttivo     = check_if_istituzione_signed_for_service($dbMD, $idIst, 'nbn');
       if (!empty($tesiServizioAttivo)) {
         $tesiAll = select_anagrafe_harvest($dbHarvest, $idIst, 'td');
       }
       if (!empty($journalServizioAttivo)) {
            $journalAll  = select_anagrafe_harvest($dbHarvest, $idIst, 'ej');
        }
       if (!empty($bookServizioAttivo)) {
           $bookAll  = select_anagrafe_harvest($dbHarvest, $idIst, 'eb');
         }
       if(!empty($nbnServizioAttivo)) {
       
         /*
           NBN.subnameSpace == MDIstituzioni.login
       
           1. select by uudi su MDIstituzioni  retrieve_id_login_for_istituzione($dbMD, $idIst)
           2. select subnameSpaceID where  NBN.subnameSpace == MDIstituzioni.login retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstituzione)
           3. select datasourceID where subnameSpaceID  retrieve_id_datasource($dbNBN, $subnamespaceID, $servizioAbilitato)
           4. select agent where datasourceID == datasourceID retrieve_agent_nbn($dbNBN, $subnamespaceID, $idDatasource)
         */  
         $loginIstNameNbn = retrieve_id_login_for_istituzione($dbMD, $idIst);
         $subNspaceID = retrieve_id_subnamespace_for_istituzione($dbNBN, $loginIstNameNbn);
         $dtsourcesID = retrieve_ids_datasources($dbNBN, $subNspaceID, 'nbn');
         $nbnAll = []; 
         foreach ($dtsourcesID as $key => $ds){
           $id = $ds->datasourceID;
           $nbnResult = retrieve_agent_nbn($dbNBN, $subNspaceID, $id);
             foreach ($nbnResult as $obj){
               $obj->id_istituzione = $idIst;
               $nbnAll[] = $obj;
           }
       
         }
      }
      get_header();

?>
<header id="homeHeader" class="entry-header welcomePad has-text-align-center">
        <div class="entry-header-inner section-inner medium">
        <h5 class="entry-title"><?php echo $_SESSION['istituzione'] ?></h5>
         <h4 class="entry-title">Benvenuto <?php echo ($_SESSION['name'] . ' ' . $_SESSION['surname']); ?></h4>
        </div>
    </header>
   <div class="container margin-top-15">
     <!-- <?php if($_SESSION['istituzione'] != 'istituzioneBase') { ?>
         <p class="text-center">Istituzione di appartenenza: <strong><?php echo $_SESSION['istituzione'] ?></strong></p>
      <?php } ?> -->
      
      <div id="ServiziShowup">
      <?php if (!empty($tesiServizioAttivo) || !empty($journalServizioAttivo) || !empty($bookServizioAttivo) || !empty($nbnServizioAttivo)) { ?>
          <h5>Servizi </h5>
        <?php } ?>
         <!-- nbn -->
         <?php if (!empty($nbnServizioAttivo) && $nbnAll) { ?>
          <div class="divServizi" id="infonbn">

            <h6>NBN - National Bibliography Number </h6>

            <?php foreach ($nbnAll as $key => $results) {
             $nomeDatasource_nbn     = $results->agent_name;
             $url_nbn                = $results->baseurl;
             $userNBN_nbn            = $results->user;
             $pwdNBN_nbn             = $results->pass;
             $ipNBN_nbn              = $results->IP;
             $idSubNamespace_nbn     = $results->subNamespaceID;
             $idDatasource_nbn       = $results->datasourceID;
             $id_Ist_nbn             = $results->id_istituzione;
             $agent_name_nbn       = $results->agent_name;
            ?>

              <div class="card">
                <div class="card-header" id="heading<?php echo $key ?>">

                  <button class="btn" data-toggle="collapse" data-target="#collapse_nbn<?php echo $key ?>" aria-expanded="false" aria-controls="collapse_tesi<?php echo $key ?>">
                    <h6 class="m-0"><?php echo $nomeDatasource_nbn ?></h6>
                  </button>

                </div>

                <div id="collapse_nbn<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">
                  <div class="card-body">
                    <form action="" method="post">

                      <input type="hidden" name="idSubNamespace_nbn" value="<?php echo $idSubNamespace_nbn ?>">
                      <input type="hidden" name="idDatasource_nbn" value="<?php echo $idDatasource_nbn ?>">
                      <input type="hidden" name="id_Ist_nbn" value="<?php echo $id_Ist_nbn ?>">
                      <input type="hidden" name="agent_name_nbn" value="<?php echo $agent_name_nbn ?>">



                      <div class="row">
                        <div class="col-md-6">
                          <label for="nomeDatasource_nbn">Nome Datasource</label>
                          <input name="nomeDatasource_nbn" value="<?php echo $nomeDatasource_nbn ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="url_nbn">URL sito</label>
                          <input name="url_nbn" value="<?php echo $url_nbn ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div>
                      <div class="row">
                       <div class="col-md-6">
                          <label for="userNBN_nbn">User per API NBN</label>
                          <input name="userNBN_nbn" value="<?php echo $userNBN_nbn ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="pwdNBN_nbn">Password per API NBN</label>
                          <input name="pwdNBN_nbn" value="<?php echo $pwdNBN_nbn ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="ipNBN_nbn">IP per API NBN</label>
                          <input name="ipNBN_nbn" value="<?php echo $ipNBN_nbn ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div>
                  <?php if ($isEditEnabled) { ?>
                      <div class="row">

                        <div class="col-md-12">
                        <?php
                        // 26/08/2021 Only omy dev D B for naow since I've implemented cascade on NBN db 
                        $ambiente = getenv('AMBIENTE_APPLICATIVO'); // Get Il Nome Del AMBIENTE  \r\n
                        if($ambiente == "local")
                        {?>
                          <input type="submit" name="rimuoviNBN" value="Rimuovi NBN" class="mt-3 btnRejectSub mr-3" />
                          <!-- <button type="button" class="btn btn-outline-secondary utente-cancella" data-toggle="modal" 
                            data-target="#deleteServiceModal" id="idRimuoviTesi" 
                            onclick="PreOpenDeleteServiceModal(
                              '<?php echo "rimuoviNBN" ?>', 
                              '<?php echo $userNBN_nbn ?>', 
                              '<?php echo $idSubNamespace_nbn ?>', 
                              '<?php echo $nomeDatasource_nbn ?>', 
                              '<?php echo $idDatasource_nbn ?>')">
                            <i class="icon-remove icon-2x " title="cancella Servizio"></i>
                          </button>   -->

                          <?php } ?>

                          <input type="submit" name="modificaNbn" value="Modifica" class="mt-3 float-right">
                        </div>
                      </div>
                     <?php } ?>

                    </form>
                  </div>
                </div>
              </div>

            <?php } // End foreach ($nbnAll ?>
          </div>
        <?php } // End if (!empty($nbnServizioAttivo))?>


        <?php if (!empty($tesiServizioAttivo)) { ?>
          <div class="divServizi"  id="infotesi">

            <h6>Tesi di Dottorato </h6>

            <?php foreach ($tesiAll as $key => $results) {
                $nomeDatasource_td     = $results->harvest_name;
                $url_td                = $results->harvest_url;
                $contatti_td           = $results->harvest_contact;
                $format_td             = $results->harvest_format;
                $set_td                = $results->harvest_set;
                $userEmbargo_td        = $results->harvest_userEmbargo;
                $pwdEmbargo_td         = $results->harvest_pwdEmbargo;
            
                $id_Ist_td             = $results->id_istituzione;
                $harvest_name_td       = $results->harvest_name;
            ?>

              <div class="card">
                <div class="card-header" id="heading<?php echo $key ?>">

                  <button class="btn" data-toggle="collapse" data-target="#collapse_tesi<?php echo $key ?>" aria-expanded="false" aria-controls="collapse_tesi<?php echo $key ?>">
                    <h6 class="m-0"><?php echo $nomeDatasource_td ?></h6>
                  </button>

                </div>

                <div id="collapse_tesi<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">
                  <div class="card-body">
                    <form action="" method="post">
                    <!--  <input type="hidden" name="idSubNamespace_td" value="<?php echo $idSubNamespace_td ?>">
                      <input type="hidden" name="idDatasource_td" value="<?php echo $idDatasource_td ?>"> -->
                      <div class="row">
                        <div class="col-md-6">
                          <label for="nomeDatasource_td">Nome Datasource</label>
                          <input name="nomeDatasource_td" value="<?php echo $nomeDatasource_td ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="url_td">URL sito OAI</label>
                          <input name="url_td" value="<?php echo $url_td ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="contatti_td">Contatti</label>
                          <input name="contatti_td" value="<?php echo $contatti_td ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="format_td">Format dei metadati</label>
                          <input name="format_td" value="<?php echo $format_td ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="set_td">Set dei metadati</label>
                          <input name="set_td" value="<?php echo $set_td ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="userEmbargo_td">Utenza per accesso embargo</label>
                          <input name="userEmbargo_td" value="<?php echo $userEmbargo_td ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="pwdEmbargo_td">Password per accesso embargo</label>
                          <input name="pwdEmbargo_td" value="<?php echo $pwdEmbargo_td ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      <!--  <div class="col-md-6">
                          <label for="userNBN_td">User per API NBN</label>
                          <input name="userNBN_td" value="<?php echo $userNBN_td ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div> -->
                      </div>
                    <!--  <div class="row">
                        <div class="col-md-6">
                          <label for="pwdNBN_td">Password per API NBN</label>
                          <input name="pwdNBN_td" value="<?php echo $pwdNBN_td ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="ipNBN_td">IP per API NBN</label>
                          <input name="ipNBN_td" value="<?php echo $ipNBN_td ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div> -->
                      <?php if ($isEditEnabled) { ?>

                      <div class="row">
                        <div class="col-md-12">

                        <?php
                        // 26/08/2021 Only omy dev D B for naow since I've implemented cascade on NBN db 
                        $ambiente = getenv('AMBIENTE_APPLICATIVO'); // Get Il Nome Del AMBIENTE  \r\n
                        if($ambiente == "local")
                        {?>
                          <input type="submit" name="rimuoviTesi" value="Rimuovi tesi" class="mt-3 btnRejectSub mr-3" />
  
                          <!-- <button type="button" class="btn btn-outline-secondary utente-cancella" data-toggle="modal" 
                            data-target="#deleteServiceModal" id="idRimuoviTesi" 
                            onclick="PreOpenDeleteServiceModal(
                              '<?php echo "rimuoviTesi" ?>', 
                              '<?php echo $userNBN_td ?>', 
                              '<?php echo $idSubNamespace_td ?>', 
                              '<?php echo $nomeDatasource_td ?>', 
                              '<?php echo $idDatasource__td ?>')">
                            <i class="icon-remove icon-2x " title="cancella Servizio"></i>
                          </button>   -->

  
                        <?php } ?>
  
                        <input type="submit" name="modificaTesi" value="Modifica" class="mt-3 float-right">
                        </div>
                      </div>
                      <?php } ?>
                    </form>
                  </div>
                </div>
              </div>

            <?php } ?>
          </div>
        <?php } ?>
        <!-- fine tesi -->

        <!-- ejournal -->
        <?php if (!empty($journalServizioAttivo)) { ?>
          <div id="infoJournal" class="divServizi" >

            <h6>e-Journal </h6>

            <?php foreach ($journalAll as $key => $results) {

              $nomeDatasource_ej     = $results->harvest_name;
              $url_ej                = $results->harvest_url;
              $contatti_ej           = $results->harvest_contact;
              $format_ej             = $results->harvest_format;
              $set_ej                = $results->harvest_set;
              $userEmbargo_ej        = $results->harvest_userEmbargo;
              $pwdEmbargo_ej         = $results->harvest_pwdEmbargo;
              // $userNBN_ej            = $results->user;
              // $pwdNBN_ej             = $results->pass;
              // $ipNBN_ej              = $results->IP;
              // $idSubNamespace_ej     = $results->subNamespaceID;
              // $idDatasource_ej       = $results->datasourceID;
              $id_Ist_ej          = $results->id_istituzione;
              $harvest_name_ej    = $results->harvest_name;

            ?>

              <div class="card">
                <div class="card-header" id="heading<?php echo $key ?>">

                  <button class="btn" data-toggle="collapse" data-target="#collapse_journal<?php echo $key ?>" aria-expanded="false" aria-controls="collapse_journal<?php echo $key ?>">
                    <h6 class="m-0"><?php echo $nomeDatasource_ej ?></h6>
                  </button>

                </div>

                <div id="collapse_journal<?php echo $key ?>" class="collapse" aria-labelledby="heading<?php echo $key ?>">
                  <div class="card-body">
                    <form action="" method="post">
                    <!--  <input type="hidden" name="idSubNamespace_ej" value="<?php echo $idSubNamespace_ej ?>">
                      <input type="hidden" name="idDatasource_ej" value="<?php echo $idDatasource_ej ?>"> -->
                      <div class="row">
                        <div class="col-md-6">
                          <label for="nomeDatasource_ej">Nome Datasource</label>
                          <input name="nomeDatasource_ej" value="<?php echo $nomeDatasource_ej ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="url_ej">URL sito OAI</label>
                          <input name="url_ej" value="<?php echo $url_ej ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="contatti_ej">Contatti</label>
                          <input name="contatti_ej" value="<?php echo $contatti_ej ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="format_ej">Format dei metadati</label>
                          <input name="format_ej" value="<?php echo $format_ej ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="set_ej">Set dei metadati</label>
                          <input name="set_ej" value="<?php echo $set_ej ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="userEmbargo_ej">Utenza per accesso embargo</label>
                          <input name="userEmbargo_ej" value="<?php echo $userEmbargo_ej ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="pwdEmbargo_ej">Password per accesso embargo</label>
                          <input name="pwdEmbargo_ej" value="<?php echo $pwdEmbargo_ej ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                       <!-- <div class="col-md-6">
                          <label for="userNBN_ej">User per API NBN</label>
                          <input name="userNBN_ej" value="<?php echo $userNBN_ej ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div> -->
                      </div>
                     <!-- <div class="row">
                        <div class="col-md-6">
                          <label for="pwdNBN_ej">Password per API NBN</label>
                          <input name="pwdNBN_ej" value="<?php echo $pwdNBN_ej ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="ipNBN_ej">IP per API NBN</label>
                          <input name="ipNBN_ej" value="<?php echo $ipNBN_ej ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div> -->
                      <?php if ($isEditEnabled) { ?>

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
                      <?php } ?>
                    </form>
                  </div>
                </div>
              </div>

            <?php } ?>
          </div>
        <?php } ?>
        <!-- fine ejournal --> 
        <!-- ebook -->
        <?php if (!empty($bookServizioAttivo)) { ?>
          <div id="infoBook" class="divServizi" >
            <h6>e-Book </h6>
            <?php foreach ($bookAll as $keyBook => $results) {
                $nomeDatasource_eb     = $results->harvest_name;
                $url_eb                = $results->harvest_url;
              //  $userNBN_eb            = $results->user;
                // $pwdNBN_eb             = $results->pass;
                // $ipNBN_eb              = $results->IP;
                // $idSubNamespace_eb  = $results->subNamespaceID;
                // $idDatasource_eb    = $results->datasourceID;
                $id_Ist_eb              = $results->id_istituzione;
                $harvest_name_eb        = $results->harvest_name;

            ?>
              <div class="card">
                <div class="card-header" id="heading<?php echo $keyBook ?>">
                  <button class="btn" data-toggle="collapse" data-target="#collapse_Book<?php echo $keyBook ?>" aria-expanded="false" aria-controls="collapse_Book<?php echo $keyBook ?>">
                    <h6 class="m-0"><?php echo $nomeDatasource_eb ?></h6>
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
                          <input name="nomeDatasource_eb" value="<?php echo $nomeDatasource_eb ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="url_eb">URL sito OAI</label>
                          <input name="url_eb" value="<?php echo $url_eb ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div>

                    <!--   <div class="row">
                        <div class="col-md-6">
                          <label for="userNBN_eb">User per API NBN</label>
                          <input name="userNBN_eb" value="<?php echo $userNBN_eb ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6">
                          <label for="pwdNBN_eb">Password per API NBN</label>
                          <input name="pwdNBN_eb" value="<?php echo $pwdNBN_eb ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                      </div>
                      
                     <div class="row">
                        <div class="col-md-6">
                          <label for="ipNBN_eb">IP per API NBN</label>
                          <input name="ipNBN_eb" value="<?php echo $ipNBN_eb ?>" type="text" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                        </div>
                        <div class="col-md-6"></div>
                      </div> -->
                      <?php if ($isEditEnabled) { ?>
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
                      <?php } ?>
                    </form>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>

      </div>
   </div>
      
<?php }
    get_footer(); 
?>