<?php

function md_Search_Facet($facet) {

	if($facet != ""){
		echo '<div class="row">';
		echo '<div class="col-md-4">';
		echo '<div class="tecaSearchFacet">';
		echo '<form id="tecaSearchFacet" name="tecaSearchFacet">';
		echo '  <fieldset class="tecaSearchFacet">';
		echo $facet;
		echo '  </fieldset>';
		echo '</form>';
		echo '</div>';
		echo '</div>';
	}
}
?>
