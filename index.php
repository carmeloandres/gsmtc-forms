<?php
/**
 * Plugin Name:       	Gesimatica Forms
 * Description:       	Plugin for the use of dinamic, flexible, easy and customizing forms using the gutenberg editor.
 * Requires at least: 	5.8
 * Requires PHP:      	7.0
 * Version:           	1
 * License:           	GPL-2.0-or-later
 * License URI:       	https://www.gnu.org/licenses/gpl-2.0.html
 * Author:            	Carmelo Andrés
 * Author URI:			https://carmeloandres.com 
 * Text Domain:       	gsmtc-forms
 * Domain Path:			/languajes
 *
 * @package           	gsmtc-forms
 */

if ( ! defined( 'ABSPATH' ) ) {die;} ; // to prevent direct access

if ( ! defined('GSMTC_FORMS_DIR')) define ('GSMTC_FORMS_DIR',plugin_dir_path(__FILE__));
if ( ! defined('GSMTC_FORMS_URL')) define ('GSMTC_FORMS_URL',plugin_dir_url(__FILE__));

//if ( ! defined('GSMTC_FORMS_STYLES_DIR')) define ('GSMTC_FORMS_STYLES_DIR', ABSPATH . 'wp-content/gsmtc-forms-styles/');

require_once(dirname(__FILE__).'/includes/class-gsmtc-forms.php');
require_once(dirname(__FILE__).'/includes/class-gsmtc-forms-api.php');

$base = new Gsmtc_Forms();
$api = new Gsmtc_Forms_Api();

/**
 * Function for plugin activation
 */
function gsmtc_forms_activate(){
	$api = new Gsmtc_Forms_Api();
	$api->install_gsmtc_forms();
}
register_activation_hook(__FILE__,'gsmtc_forms_activate'); 

// text test

