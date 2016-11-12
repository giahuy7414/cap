<?php
/*
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * History of receipts
 * @since 1.5.0
 */
class SupplyOrderVoucher extends ObjectModel
{
    /**
     * @var int id of supply order
     */

    /**
     * @var int id of supply order history
     */

    /**
     * @var int id of supply order
     */



    public $id_supply_order;

    public $id_supply_order_history;

    public $date_add;


    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'supply_order_voucherr',
        'primary' => 'id_supply_order_voucher',
        'fields' => array(
             'id_supply_order' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => false),
             'id_supply_order_history' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => false),
             'date_add' =>                   array('type' => self::TYPE_DATE, 'validate' => 'isDate')
        ),
    );


    /**
     * @see ObjectModel::$webserviceParameters
     */
    protected $webserviceParameters = array(
        'objectsNodeName' => 'supply_order_vouchers',
        'objectNodeName' => 'supply_order_voucher',
        'fields' => array(
            'id_supply_order' => array('xlink_resource' => 'supply_orders'),
            'id_supply_order_history' => array('xlink_resource' => 'supply_order_histories'),
        ),
    );



    //Function to get all supply order receipt conresponding with the supply order voucher
    public function getEntriesCollectionVoucher()
    {
        $query = new DbQuery();
        $query->select('id_employee as empid, concat(employee_lastname,\' \',employee_firstname) as empname,date_add,name, upc, reference,quantity, quantity_expected,
            case (unit_price_te mod 1 > 0) 
            when true then round(unit_price_te, 3)
            else round(unit_price_te, 0)  
            end as unit_price_te,
                         
            case (discount_rate mod 1 > 0) 
            when true then concat(round(discount_rate, 1),\'%\')
            else concat(round(discount_rate,0),\'%\')
            end as discount,
                         
            case ((price_with_discount_te/quantity_expected) mod 1 > 0) 
            when true then round(price_with_discount_te/quantity_expected, 3)
            else round(price_with_discount_te/quantity_expected,0)
            end as unit_price_dis_te,
            concat(round(tax_rate),\'%\') as tax_rate,

            case ((price_ti/quantity_expected) mod 1 > 0) 
            when true then round((price_ti/quantity_expected), 3)
            else round((price_ti/quantity_expected), 0)  
            end as unit_price_dis_ti,
                         
            case ((quantity*(price_ti/quantity_expected)) mod 1 > 0) 
            when true then round((quantity*(price_ti/quantity_expected)), 3)
            else round((quantity*(price_ti/quantity_expected)), 0)  
            end as total_item_price
            ');

        $query->from('supply_order_receipt_history', 'a');
        $query->join('INNER JOIN '._DB_PREFIX_.'supply_order_detail b ON (`a`.id_supply_order_detail=`b`.id_supply_order_detail)');
        $query->where('a.`id_supply_order_voucher` = '.(int)$this->id);
           
        $supply_order_voucher_products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
        return $supply_order_voucher_products;
    }


}
