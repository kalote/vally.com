<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 12:39:56
         compiled from "/home/www/prestashop_16/prestashop/themes/default-bootstrap/modules/homeslider/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:90800709553b15a9c22dc12-97453625%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '119566a29a882baf3ebc7fe25e82540a5e9151fb' => 
    array (
      0 => '/home/www/prestashop_16/prestashop/themes/default-bootstrap/modules/homeslider/header.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '90800709553b15a9c22dc12-97453625',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'homeslider' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b15a9c24ab64_79067106',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b15a9c24ab64_79067106')) {function content_53b15a9c24ab64_79067106($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['homeslider']->value)){?>
    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('homeslider_loop'=>$_smarty_tpl->tpl_vars['homeslider']->value['loop']),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('homeslider_width'=>$_smarty_tpl->tpl_vars['homeslider']->value['width']),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('homeslider_speed'=>$_smarty_tpl->tpl_vars['homeslider']->value['speed']),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('homeslider_pause'=>$_smarty_tpl->tpl_vars['homeslider']->value['pause']),$_smarty_tpl);?>

<?php }?><?php }} ?>