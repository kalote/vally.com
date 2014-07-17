<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 12:40:08
         compiled from "/home/www/prestashop_16/prestashop/admin/themes/default/template/helpers/list/list_action_removestock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:178908144853b15aa8dbe7c5-31568969%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f062503b6ddce7126c665f384dd3cadf6e7ea2c0' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/admin/themes/default/template/helpers/list/list_action_removestock.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '178908144853b15aa8dbe7c5-31568969',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15aa8dca799_81343463',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15aa8dca799_81343463')) {function content_53b15aa8dca799_81343463($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<i class="icon-circle-arrow-down"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a>
<?php }} ?>