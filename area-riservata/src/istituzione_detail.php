<?php
    require_once("functions.php");

if(!isset($isEditEnabled))
    $isEditEnabled = true;
    $istituzioneDetail = select_istituzione_by_id($dbMD, $idIst);
    $istNome =  $istituzioneDetail -> NOME;
    $istIndirizzo = $istituzioneDetail -> INDIRIZZO;
    $istTelefono = $istituzioneDetail -> TELEFONO;
    $istNomeContatto = $istituzioneDetail -> NOME_CONTATTO;
    $istUrl = $istituzioneDetail -> URL;
    $istNote = $istituzioneDetail -> NOTE;
    $istPiva = $istituzioneDetail -> PIVA;
    $istRegione = $istituzioneDetail -> ID_REGIONE;
?>

<div class="card">
    <div class="card-header" id="heading<?php echo $idIst ?>">
        <button class="btn" data-toggle="collapse" data-target="#collapse_ist_info<?php echo $idIst ?>" aria-expanded="false" aria-controls="collapse_ist_info<?php echo $idIst ?>">
         <h6 class="m-0">Dettaglio istituzione<!--<?php echo $loginIstName ?> --></h6>
        </button>
    </div>
    <div id="collapse_ist_info<?php echo $idIst ?>" class="collapse" aria-labelledby="heading<?php echo $idIst ?>">
        <div class="card-body">
                  <form name="gestioneInfoIstituto" method="POST">
                  <input type="hidden" name="istId" value="<?php echo $idIst ?>">
                     <div class="row">
                            <div class="col-md-6">
                                <label for="istNome">Nome istituto</label>
                                <input type="text" name="istNome" value="<?php echo $istNome ?>" id="istNome<?php echo $idIst ?>" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                            </div>
                            <div class="col-md-6">
                                <label for="istIndirizzo">Indirizzo</label>
                                <input type="text" name="istIndirizzo" id="istIndirizzo<?php echo $idIst ?>" value="<?php echo $istIndirizzo ?>" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="istTelefono">Telefono</label>
                                <input type="text" name="istTelefono" id="istTelefono<?php echo $idIst ?>"  value="<?php echo $istTelefono ?>" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                            </div>
                            <div class="col-md-6">
                                <label for="istNomeContatto">Nome Contatto</label>
                                <input type="text" name="istNomeContatto" id="istNomeContatto<?php echo $idIst ?>"  value="<?php echo $istNomeContatto ?>" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="istNote">Note</label>
                                <input type="text" name="istNote" id="istNote<?php echo $idIst ?>"  value="<?php echo $istNote ?>" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                            </div>
                            <div class="col-md-6">
                                <label for="istUrl">URL Istituto</label>
                                <input type="text" name="istUrl" id="istUrl<?php echo $idIst ?>"  value="<?php echo $istUrl ?>" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="istPiva">Partita IVA o Codice Fiscale</label>
                                <input type="text" name="istPiva" id="pivaSignupCustom<?php echo $idIst ?>"  value="<?php echo $istPiva ?>" class="<?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                            </div>
                            <div class="col-md-6">
                                <label for="istRegione">Regione</label>
                                <select name="istRegione" id="istRegione<?php echo $idIst ?>" class="selectSignup <?php echo (($isEditEnabled) ? '':'disabilitato') ?>" <?php echo (($isEditEnabled) ? '':'disabled') ?>>
                                  <?php  if ($isEditEnabled) {   ?> <option value="regione">Scegli una regione</option> <?php } ?>
                                    <?php foreach ($allRegions as $regionsElement) { ?>
                                        <option value="<?php echo $regionsElement->ID ?>" <?php echo (($regionsElement->ID == $istRegione ) ? 'selected':'') ?>  ><?php echo $regionsElement->NOMEREGIONE ?></option>
                                    <?php } ?>
                                </select>
                                <?php if (isset($alert)) { ?>
                                    <div class='alert alert-warning mt-3'><?php echo $alert ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ($isEditEnabled) { ?>
                        <div class="row">
                            <div class="col-md-12 text-right">
                              <input name="modificaIstituzione" type="submit" value="Modifica anagrafica" class="mt-3 btnAcceptSub mr-3" />
                            </div>
                        </div>
                        <?php } ?>
                    </form>
         </div>
     </div>
</div>