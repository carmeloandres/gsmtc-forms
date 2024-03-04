<?php
 if ( ! defined( 'ABSPATH' ) ) {die;} ; 

 // To get access to the patterns class
 require_once ('class-gsmtc-forms-translations.php');

/**
 * Class to manage the database
 */

class Gsmtc_Forms extends Gsmtc_Forms_Translations{

    public $plugin_prefix;
    public $table_name_forms;
    public $table_name_data_forms;

       
    function __construct()
    {
        parent::__construct();

        global $wpdb;

        $this->plugin_prefix = 'gsmtc_';
        $this->table_name_forms = $wpdb->prefix.$this->plugin_prefix.'forms';
        $this->table_name_data_forms = $wpdb->prefix.$this->plugin_prefix.'forms_data';


        add_action('init',array($this,'init'));
//        add_action('rest_api_init',array($this,'rest_api_init')); 
        add_filter('block_categories_all',array($this,'add_block_categories'));
        add_action( 'plugins_loaded',array($this,'load_textdomain'));
        add_action( 'save_post', array($this,'save_post'),10,3);
        add_action( 'before_delete_post', array($this,'before_delete_post'),10,2);
        add_action( 'add_meta_boxes', array($this,'add_meta_boxes'));
        add_action( 'admin_menu',array($this,'admin_menu'));
        add_filter('default_content', array($this,'default_content'),10,2);
        add_action('wp_body_open',array($this,"wp_body_open"));



    }
 
    function wp_body_open(){
        if (wp_script_is('gsmtc-forms-form-js', 'enqueued')) {
        ?>
        	<script type="text/javascript">
			const GsmtcForms = {
                "inputTextTitle":"<?php echo $this->input_text_title; ?>",
                "inputEmailTitle":"<?php echo $this->input_email_title; ?>"
            };

	</script>

        <?php
        }
    }
 
    function admin_menu(){
        add_submenu_page('edit.php?post_type=gsmtc-form', 'gsmtc-forms-data',__('Data forms','gsmtc-form'), 'manage_options','gsmtc-forms-data',array($this,'show_data'));
    }

    function show_data(){
        echo '<h2>Mostrar información de los formularios</h2>';
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
			'menu_name'          => _x( 'Gsmtc Forms', 'admin menu', 'gsmtc-forms' ),
			'add_new'            => _x( 'Add new', 'form', 'gsmtc-forms' ),
			'add_new_item'       => __( 'Add new form', 'gsmtc-forms' ),
			'new_item'           => __( 'New form', 'gsmtc-forms' ),
			'edit_item'          => __( 'Edit form', 'gsmtc-forms' ),
			'view_item'          => __( 'View form', 'gsmtc-forms' ),
			'all_items'          => __( 'All forms', 'gsmtc-forms' ),
			'search_items'       => __( 'Search forms', 'gsmtc-forms' ),
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
                'show_in_rest'      => true, // This option in 'true' allows the use of the block editor
                'capability_type'    => 'post',
                'menu_position'      => null,
                'supports'           => array( 'title','editor','custom-fields'),
                )			
		);
        
        // Register the gsmtc-forms blocks using the block api v2
       
//        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-checkbox');
//        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-date');
        register_block_type( GSMTC_FORMS_DIR.'/blocks/email');
//        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-fieldset');
        register_block_type( GSMTC_FORMS_DIR.'/blocks/form');
        register_block_type( GSMTC_FORMS_DIR.'/blocks/label');
//        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-noticesend');
        register_block_type( GSMTC_FORMS_DIR.'/blocks/main-email');
//        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-radio');
        register_block_type( GSMTC_FORMS_DIR.'/blocks/submit');
        register_block_type( GSMTC_FORMS_DIR.'/blocks/text');
