<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 14:58:34
         compiled from "/home/www/prestashop_16/prestashop/modules/blockbanner/blockbanner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:67086670853b15efae49a39-93496515%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9b941201ef21a7cfa4db89ba5c5f626dd3f17738' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/modules/blockbanner/blockbanner.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '67086670853b15efae49a39-93496515',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'banner_link' => 0,
    'banner_desc' => 0,
    'banner_img' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15efae7e243_09850618',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15efae7e243_09850618')) {function content_53b15efae7e243_09850618($_smarty_tpl) {?>
<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['banner_link']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['banner_desc']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
<?php if (isset($_smarty_tpl->tpl_vars['banner_img']->value)){?>
	<img class="img-responsive" src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['banner_img']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" alt="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['banner_desc']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['banner_desc']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" width="1170" height="65" />
<?php }else{ ?>
	<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['banner_desc']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

<?php }?>
</a>
<?php }} ?>