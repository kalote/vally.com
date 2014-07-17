<?php /* Smarty version Smarty-3.1.14, created on 2014-07-07 13:24:37
         compiled from "/home/www/prestashop/themes/vally/modules/blocksocial/blocksocial.tpl" */ ?>
<?php /*%%SmartyHeaderCode:194689195553ba81434f56d7-49900417%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd031228bd15e07bd1e7454b616b8813e8e472f55' => 
    array (
      0 => '/home/www/prestashop/themes/vally/modules/blocksocial/blocksocial.tpl',
      1 => 1404732273,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '194689195553ba81434f56d7-49900417',
  'function' => 
  array (
  ),
  'cache_lifetime' => 31536000,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53ba8143555fa2_35341652',
  'variables' => 
  array (
    'facebook_url' => 0,
    'twitter_url' => 0,
    'rss_url' => 0,
    'youtube_url' => 0,
    'google_plus_url' => 0,
    'pinterest_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53ba8143555fa2_35341652')) {function content_53ba8143555fa2_35341652($_smarty_tpl) {?>




<div id="socials">
	<ul>
		<?php if ($_smarty_tpl->tpl_vars['facebook_url']->value!=''){?>
			<li>
				<a target="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['facebook_url']->value, ENT_QUOTES, 'UTF-8', true);?>
">
					<img src="images/fb.png">
				</a>
			</li>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['twitter_url']->value!=''){?>
			<li>
				<a target="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['twitter_url']->value, ENT_QUOTES, 'UTF-8', true);?>
">
					<img src="images/tweeter.png">
				</a>
			</li>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['rss_url']->value!=''){?>
			<li>
				<a target="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['rss_url']->value, ENT_QUOTES, 'UTF-8', true);?>
">
					<img src="images/blog.png">
				</a>
			</li>
		<?php }?>
        <?php if ($_smarty_tpl->tpl_vars['youtube_url']->value!=''){?>
        	<li>
        		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['youtube_url']->value, ENT_QUOTES, 'UTF-8', true);?>
">
        			<img src="images/utube.png">
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
        			<img src="images/pinter.png">
        		</a>
        	</li>
        <?php }?>
	</ul>
</div>
<div class="clearfix"></div>
<?php }} ?>