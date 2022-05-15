<?php
/**
 * Plugin Name:       Gsmtc Forms
 * Description:       Plugin for the use of static forms,easy and fast use.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gsmtc-forms
 *
 * @package           create-block
 */
if ( ! defined( 'ABSPATH' ) ) {die;} ; // to prevent direct access

if ( ! defined('PLUGIN_DIR')) define ('PLUGIN_DIR',plugin_dir_path(__FILE__));
if ( ! defined('CUSTOM_STYLES_DIR')) define ('CUSTOM_STYLES_DIR', ABSPATH . 'wp-content/gsmtc-custom-styles/');

require_once(dirname(__FILE__).'/includes/class-gsmtc-forms-base.php');

$base = new Gsmtc_Forms_Base;

/**
 * Function for plugin activation
 */
function gsmtc_forms_activate(){
	$base = new Gsmtc_Forms_Base();
	$base->install_gsmtc_forms();
}
register_activation_hook(__FILE__,'gsmtc_forms_activate');   


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
	$simple_contact_assets =  include_once(PLUGIN_DIR.'/simple-contact/build/index.asset.php');

	wp_register_script('simple-contact-block',plugins_url('./simple-contact/build/index.js',__FILE__),$simple_contact_assets['dependencies'],$simple_contact_assets['version']);

	wp_register_script('simple-contact-js',plugins_url('./simple-contact/simple-contact.js',__FILE__),$simple_contact_assets['dependencies'],$simple_contact_assets['version']);

	wp_localize_script ('simple-contact-js','datosAjax',array('rest_url' => rest_url('/gsmtc-forms/simple-contact'),'rest_nonce' => wp_create_nonce('wp_rest')));
	
	wp_register_style('simple-contact',plugins_url('./simple-contact/build/style-index.css',__FILE__),array(),$simple_contact_assets['version']);

	register_block_type( 'gsmtc-forms/simple-contact',array(
		'editor_script' => 'simple-contact-block',
		'script' => 'simple-contact-js',
		'style' => 'simple-contact'
		) 
	);
}
add_action( 'init', 'create_blocks_gsmtc_forms_blocks_init' );

/**
 * Functions for the rest_api
 */
//function events_endpoint() {
//    register_rest_route( 'gsmtc-forms/', 'simple-contact', array(
//  //      'methods'  => 'POST',
  //      'methods'  => WP_REST_Server::EDITABLE,
	//	//        'methods'  => WP_REST_Server::READABLE,
//        'callback' => 'get_events',
//    ) );
//}
//add_action( 'rest_api_init', 'events_endpoint' );
/*
function get_events($request){
	error_log (" Se ha ejecutado la funcion 'get_events'".PHP_EOL.var_export($request,true));

	$resultado = array();

	if (isset($_POST['rest_nonce'])){
		$resultado['rest_nonce'] = $_POST['rest_nonce'];
	}
	if (isset($_POST['name'])){
		$resultado['name'] = $_POST['name'];
	}
	if (isset($_POST['email'])){
		$resultado['email'] = $_POST['email'];
	}
	if (isset($_POST['message'])){
		$resultado['message'] = $_POST['message'];
	}
	$name = $request->get_param('name');
	error_log (" Parametro name : ".PHP_EOL.var_export($name,true));

	$nombre = $request->get_param('nombre');
	error_log (" Parametro email : ".PHP_EOL.var_export($nombre,true));

	echo json_encode($resultado);
	exit();


}
*/

/**
 * Function to create the administrarion menu
 */
function gsmtc_admin_menu()
{
	add_menu_page('Gsmtc Forms','Gesimatica Forms','manage_options','gsmtc_forms','gsmtc_forms_admin');
	add_submenu_page('gsmtc_forms', __('Forms submitted listA','gsmtc'), __('Forms submitted listB','gsmtc'), 'manage_options', 'lista_clientes','gsmtc_forms_submitted' );			
	add_submenu_page('gsmtc_forms', 'clientes archivados', 'Clientes archivados', 'manage_options', 'clientes_archivados','gsmtc_forms_submitted' );			
	add_submenu_page('gsmtc_forms', 'grupos', 'Grupos', 'manage_options', 'grupos','gsmtc_forms_submitted' );			
	add_submenu_page('gsmtc_forms', 'cuestiones', 'Cuestiones', 'manage_options', 'cuestiones','gsmtc_forms_submitted' );			
	add_submenu_page('gsmtc_forms', 'popup', 'Popup', 'manage_options', 'popup','gsmtc_forms_submitted' );			
	remove_submenu_page('gsmtc_forms','gsmtc_forms');
}
add_action('admin_menu','gsmtc_admin_menu');


/**
 * Function to show the list of forms submited
 */
