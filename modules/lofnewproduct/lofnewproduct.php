<?php

/**
 * $ModDesc
 * 
 * @version		$Id: file.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) December 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
 */
if (!defined('_CAN_LOAD_FILES_')) {
    define('_CAN_LOAD_FILES_', 1);
}

class lofnewproduct extends Module {

    private $_params = '';
    private $_postErrors = array();

    function __construct() {
        $this->name = 'lofnewproduct';
        parent::__construct();
        $this->tab = 'LandOfCoder';
        $this->author = 'LandOfCoder';
        $this->version = '2.0';
        $this->displayName = $this->l('Lof New Products Module');
        $this->description = $this->l('Display new products using carouFredSel plugin jquery');
        $this->module_key = '';
        $this->bootstrap = true;
        if (file_exists(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/params.php') && !class_exists("LofParams", false)) {
            require( _PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/params.php' );
        }

        $this->_params = new LofParams($this->name, $this);
    }

    /**
     * process installing 
     */
    function install() {
        if (!parent::install())
            return false;
        if (!$this->registerHook('top'))
            return false;
        if (!$this->registerHook('header'))
            return false;

        $configs = $this->initConfigs();
        $this->_params->batchUpdate($configs);
        return true;
    }

    public function initConfigs() {
        $langs = LanguageCore::getLanguages(false);
        return array(
            'module_theme' => 'default',
            'order_by' => 'date_upd',
            'order_way' => 'ASC',
            'limit_items' => 12,
            'scroll_items' => 1,
            'slide_height' => 'auto',
            'slide_width' => 'auto',
            'auto_play' => 0,
            'target' => 'same_window',
            'des_max_chars' => 100,
            'cre_main_size' => 0,
            'main_img_size' => 'large_default',
            'main_height' => '',
            'main_width' => '',
            'limit_cols' => 4,
            'show_desc' => 1,
            'show_price' => 1,
            'price_special' => 1,
            'show_title' => 1,
            'show_image' => 1,
            'show_button' => 1,
            'show_pager' => 1
        );
    }

    function hooktop($params) {
        return '</div><div class="clearfix"></div><div>' . $this->processHook($params, "top");
    }

    function hookfooter($params) {
        return $this->processHook($params, "footer");
    }

    function hookHome($params) {
        return $this->processHook($params, "home");
    }

    function hookHeader($params) {
        $this->context->controller->addJS(($this->_path) . 'assets/script.js', 'all');
        define('_LOF_NEW_PRODUCT_', 1);
        $this->context->controller->addCSS(($this->_path) . 'views/templates/hook/' . $this->_params->get('module_theme', 'default') . '/assets/style.css', 'all');
    }

    /**
     * Proccess module by hook
     * $pparams: param of module
     * $pos: position call
     */
    function processHook($mparams, $pos = "home") {
        global $cookie, $link, $smarty;
        $id_lang = intval($cookie->id_lang);
        $site_url = Tools::htmlentitiesutf8('http://' . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__);

        $thumbPath = _PS_CACHEFS_DIRECTORY_ . $this->name; // create thumbnail folder
        if (!file_exists(_PS_CACHEFS_DIRECTORY_)) {
            mkdir(_PS_CACHEFS_DIRECTORY_, 0777);
        };
        if (!file_exists($thumbPath)) {
            mkdir($thumbPath, 0777);
        };
        $thumbUrl = $site_url . "cache/cachefs/" . $this->name;


        if (file_exists(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/group_base.php') && !class_exists("LofNewProductDataSourceBase", false)) {
            if (!defined("LOF_NEWPRODUCT_LOAD_LIB_GROUP")) {
                require_once( _PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/group_base.php' );
                define("LOF_NEWPRODUCT_LOAD_LIB_GROUP", true);
            }
        }
        if (file_exists(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/phpthumb/ThumbLib.inc.php') && !class_exists('PhpThumbFactory', false)) {
            if (!defined("LOF_NEWPRODUCT_LOAD_LIB_PHPTHUMB")) {
                require( _PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/phpthumb/ThumbLib.inc.php' );
                define("LOF_NEWPRODUCT_LOAD_LIB_PHPTHUMB", true);
            }
        }

        //config
        $moduleId = rand() . time();
        $params = $this->_params;
        $params->set('auto_renderthumb', 0);
        $configs = $this->initConfigs();
        $config_values = $this->_params->getConfigFieldsValues($configs);
        $config_values['auto_play'] = ($config_values['auto_play'] == 1) ? 'true' : 'false';

        $source = 'product';
        $path = dirname(__FILE__) . '/libs/groups/' . strtolower($source) . '/product.php';
        if (!file_exists($path)) {
            return array();
        }
        require_once $path;
        $objectName = "LofNew" . ucfirst($source) . "DataSource";
        $object = new $objectName();
        $object->setThumbPathInfo($thumbPath, $thumbUrl)
                ->setImagesRendered(array('mainImage' => array((int) $params->get('main_width', 150), (int) $params->get('main_height', 100))));

        $listNews = $object->getNewProducts($params);
        //echo "<pre>"; print_r($listNews); die;
        //assign params
        $smarty->assign(array(
            'moduleId' => $moduleId,
            'site_url' => $site_url,
            'config_values' => $config_values,
            'listNews' => $listNews,
        ));
        //assign layout
        $theme = $this->_params->get('module_theme');
        return ($this->display(__FILE__, $theme . '/default.tpl'));
    }

    /**
     * Render processing form && process saving data.
     */
    public function getContent() {
        $this->_html = "";
        if (Tools::isSubmit('submitUpdate')) {
            $this->_postValidation();
            if (!sizeof($this->_postErrors)) {
                $configs = $this->initConfigs();
                $res = $this->_params->batchUpdate($configs);
                if (!$res)
                    $this->_html .= $this->displayError($this->l('Configuration could not be updated'));
                else
                    $this->_html .= $this->displayConfirmation($this->l('Configuration updated'));
            }else {
                foreach ($this->_postErrors as $err) {
                    $this->_html .= $this->displayError($this->l($err));
                }
            }
        }

        return $this->_html . $this->renderForm();
    }

    /**
     * Render Configuration From for user making settings.
     *
     * @return context
     */
    private function renderForm() {
        $configs = $this->initConfigs();
        $params = $this->_params;
        $themes = $params->getFolderList(dirname(__FILE__) . "/views/templates/hook/");

        $arrOder = array(
            array('id' => 'date_add', 'name' => $this->l('Date Add')),
            array('id' => 'date_upd', 'name' => $this->l('Date Update')),
            array('id' => 'name', 'name' => $this->l('Name')),
            array('id' => 'id_product', 'name' => $this->l('Product ID')),
            array('id' => 'price', 'name' => $this->l('Price')),
        );
        $order_way = array(
            array('id' => 'ASC', 'name' => 'ASC'),
            array('id' => 'DESC', 'name' => 'DESC')
        );
        $options = array(
            array('id' => '_blank', 'name' => $this->l('New Window')),
            array('id' => '_self', 'name' => $this->l('Same Window'))
        );
        $formats = array(
            array('id' => 'home_default', 'name' => $this->l('home_default(124x124)')),
            array('id' => 'large_default', 'name' => $this->l('large_default(264x264)')),
            array('id' => 'medium_default', 'name' => $this->l('medium_default(58x58)')),
            array('id' => 'small_default', 'name' => $this->l('small_default(45x45)')),
            array('id' => 'thickbox_default', 'name' => $this->l('thickbox_default(600x600)')),
        );

        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Global Setting'),
                'icon' => 'icon-cogs'
            ),
            'input' => array(
                $params->selectTags('module_theme', 'Theme - Layout', $themes),
                $params->selectTags('order_by', ' Order by', $arrOder),
                $params->selectTags('order_way', ' Order way', $order_way),
                $params->inputTags('limit_items', 'Limit items'),
                $params->inputTags('scroll_items', 'Scroll items'),
                $params->inputTags('slide_height', 'Slide Height'),
                $params->inputTags('slide_width', 'Slide Width'),
                $params->switchTags('auto_play', 'Auto Play Slider')
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            )
        );
        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => 'Main Slider Setting',
                'icon' => 'icon-cogs'
            ),
            'input' => array(
                $params->selectTags('target', 'Open Link', $options),
                $params->inputTags('des_max_chars', 'Description Max Chars'),
                $params->switchTags('cre_main_size', 'Create Size of Main Image'),
                $params->selectTags('main_img_size', 'Main Image Size', $formats),
                $params->inputTags('limit_cols', 'Limit Column'),
                $params->switchTags('show_desc', 'Enable Main Description'),
                $params->switchTags('show_price', 'Enable Main Price '),
                $params->switchTags('price_special', 'Enable Price without Reduction'),
                $params->switchTags('show_title', 'Enable Main Title'),
                $params->switchTags('show_image', 'Enable Main Image'),
                $params->switchTags('show_button', 'Enable Button Navigation'),
                $params->switchTags('show_pager', 'Enable Pager Navigation '),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            )
        );
        $this->fields_form[2]['form'] = array(
            'legend' => array(
                'title' => 'Information',
                'icon' => 'icon-info'
            ),
            'desc' => '<div><ul>
    	     <li>+ <a target="_blank" href="http://landofcoder.com/prestashop/">' . $this->l("Detail Information") . '</li>
             <li>+ <a target="_blank" href="http://landofcoder.com/supports/forum.html">' . $this->l("Forum support") . '</a></li>
             <li>+ <a target="_blank" href="http://landofcoder.com/submit-request.html">' . $this->l("Customization/Technical Support Via Email") . '</a></li>
             <li>+ <a target="_blank" href="http://landofcoder.com/prestashop/guides/">' . $this->l("UserGuide ") . '</a></li>
        </ul>
        <br />
        
		<br/>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=248313105205162";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, "script", "facebook-jssdk"));</script>		
		<div class="social_buttons">
			<div class="fb-like" data-href="http://www.facebook.com/LandOfCoder" data-send="false" data-width="200" data-show-faces="false"></div>
			<a href="https://twitter.com/landofcoder" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @LandOfCoder</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	   </div>
	   <br/>
	   @Copyright: <a href="http://landofcoder.com">LandOfCoder.com</a></div>',
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdate';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $params->getConfigFieldsValues($configs),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm($this->fields_form);
    }

    /**
     * Process vadiation before saving data 
     */
    private function _postValidation() {
        if (!Validate::isCleanHtml(Tools::getValue('limit_items')) || !is_numeric(Tools::getValue('limit_items')))
            $this->_postErrors[] = $this->l('Limit items you entered was not allowed, sorry');
        if (!Validate::isCleanHtml(Tools::getValue('scroll_items')) || !is_numeric(Tools::getValue('scroll_items')))
            $this->_postErrors[] = $this->l('Scroll items you entered was not allowed, sorry');
        if (!Validate::isCleanHtml(Tools::getValue('des_max_chars')) || !is_numeric(Tools::getValue('des_max_chars')))
            $this->_postErrors[] = $this->l('The description max chars you entered was not allowed, sorry');
        if (!Validate::isCleanHtml(Tools::getValue('limit_cols')) || !is_numeric(Tools::getValue('limit_cols')))
            $this->_postErrors[] = $this->l('Limit column you entered was not allowed, sorry');
    }

}
