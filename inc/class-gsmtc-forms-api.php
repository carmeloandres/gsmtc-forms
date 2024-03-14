<?php
 if ( ! defined( 'ABSPATH' ) ) {die;} ; 

  // To get access to the patterns class
  require_once ('class-gsmtc-forms-translations.php');  

/**
 * Clase Gsmtc_Forms_Api
 *
 * Esta clase contiene el codigo necesario para crear la Api de comunicación con los formularios
 * en el fronend y las estructuras de información para almacenar la información de las llamadas a la Api.
 *
 * @package gsmtc-forms
 * @since 1
 */
class Gsmtc_Forms_Api extends Gsmtc_forms_Translations{

    /**
     * Prefijo utilizado para las tablas propias del plugin.
     *
     * @var string
     */
    public $plugin_prefix;

    /**
     * Nombre de la tabla que almacena la información de contexto de cada formulario enviado.
     *
     * @var string
     */
    public $table_name_submited_forms;


    /**
     * Nombre de la tabla que almacena la información de los formularios en la base de datos.
     *
     * @var string
     */
    public $table_name_data_forms;

    /**
     * Numero de filas por página.
     *
     * @var int
     */
    public $rows_per_page;

    /**
     * Constructor de la clase.
     *
     * Establece el valor de las propiedades, añade las acciones necesarias para el funcionamiento de
     * la clase.
     */
    function __construct(){
        global $wpdb;

        $this->plugin_prefix = 'gsmtc_';
        $this->table_name_submited_forms = $wpdb->prefix.$this->plugin_prefix.'forms_submited';
        $this->table_name_data_forms = $wpdb->prefix.$this->plugin_prefix.'forms_data';
        $this->rows_per_page = 10;
   
        add_action('rest_api_init',array($this,'rest_api_init')); 

    }

     /**
	 * rest_api_init
	 * 
	 * Este metodo crea los endpoints para la conexion con la api de la aplicación
	 *
	 * @return void
	 */
	function rest_api_init(){
        
		register_rest_route('gsmtc-forms','form',array(
			'methods'  => 'POST',
			'callback' => array($this,'manage_api_request'),	
			'permission_callback' => array($this,'get_permissions_check')			
	
		));

        
		register_rest_route('gsmtc-forms','admin',array(
			'methods'  => 'POST',
			'callback' => array($this,'manage_admin_api_request'),	
			'permission_callback' => array($this,'get_permissions_check')			
		));

    }

    /**
	 * manage_api_request
	 * 
	 * This method manage de recuest of the endpoints 
	 *
	 * @return void
	 */
		
     function manage_api_request(WP_REST_Request $request ){

		$result = json_encode(0);

		if ($request->sanitize_params()){

			$params = $request->get_params();

            error_log ('Manage_api_request_ - $params : '.var_export($params,true));
            if (isset ($_SERVER))
//                error_log ('Manage_api_request_ - $_SERVER : '.var_export($_SERVER,true));
            
            if (isset($params['action'])){
				$action = $params['action'];
//				error_log ('Estamos dentro del bucle, $params: '.var_export($params,true));
				switch ($action){
					case 'submitted_form':
						$result = $this->submitted_form($params);
						break;
					case 'update_customer' :
						$result = $this->update_customer($params);
						break;										
					}
			} 
		}
		error_log ('Resultado del bucle, $result: '.var_export($result,true));

        echo json_encode($result);
		exit();
	}

    /**
	 * manage_admin_api_request
	 * 
	 * This method manage de request of the endpoints from the admin 
	 *
	 * @return void
	 */
		
     function manage_admin_api_request(WP_REST_Request $request ){

		$result = json_encode(0);

		if ($request->sanitize_params()){

			$params = $request->get_params();

            error_log ('Manage_admin_api_request_ - $params : '.var_export($params,true));
            
            if (isset($params['action'])){
				$action = $params['action'];
				switch ($action){
					case 'get_data_page':
						$result = $this->get_data_page($params);
						break;
					case 'delete_submission' :
						$result = $this->delete_submission($params);
						break;										
                    case 'get_data_submit' :
                        $result = $this->get_data_submit($params);
                        break;										
                }
			} 
		}
        error_log ('Resultado del bucle, $result: '.var_export($result,true));

        echo json_encode($result);
		exit();
	}

