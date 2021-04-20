<?php
include_once (MD_PLUGIN_PATH . 'tools/solr/MDSolrFacetPivot.php');

/**
 * Classe utilizzata pe la gestione dei metodo per la gestione dei risultati Facet
 *
 * @author massi
 *
 */
class MDSolrFacet extends MDSolrFacetPivot {

	private $facet = '';

	function __construct(){
		parent::__construct();
	}

	/**
	 * 
	 * @param unknown $response
	 */
	protected function disFacetMenu($response, $facetQuery, $baseurl) {
	
		// $facet_fields = $response->offsetGet ( 'facet_counts' )->offsetGet ( 'facet_fields' );
		$facet_fields = $response->offsetGet ( 'facet_counts' )->offsetGet ( 'facet_pivot' );
		$this->facet = '<table class=\'mdResultFacet\'>';
		$this->facet .= $this->scanFacetPivot( $facet_fields, $facetQuery, $baseurl );
		$this->facet .= '</table>';
	}

	function getFacet(){
		return $this->facet;
	}
}
?>
