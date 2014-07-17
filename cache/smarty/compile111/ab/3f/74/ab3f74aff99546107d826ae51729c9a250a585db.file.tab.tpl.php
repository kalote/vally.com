<?php /* Smarty version Smarty-3.1.14, created on 2014-07-07 13:26:37
         compiled from "/home/www/prestashop/themes/vally/modules/blockbestsellers/tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:41124131753ba83ed5e8563-56385122%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab3f74aff99546107d826ae51729c9a250a585db' => 
    array (
      0 => '/home/www/prestashop/themes/vally/modules/blockbestsellers/tab.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '41124131753ba83ed5e8563-56385122',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_li' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53ba83ed5f6ba1_30489053',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53ba83ed5f6ba1_30489053')) {function content_53ba83ed5f6ba1_30489053($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include '/home/www/prestashop/tools/smarty/plugins/function.counter.php';
?>
<?php echo smarty_function_counter(array('name'=>'active_li','assign'=>'active_li'),$_smarty_tpl);?>

<li<?php if ($_smarty_tpl->tpl_vars['active_li']->value==1){?> class="active"<?php }?>><a data-toggle="tab" href="#blockbestsellers" class="blockbestsellers"><?php echo smartyTranslate(array('s'=>'Best Sellers','mod'=>'blockbestsellers'),$_smarty_tpl);?>
</a></li><?php }} ?>