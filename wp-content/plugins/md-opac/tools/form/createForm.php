<?php
class CreateForm {
	
	/**
	 */
	function __construct() {
	}
	
	/**
	 *
	 * @param unknown $options        	
	 */
	function create_form($options) {
		$this->save($options);
		?>
<form id='options_form' method='post' name='form'>
<table class="mdAdmin">
<?php
	foreach ( $options as $value ) {
		$this->checkOption($value);
	}
		?> 
		<tr>
		  <th class="save" colspan="2">
	<input name="save" type="button" value="Save" class="button"
		onclick="submit_form(this, document.forms['form'])" /> <input
		type="hidden" name="formaction" value="default" />
		</th>
		</tr>
  </table>

	<script> function submit_form(element, form){ 
	  form['formaction'].value = element.name;
	  form.submit();
	} </script>
</form>
<?php
	}

	/**
	 * Metodo utilizzato per analizzare le diverse voci di ooption individuate
	 */
	function checkOption($value){
		switch ($value ['type']) {
			case "text" :
				$this->create_section_for_text ( $value );
				break;
			case "textarea" :
				$this->create_section_for_textarea ( $value );
				break;
			case "multi-select" :
				$this->create_section_for_multi_select ( $value );
				break;
			case "radio" :
				$this->create_section_for_radio ( $value );
				break;
			case "select" :
				$this->create_section_for_category_select ( 'first section', $value );
				break;
		}
	}
	
	/**
	 *
	 * @param unknown $value        	
	 */
	function create_section_for_text($value) {
		$this->create_opening_tag ( $value );
		$text = "";
		if (get_option ( $value ['id'] ) === FALSE) {
			$text = $value ['std'];
		} else {
			$text = get_option ( $value ['id'] );
		}
		
		echo '<input type="text" ';
		if (isset($value ['size'])){
			echo 'size="'.$value ['size'].'" ';
		}
		if (isset($value ['desc'])){
		  echo 'alt="'.$value ['desc'].'"  title="'.$value ['desc'].'" ';
		}
		echo 'id="' . $value ['id'] . '" ';
		if (isset($value ['msg'])){
		  echo 'placeholder="'.$value ['msg'].'" ';
		}
		echo 'name="' . $value ['id'] . '" value="' . $text . '" />' . "\n";
		$this->create_closing_tag ( $value );
	}
	
	/**
	 *
	 * @param unknown $value        	
	 */
	function create_section_for_textarea($value) {
		$this->create_opening_tag ( $value );
		echo '<textarea name="' . $value ['id'] . '" type="textarea" ';
		if(isset($value ['cols'])){
		  echo 'cols="'.$value ['cols'].'" ';
		} else {
			echo 'cols="100" ';
		}
		if (isset($value ['rows'])){
		  echo 'rows="'.$value ['rows'].'"';
		} else {
			echo 'rows="10"';
		}
		echo '>' . "\n";
		if (get_option ( $value ['id'] ) != "") {
			echo get_option ( $value ['id'] );
		} else {
			echo $value ['std'];
		}
		echo '</textarea>';
		$this->create_closing_tag ( $value );
	}
	
	/**
	 *
	 * @param unknown $value        	
	 */
	function create_section_for_multi_select_old($value) {
		$this->create_opening_tag ( $value );
		echo '<ul  class="mnt-checklist" id="' . $value ['id'] . '" >' . "\n";
		foreach ( $value ['options'] as $option_value => $option_list ) {
			$checked = " ";
			if (get_option ( $value ['id'] . "_" . $option_value )) {
				$checked = " checked='checked' ";
			}
			echo "<li>\n";
			echo '<input type="checkbox" name="' . $value ['id'] . "_" . $option_value . '" value="true" ' . $checked . ' class="depth-' . ($option_list ['depth'] + 1) . '" />' . $option_list ['title'] . "\n";
			echo "</li>\n";
		}
		echo "</ul>\n";
		$this->create_closing_tag ( $value );
	}

	function create_section_for_multi_select($value) {
		$this->create_opening_tag ( $value );
		echo "<select multiple='multiple' id='" . $value ['id'] . "' ";
		if (isset($value ['desc'])){
			echo 'alt="'.$value ['desc'].'"  title="'.$value ['desc'].'" ';
		}
		echo "class='post_form' name='" . $value ['id'] . "[]' >\n";
		$valori = array();
		if (!get_option ( $value ['id'] )===FALSE){
			$valori = explode(",", get_option ( $value ['id'] ));
		}
		foreach ( $value ['options'] as $option_value => $option_list ) {

			echo '<option value="' . $option_value . '" ';
			echo 'class="level-0" ';
		
			$xvalore = array_search($option_value, $valori);
			if (is_numeric($xvalore)){
				echo ' selected="selected" ';
			} else if ($valori === FALSE && $value ['std'] == $option_value) {
				echo ' selected="selected" ';
			}
			if (isset($option_list ['number'])){
				echo ' number="' . ($option_list ['number']) . '" />';
			}
			echo $option_list ['name'];
			echo "</option>\n";
		}
		echo "</select>\n";
		$this->create_closing_tag ( $value );
	}
	
