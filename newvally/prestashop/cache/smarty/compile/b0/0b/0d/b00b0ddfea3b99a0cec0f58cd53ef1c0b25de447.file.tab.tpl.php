<?php /* Smarty version Smarty-3.1.14, created on 2014-07-08 11:22:00
         compiled from "/home/www/prestashop/themes/vally/modules/homefeatured/tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27178059253bbb838b16f93-83647944%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b00b0ddfea3b99a0cec0f58cd53ef1c0b25de447' => 
    array (
      0 => '/home/www/prestashop/themes/vally/modules/homefeatured/tab.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27178059253bbb838b16f93-83647944',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_li' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53bbb838b4cd07_71790388',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bbb838b4cd07_71790388')) {function content_53bbb838b4cd07_71790388($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include '/home/www/prestashop/tools/smarty/plugins/function.counter.php';
?>
<?php echo smarty_function_counter(array('name'=>'active_li','assign'=>'active_li'),$_smarty_tpl);?>

<li<?php if ($_smarty_tpl->tpl_vars['active_li']->value==1){?> class="active"<?php }?>><a data-toggle="tab" href="#homefeatured" class="homefeatured"><?php echo smartyTranslate(array('s'=>'Popular','mod'=>'homefeatured'),$_smarty_tpl);?>
</a></li><?php }} ?>