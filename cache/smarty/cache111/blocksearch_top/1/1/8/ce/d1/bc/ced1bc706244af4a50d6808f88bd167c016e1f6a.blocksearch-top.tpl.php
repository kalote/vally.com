<?php /*%%SmartyHeaderCode:165801994053ba80027e7915-16679702%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ced1bc706244af4a50d6808f88bd167c016e1f6a' => 
    array (
      0 => '/home/www/prestashop/themes/vally/modules/blocksearch/blocksearch-top.tpl',
      1 => 1404729413,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '165801994053ba80027e7915-16679702',
  'variables' => 
  array (
    'link' => 0,
    'search_query' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53ba800280c610_32274277',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53ba800280c610_32274277')) {function content_53ba800280c610_32274277($_smarty_tpl) {?><!-- Block search module TOP -->


<div id="search_block_top" class="col-sm-4 clearfix">
	<form id="searchbox" method="get" action="http://localhost/prestashop/index.php?controller=search" >
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="Search" value="" />
		<button type="submit" name="submit_search" class="btn btn-default button-search">
			<span>Search</span>
		</button>
	</form>
</div>
<!-- /Block search module TOP --><?php }} ?>