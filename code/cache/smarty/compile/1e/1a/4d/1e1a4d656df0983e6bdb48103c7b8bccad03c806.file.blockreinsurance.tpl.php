<?php /* Smarty version Smarty-3.1.14, created on 2014-07-08 11:31:42
         compiled from "/home/www/prestashop/themes/vally/modules/blockreinsurance/blockreinsurance.tpl" */ ?>
<?php /*%%SmartyHeaderCode:191449999653bbb83923d5c7-89399933%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1e1a4d656df0983e6bdb48103c7b8bccad03c806' => 
    array (
      0 => '/home/www/prestashop/themes/vally/modules/blockreinsurance/blockreinsurance.tpl',
      1 => 1404811898,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '191449999653bbb83923d5c7-89399933',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53bbb839268d57_12827417',
  'variables' => 
  array (
    'infos' => 0,
    'nbblocks' => 0,
    'info' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bbb839268d57_12827417')) {function content_53bbb839268d57_12827417($_smarty_tpl) {?>
<?php if (count($_smarty_tpl->tpl_vars['infos']->value)>0){?>
<!-- MODULE Block reinsurance -->

<div id="reinsurance_block" class="clearfix">
	
	<ul class="width<?php echo $_smarty_tpl->tpl_vars['nbblocks']->value;?>
">	
		<?php  $_smarty_tpl->tpl_vars['info'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['info']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['infos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['info']->key => $_smarty_tpl->tpl_vars['info']->value){
$_smarty_tpl->tpl_vars['info']->_loop = true;
?>
			<li><img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getMediaLink("/prestashop/themes/vally/img/reinsurrance/".((string)mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['info']->value['file_name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8')));?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['info']->value['text'], ENT_QUOTES, 'UTF-8', true);?>
" /> <span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['info']->value['text'], ENT_QUOTES, 'UTF-8', true);?>
</span></li>                        
		<?php } ?>
	</ul>
</div>

<!-- /MODULE Block reinsurance -->
<?php }?><?php }} ?>