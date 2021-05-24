<?php
include_once (MD_PLUGIN_PATH . 'tools/form/createForm.php');
include_once( MD_PLUGIN_PATH . 'admin/adminConfig.php' );

/**
 */
function md_plugin_setup_menu() {
	add_menu_page ( 'MD', 'Magazzini Digitali Opac', 'manage_options', 'md-Opac', 'md_opac' );
	add_submenu_page ( 'md-Opac', 'Solr', 'Solr Menu', 'activate_plugins', 'md-Opac-Solr', 'md_solr' );
	add_submenu_page ( 'md-Opac', 'Ricerca', 'Ricerca Menu', 'activate_plugins', 'md-Opac-Ricerca', 'md_ricerca' );
	add_submenu_page ( 'md-Opac', 'Scheda', 'Scheda Menu', 'activate_plugins', 'md-Opac-Scheda', 'md_scheda' );
}

/**
 * 
 */
function md_opac(){
	$createForm = new CreateForm ();
	$options = array (
			array (
					"name" => "Solr Tipo Database",
					"desc" => "Indicare il tipo di Database Solr utilizzato",
					"id" => "tecaSolrTipoDB",
					"type" => "select",
					"options" => array (
							"magazziniDigitali" => array (
									"name" => "Magazini Digitali",
									"number" => 1
							),
							"sast" => array (
									"name" => "Sistema Archivi Storici Territoriali",
									"number" => 1
							)
					),
					"parent" => "header-styles",
					"std" => "8983"
			)
	);
	?>
	<div class="wrap">
		<h1>Configurazione Titolopogia Database</h1>
		<div class="mnt-options">
	<?php
		$createForm->create_form ( $options );
		?>
	    </div>
	</div>
	<?php
}

/**
 */
function md_solr() {
	$createForm = new CreateForm ();
	$options = array (
			array (
					"name" => "Solr Server",
					"desc" => "Indicare il nome del Server Solr",
					"id" => "tecaSolrServer",
					"type" => "text",
					"parent" => "header-styles",
					"std" => "" 
			),
			array (
					"name" => "Solr Port",
					"desc" => "Indicare la porta del Server Solr",
					"id" => "tecaSolrPort",
					"type" => "select",
					"options" => array (
							"8443" => array (
									"name" => "8443",
									"number" => 1 
							),
							"8983" => array (
									"name" => "8983",
									"number" => 2 
							),
							"8984" => array (
									"name" => "8984",
									"number" => 3 
							) 
					),
					"parent" => "header-styles",
					"std" => "8983" 
			),
			array (
					"name" => "Solr Search Servlet",
					"desc" => "Indicare il percorso della Servlet utilizzata per la ricerca",
					"id" => "tecaSolrSearchServlet",
					"type" => "text",
					"parent" => "header-styles",
					"std" => "" 
			) 
	);
	?>
<div class="wrap">
	<h1>Configurazione collegamento server Solr</h1>
	<div class="mnt-options">
<?php
	$createForm->create_form ( $options );
	?>
    </div>
</div>
<?php
}

/**
 */
