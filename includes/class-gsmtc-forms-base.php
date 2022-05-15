<?php
 if ( ! defined( 'ABSPATH' ) ) {die;} ; 

/**
 * Class to manage the database
 */

class Gsmtc_Forms_Base{

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
           
    }

    /**
     * Method to registerl all endpoints
     */
    public function endpoints(){
        register_rest_route( 'gsmtc-forms/','simple-contact', array('methods'  => WP_REST_Server::EDITABLE,
                                'callback' => array($this,'request_simple_contact'),) );
    }

    /**
     * Method para atender la petici
     */
    function request_simple_contact($request){ 
        global $wpdb;

        $result = false;
        $form['nameform'] = 'contact';
        $form['date'] = date('d-m-Y');
        if($wpdb->insert($this->table_name_forms,$form)){
            $form_id = $wpdb->insert_id;  
            if ($request->get_param('name') != NULL){   
                $data = array ('idform' => $form_id,'typedata' => 'input','namedata' => 'name','contentdata' => $this->validate($request->get_param('name')));
                $wpdb->insert($this->table_name_data_forms,$data);
            }
            if ($request->get_param('email') != NULL){
                $data = array ('idform' => $form_id,'typedata' => 'email','namedata' => 'email','contentdata' => $this->validate($request->get_param('email')));
                $wpdb->insert($this->table_name_data_forms,$data);
            }
            if ($request->get_param('message') != NULL){
                $data = array ('idform' => $form_id,'typedata' => 'textarea','namedata' => 'message','contentdata' => $this->validate($request->get_param('message')));
                $wpdb->insert($this->table_name_data_forms,$data);
            }
            if ($request->get_param('accept') != NULL){
                $data = array ('idform' => $form_id,'typedata' => 'checkbox','namedata' => 'accept','contentdata' => $this->validate($request->get_param('accept')));
                $wpdb->insert($this->table_name_data_forms,$data);
            }
            $result = $form_id;
        }
        echo json_encode($result);
        exit();
            
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
     * Method para atender la peticion de borrar comentario
     */
    function request_contact(){ 
        global $wpdb;

        $result = false;
        $form['nameform'] = 'contact';
        $form['date'] = date('d-m-Y');
        if($wpdb->insert($this->table_name_forms,$form)){
            $form_id = $wpdb->insert_id;        
            if (isset($_POST['name'])){
                $data = array ('idform' => $form_id,'typedata' => 'input','namedata' => 'name','contentdata' => $this->validate($_POST['name']));
                $wpdb->insert($this->table_name_data_forms,$data);
            }
            if (isset($_POST['email'])){
                $data = array ('idform' => $form_id,'typedata' => 'email','namedata' => 'email','contentdata' => $this->validate($_POST['email']));
                $wpdb->insert($this->table_name_data_forms,$data);
            }
            if (isset($_POST['message'])){
                $data = array ('idform' => $form_id,'typedata' => 'textarea','namedata' => 'message','contentdata' => $this->validate($_POST['message']));
                $wpdb->insert($this->table_name_data_forms,$data);
            }
            if (isset($_POST['accept'])){
                $data = array ('idform' => $form_id,'typedata' => 'checkbox','namedata' => 'accept','contentdata' => $this->validate($_POST['accept']));
                $wpdb->insert($this->table_name_data_forms,$data);
            }
            $result = $form_id;
        }
        
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
     * Method to inicialize gsmtc_forms
     */
    public function install_gsmtc_forms(){
        // Create tables in database, if not exists
        $this->create_tables();
        // Create custom styles dir, if not exists
        if ( ! is_dir(CUSTOM_STYLES_DIR) ) mkdir(CUSTOM_STYLES_DIR);
                       
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