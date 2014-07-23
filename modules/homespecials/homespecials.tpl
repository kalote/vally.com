<!-- MODULE Block specials 2, edited by Nemo to hook in center column -->
<div id="special_products_block_center" class="block products_block clearfix">
	<h4><a href="{$link->getPageLink('prices-drop.php')}" title="{l s='Specials' mod='blockspecials'}">{l s='Home Specials' mod='homespecials'}</a></h4>
	{if isset($special) AND $special}
		<div class="block_content">
			{assign var='liHeight' value=250}
			{assign var='nbItemsPerLine' value=4}
			{assign var='nbLi' value=$special|@count}
			{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
			{math equation="nbLines*liHeight" nbLines=$nbLines|ceil liHeight=$liHeight assign=ulHeight}
			<ul style="height:{$ulHeight}px;">
			{foreach from=$special item=product name=homeSpecialProducts}
				<li class="ajax_block_product {if $smarty.foreach.homeSpecialProducts.first}first_item{elseif $smarty.foreach.homeSpecialProducts.last}last_item{else}item{/if} {if $smarty.foreach.homeSpecialProducts.iteration%$nbItemsPerLine == 0}last_item_of_line{elseif $smarty.foreach.homeSpecialProducts.iteration%$nbItemsPerLine == 1} {/if} {if $smarty.foreach.homeSpecialProducts.iteration > ($smarty.foreach.homeSpecialProducts.total - ($smarty.foreach.homeSpecialProducts.total % $nbItemsPerLine))}last_line{/if}">
					<a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_image"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home')}" height="{$homeSize.height}" width="{$homeSize.width}" alt="{$product.name|escape:html:'UTF-8'}" />{if isset($product.new) && $product.new == 1}<span class="new">{l s='New'}</span>{/if}</a>
					<h5><a href="{$product.link}" title="{$product.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h5>
					<div class="product_desc"><a href="{$product.link}" title="{l s='More' mod='homespecials'}">{$product.description_short|strip_tags|truncate:65:'...'}</a></div>
					<div>
						<a class="lnk_more" href="{$product.link}" title="{l s='View' mod='homespecials'}">{l s='View' mod='homespecials'}</a>
						<!-- Adding modification by Nemo: product discounts -->	
						{if isset($product.qty_discounts) && $product.qty_discounts}
							{foreach from=$product.qty_discounts item=qt_disc}
								{$qty_taxed = ($qt_disc.price/100)*$product.rate}
								{math equation= "a + b" a=$qt_disc.price b=$qty_taxed assign=correct_disc}
								{if $correct_disc < $product.price} {$product.price = $correct_disc}{$product.price_tax_exc = $qt_disc.price}{/if}

							{/foreach}
						{/if}				
						<!-- /Adding modification by Nemo: product discounts -->
						{if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}<p class="price_container">{l s='As low as'} <span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span></p>{else}<div style="height:21px;"></div>{/if}
						
						{if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}
							{if ($product.quantity > 0 OR $product.allow_oosp)}
							<a class="exclusive ajax_add_to_cart_button" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart.php')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='homespecials'}">{l s='Add to cart' mod='homespecials'}</a>
							{else}
							<span class="exclusive">{l s='Add to cart' mod='homespecials'}</span>
							{/if}
						{else}
							<div style="height:23px;"></div>
						{/if}
					</div>
				</li>
			{/foreach}
			</ul>
		</div>
	{else}
		<p>{l s='No special price products' mod='homespecials'}</p>
	{/if}
</div>
<!-- /MODULE Block specials -->