    /**
     * Metodo: get_data_submit
     *  
     * Obtiene el contenido de los correspondientes inputs del envio de un determinado
     * formulario, identificado por el idsubmit.
     *
     * @param array $params La información de la petición.     
     * @return array Devuelve el tipo, el nombre y el contenido de los inputs del envio de un formulario.
     */
    function get_data_submit($params){
        global $wpdb;

        $result = array();

        if (isset($params['idSubmit']) && is_int(intval($params['idSubmit']))){
            
            $query = "SELECT typedata, namedata, contentdata FROM ".$this->table_name_data_forms." WHERE idsubmit = ".intval($params['idSubmit']);
            $result = $wpdb->get_results($query,ARRAY_A);
            
            if ($result === NULL)
                $result = array();
        }

        return $result;
    }

    /**
     * Metodo: delete_subbmision
     *  
     * Borra los registros relacionados con el envio de un formulario, tanto de la tabla de datos
     * como de la tabla de envio.
     *
     * @param array $params La información de la petición.     
     * @return int/bool Devuelve el número de registros eliminados, 1 o false en caso de error.
     */
    function delete_submission($params){
        global $wpdb;

        $result = false;

        if (isset($params['id'])){

            $id = $params['id'];
            $condition = array(
                'idsubmit' => $id,
            );
            $result = $wpdb->delete($this->table_name_data_forms,$condition);
            if ($result !== false){
                $condition = array(
                    'id' => $id,
                );
                $result = $wpdb->delete($this->table_name_submited_forms,$condition);
                if ($result !== false)
                    $result = $this->get_last_page();
            }
        }
        return $result;
    }

    /**
     * Metodo: get_data_page
     *  
     * Obtiene una pagina de los datos generales de los formularios.
     *
     * @param array $params La información de la petición.     
     * @return array un array con la información correspondiente a las filas de los formularios.
     */
    function get_data_page($params){
        global $wpdb;

        $result = array();

        if (isset($params['page'])){
            $page = $params['page'];
            $init = ($page - 1 ) * $this->rows_per_page;
            $query ="SELECT * FROM ".$this->table_name_submited_forms." ORDER BY id DESC LIMIT ".$this->rows_per_page." OFFSET ".$init;
            $result = $wpdb->get_results($query,ARRAY_A);
//            error_log ('get_data_page - $result : '.var_export($result,true));

        }

        return $result;
    }

    /**
     * Metodo: submitted_form
     *  
     * Gestiona la recepción de la información de los formularios y actualiza la base de datos, con la 
     * información correspondiente.
     *
     * @param array $params La información de la petición.     
     * @return int El id correcpondiente al registro de la tabla de formularios enviados, que almacena el contexto del formulario.
     */
    function submitted_form($params){
        global $wpdb;
        
        $result = 0;
        
        if (isset($params['formId']) && isset($params['formName']) && isset($params['originUrl']) && isset($params['userAgent'])){
            
            
            $elements = $this->get_elements($params);
            $main_email = $this->get_main_email($elements);  // email sanitizado
            error_log ('Se ha ejecutado "submited_form", $elements: '.var_export($elements,true).PHP_EOL);
            
            $context = maybe_serialize(array('originUrl' => sanitize_text_field($params['originUrl']), 'userAgent' => sanitize_text_field($params['userAgent'])));

            $submited_form = array(
                'idform' => sanitize_text_field($params['formId']),
                'formname' => sanitize_text_field($params['formName']),
                'date' => date('Y-m-d H:m:s'),
                'email' => $main_email,
               'context' => $context               
            );

            $result = $wpdb->insert($this->table_name_submited_forms,$submited_form);

error_log ('Se ha ejecutado "submited_form", $submited_form: '.var_export($submited_form,true).' , $result: '.var_export($result,true).PHP_EOL);
//$wpdb->print_error();
//error_log ('Se ha ejecutado "submited_form", $submited_form: '.var_export($submited_form,true).' , $result: '.var_export($result,true).PHP_EOL);

            if ($result === false) {
                // Ocurrió un error durante la inserción
                $mensaje_error = $wpdb->last_error;
                error_log("Error al insertar en la tabla : $mensaje_error");
            } else {
                // Inserción exitosa
                $submited_id = $wpdb->insert_id;
                $this->insert_elements($elements,$submited_id);
                // Puedes realizar acciones adicionales si es necesario
                error_log("Datos insertados correctamente id del registro: $submited_id");
            }



        }

        return $result;
            
    }



