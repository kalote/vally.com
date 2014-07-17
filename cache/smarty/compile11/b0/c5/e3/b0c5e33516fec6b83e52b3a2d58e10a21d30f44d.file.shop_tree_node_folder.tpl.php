<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 12:40:04
         compiled from "/home/www/prestashop_16/prestashop/admin/themes/default/template/controllers/shop/helpers/tree/shop_tree_node_folder.tpl" */ ?>
<?php /*%%SmartyHeaderCode:143627359953b15aa410e861-93865456%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0c5e33516fec6b83e52b3a2d58e10a21d30f44d' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/admin/themes/default/template/controllers/shop/helpers/tree/shop_tree_node_folder.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143627359953b15aa410e861-93865456',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url_shop_group' => 0,
    'node' => 0,
    'children' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15aa411e0a8_20205195',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15aa411e0a8_20205195')) {function content_53b15aa411e0a8_20205195($_smarty_tpl) {?>
<li class="tree-folder">
	<span class="tree-folder-name">
		<i class="icon-folder-close"></i>
		<label class="tree-toggler "><a href="<?php echo $_smarty_tpl->tpl_vars['url_shop_group']->value;?>
&id_shop_group=<?php echo $_smarty_tpl->tpl_vars['node']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['node']->value['name'];?>
</a></label>
	</span>
	<ul class="tree">
		<?php echo $_smarty_tpl->tpl_vars['children']->value;?>

	</ul>
</li><?php }} ?>