function md_ricerca() {
	$createForm = new CreateForm ();
	$adminConfig = new adminConfig();

	$options = array(
			array (
					"name" => "Campi breve",
					"desc" => "Campi da visualizzare nella breve",
					"id" => "tecaSolrSearchField",
					"type" => "multi-select",
					"options" => $adminConfig->tecaSolrSearchField(),
					"parent" => "header-styles",
					"std" => "none" 
			),
			array (
					"name" => "Esclusi",
					"desc" => "Indica le voci excluse dalla ricerca",
					"id" => "tecaSolrSearchExclude",
					"type" => "textarea",
					"parent" => "header-styles",
					"std" => ""
			),
			array (
					"name" => "Ordinamento della breve",
					"desc" => "Indica il tipo di ordinamento della breve",
					"id" => "tecaSolrSearchSort",
					"type" => "select",
					"options" => $adminConfig->tecaSolrSearchSort()	,
					"parent" => "header-styles",
					"std" => "8983" 
			),
			array (
					"name" => "Record Page",
					"desc" => "Indica il numero di record per pagina",
					"id" => "tecaSolrSearchPage",
					"type" => "select",
					"options" => $createForm->genArraySelect(array (
							"10" => "10","20" => "20","30" => "30",
							"40" => "40","50" => "50","60" => "60",
							"70" => "70","80" => "80","90" => "90",
							"100" => "100")),
					"parent" => "header-styles",
					"std" => "10"
			),
			array (
					"name" => "Facet",
					"id" => "tecaSolrSearchFacet",
					"type" => "radio",
					"desc" => "Viene utilizzato per abilitare la faccettazione dei risultati",
					"options" => array (
							"0" => "No",
							"1" => "Si" 
					),
					"parent" => "header-styles",
					"std" => "0" 
			),
			array (
					"name" => "Facet Min Count",
					"desc" => "Indica il numero minimo di record per faccette",
					"id" => "tecaSolrSearchFacetMinCount",
					"type" => "select",
					"options" => $createForm->genArraySelect(array (
							"1" => "1","2" => "2","3" => "3","4" => "4",
							"5" => "5","6" => "6","7" => "7","8" => "8",
							"9" => "9","10" => "10")),
					"parent" => "header-styles",
					"std" => "1"
			),
			array (
					"name" => "Facet Limit",
					"desc" => "Indica il numero massimo di oggetti per voce della faccetta",
					"id" => "tecaSolrSearchFacetLimit",
					"type" => "select",
					"options" => $createForm->genArraySelect(array (
							"10" => "10","20" => "20","30" => "30",
							"40" => "40","50" => "50","60" => "60",
							"70" => "70","80" => "80","90" => "90",
							"100" => "100")),
					"parent" => "header-styles",
					"std" => "10"
			),
			array (
					"name" => "Ordinamento delle faccette",
					"desc" => "Indica il tipo di ordinamento delle faccette",
					"id" => "tecaSolrSearchFacetSort",
					"type" => "select",
					"options" => $createForm->genArraySelect(array (
							"1" => "Decrescente per numero occorenze",
							"0" => "Crescente per descrizione")),
					"parent" => "header-styles",
					"std" => "10"
			),
			array (
					"name" => "Campi per le faccette Field",
					"desc" => "Campi da visualizzare nelle faccette",
					"id" => "tecaSolrSearchFacetField",
					"type" => "text",
					"parent" => "header-styles",
					"std" => "" 
			),
			array (
					"name" => "Campi per le faccette Pivot",
					"desc" => "Campi da visualizzare nelle faccette",
					"id" => "tecaSolrSearchFacetPivot",
					"type" => "multi-select",
					"options" => $adminConfig->tecaSolrSearchFacetPivot(),
					"parent" => "header-styles",
					"std" => "none"
			),
			array (
					"name" => "Tracciato Xls",
					"desc" => "File Xls utilizzato per la generazione dei risultati nella breve",
					"id" => "tecaSolrSearchXsl",
					"type" => "text",
					"parent" => "header-styles",
					"size" => "100",
					"std" => "wp-content/plugins/md-opac/xsd/solrToSearchResult.xsl" 
			)
		);
	?>
<div class="wrap">
	<h1>Configurazione Scheda per la Ricerca</h1>
	<div class="mnt-options">
<?php
	$createForm->create_form ( $options );
	?>
    </div>
</div>
<?php
}

/**
 */
function md_scheda() {
	$createForm = new CreateForm();
	$adminConfig = new adminConfig();
	
	$options = array (
			array (
					"name" => "Campi Scheda",
					"desc" => "Campi da visualizzare nella scheda",
					"id" => "tecaSolrSchedaField",
					"type" => "multi-select",
					"options" => $adminConfig->tecaSolrSchedaField(),
					"parent" => "header-styles",
					"std" => "none"
			),
			array (
					"name" => "Tracciato Xls",
					"desc" => "File Xls utilizzato per la generazione della scheda",
					"id" => "tecaSolrSchedaXsl",
					"type" => "text",
					"parent" => "header-styles",
					"size" => "100",
					"std" => "wp-content/plugins/md-opac/xsd/show/solrToScheda.xsl"
			), 
			array (
					"name" => "Campi Scheda Figli",
					"desc" => "Campi da visualizzare nella scheda figli",
					"id" => "tecaSolrSchedaFigliField",
					"type" => "multi-select",
					"options" => $adminConfig->tecaSolrSchedaField(),
					"parent" => "header-styles",
					"std" => "none"
			),
			array (
					"name" => "Tracciato Xls Figli",
					"desc" => "File Xls utilizzato per la generazione della scheda Figli",
					"id" => "tecaSolrSchedaFigliXsl",
					"type" => "text",
					"parent" => "header-styles",
					"size" => "100",
					"std" => "wp-content/plugins/md-opac/xsd/show/solrToSchedaFigli.xsl"
			),
			array (
					"name" => "Tipologie files View",
					"desc" => "Tipologie files accettate per la visualizzazione degli oggetto",
					"id" => "tecaSolrSchedaMimeTypeShow",
					"type" => "multi-select",
					"options" =>  $adminConfig->tecaSolrMimeTypeShow(),
					"parent" => "header-styles",
					"std" => ""
			),
			array (
					"name" => "URL Show Object",
					"desc" => "Indirizzo URL per la visualizzazione degli oggetti",
					"id" => "tecaSolrSchedaURLShowObject",
					"type" => "text",
					"parent" => "header-styles",
					"size" => "100",
					"std" => "/index.php/opac/login-oggetti-digitali/"
			),
			array (
					"name" => "URL Richieste Visualizzazione",
					"desc" => "Indirizzo URL il calcolo delle richieste di Visualizzazione",
					"id" => "NumberViewPortWsdl",
					"type" => "text",
					"parent" => "header-styles",
					"size" => "100",
					"std" => "http://md-services.test.bncf.lan/MagazziniDigitaliServices/services/NumberViewPort?wsdl"
			)
			
	);
	?>
<div class="wrap">
	<h1>Configurazione Scheda per la Ricerca</h1>
	<div class="mnt-options">
<?php
$createForm->create_form ( $options );
	?>
    </div>
</div>
<?php
}
?>