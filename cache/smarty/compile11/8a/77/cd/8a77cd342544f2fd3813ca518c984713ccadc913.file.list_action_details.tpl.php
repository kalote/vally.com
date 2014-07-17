<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 12:40:08
         compiled from "/home/www/prestashop_16/prestashop/admin/themes/default/template/helpers/list/list_action_details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:60017870553b15aa8735f87-85681762%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8a77cd342544f2fd3813ca518c984713ccadc913' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/admin/themes/default/template/helpers/list/list_action_details.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '60017870553b15aa8735f87-85681762',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'params' => 0,
    'id' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15aa8748bb3_19867156',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15aa8748bb3_19867156')) {function content_53b15aa8748bb3_19867156($_smarty_tpl) {?>

<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" id="details_<?php echo $_smarty_tpl->tpl_vars['params']->value['action'];?>
_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" class="">
	<i class="icon-eye-open"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a>
<?php }} ?>