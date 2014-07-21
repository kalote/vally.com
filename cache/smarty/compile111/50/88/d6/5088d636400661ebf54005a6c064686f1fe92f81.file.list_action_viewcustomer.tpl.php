<?php /* Smarty version Smarty-3.1.14, created on 2014-07-08 10:48:42
         compiled from "/home/www/prestashop/modules/blocknewsletter/views/templates/admin/list_action_viewcustomer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:166606915853bbb06a7a6153-78677960%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5088d636400661ebf54005a6c064686f1fe92f81' => 
    array (
      0 => '/home/www/prestashop/modules/blocknewsletter/views/templates/admin/list_action_viewcustomer.tpl',
      1 => 1404809316,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '166606915853bbb06a7a6153-78677960',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'disable' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53bbb06a7f4c05_14253118',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bbb06a7f4c05_14253118')) {function content_53bbb06a7f4c05_14253118($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="edit btn btn-default <?php if ($_smarty_tpl->tpl_vars['disable']->value){?>disabled<?php }?>" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" >
	<i class="icon-search-plus"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>