    /**
	 * get_elements
	 * 
	 * Method to manage the access permissions to the endpoints
	 * only administrators can access
	 *
     * @param array Un array generado por la recepción con los parametros de la petición en la cual se incluye la información de 
     *              los elementos del formulario.
	 * @return array Un array de arrays que los cuales contienen la información de cada elemento enviado
	 */
	function get_elements($params){
        $resultado = array();

        $counter = 0;
        $identifier = 'Element'.$counter; 
        $expresionRegular = '/"([^"]+)"/';

        while ( isset($params[$identifier])){
                        
            preg_match_all($expresionRegular, $params[$identifier], $coincidencias);
            
            if (!empty($coincidencias[1])) {
                    $resultado[] = $coincidencias[1];
            }

            $counter++;
            $identifier = 'Element'.$counter; 
        }    


        return $resultado;
    }

    /**
	 * get_main_email
	 * 
	 * Metodo para obtener de un array de elementos, generado por la función get_elements,
     * el email principal, si existe.
	 *
     * @param array Un array generado por la función get_elements 
     *              
	 * @return string Una cadena con el email principal, o vacia si no existe.
	 */
	function get_main_email($elements){
        $main_email = '';
        $length = count($elements);
        $counter = 0;
        while (($counter < $length) && ($main_email == '')){
            if (isset($elements[$counter][0]) && isset($elements[$counter][3]))
                if (($elements[$counter][0] == 'email') && ($elements[$counter][3] == 'main'))
                    $main_email = sanitize_email($elements[$counter][2]);

            $counter++;
        }

        return $main_email;
    }

    /**
	 * insert_elements
	 * 
	 * Metodo para obtener de un array de elementos, generado por la función get_elements,
     * el email principal, si existe.
	 *
     * @param array Un array generado por la función get_elements, con los elementos a insertar 
     * @param int El id del registro de información general del formulario enviado al que se relacionan los elementos 
     *              
	 * @return string Una cadena con el email principal, o vacia si no existe.
	 */
	function insert_elements($elements,$id){

        global $wpdb;

        foreach($elements as $element){

            $data = array(
                'idsubmit' => $id,
                'typedata' => sanitize_text_field($element[0]),
                'namedata' => sanitize_text_field($element[1]),
                'contentdata' => sanitize_text_field($element[2])                    
            );
            switch($element[0]){
                case 'checkbox':
                    $data = array(
                        'idsubmit' => $id,
                        'typedata' => 'checkbox',
                        'namedata' => sanitize_text_field($element[1]),
                        'contentdata' => sanitize_text_field($element[2])                    
                    );
                    break;
                case 'text':
                    $data = array(
                        'idsubmit' => $id,
                        'typedata' => 'text',
                        'namedata' => sanitize_text_field($element[1]),
                        'contentdata' => sanitize_text_field($element[2])                    
                    );
                    break;
                case 'email':
                    $typedata = 'email';
                    if (isset($element[3]) && ($element[3] == 'main'))
                        $typedata = 'email_main';
                    $data = array(
                        'idsubmit' => $id,
                        'typedata' => $typedata,
                        'namedata' => sanitize_text_field($element[1]),
                        'contentdata' => sanitize_email($element[2])                    
                    );
                    break;
            }

            $result = $wpdb->insert($this->table_name_data_forms,$data);

            error_log ('Se ha ejecutado "insert_elements", $data: '.var_export($data,true).' , $result: '.var_export($result,true).PHP_EOL);

            if ($result === false) {
                // Ocurrió un error durante la inserción
                $mensaje_error = $wpdb->last_error;
                error_log("Error al insertar en la tabla : $mensaje_error");
            } else {
                // Inserción exitosa
                $data_id = $wpdb->insert_id;
                // Puedes realizar acciones adicionales si es necesario
                error_log("Datos insertados correctamente id del registro: $data_id");
            }

        }

    }


