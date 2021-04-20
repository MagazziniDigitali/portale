<?php
include_once (MD_PLUGIN_PATH . 'tools/converter.php');
include_once (MD_PLUGIN_PATH . 'tools/molliche.php'); 
include_once (MD_PLUGIN_PATH . 'tools/stringManipolator.php');
include_once (MD_PLUGIN_PATH . 'tools/solr/MDSolrFacet.php');
include_once (MD_PLUGIN_PATH . 'tools/wsdl/wsdlClient.php');

/**
 * Classe utilizzata pe la gestione dei metodo per la gestione dell'accesso alla base dati Solr
 *
 * @author massi
 *
 */
class MDSolr extends MDSolrFacet {

	private $keyword = '';
	private $result = '';
	private $qStart = '';
	private $recPag = '';
	private $facetQuery = '';
	private $facetQueryTitolo = '';
	private $keySolr = '';
	private $valueSolr = '';
	private $start;
	private $indietro;
	private $end;
	private $avanti;
	private $numFound;
	private $fine;
	private $QTime;

	/**
	 * Costruttore
	 */
	function __construct() {
		parent::__construct();
		$this->initKeyword ();
		$this->initNavigator ();
		$this->initFacet ();
		$this->initKeySolr ();
	}

	/**
	 * Metodo utilizzato per inizializzare la variabile Keyword e Result
	 */
	private function initKeyword() {
		$this->keyword = '';
		$this->result = '';

		if (isset ( $_REQUEST ['keyword'] )) {
			$this->keyword = $_REQUEST ['keyword'];
		}
		if ($this->keyword == 'Ricerca per parola:') {
			$this->keyword = '';
		}
	}

	/**
	 * Metodo utilizzato per l'inizializzazione delle infomrazioni per la navigazione
	 */
	private function initNavigator() {
		if (! isset ( $_REQUEST ['qStart'] )) {
			$this->qStart = 0;
		} else {
			$this->qStart = $_REQUEST ['qStart'];
		}
		if (! isset ( $_REQUEST ['recPag'] ) || $_REQUEST ['recPag'] == '') {
			$this->recPag = get_option ( 'tecaSolrSearchPage', '10' );
		} else {
			$this->recPag = $_REQUEST ['recPag'];
		}
	}

