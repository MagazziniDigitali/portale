<?php
include_once (MD_PLUGIN_PATH . 'tools/form/createForm.php');
class adminConfig {

	/**
	 */
	function __construct() {
	}

	function tecaSolrMimeTypeShow(){
		$createForm = new CreateForm ();
		$mimeType = array("application/pdf" => "PDF",
                          "application/epub+zip" => "EPUB");
		return $createForm->genArrayMultiSelect ($mimeType);
	}

	/**
	 * Indica la lista dei campi visualizzati nella ricostruzione breve
	 *
	 * @return unknown|NULL
	 */
	function tecaSolrSearchField() {
		$createForm = new CreateForm ();
		$tecaSolrTipoDB = get_option ( 'tecaSolrTipoDB' );
		if (isset ( $tecaSolrTipoDB )) {
			if ($tecaSolrTipoDB == 'magazziniDigitali') {
				$tecaSolrSearchFieldMD = $this->tecaSolrSearchFieldMD ();
				return $createForm->genArrayMultiSelect ( $tecaSolrSearchFieldMD );
			} else if ($tecaSolrTipoDB == 'sast') {
				$tecaSolrSearchFieldSast = $this->tecaSolrSearchFieldSast();
				return $createForm->genArrayMultiSelect ( $tecaSolrSearchFieldSast);
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}

	/**
	 * Indica la lista dei campi visualizzati nella ricostruzione breve per
	 * la dase dati Sast
	 *
	 * @return string[]
	 */
	private function tecaSolrSearchFieldSast() {
		return array (
				"id" => "Identificativo",
				"tipoOggetto_show" => "Tipo oggetto",
				"originalFileName_show" => "File originale",
				"mimeType_show" => "Mime Type",
				"size_show" => "Dimensione",
				"autore_show" => "Autore",
				"titolo_show" => "Titolo",
				"inventario_show" => "Inventario",
				"collocazione_show" => "Collocazione",
				"eventType_show" => "Event Type",
				"eventDate_show" => "Event Date",
				"eventOutCome_show" => "Event Out Come"
		);
	}

	/**
	 * Indica la lista dei campi visualizzati nella ricostruzione breve per
	 * la dase dati Magazzini Digitali
	 *
	 * @return string[]
	 */
	private function tecaSolrSearchFieldMD() {
		return array (
				"id" => "Identificativo",
				"tipoOggetto_show" => "Tipo oggetto",
				"originalFileName_show" => "File originale",
				"mimeType_show" => "Mime Type",
				"size_show" => "Dimensione",
				"autore_show" => "Autore",
				"titolo_show" => "Titolo",
				"data_show" => "Data",
				"inventario_show" => "Inventario",
				"collocazione_show" => "Collocazione",
				"eventType_show" => "Event Type",
				"eventDate_show" => "Event Date",
				"eventOutCome_show" => "Event Out Come",
				"agentName_show" => "Agent Name",
				"agentType_show" => "Agent Type",
				"rightsBasis_show" => "Rigths Basis"
		);
	}

	/**
	 * Indica la lista dei possibili indici nella breve
	 *
	 * @return unknown|NULL
	 */
	function tecaSolrSearchSort() {
		$createForm = new CreateForm ();
		$tecaSolrTipoDB = get_option ( 'tecaSolrTipoDB' );
		if (isset ( $tecaSolrTipoDB )) {
			if ($tecaSolrTipoDB == 'magazziniDigitali') {
				$tecaSolrSearchSortMD = $this->tecaSolrSearchSortMD();
				return $createForm->genArrayMultiSelect ( $tecaSolrSearchSortMD );
			} else if ($tecaSolrTipoDB == 'sast') {
				$tecaSolrSearchSortSast = $this->tecaSolrSearchSortSast();
				return $createForm->genArrayMultiSelect ( $tecaSolrSearchSortSast );
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}

	/**
	 * Indica la lista dei possibili indici nella breve per
	 * la dase dati Sast
	 *
	 * @return string[]
	 */
	private function tecaSolrSearchSortSast() {
		return array (
				"soggettoConservatore_sort asc, fondo_sort asc, subFondo_sort asc, collocazione_sort asc" => "Soggetto Conservatore Asc, Fondo Asc, subFondo Asc, Collocazione Asc"
		);
	}

	/**
	 * Indica la lista dei possibili indici nella breve per
	 * la dase dati Sast
	 *
	 * @return string[]
	 */
	private function tecaSolrSearchSortMD() {
		return array (
				"collocazione_sort asc" => "Collocazione Asc"
		);
	}

	/**
	 * Indica la lista dei possibili indici nella breve
	 *
	 * @return unknown|NULL
	 */
	function tecaSolrSearchFacetPivot() {
		$createForm = new CreateForm ();
		$tecaSolrTipoDB = get_option ( 'tecaSolrTipoDB' );
		if (isset ( $tecaSolrTipoDB )) {
			if ($tecaSolrTipoDB == 'magazziniDigitali') {
				$tecaSolrSearchFacetPivotMD = $this->tecaSolrSearchFacetPivotMD();
				return $createForm->genArrayMultiSelect ( $tecaSolrSearchFacetPivotMD );
			} else if ($tecaSolrTipoDB == 'sast') {
				$tecaSolrSearchFacetPivotSast = $this->tecaSolrSearchFacetPivotSast();
				return $createForm->genArrayMultiSelect ( $tecaSolrSearchFacetPivotSast );
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}

	/**
	 * Indica la lista dei possibili indici nella breve per
	 * la dase dati Sast
	 *
	 * @return string[]
	 */
	public function tecaSolrSearchFacetPivotSast() {
		return array (
				"tipologiaFile_fc" => "Tipologia File",
				"soggettoConservatore_fc#soggettoConservatoreKey_fc#tipologiaFile_fc#soggettoConservatoreScheda_fc" => "Soggetto Conservatore",
				"fondo_fc#fondoKey_fc#soggettoConservatoreKey_fc#tipologiaFile_fc#fondoScheda_fc" => "Fondo",
				"subFondo_fc#subFondoKey_fc#subFondoScheda_fc" => "Sotto Livelli",
				"subFondo2_fc#subFondo2Key_fc#subFondo2Scheda_fc" => "Sotto Livelli2",
				"subFondo3_fc#subFondo3Key_fc#subFondo3Scheda_fc" => "Sotto Livelli3"
		);
	}

	/**
	 * Indica la lista dei possibili indici nella breve per
	 * la dase dati Sast
	 *
	 * @return string[]
	 */
	public function tecaSolrSearchFacetPivotMD() {
		return array (
				"tipoOggetto_fc" => "Oggetto",
				"fileType_fc" => "Contenitore",
				"mimeType_fc" => "Tipo File",
				"tipoContenitore_fc" => "Tipo Contenitore",
				"autore_fc" => "Autori",
				"titolo_fc" => "Titoli",
				"data_fc" => "Data pubblicazione",
				"eventType_fc" => "Eventi",
				"agentSoftware_fc" => "Agente Software"
		);
	}

	/**
	 * Indica la lista dei possibili indici nella breve
	 *
	 * @return unknown|NULL
	 */
	function tecaSolrSchedaField() {
		$createForm = new CreateForm ();
		$tecaSolrTipoDB = get_option ( 'tecaSolrTipoDB' );
		if (isset ( $tecaSolrTipoDB )) {
			if ($tecaSolrTipoDB == 'magazziniDigitali') {
				$tecaSolrSchedaFieldMD = $this->tecaSolrSchedaFieldMD();
				return $createForm->genArrayMultiSelect ( $tecaSolrSchedaFieldMD );
			} else if ($tecaSolrTipoDB == 'sast') {
				$tecaSolrSchedaFieldSast = $this->tecaSolrSchedaFieldSast();
				return $createForm->genArrayMultiSelect ( $tecaSolrSchedaFieldSast );
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}

	/**
	 * Indica la lista dei possibili indici nella breve per
	 * la dase dati Sast
	 *
	 * @return string[]
	 */
	private function tecaSolrSchedaFieldSast() {
		return array (
				"id" => "Identificativo",
				"tipoOggetto_show" => "Tipologia File",
				"bid_show" => "Bid",
				"soggettoConservatore_show" => "Soggetto Conservatore",
				"soggettoConservatoreKey_show" => "Soggetto Conservatore Chiave",
				"soggettoConservatoreScheda_show" => "Soggetto Conservatore Scheda",
				"fondo_show" => "Fondo",
				"fondoKey_show" => "Fondo Chiave",
				"fondoScheda_show" => "Fondo Scheda",
				"subFondo_show" => "Sub Fondo",
				"subFondoScheda_show" => "Sub Fondo Scheda",
				"subFondoKey_show" => "Sub Fondo chiave",
				"subFondo2_show" => "Sub Fondo2",
				"subFondo2Scheda_show" => "Sub Fondo2 Scheda",
				"subFondo2Key_show" => "Sub Fondo2 Chiave",
				"subFondo3_show" => "Sub Fondo3",
				"subFondo3Scheda_show" => "Sub Fondo3 Scheda",
				"subFondo3Key_show" => "Sub Fondo3 Chiave",
				"collocazione_show" => "Collocazione",
				"_root_" => "Collegamento Scheda Padre",
				"_rootDesc_" => "Descrizione Scheda Padre",
				"tipologiaMateriale_show" => "Tipologia Materiale",
				"tipologiaFile_show" => "Tipologia File",
				"titolo_show" => "Titolo",
				"lingua_show" => "Lingua",
				"dataCronica_show" => "Data Cronica",
				"dataTopica_show" => "Data Topica",
				"supporto_show" => "Supporto",
				"tecnica_show" => "Tecnica",
				"dimensione_show" => "Dimensione",
				"scala_show" => "Scala",
				"statoConservazione_show" => "Stato Conservazione",
				"autore_show" => "Autore",
				"datiFruizione_show" => "Dati Fruizione",
				"compilatore_show" => "Compilatore",
				"dataCompilazione_show" => "Data Compilazione",
				"tipologiaUnitaArchivistica_show" => "Tipologia Unità Archivistica",
				"annoIniziale_show" => "Anno Iniziale",
				"annoFinale_show" => "Anno Finale",
				"secoloIniziale_show" => "Secolo Iniziale",
				"secoloFinale_show" => "Secolo Finale",
				"consistenzaCarte_show" => "Consistenza Carte",
				"consistenzaSast_show" => "Consistenza Oggetti Digitali",
				"documentiCatografici_show" => "Documenti Cartografici",
				"children_show" => "Collegamento alle schede Figlie",
				"childrenDesc_show" => "Descrizioni alle schede Figlie",
				"originalFileName_show" => "Nome del file Originale",
				"note_show" => "Note",
				"xmlSchedaF" => "Scheda F",
				"descrizione_show" => "Descrizione",
				"indirizzo_show" => "Indirizzo",
				"telefono_show" => "Telefono",
				"fax_show" => "Fax",
				"estremi_show" => "Estremi",
				"storiaArchivistica_show" => "Storia Archivistica",
				"soggettoProduttore_show" => "Soggetto Produttore",
				"soggettoProduttoreKey_show" => "Soggetto Produttore Key",
				"tipoSoggettoConservatore_show" => "Tipo Soggetto Conservatore",
				"email_show" => "Email",
				"servizioPub_show" => "Servizi consultazione al Pub.",
				"orarioApertura_show" => "Orario Apertura",
				"schedeConservatori_show" => "Schede Conservatori",
				"schedeConservatoriUrl_show" => "Schede Conservatori URL",
				"risorseEsterne_show" => "Risorse Esterne",
				"risorseEsterneUrl_show" => "Risorse Esterne URL",
				"tipologia_show" => "Tipologia",
				"sistemaAderente_show" => "Sistema Aderente",
				"schedaProvenienzaUrl_show" => "Scheda Provenienza Url",
				"altreDenominazioni_show" => "Altre Denominazioni",
				"dataEsistenza_show" => "Data Esistenza",
				"dataMorte_show" => "Data Morte",
				"luogoNascita_show" => "Luogo di Nascita",
				"luogoMorte_show" => "Luogo di Morte",
				"sede_show" => "Sede",
				"naturaGiuridica_show" => "Natura Giuridica",
				"tipoEnte_show" => "Tipo Ente",
				"ambitoTerritoriale_show" => "Ambito Territoriale",
				"contenuto_show" => "Contenuto",
				"sottoUnita_show" => "Sotto Unità"
		);
	}

	/**
	 * Indica la lista dei possibili indici nella breve per
	 * la dase dati Sast
	 *
	 * @return string[]
	 */
	private function tecaSolrSchedaFieldMD() {
		return array (
				"id" => "Identificativo",
				"tipoOggetto_show" => "Tipologia File",
				"bid_show" => "Bid",
				"bidUrl_show" => "Bid Url",
				"journalBid_show" => "Journal Bid",
				"journalBidUrl_show" => "Journal Bid Url",
				"collocazione_show" => "Collocazione",
				"_root_" => "Collegamento Scheda Root",
				"padre" => "Collegamento Scheda Padre",
				"titolo_show" => "Titolo",
				"journalTitolo_show" => "Journal Titolo",
				"lingua_show" => "Lingua",
				"autoreId_show" => "ID Autore",
				"autore_show" => "Autore",
				"originalFileName_show" => "Nome del file Originale",
				"descrizione_show" => "Descrizione",
				"provenienzaOggetto_show" => "Provenienza Oggetto",
				"tipoContenitore_show" => "Tipo Contenitore",
				"objectIdentifier_show" => "Object Identifier",
				"fileType_show" => "File Type",
				"actualFileName_show" => "Actual File Name",
				"compositionLevel_show" => "Composition Level",
				"sha1_show" => "Sha1",
				"size_show" => "Size",
				"mimeType_show" => "Mime Type",
				"promon_show" => "Promon",
				"rights_show" => "Rights",
				"tarIndex_show" => "tarIndex",
				"relationshipType_show" => "relationshipType",
				"eventID_show" => "Event ID",
				"eventType_show" => "Event Type",
				"eventDate_show" => "Event Date",
				"eventDetail_show" => "Event Detail",
				"eventOutCome_show" => "Event Out Come",
				"agentDepositante_show" => "Agent Depositante",
				"agentSoftware_show" => "Agent Software",
				"nodo_show" => "Nodo",
				"tipoDocumento_show" => "Tipo Documento",
				"bni_show" => "Bni",
				"pubblicazione_show" => "Luogo di pubblicazione",
				"soggetto_show" => "Soggetto",
				"contributo_show" => "Contributo",
				"data_show" => "Data Pubblicazione",
				"tiporisorsa_show" => "Tipo Risorsa",
				"formato_show" => "Formato",
				"fonte_show" => "Fonte",
				"relazione_show" => "RElazione",
				"copertura_show" => "Copertura",
				"gestionediritti_show" => "Gestione Diritti",
				"biblioteca_show" => "Biblioteca",
				"inventario_show" => "Inventario",
				"piecegr_show" => "Piece gr",
				"piecedt_show" => "Piece dt",
				"piecein_show" => "Piece in",
				"indexed_show" => "Data ora indicizzazione",
				"pageStart_show" => "Pagina di partenza",
				"pageEnd_show" => "Pagina di arrivo",
				"url_show" => "Url",
				"agentIdentifier_show" => "Agent Identifier",
				"agentName_show" => "Agent Name",
				"agentType_show" => "Agent Type",
				"agentNote_show" => "Agent Note",
				"agentIdIstituzione_show" => "Agent Id Istitutzione",
				"agentIdRigths_show" => "Agent Id Rights",
				"rightsIdentifier_show" => "Rigths Identifier",
				"rightsBasis_show" => "Rigths Basis",
				"rightsInformationBasis_show" => "Rigths Information Basis",
				"rightsAct_show" => "Rigths Act",
				"rightsRestriction_show" => "Rigths Restriction",
				"rightsObjectIdentifier_show" => "Rigths Object Itentifier",
				"rightsStatuteJurisdiction_show" => "Rigths Statute Jurisdiction",
				"rightsStatuteCitation_show" => "Rigths Statute Citation",
				"nbn_show" => "NBN",
				"agentMachine_show" => "Agent Machine",
				"registroId_show" => "Registro Ingressi ID",
				"registroTimeStampIngest_show" => "Registro Ingressi Data Ora Ingest",
				"registroContainerFingerPrint_show" => "Registro Ingressi Finger Print",
				"registroContainerFingerPrintChain_show" => "Registro Ingressi Finger Print Chain",
				"registroContainerType_show" => "Registro Ingressi Container Type",
				"registroStatus_show" => "Registro Ingressi Status",
				"registroTimeStampInit_show" => "Registro Ingressi Data Ora Init",
				"registroTimeStampElab_show" => "Registro Ingressi Data Ora Elaborazione",
				"registroTimeStampCoda_show" => "Registro Ingressi Data Ora Coda",
				"registroTimeStampPub_show" => "Registro Ingressi Data Ora Pubblicazione",
				"registroTimeStampErr_show" => "Registro Ingressi Data Ora Errori",
		);
	}
}
?>
