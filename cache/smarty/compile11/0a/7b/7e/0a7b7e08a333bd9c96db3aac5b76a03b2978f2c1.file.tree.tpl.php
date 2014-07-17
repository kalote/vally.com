<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 12:40:07
         compiled from "/home/www/prestashop_16/prestashop/admin/themes/default/template/helpers/tree/tree.tpl" */ ?>
<?php /*%%SmartyHeaderCode:157283999453b15aa7a1cec6-33009834%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a7b7e08a333bd9c96db3aac5b76a03b2978f2c1' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/admin/themes/default/template/helpers/tree/tree.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '157283999453b15aa7a1cec6-33009834',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'header' => 0,
    'nodes' => 0,
    'id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15aa7a363d1_40218914',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15aa7a363d1_40218914')) {function content_53b15aa7a363d1_40218914($_smarty_tpl) {?>
<div class="panel">
	<?php if (isset($_smarty_tpl->tpl_vars['header']->value)){?><?php echo $_smarty_tpl->tpl_vars['header']->value;?>
<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['nodes']->value)){?>
	<ul id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" class="tree">
		<?php echo $_smarty_tpl->tpl_vars['nodes']->value;?>

	</ul>
	<?php }?>
</div><?php }} ?>