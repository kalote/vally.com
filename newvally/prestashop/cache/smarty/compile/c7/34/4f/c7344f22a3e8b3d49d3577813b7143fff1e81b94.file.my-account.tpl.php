<?php /* Smarty version Smarty-3.1.14, created on 2014-07-09 11:38:35
         compiled from "/home/www/prestashop/themes/vally/modules/blockwishlist/my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:173328273053bd0d9bca52a3-63901611%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7344f22a3e8b3d49d3577813b7143fff1e81b94' => 
    array (
      0 => '/home/www/prestashop/themes/vally/modules/blockwishlist/my-account.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '173328273053bd0d9bca52a3-63901611',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53bd0d9bcc3302_15964121',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bd0d9bcc3302_15964121')) {function content_53bd0d9bcc3302_15964121($_smarty_tpl) {?>

<!-- MODULE WishList -->
<li class="lnk_wishlist">
	<a 	href="<?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getModuleLink('blockwishlist','mywishlist',array(),true));?>
" title="<?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>
">
		<i class="icon-heart"></i>
		<span><?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>
</span>
	</a>
</li>
<!-- END : MODULE WishList --><?php }} ?>