<?php
include_once (MD_PLUGIN_PATH . 'tools/solr/MDSolrFacetPivotSast.php');

/**
 *
 * @author massi
 *        
 */
class MDSolrFacetPivotMD extends MDSolrFacetPivotSast {
	
	/**
	 *
	 * @param unknown $lst        	
	 * @param unknown $facetQuery        	
	 * @param unknown $baseurl        	
	 * @param unknown $isSubLevel        	
	 * @param unknown $rientri        	
	 * @return string
	 */
	protected function pivotPrintRowMD($lst, $facetQuery, $baseurl, $isSubLevel, $rientri) {
		$field = $lst->offsetGet ( 'field' );
		$value = str_replace ( "_", " ", $lst->offsetGet ( 'value' ) );
		$facet = '';
		
		$count = $lst->offsetGet ( 'count' );
		
		$cbName = $field;
		
		$cbValue = str_replace ( '"', '\%22', $lst->offsetGet ( 'value' ) );
		$cbValue2 = str_replace ( '"', '\"', $lst->offsetGet ( 'value' ) );
		
		for($x = 1; $x <= $rientri; ++ $x) {
			$facet .= "<p class=\"rientro\">&#9474;</p>";
		}
		
		if ($isSubLevel) {
			$facet .= "<p class=\"plus\">&#9547;</p>";
		} else {
			$facet .= '<input type="checkbox" name="' . $cbName . '" value="' . $cbValue . '" onchange="cerca(0);"';
			$pos = strrpos ( str_replace ( '\"', '"', $facetQuery), "+" . $cbName . ':"' . $cbValue2 . '"' );
			if (! ($pos === FALSE)) {
				$facet .= ' checked';
			}
			$facet .= '/>';
		}
		$facet .= '&nbsp;' . $count . '&nbsp;:&nbsp;' . $value;
		
		return $facet;
	}
}
?>