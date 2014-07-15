<?php /* Smarty version Smarty-3.1.14, created on 2014-07-08 10:48:42
         compiled from "/home/www/prestashop/modules/blocknewsletter/views/templates/admin/list_action_unsubscribe.tpl" */ ?>
<?php /*%%SmartyHeaderCode:69482083453bbb06a7f8997-55989904%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '103ce1216fa11500c542f3cffcefad873f7b306c' => 
    array (
      0 => '/home/www/prestashop/modules/blocknewsletter/views/templates/admin/list_action_unsubscribe.tpl',
      1 => 1404809316,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '69482083453bbb06a7f8997-55989904',
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
  'unifunc' => 'content_53bbb06a8028f6_28863220',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bbb06a8028f6_28863220')) {function content_53bbb06a8028f6_28863220($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" >
	<i class="icon-check"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a>
<?php }} ?>