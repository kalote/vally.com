<div class="clearfix clear clr"></div>
<div class="lof-newproduct {$config_values.module_theme}">
	<div class="newproduct-widget block">
		<div class="header">
			<h4 class="newproduct-title title_block">{l s='New product' mod='lofnewproduct'}</h4>
		</div>
		<div class="list-newproduct responsive">
			<ul id="lofnewproduct-{$moduleId}" class="newproduct-news clearfix">
				{foreach from=$listNews item=item}    
				<li>
					<div class="article lof-content">
						<div class="newproduct-item box-hover clearfix">
							{if $config_values.show_title eq '1'}
							<h5 class="entry-title">
								<a href="{$item.link}" target="{$target}">{$item.name}</a>
							</h5>
							{/if}
							<div class="video-thumb lof-product">
							<a href="{$item.link}" title="{$item.name|escape:html:'UTF-8'}" class="product_image" target="{$target}">
								<img class="responsive-img" src="{$item.mainImge}" alt="{$item.name}"/>
							</a>
							</div>
							{if $config_values.show_desc eq '1'}
								<p class="product_desc">{$item.description}</p>
							{/if}
							{if !$PS_CATALOG_MODE && $config_values.show_price eq '1' AND !isset($restricted_country_mode) && $item.show_price}
								<p class="entry-price price_container"><span class="price lof-price">{$item.price}</span></p>
							{/if}

							{if !$PS_CATALOG_MODE && is_array($item.specific_prices) AND ($config_values.price_special  eq '1') AND !isset($restricted_country_mode) && $item.show_price}
							<div class="entry-price-discount">{displayWtPrice p=$item.price_without_reduction}</div>
							{/if}
							<div class="entry-content lof-button">
								
                                                                 {if ($item.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $item.available_for_order && !isset($restricted_country_mode) && $item.minimal_quantity <= 1 && $item.customizable != 2 && !$PS_CATALOG_MODE}
                                                                    {if ($item.allow_oosp || $item.quantity > 0)}
                                                                            {if isset($static_token)}
                                                                                    <a class="button ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$item.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$item.id_product|intval}">
                                                                                            <span>{l s='Add to cart'}</span>
                                                                                    </a>
                                                                            {else}
                                                                                    <a class="button ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$item.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$item.id_product|intval}">
                                                                                            <span>{l s='Add to cart'}</span>
                                                                                    </a>
                                                                            {/if}						
                                                                    {else}
                                                                            <span class="button ajax_add_to_cart_button btn btn-default disabled">
                                                                                    <span>{l s='Add to cart'}</span>
                                                                            </span>
                                                                    {/if}
                                                            {/if}
                                                            <a href="{$item.link}" class="lof-detail">{l s='Detail' mod='lofnewproduct'}</a>
                                                                
							</div>
						</div>
					</div>				
				</li>
				{/foreach}
			</ul>		
			<div class="clear"></div>
			{if $config_values.show_button eq '1'}
			<div class="newproduct-nav">
				<a id="lofprev-{$moduleId}" class="prev" href="#">&nbsp;</a>
				<a id="lofnext-{$moduleId}" class="next" href="#">&nbsp;</a>
			</div>{/if}
			{if $config_values.show_pager eq '1'}<div id="lofpager-{$moduleId}" class="lof-pager"></div>{/if}
		</div>
	</div>
</div>
<script type="text/javascript">
// <![CDATA[
			$('#lofnewproduct-{$moduleId}').carouFredSel({ldelim}
				responsive:true,
				prev: '#lofprev-{$moduleId}',
				next: '#lofnext-{$moduleId}',
				pagination: "#lofpager-{$moduleId}",
				auto: {$config_values.auto_play},
				width: "{$config_values.slide_width}",
				height: "{$config_values.slide_height}",
				scroll: {$config_values.scroll_items},
				items:{ldelim}
					width:200,
					visible:{ldelim}
						min:1,
						max:{$config_values.limit_cols}
					{rdelim}
				{rdelim}
			{rdelim});	

// ]]>
</script>  