function gsmtc_forms_submitted(){

	global $base;
//	if ( ! is_dir(CUSTOM_STYLES_DIR) ) mkdir(CUSTOM_STYLES_DIR);

//	error_log (" Variable CUSTOM_STYLES_DIR : ".var_export(CUSTOM_STYLES_DIR,true));

	$forms = $base->get_submitted_forms_list(1,20);
?>
		<div class="wrap">

<h1 class="wp-heading-inline">Mensajes entrantes</h1>


<hr class="wp-header-end">


<ul class='subsubsub'>
	<li class='inbox'><a href="https://carmeloandres.com/wp-admin/admin.php?page=flamingo_inbound" class="current">Bandeja de entrada <span class="count">(761)</span></a> |</li>
	<li class='spam'><a href="https://carmeloandres.com/wp-admin/admin.php?page=flamingo_inbound&#038;post_status=spam">Spam <span class="count">(0)</span></a></li>
</ul>
<form method="get" action="">
	<input type="hidden" name="page" value="flamingo_inbound" />
	<input type="hidden" name="post_status" value="" />
	<p class="search-box">
	<label class="screen-reader-text" for="flamingo-inbound-search-input">Buscar mensajes:</label>
	<input type="search" id="flamingo-inbound-search-input" name="s" value="" />
		<input type="submit" id="search-submit" class="button" value="Buscar mensajes"  /></p>
			<input type="hidden" id="_wpnonce" name="_wpnonce" value="679e0a8319" /><input type="hidden" name="_wp_http_referer" value="/wp-admin/admin.php?page=flamingo_inbound" />	<div class="tablenav top">

				<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">Selecciona acción en lote</label><select name="action" id="bulk-action-selector-top">
<option value="-1">Acciones en lote</option>
	<option value="trash">Mover a la papelera</option>
	<option value="spam">Marcar como spam</option>
</select>
<input type="submit" id="doaction" class="button action" value="Aplicar"  />
		</div>
			<div class="alignleft actions">
		<label for="filter-by-date" class="screen-reader-text">Filtrar por fecha</label>
		<select name="m" id="filter-by-date">
			<option selected='selected' value="0">Todas las fechas</option>
		<option  value='202203'>marzo 2022</option>
<option  value='202202'>febrero 2022</option>
<option  value='202201'>enero 2022</option>
<option  value='202112'>diciembre 2021</option>
<option  value='202111'>noviembre 2021</option>
<option  value='202110'>octubre 2021</option>
<option  value='202109'>septiembre 2021</option>
<option  value='202108'>agosto 2021</option>
<option  value='202107'>julio 2021</option>
<option  value='202106'>junio 2021</option>
<option  value='202105'>mayo 2021</option>
<option  value='202104'>abril 2021</option>
<option  value='202103'>marzo 2021</option>
<option  value='202102'>febrero 2021</option>
<option  value='202101'>enero 2021</option>
<option  value='202012'>diciembre 2020</option>
<option  value='202011'>noviembre 2020</option>
<option  value='202010'>octubre 2020</option>
<option  value='202009'>septiembre 2020</option>
<option  value='202008'>agosto 2020</option>
<option  value='202007'>julio 2020</option>
<option  value='202006'>junio 2020</option>
<option  value='202005'>mayo 2020</option>
<option  value='202004'>abril 2020</option>
<option  value='202003'>marzo 2020</option>
		</select>
		<select  name='channel_id' id='channel_id' class='postform' >
	<option value='0' selected='selected'>Ver todos los canales</option>
	<option class="level-0" value="3">Contact Form 7</option>
	<option class="level-1" value="4">&nbsp;&nbsp;&nbsp;contacto principal</option>
	<option class="level-1" value="9">&nbsp;&nbsp;&nbsp;Formulario de contacto 1</option>
</select>
<input type="submit" id="post-query-submit" class="button" value="Filtro"  /><input type="submit" name="export" id="export" class="button" value="Exportar"  /></div>
<div class='tablenav-pages'><span class="displaying-num">761 elementos</span>
<span class='pagination-links'><span class="tablenav-pages-navspan button disabled" aria-hidden="true">&laquo;</span>
<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&lsaquo;</span>
<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Página actual</label><input class='current-page' id='current-page-selector' type='text' name='paged' value='1' size='2' aria-describedby='table-paging' /><span class='tablenav-paging-text'> de <span class='total-pages'>39</span></span></span>
<a class='next-page button' href='https://carmeloandres.com/wp-admin/admin.php?page=flamingo_inbound&#038;paged=2'><span class='screen-reader-text'>Página siguiente</span><span aria-hidden='true'>&rsaquo;</span></a>
<a class='last-page button' href='https://carmeloandres.com/wp-admin/admin.php?page=flamingo_inbound&#038;paged=39'><span class='screen-reader-text'>Última página</span><span aria-hidden='true'>&raquo;</span></a></span></div>
		<br class="clear" />
	</div>
<?php
	foreach($forms as $form){
	?>
	<div>
		<div><?php echo ' id '.$form['id'].' '.__('form class','gsmtc').' '.$form['nameform'].' '.__('submitted on','gsmtc').' '.$form['date']; ?></div>	
	</div>
	<?php
	}
}