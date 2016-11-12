<?php

class AdminPdfController extends AdminPdfControllerCore
{
    
    //Function to get Supply Order Voucher Template

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
