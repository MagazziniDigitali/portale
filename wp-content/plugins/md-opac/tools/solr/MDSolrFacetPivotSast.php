<?php
include_once (MD_PLUGIN_PATH . 'admin/adminConfig.php');

/**
 * Classe utilizzata pe la gestione dei metodo per la gestione dei risultati Facet Pivot
 *
 * @author massi
 *
 */
class MDSolrFacetPivotSast {

	/**
	 * 
	 * @param unknown $lst
	 * @param unknown $facetQuery
	 * @param unknown $baseurl
	 * @param unknown $isSubLevel
	 * @param unknown $rientri
	 * @return string
	 */
	protected function pivotPrintRowSast($lst, $facetQuery, $baseurl, $isSubLevel, $rientri) {
		$field = $lst->offsetGet ( 'field' );
		$value = str_replace ( "_", " ", $lst->offsetGet ( 'value' ) );
		$facet = '';
		if ($field == 'subFondoScheda_fc') {
			foreach ( $lst->offsetGet ( 'pivot' ) as $i2 => $pivot ) {
				$facet .= $this->pivotPrintRow ( $pivot, $facetQuery, $baseurl, false, $rientri );
				$facet .= '<br/>';
			}
		} else {
			$count = $lst->offsetGet ( 'count' );
			if (startsWith ( $field, 'tipologiaFile_fc' )) {
				$value = $this->normalizzaTipologiaFile ( $value );
			}
			if (startsWith ( $field, 'soggettoConservatore_fc' )) {
				$value = $this->normalizzaSoggettoConservatore ( $value );
			}
			$cbName = $field;
			$cbValue = str_replace ( '"', '\%22', $lst->offsetGet ( 'value' ) );
			$cbValue2 = str_replace ( '"', '\"', $lst->offsetGet ( 'value' ) );
			
			for($x = 1; $x <= $rientri; ++ $x) {
				$facet .= "<p class=\"rientro\">&#9474;</p>";
			}
			
			if ($isSubLevel) {
				$facet .= "<p class=\"plus\">&#9547;</p>";
			} else {
				$tmp = '';
				if ($cbName == 'soggettoConservatore_fc') {
					$tmp = $this->pivotComposeString ( $lst, 'soggettoConservatoreKey_fc' );
				} else if ($cbName == 'fondo_fc') {
					$tmp = $this->pivotComposeString ( $lst, 'fondoKey_fc' );
				} else if ($cbName == 'subFondo_fc') {
					$tmp = $this->pivotComposeString ( $lst, 'subFondoKey_fc' );
				} else if ($cbName == 'subFondo2_fc') {
					$tmp = $this->pivotComposeString ( $lst, 'subFondo2Key_fc' );
				}
				if ($tmp == '') {
					$facet .= '<input type="checkbox" name="' . $cbName . '" value="' . $cbValue . '" onchange="cerca(0);"';
				} else {
					$facet .= $tmp;
				}
				
				$pos = strrpos ( str_replace ( 'non identificabile', 'non_identificabile', $facetQuery ), "+" . $cbName . ':"' . $cbValue2 . '"' );
				if ($pos === FALSE) {
					if ($lst->offsetExists ( 'pivot' )) {
						foreach ( $lst->offsetGet ( 'pivot' ) as $i2 => $pivot ) {
							$pos = strrpos ( $facetQuery, "+" . $pivot->offsetGet ( 'field' ) . ':"' . $pivot->offsetGet ( 'value' ) . '"' );
							if ($pos !== FALSE) {
								$facet .= ' checked';
							}
						}
					}
				} else {
					$facet .= ' checked';
				}
				
				$facet .= '/>';
			}
			$facet .= '&nbsp;' . $count . '&nbsp;:&nbsp;' . $value;
			
			if ($lst->offsetExists ( 'pivot' )) {
				foreach ( $lst->offsetGet ( 'pivot' ) as $i2 => $pivot ) {
					if ($pivot->offsetGet ( 'field' ) == 'subFondoKey_fc' || $pivot->offsetGet ( 'field' ) == 'subFondo2Key_fc') {
						if ($pivot->offsetExists ( 'pivot' )) {
							foreach ( $pivot->offsetGet ( 'pivot' ) as $i3 => $pivot2 ) {
								if ($pivot2->offsetGet ( 'field' ) == 'subFondoScheda_fc') {
									if ($pivot2->offsetGet ( 'value' ) !== 'No') {
										$title = 'Visualizza Scheda ' . $pivot2->offsetGet ( 'value' );
										$facet .= '&nbsp;';
										$facet .= '<a alt="' . $title . '" title="' . $title . '" onclick="showSchedaByBid(\'' . $pivot2->offsetGet ( 'value' ) . '\');">';
										$facet .= '<img src="' . $baseurl . '/plugins/content/tecadigitale/images/find.ico" class="showScheda" alt="' . $title . '" title="' . $title . '">';
										$facet .= '</a>';
									}
								}
								if ($pivot2->offsetGet ( 'field' ) == 'subFondo2Scheda_fc') {
									if ($pivot2->offsetGet ( 'value' ) !== 'No') {
										$title = 'Visualizza Scheda ' . $pivot->offsetGet ( 'value' );
										$facet .= '&nbsp;';
										$facet .= '<a alt="' . $title . '" title="' . $title . '" onclick="showSchedaByBid(\'' . $pivot2->offsetGet ( 'value' ) . '\');">';
										$facet .= '<img src="' . $baseurl . '/plugins/content/tecadigitale/images/find.ico" class="showScheda" alt="' . $title . '" title="' . $title . '">';
										$facet .= '</a>';
									}
								}
							}
						}
					}
				}
			}
			if ($isSubLevel) {
				$rientri ++;
				foreach ( $lst->offsetGet ( 'pivot' ) as $i2 => $pivot ) {
					foreach ( $pivot->offsetGet ( 'pivot' ) as $i3 => $pivot2 ) {
						$facet .= '<br/>';
						$facet .= $this->pivotPrintRow ( $pivot2, $facetQuery, $baseurl, false, $rientri );
					}
				}
			} else {
				if ($lst->offsetExists ( 'pivot' )) {
					foreach ( $lst->offsetGet ( 'pivot' ) as $i2 => $pivot ) {
						if ($this->pivotIsValid ( $pivot )) {
							$prefix = $this->pivotGetPrefix ( $pivot );
							$title = 'Visualizza Scheda ' . $prefix . $pivot->offsetGet ( 'value' );
							$facet .= '&nbsp;';
							$facet .= '<a alt="' . $title . '" title="' . $title . '" onclick="showSchedaByBid(\'' . $prefix . $pivot->offsetGet ( 'value' ) . '\');">';
							$facet .= '<img src="' . $baseurl . '/plugins/content/tecadigitale/images/find.ico" class="showScheda" alt="' . $title . '" title="' . $title . '">';
							$facet .= '</a>';
						}
					}
				}
			}
		}
		return $facet;
	}

