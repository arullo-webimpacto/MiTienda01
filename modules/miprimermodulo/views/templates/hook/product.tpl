{*
* 2007-2020 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div class="row">
	<div class="col-md-6">
        <div class="images-container">
			{block name='product_cover'}
				{include file='C:/xampp/htdocs/mitienda/themes/classic/templates/catalog/_partials/product-cover-thumbnails.tpl'}
				{* <div class="product-cover">
				{if $product.cover}
					<img class="js-qv-product-cover" src="{$product.cover.bySize.large_default.url}" alt="{$product.cover.legend}" title="{$product.cover.legend}" style="width:100%;" itemprop="image">
					<div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal">
					<i class="material-icons zoom-in">&#xE8FF;</i>
				</div>
				{/if}
				</div> *}
			{/block}
		</div>
    </div>
	<div class="col-md-6">
        <h1>{$texto_variable}</h1>
		<h1> Producto: {$product.name}</h1>
		<h1> ID_categoria: {$product.id_category_default}</h1>
		<h1> NAME_categoria: {$product.category_name}</h1>
    </div>
</div>

