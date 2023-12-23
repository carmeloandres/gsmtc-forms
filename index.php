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
	 * Register simple-contact block
	 */
//	$simple_contact_assets =  include_once(GSMTC_FORMS_DIR.'simple-contact/build/index.asset.php');

///	wp_register_script('simple-contact-block',plugins_url('./simple-contact/build/index.js',__FILE__),$simple_contact_assets['dependencies'],$simple_contact_assets['version']);

//	wp_register_script('simple-contact-js',plugins_url('./simple-contact/simple-contact.js',__FILE__),$simple_contact_assets['dependencies'],$simple_contact_assets['version']);
	
//	wp_register_script('gsmtc-forms-form-js',plugins_url('./gsmtc-form/gsmtc-forms-form.js',__FILE__));


//	wp_localize_script ('simple-contact-js','datosAjax',array('rest_url' => rest_url('/gsmtc-forms/simple-contact'),'rest_nonce' => wp_create_nonce('wp_rest')));
	
//	wp_register_style('simple-contact',plugins_url('./simple-contact/build/style-index.css',__FILE__),array(),$simple_contact_assets['version']);

//	register_block_type( 'gsmtc-forms/simple-contact',array(
//		'editor_script' => 'simple-contact-block',
//		'script' => 'simple-contact-js',
//		'style' => 'simple-contact'
//		) 
//	);

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


/******
 * Function gsmtc_forms_callback
 * 
 * Función para crear el callback del formulario
 */
function gsmtc_forms_callback(){

		error_log (" Se ha ejecutado la funcion 'gsmtc_forms_callback' ".PHP_EOL);

		$bloque =stripslashes( '<!-- wp:gsmtc-forms/gsmtc-form {\\"id\\":\\"1703178964\\"} -->
		<form class=\\"wp-block-gsmtc-forms-gsmtc-form\\" id=\\"1703178964\\"><!-- wp:group {\\"layout\\":{\\"type\\":\\"flex\\",\\"orientation\\":\\"vertical\\",\\"justifyContent\\":\\"center\\"}} -->
		<div class=\\"wp-block-group\\"><!-- wp:heading -->
		<h2 class=\\"wp-block-heading\\">Form title</h2>
		<!-- /wp:heading --></div>
		<!-- /wp:group -->
		
		<!-- wp:group {\\"layout\\":{\\"type\\":\\"flex\\",\\"flexWrap\\":\\"nowrap\\",\\"justifyContent\\":\\"center\\"}} -->
		<div class=\\"wp-block-group\\"><!-- wp:gsmtc-forms/gsmtc-label {\\"forInput\\":\\"name\\",\\"content\\":\\"Nombre\\"} -->
		<label for=\\"name\\" class=\\"wp-block-gsmtc-forms-gsmtc-label\\">Nombre</label>
		<!-- /wp:gsmtc-forms/gsmtc-label -->
		
		<!-- wp:gsmtc-forms/gsmtc-text {\\"name\\":\\"name\\"} -->
		<input type=\\"text\\" class=\\"wp-block-gsmtc-forms-gsmtc-text\\" name=\\"name\\"/>
		<!-- /wp:gsmtc-forms/gsmtc-text --></div>
		<!-- /wp:group --></form>
		<!-- /wp:gsmtc-forms/gsmtc-form -->');
	
	//return $bloque;
	return '';
}

