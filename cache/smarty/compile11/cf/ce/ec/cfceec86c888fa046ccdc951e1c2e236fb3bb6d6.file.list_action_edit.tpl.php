<?php /* Smarty version Smarty-3.1.14, created on 2014-07-07 06:21:51
         compiled from "/home/www/prestashop_16/prestashop/admin0792/themes/default/template/helpers/list/list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:51471534753ba205f83b0d6-44874666%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfceec86c888fa046ccdc951e1c2e236fb3bb6d6' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/admin0792/themes/default/template/helpers/list/list_action_edit.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '51471534753ba205f83b0d6-44874666',
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
  'unifunc' => 'content_53ba205f84f066_86191422',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53ba205f84f066_86191422')) {function content_53ba205f84f066_86191422($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>