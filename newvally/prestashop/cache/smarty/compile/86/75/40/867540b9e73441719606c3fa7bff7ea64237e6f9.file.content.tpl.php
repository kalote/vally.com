<?php /* Smarty version Smarty-3.1.14, created on 2014-07-14 11:38:57
         compiled from "/home/www/prestashop/admin3102/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:74814130453c3a531da3036-27883743%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '867540b9e73441719606c3fa7bff7ea64237e6f9' => 
    array (
      0 => '/home/www/prestashop/admin3102/themes/default/template/content.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '74814130453c3a531da3036-27883743',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53c3a531db7254_09399755',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53c3a531db7254_09399755')) {function content_53c3a531db7254_09399755($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>

<?php if (isset($_smarty_tpl->tpl_vars['content']->value)){?>
	<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<?php }?>
<?php }} ?>