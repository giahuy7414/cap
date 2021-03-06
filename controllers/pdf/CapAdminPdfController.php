<?php
 /*include_once(_PS_MODULE_DIR_.'supplyordervoucherpdf'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'HTMLTemplateSupplyOrderVoucher.php');
 include_once(_PS_MODULE_DIR_.'supplyordervoucherpdf'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'SupplyOrderVoucher.php');*/
class AdminPdfController extends AdminPdfControllerCore
{
    /*
    * module: supplyordervoucherpdf
    * date: 2016-11-06 01:50:54
    * version: 1.0
    */
	
    /*
    * module: supplyordervoucherpdf
    * date: 2016-11-06 01:50:54
    * version: 1.0
    */
	
    /*
    * module: supplyordervoucherpdf
    * date: 2016-11-06 01:50:54
    * version: 1.0
    */
	
    /*
    * module: supplyordervoucherpdf
    * date: 2016-11-06 01:50:54
    * version: 1.0
    */
	
    /*
    * module: supplyordervoucherpdf
    * date: 2016-11-06 01:50:54
    * version: 1.0
    */
    /*
    * module: supplyordervoucherpdf
    * date: 2016-11-07 08:52:13
    * version: 1.0
    */
    /*
    * module: supplyordervoucherpdf
    * date: 2016-11-07 22:30:18
    * version: 1.0
    */
    public function processGenerateSupplyOrderVoucherPDF()
    {

        if (!Tools::isSubmit('id_supply_order_voucher')) {
            die(Tools::displayError('The supply order voucher ID is missing.'));
        }
        $id_supply_order_voucher = (int)Tools::getValue('id_supply_order_voucher');
        $supply_order_voucher = new SupplyOrderVoucher($id_supply_order_voucher);
        if (!Validate::isLoadedObject($supply_order_voucher)) {
            die(Tools::displayError('The supply order voucher cannot be found within your database.'));
        }
       
        parent::generatePDF($supply_order_voucher, CapPDF::TEMPLATE_SUPPLY_ORDER_VOUCHER);
    }
	
}
?>