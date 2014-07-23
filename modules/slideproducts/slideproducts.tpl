<!-- MODULE Slide Featured Products -->
<h2>{l s='featured products' mod='slideproducts'}</h2>

<div id="slider">
	<div id="mover">
			
	{if isset($products) AND $products}

	{counter start=0 assign=nbPrd}

		{foreach from=$products item=value}
			
			{assign var='productLink' value=$link->getProductLink($value.id_product, $value.link_rewrite)}
			
			{if isset($value.attributes_small)}
				{assign var='productName' value=$value.name|cat:' ':$value.attributes_small|truncate:36}
			{else}
				{assign var='productName' value=$value.name|truncate:36}
			{/if}

			{if $nbPrd == 0}
				<div id="slide-1" class="slide">
			{else}
				<div class="slide">
			{/if}

			<h1><a href="{$productLink}" title="{$value.name|escape:htmlall:'UTF-8'|truncate:35}">{$value.name|escape:htmlall:'UTF-8'|truncate:35}</a></h1>
			<p class="product_desc"><a href="{$productLink}" title="{l s='More' mod='homefeatured'}">{$value.description_short|strip_tags:htmlall:'UTF-8'|truncate:70}</a></p>
			<h2>{displayWtPrice p=$value.price}</h2>
			<a href="{$productLink}" title="{$product.legend|escape:htmlall:'UTF-8'}" class="product_image"><img src="{$img_prod_dir}{$value.id_image}-home.jpg" alt="{$product.legend|escape:htmlall:'UTF-8'}" /></a>
			</div>

			{counter print=false}
		{/foreach}			

	</div>
</div>

	{else}
		{l s='No featured products' mod='slidefeatured'}
	{/if}

<!-- /MODULE Home Featured Products -->