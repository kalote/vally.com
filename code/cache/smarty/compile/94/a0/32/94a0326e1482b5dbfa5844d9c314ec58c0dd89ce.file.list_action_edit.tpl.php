<?php /* Smarty version Smarty-3.1.14, created on 2014-07-14 12:16:48
         compiled from "/home/www/prestashop/admin3102/themes/default/template/helpers/list/list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:112718356653c3ae10566c65-89652247%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '94a0326e1482b5dbfa5844d9c314ec58c0dd89ce' => 
    array (
      0 => '/home/www/prestashop/admin3102/themes/default/template/helpers/list/list_action_edit.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '112718356653c3ae10566c65-89652247',
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
  'unifunc' => 'content_53c3ae1057de27_99998597',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53c3ae1057de27_99998597')) {function content_53c3ae1057de27_99998597($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>