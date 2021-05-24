<?php
include_once (MD_PLUGIN_PATH . 'admin/adminConfig.php');
include_once (MD_PLUGIN_PATH . 'tools/solr/MDSolrFacetPivotMD.php');

/**
 * Classe utilizzata pe la gestione dei metodo per la gestione dei risultati Facet Pivot
 *
 * @author massi
 *
 */
class MDSolrFacetPivot extends MDSolrFacetPivotMD {

	protected $tecaSolrTipoDB= '';

	function __construct(){
		$this->tecaSolrTipoDB = get_option ( 'tecaSolrTipoDB' );
		if (!isset ( $this->tecaSolrTipoDB )) {
			$this->tecaSolrTipoDB='';
		}
	}

	/**
	 * 
	 * @param unknown $facet_fields
	 * @param unknown $facetQuery
	 * @param unknown $baseurl
	 * @return string
	 */
	function scanFacetPivot($facet_fields, $facetQuery, $baseurl) {
		$keys = $facet_fields->getPropertyNames ();
		$facet = '';
		
		// Analizzo i dati presenti nel nodo arr
		foreach ( $keys as $i => $value ) {
			$titolo = $this->convertTitleFacet ( $value );
			$contenuto = $this->scanFacetPivotLst ( $facet_fields->offsetGet ( $value ), $facetQuery, $baseurl );
			if ($contenuto !== '') {
				$facet .= '<tr class=\'title primary-navigation\'><td>' . $titolo . '</td></tr>' . $contenuto;
			}
		}
		return $facet;
	}

	/**
	 * 
	 * @param unknown $lsts
	 * @param unknown $facetQuery
	 * @param unknown $baseurl
	 * @return string
	 */
	private function scanFacetPivotLst($lsts, $facetQuery, $baseurl) {
		$facet = '';
		$isSubLevel = false;
		foreach ( $lsts as $i => $lst ) {
			
			if ($lst->offsetExists ( 'pivot' )) {
				foreach ( $lst->offsetGet ( 'pivot' ) as $i2 => $pivot ) {
					if ($this->pivotIsSubLevel ( $pivot )) {
						$isSubLevel = true;
					}
				}
			}
			$facet .= '<tr class=\'value\'><td>';
			$facet .= $this->pivotPrintRow ( $lst, $facetQuery, $baseurl, $isSubLevel, 0 );
			$facet .= '</td></tr>';
			$isSubLevel = false;
		}
		return $facet;
	}

	/**
	 * 
	 * @param unknown $lst
	 * @param unknown $facetQuery
	 * @param unknown $baseurl
	 * @param unknown $isSubLevel
	 * @param unknown $rientri
	 * @return string
	 */
	private function pivotPrintRow($lst, $facetQuery, $baseurl, $isSubLevel, $rientri) {
		if ($this->tecaSolrTipoDB == 'magazziniDigitali') {
			return $this->pivotPrintRowMD($lst, $facetQuery, $baseurl, $isSubLevel, $rientri);
		} else if ($this->tecaSolrTipoDB == 'sast') {
			return $this->pivotPrintRowSast($lst, $facetQuery, $baseurl, $isSubLevel, $rientri);
		}
	}

	/**
	 * 
	 * @param unknown $pivot
	 * @return boolean
	 */
	private function pivotIsSubLevel($pivot) {
		$valid = false;
		if ($pivot->offsetGet ( 'field' ) == 'subFondo2_fc') {
			$valid = true;
		} else {
			if ($pivot->offsetExists ( 'pivot' )) {
				foreach ( $pivot->offsetGet ( 'pivot' ) as $i => $pivot2 ) {
					if ($pivot2->offsetGet ( 'field' ) == 'subFondo2_fc') {
						$valid = true;
					} else {
						if ($this->pivotIsSubLevel ( $pivot2 )) {
							$valid = true;
						}
					}
				}
			}
		}
		return $valid;
	}

	/**
	 * 
	 * @param unknown $value
	 * @return string|unknown
	 */
	private function convertTitleFacet($value) {
		$adminConfig = new adminConfig();
		
		$tecaSolrTipoDB = get_option ( 'tecaSolrTipoDB' );
		if ($tecaSolrTipoDB == 'magazziniDigitali') {
			$tecaSolr= $adminConfig->tecaSolrSearchFacetPivotMD ();
		} else if ($tecaSolrTipoDB == 'sast') {
			$tecaSolr = $adminConfig->tecaSolrSearchFacetPivotSast();
		}
		if (isset($tecaSolr)){
			$titolo = $tecaSolr[$value];
		} else {
			$titolo = $value;
		}
// 		if (startsWith ( $value, 'tipologiaFile_fc' )) {
// 			$titolo = 'Tipologia Materiale';
// 		} else if (startsWith ( $value, 'soggettoConservatore_fc' )) {
// 			$titolo = 'Soggetto Conservatore';
// 		} else if (startsWith ( $value, 'fondo_fc' )) {
// 			$titolo = 'Fondo';
// 		} else if (startsWith ( $value, 'subFondo_fc' )) {
// 			$titolo = 'Sotto Livello';
// 		} else if (startsWith ( $value, 'subFondo2_fc' )) {
// 			$titolo = 'Sotto Livello';
// 		} else {
// 			$titolo = $value;
// 		}
		return $titolo;
	}
}
?>