	/**
	 *
	 * @param unknown $value        	
	 */
	function create_section_for_radio($value) {
		$this->create_opening_tag ( $value );
		foreach ( $value ['options'] as $option_value => $option_text ) {
			$checked = ' ';
			if (get_option ( $value ['id'] ) == $option_value) {
				$checked = ' checked="checked" ';
			} else if (get_option ( $value ['id'] ) === FALSE && $value ['std'] == $option_value) {
				$checked = ' checked="checked" ';
			} else {
				$checked = ' ';
			}
			echo '<div class="mnt-radio"><input type="radio" name="' . $value ['id'] . '" value="' . $option_value . '" ' . $checked . "/>" . $option_text . "</div>\n";
		}
		$this->create_closing_tag ( $value );
	}
	
	/**
	 *
	 * @param unknown $page_section        	
	 * @param unknown $value        	
	 */
	function create_section_for_category_select($page_section, $value) {
		$this->create_opening_tag ( $value );
		$all_categoris = '';
//		echo '<div class="wrap" id="' . $value ['id'] . '" >' . "\n";
//		echo '<h1>Theme Options</h1> ' . "\n" . '
//				<p><strong>' . $page_section . ':</strong></p>';
		echo "<select id='" . $value ['id'] . "' ";
		if (isset($value ['desc'])){
			echo 'alt="'.$value ['desc'].'"  title="'.$value ['desc'].'" ';
		}
		echo "class='post_form' name='" . $value ['id'] . "' value='true'>\n";
		echo "<option id='all' value=''>Seleziona ....</option>";
		foreach ( $value ['options'] as $option_value => $option_list ) {
//			echo 'value_id=' . $value ['id'] . ' value_id=' . get_option ( $value ['id'] ) . ' options_value=' . $option_value;
			echo '<option value="' . $option_value . '" ';
			echo 'class="level-0" ';

			if (get_option ( $value ['id'] ) == $option_value) {
				echo ' selected="selected" ';
			} else if (get_option ( $value ['id'] ) === FALSE && $value ['std'] == $option_value) {
				echo ' selected="selected" ';
			}
			echo ' number="' . ($option_list ['number']) . '" />'; 
			echo $option_list ['name'] . "</option>\n";
			// $all_categoris .= $option_list['name'] . ',';
		}
		echo "</select>\n ";
//		echo "</div>";
		// echo '<script>jQuery("#all").val("'.$all_categoris.'")</\script>';
		$this->create_closing_tag ( $value );
	}

	/**
	 *
	 * @param unknown $value        	
	 */
	function create_opening_tag($value) {
		$group_class = "";
		echo '<tr><th class="md-Row">';
// 		if (isset ( $value ['grouping'] )) {
// 			$group_class = "suf-grouping-rhs";
// 		}
// 		echo '<div class="suf-section fix">' . "\n";
// 		if ($group_class != "") {
// 			echo "<div class='$group_class fix'>\n";
// 		}
		if (isset ( $value ['name'] )) {
			echo "<h3>" . $value ['name'] . "</h3>\n";
		}
//		if (isset ( $value ['desc'] ) && ! (isset ( $value ['type'] ) && $value ['type'] == 'checkbox')) {
//			echo $value ['desc'] . "<br />";
//		}
		if (isset ( $value ['note'] )) {
			echo "<span class=\"note\">" . $value ['note'] . "</span><br />";
		}
		echo '</th><td class="md-Row">';
	}
	
	/**
	 * Creates the closing markup for each option.
	 *
	 * @param
	 *        	$value
	 * @return void
	 */
	function create_closing_tag($value) {
// 		if (isset ( $value ['grouping'] )) {
// 			echo "</div>\n";
// 		}
		// echo "</div><!-- suf-section -->\n";
		echo "</td></tr>\n";
	}
	
	/**
	 */
	function save($options) {
		if (isset($_REQUEST ['formaction']) && 
				'save' == $_REQUEST ['formaction']) {
			echo '<div id="message" class="updated fade"><p><strong>Le informazioni sono state salvate</strong></p></div>';
			foreach ( $options as $value ) {
				if (isset ( $_REQUEST [$value ['id']] )) {
					if (is_array($_REQUEST [$value ['id']])){
						$valore='';
						foreach ($_REQUEST [$value ['id']] as $selezionato){
							if ($valore==''){
								$valore = $selezionato;
							} else {
								$valore = $valore.','.$selezionato;
							}
						}
						update_option ( $value ['id'], $valore );
					} else {
						update_option ( $value ['id'], $_REQUEST [$value ['id']] );
					}
					} else {
					delete_option ( $value ['id'] );
				}
			}
			
// 			foreach ( $spawned_options as $value ) {
// 				if (isset ( $_REQUEST [$value ['id']] )) {
// 					update_option ( $value ['id'], $_REQUEST [$value ['id']] );
// 				} else {
// 					delete_option ( $value ['id'] );
// 				}
// 			}
// 			header ( "Location: themes.php?page=options.php&saved=true" );
// 			die ();
		}
	}

	function genArrayMultiSelect($values){
		return $this->genArraySelect($values);
// 		$ret = array ();
// 		foreach ( $values as $id => $desc ) {
// 			$ret [$id] = array (
// 					"title" => $desc,
// 					"depth" => 1 );
// 		}
// 		return $ret;
	}

	function genArraySelect($values){
		$ret = array ();
		foreach ( $values as $id => $desc ) {
			$ret [$id] = array (
					"name" => $desc,
					"number" => 1 );
		}
		return $ret;
	}
	}
?>
