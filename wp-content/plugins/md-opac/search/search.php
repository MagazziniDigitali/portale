<?php
include_once (MD_PLUGIN_PATH . 'show/show.php');
include 'searchResult.php';

/**
 * 
 */
function md_Search_form() {
	wp_register_style ( 'mdRicerca', plugins_url ( 'md-opac/css/MDRicerca.css' ) );
	wp_enqueue_style ( 'mdRicerca' );
	wp_register_style ( 'md', plugins_url ( 'md-opac/css/md.css' ) );
	wp_enqueue_style ( 'md' );

	wp_register_style ( 'chosen_docsupport_style', plugins_url ( 'md-opac/chosen_v1.7.0/docsupport/style.css' ) );
	wp_enqueue_style ( 'chosen_docsupport_style' );
	wp_register_style ( 'chosen_docsupport_prism', plugins_url ( 'md-opac/chosen_v1.7.0/docsupport/prism.css' ) );
	wp_enqueue_style ( 'chosen_docsupport_prism' );
	wp_register_style ( 'chosen_chosen', plugins_url ( 'md-opac/chosen_v1.7.0/chosen.css' ) );
	wp_enqueue_style ( 'chosen_chosen' );
	
	wp_register_script ( 'gestText-js', plugins_url ( 'md-opac/js/gestText.js' ) );
	wp_enqueue_script ( 'gestText-js' );

	wp_register_script ( 'mdRicerca-js', plugins_url ( 'md-opac/js/MDRicerca.js' ) );
	wp_enqueue_script ( 'mdRicerca-js' );
	wp_register_script ( 'mdRicercaAvanzata-js', plugins_url ( 'md-opac/js/MDRicercaAvanzata.js' ) );
	wp_enqueue_script ( 'mdRicercaAvanzata-js' );

	wp_register_script ( 'chosen_chosen-js', plugins_url ( 'md-opac/chosen_v1.7.0/chosen.jquery.js' ));
	wp_enqueue_script ( 'chosen_chosen-js' );

	wp_register_script ( 'chosen_docsupport_prism-js', plugins_url ( 'md-opac/chosen_v1.7.0/docsupport/prism.js' ));
	wp_enqueue_script ( 'chosen_docsupport_prism-js' );
	wp_register_script ( 'chosen_docsupport_init-js', plugins_url ( 'md-opac/chosen_v1.7.0/docsupport/init.js' ));
	wp_enqueue_script ( 'chosen_docsupport_init-js' );
	
	md_Search_Result ();
}

/**
 * 
 */
function md_View_form() {
	wp_register_style ( 'mdRicerca', plugins_url ( 'md-opac/css/MDRicerca.css' ) );
	wp_enqueue_style ( 'mdRicerca' );
	wp_register_style ( 'md', plugins_url ( 'md-opac/css/md.css' ) );
	wp_enqueue_style ( 'md' );

	wp_register_script ( 'mdRicerca-js', plugins_url ( 'md-opac/js/MDRicerca.js' ) );
	wp_enqueue_script ( 'mdRicerca-js' );

	md_View_Show ();
}


/**
 * 
 * @return string
 */
function cf_shortcode() {
	?>
<div class="breadcrumbs">
    <?php
	
if (function_exists ( 'bcn_display' )) {
		bcn_display ();
	}
	?>
</div>
<?php
	ob_start ();
	if (isset ( $_REQUEST ['view'] )) {
		if ($_REQUEST ['view'] == 'search') {
			md_Search_form ();
		} else if ($_REQUEST ['view'] == 'show') {
			md_View_form ();
		} else {
			md_Search_form ();
		}
	} else {
		md_Search_form ();
	}
	return ob_get_clean ();
}
?>
