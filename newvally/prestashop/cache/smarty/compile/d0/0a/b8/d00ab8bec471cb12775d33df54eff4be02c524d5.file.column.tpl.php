<?php /* Smarty version Smarty-3.1.14, created on 2014-07-09 11:38:35
         compiled from "/home/www/prestashop/modules/paypal/views/templates/hook/column.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15449898453bd0d9bdb11c2-97255951%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd00ab8bec471cb12775d33df54eff4be02c524d5' => 
    array (
      0 => '/home/www/prestashop/modules/paypal/views/templates/hook/column.tpl',
      1 => 1404898537,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15449898453bd0d9bdb11c2-97255951',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_dir_ssl' => 0,
    'logo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53bd0d9bdbb202_65290886',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bd0d9bdbb202_65290886')) {function content_53bd0d9bdbb202_65290886($_smarty_tpl) {?>

<div id="paypal-column-block">
	<p><a href="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/paypal/about.php" rel="nofollow"><img src="<?php echo $_smarty_tpl->tpl_vars['logo']->value;?>
" alt="PayPal" title="<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
" style="max-width: 100%" /></a></p>
</div>
<?php }} ?>