<?php

/**
 * Metodo utilizzato per la gestione delle molliche di pane
 * 
 * @param unknown $titolo
 * @param unknown $router
 */
function checkMolliche($titolo){
	
}
function checkMolliche_old($titolo){

//	$pathway =& getPathway();
//	$pathway->addItem( 'texto', 'index.php');

	// Get input cookie object

	echo 'keyword: '.$_REQUEST['keyword'].'<br/>';
	if (isset($_REQUEST['keyword'])  || isset($_REQUEST['view'])){
			
		// TODO: Testare se è stato utilizzato un link

		if(!isset($_COOKIE['MDtecaSearchMolliche'])) {
			$values = array();
		} else {
			$values = json_decode($_COOKIE['MDtecaSearchMolliche']);
		}

		$pathway = getPathway();
		//append item on the end of the pathway - first argument for the name, the second (optional) for a link

		if (isset($_REQUEST ['pw'])) {
			$conta = $_REQUEST ['pw'];
			$conta = $conta+1;
		} else {
			$conta= -1;
			for ($i=0; $i < count($values); $i++){
				$value = $values[$i];
				$url = $value[1];
				$pos = strrpos($url, '&pw=');
				if ($pos!==false){
					$url = substr($url, 0, $pos);
				}
				if ($url==JURI::current().'?'.$u->getQuery()){
					if ($conta==-1){
						$conta=$i+1;
					}
				}
			}
			if ($conta==-1){
				$pwValue = JURI::current().'?'.$u->getQuery().'&pw='.count($values);

				array_push($values, array($titolo, $pwValue));

				$conta = count($values);
			}
		}

		$values2 = array();
		for ($i = 0; $i < $conta; $i++) {
			$value = $values[$i];
			array_push($values2, $value);
			// 		}
			// 		foreach ($values as $value) {
			$pathway->addItem($value[0], $value[1]);
			//			$value = $value * 2;
		}

		//		echo "value: ";
		//		var_dump($values);
		//		echo "<br/>";

		// Set cookie data
		setcookie( 'tecaSearchMolliche', json_encode($values2), 0, COOKIEPATH, COOKIE_DOMAIN );
		
	} else {
		// TODO: rimuovere il Cookie
		if (isset($_COOKIE['MDtecaSearchMolliche'])){
			unset( $_COOKIE['MDtecaSearchMolliche'] );
			setcookie( 'MDtecaSearchMolliche', '', time() - ( 15 * 60 ) );
		}
	}

}
?>