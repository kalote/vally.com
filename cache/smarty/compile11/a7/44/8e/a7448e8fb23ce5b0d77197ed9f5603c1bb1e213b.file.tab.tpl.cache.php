<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 14:58:33
         compiled from "/home/www/prestashop_16/prestashop/themes/default-bootstrap/modules/homefeatured/tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:131136541853b15ef9cfb359-58775629%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a7448e8fb23ce5b0d77197ed9f5603c1bb1e213b' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/themes/default-bootstrap/modules/homefeatured/tab.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '131136541853b15ef9cfb359-58775629',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_li' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15ef9d16339_25060710',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15ef9d16339_25060710')) {function content_53b15ef9d16339_25060710($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include '/home/www/prestashop_16/prestashop/tools/smarty/plugins/function.counter.php';
?>
<?php echo smarty_function_counter(array('name'=>'active_li','assign'=>'active_li'),$_smarty_tpl);?>

<li<?php if ($_smarty_tpl->tpl_vars['active_li']->value==1){?> class="active"<?php }?>><a data-toggle="tab" href="#homefeatured" class="homefeatured"><?php echo smartyTranslate(array('s'=>'Popular','mod'=>'homefeatured'),$_smarty_tpl);?>
</a></li><?php }} ?>