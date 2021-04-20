<?php
/*
Plugin Name: Magazzini Digitali - Opac
Version: 2.0.7
Description: Interfaccia Opac per Magazzini Digitali
Author: Massimiliano Randazzo
Author URI: http://www.depositolegale.it
*/
define( 'MD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
include(MD_PLUGIN_PATH.'search/search.php');
include(MD_PLUGIN_PATH.'admin/admin.php');

add_shortcode( 'sitepoint_contact_form', 'cf_shortcode' );

add_action('admin_menu', 'md_plugin_setup_menu');

function change_zeedynamic_footer_menu() {
  echo '<fieldset class="urlIstituto" style="">';
  //echo '<legend>';
  echo '<a href="http://www.librari.beniculturali.it/opencms/opencms/it/"><img class="urlIstituto" title="mibac" src="'.MD_PLUGIN_URL.'images/logo_dgbid.jpg" alt="mibac" width="170" height="59"></a>';
  echo '&nbsp;';
  echo '<a href="http://www.bncf.firenze.sbn.it"><img class="urlIstituto" title="bncf" src="'.MD_PLUGIN_URL.'images/logo-bncf.jpg" alt="bncf" width="121" height="59"></a>';
  echo '&nbsp;';
  echo '<a href="http://www.bncrm.librari.beniculturali.it/"><img class="urlIstituto" title="bncr" src="'.MD_PLUGIN_URL.'images/bncr.jpg" alt="bncr" width="88" height="59"></a>';
  echo '&nbsp;';
  echo '<a href="http://marciana.venezia.sbn.it/"><img class="urlIstituto" title="marciana" src="'.MD_PLUGIN_URL.'images/marciana.gif" alt="marciana" width="63" height="59"></a>';
  //echo '</legend>';
  echo '</fieldset>';
} 

add_filter('zeedynamic_footer_menu', 'change_zeedynamic_footer_menu'); 

?>
