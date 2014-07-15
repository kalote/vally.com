<?php /* Smarty version Smarty-3.1.14, created on 2014-07-08 13:44:32
         compiled from "/home/www/prestashop/admin0792/themes/default/template/helpers/list/list_action_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:75083054453bbd9a0a03755-43849396%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'caafde987af2f10510f3276f7d1fc846c3746e25' => 
    array (
      0 => '/home/www/prestashop/admin0792/themes/default/template/helpers/list/list_action_view.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '75083054453bbd9a0a03755-43849396',
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
  'unifunc' => 'content_53bbd9a0a0dcd6_69159555',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bbd9a0a0dcd6_69159555')) {function content_53bbd9a0a0dcd6_69159555($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" >
	<i class="icon-search-plus"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>