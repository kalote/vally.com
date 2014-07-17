<?php /* Smarty version Smarty-3.1.14, created on 2014-07-09 10:45:38
         compiled from "/home/www/prestashop/themes/vally/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:47376453953bbb8395b1a60-69082542%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ce3e445b4d4c6a89bfef72e8318eef7977b876d' => 
    array (
      0 => '/home/www/prestashop/themes/vally/index.tpl',
      1 => 1404895532,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '47376453953bbb8395b1a60-69082542',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53bbb8395d8a62_11632462',
  'variables' => 
  array (
    'HOOK_HOME_TAB_CONTENT' => 0,
    'HOOK_HOME_TAB' => 0,
    'HOOK_HOME' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bbb8395d8a62_11632462')) {function content_53bbb8395d8a62_11632462($_smarty_tpl) {?>

<div class="getinspire">
		    <div class="wraper">
				  <div class="textgetibspire">
				    GET  INSPIRED
				  </div>
			</div>
		</div>

<?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value)){?>
    <?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME_TAB']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME_TAB']->value)){?>
        <ul id="home-page-tabs" class="nav nav-tabs clearfix">
			<?php echo $_smarty_tpl->tpl_vars['HOOK_HOME_TAB']->value;?>

		</ul>
	<?php }?>
	<div class="tab-content"><?php echo $_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value;?>
</div>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME']->value)){?>
	<div class="clearfix"><?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>
</div>
<?php }?><?php }} ?>