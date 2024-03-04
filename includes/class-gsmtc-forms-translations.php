<?php

/**
 * Gsmtc_Forms_Translations
 * 
 * This class manage the validation pattern to use in frontend and in backend
 */
class Gsmtc_Forms_Translations{

    public $input_text_title;
	public $input_email_title;
	public $expresion_fecha;
	public $expresion_texto;
	public $expresion_decimal;
	public $expresion_telefono;
	public $expresion_telefonoextendido;
	public $expresion_colorhexadecimal;

	function __construct(){
        $this->input_text_title = __("The string must be between 0 and 249 characters and cannot contain '>' or '<'","gsmtc-forms");
		$this->input_email_title = __("enter a valid email address","gsmtc-forms");
		$this->expresion_fecha = '/^[2][0][0-9]{2}-[0-1][0-9]-[0-3][0-9]$/';
		$this->expresion_texto = '/^[\n\r0-9a-zñA-ZÑáéíóúºª ,-.:\/\(\)\']{0,200}$/';
		$this->expresion_decimal = '/^[0-9.-]{1,7}$/';
		$this->expresion_telefono= '/^[0-9]{1,9}$/';
		$this->expresion_telefonoextendido = '/^[0-9+. ()-]{1,30}$/';
		$this->expresion_colorhexadecimal = '/^#[A-Fa-f0-9]{6}$/';
    }
}
