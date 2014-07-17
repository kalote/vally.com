<?php /* Smarty version Smarty-3.1.14, created on 2014-07-07 13:12:11
         compiled from "/home/www/prestashop/admin0792/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:111519560453ba808b732192-39144767%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '111519560453ba808b732192-39144767',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53ba808b73d242_94476394',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53ba808b73d242_94476394')) {function content_53ba808b73d242_94476394($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>

<?php if (isset($_smarty_tpl->tpl_vars['content']->value)){?>
	<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<?php }?>
<?php }} ?>