<?php
function convertToHtml($xml, $fileXsl) {
	$xslDoc = new DOMDocument ();
	$xslDoc->load ( $fileXsl );

	$xmlDoc = new DOMDocument ();
	$xmlDoc->loadXML ( $xml );

	$proc = new XSLTProcessor ();
	$proc->importStylesheet ( $xslDoc );
	return $proc->transformToXML ( $xmlDoc );
}
?>