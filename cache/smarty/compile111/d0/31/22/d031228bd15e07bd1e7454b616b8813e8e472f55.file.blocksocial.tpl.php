<?php /* Smarty version Smarty-3.1.14, created on 2014-07-07 13:32:42
         compiled from "/home/www/prestashop/themes/vally/modules/blocksocial/blocksocial.tpl" */ ?>
<?php /*%%SmartyHeaderCode:183413615753ba8002cec948-66281167%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd031228bd15e07bd1e7454b616b8813e8e472f55' => 
    array (
      0 => '/home/www/prestashop/themes/vally/modules/blocksocial/blocksocial.tpl',
      1 => 1404732760,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '183413615753ba8002cec948-66281167',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53ba8002d4d328_93151598',
  'variables' => 
  array (
    'facebook_url' => 0,
    'img_dir' => 0,
    'twitter_url' => 0,
    'rss_url' => 0,
    'youtube_url' => 0,
    'google_plus_url' => 0,
    'pinterest_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53ba8002d4d328_93151598')) {function content_53ba8002d4d328_93151598($_smarty_tpl) {?>




<div id="socials">
	<ul>
		<?php if ($_smarty_tpl->tpl_vars['facebook_url']->value!=''){?>
			<li>
				<a target="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['facebook_url']->value, ENT_QUOTES, 'UTF-8', true);?>
">
					<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
/fb.png">
				</a>
			</li>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['twitter_url']->value!=''){?>
			<li>
				<a target="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['twitter_url']->value, ENT_QUOTES, 'UTF-8', true);?>
">
					<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
/tweeter.png">
				</a>
			</li>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['rss_url']->value!=''){?>
			<li>
				<a target="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['rss_url']->value, ENT_QUOTES, 'UTF-8', true);?>
">
					<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
/blog.png">
				</a>
			</li>
		<?php }?>
        <?php if ($_smarty_tpl->tpl_vars['youtube_url']->value!=''){?>
        	<li>
        		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['youtube_url']->value, ENT_QUOTES, 'UTF-8', true);?>
">
        			<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
/utube.png">
        		</a>
        	</li>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['google_plus_url']->value!=''){?>
        	<li>
        		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['google_plus_url']->value, ENT_QUOTES, 'UTF-8', true);?>
">
        			<span><?php echo smartyTranslate(array('s'=>'Google Plus','mod'=>'blocksocial'),$_smarty_tpl);?>
</span>
        		</a>
        	</li>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['pinterest_url']->value!=''){?>
        	<li>
        		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pinterest_url']->value, ENT_QUOTES, 'UTF-8', true);?>
">
        			<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
/pinter.png">
        		</a>
        	</li>
        <?php }?>
	</ul>
</div>
<div class="clearfix"></div>
<?php }} ?>