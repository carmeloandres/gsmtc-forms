<?php

/**
 * compilar
 * 
 * Esta clase contiene toda la funcionalidad para crear la estructura de traducciones en la compilación
 */
class Compilar{

    public $nombre_base;
    public $directorio_padre;
    public $text_domain;

    function __construct($text_domain = ''){
        $this->text_domain = $text_domain;
        $this->directorio_padre =  dirname(pathinfo(__FILE__)['dirname']);
        $longitud = strlen($this->directorio_padre);
        $nombre_directorio_local = substr(pathinfo(__FILE__)['dirname'],$longitud+1);
        $vector = explode('-',$nombre_directorio_local);
        $this->nombre_base = $vector[1];
    }
    
    function get_translation_args($folder,$text_domain,){
        $arguments = array();
        // file name for translations file.
        $file_name = $text_domain.'-translations.php';
        $words = explode('-',$text_domain);
        $function_name = '';
        foreach($words as $word){
            if ($function_name == '')
                $function_name = $word;
            else $function_name = $function_name.'_'.$word;
        }
        $function_name = $function_name.'_translations';
        $fichero = fopen($folder.'\\'.$file_name,'r');
        $linea = fgets($fichero);
        while ($linea !== false){
            $primeras_comillas = strpos($linea,'"',0);
            $segundas_comillas = strpos($linea,'"',$primeras_comillas + 1);
            if (is_int($primeras_comillas) && is_int($segundas_comillas)){
                $longitud = $segundas_comillas - $primeras_comillas + 1;
                $nuevo_argumento = substr($linea,$primeras_comillas,$longitud);
                $arguments[] = str_replace('"',"'",$nuevo_argumento);
            }
            $linea = fgets($fichero);
        }

        return $arguments;
    
    }



    function create_translation_file($folder,$text_domain,$arguments){
        // file name for translations file.
        $words = explode('-',$text_domain);
        $file_name = $words[0].'-'.$this->nombre_base.'-translations.php';
        $function_name = $words[0].'_'.$this->nombre_base;
        $function_name = $function_name.'_translations';
        $fichero = fopen($folder.'\\'.$file_name,'w');
        fputs($fichero,'<?php'.PHP_EOL);
        fputs($fichero,PHP_EOL);
        fputs($fichero,'function '.$function_name.'(){'.PHP_EOL);
        fputs($fichero,'?>'.PHP_EOL);
        fputs($fichero,'{'.PHP_EOL);
        foreach($arguments as $argument){
            $cadena = "                    ".$argument.":'<?php echo __(".$argument.",'".$text_domain."'); ?>',".PHP_EOL;
            fputs($fichero,str_replace("'",'"',$cadena));
        }
        fputs($fichero,'                }'.PHP_EOL);
        fputs($fichero,'<?php'.PHP_EOL);
        fputs($fichero,PHP_EOL);
        fputs($fichero,'}'.PHP_EOL);
        fclose($fichero);
            
        // file name for version file.
        $version_name = $text_domain.'-version.php';
        $version = 1;
        if (file_exists($folder.'\\'.$version_name)){
            $dependencies = include_once($folder.'\\'.$version_name);
            $version =  intval($dependencies['version'],10);
            $version++;
        }

        $fichero = fopen($folder.'\\'.$version_name,'w');
        fputs($fichero,"<?php return array('version' => '".$version."');".PHP_EOL);
        fclose($fichero);

    }

