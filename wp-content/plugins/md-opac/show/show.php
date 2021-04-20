<?php
include_once (MD_PLUGIN_PATH . 'tools/solr/MDSolr.php');

function md_View_Show(){
	$mdSolr = new MDSolr();
	$bid ='';
	$id = '';
	
	if (!isset($_REQUEST ['myId']) && 
			!isset($_REQUEST ['bid'])) {
		die ( 'E\' necessario indicare l\'identificativo dell\'opera' );
	} else {
		if (isset($_REQUEST ['bid'])){
			$bid = $_REQUEST ['bid'];
		} else {
			$id = $_REQUEST ['myId'];
		}
	}

	echo $mdSolr->searchShowSolr( $id,$bid );
	
	if (isset($id)){
		echo $mdSolr->searchShowFigliSolr($id);
	}
}
?>
