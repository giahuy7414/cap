<?php

//prevent the module folder loading directly from browser
if (!defined('_PS_VERSION_'))
exit;
 
class SupplyOrderVoucherPDF extends Module
{

    public function __construct()
	{
	    $this->name = 'supplyordervoucherpdf';
	    $this->tab = 'others';
	    $this->version = '1.0';
	    $this->author = 'Huy Truong Gia';
	    $this->need_instance = 0;
	    $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.7');
	 
	    parent::__construct();
	 
	    $this->displayName = $this->l('Supply Order Voucher PDF');
	    $this->description = $this->l('Generate PDF File For Supply Order Voucher');
	 
	    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	 
	    if (!Configuration::get('supplyordervoucherpdf')) {      
	       $this->warning = $this->l('No name provided');
		}	
	}


    public function install()
    { 
      	//sql querry to create new supply order voucherr table
		$sql_installdb = 'CREATE TABLE `'._DB_PREFIX_.'supply_order_voucherr` ( `id_supply_order_voucher` INT UNSIGNED AUTO_INCREMENT , `id_supply_order` INT UNSIGNED NULL DEFAULT NULL , `id_supply_order_history` INT UNSIGNED NULL DEFAULT NULL , `date_add` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id_supply_order_voucher`))';

		//check the inintial installation of module 
		if (parent::install() == false){
			return false;
		} else {

			// check the existence of id_supply_order_voucher column in existing table, if yen then drop the column
			$check_column_id_supply_order_voucher = Db::getInstance()->executeS('SHOW COLUMNS FROM `'._DB_PREFIX_.'supply_order_receipt_history` LIKE \'id_supply_order_voucher\'');

			if (count($check_column_id_supply_order_voucher)>0) {
            Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'supply_order_receipt_history` DROP COLUMN `id_supply_order_voucher`');
			}

		//add new id_Supply_order_voucher column to supply_order_receipt_history table 
		Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'supply_order_receipt_history` ADD `id_supply_order_voucher` INT(10) AFTER `date_add` ');
		Db::getInstance()->Execute($sql_installdb);

		// register to moduleRoutes hook to autoload all the class of this modules. 
		return true && $this->registerHook('moduleRoutes');
		};
    }


    public function uninstall()
    {

		$sql_unistalldb = 'DROP TABLE `'._DB_PREFIX_.'supply_order_voucherr` ';

		if (parent::uninstall() == false){
			return false;
		} else {

			//check the existence of id_supply_order_voucher 
			$check_column_id_supply_order_voucher = Db::getInstance()->executeS('SHOW COLUMNS FROM `'._DB_PREFIX_.'supply_order_receipt_history` LIKE \'id_supply_order_voucher\'');

			//drop the id_supply_order_voucher column (if exist)
            if (count($check_column_id_supply_order_voucher)>0) {
               Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'supply_order_receipt_history` DROP COLUMN `id_supply_order_voucher`');
			}

			Db::getInstance()->Execute($sql_unistalldb);   
            Configuration::deleteByName('supplyordervoucherpdf') ;
            return true;

		} 
    }



	public function displayForm()
	{	
		$helper = new HelperForm();
		//get current selected employee group and shop in the system
		$POREF_Placeholder = Configuration::get('POREF_Placeholder');
		$GRNREF_Placeholder = Configuration::get('GRNREF_Placeholder');
		$VOUREF_Placeholder = Configuration::get('VOUREF_Placeholder');


		//get available shop and assign to checkbox options and check for its selected status in system, if yes then the option(s) need to be checked when render
		
		$helper->fields_value['idporef']  = $POREF_Placeholder;
		$helper->fields_value['idgrnref'] = $GRNREF_Placeholder;
		$helper->fields_value['idvouref'] = $VOUREF_Placeholder;


	    // Get default language
	    $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
	     
	    // Init Fields form array
	    $fields_form[0]['form'] = array(
	        'legend' => array(
	            'title' => $this->l('Settings'),
	        ),
	        'input' => array(
	            array(
	                'type' => 'text',
	                'label' => $this->l('PO Reference'),

	                'name' => 'idporef',
	                'required' => true
	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('GRN Reference'),
	                'name' => 'idgrnref',
	                'required' => true
	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('VOU Reference'),
	                'name' => 'idvouref',
	                'required' => true
	            )
	        ),
	        'submit' => array(
	            'title' => $this->l('Save'),
	            'class' => 'btn btn-default pull-right'
	        )
	    );
	    

	    
	    // Module, token and currentIndex
	    $helper->module = $this;
	    $helper->name_controller = $this->name;
	    $helper->token = Tools::getAdminTokenLite('AdminModules');
	    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
	     
	    // Language
	    $helper->default_form_language = $default_lang;
	    $helper->allow_employee_form_lang = $default_lang;
	     
	    // Title and toolbar
	    $helper->title = $this->displayName;
	    $helper->show_toolbar = true;        // false -> remove toolbar
	    $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
	    $helper->submit_action = 'submit'.$this->name;
	    $helper->toolbar_btn = array(
	        'save' =>
	        array(
	            'desc' => $this->l('Save'),
	            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
	            '&token='.Tools::getAdminTokenLite('AdminModules'),
	        ),
	        'back' => array(
	            'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
	            'desc' => $this->l('Back to list')
	        )
	    );
	     
	    return $helper->generateForm($fields_form);
	}


	public function getContent()
	{
	    $output = null;

	    if (Tools::isSubmit('submit'.$this->name))
	    {
	        if ($this->saveConfiguration()){
	            $output .= $this->displayConfirmation($this->l('Settings updated'));
	        }
	        
	    }

	    return $output.$this->displayForm();
	}

	public function saveConfiguration()
	{	
		$Success;
		if (Validate::isGenericName(Tools::getValue('idporef')) && Validate::isGenericName(Tools::getValue('idgrnref')) && Validate::isGenericName(Tools::getValue('idvouref')) ){
		    Configuration::updateValue('POREF_Placeholder',Tools::getValue('idporef'));
	        Configuration::updateValue('GRNREF_Placeholder',Tools::getValue('idgrnref'));
	        Configuration::updateValue('VOUREF_Placeholder',Tools::getValue('idvouref'));
	        $Success = true;
		} else {
			context::getContext()->controller->errors[] = 'Invalid character';
			$Success = false;
		}

		return $Success;
	    
	}



    //function to call the file contain the path to class that need to be loaded when running the moduel
    public function hookModuleRoutes() 
    {

		require_once  (_PS_MODULE_DIR_.'supplyordervoucherpdf'.DIRECTORY_SEPARATOR.'autoload'.DIRECTORY_SEPARATOR.'autoload.php');
		
    }


}
