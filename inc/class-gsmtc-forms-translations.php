<?php

/**
 * Gsmtc_Forms_Translations
 * 
 * This class manage the validation pattern to use in frontend and in backend
 */
class Gsmtc_Forms_Translations{

    public $input_text_title;
	public $input_email_title;
	public $input_textarea_title;

	function __construct(){
        $this->input_text_title = __("The string must be between 0 and 249 characters and cannot contain '>' or '<'","gsmtc-forms");
		$this->input_email_title = __("enter a valid email address","gsmtc-forms");
		$this->input_textarea_title = __("The string must be between 0 and 249 characters and cannot contain '>' or '<'","gsmtc-forms");
    }
}