    /**
	 * get_last_page
	 * 
	 * Method to manage the access permissions to the endpoints
	 * only administrators can access
	 *
	 * @return void
	 */
	function get_last_page(){
        global $wpdb;
        $last_page = 0;

        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name_submited_forms;
        $result = $wpdb->get_results($query,ARRAY_A); 
        if(isset($result[0]) && isset($result[0]['total_rows']) && intval($result[0]['total_rows']) > 0){
            $last_page = (int)( $result[0]['total_rows'] / $this->rows_per_page );
            if (($result[0]['total_rows'] % $this->rows_per_page) !== 0)
                $last_page++; 
        }

        return $last_page;
    }


  /**
	 * get_permissions_check
	 * 
	 * Method to manage the access permissions to the endpoints
	 * only administrators can access
	 *
	 * @return void
	 */
	function get_permissions_check(){


        //	$user = wp_get_current_user();
    
        //	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //		if (! ( in_array('jardinero',$user->roles) || in_array('administrator',$user->roles) || in_array('editor',$user->roles)))
        //			return new WP_Error( 'rest_forbidden', esc_html__( 'OMG you can not view private data.', 'gsmtc-forms' ), array( 'status' => 401 ) );
        //	}
    
        
            return true;
        
    }
    
    /**
     * Method to inicialize gsmtc_forms
     */
    public function install_gsmtc_forms(){
        // Create tables in database, if not exists
        $this->create_tables();
        // Create custom styles dir, if not exists
//        if ( ! is_dir(GSMTC_FORMS_STYLES_DIR) ) mkdir(GSMTC_FORMS_STYLES_DIR);
//        add_option('gsmtc-forms-block-pattern-version',1);
                       
    }

   /**
     * Method to create the database tables
     */
    public function create_tables(){

        global $wpdb;

        /**
         * The forms table stores informatión about the indivudual forms 
         */
        $query_submited_forms = "CREATE TABLE IF NOT EXISTS " . $this->table_name_submited_forms . " (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            idform varchar(15)COLLATE utf8mb4_unicode_520_ci,
            formname varchar (256)COLLATE utf8mb4_unicode_520_ci,
            date varchar (20)COLLATE utf8mb4_unicode_520_ci,
            email varchar (256)COLLATE utf8mb4_unicode_520_ci,
            context text COLLATE utf8mb4_unicode_520_ci,
                                                
            PRIMARY KEY (id)
            ) DEFAULT CHARSET = utf8mb4 COLLATE=utf8mb4_unicode_520_ci;";
        
        /**
         * The data_forms table stores informatión about the content of every form 
         */
        $query_data_forms = "CREATE TABLE IF NOT EXISTS " . $this->table_name_data_forms . " (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            idsubmit bigint(20) unsigned NOT NULL,
            typedata varchar (50)COLLATE utf8mb4_unicode_520_ci,
            namedata varchar (50)COLLATE utf8mb4_unicode_520_ci,
            contentdata text COLLATE utf8mb4_unicode_520_ci,
            
            PRIMARY KEY (id)
            ) DEFAULT CHARSET = utf8mb4 COLLATE=utf8mb4_unicode_520_ci;";

        $wpdb->query($query_submited_forms);
        $wpdb->query($query_data_forms);

    }






}