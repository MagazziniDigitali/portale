<?php
include_once (MD_PLUGIN_PATH . 'tools/solr/MDSolrFacetPivot.php');

/**
 * Classe utilizzata pe la gestione dei metodo per la gestione dei risultati Facet Standard
 * 
 * @author massi
 *
 */
class MDSolrFacetFields extends MDSolrFacetPivot {

	/**
	 * Costruttore
	 */
	function __construct() {
		parent::__construct();
	}

	function scanFacetFields() {
		foreach ( $keys as $i => $value ) {
			if ($this->startsWith ( $value, 'tipologiaFile_fc' )) {
				$titolo = 'Tipologia Materiale';
			} else if ($this->startsWith ( $value, 'soggettoConservatore_fc' )) {
				$titolo = 'Soggetto Conservatore';
			} else if ($this->startsWith ( $value, 'fondo_fc' )) {
				$titolo = 'Fondo';
			} else if ($this->startsWith ( $value, 'subFondo_fc' )) {
				$titolo = 'Sub Fondo';
			} else {
				$titolo = $value;
			}
			$this->facet .= '<tr class=\'title\'><td>' . $titolo . '</td></tr>';
			$keys2 = $facet_fields->offsetGet ( $value )->getPropertyNames ();
			foreach ( $keys2 as $i2 => $value2 ) {
				$valore = str_replace ( "_", " ", $value2 );
				if ($this->startsWith ( $value, 'tipologiaFile_fc' )) {
					if ($this->startsWith ( $valore, 'Uc' )) {
						$valore = 'Unit&agrave; Cartografiche';
					} else if ($this->startsWith ( $valore, 'Ud' )) {
						$valore = 'Unit&agrave; Documentali';
					} else if ($this->startsWith ( $valore, 'SchedaF' )) {
						$valore = 'Schede Fotografiche';
					} else if ($this->startsWith ( $valore, 'SoggettoConservatore' )) {
						$valore = 'Soggetti Conservatori';
					} else if ($this->startsWith ( $valore, 'ComplessoArchivistico' )) {
						$valore = 'Complessi Archivistici';
					}
				}
				if ($this->startsWith ( $value, 'soggettoConservatore_fc' )) {
					if ($this->startsWith ( $valore, 'non identificabile' )) {
						$valore = 'Archivio Adda';
					}
				}
				$cbName = substr ( str_replace ( '_fc', '', $value ), 0, - 1 );
				$cbValue = substr ( str_replace ( '"', '', $value2 ), 0, - 1 );
				$this->facet .= '<tr class=\'value\'><td>' . '<input type="checkbox" name="' . $cbName . '" value="' . $cbValue . '" onchange="cerca(0);"';
				$pos = strrpos ( str_replace ( 'non identificabile', 'non_identificabile', $this->facetQuery ), "+" . $cbName . ':"' . $cbValue . '"' );
				if ($pos === FALSE) {
					$this->facet .= '';
				} else {
					$this->facet .= ' checked';
				}
				
				$this->facet .= '/>&nbsp;' . $facet_fields->offsetGet ( $value )->offsetGet ( $value2 ) . '&nbsp;:&nbsp;' . $valore . '</td></tr>';
			}
		}
	}
}
?>
