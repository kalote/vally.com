<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 12:39:53
         compiled from "/home/www/prestashop_16/prestashop/themes/default-bootstrap/modules/blockbestsellers/tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:55462668453b15a99ab8a54-96360383%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f40b022ecaf91c26d676c997fbb0d2d2bc95933' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/themes/default-bootstrap/modules/blockbestsellers/tab.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '55462668453b15a99ab8a54-96360383',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_li' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15a99ac70c1_79026643',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15a99ac70c1_79026643')) {function content_53b15a99ac70c1_79026643($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include '/home/www/prestashop_16/prestashop/tools/smarty/plugins/function.counter.php';
?>
<?php echo smarty_function_counter(array('name'=>'active_li','assign'=>'active_li'),$_smarty_tpl);?>

<li<?php if ($_smarty_tpl->tpl_vars['active_li']->value==1){?> class="active"<?php }?>><a data-toggle="tab" href="#blockbestsellers" class="blockbestsellers"><?php echo smartyTranslate(array('s'=>'Best Sellers','mod'=>'blockbestsellers'),$_smarty_tpl);?>
</a></li><?php }} ?>