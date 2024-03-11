<?php

function gsmtc_forms_admin_translations(){
ob_start();
?>
{
                    "Please wait loading content...":"<?php echo __("Please wait loading content...","gsmtc-forms"); ?>",
                }
<?php
$output = ob_get_contents();
ob_end_clean();
return $output;

}