	//	facetQuery=%2BtipoOggetto_fc%3A%22contenitore%22
	/**
	* Metodo utilizzato per la lettura dell'eventuali filtri per le facette
	*/
	private function initFacet() {

		if (isset ( $_REQUEST ['facetQuery'] ) && $_REQUEST ['facetQuery'] !== '') {
			if (isset ( $_REQUEST ['facetQuery'] )) {
				$this->facetQuery = $_REQUEST ['facetQuery'];
				$this->facetQueryTitolo = $_REQUEST ['facetQuery'];
				// echo("FQ: ".$this->facetQuery."<br/>");
				$this->facetQueryTitolo = str_replace ( '+tipologiaFile_fc:', ' ', $this->facetQueryTitolo );
				$this->facetQueryTitolo = str_replace ( '+soggettoConservatore_fc:', ' ', $this->facetQueryTitolo );
				$this->facetQueryTitolo = str_replace ( '+fondo_fc:', ' ', $this->facetQueryTitolo );
				$this->facetQueryTitolo = str_replace ( '+subFondo_fc:', ' ', $this->facetQueryTitolo );
			}
		} else {
			// echo("FQ: ".$this->facetQuery."<br/>");
			// echo ("SSS.");
			if (isset ( $_REQUEST ['tipologiaFile_fc'] ) && $_REQUEST ( 'tipologiaFile_fc' ) !== '') {
				$this->facetQuery .= '+tipologiaFile_fc:"' . $_REQUEST ( 'tipologiaFile_fc' ) . '"';
				$this->facetQueryTitolo .= $_REQUEST ( 'tipologiaFile_fc' );
			}

			if (isset ( $_REQUEST ['soggettoConservatoreKey_fc'] ) && $_REQUEST ['soggettoConservatoreKey_fc'] !== '') {
				if ($this->facetQuery !== '') {
					$this->facetQuery .= ' ';
					$this->facetQueryTitolo .= ' ';
				}
				$this->facetQuery .= '+soggettoConservatoreKey_fc:"' . $_REQUEST ['soggettoConservatoreKey_fc'] . '"';
				$this->facetQueryTitolo .= $_REQUEST ['soggettoConservatoreKey_fc'];
			}

			if (isset ( $_REQUEST ['soggettoConservatore_fc'] ) && $_REQUEST ['soggettoConservatore_fc'] !== '') {
				if ($this->facetQuery !== '') {
					$this->facetQuery .= ' ';
					$this->facetQueryTitolo .= ' ';
				}
				if ($_REQUEST ['soggettoConservatore_fc'] == 'non_identificabile') {
					$this->facetQuery .= '+soggettoConservatore_fc:"non identificabile"';
				} else {
					$this->facetQuery .= '+soggettoConservatore_fc:"' . $_REQUEST ['soggettoConservatore_fc'] . '"';
					$this->facetQueryTitolo .= $_REQUEST ['soggettoConservatore_fc'];
				}
			}

			if (isset ( $_REQUEST ['fondoKey_fc'] ) && $_REQUEST ['fondoKey_fc'] !== '') {
				if ($this->facetQuery !== '') {
					$this->facetQuery .= ' ';
					$this->facetQueryTitolo .= ' ';
				}
				$this->facetQuery .= '+fondoKey_fc:"' . $_REQUEST ['fondoKey_fc'] . '"';
				$this->facetQueryTitolo .= $_REQUEST ['fondoKey_fc'];
			}

			if (isset ( $_REQUEST ['fondo_fc'] ) && $_REQUEST ['fondo_fc'] !== '') {
				if ($this->facetQuery !== '') {
					$this->facetQuery .= ' ';
					$this->facetQueryTitolo .= ' ';
				}
				$this->facetQuery .= '+fondo_fc:"' . $_REQUEST ['fondo_fc'] . '"';
				$this->facetQueryTitolo .= $_REQUEST ['fondo_fc'];
			}

			if (isset ( $_REQUEST ['subFondoKey_fc'] ) && $_REQUEST ['subFondoKey_fc'] !== '') {
				if ($this->facetQuery !== '') {
					$this->facetQuery .= ' ';
					$this->facetQueryTitolo .= ' ';
				}
				$this->facetQuery .= '+subFondoKey_fc:"' . $_REQUEST ['subFondoKey_fc'] . '"';
				$this->facetQueryTitolo .= $_REQUEST ['subFondoKey_fc'];
			}

			if (isset ( $_REQUEST ['subFondo_fc'] ) && $_REQUEST ['subFondo_fc'] !== '') {
				if ($this->facetQuery !== '') {
					$this->facetQuery .= ' ';
					$this->facetQueryTitolo .= ' ';
				}
				$this->facetQuery .= '+subFondo_fc:"' . $_REQUEST ['subFondo_fc'] . '"';
				$this->facetQueryTitolo .= $_REQUEST ['subFondo_fc'];
			}

			if (isset ( $_REQUEST ['subFondo2Key_fc'] ) && $_REQUEST ['subFondo2Key_fc'] !== '') {
				if ($this->facetQuery !== '') {
					$this->facetQuery .= ' ';
					$this->facetQueryTitolo .= ' ';
				}
				$this->facetQuery .= '+subFondo2Key_fc:"' . $_REQUEST ['subFondo2Key_fc'] . '"';
				$this->facetQueryTitolo .= $_REQUEST ['subFondo2Key_fc'];
			}
		}
	}

