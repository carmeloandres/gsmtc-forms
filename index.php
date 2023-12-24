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

if ( ! defined('GSMTC_FORMS_STYLES_DIR')) define ('GSMTC_FORMS_STYLES_DIR', ABSPATH . 'wp-content/gsmtc-forms-styles/');

require_once(dirname(__FILE__).'/includes/class-gsmtc-forms.php');

$base = new Gsmtc_Forms();

/**
 * Function for plugin activation
 */
function gsmtc_forms_activate(){
	$base = new Gsmtc_Forms();
	$base->install_gsmtc_forms();
}
register_activation_hook(__FILE__,'gsmtc_forms_activate'); 

/**
 * Filter function to add new categories to block categories
 */
function gsmtc_forms_add_block_categories($block_categories){
		array_push (
			$block_categories,
			array(
				'slug' => 'gsmtc',
				'title'=> __('Formularios Gesimática','gsmtc-forms'),
				'icon' => null,
			)
			);
		return $block_categories;
}
add_filter('block_categories_all','gsmtc_forms_add_block_categories');



/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_blocks_gsmtc_forms_blocks_init() {

	global $base;

	/**
	 * Register the gsmtc-form block using the block api v2
	 */
	register_block_type( __DIR__.'/gsmtc-button');
	register_block_type( __DIR__.'/gsmtc-checkbox');
	register_block_type( __DIR__.'/gsmtc-date');
	register_block_type( __DIR__.'/gsmtc-email');
	register_block_type( __DIR__.'/gsmtc-fieldset');
	register_block_type( __DIR__.'/gsmtc-form');
	register_block_type( __DIR__.'/gsmtc-label');
	register_block_type( __DIR__.'/gsmtc-submit');
	register_block_type( __DIR__.'/gsmtc-text');
	register_block_type( __DIR__.'/gsmtc-textarea');

}
add_action( 'init', 'create_blocks_gsmtc_forms_blocks_init' );

