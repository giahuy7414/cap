<?php
/**
 * 2007-2016 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author 	PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2016 PrestaShop SA
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

/**
 * @since 1.5
 */
class HTMLTemplateSupplyOrderVoucher extends HTMLTemplate
{
    public $supply_order;
    public $supply_order_voucher;
    public $warehouse;
    public $address_warehouse;
    public $address_supplier;
    public $context;
	public $grn=false;
	public $supply_order_voucher_products;

    /**
     * @param SupplyOrder $supply_order
     * @param $smarty
     * @throws PrestaShopException
     */



    public function __construct(SupplyOrderVoucher $supply_order_voucher, $smarty)
    {  
        $this->supply_order_voucher = $supply_order_voucher;
        $this->supply_order = new SupplyOrder((int)$this->supply_order_voucher->id);
        $this->smarty = $smarty;
        $this->context = Context::getContext();
        $this->warehouse = new Warehouse((int)$this->supply_order->id_warehouse);
        $this->address_warehouse = new Address((int)$this->warehouse->id_address);
        $this->address_supplier = new Address(Address::getAddressIdBySupplierId((int)$this->supply_order->id_supplier));
        $this->supply_order_voucher_products = $this->supply_order_voucher->getEntriesCollectionVoucher();

        // header informations
       // $this->date = Tools::displayDate($supply_order->date_add);
        $this->title = $this->l('Supply Order Voucher'); //XXX
		if (Tools::getValue('grn')==true)
		{
			$this->title = $this->l('Good Receive Note');
			$this->grn = true;
		}
        $this->shop = new Shop((int)$this->order->id_shop);
    }


/**
     * @see HTMLTemplate::getContent()
     */
    public function getContent()
    {  
  		
        $total_summary = $this->getTotalVoucherSummary();    
        $currency = new Currency((int)$this->supply_order->id_currency);

        $this->smarty->assign(array(
            'warehouse' => $this->warehouse,
            'address_warehouse' => $this->address_warehouse,
            'address_supplier' => $this->address_supplier,
            'supply_order' => $this->supply_order,
            'supply_order_voucher_products' => $this->supply_order_voucher_products,
            'total_summary' => $total_summary,
            'currency' => $currency,
        ));

     /*   $tpls = array(
            'style_tab' => $this->smarty->fetch($this->getTemplate('invoice.style-tab')),
            'addresses_tab' => $this->smarty->fetch($this->getTemplate('supply-order-voucher.addresses-tab')),
            'product_tab' => $this->smarty->fetch($this->getTemplate('supply-order-voucher.product-tab')),
        );
     */
          $tpls = array(
            'style_tab' => $this->smarty->fetch($this->getTemplate('invoice.style-tab')),
            'addresses_tab' => $this->smarty->fetch($this->getTemplate('supply-order-voucher.addresses-tab')),
            'product_tab' => $this->smarty->fetch($this->getTemplate('supply-order-voucher.product-tab')),
            'total_tab' => $this->smarty->fetch($this->getTemplate('supply-order-voucher.total-tab')),
        );
          
        $this->smarty->assign($tpls);

        return $this->smarty->fetch($this->getTemplate('supply-order-voucher'));
    }



protected function getTotalVoucherSummary()
    {	$total_ti = 0;
    	$total_te = 0;
    	$total_tax = 0;
    	$total_discount = 0;
    	$total_information;

    	foreach ($this->supply_order_voucher_products as $value) {
    		$total_te += $value['unit_price_dis_te']*$value['quantity'];
    		$total_ti += $value['total_item_price'];
    		$total_discount += $value['unit_price_te']*$value['quantity'] - $value['unit_price_dis_te']*$value['quantity'];
    	}
    	$total_tax = $total_ti - $total_te;

    	$total_information = array('total_te' => $total_te,'total_ti' => $total_ti,'total_tax' => $total_tax,'total_discount' => $total_discount );


        return $total_information;
    }