	/**
	 * Metodo utilizzato per la lettura dei filtri per KeySolr
	 */
	private function initKeySolr() {
		$this->keySolr = '';
		$this->valueSolr = '';
		if ($this->keyword == '') {
			if (isset ( $_REQUEST ['keySolr'] ) && $_REQUEST ['keySolr'] !== '') {
				$this->keySolr = $_REQUEST ['keySolr'];
			}

			if (isset ( $_REQUEST ['valueSolr'] ) && $_REQUEST ['valueSolr'] !== '') {
				$this->valueSolr = str_replace ( ']', '', str_replace ( '[', '', str_replace ( '"', '', $_REQUEST ['valueSolr'] ) ) );
			}

			if ($this->keySolr == 'tipologiaFile') {
				$this->facetQuery .= '+tipologiaFile:"' . str_replace ( ' ', '_', $this->valueSolr ) . '"';
				$this->facetQueryTitolo .= $this->valueSolr;
				$this->keySolr = '';
				$this->valueSolr = '';
			} else if ($this->keySolr == 'soggettoConservatore' || $this->keySolr == 'denominazione') {
				if ($this->valueSolr == 'non identificabile') {
					$this->facetQuery .= '+soggettoConservatore:"non identificabile"';
				} else {
					$this->facetQuery .= '+soggettoConservatore:"' . str_replace ( ' ', '_', $this->valueSolr ) . '"';
					$this->facetQueryTitolo .= $this->valueSolr;
				}
				$this->keySolr = '';
				$this->valueSolr = '';
			} else if ($this->keySolr == 'fondo') {
				$this->facetQuery .= '+fondo:"' . str_replace ( ' ', '_', $this->valueSolr ) . '"';
				$this->facetQueryTitolo .= $this->valueSolr;
				$this->keySolr = '';
				$this->valueSolr = '';
			} else if ($this->keySolr == 'subFondo') {
				$this->facetQuery .= '+subFondo:"' . str_replace ( ' ', '_', $this->valueSolr ) . '"';
				$this->facetQueryTitolo .= $this->valueSolr;
				$this->keySolr = '';
				$this->valueSolr = '';
			} else if ($this->keySolr == 'subFondo2') {
				$this->facetQuery .= '+subFondo2:"' . $this->valueSolr . '"';
				$this->facetQueryTitolo .= $this->valueSolr;
				$this->keySolr = '';
				$this->valueSolr = '';
			} else if ($this->keySolr == 'agentDepositante') {
				$this->facetQuery .= '+agentDepositante:"' . $this->valueSolr . '"';
				$this->facetQueryTitolo .= $this->valueSolr;
				$this->keySolr = '';
				$this->valueSolr = '';
			}
		}

		$titolo = "";
		if ($this->keyword !== '') {
			$titolo .= " " . $this->keyword;
		} else {
			if ($this->keySolr !== '' && $this->valueSolr !== '') {
				$titolo .= $this->valueSolr;
			}
		}
		if ($this->facetQuery !== '' && $this->facetQuery !== NULL) {
			$titolo .= " " . $this->facetQueryTitolo;
		}

		checkMolliche ( $titolo);
	}

