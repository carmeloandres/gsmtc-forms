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
        // Ruta para gestionar la api de las petciones desde la plantilla jardinero
		register_rest_route('gsmtc-forms','form',array(
			'methods'  => 'POST',
			'callback' => array($this,'manage_api_request'),
//			'permission_callback' => true			
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
            
            $context = maybe_serialize(array('originUrl' => sanitize_text_field($params['originUrl']), 'userAgent' => sanitize_text_field($params['userAgent'])));
            
            $counter = 0;
            $identifier = 'Element'.$counter; 
            while ( isset($params[$identifier])){
                error_log ('Se ha ejecutado "submited_form", $identifier: '.var_export($identifier,true).' field content'.var_export($params[$identifier],true).' field type :'.gettype($params[$identifier]).PHP_EOL);
                $counter++;
                $identifier = 'Element'.$counter; 
            }    

            $submited_form = array(
                'idform' => sanitize_text_field($params['formId']),
                'formname' => sanitize_text_field($params['formName']),
                'date' => date('Y-m-d H:m:s'),
                'email' => '',
               'context' => $context               
            );

// Insertar los datos en la tabla
//            $result = $wpdb->insert($tabla, $datos_a_insertar, $formato_datos);


//            $query = "INSERT INTO ".$this->table_name_submited_forms." (idform, formname, date, email, context) VALUES ('".sanitize_text_field($params['formId'])."','".sanitize_text_field($params['formName'])."','".date('Y-m-d H:m:s')."','','".$context."')";
            
            $result = $wpdb->insert($this->table_name_submited_forms,$submited_form);
            //$result = $wpdb->query($query);
error_log ('Se ha ejecutado "submited_form", $submited_form: '.var_export($submited_form,true).' , $result: '.var_export($result,true).PHP_EOL);
//$wpdb->print_error();
//error_log ('Se ha ejecutado "submited_form", $submited_form: '.var_export($submited_form,true).' , $result: '.var_export($result,true).PHP_EOL);

            if ($result === false) {
                // Ocurrió un error durante la inserción
                $mensaje_error = $wpdb->last_error;
                error_log("Error al insertar en la tabla : $mensaje_error");
            } else {
                // Inserción exitosa
                $nueva_fila_id = $wpdb->insert_id;
                // Puedes realizar acciones adicionales si es necesario
                error_log("Datos insertados correctamente id del registro: $nueva_fila_id");
            }



        }

        return $result;
            
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