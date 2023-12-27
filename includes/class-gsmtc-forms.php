<?php
 if ( ! defined( 'ABSPATH' ) ) {die;} ; 

/**
 * Class to manage the database
 */

class Gsmtc_Forms{

    public $plugin_prefix;
    public $table_name_forms;
    public $table_name_data_forms;

    public $nonce_base;
       
    function __construct()
    {
        global $wpdb;

        $this->plugin_prefix = 'gsmtc_';
        $this->table_name_forms = $wpdb->prefix.$this->plugin_prefix.'forms';
        $this->table_name_data_forms = $wpdb->prefix.$this->plugin_prefix.'forms_data';

        $this->nonce_base = NONCE_KEY.date('y-m-d'); // add data to strengthen the nonce

        add_action('init',array($this,'init'));
        add_filter('block_categories_all',array($this,'add_block_categories'));
        add_action( 'plugins_loaded',array($this,'load_textdomain'));
        add_action( 'save_post', array($this,'save_post'),10,3);


        // hooking the response function to ajax requests
        add_action( 'wp_ajax_gsmtc_ajax_request', array($this,'ajax_request') );
        add_action( 'wp_ajax_nopriv_gsmtc_ajax_request', array($this,'ajax_request') );
        add_action( 'rest_api_init', array($this,'endpoints') );
//        add_action( 'edit_post',array($this,'edit_post'),10,2);
//        add_filter( 'wp_insert_post_data',array($this,'wp_insert_post_data'),10,4);

    }

    /**
     * Method init
     * 
     * This method creates the gsmtc-form postype.
     * Registers the gsmtc-forms blocks.
     * Registers the block_pattern category'Gesimatica forms`pattern'
     * Registers the gsmtc-forms as block pattern
     * REgisters the script to manage the submit forms
     */

    function init(){

        // Labels for the custom post type "gsmtc-form"
		$labels_gsmtc_form = array(
			'name'               => _x( 'Gsmtc Forms', 'post type general name', 'gsmtc-forms' ),
			'singular_name'      => _x( 'Gsmtc Form', 'post type singular name', 'gsmtc-forms' ),
			'menu_name'          => _x( 'Gsmtc Formss', 'admin menu', 'gsmtc-forms' ),
			'add_new'            => _x( 'Add new', 'form', 'gsmtc-forms' ),
			'add_new_item'       => __( 'Add new form', 'gsmtc-forms' ),
			'new_item'           => __( 'New form', 'gsmtc-forms' ),
			'edit_item'          => __( 'Edit form', 'gsmtc-forms' ),
			'view_item'          => __( 'View form', 'gsmtc-forms' ),
			'all_items'          => __( 'All forms', 'gsmtc-forms' ),
			'search_items'       => __( 'Search formss', 'gsmtc-forms' ),
			'not_found'          => __( "There aren't  forms.", 'gsmtc-forms' ),
			'not_found_in_trash' => __( "There arent't forms in the trash.", 'gsmtc-forms' ),
            'parent_item_colon'  => ''
		);
                
        // Registers the "gsmtc-form" custom post type

        register_post_type('gsmtc-form',
            array(
                'labels'			=> $labels_gsmtc_form,
                'description' 		=> 'Custom post type used to store data from gsmtc-forms',
                'show_ui'           => true, 
                'show_in_rest'      => false,
                'capability_type'    => 'post',
                'menu_position'      => null,
                'supports'           => array( 'title','editor','custom-fields'),
                )			
		);
        
        // Register the gsmtc-forms blocks using the block api v2
       
        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-checkbox');
        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-date');
        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-email');
        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-fieldset');
        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-form');
        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-label');
        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-radio');
        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-submit');
        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-text');
        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-textarea');
    
        // Register the "Gesimatica forms" block pattern category
        register_block_pattern_category(
            'gsmtc-forms', // Unique identifier for your category
            array(
                'label' => esc_html__('Gesimatica forms', 'gsmtc-forms'), // Category label
            )
        );

        // Unregister all gesimatica forms pattern blocks
        $get_patterns  = WP_Block_Patterns_Registry::get_instance()->get_all_registered();

        foreach($get_patterns as $pattern){
            if (isset($pattern['categories'])  && in_array('gsmtc-forms',$pattern['categories'])){
//                error_log ('Se ha ejecutado la funcion "init", $form :'.var_export($form,true).PHP_EOL);
//                    $keys = array_keys($pattern);
//                    error_log ('Se ha ejecutado la funcion "init", $keys :'.var_export($keys,true).PHP_EOL);
//                    error_log ('Se ha ejecutado la funcion "init", $pattenr[keys[2]] :'.var_export($pattern[$keys[2]],true).PHP_EOL);
//                error_log ('Se ha ejecutado la funcion "init", $pattern :'.var_export($pattern,true).PHP_EOL);
     //   unregister_block_pattern( $pattern['name']);
            }
        }

        
        // Register_all gesimatica forms pattern blocks, to update
        $gsmtc_forms = $this->get_all_gsmtc_forms();
        $version = get_option('gsmtc-forms-block-pattern-version',1);            
//        error_log ('Se ha ejecutado la funcion "init", $gsmtc-forms :'.var_export($gsmtc_forms,true).PHP_EOL);

        foreach($gsmtc_forms as $form){


                register_block_pattern( $form->post_name,
                    array(
                        'title' =>  $form->post_title,
                        'content' =>  $form->post_content,
                        'categories' => ['gsmtc-forms'],
                        'version' => $version,
                    ));
        }

        update_option('gsmtc-forms-block-pattern-version',$version + 1);

        // Registers the form submit script  
	    wp_register_script(
		    'gsmtc-forms-form-js',
		    GSMTC_FORMS_URL.'/gsmtc-form/gsmtc-forms-form.js',
    	);

    }

