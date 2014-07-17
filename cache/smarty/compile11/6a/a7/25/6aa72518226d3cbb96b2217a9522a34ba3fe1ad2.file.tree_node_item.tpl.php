<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 12:40:07
         compiled from "/home/www/prestashop_16/prestashop/admin/themes/default/template/helpers/tree/tree_node_item.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18817213053b15aa7ae1488-59497409%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6aa72518226d3cbb96b2217a9522a34ba3fe1ad2' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/admin/themes/default/template/helpers/tree/tree_node_item.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18817213053b15aa7ae1488-59497409',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'node' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15aa7ae7a70_98511000',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15aa7ae7a70_98511000')) {function content_53b15aa7ae7a70_98511000($_smarty_tpl) {?>

<li class="tree-item">
	<label class="tree-item-name">
		<i class="tree-dot"></i>
		<?php echo $_smarty_tpl->tpl_vars['node']->value['name'];?>

	</label>
</li><?php }} ?>