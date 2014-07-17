<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 12:40:00
         compiled from "/home/www/prestashop_16/prestashop/themes/default-bootstrap/category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:83700498453b15aa0d0b804-40151962%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54a413abfeded37b2849ba3df4fa976da17212ad' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/themes/default-bootstrap/category-count.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '83700498453b15aa0d0b804-40151962',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'nb_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15aa0d31fb2_52391304',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15aa0d31fb2_52391304')) {function content_53b15aa0d31fb2_52391304($_smarty_tpl) {?>
<span class="heading-counter"><?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?><?php echo smartyTranslate(array('s'=>'There are no products in  this category'),$_smarty_tpl);?>
<?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?><?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>
<?php }else{ ?><?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>
<?php }?><?php }?></span><?php }} ?>