//        register_block_type( GSMTC_FORMS_DIR.'/gsmtc-textarea');
    
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
            if ($form->post_status == 'publish') 
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
		    GSMTC_FORMS_URL.'/blocks/form/gsmtc-forms-form.js',
    	);

        // loads the data to conect to API
        wp_localize_script('gsmtc-forms-form-js','GsmtcFormsAPI',array(
            "restUrl" =>  esc_url_raw(rest_url( '/gsmtc-forms/form' )),
            "nonce" => wp_create_nonce('wp_rest'),
            "homeUrl" => home_url(),
        ));

        //Registers the blocks styles
        wp_register_style('gsmtc-forms-submit-css',
                            GSMTC_FORMS_URL.'/blocks/submit/gsmtc-forms-submit.css');

    }

    /**
     * Metodo: default_content
     *  
     * Crea contenido por defecto en el momemnto de crear un nuevo custom post_type del tipo "gsmtc-form"
     *
     * Esta función detecta el momento previo a la edición de posts y si el contenido esta vacio y el tipo de post
     * es "gsmtc-form", añade un bloque de formulario vacio.
     *
     * @param string $content El contenido del post.     
     * @param WP_Post $post El post a eleminar.
     * @return string El contenido del post, tanto si ha sido modificado como si no.
     */
     function default_content($content, $post){
        //        error_log ('Se ha ejecutado la función "dafault_content", $content : '.var_export($content,true).' , $post :'.var_export($post,true).PHP_EOL);
                if (($content == '') && ($post->post_type === 'gsmtc-form')){
                    $form_id = time();
                    $content = '<!-- wp:gsmtc-forms/form {"id":"'.$form_id.'"} -->';
                    $content = $content.'<form class="wp-block-gsmtc-forms-form" id="'.$form_id.'"></form>';
                    $content = $content.'<!-- /wp:gsmtc-forms/form -->';
        //            error_log ('Se ha ejecutado la función "dafault_content", $content : '.var_export($content,true).' , $post :'.var_export($post,true).PHP_EOL);
        
                }
                
                return $content;
            }
        
    function add_meta_boxes(){
        add_meta_box(
            'gsmtc_form_meta_box',           // ID único del meta box
            'Datos relacionados del formulario',       // Título del meta box que se mostrará en la página de edición
            array($this,'show_gsmtc_metabox'), // Callback para mostrar el contenido del meta box
            'gsmtc-form',                      // Tipo de contenido al que se aplicará el meta box (en este caso, gsmtc-form)
            'normal',                    // Contexto (puedes usar 'normal', 'advanced', o 'side')
            'default'                    // Prioridad (puedes usar 'default', 'high', 'low' o 'core')
        ); 
    }

    function show_gsmtc_metabox($post){
           // Recuperar el valor actual del campo personalizado (si existe)
    $vector = get_post_meta($post->ID, 'gsmtc_form_posts_list');
//    error_log ('Se ha ejecutado la función "show_gsmtc_metabox", $vector : '.var_export($vector,true).PHP_EOL);

    if (is_array($vector) && isset($vector[0])){
    ?>
        <h2>Lista de posts en los que se muestra el formulario</h2>
        <ul>
    <?php
        $post_list = $vector[0];
        foreach($post_list as $post_id){
            $post_title = $this->get_post_title($post_id);
            $url_edicion = home_url('wp-admin/post.php?post='.$post_id.'&action=edit');
            $url_show = home_url($post_title);
            ?>
                <li><a href="<?php echo $url_edicion?>">Editar </a> <?php echo $post_title?> <a href="<?php echo $url_show?>">Mostrar </a> </li>
            <?php
        }
        ?>
            </ul>
        <?php
    } else {
        ?>
            <h2>Este formulario no se muestra en ningun contenido</h2>
        <?php
    }

    }

    function get_post_title($post_id){
        global $wpdb;

        $table_prefix = $wpdb->prefix;
        $table_name = $table_prefix.'posts';
        $query = 'SELECT post_title FROM '.$table_name.' WHERE ID = '.$post_id;
        $result = $wpdb->get_var($query);

        if ($result !== NULL)
            return $result;
        else return '';
    }

    /**
     * Metodo: before_delete_post
     *  
     * Crea un nuevo formulario gsmtc y lo almacena como un post personalizado.
     *
     * Esta función toma un formulario gsmtc, su identificador y el ID del post en el que
     * se aloja el formulario, y crea un nuevo post personalizado 'gsmtc-form' con la 
     * información proporcionada.
     *
     * @param int $postid. El id del post a eliminar
     * @param WP_Post $post El post a eleminar.
     * @return int|WP_Error El ID del post creado o un objeto WP_Error si hay un error.
     */
    function before_delete_post($postid, $post) {
        error_log ('Se ha ejecutado la funcion "before_delete_post", $post->post_type :'.var_export($post->post_type,true).PHP_EOL);
        if ($post->post_type == 'gsmtc-form'){

            // Unhook to prevent infinity loop
            remove_action('save_post',array($this,'save_post'),10);

            $form_id = get_post_meta($postid,'gsmtc_form_id',true);
            $vector = get_post_meta($postid,'gsmtc_form_posts_list');
            if (is_array($vector) && is_array($vector[0])){
                $post_list = $vector[0];
                error_log ('Se ha ejecutado la funcion "before_delete_post", $post_list :'.var_export($post_list,true).' , $form_id :'.var_export($form_id,true).PHP_EOL);
    
                foreach ($post_list as $post_id)
                    $this->delete_form_post($form_id, $post_id);
            }

            // Rehook to prevent infinity loop 
            add_action( 'save_post', array($this,'save_post'),10,3);


        }

    }


    function delete_form_post($form_id,$post_id){

        $result = false;
        error_log ('Se ha ejecutado la funcion "delete_form_post", $form_id :'.var_export($form_id,true).PHP_EOL);
        
        $post_content = $this->get_post_content($post_id);   

//        error_log ('Se ha ejecutado la funcion "update_form_post", $post_content :'.var_export($post_content,true).PHP_EOL);
        $gsmtc_form_initial_position = strpos( $post_content, '<!-- wp:gsmtc-forms/form {"id":"'.$form_id);
        $gsmtc_form_end_position = strpos( $post_content, '<!-- /wp:gsmtc-forms/form -->');

        if (($gsmtc_form_initial_position !== false) && ($gsmtc_form_end_position !== false) ){ 
                
            // get a form
            $form_string = substr($post_content,$gsmtc_form_initial_position,($gsmtc_form_end_position - $gsmtc_form_initial_position + 29));
            $new_post_content = str_replace($form_string,'',$post_content);
    
//                    error_log ('Se ha ejecutado la funcion "update_form_post", $search :'.var_export($search,true).PHP_EOL);

            $post_data = array(
                'ID' => $post_id,
                'post_content' => addslashes($new_post_content),
            );
                    
            $result = wp_update_post($post_data,false,false);
 
        }


        return $result;
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
                'slug' => 'gsmtc-forms',
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
        $query = "SELECT post_title,post_name,post_content,post_status FROM ".$tablename." WHERE post_type='gsmtc-form'";
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
        
        if ($updated && ($post->post_type !== 'revision')){
            // Unhook to prevent infinity loop
            remove_action('save_post',array($this,'save_post'),10);
            
//            error_log ('Se ha ejecutado la funcion "save_post", $post :'.var_export($post,true).PHP_EOL);

            $gsmtc_forms = $this->get_forms_array_from_post($post->post_content);

            foreach( $gsmtc_forms as $form){
                if ($this->is_new_form($form)){
                    if ($post->post_type === 'gsmtc-form')
                        $this->new_gsmtc_form_created($form, $post_id, $post->post_title);
                    else
                        $this->create_new_gsmtc_form($form, $post_id);
                    error_log ('Se ha ejecutado la funcion "save_post", EL FORMULARIO ES NUEVO, $post_id :'.var_export($post_id,true).PHP_EOL);
                } else {
                        if (($this->is_modified_form($form)) || ($post->post_type == 'gsmtc-form')){
                            error_log ('Se ha ejecutado la funcion "save_post", EL FORMULARIO HA SIDO MODIFICADO'.PHP_EOL);//.var_export($form,true).PHP_EOL);
                            $this->update_form($form, $post_id);

                        } else {
                            $post_list = $this->add_id_to_list_if_proceeds($form,$post_id);
    /*                        $encontrado = false;
                            foreach($post_list as $id){
                                if($post_id == $id)
                                    $encontrado = true;
                            }


    */
                            error_log ('Se ha ejecutado la funcion "save_post", EL FORMULARIO NO HA SIDO MODIFICADO, $post_list :'.var_export($post_list,true).PHP_EOL);//.var_export($form,true).PHP_EOL);
                        }

                } 
            }

            // Rehook to prevent infinity loop 
            add_action( 'save_post', array($this,'save_post'),10,3);

        }
    }

    /**
     * Metodo:  new_gsmtc_form_created
     *  
     * Esta función se ejecuta cuando se crea un nuevo custom post type del tipo 'gsmtc-form'
     * utilizando el editor de customs post.
     * 
     * Tiene como cometido modificar el post para que, solo tenga un bloque de formularios del tipo
     * 'gsmtc-form' añadir el nombre del post al bloque y crear los metafields necesarios para su correcto funcionamiento. 
     *
     *
     * @param string $form El contenido del formulario gsmtc.
     * @param int $post_id El ID del post que contiene al formulario.
     * @param string $post_title El titulo del post, que será añadido al bloque.  
     * @return int|WP_Error El ID del post creado o un objeto WP_Error si hay un error.
     */
    function new_gsmtc_form_created($form,$post_id,$post_title){
        // obtenemos el campo nombre del bloque formulario
        $form_id = $this->get_form_id($form);
        $form_name = $this->get_form_name($form);
        // si el bloque no tiene nombre, añadimos el titulo del post al nombre del bloque
        $new_form = $form;
        if ($form_name == ''){
            // Buscamos la posición final de la cabecera  del bloque de formulario.
            $form_name = $post_title;
            $gsmtc_header_end_position = strpos($form, '} -->');
            error_log ('Se ha ejecutado la funcion "new_gsmtc_form_created", $gsmtc_header_end_position :'.var_export($gsmtc_header_end_position,true).PHP_EOL);
            if ($gsmtc_header_end_position !== false){

                $html_form_id_position = strpos($form,'id="');
                if ($html_form_id_position !== false){
                    $html_form_id_position = $html_form_id_position + 15;
                    
                    $first_part = substr($form,0,$gsmtc_header_end_position);
                    $second_part = ',"name":"'.$post_title.'"';
                    $third_part = substr($form, $gsmtc_header_end_position,($html_form_id_position - $gsmtc_header_end_position));
                    $fourth_part = ' name="'.$post_title.'"';
                    $fifth_part = substr($form,$html_form_id_position);
                    $new_form = $first_part.$second_part.$third_part.$fourth_part.$fifth_part;

                    error_log ('Se ha ejecutado la funcion "new_gsmtc_form_created", $new_form :'.var_export($new_form,true).PHP_EOL);

                }

            }
        } 

        $post_data = array(
            'ID' => $post_id,
            'post_title'    => wp_strip_all_tags($form_name),
            'post_content'  => addslashes($new_form),
            'post_type'     => 'gsmtc-form',
            'post_status'   => 'publish',
            'meta_input'    => array(
                'gsmtc_form_id'          => wp_strip_all_tags($form_id),
                'gsmtc_form_posts_list'  => array(),
            ),
        );

        // Insertamos el post personalizado y obtenemos el resultado.
        $result = wp_insert_post($post_data);

        // Retornamos el ID del post creado o un objeto WP_Error en caso de error.
        return $result;

//        $gsmtc_form_initial_position = strpos($post_content, '<!-- wp:gsmtc-forms/form');        

    }

    function add_id_to_list_if_proceeds($form,$post_id){
        $form_id = $this->get_form_id($form);
        $gsmtc_post_id = $this->get_gsmtc_form_post_id($form_id);
        $vector = get_post_meta($gsmtc_post_id,'gsmtc_form_posts_list');
        $post_list = $vector[0];
        error_log ('Se ha ejecutado la funcion "add_id_to_list_if_proceeds", $post_list :'.var_export($post_list,true).PHP_EOL);

        if ( ! is_array($post_list))
            $post_list = array();
        // Si el post actualizado no es el custom post type del formulario, lo incluimos en la lista, en caso de no estar en ella.
        if ($gsmtc_post_id != $post_id){
            $encontrado = false;
            foreach($post_list as $id){
                if($post_id == $id)
                    $encontrado = true;
            }
    
            if (! $encontrado){
                $post_list[] = $post_id;
                update_post_meta($gsmtc_post_id,'gsmtc_form_posts_list',$post_list);
            }
        }

        return $post_list;
    }

    /**
     * Metodo:  create_new_gsmtc_form
     *  
     * Crea un nuevo formulario gsmtc y lo almacena como un post personalizado.
     *
     * Esta función toma un formulario gsmtc, su identificador y el ID del post en el que
     * se aloja el formulario, y crea un nuevo post personalizado 'gsmtc-form' con la 
     * información proporcionada.
     *
     * @param string $form El contenido del formulario gsmtc.
     * @param int $post_id_holder El ID del post que contiene al formulario.
     * @return int|WP_Error El ID del post creado o un objeto WP_Error si hay un error.
     */
    function create_new_gsmtc_form($form, $post_id_holder) {
        // Obtenemos el ID y el nombre del formulario utilizando funciones auxiliares.
        $form_id = $this->get_form_id($form);
        $form_name = $this->get_form_name($form);

        // Verificamos si el nombre del formulario está vacío y lo asignamos si es necesario.
        if ($form_name == '') {
            $form_name = 'Gsmtc-Form-' . $form_id;
        }

        // Configuramos los datos del post personalizado.
        $post_data = array(
            'post_title'    => wp_strip_all_tags($form_name),
            'post_content'  => addslashes($form),
            'post_type'     => 'gsmtc-form',
            'post_status'   => 'publish',
            'meta_input'    => array(
                'gsmtc_form_id'          => wp_strip_all_tags($form_id),
                'gsmtc_form_posts_list'  => [$post_id_holder],
            ),
        );

        // Insertamos el post personalizado y obtenemos el resultado.
        $result = wp_insert_post($post_data);

        // Retornamos el ID del post creado o un objeto WP_Error en caso de error.
        return $result;
    }
        
        

    /**
     * Verifica si un formulario es nuevo o ya existe.
     *
     * Esta función determina si un formulario dado es nuevo o ya existe en función
     * de su identificador. Retorna true si el formulario es nuevo y false si ya existe.
     *
     * @param string $form El identificador del formulario.
     * @return bool Retorna true si el formulario es nuevo, false si ya existe.
     */
    function is_new_form($form) {

        global $wpdb;

        // Obtenemos el ID del formulario utilizando la función get_form_id.
        $form_id = $this->get_form_id($form);

        // Comprobamos si hay post_id asociado al id del formulario.
        $table_name = $wpdb->prefix.'postmeta';
        $query = "SELECT 'post_id' FROM ".$table_name." WHERE meta_key = 'gsmtc_form_id' AND meta_value =".$form_id;  
        $result = $wpdb->get_var($query);

        // Verificamos si el resultado.
        if ($result == NULL) {
            // Si el post_id está vacío, significa que el formulario es nuevo.
            return true;
        } else {
            // Si el post_id no está vacío, significa que el formulario ya existe.
            return false;
        }
    }


    /**
     * Method: get_forms_array_from_posts
     * 
     * Obtiene un array de formularios desde el contenido de un post.
     *
     * Esta función busca y extrae bloques de formularios definidos por el plugin 'gsmtc-forms'
     * en el contenido de un post y los devuelve como un array.
     *
     * @param string $post_content El contenido del post del cual se extraerán los formularios.
     * @return array Un array que contiene los bloques de formularios encontrados en el contenido del post.
     */
    function get_forms_array_from_post($post_content) {
        // Inicializamos un array para almacenar los formularios encontrados.
        $gsmtc_forms = array();

        // Inicializamos la posición del offset del formulario.
        $gsmtc_form_offset = 0;

        // Iteramos sobre el contenido del post para encontrar y extraer los formularios.
        do {
            // Buscamos la posición inicial de un bloque de formulario.
            $gsmtc_form_initial_position = strpos($post_content, '<!-- wp:gsmtc-forms/form', $gsmtc_form_offset);

            // Buscamos la posición final de un bloque de formulario.
            $gsmtc_form_end_position = strpos($post_content, '<!-- /wp:gsmtc-forms/form -->', $gsmtc_form_offset);

            // Verificamos si se encontraron ambas posiciones.
            if (($gsmtc_form_initial_position !== false) && ($gsmtc_form_end_position !== false)) {
                // Calculamos la longitud del bloque de formulario.
                $longitud = $gsmtc_form_end_position - $gsmtc_form_initial_position + 29;

                // Extraemos el bloque de formulario y lo almacenamos en el array.
                $gsmtc_forms[] = substr($post_content, $gsmtc_form_initial_position, $longitud);

                // Actualizamos el offset para buscar el próximo formulario.
                $gsmtc_form_offset = $gsmtc_form_end_position + 29;
            }

        } while (($gsmtc_form_initial_position !== false) && ($gsmtc_form_end_position !== false));

        // Retornamos el array de formularios encontrados.
        return $gsmtc_forms;
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

    function update_form($form, $post_id_holder){
        $form_id = $this->get_form_id($form);
        $form_name = $this->get_form_name($form);
        if ($form_name == '')
            $form_name = 'Gsmtc-Form-'.$form_id;
        $gsmtc_post_id = $this->get_gsmtc_form_post_id($form_id);
        $this->update_gsmtc_form_posts($form, $form_id, $form_name, $gsmtc_post_id, $post_id_holder);

//        error_log ('Se ha ejecutado la funcion "update_form", $form_id :'.var_export($form_id,true).PHP_EOL);
//        error_log ('Se ha ejecutado la funcion "update_form", $post_id :'.var_export($post_id,true).PHP_EOL);
        
    }


    function update_gsmtc_form_posts($form, $form_id, $form_name, $gsmtc_form_id, $post_id_holder){

        // obtengo la lista de posts en la que se encuentra este formulario
        $post_list = $this->add_id_to_list_if_proceeds($form,$post_id_holder);
//        $post_list = get_post_meta($gsmtc_form_id,'gsmtc_form_posts_list',true);
        $new_post_list = array();
        error_log ('Se ha ejecutado la funcion "update_gsmtc_form_posts", $post_list :'.var_export($post_list,true).PHP_EOL);

        // Actualizamos loa post de la lista menos el post en el que ha sido actualizado el formulario.
        foreach ($post_list as $post_id){
//            if ($post_id != $post_id_holder){
                $result = $this->update_form_post($form,$post_id); 
                // Si la actualización ha tenido exito, el formulario todavia esta en el post, se añade el post a la lista de post que contienen el formulario
                if ($result == true)
                    $new_post_list[] = $post_id;
//            }
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
            'meta_input' => $meta_post
        );

        error_log ('Se ha ejecutado la funcion "update_gsmtc_form_posts", $new_post_list :'.var_export($new_post_list,true).PHP_EOL);

        wp_update_post($post_data,false,false);
                
    } 



    function update_form_post($form,$post_id){

        $result = false;
        $form_id = $this->get_form_id($form);
        error_log ('Se ha ejecutado la funcion "update_form_post", $post_id :'.var_export($post_id,true).PHP_EOL);
        
        $gsmtc_forms = array();
        $gsmtc_form_offset = 0;
        $post_content = $this->get_post_content($post_id);            
//        error_log ('Se ha ejecutado la funcion "update_form_post", $post_content :'.var_export($post_content,true).PHP_EOL);
        do {
            $gsmtc_form_initial_position = strpos( $post_content, '<!-- wp:gsmtc-forms/form', $gsmtc_form_offset);
            $gsmtc_form_end_position = strpos( $post_content, '<!-- /wp:gsmtc-forms/form -->', $gsmtc_form_offset);

            if (($gsmtc_form_initial_position !== false) && ($gsmtc_form_end_position !== false) ){ 
                
                // get a form
                $search = substr($post_content,$gsmtc_form_initial_position,($gsmtc_form_end_position - $gsmtc_form_initial_position + 29));

                // obtenemos el id del formulario que esta en el post
                $post_form_id = '';
                $start_char_id = strpos($search, 'id":"');
                if ($start_char_id !== false){
                    $start_char_id = $start_char_id + 5;
                    $end_char_id = strpos($search,'"',$start_char_id + 1);
                    $post_form_id = substr($search, $start_char_id, ($end_char_id - $start_char_id));
                } 
        
                if ($form_id == $post_form_id){
    
//                    error_log ('Se ha ejecutado la funcion "update_form_post", $search :'.var_export($search,true).PHP_EOL);

                    $post_content = str_replace($search,$form,$post_content);                  

                    $post_data = array(
                        'ID' => $post_id,
                        'post_content' => addslashes($post_content),
                    );
                    
                    $result = wp_update_post($post_data,false,false);
                }

                $gsmtc_form_offset = $gsmtc_form_end_position + 29;
                if ( $gsmtc_form_offset >= strlen( $post_content ) ){
                    $gsmtc_form_offset = strlen( $post_content ) - 1;
                } 
            }

        } while ( $gsmtc_form_initial_position !== false );


        return $result;
    }

    function get_post_content($post_id){
        global $wpdb;

        $tablename = $wpdb->prefix.'posts';
        $query = "SELECT post_content FROM ".$tablename." WHERE ID=".$post_id;
        $post_content = $wpdb->get_var($query);
        if ($post_content !== NULL)
            return $post_content;
        else return '';
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
        // Dafault value of form_name
        $form_name = '';

        // getting the header of gesimatica form block
        $start_char_header = strpos($form,'<!-- wp:gsmtc-forms/form');
        if ($start_char_header !== false){
            $end_char_header = strpos($form,'-->',$start_char_header);
            if ($end_char_header !== false){
                $form_header = substr($form, $start_char_header, ($end_char_header - $start_char_header));
                if ($form_header !== '' && $form_header !== false){
                    // Once we get the header and is valid, proced to obtain the form name 
                    $start_char = strpos($form_header, 'name":"');
                    if ($start_char !== false){
                        $start_char = $start_char + 7;
                        $end_char = strpos($form_header,'"',$start_char + 1);
                        $form_name = substr($form_header, $start_char, ($end_char - $start_char));
                    } 
                }
            }
        }

        return $form_name;
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
    /*
    public function endpoints(){
        register_rest_route( 'gsmtc-forms','simple-contact', array(
                                'methods'  => WP_REST_Server::EDITABLE,
                                'callback' => array($this,'request_simple_contact'),
                                'permission_callback' => true ) );
    }

    /**
     *  Method to validate data form forms
     */
    /*
    public function validate($input){

        $result = trim($input);
        $result = stripslashes($result);
        $result = htmlspecialchars($result);
        
        return $result;
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