   /**
     * Method add_block_categories
     * 
     * This method adds the gsmtc-form category.
     * 
     */
    function add_block_categories($block_categories){
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

    /**
     * get_all_gsmtc_forms
     * 
     * Function to get all gsmtc-forms
     *       
     */
    function get_all_gsmtc_forms(){
        global $wpdb;

        $gsmtc_forms = array();

        $tablename = $wpdb->prefix.'posts';
        $query = "SELECT post_title,post_name,post_content FROM ".$tablename." WHERE post_type='gsmtc-form'";
        $posts_ids = $wpdb->get_results($query);

        if ($posts_ids === NULL)
            return array();

        return $posts_ids;        
    }

    /**
     * Method save_post
     * 
     * Este metodo se ejecuta con el filtro del mismo nombre, y detecta si se esta actualizando algún formulario creado con el plugin
     * gsmtc-forms
     * 
     */


    function save_post($post_id, $post, $updated){
        if ($updated){
            // Unhook to prevent infinity loop
            remove_action('save_post',array($this,'save_post'),10);
            
            $gsmtc_forms = array();
            $gsmtc_form_offset = 0;            
            do {
                $gsmtc_form_initial_position = strpos( $post->post_content, '<!-- wp:gsmtc-forms/gsmtc-form', $gsmtc_form_offset);
                $gsmtc_form_end_position = strpos( $post->post_content, '<!-- /wp:gsmtc-forms/gsmtc-form -->', $gsmtc_form_offset);
                
                if (($gsmtc_form_initial_position !== false) && ($gsmtc_form_end_position !== false) ){                
                    $longitud = $gsmtc_form_end_position - $gsmtc_form_initial_position + 35;
                    $gsmtc_forms[] = substr($post->post_content,$gsmtc_form_initial_position,($gsmtc_form_end_position - $gsmtc_form_initial_position + 35));                   
                    $gsmtc_form_offset = $gsmtc_form_end_position + 35;
                }
                
            } while ( ($gsmtc_form_initial_position !== false) && ($gsmtc_form_end_position) );
            
            foreach( $gsmtc_forms as $form){
                if ($this->is_modified_form($form)){
                    error_log ('Se ha ejecutado la funcion "save_post", EL FORMULARIO HA SIDO MODIFICADO, $form :'.var_export($form,true).PHP_EOL);
                    $this->update_form($form, $post);

                }
                else error_log ('Se ha ejecutado la funcion "save_post", EL FORMULARIO NO HA SIDO MODIFICADO, $form :'.var_export($form,true).PHP_EOL);

            }

            // Rehook to prevent infinity loop 
            add_action( 'save_post', array($this,'save_post'),10,3);

        }
    }

    /**
     * Method is_modified_form
     * 
     * Verifica si un formulario ha sido modificado.
     *
     * @param string $form El identificador del formulario.
     * @return bool Retorna true si el formulario ha sido modificado, false en caso contrario.
     */
 
     function is_modified_form($form) {
        global $wpdb;

        // Por defecto, consideramos que el formulario ha sido modificado.
        $modified = true;

        // Obtenemos el ID del formulario.
        $form_id = $this->get_form_id($form);

        // Obtenemos el ID del post asociado al formulario.
        $post_form_id = $this->get_gsmtc_form_post_id($form_id);

        // Verificamos si existe un post asociado al formulario.
        if ($post_form_id > 0) {
            // Obtenemos el formulario almacenado en el post.
            $gsmtc_form = $this->get_gsmtc_form($post_form_id);

            // Comparamos el formulario actual con el almacenado.
            $result = strcmp($form, $gsmtc_form);

            if ($result == 0) {
                // Si los formularios son idénticos, marcamos como no modificado.
                $modified = false;
            } 
        }

        // Retornamos el estado de modificación del formulario.
        return $modified;
    }
 
    /**
     * Method get_gsmtc_form
     * 
     * Obtiene el contenido del formulario asociado a un ID de post.
     *
     * @param int $post_form_id El ID del post asociado al formulario.
     * @return string El contenido del formulario, o una cadena vacía si no se encuentra.
     */
    function get_gsmtc_form($post_form_id) {
        global $wpdb;

        // Obtenemos el nombre de la tabla de posts usando el prefijo de la base de datos.
        $tablename = $wpdb->prefix.'posts';

        // Construimos la consulta SQL para obtener el contenido del formulario.
        $query = "SELECT post_content FROM ".$tablename." WHERE ID=".$post_form_id;

        // Ejecutamos la consulta y obtenemos el contenido del formulario.
        $post_content = $wpdb->get_var($query);

        // Verificamos si se encontró algún contenido.
        if ($post_content !== NULL) {
            // Si hay contenido, lo retornamos.
            return $post_content;
        } else {
            // Si no hay contenido, retornamos una cadena vacía.
            return '';
        }
    }

    /**
     * Method update_post
     * 
     * Este metodo se ejecuta para actualizar el custom posttype 'gsmtc-form' si es necesario y modificar todos 
     * los posts en los que aparece el formulario.
     * 
     */

    function update_form($form, $post){
        $form_id = $this->get_form_id($form);
        $form_name = $this->get_form_name($form);
        if ($form_name == '')
            $form_name = 'Form-'.$form_id;
        $post_id = $this->get_gsmtc_form_post_id($form_id);
        if ($post_id == 0)
            $this->insert_gsmtc_form_post($form, $form_id, $form_name, $post->ID);
        else $this->update_gsmtc_form_posts($form, $form_id, $form_name, $post_id, $post->ID);

//        error_log ('Se ha ejecutado la funcion "update_form", $form_id :'.var_export($form_id,true).PHP_EOL);
//        error_log ('Se ha ejecutado la funcion "update_form", $post_id :'.var_export($post_id,true).PHP_EOL);
        
    }

    function insert_gsmtc_form_post($form, $form_id, $form_name, $post_id_holder){
        
        $post_data = array(
            'post_title' =>wp_strip_all_tags( $form_name), 
            'post_content' => addslashes($form),
            'post_type' => 'gsmtc-form',
            'post_status' => 'private',
            'meta_input' => array(
                                    'gsmtc_form_id' => wp_strip_all_tags( $form_id),
                                    'gsmtc_form_posts_list' => array($post_id_holder), 
                                ),
        );

        $result = wp_insert_post($post_data);

        return $result;
    } 

    function update_gsmtc_form_posts($form, $form_id, $form_name, $gsmtc_form_id, $post_id_holder){

        // obtengo la lista de posts en la que se encuentra este formulario
        $post_list = get_post_meta($gsmtc_form_id,'gsmtc_form_posts_list');
        $new_post_list = array( $post_id_holder );

        // Actualizamos loa post de la lista menos el post en el que ha sido actualizado el formulario.
        foreach ($post_list as $post_id){
            if ($post_id != $post_id_holder){
                $result = $this->update_form_post($form,$post_id); 
                if ($result == true)
                    $new_post_list[] = $post_id;
            }
        }

        
        // actualizo el post gsmtc-form del formulario, con la lista de post actualizados
        $meta_post = array(
            'gsmtc_form_id' => wp_strip_all_tags( $form_id),
            'gsmtc_form_posts_list' => $new_post_list
        );
        
        $post_data = array(
            'ID' => $gsmtc_form_id,
            'post_title' =>wp_strip_all_tags( $form_name), 
            'post_content' => addslashes($form),
            'post_type' => 'gsmtc-form',
            'post_status' => 'private',
            'meta_input' => $meta_post
        );
        
        wp_update_post($post_data,false,false);
                
    } 



    function update_form_post($form,$post_id){

        $form_id = $this->get_form_id($form);
        $post = get_post($post_id);
        error_log ('Se ha ejecutado la funcion "update_form_post", $post->post_content :'.var_export($post->post_content,true).PHP_EOL);

        $gsmtc_forms = array();
        $gsmtc_form_offset = 0;
        $post_content = $post->post_content;            
        do {
            $gsmtc_form_initial_position = strpos( $post_content, '<!-- wp:gsmtc-forms/gsmtc-form', $gsmtc_form_offset);
            $gsmtc_form_end_position = strpos( $post_content, '<!-- /wp:gsmtc-forms/gsmtc-form -->', $gsmtc_form_offset);

            if (($gsmtc_form_initial_position !== false) && ($gsmtc_form_end_position !== false) ){ 
                
                // obtenemos el id del formulario que esta en el post
                $post_form_id = '';
                $start_char_id = strpos($post_content, 'id":"',$gsmtc_form_initial_position);
                if ($start_char_id !== false){
                    $start_char_id = $start_char_id + 5;
                    $end_char_id = strpos($post_content,'"',$start_char_id + 1);
                    $post_form_id = substr($post_content, $start_char_id, ($end_char_id - $start_char_id));
                } 
        
                if ($form_id == $post_form_id){
    
                    $search = substr($post_content,$gsmtc_form_initial_position,($gsmtc_form_end_position - $gsmtc_form_initial_position + 35));
                    str_replace($search,$form,$post_content);                  

                    $post_data = array(
                        'ID' => $post->ID,
                        'post_content' => addslashes($post_content),
                    );
                    
                    $result = wp_update_post($post_data,false,false);
                }

                $gsmtc_form_offset = $gsmtc_form_end_position + 35;
            }

        } while ( $gsmtc_form_initial_position !== false );



    }

    function get_gsmtc_form_post_id($form_id){
        global $wpdb;

        $tablename = $wpdb->prefix.'postmeta';
        $query = "SELECT post_id FROM ".$tablename." WHERE meta_key='gsmtc_form_id' and meta_value=".$form_id;
        $post_id = $wpdb->get_var($query);

        if ($post_id !== NULL)
            return $post_id;
        else return 0;
    }

    function get_form_id($form){
        $form_id = '';
        $start_char_id = strpos($form, 'id":"');
        if ($start_char_id !== false){
            $start_char_id = $start_char_id + 5;
            $end_char_id = strpos($form,'"',$start_char_id + 1);
            $form_id = substr($form, $start_char_id, ($end_char_id - $start_char_id));
        } 

        return $form_id;
    }

    function get_form_name($form){
        $form_name = '';
        $start_char = strpos($form, 'name":"');
        if ($start_char !== false){
            $start_char = $start_char + 7;
            $end_char = strpos($form,'"',$start_char + 1);
            $form_name = substr($form, $start_char, ($end_char - $start_char));
            error_log ('Se ha ejecutado la funcion "get_form_name", $form_name :'.var_export($form_name,true).PHP_EOL);
        } 

        return $form_name;
    }

    /**
     * Method wp_insert_post_data
     * 
     * Este metodo se ejecuta con el filtro del mismo nombre, y detecta si se esta actualizando algún formulario de creado con el plugin
     * gsmtc-forms
     * 
     * @params $data, postarr
     * @return $data
     */

     function wp_insert_post_data($data,$postarr,$unsanitized,$updated){
         

        if ($data['post_type'] == 'revision')
            error_log (PHP_EOL." Se ha ejecutado la funcion 'wp_insert_post_data', es una copia de seguridad ".PHP_EOL);
        else {

            $gsmtc_forms_positions = array();
            $gsmtc_form_initial_position = 0;            
            do {
                $gsmtc_form_initial_position = strpos($data['post_content'],'<!-- wp:gsmtc-forms/gsmtc-form',$gsmtc_form_initial_position);
                if ($gsmtc_form_initial_position !== false )
                    $gsmtc_forms_position[] = $gsmtc_form_initial_position;

            } while ( $gsmtc_form_initial_position != false );

            error_log (" Se ha ejecutado la funcion 'wp_insert_post_data', gsmtc_forms_positions :".PHP_EOL.var_export($gsmtc_forms_positions,true).PHP_EOL);

                 $offset = 32;
                 $id_position = strpos($data['post_content'],'id=');
                 if ($id_position != false){
                     $id_value_position = strpos($data['post_content'],'"',$id_position) + 1;
                     $id_value_final_position = strpos($data['post_content'],'"',$id_value_position);   
                     $id_value = stripslashes(substr($data['post_content'],$id_value_position, $id_value_position - $id_value_initial_position));        
                     error_log (" Se ha ejecutado la funcion 'wp_insert_post_data', gsmtc-form -> id :".PHP_EOL.var_export($id_value,true).PHP_EOL.' $form_initial_position : '.var_export($form_initial_position,true));
                    }
                    
                    // comprobamos si el id es cero
                    // si el id es cero buscamos un identificador unico y lo añadimos como nuevo custom post tipe y como pattens en wordpress
                    // si tenemos un identificador diferenta solo actualizamos el correspondiente custom post type y el correspondiente patrom.
                

                    error_log (" Se ha ejecutado la funcion 'wp_insert_post_data', data :".PHP_EOL.var_export($data,true).PHP_EOL.' $updated -> '.var_export($updated,true));
        }


            return $data;
    }




     /**
     * Metodo load_textdomain
     * 
     * Este metodo realiza las tareas necesarias para que se cargen las traducciones, en base al directorio
     * y el textdomain
     * 
     * @params void
     * @return void
     */

     function load_textdomain(){
        $text_domain	= 'gsmtc-forms';
        $path_languages = basename(GSMTC_FORMS_DIR).'/languages/';
    
        load_plugin_textdomain($text_domain, false, $path_languages );
    }

    /**
     * Method to register all endpoints
     */
    public function endpoints(){
        register_rest_route( 'gsmtc-forms','simple-contact', array(
                                'methods'  => WP_REST_Server::EDITABLE,
                                'callback' => array($this,'request_simple_contact'),
                                'permission_callback' => true ) );
    }

    /**
     *  Method to validate data form forms
     */
    public function validate($input){

        $result = trim($input);
        $result = stripslashes($result);
        $result = htmlspecialchars($result);
        
        return $result;
    }

    /**
     * Method to respond all the ajax requests
     */
    public function ajax_request(){

        $result = false;
        error_log (" Se ha ejecutado la funcion 'ajax_request'".PHP_EOL.var_export($_POST,true));
        if (isset($_POST['nonce'])) {
            if (wp_verify_nonce($_POST['nonce'],$this->nonce_base)){
                if (isset($_POST['request'])){
                    $request = $_POST['request'];
                    error_log (" Se ha ejecutado la funcion 'ajax_request', el nonce es correcto ".PHP_EOL.var_export($request,true));

                    switch ($request){
                        case 'contact' :
                            $result = $this->request_contact();
                            break;
                    }
                } 
            }
        }

        echo json_encode($result);
        exit();
    }
    


    /**
     * Method to get list of submitted forms
     */
    public function get_submitted_forms_list($page,$forms_page){
        global $wpdb;

        $offset = ($page -1) * $forms_page;
        $query = "SELECT * FROM ".$this->table_name_forms." ORDER BY id DESC LIMIT ".$forms_page." OFFSET ".$offset;
        $result = $wpdb->get_results($query,ARRAY_A);
        error_log (" Se ha ejecutado la funcion 'get_submitted_forms_list', consulta :  ".var_export($query,true));
        error_log (" Resultado ".PHP_EOL.var_export($result,true));

        
        if ($result != null)
            return $result;
        else return array();
    }


    /**
     * Method to inicialize gsmtc_forms
     */
    public function install_gsmtc_forms(){
        // Create tables in database, if not exists
        $this->create_tables();
        // Create custom styles dir, if not exists
        if ( ! is_dir(GSMTC_FORMS_STYLES_DIR) ) mkdir(GSMTC_FORMS_STYLES_DIR);
        add_option('gsmtc-forms-block-pattern-version',1);
                       
    }


    /**
     * Method to create the database tables
     */
    public function create_tables(){

        global $wpdb;

        /**
         * The forms table stores informatión about the indivudual forms 
         */
        $query_forms = "CREATE TABLE IF NOT EXISTS " . $this->table_name_forms . " (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            nameform varchar (50)COLLATE utf8mb4_unicode_ci,
            date varchar (10)COLLATE utf8mb4_unicode_ci,
                                                
            PRIMARY KEY (id)
            ) DEFAULT CHARSET = utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        /**
         * The data_forms table stores informatión about the content of every form 
         */
        $query_data_forms = "CREATE TABLE IF NOT EXISTS " . $this->table_name_data_forms . " (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            idform bigint(20) unsigned NOT NULL,
            typedata varchar (50)COLLATE utf8mb4_unicode_ci,
            namedata varchar (50)COLLATE utf8mb4_unicode_ci,
            contentdata text COLLATE utf8mb4_unicode_ci,
            
            PRIMARY KEY (id)
            ) DEFAULT CHARSET = utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $wpdb->query($query_forms);
        $wpdb->query($query_data_forms);

    }

    /**
     * Method to remove the database tables
     */
    public function remove_tables(){

        global $wpdb;
        $query_forms = "DROP TABLE IF EXISTS " . $this->table_name_forms ;
        $query_data_forms = "DROP TABLE IF EXISTS " . $this->table_name_data_forms ;

        $wpdb->query($query_forms);
        $wpdb->query($query_data_forms);
    }

    /**
     * Method to delete recursively a dir and his content
     */
    function delete ($path){

        if (is_dir($path) === true){
            // if path is a dir
            // get array of files and dirs without dirs '.' and '..'
            $files = array_diff(scandir($path), array('.', '..'));
            foreach($files as $file){
                // for each file call recursevely to delete
                $this->delete(realpath($path) . '/' . $file);
            }
            return rmdir($path);
        } else if (is_file($path) === true){
            // if path is a file, it is deleted 
            return unlink($path);
        }

        return false;
    }

}