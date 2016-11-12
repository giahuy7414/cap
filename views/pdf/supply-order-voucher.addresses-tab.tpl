{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<table id="addresses-tab" cellspacing="0" cellpadding="0">
	<tr>
		<td width="40%"><span class="bold"> </span><br/><br/>
			
{l s='Warehouse Name'   mod='supplyordervoucherpdf'}{$warehouse->name}<br/>
{l s='Warehouse Address'   mod='supplyordervoucherpdf'}{$address_warehouse->address1}<br/>
			{if !empty($address_warehouse->address2)}
{l s='Warehouse Address 2'   mod='supplyordervoucherpdf'}{$address_warehouse->address2}<br/>{/if}
		</td>
		<td width="20%">&nbsp;</td>
		<td width="40%"><span class="bold"> </span><br/><br/>	
{l s='Supplier Name'   mod='supplyordervoucherpdf'}{$supply_order->supplier_name}<br/>		
{l s='Supplier Address'   mod='supplyordervoucherpdf'}{$address_supplier->address1}<br/>
			{if !empty($address_supplier->address2)}
{l s='Supplier Address 2'   mod='supplyordervoucherpdf'}{$address_supplier->address2}<br/>{/if}
			{$address_supplier->postcode} {$address_supplier->city}<br/>
			{$address_supplier->country}
		</td>
	</tr>
</table>
