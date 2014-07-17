<?php /* Smarty version Smarty-3.1.14, created on 2014-07-07 13:26:37
         compiled from "/home/www/prestashop/themes/vally/modules/blocknewproducts/tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15872299553ba83ed5a2ed2-80439239%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '93727cdb619f39dd1b2782e9fa1ad91af4c4bcc6' => 
    array (
      0 => '/home/www/prestashop/themes/vally/modules/blocknewproducts/tab.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15872299553ba83ed5a2ed2-80439239',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_li' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53ba83ed5b18f2_13608097',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53ba83ed5b18f2_13608097')) {function content_53ba83ed5b18f2_13608097($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include '/home/www/prestashop/tools/smarty/plugins/function.counter.php';
?>
<?php echo smarty_function_counter(array('name'=>'active_li','assign'=>'active_li'),$_smarty_tpl);?>

<li<?php if ($_smarty_tpl->tpl_vars['active_li']->value==1){?> class="active"<?php }?>><a data-toggle="tab" href="#blocknewproducts" class="blocknewproducts"><?php echo smartyTranslate(array('s'=>'New arrivals','mod'=>'blocknewproducts'),$_smarty_tpl);?>
</a></li><?php }} ?>