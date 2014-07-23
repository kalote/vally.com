<!-- MODULE Slide Featured Products -->
<h2>{l s='new products' mod='slidenewproducts'}</h2>

<div id="slider">
	<div id="mover">
{if $new_products}			
	{counter start=0 assign=nbPrd}

		{foreach from=$new_products item=product name=myLoop}
			

			{if $nbPrd == 0}
				<div id="slide-1" class="slide">
			{else}
				<div class="slide">
			{/if}

			<h1><a href="{$product.link}" title="{$product.name|escape:htmlall:'UTF-8'|truncate:35}">{$product.name|escape:htmlall:'UTF-8'|truncate:35}</a></h1>
			<p class="product_desc"><a href="{$product.link}" title="{l s='More' mod='homefeatured'}">{$product.description_short|strip_tags:htmlall:'UTF-8'|truncate:70}</a></p>
			<h2>{displayWtPrice p=$product.price}</h2>
			<a href="{$product.link}" title="{$product.legend|escape:htmlall:'UTF-8'}" class="product_image"><img src="{$img_prod_dir}{$product.id_image}-home.jpg" alt="{$product.legend|escape:htmlall:'UTF-8'}" /></a>
			</div>

			{counter print=false}
		{/foreach}			
	{else}
		<p>{l s='No new product at this time' mod='slidenewproducts'}</p>
	{/if}
	</div>
</div>

<!-- /MODULE Home Featured Products -->