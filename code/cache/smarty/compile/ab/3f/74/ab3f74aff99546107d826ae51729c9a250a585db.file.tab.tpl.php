<?php /* Smarty version Smarty-3.1.14, created on 2014-07-08 11:22:00
         compiled from "/home/www/prestashop/themes/vally/modules/blockbestsellers/tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:161245829153bbb838b675e9-73782272%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '161245829153bbb838b675e9-73782272',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_li' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53bbb838ba5d64_12021892',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bbb838ba5d64_12021892')) {function content_53bbb838ba5d64_12021892($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include '/home/www/prestashop/tools/smarty/plugins/function.counter.php';
?>
<?php echo smarty_function_counter(array('name'=>'active_li','assign'=>'active_li'),$_smarty_tpl);?>

<li<?php if ($_smarty_tpl->tpl_vars['active_li']->value==1){?> class="active"<?php }?>><a data-toggle="tab" href="#blockbestsellers" class="blockbestsellers"><?php echo smartyTranslate(array('s'=>'Best Sellers','mod'=>'blockbestsellers'),$_smarty_tpl);?>
</a></li><?php }} ?>