    function get_new_arguments_folder($folder,$arguments = []){
        $new_arguments = $arguments;
        if (is_dir($folder)){
            $manejador = opendir($folder);
            while (false !== ($file = readdir($manejador))){
                if ( str_ends_with($file,'.jsx')){
                    echo 'analising file :'.$file.PHP_EOL;
                    $new_arguments = $this->get_new_arguments_file($folder.'\\'.$file,$new_arguments);

                } else {
                    if (is_dir($folder.'\\'.$file) && ($file != '.') && ($file != '..')){
                        echo 'reading folder :'.$file.PHP_EOL;                    
                        $new_arguments = $this->get_new_arguments_folder($folder.'\\'.$file,$new_arguments); 
                    } else echo 'omiting :'.$file.PHP_EOL;
                }
            }
        }
        return $new_arguments;
    }
    function get_new_arguments_file($file,$arguments){
        $new_arguments = $arguments;

        if (is_file($file)){
           $fichero = fopen($file,"r"); 
           if ($fichero !== false){
            $linea = fgets($fichero);
            while ($linea !== false){
                $argumentos = $this->get_line_arguments($linea);
                $arguments_auxiliar = $new_arguments;
                foreach($argumentos as $argumento){
                    $encontrado = false;
                    foreach($arguments_auxiliar as $argument)
                        if ($argumento == $argument)
                            $encontrado = true;
                    if (! $encontrado)
                    $new_arguments[] = $argumento;
                }
                $linea = fgets($fichero);   
            }
           }
        }

        return $new_arguments;
    }

    function get_line_arguments($linea){
        $arguments = [];
        $offset = 0;
        $posicion = strpos($linea,"__(",$offset);
        while($posicion !== false){
            $primera_coma = strpos($linea,"'",$posicion);
            $segunda_coma = strpos($linea,"'",$primera_coma + 1);
            if (is_int($primera_coma) && is_int($segunda_coma)){
                $longitud = $segunda_coma - $primera_coma + 1;
                // Comprobamos que los argumentos no sean iguales
                $encontrado = false;
                $nuevo_argumento = substr($linea,$primera_coma,$longitud);
                foreach($arguments as $argument)
                    if ($nuevo_argumento == $argument)
                        $encontrado = true;
                if (! $encontrado)
                    $arguments[] = $nuevo_argumento;
            }
            $posicion = strpos($linea,"__(",$posicion + 1);
        }
        return $arguments;
    }

	/**
	 * increment_version
	 *
	 * Este metodo abre el fichero index.php del plugin y busca si se ha definido la constante para la version
     * en caso de encontrarla la incrementa.
     * La constante para la versión tiene que depender del text-domain, 
     * ejemplo: text-domain 
     * Constante: TEXT_DOMAIN_VERSION
	 * 
	 * @param  mixed $params
	 * @return json 
	 */
    function increment_version(){
        // Si el text-domain no esta vacio
        if ($this->text_domain != ''){
            // genera un arry con las palabras del text domain
            $words = explode('-',$this->text_domain);
            $constante = '';
            foreach($words as $word)
                if ($constante == '')
                    $constante = strtoupper($word);
                else $constante = $constante.'_'.strtoupper($word);

            $constante = $constante.'_VERSION';
            $cadena_a_buscar = "if ( ! defined('".$constante."')) define ('".$constante."',";
//            echo 'Cadena a buscar : '.$cadena_a_buscar;
            $longitud_cadena_a_buscar = strlen($cadena_a_buscar);
            // nombre del fichero inicial del plugin
            $fichero_index = $this->directorio_padre.'/index.php';
            $contenido = file_get_contents($fichero_index);
            $posicion_inicial = strpos($contenido, $cadena_a_buscar);
            $posicion_siguiente = strpos($contenido,')',$posicion_inicial + $longitud_cadena_a_buscar);
            $longitud_substring = $posicion_siguiente - ($posicion_inicial + $longitud_cadena_a_buscar);
            $version = substr($contenido,$posicion_inicial + $longitud_cadena_a_buscar,$longitud_substring);
            if (is_int(intval($version,10))){
                $nueva_version = intval($version,10) + 1;
                $cadena_a_sustituir = $cadena_a_buscar.$version.');';
                $cadena_substituta = $cadena_a_buscar.$nueva_version.');';
                $contenido_nuevo = substr_replace($contenido,$cadena_substituta,$posicion_inicial,strlen($cadena_a_sustituir));
                file_put_contents($fichero_index,$contenido_nuevo);
            }

//            echo 'version actual :'.$version;
            

        }

    }
}