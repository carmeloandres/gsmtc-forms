<?php

/**
 * Gsmtc_Forms_Patterns
 * 
 * This class manage the validation pattern to use in frontend and in backend
 */
class Gsmtc_Forms_Patterns{

	public $input_text_pattern;
    public $input_text_title;
	public $expresion_nombre;
	public $expresion_fecha;
	public $expresion_texto;
	public $expresion_decimal;
	public $expresion_telefono;
	public $expresion_telefonoextendido;
	public $expresion_colorhexadecimal;

	function __construct(){

		$this->input_text_pattern ="^[a-zA-Z0-9\s'\"\?!]+$"; //in frontend"^[a-zA-Z0-9\s'\"\?!]+$"
        $this->input_text_title = __("Letters, numbers, question marks and exclamation marks","gsmtc-forms");
		$this->expresion_nombre = '/^[a-zñA-ZÑáéíóú0-9\' -]{0,120}$/';
		$this->expresion_fecha = '/^[2][0][0-9]{2}-[0-1][0-9]-[0-3][0-9]$/';
		$this->expresion_texto = '/^[\n\r0-9a-zñA-ZÑáéíóúºª ,-.:\/\(\)\']{0,200}$/';
		$this->expresion_decimal = '/^[0-9.-]{1,7}$/';
		$this->expresion_telefono= '/^[0-9]{1,9}$/';
		$this->expresion_telefonoextendido = '/^[0-9+. ()-]{1,30}$/';
		$this->expresion_colorhexadecimal = '/^#[A-Fa-f0-9]{6}$/';
    }
}
