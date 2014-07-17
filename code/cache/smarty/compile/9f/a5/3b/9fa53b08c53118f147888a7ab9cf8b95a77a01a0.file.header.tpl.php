<?php /* Smarty version Smarty-3.1.14, created on 2014-07-09 11:35:59
         compiled from "/home/www/prestashop/modules/paypal/views/templates/admin/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:50110703353bd0cff5a9d44-73897601%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9fa53b08c53118f147888a7ab9cf8b95a77a01a0' => 
    array (
      0 => '/home/www/prestashop/modules/paypal/views/templates/admin/header.tpl',
      1 => 1404898537,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '50110703353bd0cff5a9d44-73897601',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PayPal_WPS' => 0,
    'PayPal_HSS' => 0,
    'PayPal_ECS' => 0,
    'PayPal_module_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53bd0cff5eb9e5_68453848',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bd0cff5eb9e5_68453848')) {function content_53bd0cff5eb9e5_68453848($_smarty_tpl) {?>

<script type="text/javascript">
	var PayPal_WPS = '<?php echo intval($_smarty_tpl->tpl_vars['PayPal_WPS']->value);?>
';
	var PayPal_HSS = '<?php echo intval($_smarty_tpl->tpl_vars['PayPal_HSS']->value);?>
';
	var PayPal_ECS = '<?php echo intval($_smarty_tpl->tpl_vars['PayPal_ECS']->value);?>
';
</script>

<script type="text/javascript" src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/js/back_office.js"></script><?php }} ?>