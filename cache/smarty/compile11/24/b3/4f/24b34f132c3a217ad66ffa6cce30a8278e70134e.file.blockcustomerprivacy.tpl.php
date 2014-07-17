<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 12:39:54
         compiled from "/home/www/prestashop_16/prestashop/themes/default-bootstrap/modules/blockcustomerprivacy/blockcustomerprivacy.tpl" */ ?>
<?php /*%%SmartyHeaderCode:120970528453b15a9aaa9777-93209115%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24b34f132c3a217ad66ffa6cce30a8278e70134e' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/themes/default-bootstrap/modules/blockcustomerprivacy/blockcustomerprivacy.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '120970528453b15a9aaa9777-93209115',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'privacy_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15a9aab1868_40793639',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15a9aab1868_40793639')) {function content_53b15a9aab1868_40793639($_smarty_tpl) {?>

<div class="error_customerprivacy" style="color:red;"></div>
<fieldset class="account_creation customerprivacy">
	<h3 class="page-subheading">
		<?php echo smartyTranslate(array('s'=>'Customer data privacy','mod'=>'blockcustomerprivacy'),$_smarty_tpl);?>

	</h3>
	<div style="width:21px; float:left;">
		<div class="required checkbox">
			<input type="checkbox" value="1" id="customer_privacy" name="customer_privacy" autocomplete="off"/>
		</div>
	</div>
	<div style="width: 92%; float: left; margin-top: 8px;">
        <label for="customer_privacy" style="font-weight: normal;"><?php echo $_smarty_tpl->tpl_vars['privacy_message']->value;?>
</label>				
	</div>
</fieldset><?php }} ?>