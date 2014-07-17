<?php /* Smarty version Smarty-3.1.14, created on 2014-07-07 06:14:04
         compiled from "/home/www/prestashop_16/prestashop/admin0792/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:58119297653ba1e8c60bd77-85246488%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4468ee4a808b107ae135941bdc110974266d2c78' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/admin0792/themes/default/template/content.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '58119297653ba1e8c60bd77-85246488',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53ba1e8c639449_44844217',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53ba1e8c639449_44844217')) {function content_53ba1e8c639449_44844217($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>

<?php if (isset($_smarty_tpl->tpl_vars['content']->value)){?>
	<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<?php }?>
<?php }} ?>