    /**
     * Returns the invoice logo
     *
     * @return String Logo path
     */
    protected function getLogo()
    {
        $logo = '';

        if (Configuration::get('PS_LOGO_INVOICE', null, null, (int)Shop::getContextShopID()) != false && file_exists(_PS_IMG_DIR_.Configuration::get('PS_LOGO_INVOICE', null, null, (int)Shop::getContextShopID()))) {
            $logo = _PS_IMG_DIR_.Configuration::get('PS_LOGO_INVOICE', null, null, (int)Shop::getContextShopID());
        } elseif (Configuration::get('PS_LOGO', null, null, (int)Shop::getContextShopID()) != false && file_exists(_PS_IMG_DIR_.Configuration::get('PS_LOGO', null, null, (int)Shop::getContextShopID()))) {
            $logo = _PS_IMG_DIR_.Configuration::get('PS_LOGO', null, null, (int)Shop::getContextShopID());
        }

        return $logo;
    }

    /**
     * @see HTMLTemplate::getBulkFilename()
     */
    public function getBulkFilename()
    {
        return 'supply_order_voucher.pdf';
    }

    /**
     * @see HTMLTemplate::getFileName()
     */
    public function getFilename()
    {   if ($this->grn == false)
        {
            return self::l('SupplyOrderVoucher').sprintf('_%s', $this->supply_order->reference).'.pdf';
        }
        else
        {
            return self::l('GoodReceiveNote').sprintf('_%s', $this->supply_order->reference).'.pdf';
        }

    }

    /**
     * Get order taxes summary
     *
     * @return array|false|mysqli_result|null|PDOStatement|resource
     * @throws PrestaShopDatabaseException
     */

   

    /**
     * @see HTMLTemplate::getHeader()
     */
    public function getHeader()
    {  
        $date_add =  $this->supply_order_voucher->date_add;
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $path_logo = $this->getLogo();
        $width = $height = 0;
    
        

        if (!empty($path_logo)) {
            list($width, $height) = getimagesize($path_logo);
        }

        $this->smarty->assign(array(
            'logo_path' => $path_logo,
            'img_ps_dir' => 'http://'.Tools::getMediaServer(_PS_IMG_)._PS_IMG_,
            'img_update_time' => Configuration::get('PS_IMG_UPDATE_TIME'),
            'title' => $this->title,
            'reference' => $this->supply_order->reference,
            'id_vou' =>  $this->supply_order_voucher->id,
            'reference' => $this->supply_order->reference,
            'date' => $this->supply_order_voucher->date_add, //XXX
            'shop_name' => $shop_name,
            'width_logo' => $width,
            'height_logo' => $height,
            'grn' => $this->grn
        ));

        return $this->smarty->fetch($this->getTemplate('supply-order-voucher-header'));
    }

    /**
     * @see HTMLTemplate::getFooter()
     */
    public function getFooter()
    {
        $this->address = $this->address_warehouse;
        $free_text = array();
        $free_text[] = $this->l('TE: Tax excluded');
        $free_text[] = $this->l('TI: Tax included');

        $this->smarty->assign(array(
            'shop_address' => $this->getShopAddress(),
            'shop_fax' => Configuration::get('PS_SHOP_FAX'),
            'shop_phone' => Configuration::get('PS_SHOP_PHONE'),
            'shop_details' => Configuration::get('PS_SHOP_DETAILS'),
            'free_text' => $free_text,
        ));
        return $this->smarty->fetch($this->getTemplate('supply-order-voucher-footer'));
    }





     /**
     * Rounds values of a SupplyOrderVoucher object
     *
     * @param array|PrestaShopCollection $collection
     */
    protected function roundSupplyOrderVoucher(&$collection)
    {
        foreach ($collection as $supply_order_detail) {
            /** @var SupplyOrderDetail $supply_order_detail */
            $supply_order_voucher->price_te = Tools::ps_round($supply_order_detail->price_te, 2);
        }
    }

  
}
