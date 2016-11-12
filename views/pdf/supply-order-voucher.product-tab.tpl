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
{l s='Products received:' pdf='true'    mod='supplyordervoucherpdf'}<br/>

<table class="product small" align="left" width="100%" cellpadding="4" cellspacing="0">

	<thead>
	<tr>
		<th class="product header small" width="14%">{l s='Name'   mod='supplyordervoucherpdf'}</th>
		<th class="product header small" width="10%">{l s='UPC'   mod='supplyordervoucherpdf'}</th>
		<th class="product header small" width="10%">{l s='REF'   mod='supplyordervoucherpdf'}</th>
	<!--	<th class="product header small" width="10%">{l s='QUANTITY EXPECTED'   mod='supplyordervoucherpdf'}</th> -->
		<th class="product header small" width="11%">{l s='QUANTITY RECEIVED'   mod='supplyordervoucherpdf'} <br /> </th>
		<th class="product header small" width="15%">{l s='UNIT PRICE TE'   mod='supplyordervoucherpdf'}</th>
		<!--<th class="product header small" width="15%">{l s='DISCOUNT %'   mod='supplyordervoucherpdf'}</th> -->
		<th class="product header small" width="15%">{l s='UNIT PRICE DIS TE'   mod='supplyordervoucherpdf'}</th>
	<!--	<th class="product header small" width="15%">{l s='TAX RATE %'   mod='supplyordervoucherpdf'}</th>-->
		<th class="product header small" width="15%">{l s='UNIT PRICE DIS TI'   mod='supplyordervoucherpdf'}</th>
		<th class="product header small" width="15%">{l s='TOTAL ITEM PRICE'   mod='supplyordervoucherpdf'}</th>
	</tr>
	</thead>

	<tbody>

	{foreach $supply_order_voucher_products as $supply_order_voucher_product}
			{cycle values=["color_line_even", "color_line_odd"] assign=bgcolor_class}
			<tr class="product {$bgcolor_class}">

				<td class="product center">
				{$supply_order_voucher_product.name}
				</td>
				<td class="product center">
					{$supply_order_voucher_product.upc}
				</td>
				<td class="product center">
					{$supply_order_voucher_product.reference}
				</td>
			<!--	<td  class="product center">
					{$supply_order_voucher_product.quantity_expected}
				</td>
			-->	
				<td  class="product center">
					{$supply_order_voucher_product.quantity}
				</td>
				<td class="product center">
					{$currency->prefix} {$supply_order_voucher_product.unit_price_te}{$currency->suffix}
				</td>
		
		<!--		<td class="product center">
					{$supply_order_voucher_product.discount}
				</td>
		-->
				<td class="product center">
					{$currency->prefix} {$supply_order_voucher_product.unit_price_dis_te}{$currency->suffix}
				</td>
		<!--		<td class="product center">
					{$supply_order_voucher_product.tax_rate}
			</td>
		-->	
				<td  class="product center">
					{$currency->prefix} {$supply_order_voucher_product.unit_price_dis_ti} {$currency->suffix}
				</td>
				<td  class="product center">
					{$currency->prefix} {$supply_order_voucher_product.total_item_price} {$currency->suffix}
				</td>
			</tr>
		
	{/foreach}

	</tbody>

</table>
