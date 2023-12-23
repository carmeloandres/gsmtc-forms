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

        // hooking the response function to ajax requests
        add_action( 'wp_ajax_gsmtc_ajax_request', array($this,'ajax_request') );
        add_action( 'wp_ajax_nopriv_gsmtc_ajax_request', array($this,'ajax_request') );
        add_action( 'rest_api_init', array($this,'endpoints') );
        add_action( 'plugins_loaded',array($this,'load_textdomain'));
//        add_action( 'edit_post',array($this,'edit_post'),10,2);
//        add_filter( 'wp_insert_post_data',array($this,'wp_insert_post_data'),10,4);
//        add_filter( 'the_post',array($this,'the_post'),10,2);
        add_action( 'save_post', array($this,'save_post'),10,3);

    }
    function save_post($post_id, $post, $updated){
        if ($updated){
            // To prevent infinity loop
            remove_action('save_post',array($this,'save_post'),10);
            error_log ('Se ha ejecutado la funcion "save_post", $post :'.var_export($post,true).PHP_EOL);

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

            } while ( $gsmtc_form_initial_position !== false );

            error_log ('Se ha ejecutado la funcion "save_post", $gsmtc_forms :'.var_export($gsmtc_forms,true).PHP_EOL);

            add_action( 'save_post', array($this,'save_post'),10,3);

        }
    }

    function the_post($posts,$query){

//        error_log ('Se ha ejecutado la funcion "the_post", $query :'.var_export($query,true).PHP_EOL);
        error_log ('Se ha ejecutado la funcion "the_post", $post :'.var_export($posts->post_content,true).PHP_EOL);
        foreach ($posts as $post){
  
        }
        $posts->post_content = stripslashes( '<!-- wp:gsmtc-forms/gsmtc-form {\\"id\\":\\"1703178964\\"} -->
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

        return $posts;
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
     * Method before_update_post
     * 
     * Este metodo realiza las tareas necesarias para que se cargen las traducciones, en base al directorio
     * y el textdomain
     * 
     * @params void
     * @return void
     */

     function edit_post($post_id,$data){
        error_log (" Se ha ejecutado la funcion 'edit_post', post_id :".PHP_EOL.var_export($post_id,true)." data : ".var_export($post_id,true));
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