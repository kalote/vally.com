<?php /* Smarty version Smarty-3.1.14, created on 2014-07-08 13:44:32
         compiled from "/home/www/prestashop/admin0792/themes/default/template/helpers/list/list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:121274336453bbd9a0a10e50-51456681%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa4ab08482c4af355591eb8a5485f3e64202c757' => 
    array (
      0 => '/home/www/prestashop/admin0792/themes/default/template/helpers/list/list_action_edit.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '121274336453bbd9a0a10e50-51456681',
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
  'unifunc' => 'content_53bbd9a0a1b021_73048450',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bbd9a0a1b021_73048450')) {function content_53bbd9a0a1b021_73048450($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>