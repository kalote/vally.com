<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 12:40:01
         compiled from "/home/www/prestashop_16/prestashop/admin/themes/default/template/controllers/stats/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:73448684653b15aa168ebb2-83570407%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '30f7353920c38404cac4b81365248892fd36c49e' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/admin/themes/default/template/controllers/stats/menu.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '73448684653b15aa168ebb2-83570407',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'modules' => 0,
    'module' => 0,
    'module_instance' => 0,
    'current_module_name' => 0,
    'current' => 0,
    'token' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15aa16bee85_65821313',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15aa16bee85_65821313')) {function content_53b15aa16bee85_65821313($_smarty_tpl) {?>
<div id="container" class="row">
	<div class="sidebar navigation col-md-3">
		<nav class="list-group categorieList">
		<?php if (count($_smarty_tpl->tpl_vars['modules']->value)){?>
			<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['modules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
?>
				<?php if ($_smarty_tpl->tpl_vars['module_instance']->value[$_smarty_tpl->tpl_vars['module']->value['name']]){?>
					<a class="list-group-item<?php if (($_smarty_tpl->tpl_vars['current_module_name']->value&&$_smarty_tpl->tpl_vars['current_module_name']->value==$_smarty_tpl->tpl_vars['module']->value['name'])){?> active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['current']->value;?>
&amp;token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
&amp;module=<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['module_instance']->value[$_smarty_tpl->tpl_vars['module']->value['name']]->displayName;?>
</a>
				<?php }?>
			<?php } ?>
		<?php }else{ ?>
			<?php echo smartyTranslate(array('s'=>'No module has been installed.'),$_smarty_tpl);?>

		<?php }?>
		</nav>
	</div><?php }} ?>