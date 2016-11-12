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





    //function to call the file contain the path to class that need to be loaded when running the moduel
    public function hookModuleRoutes() 
    {

		require_once  (_PS_MODULE_DIR_.'supplyordervoucherpdf'.DIRECTORY_SEPARATOR.'autoload'.DIRECTORY_SEPARATOR.'autoload.php');
		
    }


}
