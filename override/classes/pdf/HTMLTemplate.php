<?php
abstract class HTMLTemplate extends HTMLTemplateCore
{ 
    /*
    * module: supplyordervoucherpdf
    * date: 2016-11-06 01:50:53
    * version: 1.0
    */

    /*
    * module: supplyordervoucherpdf
    * date: 2016-11-06 01:50:53
    * version: 1.0
    */
    /*
    * module: supplyordervoucherpdf
    * date: 2016-11-07 08:52:12
    * version: 1.0
    */
    protected function getTemplate($template_name)
    {
        $template = false;
        $overridden_templates = array();
        
            $module_name = Context::getContext()->controller->module->name;
            $overridden_templates[] = rtrim(_PS_PDF_DIR_, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$template_name.'.tpl';
            $overridden_templates[] = _PS_MODULE_DIR_.DIRECTORY_SEPARATOR.'supplyordervoucherpdf'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.$template_name.'.tpl'; // In Module itself
        p($overridden_templates);
        
       
        foreach ($overridden_templates as $overridden_template) {
   
            if (file_exists($overridden_template)) {
                $template = $overridden_template;
                break;
            }
        }
      
        return $template;
    }
}
 
?>
