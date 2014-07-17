<?php /* Smarty version Smarty-3.1.14, created on 2014-07-08 09:00:05
         compiled from "/home/www/prestashop/themes/vally/modules/blockwishlist/blockwishlist_button.tpl" */ ?>
<?php /*%%SmartyHeaderCode:77414429253bb96f5749215-81687822%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '194c0e02e4628394a9d26165f9cbe0173261e4e5' => 
    array (
      0 => '/home/www/prestashop/themes/vally/modules/blockwishlist/blockwishlist_button.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '77414429253bb96f5749215-81687822',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53bb96f57862b4_97456285',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bb96f57862b4_97456285')) {function content_53bb96f57862b4_97456285($_smarty_tpl) {?>

<div class="wishlist">
	<a class="addToWishlist wishlistProd_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" href="#" rel="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" onclick="WishlistCart('wishlist_block_list', 'add', '<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
', false, 1); return false;">
		<?php echo smartyTranslate(array('s'=>"Add to Wishlist",'mod'=>'blockwishlist'),$_smarty_tpl);?>

	</a>
</div><?php }} ?>