<?php /* Smarty version Smarty-3.1.14, created on 2014-07-07 13:26:37
         compiled from "/home/www/prestashop/themes/vally/modules/homefeatured/homefeatured.tpl" */ ?>
<?php /*%%SmartyHeaderCode:145827136053ba83eda3a6d2-92840818%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c8f58a2311f67081134ce63b4024a431e6481910' => 
    array (
      0 => '/home/www/prestashop/themes/vally/modules/homefeatured/homefeatured.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '145827136053ba83eda3a6d2-92840818',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
    'active_ul' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53ba83eda60a09_73490549',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53ba83eda60a09_73490549')) {function content_53ba83eda60a09_73490549($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include '/home/www/prestashop/tools/smarty/plugins/function.counter.php';
?>
<?php echo smarty_function_counter(array('name'=>'active_ul','assign'=>'active_ul'),$_smarty_tpl);?>

<?php if (isset($_smarty_tpl->tpl_vars['products']->value)&&$_smarty_tpl->tpl_vars['products']->value){?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('class'=>'homefeatured tab-pane','id'=>'homefeatured','active'=>$_smarty_tpl->tpl_vars['active_ul']->value), 0);?>

<?php }else{ ?>
<ul id="homefeatured" class="homefeatured tab-pane<?php if (isset($_smarty_tpl->tpl_vars['active_ul']->value)&&$_smarty_tpl->tpl_vars['active_ul']->value==1){?> active<?php }?>">
	<li class="alert alert-info"><?php echo smartyTranslate(array('s'=>'No featured products at this time.','mod'=>'homefeatured'),$_smarty_tpl);?>
</li>
</ul>
<?php }?><?php }} ?>