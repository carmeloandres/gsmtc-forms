<?php

function gsmtc_forms_admin_translations(){
ob_start();
?>
{
                    "Email":"<?php echo __("Email","gsmtc-forms"); ?>",
                    "Main email":"<?php echo __("Main email","gsmtc-forms"); ?>",
                    "Text":"<?php echo __("Text","gsmtc-forms"); ?>",
                    "Form name":"<?php echo __("Form name","gsmtc-forms"); ?>",
                    "Date of submission form":"<?php echo __("Date of submission form","gsmtc-forms"); ?>",
                    "Main email of subnission":"<?php echo __("Main email of subnission","gsmtc-forms"); ?>",
                    "Actions":"<?php echo __("Actions","gsmtc-forms"); ?>",
                    "are you sure to deleting the data form submission":"<?php echo __("are you sure to deleting the data form submission","gsmtc-forms"); ?>",
                    "Please wait loading content...":"<?php echo __("Please wait loading content...","gsmtc-forms"); ?>",
                    "Type":"<?php echo __("Type","gsmtc-forms"); ?>",
                    "Name":"<?php echo __("Name","gsmtc-forms"); ?>",
                    "Content":"<?php echo __("Content","gsmtc-forms"); ?>",
                    "Deleting de submission data form":"<?php echo __("Deleting de submission data form","gsmtc-forms"); ?>",
                    "The data has been deleted successfull":"<?php echo __("The data has been deleted successfull","gsmtc-forms"); ?>",
                    "The data has not been deleted":"<?php echo __("The data has not been deleted","gsmtc-forms"); ?>",
                    "Forms submission data":"<?php echo __("Forms submission data","gsmtc-forms"); ?>",
                }
<?php

$output = ob_get_contents();

ob_end_clean();

return $output;

}
