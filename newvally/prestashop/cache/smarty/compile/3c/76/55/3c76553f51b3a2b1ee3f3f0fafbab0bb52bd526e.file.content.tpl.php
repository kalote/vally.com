<?php /* Smarty version Smarty-3.1.14, created on 2014-07-08 11:32:02
         compiled from "/home/www/prestashop/admin0792/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25465174753bbba926eb6b4-05053463%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c76553f51b3a2b1ee3f3f0fafbab0bb52bd526e' => 
    array (
      0 => '/home/www/prestashop/admin0792/themes/default/template/content.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25465174753bbba926eb6b4-05053463',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53bbba927303a1_64173178',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bbba927303a1_64173178')) {function content_53bbba927303a1_64173178($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>

<?php if (isset($_smarty_tpl->tpl_vars['content']->value)){?>
	<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<?php }?>
<?php }} ?>