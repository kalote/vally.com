<?php /* Smarty version Smarty-3.1.14, created on 2014-07-07 13:09:54
         compiled from "/home/www/prestashop/themes/vally/modules/homeslider/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2983481353ba800278b009-53305095%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b6b0918cd61443046118e4382106f569105dfb03' => 
    array (
      0 => '/home/www/prestashop/themes/vally/modules/homeslider/header.tpl',
      1 => 1397133552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2983481353ba800278b009-53305095',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'homeslider' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53ba80027c0e85_57042746',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53ba80027c0e85_57042746')) {function content_53ba80027c0e85_57042746($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['homeslider']->value)){?>
    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('homeslider_loop'=>$_smarty_tpl->tpl_vars['homeslider']->value['loop']),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('homeslider_width'=>$_smarty_tpl->tpl_vars['homeslider']->value['width']),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('homeslider_speed'=>$_smarty_tpl->tpl_vars['homeslider']->value['speed']),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('homeslider_pause'=>$_smarty_tpl->tpl_vars['homeslider']->value['pause']),$_smarty_tpl);?>

<?php }?><?php }} ?>