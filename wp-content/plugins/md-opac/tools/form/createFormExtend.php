<?php
include 'createForm.php';

class CreateFormExtend extends CreateForm{
	
	function checkOption($value){
		parent::checkOption($value);
		switch ($value ['type']) {
			case "sub-section-3" :
				create_suf_header_3 ( $value );
				break;
			case "color-picker" :
				create_section_for_color_picker ( $value );
				break;
			case "select-2" :
				create_section_for_category_select ( 'second section', $value );
				break;
		}
	}

	/**
	 *
	 * @param unknown $value
	 */
	function create_suf_header_3($value) {
		echo '<h3 class="suf-header-3">' . $value ['name'] . "</h3>\n";
	}

	/**
	 *
	 * @param unknown $value
	 */
	function create_section_for_color_picker($value) {
		create_opening_tag ( $value );
		$color_value = "";
		if (get_option ( $value ['id'] ) === FALSE) {
			$color_value = $value ['std'];
		} else {
			$color_value = get_option ( $value ['id'] );
		}
	
		echo '<div class="color-picker">' . "\n";
		echo '<input type="text" id="' . $value ['id'] . '" name="' . $value ['id'] . '" value="' . $color_value . '" class="color" />';
		echo ' « Click to select color<br/>' . "\n";
		echo "<strong>Default: <font color='" . $value ['std'] . "'> " . $value ['std'] . "</font></strong>";
		echo " (You can copy and paste this into the box above)\n";
		echo "</div>\n";
		create_closing_tag ( $value );
	}
	
}