	/**
	 * Metodo utilizzato per eseguire le ricerche per la breve
	 *
	 * @param unknown $keyword
	 * @return string
	 */
	function searchSolr($keyword) {
		$options = array (
			'hostname' => get_option ( 'tecaSolrServer', 'default_value' ),
			'port' => get_option ( 'tecaSolrPort', 'default_value' )
		);
		
		$client = new SolrClient ( $options );
		$client->setServlet ( SolrClient::SEARCH_SERVLET_TYPE, get_option ( 'tecaSolrSearchServlet', 'default_value' ) );

		$query = new SolrQuery ();

		if (get_option ( 'tecaSolrSearchSort', '' ) != '') {
			$sorts = explode ( ",", get_option ( 'tecaSolrSearchSort', '' ) );
			foreach ( $sorts as &$sort ) {
				$dati = explode ( " ", trim ( $sort ) );
				$key = trim ( $dati [0] );
				if (trim ( $dati [1] ) == 'asc') {
					$ord = SolrQuery::ORDER_ASC;
				} else {
					$ord = SolrQuery::ORDER_DESC;
				}

				$query->addSortField ( $key, $ord );
			}
		}

		$solrQuery = '';
		if ($keyword == '') {
			if ($this->keySolr == '' && $this->valueSolr == '') {
				$solrQuery = '*:*';
			} else {
				if ($this->keySolr == 'collocazione') {
					$solrQuery .= ' +' . $this->keySolr . ':"' . trim ( $this->valueSolr ) . '"';
				} else {
					$pieces = explode ( " ", trim ( $this->valueSolr ) );
					foreach ( $pieces as &$valuePieces ) {
						$solrQuery .= ' +' . $this->keySolr . ':' . $valuePieces;
					}
				}
			}
		} else {
			$pieces = explode ( " ", trim ( $keyword ) );
			foreach ( $pieces as &$valuePieces ) {
				$solrQuery .= ' +keywords:' . str_replace('\"','"',str_replace ( ':', '\\:',$valuePieces));
			}
		}

		if ($this->facetQuery != '') {
			if ($solrQuery == '*:*') {
				$solrQuery = '';
			}
			$solrQuery .= ' ' . str_replace('\"','"',str_replace ( '_fc:', ':', $this->facetQuery));
		}

		if (isset ( $_REQUEST ['RA_Fields'] )) {
                        $raFields = $_REQUEST ['RA_Fields'];
			$xml = simplexml_load_string(hex2bin($raFields));
			if ($xml->search != '') {
				$solrQuery .= ' '.$xml->search;
    			}
                        $solrQuery = $this->addFilterAdvanzed($solrQuery, $xml);
                } else {
                        $solrQuery = $this->addFilterAdvanzed($solrQuery, $xml);
                }

		$tecaSolrSearchExclude = get_option ( 'tecaSolrSearchExclude' );
		if (isset($tecaSolrSearchExclude) && $tecaSolrSearchExclude != ''){
			$excludes = explode ( "\r", $tecaSolrSearchExclude );
			foreach ( $excludes as &$exclude ) {
				$solrQuery .= ' NOT ' . $exclude;
			}
		}
		$query->setQuery ( $solrQuery );
		$query->setStart ( $this->qStart );
		$query->setRows ( $this->recPag );

		$tecaSolrSearchField = get_option ( 'tecaSolrSearchField');
		if (isset($tecaSolrSearchField) && $tecaSolrSearchField != ''){
			$fields = explode ( ",", $tecaSolrSearchField );
			foreach ( $fields as &$field ) {
				$query->addField ( $field );
			}
		}
		if (get_option ( 'tecaSolrSearchFacet', 'false' ) == TRUE) {
			$query->setFacet ( TRUE );
			$query->setFacetMinCount ( get_option ( 'tecaSolrSearchFacetMinCount', '1' ) );
			$query->setFacetLimit ( get_option ( 'tecaSolrSearchFacetLimit', '10' ) );
			$query->setFacetSort ( get_option ( 'tecaSolrSearchFacetSort', '1' ) );

			$tecaSolrSearchFacetField = get_option ( 'tecaSolrSearchFacetField' );
			if (isset($tecaSolrSearchFacetField) && $tecaSolrSearchFacetField != '') {
				$fields = explode ( ",", $tecaSolrSearchFacetField );
				foreach ( $fields as &$field ) {
					if ($field == 'fondo_fc' || $field == 'subFondo_fc') {
						if (strpos ( $this->facetQuery, '+soggettoConservatore_fc:' ) !== false || strpos ( $this->facetQuery, '+soggettoConservatoreKey_fc:' ) !== false || strpos ( $this->facetQuery, '+fondo_fc:' ) !== false || strpos ( $this->facetQuery, '+fondoKey_fc:' ) !== false || strpos ( $this->facetQuery, '+subFondo_fc:' ) !== false) {
							$query->addFacetField ( $field );
						}
					} else {
						$query->addFacetField ( $field );
					}
				}
			}
			$tecaSolrSearchFacetPivot = get_option ( 'tecaSolrSearchFacetPivot', 'default_value' );
			if (isset($tecaSolrSearchFacetPivot) && $tecaSolrSearchFacetPivot != '') {
				$fields = explode ( ",", $tecaSolrSearchFacetPivot );
				foreach ( $fields as &$field ) {
					$field = str_replace ( '#', ',', $field );
					if (startsWith ( $field, 'fondo_fc' )) {
						if (strpos ( $this->facetQuery, '+soggettoConservatore_fc:' ) !== false || strpos ( $this->facetQuery, '+soggettoConservatoreKey_fc:' ) !== false) {
							$query->addParam ( 'facet.pivot', $field );
						}
					} else if (startsWith ( $field, 'subFondo_fc' )) {
						if (strpos ( $this->facetQuery, '+fondo_fc:' ) !== false || strpos ( $this->facetQuery, '+fondoKey_fc:' ) !== false) {
							$query->addParam ( 'facet.pivot', $field );
						}
					} else if (startsWith ( $field, 'subFondo2_fc' )) {
						if (strpos ( $this->facetQuery, '+subFondo_fc:' ) !== false || strpos ( $this->facetQuery, '+subFondoKey_fc:' ) !== false) {
							$query->addParam ( 'facet.pivot', $field );
						}
					} else {
						$query->addParam ( 'facet.pivot', $field );
					}
				}
			}
		}
		$query->addParam ( 'wt', 'xml' );

		try {
			$query_response = $client->query ( $query );
			$response = $query_response->getRawResponse ();
			$this->calcStatoPage($query_response->getResponse ());
			$this->disFacetMenu ( $query_response->getResponse (), $this->facetQuery, MD_PLUGIN_URL );
		} catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}