	/**
	 * 
	 * @param unknown $lst
	 * @param unknown $key
	 * @return string
	 */
	private function pivotComposeString($lst, $key) {
		$facet = '';
		
		$field = $lst->offsetGet ( 'field' );
		$value = str_replace ( "_", " ", $lst->offsetGet ( 'value' ) );
		
		if ($field == $key) {
			$facet = '<input type="checkbox" name="' . $field . '" value="' . $value . '" onchange="cerca(0);"';
		} else {
			if ($lst->offsetExists ( 'pivot' )) {
				foreach ( $lst->offsetGet ( 'pivot' ) as $i2 => $pivot ) {
					if ($facet == '') {
						$facet = $this->pivotComposeString ( $pivot, $key );
					}
				}
			}
		}
		return $facet;
	}

	/**
	 * 
	 * @param unknown $pivot
	 * @return string
	 */
	private function pivotGetPrefix($pivot) {
		$valid = '';
		if ($pivot->offsetExists ( 'pivot' )) {
			foreach ( $pivot->offsetGet ( 'pivot' ) as $i => $pivot2 ) {
				if ($pivot2->offsetGet ( 'field' ) == 'soggettoConservatoreKey_fc') {
					$valid = $pivot2->offsetGet ( 'value' ) . '.';
				} else {
					$valid = $this->pivotGetPrefix ( $pivot2 );
				}
			}
		}
		return $valid;
	}

	/**
	 * 
	 * @param unknown $pivot
	 * @return boolean
	 */
	private function pivotIsValid($pivot) {
		$valid = false;
		if ($pivot->offsetExists ( 'pivot' )) {
			foreach ( $pivot->offsetGet ( 'pivot' ) as $i => $pivot2 ) {
				if ($pivot2->offsetGet ( 'field' ) == 'tipologiaFile_fc') {
					// if ($pivot2->offsetGet('value') !== 'SchedaF'){
					if ($this->pivotShowScheda ( $pivot2 )) {
						$valid = true;
					}
					// }
				} else {
					if ($this->pivotIsValid ( $pivot2 )) {
						$valid = true;
					}
				}
			}
		}
		return $valid;
	}

	/**
	 * 
	 * @param unknown $pivot
	 * @return boolean
	 */
	private function pivotShowScheda($pivot) {
		$valid = false;
		if ($pivot->offsetExists ( 'pivot' )) {
			foreach ( $pivot->offsetGet ( 'pivot' ) as $i => $pivot2 ) {
				if ($pivot2->offsetGet ( 'field' ) == 'soggettoConservatoreScheda_fc' || $pivot2->offsetGet ( 'field' ) == 'fondoScheda_fc') {
					if ($pivot2->offsetGet ( 'value' ) == 'Si') {
						$valid = true;
					}
				} else {
					if ($this->pivotShowScheda ( $pivot2 )) {
						$valid = true;
					}
				}
			}
		}
		return $valid;
	}

	/**
	 * 
	 * @param unknown $valore
	 * @return string
	 */
	private function normalizzaTipologiaFile($valore) {
		if (startsWith ( $valore, 'Uc' )) {
			$valore = 'Unit&agrave; Cartografiche';
		} else if (startsWith ( $valore, 'Ud' )) {
			$valore = 'Unit&agrave; Documentali';
		} else if (startsWith ( $valore, 'SchedaF' )) {
			$valore = 'Schede Fotografiche';
		} else if (startsWith ( $valore, 'SoggettoConservatore' )) {
			$valore = 'Soggetti Conservatori';
		} else if (startsWith ( $valore, 'ComplessoArchivistico' )) {
			$valore = 'Complessi Archivistici';
		}
		return $valore;
	}

	/**
	 * 
	 * @param unknown $valore
	 * @return string
	 */
	private function normalizzaSoggettoConservatore($valore) {
		if (startsWith ( $valore, 'non identificabile' )) {
			$valore = 'Archivio Adda';
		}
		return $valore;
	}
}
?>