		return convertToHtml ( $response, get_option ( 'tecaSolrSearchXsl', 'components/com_tecaricerca/views/search/xsd/solrToSearchResult.xsl' ) );
	}

	function addFilterAdvanzed($solrQuery, $xml){
          if (!isset($xml) || !isset($xml->RA_esclusioni->agentSoftware)){
            $solrQuery .= ' NOT agentType:software';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->contenitoreAdmtape)){
            $solrQuery .= ' NOT (tipoOggetto:contenitore +tipoContenitore:admtape)';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->eventDecompress)){
            $solrQuery .= ' NOT eventType:decompress';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->eventSend)){
            $solrQuery .= ' NOT eventType:send';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->eventValidation)){
            $solrQuery .= ' NOT eventType:validation';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->eventCopyPremis)){
            $solrQuery .= ' NOT eventType:copyPremis';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->eventMoveFile)){
            $solrQuery .= ' NOT eventType:moveFile';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->eventGeoReplica)){
            $solrQuery .= ' NOT eventType:geoReplica';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->eventIndex)){
            $solrQuery .= ' NOT eventType:index';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->fileMd5)){
            $solrQuery .= ' NOT promon:993';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->fileHtml)){
            $solrQuery .= ' NOT originalFileName:*html NOT originalFileName:*htm';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->fileJp2)){
            $solrQuery .= ' NOT originalFileName:*jp2';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->fileJpeg)){
            $solrQuery .= ' NOT mimeType:image/jpeg';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->fileTif)){
            $solrQuery .= ' NOT mimeType:image/tiff';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->filePremis)){
            $solrQuery .= ' NOT originalFileName:*premis';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->fileJson)){
            $solrQuery .= ' NOT mimeType:"application/json"';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->fileManifest)){
            $solrQuery .= ' NOT originalFileName:"*manifest-sha256.txt" NOT originalFileName:"*tagmanifest-sha256.txt"';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->oggettoRegistro)){
            $solrQuery .= ' NOT tipoOggetto:registro NOT originalFileName:RegistroIngresso*';
          }
          if (!isset($xml) || !isset($xml->RA_esclusioni->oggettoDiritti)){
            $solrQuery .= ' NOT tipoOggetto:diritti ';
          }
          return $solrQuery;
        }

	/**
	 *
	 * @param unknown $id
	 * @param unknown $bid
	 * @return string
	 */
	function searchShowSolr($id,$bid) {
		$options = array (
				'hostname' => get_option('tecaSolrServer','default_value'),
				'port' => get_option('tecaSolrPort','default_value')
		);

		$client = new SolrClient ( $options );
		$client->setServlet ( SolrClient::SEARCH_SERVLET_TYPE, get_option('tecaSolrSearchServlet','default_value') );

		$query = new SolrQuery ();
		if ($id !== ''){
			$solrQuery='id:'.$id;
		} else {
			$solrQuery='bid:'.$bid;
		}

		$query->setQuery ( $solrQuery);
		$query->setStart ( 0 );
		$query->setRows ( get_option('tecaSolrSearchPage','10') );

		$tecaSolrSearchField = get_option('tecaSolrSchedaField','default_value');

		$fields = explode ( ",", $tecaSolrSearchField );
		foreach ( $fields as &$field ) {
			$query->addField ($field);
		}

		$query->addParam ( 'wt', 'xml' );

		#echo("SolrQ: ".$query->toString()."<br/>");
		$query_response = $client->query ( $query );

		$response = $query_response->getRawResponse ();
		$resp = $query_response->getResponse ();
		if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]==''){
			return "<h1>Scheda non presente</h1>";
		} else {
			if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipologiaFile_show')[0]=='ComplessoArchivistico'){
				checkMolliche("Complesso Archivistico ".$bid);
			} else if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipologiaFile_show')[0]=='SoggettoConservatore'){
				checkMolliche("Soggetto Conservatore ".$bid);
			} else if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipologiaFile_show')[0]=='SoggettoProduttore'){
				checkMolliche("Soggetto Produttore ".$bid);
			} else if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipologiaFile_show')[0]=='SchedaF'){
				checkMolliche("Scheda Fotografica");
			} else if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipologiaFile_show')[0]=='Uc'){
				checkMolliche("Unità cartografica");
			} else if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipologiaFile_show')[0]=='Ud'){
				checkMolliche("Unità documentale");
			} else {
				checkMolliche("Visualizza Scheda");
			}
			if ($this->isSchedaF($resp)){
				$xml = $resp
				->offsetGet ( 'response' )
				->offsetGet ('docs')[0]
				->offsetGet('xmlSchedaF')[0];
				#echo ("SCHEDAF");
				return convertToHtml ( str_replace('<scheda><CD>','<scheda><id>'.$id.'</id><CD>',$xml),
						get_option('tecaSolrSchedaXsl','components/com_tecaricerca/views/show/xsd/solrToScheda.xsl') );
			} else {
				#echo ("NON SCHEDAF");
                                if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('rights_show')[0]){
					$rights = $this->searchShowRights($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('rights_show')[0]);
					if ($rights != ""){
						$response = str_replace('<doc>','<doc><rights>'.$rights.'</rights>',$response);
					}
				}
				if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipoOggetto_show')[0] == 'file' or
						$resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipoOggetto_show')[0] == 'documento' or
						$resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipoOggetto_show')[0] == 'contenitore'){

					$tipoOggetto = $resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipoOggetto_show')[0];
					$mimeTypes = $resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('mimeType_show');
					$mimeType = "";
					if (isset($mimeTypes)){
						$mimeType = $mimeTypes[0];
					}
					$id = $resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('id');
					$root = $resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('_root_');
					if (!isset($root)){
						$root = $resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('padre')[0];
						if (!isset($root)){
					    	$root="";
						}
					}

					$url = $this->checkShowObject($tipoOggetto, $mimeType, $id, $client, $root);

					if ($url != ""){
						$response = str_replace('<doc>','<doc><urlObj>'.$url.'</urlObj>',$response);
					}
					$numberView = 0;
					try {
						$numberView = numberView($id);
					} catch (WsdlExceptionOpac $e){
						$numberView = 0;
					}
					$response = str_replace('<doc>','<doc><numberView>'.$numberView.'</numberView>',$response);
				}
				return convertToHtml ( $response,
						get_option('tecaSolrSchedaXsl','components/com_tecaricerca/views/show/xsd/solrToScheda.xsl') );
			}
		}
	}

	function checkShowObject($tipoOggetto, $mimeType, $id, $client, $root){
		$url="";
		if ($tipoOggetto == 'contenitore'){
			$url=get_option('tecaSolrSchedaURLShowObject','default_value').'?id='.$id;
		} elseif ($tipoOggetto == 'file'){
// 			$mimeTypeShow = get_option('tecaSolrSchedaMimeTypeShow','default_value');

// 			$fields = explode ( ",", $mimeTypeShow);
// 			foreach ( $fields as &$field ) {
// 				if ($url=="" and $mimeType == $field) {
					$url=get_option('tecaSolrSchedaURLShowObject','default_value').'?id='.$id;
// 				}
// 			}
		} elseif ($tipoOggetto == 'documento' && !$root==''){
			$url=get_option('tecaSolrSchedaURLShowObject','default_value').'?id='.$id;
// 			$query = new SolrQuery ();
// 			$solrQuery='id:'.$root;

// 			$query->setQuery ( $solrQuery);
// 			$query->setStart ( 0 );
// 			$query->setRows ( get_option('tecaSolrSearchPage','10') );

// 			$query->addField ("tipoOggetto_show");
// 			$query->addField ("mimeType_show");
// 			$query->addField ("id");
// 			$query->addField ("_root_");
// 			$query->addField ("padre");

// 			$query->addParam ( 'wt', 'xml' );

// 			$query_response = $client->query ( $query );

// 			$resp = $query_response->getResponse ();
// 			if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]==''){
// 				$url="";
// 			} else {
// 				if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipoOggetto_show')[0] == 'file' or
// 						$resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipoOggetto_show')[0] == 'documento'){

// 							$tipoOggetto = $resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('tipoOggetto_show')[0];
// 							$mimeTypes = $resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('mimeType_show');
// 							$mimeType = "";
// 							if (isset($mimeTypes)){
// 								$mimeType = $mimeTypes[0];
// 							}
// 							$id = $resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('id');
// 							$root = $resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('_root_');
// 							if (!isset($root)){
// 								$root = $resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet('padre')[0];
// 								if (!isset($root)){
// 									$root = "";
// 								}
// 							}

// 							$url = $this->checkShowObject($tipoOggetto, $mimeType, $id, $client, $root);
// 				}
// 			}
		}
		return $url;
	}

	/**
	 *
	 * @param unknown $id
	 * @return string
	 */
	function searchShowRights($id) {
		$options = array (
				'hostname' => get_option('tecaSolrServer','default_value'),
				'port' => get_option('tecaSolrPort','default_value')
		);

		$client = new SolrClient ( $options );
		$client->setServlet ( SolrClient::SEARCH_SERVLET_TYPE, get_option('tecaSolrSearchServlet','default_value') );

		$query = new SolrQuery ();
		if ($id !== ''){
			$solrQuery='id:'.$id;

			$query->setQuery ( $solrQuery);
			$query->setStart ( 0 );
			$query->setRows ( 900 );

			$tecaSolrSearchField = get_option('tecaSolrSchedaFigliField','default_value');

			$query->addField ('rightsBasis_show');

			$query->addSortField ( "titolo_sort", SolrQuery::ORDER_ASC );
			$query->addSortField ( "originalFileName_sort", SolrQuery::ORDER_ASC );
			$query->addSortField ( "eventType_sort", SolrQuery::ORDER_ASC );

			$query->addParam ( 'wt', 'xml' );

		#echo("SolrQ: ".$query->toString()."<br/>");
			$query_response = $client->query ( $query );

			$response = $query_response->getRawResponse ();
			$resp = $query_response->getResponse ();


			if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]==''){
				return $id;
			} else {
				if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet ('rightsBasis_show')[0]==''){
					return $id;
				} else {
					return $resp->offsetGet ( 'response' )->offsetGet ('docs')[0]->offsetGet ('rightsBasis_show')[0];
				}
			}

		} else {
			return "";
		}
	}

	/**
	 *
	 * @param unknown $id
	 * @return string
	 */
	function searchShowFigliSolr($id) {
		$options = array (
				'hostname' => get_option('tecaSolrServer','default_value'),
				'port' => get_option('tecaSolrPort','default_value')
		);

		$client = new SolrClient ( $options );
		$client->setServlet ( SolrClient::SEARCH_SERVLET_TYPE, get_option('tecaSolrSearchServlet','default_value') );

		$query = new SolrQuery ();
		if ($id !== ''){
			$solrQuery='_root_:'.$id;
		}

                $solrQuery = $this->addFilterAdvanzed($solrQuery, $xml);

		$tecaSolrSearchExclude = get_option ( 'tecaSolrSearchExclude' );
                if (isset($tecaSolrSearchExclude) && $tecaSolrSearchExclude != ''){
                        $excludes = explode ( "\r", $tecaSolrSearchExclude );
                        foreach ( $excludes as &$exclude ) {
                                $solrQuery .= ' NOT ' . $exclude;
                        }
                }

		$query->setQuery ( $solrQuery);
		$query->setStart ( 0 );
		$query->setRows ( 900 );

		$tecaSolrSearchField = get_option('tecaSolrSchedaFigliField','default_value');

		$fields = explode ( ",", $tecaSolrSearchField );
		foreach ( $fields as &$field ) {
			$query->addField ($field);
		}

		$query->addSortField ( "titolo_sort", SolrQuery::ORDER_ASC );
		$query->addSortField ( "originalFileName_sort", SolrQuery::ORDER_ASC );
		$query->addSortField ( "eventType_sort", SolrQuery::ORDER_ASC );

		$query->addParam ( 'wt', 'xml' );

		#echo("SolrQ: ".$query->toString()."<br/>");
		$query_response = $client->query ( $query );

		$response = $query_response->getRawResponse ();
		$resp = $query_response->getResponse ();
		if ($resp->offsetGet ( 'response' )->offsetGet ('docs')[0]==''){
			return "";
		} else {
			return convertToHtml ( $response,
					get_option('tecaSolrSchedaFigliXsl','components/com_tecaricerca/views/show/xsd/solrToSchedaFigli.xsl') );
		}
	}

	/**
	 *
	 * @param unknown $response
	 */
	private function calcStatoPage($response) {
		$tag_response = $response->offsetGet ( 'response' );
		$this->start = $tag_response->offsetGet ( 'start' ) + 1;
		if (($tag_response->offsetGet ( 'start' ) - $this->recPag) < 0) {
			$this->indietro = - 1;
		} else {
			$this->indietro = ($tag_response->offsetGet ( 'start' ) - $this->recPag);
		}
		$this->end = $tag_response->offsetGet ( 'start' ) + $this->recPag;
		if ($this->end >= $tag_response->offsetGet ( 'numFound' )) {
			$this->avanti = - 1;
		} else {
			$this->avanti = $this->end;
		}
		$this->numFound = $tag_response->offsetGet ( 'numFound' );

		$div = $this->numFound / $this->recPag;
		$pos = strpos ( $div, '.' );
		$div = substr ( $div, 0, $pos );
		$this->fine = ($div * $this->recPag);

		$this->QTime = $response->offsetGet ( 'responseHeader' )->offsetGet ( 'QTime' );
	}

	/**
	 *
	 * @param unknown $response
	 * @return boolean
	 */
	private function isSchedaF($response){
		$tag_response = $response->offsetGet ( 'response' );
		return ($tag_response->offsetGet ('docs')[0]->offsetGet('tipologiaFile_show')[0] =='SchedaF');
	}

	/**
	 *
	 * @return number
	 */
	function getStart(){
		return $this->start;
	}

	/**
	 *
	 * @return number
	 */
	function getIndietro(){
		return $this->indietro;
	}

	/**
	 *
	 * @return number
	 */
	function getEnd(){
		return $this->end;
	}

	/**
	 *
	 * @return number
	 */
	function getAvanti(){
		return $this->avanti;
	}

	/**
	 *
	 * @return number
	 */
	function getNumFound(){
		return $this->numFound;
	}

	/**
	 *
	 * @return number
	 */
	function getFine(){
		return $this->fine;
	}

	/**
	 *
	 * @return number
	 */
	function getQTime(){
		return $this->QTime;
	}

	/**
	 *
	 * @return string|unknown
	 */
	function getRecPag() {
		return $this->recPag;
	}

	/**
	 *
	 * @return string|unknown
	 */
	function getKeyword(){
		return $this->keyword;
	}

	/**
	 *
	 * @return string|mixed
	 */
	function getValueSolr(){
		return $this->valueSolr;
	}

	function getKeySolr(){
		return $this->keySolr;
	}

	function getQStart(){
		return $this->qStart;
	}
}
?>
