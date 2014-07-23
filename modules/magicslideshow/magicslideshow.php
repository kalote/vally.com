<?php

if(!defined('_PS_VERSION_')) exit;

if(!isset($GLOBALS['magictoolbox'])) {
    $GLOBALS['magictoolbox'] = array();
    $GLOBALS['magictoolbox']['filters'] = array();
    $GLOBALS['magictoolbox']['isProductScriptIncluded'] = false;
    $GLOBALS['magictoolbox']['standardTool'] = '';
    $GLOBALS['magictoolbox']['selectorImageType'] = '';
}

if(!isset($GLOBALS['magictoolbox']['magicslideshow'])) {
    $GLOBALS['magictoolbox']['magicslideshow'] = array();
    $GLOBALS['magictoolbox']['magicslideshow']['headers'] = false;
}

class MagicSlideshow extends Module {

    //Prestahop v1.5 or above
    public $isPrestahop15x = false;

    //Prestahop v1.6 or above
    public $isPrestahop16x = false;

    //Smarty v3 template engine
    public $isSmarty3 = false;

    //Smarty 'getTemplateVars' function name
    public $getTemplateVars = 'getTemplateVars';

    //Suffix was added to default images types since version 1.5.1.0
    public $imageTypeSuffix = '';

    public function __construct() {

        $this->name = 'magicslideshow';
        $this->tab = 'Tools';
        $this->version = '5.5.11';
        $this->author = 'Magic Toolbox';


        $this->module_key = '609e67944f32c5c27730cb08142c0a2f';

        parent::__construct();

        $this->displayName = 'Magic Slideshow';
        $this->description = "Display one image after another. Fade or slide, fast or slow, text or just images. It's your choice!";

        $this->confirmUninstall = 'All magicslideshow settings would be deleted. Do you really want to uninstall this module ?';

        $this->isPrestahop15x = version_compare(_PS_VERSION_, '1.5', '>=');
        $this->isPrestahop16x = version_compare(_PS_VERSION_, '1.6', '>=');

        $this->isSmarty3 = $this->isPrestahop15x || Configuration::get('PS_FORCE_SMARTY_2') === "0";
        if($this->isSmarty3) {
            //Smarty v3 template engine
            $this->getTemplateVars = 'getTemplateVars';
        } else {
            //Smarty v2 template engine
            $this->getTemplateVars = 'get_template_vars';
        }

        $this->imageTypeSuffix = version_compare(_PS_VERSION_, '1.5.1.0', '>=') ? '_default' : '';

    }

    public function install() {
        $homeHookID = $this->isPrestahop15x ? ($this->isPrestahop16x ? Hook::getIdByName('displayTopColumn') : Hook::getIdByName('displayHome')) : Hook::get('home');
        $headerHookID = $this->isPrestahop15x ? Hook::getIdByName('displayHeader') : Hook::get('header');
        if(   !parent::install()
           OR !$this->registerHook($this->isPrestahop15x ? 'displayHeader' : 'header')
           OR !$this->registerHook($this->isPrestahop15x ? 'displayFooterProduct' : 'productFooter')
           OR !$this->registerHook($this->isPrestahop15x ? 'displayFooter' : 'footer')
           OR !$this->installDB()
           OR !$this->fixCSS()
           //OR !$this->registerHook($this->isPrestahop15x ? 'displayHome' : 'home')
           OR !$this->registerHook($this->isPrestahop15x ? ($this->isPrestahop16x ? 'displayTopColumn' : 'displayHome') : 'home')
           //OR ($this->isPrestahop16x ? !$this->registerHook('displayTopColumn') : false)
           //OR ($this->isPrestahop16x && !$this->registerHook('displayTopColumn'))
           OR !$this->updatePosition($homeHookID, 0, 1)
           OR !$this->createImageFolder('magicslideshow')
           OR !$this->updatePosition($headerHookID, 0, 1)
          )
          return false;

        $this->sendStat('install');

        return true;
    }

    private function createImageFolder($imageFolderName) {
        if(!is_dir(_PS_IMG_DIR_.$imageFolderName))
            if(!mkdir(_PS_IMG_DIR_.$imageFolderName, 0755))
                return false;

        return true;
    }

    private function installDB() {
        if(!Db::getInstance()->Execute('CREATE TABLE `'._DB_PREFIX_.'magicslideshow_settings` (
                                        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                        `block` VARCHAR(32) NOT NULL,
                                        `name` VARCHAR(32) NOT NULL,
                                        `value` TEXT,
                                        `enabled` INT(2) UNSIGNED NOT NULL,
                                        PRIMARY KEY (`id`)
                                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;'
                                      )
            OR !$this->fillDB()
            OR !$this->fixDefaultValues()
            OR !Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'magicslideshow_images` (
                                            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            `order` INT UNSIGNED default 0,
                                            `name` VARCHAR(64) NOT NULL default \'\',
                                            `ext` VARCHAR(16) NOT NULL default \'\',
                                            `title` VARCHAR(64) NOT NULL default \'\',
                                            `description` TEXT,
                                            `link` VARCHAR(256) NOT NULL default \'\',
                                            `lang` INT(10) UNSIGNED default 0,
                                            `enabled` INT(2) UNSIGNED NOT NULL default 1,
                                            PRIMARY KEY (`id`)
                                            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;'
                                          )
          ) return false;

        return true;
    }

    private function fixCSS() {

        //fix url's in css files
        $fileContents = file_get_contents(dirname(__FILE__).'/magicslideshow.css');
        $toolPath = _MODULE_DIR_.'magicslideshow';
        $pattern = '/url\(\s*(?:\'|")?(?!'.preg_quote($toolPath, '/').')\/?([^\)\s]+?)(?:\'|")?\s*\)/is';
        $replace = 'url('.$toolPath.'/$1)';
        $fixedFileContents = preg_replace($pattern, $replace, $fileContents);
        if($fixedFileContents != $fileContents) {
            //file_put_contents(dirname(__FILE__).'/magicslideshow.css', $fixedFileContents);
            $fp = fopen(dirname(__FILE__).'/magicslideshow.css', 'w+');
            if($fp) {
                fwrite($fp, $fixedFileContents);
                fclose($fp);
            }
        }

        return true;
    }

    private function sendStat($action = '') {

        //NOTE: don't send from working copy
        if('working' == 'v5.5.11' || 'working' == 'v2.0.13') {
            return;
        }

        $hostname = 'www.magictoolbox.com';
        $url = $_SERVER['HTTP_HOST'].preg_replace('/\/$/i', '', __PS_BASE_URI__);
        $url = urlencode(urldecode($url));
        $platformVersion = defined('_PS_VERSION_') ? _PS_VERSION_ : '';
        $path = "api/stat/?action={$action}&tool_name=magicslideshow&license=trial&tool_version=v2.0.13&module_version=v5.5.11&platform_name=prestashop&platform_version={$platformVersion}&url={$url}";
        $handle = @fsockopen($hostname, 80, $errno, $errstr, 30);
        if($handle) {
            $headers  = "GET /{$path} HTTP/1.1\r\n";
            $headers .= "Host: {$hostname}\r\n";
            $headers .= "Connection: Close\r\n\r\n";
            fwrite($handle, $headers);
            fclose($handle);
        }

    }

    public function fixDefaultValues() {
        $result = true;
        if(version_compare(_PS_VERSION_, '1.5.1.0', '>=')) {
            $sql = 'UPDATE `'._DB_PREFIX_.'magicslideshow_settings` SET `value`=CONCAT(value, \'_default\') WHERE `name`=\'thumb-image\' OR `name`=\'selector-image\' OR `name`=\'large-image\'';
            $result = Db::getInstance()->Execute($sql);
        }
        if($this->isPrestahop16x) {
            $sql = 'UPDATE `'._DB_PREFIX_.'magicslideshow_settings` SET `value`=\'Yes\', `enabled`=1 WHERE `name`=\'arrows\' AND (`block`=\'product\' OR `block`=\'homefeatured\' OR `block`=\'blocknewproducts_home\' OR `block`=\'blockbestsellers_home\')';
            $result = Db::getInstance()->Execute($sql);
            $sql = 'UPDATE `'._DB_PREFIX_.'magicslideshow_settings` SET `value`=\'60%\', `enabled`=1 WHERE `name`=\'height\' AND (`block`=\'homefeatured\' OR `block`=\'blocknewproducts_home\' OR `block`=\'blockbestsellers_home\')';
            $result = Db::getInstance()->Execute($sql);
            $sql = 'UPDATE `'._DB_PREFIX_.'magicslideshow_settings` SET `value`=\'thickbox_default\', `enabled`=1 WHERE `name`=\'thumb-image\' AND (`block`=\'homefeatured\' OR `block`=\'blocknewproducts_home\' OR `block`=\'blockbestsellers_home\')';
            $result = Db::getInstance()->Execute($sql);
            $sql = 'UPDATE `'._DB_PREFIX_.'magicslideshow_settings` SET `value`=\'8\', `enabled`=1 WHERE `name`=\'max-number-of-products\' AND (`block`=\'blockbestsellers\' OR `block`=\'blockbestsellers_home\')';
            $result = Db::getInstance()->Execute($sql);
        }
        return $result;
    }

    public function uninstall() {
        //NOTE: spike to clear cache for 'homefeatured.tpl'
        if(version_compare(_PS_VERSION_, '1.5.5.0', '>=')) {
            $this->name = 'homefeatured';
            $this->_clearCache('homefeatured.tpl');
            $this->name = 'magicslideshow';
        }
        if(!parent::uninstall() OR !$this->uninstallDB()) return false;
        $this->sendStat('uninstall');
        return true;
    }

    private function uninstallDB() {
        return  Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'magicslideshow_settings`;')
                //AND Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'magicslideshow_images`;')
                ;
    }

    public function disable($forceAll = false) {
        //NOTE: spike to clear cache for 'homefeatured.tpl'
        if(version_compare(_PS_VERSION_, '1.5.5.0', '>=')) {
            $this->name = 'homefeatured';
            $this->_clearCache('homefeatured.tpl');
            $this->name = 'magicslideshow';
        }
        return parent::disable($forceAll);
    }

    public function enable($forceAll = false) {
        //NOTE: spike to clear cache for 'homefeatured.tpl'
        if(version_compare(_PS_VERSION_, '1.5.5.0', '>=')) {
            $this->name = 'homefeatured';
            $this->_clearCache('homefeatured.tpl');
            $this->name = 'magicslideshow';
        }
        return parent::enable($forceAll);
    }

    public function getImagesTypes() {
        if(!isset($GLOBALS['magictoolbox']['imagesTypes'])) {
            $GLOBALS['magictoolbox']['imagesTypes'] = array('original');
            // get image type values
            $sql = 'SELECT name FROM `'._DB_PREFIX_.'image_type` ORDER BY `id_image_type` ASC';
            $result = Db::getInstance()->ExecuteS($sql);
            foreach($result as $row) {
                $GLOBALS['magictoolbox']['imagesTypes'][] = $row['name'];
            }
        }
        return $GLOBALS['magictoolbox']['imagesTypes'];
    }

    public function getContent() {

        $tool = $this->loadTool();
        $paramsMap = $this->getParamsMap();

        $_imagesTypes = array(
            'selector',
            'large',
            'thumb'
        );

        foreach($_imagesTypes as $name) {
            foreach($this->getBlocks() as $blockId => $blockLabel) {
                if($tool->params->paramExists($name.'-image', $blockId)) {
                    $tool->params->setValues($name.'-image', $this->getImagesTypes(), $blockId);
                }
            }
        }

        $magicSubmit = Tools::getValue('magic_submit', '');
        if(!empty($magicSubmit)) {
            // save settings
            if($magicSubmit == $this->l('Save settings')) {
                foreach($paramsMap as $blockId => $groups) {
                    foreach($groups as $group) {
                        foreach($group as $param) {
                            if(Tools::getValue($blockId.'-'.$param, null) !== null) {
                                $valueToSave = $value = trim(Tools::getValue($blockId.'-'.$param, ''));
                                //switch($tool->params->params[$param]['type']) {
                                switch($tool->params->getType($param)) {
                                    case "num":
                                        $valueToSave = $value = intval($value);
                                        break;
                                    case "array":
                                        if(!in_array($value, $tool->params->getValues($param))) $valueToSave = $value = $tool->params->getDefaultValue($param);
                                        break;
                                    case "text":
                                        $valueToSave = pSQL($value);
                                        break;
                                }
                                Db::getInstance()->Execute(
                                    'UPDATE `'._DB_PREFIX_.'magicslideshow_settings` SET `value`=\''.$valueToSave.'\', `enabled`=1 WHERE `block`=\''.$blockId.'\' AND `name`=\''.$param.'\''
                                );
                                $tool->params->setValue($param, $value, $blockId);
                            } else {
                                Db::getInstance()->Execute(
                                    'UPDATE `'._DB_PREFIX_.'magicslideshow_settings` SET `enabled`=0 WHERE `block`=\''.$blockId.'\' AND `name`=\''.$param.'\''
                                );
                                if($tool->params->paramExists($param, $blockId)) {
                                    $tool->params->removeParam($param, $blockId);
                                };
                            }
                        }
                    }
                }
                //NOTE: spike to clear cache for 'homefeatured.tpl'
                if(version_compare(_PS_VERSION_, '1.5.5.0', '>=')) {
                    $this->name = 'homefeatured';
                    $this->_clearCache('homefeatured.tpl');
                    $this->name = 'magicslideshow';
                }
            }
            /* upload the image */
            if($magicSubmit == $this->l('Upload files')) {
                $errors = array();
                $imageFilePath = _PS_IMG_DIR_.'magicslideshow/';
                $imagesTypes = ImageType::getImagesTypes();
                if(isset($_FILES['magicslideshow_image_files']['tmp_name']) && is_array($_FILES['magicslideshow_image_files']['tmp_name']) && count($_FILES['magicslideshow_image_files']['tmp_name'])) {

                    $imageResizeMethod = 'imageResize';
                    if(class_exists('ImageManager') && method_exists('ImageManager', 'resize')) {
                        $imageResizeMethod = array('ImageManager', 'resize');
                    }

                    foreach($_FILES['magicslideshow_image_files']['tmp_name'] as $key => $tempName) {
                        if(!empty($tempName) && file_exists($tempName)) {
                            if(!$tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS') OR !move_uploaded_file($tempName, $tmpName))
                                $errors[] = 'An error occurred during the image upload.';
                            else {
                                preg_match('/^(.*?)\.([^\.]*)$/is', $_FILES['magicslideshow_image_files']['name'][$key], $matches);
                                list(, $imageFileName, $imageFileExt) = $matches;
                                $imageSuffix = 0;
                                while(file_exists($imageFilePath.$imageFileName.($imageSuffix?'-'.$imageSuffix:'').'.'.$imageFileExt)) {
                                    $imageSuffix++;
                                }
                                $imageFileName = $imageFileName.($imageSuffix?'-'.$imageSuffix:'');
                                if(!call_user_func($imageResizeMethod, $tmpName, $imageFilePath.$imageFileName.'.'.$imageFileExt, NULL, NULL, $imageFileExt)) {
                                    $errors[] = 'An error occurred while copying image.';
                                } else {
                                    foreach($imagesTypes as $k => $imageType)
                                        if(!call_user_func($imageResizeMethod, $tmpName, $imageFilePath.$imageFileName.'-'.stripslashes($imageType['name']).'.'.$imageFileExt, $imageType['width'], $imageType['height'], $imageFileExt))
                                            $errors[] = 'An error occurred while copying resized image ('.stripslashes($imageType['name']).').';
                                }
                            }
                            @unlink($tmpName);
                            $magicslideshowImagesData = Tools::getValue('magicslideshow_images_data', array());
                            $title = isset($magicslideshowImagesData[$key]['title']) ? $magicslideshowImagesData[$key]['title'] : '';
                            $description = isset($magicslideshowImagesData[$key]['description']) ? $magicslideshowImagesData[$key]['description'] : '';
                            $link = isset($magicslideshowImagesData[$key]['link']) ? $magicslideshowImagesData[$key]['link'] : '';
                            $lang = isset($magicslideshowImagesData[$key]['lang']) ? $magicslideshowImagesData[$key]['lang'] : '0';
                            Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'magicslideshow_images` (`name`, `ext`, `title`, `description`, `link`, `lang`, `enabled`, `order`) VALUES (\''.$imageFileName.'\', \''.$imageFileExt.'\', \''.$title.'\', \''.pSQL(htmlspecialchars($description)).'\', \''.$link.'\', '.$lang.', 1, 0)');
                            Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'magicslideshow_images` SET `order`=LAST_INSERT_ID() WHERE `id`=LAST_INSERT_ID()');
                        }
                    }
                }
            }

            // save images data
            $imagesUpdateData = Tools::getValue('images-update-data', array());
            if($magicSubmit == $this->l('Save settings') && !empty($imagesUpdateData)) {
                $imageFilePath = _PS_IMG_DIR_.'magicslideshow/';
                $imagesTypes = ImageType::getImagesTypes();
                foreach($imagesUpdateData as $imageId => $imageData) {
                    if(intval($imageData['delete'])) {
                        $sql = 'SELECT `name`, `ext` FROM `'._DB_PREFIX_.'magicslideshow_images` WHERE `id`='.intval($imageId);
                        $result = Db::getInstance()->ExecuteS($sql);
                        $result = $result[0];
                        foreach($imagesTypes as $k => $imageType) {
                            @unlink($imageFilePath.$result['name'].'-'.stripslashes($imageType['name']).'.'.$result['ext']);
                        }
                        @unlink($imageFilePath.$result['name'].'.'.$result['ext']);
                        Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'magicslideshow_images` WHERE `id`='.intval($imageId));
                    } else {
                        Db::getInstance()->Execute(
                            'UPDATE `'._DB_PREFIX_.'magicslideshow_images` SET '.
                                '`order`='.intval($imageData['order']).
                                ', `title`=\''.$imageData['title'].'\''.
                                ', `description`=\''.pSQL(htmlspecialchars($imageData['description'])).'\''.
                                ', `link`=\''.$imageData['link'].'\''.
                                ', `lang`=\''.$imageData['lang'].'\''.
                                ', `enabled`='.(isset($imageData['enabled'])?'1':'0').
                                ' WHERE `id`='.intval($imageId)
                        );
                    }
                }
            }
        }

        //change subtype for some params to display them like radio
        foreach($tool->params->getParams() as $id => $param) {
            if($tool->params->getSubType($id) == 'select' && count($tool->params->getValues($id)) < 6)
                $tool->params->setSubType($id, 'radio');
        }

        // display params
        ob_start();
        include(dirname(__FILE__).'/magicslideshow.settings.tpl.php');
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    public function loadTool($profile = false, $force = false) {
        if(!isset($GLOBALS['magictoolbox']['magicslideshow']['class']) || $force) {
            require_once(dirname(__FILE__).'/magicslideshow.module.core.class.php');
            $GLOBALS['magictoolbox']['magicslideshow']['class'] = new MagicSlideshowModuleCoreClass();
            $tool = &$GLOBALS['magictoolbox']['magicslideshow']['class'];
            // load current params
            $sql = 'SELECT `name`, `value`, `block` FROM `'._DB_PREFIX_.'magicslideshow_settings` WHERE `enabled`=1';
            $result = Db::getInstance()->ExecuteS($sql);
            foreach($result as $row) {
                $tool->params->setValue($row['name'], $row['value'], $row['block']);
            }
            // load translates
            $GLOBALS['magictoolbox']['magicslideshow']['translates'] = $this->getMessages();
            foreach($this->getBlocks() as $block => $label) {
                if($GLOBALS['magictoolbox']['magicslideshow']['translates'][$block]['message']['title'] != $GLOBALS['magictoolbox']['magicslideshow']['translates'][$block]['message']['translate']) {
                    $tool->params->setValue('message', $GLOBALS['magictoolbox']['magicslideshow']['translates'][$block]['message']['translate'], $block);
                }
                // prepare image types
                foreach(array('large', 'selector', 'thumb') as $name) {
                    if($tool->params->checkValue($name.'-image', 'original', $block)) {
                        $tool->params->setValue($name.'-image', false, $block);
                    }
                }
            }

            if($tool->type == 'standard' && $tool->params->checkValue('magicscroll', 'yes', 'product')) {
                require_once(dirname(__FILE__).'/magicscroll.module.core.class.php');
                $GLOBALS['magictoolbox']['magicslideshow']['magicscroll'] = new MagicScrollModuleCoreClass();
                $scroll = &$GLOBALS['magictoolbox']['magicslideshow']['magicscroll'];
                $scroll->params->setScope('MagicScroll');
                $scroll->params->appendParams($tool->params->getParams('product'));//!!!!!!!!!!!!!
                $scroll->params->setValue('direction', $scroll->params->checkValue('template', array('left', 'right')) ? 'bottom' : 'right');
            }

        }

        $tool = &$GLOBALS['magictoolbox']['magicslideshow']['class'];

        if($profile) {
            $tool->params->setProfile($profile);
        }

        return $tool;

    }

    public function hookHeader($params) {
        global $smarty;

        if(!$this->isPrestahop15x) {
            ob_start();
        }

        $headers = '';
        $tool = $this->loadTool();
        $tool->params->resetProfile();

        $page = $smarty->{$this->getTemplateVars}('page_name');
        switch($page) {
            case 'product':
            case 'index':
                break;
            default:
                $page = '';
        }
        //old check if(preg_match('/\/prices-drop.php$/is', $GLOBALS['_SERVER']['SCRIPT_NAME']))

        if($tool->params->checkValue('include-headers-on-all-pages', 'Yes', 'default') && ($GLOBALS['magictoolbox']['magicslideshow']['headers'] = true)
           || $tool->params->profileExists($page) && !$tool->params->checkValue('enable-effect', 'No', $page)
           || $page == 'index' && !$tool->params->checkValue('enable-effect', 'No', 'homeslideshow')
           || $page == 'index' && !$tool->params->checkValue('enable-effect', 'No', 'homefeatured') && parent::isInstalled('homefeatured') && parent::getInstanceByName('homefeatured')->active
           || $page == 'index' && !$tool->params->checkValue('enable-effect', 'No', 'blocknewproducts_home') && parent::isInstalled('blocknewproducts') && parent::getInstanceByName('blocknewproducts')->active
           || $page == 'index' && !$tool->params->checkValue('enable-effect', 'No', 'blockbestsellers_home') && parent::isInstalled('blockbestsellers') && parent::getInstanceByName('blockbestsellers')->active
           || !$tool->params->checkValue('enable-effect', 'No', 'blockviewed') && parent::isInstalled('blockviewed') && parent::getInstanceByName('blockviewed')->active
           || !$tool->params->checkValue('enable-effect', 'No', 'blockspecials') && parent::isInstalled('blockspecials') && parent::getInstanceByName('blockspecials')->active
           || (!$tool->params->checkValue('enable-effect', 'No', 'blocknewproducts') || ($page == 'index' && !$tool->params->checkValue('enable-effect', 'No', 'blocknewproducts_home'))) && parent::isInstalled('blocknewproducts') && parent::getInstanceByName('blocknewproducts')->active
           || (!$tool->params->checkValue('enable-effect', 'No', 'blockbestsellers') || ($page == 'index' && !$tool->params->checkValue('enable-effect', 'No', 'blockbestsellers_home'))) && parent::isInstalled('blockbestsellers') && parent::getInstanceByName('blockbestsellers')->active
          ) {
            // include headers
            $headers = $tool->getHeadersTemplate(_MODULE_DIR_.'magicslideshow');
            $headers .= '<script type="text/javascript" src="'._MODULE_DIR_.'magicslideshow/common.js"></script>';
            if($page == 'product' && !$tool->params->checkValue('enable-effect', 'No', 'product')) {
                $headers .= '
<script type="text/javascript">
</script>';
                if(!$GLOBALS['magictoolbox']['isProductScriptIncluded']) {
                    $headers .= '<script type="text/javascript" src="'._MODULE_DIR_.'magicslideshow/product.js"></script>';
                    $GLOBALS['magictoolbox']['isProductScriptIncluded'] = true;
                }
                //<style type="text/css"></style>';
            }
                $headers .= '
<script type="text/javascript">
    var isProductMagicSlideshowReady = false;
    MagicSlideshow.options[\'onready\'] = function(id) {
        if(id == \'productMagicSlideshow\') {
            isProductMagicSlideshowReady = true;
        }
    }
</script>
';
            /*
                Commented as discussion in issue #0021547
            */
            /*
            $headers .= '
            <!--[if !(IE 8)]>
            <style type="text/css">
                #center_column, #left_column, #right_column {overflow: hidden !important;}
            </style>
            <![endif]-->
            ';*/

            if($this->isSmarty3) {
                //Smarty v3 template engine
                $smarty->registerFilter('output', array(Module::getInstanceByName('magicslideshow'), 'parseTemplateCategory'));
            } else {
                //Smarty v2 template engine
                $smarty->register_outputfilter(array(Module::getInstanceByName('magicslideshow'), 'parseTemplateCategory'));
            }
            $GLOBALS['magictoolbox']['filters']['magicslideshow'] = 'parseTemplateCategory';

            // presta create new class every time when hook called
            // so we need save our data in the GLOBALS
            $GLOBALS['magictoolbox']['magicslideshow']['cookie'] = $params['cookie'];
            $GLOBALS['magictoolbox']['magicslideshow']['productsViewed'] = (isset($params['cookie']->viewed) AND !empty($params['cookie']->viewed)) ? explode(',', $params['cookie']->viewed) : array();

            $headers = '<!-- MAGICSLIDESHOW HEADERS START -->'.$headers.'<!-- MAGICSLIDESHOW HEADERS END -->';

        }

        return $headers;

    }

    public function hookProductFooter($params) {
        //we need save this data in the GLOBALS for compatible with some Prestashop module which reset the $product smarty variable
        $GLOBALS['magictoolbox']['magicslideshow']['product'] = array('id' => $params['product']->id, 'name' => $params['product']->name, 'link_rewrite' => $params['product']->link_rewrite);
        return '';
    }

    public function hookFooter($params) {

        if(!$this->isPrestahop15x) {

            $contents = ob_get_contents();
            ob_end_clean();

            $matches = array();
            $lang = isset($params['cart']->id_lang) ? $params['cart']->id_lang : 0;
            if(preg_match_all('/\[magicslideshow(?:\sid=(\d+(?:,\d+)*))?\]/', $contents, $matches, PREG_SET_ORDER)) {
                foreach($matches as $match) {
                    $contents = str_replace($match[0], $this->getCustomSlideshow(empty($match[1]) ? '' : $match[1], $lang, false), $contents);
                }
                $GLOBALS['magictoolbox']['magicslideshow']['headers'] = true;
            }

            if($GLOBALS['magictoolbox']['magicslideshow']['headers'] == false) {
                $contents = preg_replace('/<\!-- MAGICSLIDESHOW HEADERS START -->.*?<\!-- MAGICSLIDESHOW HEADERS END -->/is', '', $contents);
            } else {
                $contents = preg_replace('/<\!-- MAGICSLIDESHOW HEADERS (START|END) -->/is', '', $contents);
            }

            echo $contents;

        }

        return '';

    }

    public function hookDisplayTopColumn($params) {
        $page = $params['smarty']->{$this->getTemplateVars}('page_name');
        return $page == 'index' ? $this->hookHome() : '';
    }

    public function hookHome($params) {
        $tool = $this->loadTool();
        $tool->params->setProfile('homeslideshow');
        if($tool->params->checkValue('enable-effect', 'No')) return '';
        $lang = isset($params['cart']->id_lang) ? $params['cart']->id_lang : 0;
        $slideshow = $this->getCustomSlideshow('', $lang, true);
        if(!empty($slideshow)) $GLOBALS['magictoolbox']['magicslideshow']['headers'] = true;
        return $slideshow;
    }

    public function getCustomSlideshow($ids = '', $lang = 0, $enabledOnly = false) {
        $slideshow = '';
        $tool = $this->loadTool();
        $tool->params->setProfile('homeslideshow');
        if(empty($ids)) {
            $where = '';
            $order = 'ORDER BY `order`';
        } else {
            $where = '`id` IN ('.$ids.') AND ';
            $order = 'ORDER BY FIELD(`id`,'.$ids.')';
        }
        $where .= $enabledOnly ? '`enabled`=1 AND ' : '';
        $where .= $lang ? '(`lang`=0 OR `lang`='.$lang.') ' : '`lang`=0 ';
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'magicslideshow_images` WHERE '.$where.$order;
        $result = Db::getInstance()->ExecuteS($sql);
        if(is_array($result) && count($result)) {
            $imagesData = array();
            $thumbSuffix = $tool->params->getValue('selector-image');
            $thumbSuffix = $thumbSuffix ? '-'.$thumbSuffix : '';
            $imgSuffix = $tool->params->getValue('thumb-image');
            $imgSuffix = $imgSuffix ? '-'.$imgSuffix : '';
            $fullscreenSuffix = $tool->params->getValue('large-image');
            $fullscreenSuffix = $fullscreenSuffix ? '-'.$fullscreenSuffix : '';
            foreach($result as $row) {
                $imagesData[$row['id']]['link'] = $row['link'];
                $imagesData[$row['id']]['title'] = $row['title'];
                $imagesData[$row['id']]['description'] = htmlspecialchars_decode($row['description']);
                $imagesData[$row['id']]['thumb'] = _PS_IMG_.'magicslideshow/'.$row['name'].$thumbSuffix.'.'.$row['ext'];
                $imagesData[$row['id']]['img'] = _PS_IMG_.'magicslideshow/'.$row['name'].$imgSuffix.'.'.$row['ext'];
                $imagesData[$row['id']]['fullscreen'] = _PS_IMG_.'magicslideshow/'.$row['name'].$fullscreenSuffix.'.'.$row['ext'];
            }
            $slideshow = '<div class="MagicToolboxContainer">'.$tool->getMainTemplate($imagesData, array('id' => 'customSlideshow'.md5($where))).'</div>';
        }
        return $slideshow;
    }

    private static $outputMatches = array();

    public function prepareOutput($output, $index = 'DEFAULT') {

        if(!isset(self::$outputMatches[$index])) {
            preg_match_all('/<div [^>]*?class="[^"]*?MagicToolboxContainer[^"]*?".*?<\/div>\s/is', $output, self::$outputMatches[$index]);
            foreach(self::$outputMatches[$index][0] as $key => $match) {
                $output = str_replace($match, 'MAGICSLIDESHOW_MATCH_'.$index.'_'.$key.'_', $output);
            }
        } else {
            foreach(self::$outputMatches[$index][0] as $key => $match) {
                $output = str_replace('MAGICSLIDESHOW_MATCH_'.$index.'_'.$key.'_', $match, $output);
            }
            unset(self::$outputMatches[$index]);
        }
        return $output;

    }


    public function parseTemplateCategory($output, $smarty) {
        if($this->isSmarty3) {
            //Smarty v3 template engine
            //$currentTemplate = substr(basename($smarty->_current_file), 0, -4);
            $currentTemplate = substr(basename($smarty->template_resource), 0, -4);
            if($currentTemplate == 'breadcrumb') {
                $currentTemplate = 'product';
            } elseif($currentTemplate == 'pagination') {
                $currentTemplate = 'category';
            }
        } else {
            //Smarty v2 template engine
            $currentTemplate = $smarty->currentTemplate;
        }

        if($this->isPrestahop15x && $currentTemplate == 'layout') {

            $matches = array();
            $lang = intval($GLOBALS['magictoolbox']['magicslideshow']['cookie']->id_lang);
            if(preg_match_all('/\[magicslideshow(?:\sid=(\d+(?:,\d+)*))?\]/', $output, $matches, PREG_SET_ORDER)) {
                foreach($matches as $match) {
                    $output = str_replace($match[0], $this->getCustomSlideshow(empty($match[1]) ? '' : $match[1], $lang, false), $output);
                }
                $GLOBALS['magictoolbox']['magicslideshow']['headers'] = true;
            }

            if(version_compare(_PS_VERSION_, '1.5.5.0', '>=')) {
                //NOTE: because we do not know whether the effect is applied to the blocks in the cache
                $GLOBALS['magictoolbox']['magicslideshow']['headers'] = true;
            }
            //NOTE: full contents in prestashop 1.5.x
            if($GLOBALS['magictoolbox']['magicslideshow']['headers'] == false) {
                $output = preg_replace('/<\!-- MAGICSLIDESHOW HEADERS START -->.*?<\!-- MAGICSLIDESHOW HEADERS END -->/is', '', $output);
            } else {
                $output = preg_replace('/<\!-- MAGICSLIDESHOW HEADERS (START|END) -->/is', '', $output);
            }
            return $output;
        }

        switch($currentTemplate) {
            case 'search':
            case 'manufacturer':
                //$currentTemplate = 'manufacturer';
                break;
            case 'best-sales':
                $currentTemplate = 'bestsellerspage';
                break;
            case 'new-products':
                $currentTemplate = 'newproductpage';
                break;
            case 'prices-drop':
                $currentTemplate = 'specialspage';
                break;
            case 'blockbestsellers-home':
                $currentTemplate = 'blockbestsellers_home';
                break;
            case 'product-list'://for 'Layered navigation block'
                if(strpos($_SERVER['REQUEST_URI'], 'blocklayered-ajax.php') !== false) {
                    $currentTemplate = 'category';
                }
                break;
        }

        $tool = $this->loadTool();
        if(!$tool->params->profileExists($currentTemplate) || $tool->params->checkValue('enable-effect', 'No', $currentTemplate)) {
            return $output;
        }
        $tool->params->setProfile($currentTemplate);

        global $link;
        $cookie = &$GLOBALS['magictoolbox']['magicslideshow']['cookie'];
        if(method_exists($link, 'getImageLink')) {
            $_link = &$link;
        } else {
            //for Prestashop ver 1.1
            $_link = &$this;
        }

        $output = self::prepareOutput($output);

        switch($currentTemplate) {
            case 'homefeatured':
                $categoryID = $this->isPrestahop15x ? Context::getContext()->shop->getCategory() : 1;
                $category = new Category($categoryID);
                $nb = intval(Configuration::get('HOME_FEATURED_NBR'));//Number of product displayed
                $products = $category->getProducts(intval($cookie->id_lang), 1, ($nb ? $nb : 10));
                if(!is_array($products)) break;
                $pCount = count($products);
                if(!$pCount) break;
                $GLOBALS['magictoolbox']['magicslideshow']['headers'] = true;
                $productImagesData = array();
                $useLink = !$tool->params->checkValue('links', 'false');
                foreach($products as $p_key => $product) {
                    $productImagesData[$p_key]['link'] = $useLink?$link->getProductLink($product['id_product'], $product['link_rewrite'], isset($product['category']) ? $product['category'] : null):'';
                    $productImagesData[$p_key]['title'] = $product['name'];
                    $productImagesData[$p_key]['img'] = $_link->getImageLink($product['link_rewrite'], $product['id_image'], $tool->params->getValue('thumb-image'));
                    $productImagesData[$p_key]['thumb'] = $_link->getImageLink($product['link_rewrite'], $product['id_image'], $tool->params->getValue('selector-image'));
                    $productImagesData[$p_key]['fullscreen'] = $_link->getImageLink($product['link_rewrite'], $product['id_image'], $tool->params->getValue('large-image'));
                }
                $magicslideshow = $tool->getMainTemplate($productImagesData, array("id" => "homefeaturedMagicSlideshow"));
                if($this->isPrestahop16x) {
                    $magicslideshow = '<div id="homefeatured" class="MagicToolboxContainer homefeatured tab-pane">'.$magicslideshow.'</div>';
                }
                $pattern = '<ul[^>]*?>.*?<\/ul>';
                $output = preg_replace('/'.$pattern.'/is', $magicslideshow, $output);
                break;
            case 'product':
                if(!isset($GLOBALS['magictoolbox']['magicslideshow']['product'])) {
                    //for skip loyalty module product.tpl
                    break;
                }

                $images = $smarty->{$this->getTemplateVars}('images');
                $pCount = count($images);
                if(!$pCount) break;

                //$product = $smarty->tpl_vars['product'];
                //get some data from $GLOBALS for compatible with Prestashop modules which reset the $product smarty variable
                $product = &$GLOBALS['magictoolbox']['magicslideshow']['product'];

                $cover = $smarty->{$this->getTemplateVars}('cover');
                if(!isset($cover['id_image'])) {
                    break;
                }
                $coverImageIds = is_numeric($cover['id_image']) ? $product['id'].'-'.$cover['id_image'] : $cover['id_image'];


                $productImagesData = array();
                $ids = array();
                foreach($images as $image) {
                    $id_image = intval($image['id_image']);
                    $ids[] = $id_image;
                    //if($image['cover']) $coverID = $id_image;
                    $productImagesData[$id_image]['title'] = /*$product['name']*/$image['legend'];
                    $productImagesData[$id_image]['thumb'] = $_link->getImageLink($product['link_rewrite'], intval($product['id']).'-'.$id_image, $tool->params->getValue('selector-image'));
                    $productImagesData[$id_image]['fullscreen'] = $_link->getImageLink($product['link_rewrite'], intval($product['id']).'-'.$id_image, $tool->params->getValue('large-image'));
                    $productImagesData[$id_image]['img'] = $_link->getImageLink($product['link_rewrite'], intval($product['id']).'-'.$id_image, $tool->params->getValue('thumb-image'));
                }

                $GLOBALS['magictoolbox']['magicslideshow']['headers'] = true;

                $magicslideshow = $tool->getMainTemplate($productImagesData, array("id" => "productMagicSlideshow"));

                $magicslideshow .= '<script type="text/javascript">magictoolboxImagesOrder = ['.implode(',', $ids).'];</script>';

                //need img#bigpic for blockcart module
                $magicslideshow = '<div style="width:0px;height:0px;overflow:hidden;visibility:hidden;"><img id="bigpic" src="'.$productImagesData[$ids[0]]['img'].'" /></div>'.$magicslideshow;

                /*
                $imagePatternTemplate = '<img [^>]*?src="[^"]*?__SRC__"[^>]*>';
                $patternTemplate = '<a [^>]*>[^<]*'.$imagePatternTemplate.'[^<]*<\/a>|'.$imagePatternTemplate;
                $patternTemplate = '<span [^>]*?id="view_full_size"[^>]*>[^<]*'.
                                   '(?:<span [^>]*?class="[^"]*"[^>]*>[^<]*<\/span>[^<]*)*'.
                                   '(?:'.$patternTemplate.')[^<]*'.
                                   '(?:<span [^>]*?class="[^"]*?span_link[^"]*"[^>]*>.*?<\/span>[^<]*)*'.
                                   '<\/span>|'.$patternTemplate;
                //NOTE: added support custom theme #53897
                $patternTemplate = $patternTemplate.'|'.
                    '<div [^>]*?id="wrap"[^>]*>[^<]*'.
                    '<a [^>]*>[^<]*'.
                    '<span [^>]*?id="view_full_size"[^>]*>[^<]*'.
                    $imagePatternTemplate.'[^<]*'.
                    '<\/span>[^<]*'.
                    '<\/a>[^<]*'.
                    '<\/div>[^<]*'.
                    '<div [^>]*?class="[^"]*?zoom-b[^"]*"[^>]*>[^<]*'.
                    '<a [^>]*>[^<]*<\/a>[^<]*'.
                    '<\/div>';
                //NOTE: added support custom theme #54204
                $patternTemplate = $patternTemplate.'|'.
                    '<span [^>]*?id="view_full_size"[^>]*>[^<]*'.
                    '<a [^>]*>[^<]*'.
                    '<img [^>]*>[^<]*'.
                    $imagePatternTemplate.'[^<]*'.
                    '<span [^>]*?class="[^"]*?mask[^"]*"[^>]*>.*?<\/span>[^<]*'.
                    '<\/a>[^<]*'.
                    '<\/span>[^<]*';

                $patternTemplate = '(?:'.$patternTemplate.')';

                //$patternTemplate = '(<div[^>]*?id="image-block"[^>]*>[^<]*)'.$patternTemplate;//NOTE: we need this to determine the main image
                //NOTE: added support custom theme #53897
                $patternTemplate = '(<div [^>]*?(?:id="image-block"|class="[^"]*?image[^"]*")[^>]*>[^<]*)'.$patternTemplate;

                $srcPattern = preg_quote($_link->getImageLink($product['link_rewrite'], $coverImageIds, 'large'.$this->imageTypeSuffix), '/');
                $pattern = str_replace('__SRC__', $srcPattern, $patternTemplate);

                $replaced = 0;
                $output = preg_replace('/'.$pattern.'/is', '$1'.$magicslideshow, $output, -1, $replaced);
                if(!$replaced) {
                    $iTypes = $this->getImagesTypes();
                    foreach($iTypes as $iType) {
                        if($iType != 'large'.$this->imageTypeSuffix) {

                            $srcPattern = preg_quote($_link->getImageLink($product['link_rewrite'], $coverImageIds, $iType), '/');
                            $noImageSrcPattern = preg_quote($img_prod_dir.$lang_iso.'-default-'.$iType.'.jpg', '/');
                            $pattern = str_replace('__SRC__', $srcPattern, $patternTemplate);
                            $output = preg_replace('/'.$pattern.'/is', '$1'.$magicslideshow, $output, -1, $replaced);
                            if($replaced) break;
                        }
                    }
                }
                */

                //NOTE: common pattern to match div#image-block tag
                $pattern =  '(<div\b[^>]*?(?:\bid\s*+=\s*+"image-block"|\bclass\s*+=\s*+"[^"]*?\bimage\b[^"]*+")[^>]*+>)'.
                            '('.
                            '(?:'.
                                '[^<]++'.
                                '|'.
                                '<(?!/?div\b|!--)'.
                                '|'.
                                '<!--.*?-->'.
                                '|'.
                                '<div\b[^>]*+>'.
                                    '(?2)'.
                                '</div\s*+>'.
                            ')*+'.
                            ')'.
                            '</div\s*+>';
                //$replaced = 0;
                //preg_match_all('%'.$pattern.'%is', $output, $__matches, PREG_SET_ORDER);
                //NOTE: limit = 1 because pattern can be matched with other products, located below the main product
                $output = preg_replace('%'.$pattern.'%is', '$1'.$magicslideshow.'</div>', $output, 1/*, $replaced*/);

                //remove selectors
                //$output = preg_replace('/<div [^>]*?id="thumbs_list"[^>]*>.*?<\/div>/is', '', $output);
                //NOTE: added support custom theme #53897
                $output = preg_replace('/<div [^>]*?(?:id="thumbs_list"|class="[^"]*?image-additional[^"]*")[^>]*>.*?<\/div>/is', '', $output);

                //NOTE: div#views_block is parent for div#thumbs_list
                $output = preg_replace('/<div [^>]*?id="views_block"[^>]*>.*?<\/div>/is', '', $output);

                //#resetImages link
                $output = preg_replace('/<\!-- thumbnails -->[^<]*<p[^>]*><a[^>]+reset[^>]+>.*?<\/a><\/p>/is', '<!-- thumbnails -->', $output);
                //remove "View full size" link
                $output = preg_replace('/<li>[^<]*<span[^>]*?id="view_full_size"[^>]*?>[^<]*<\/span>[^<]*<\/li>/is', '', $output);
                //remove "Display all pictures" link
                $output = preg_replace('/<p[^>]*>[^<]*<span[^>]*?id="wrapResetImages"[^>]*>.*?<\/span>[^<]*<\/p>/is', '', $output);
                break;
            case 'blockspecials':
                if(version_compare(_PS_VERSION_, '1.4', '<')) {
                    $products = $this->getAllSpecial(intval($cookie->id_lang));
                } else {
                    $products = Product::getPricesDrop((int)($cookie->id_lang), 0, 10, false, 'position', 'asc');
                }
                if(!is_array($products)) break;
                $pCount = count($products);
                if(!$pCount) break;
                $GLOBALS['magictoolbox']['magicslideshow']['headers'] = true;
                $productImagesData = array();
                $useLink = !$tool->params->checkValue('links', 'false');

                foreach($products as $p_key => $product) {
                    if($useLink && (!Tools::getValue('id_product', false) || (Tools::getValue('id_product', false) != $product['id_product']))) {
                        $productImagesData[$p_key]['link'] = $link->getProductLink($product['id_product'], $product['link_rewrite'], isset($product['category']) ? $product['category'] : null);
                    } else {
                        $productImagesData[$p_key]['link'] = '';
                    }
                    $productImagesData[$p_key]['title'] = $product['name'];
                    $productImagesData[$p_key]['img'] = $_link->getImageLink($product['link_rewrite'], $product['id_image'], $tool->params->getValue('thumb-image'));
                    $productImagesData[$p_key]['thumb'] = $_link->getImageLink($product['link_rewrite'], $product['id_image'], $tool->params->getValue('selector-image'));
                    $productImagesData[$p_key]['fullscreen'] = $_link->getImageLink($product['link_rewrite'], $product['id_image'], $tool->params->getValue('large-image'));
                }

                $magicslideshow = $tool->getMainTemplate($productImagesData, array("id" => "blockspecialsMagicSlideshow"));
                $pattern = '<ul[^>]*?>.*?<\/ul>';
                $output = preg_replace('/'.$pattern.'/is', $magicslideshow, $output);
                break;
            case 'blockviewed':
                $productsViewed = $GLOBALS['magictoolbox']['magicslideshow']['productsViewed'];
                $pCount = count($productsViewed);
                if(!$pCount) break;
                $GLOBALS['magictoolbox']['magicslideshow']['headers'] = true;
                $productImagesData = array();
                $useLink = !$tool->params->checkValue('links', 'false');

                foreach($productsViewed as $id_product) {
                    $productViewedObj = new Product(intval($id_product), false, intval($cookie->id_lang));
                    if (!Validate::isLoadedObject($productViewedObj) OR !$productViewedObj->active)
                        continue;
                    else {
                        $images = $productViewedObj->getImages(intval($cookie->id_lang));
                        foreach($images as $image) {
                            if($image['cover']) {
                                $productViewedObj->cover = $productViewedObj->id.'-'.$image['id_image'];
                                $productViewedObj->legend = $image['legend'];
                                break;
                            }
                        }
                        if(!isset($productViewedObj->cover)) {
                            $productViewedObj->cover = Language::getIsoById($cookie->id_lang).'-default';
                            $productViewedObj->legend = '';
                        }
                        $lrw = $productViewedObj->link_rewrite;
                        if($useLink && (!Tools::getValue('id_product', false) || (Tools::getValue('id_product', false) != $id_product))) {
                            $productImagesData[$id_product]['link'] = $link->getProductLink($id_product, $lrw, $productViewedObj->category);
                        } else {
                            $productImagesData[$id_product]['link'] = '';
                        }
                        $productImagesData[$id_product]['title'] = $productViewedObj->name;
                        $productImagesData[$id_product]['img'] = $_link->getImageLink($lrw, $productViewedObj->cover, $tool->params->getValue('thumb-image'));
                        $productImagesData[$id_product]['thumb'] = $_link->getImageLink($lrw, $productViewedObj->cover, $tool->params->getValue('selector-image'));
                        $productImagesData[$id_product]['fullscreen'] = $_link->getImageLink($lrw, $productViewedObj->cover, $tool->params->getValue('large-image'));
                    }
                }
                $magicslideshow = $tool->getMainTemplate($productImagesData, array("id" => "blockviewedMagicSlideshow"));
                $pattern = '<ul[^>]*?>.*?<\/ul>';
                $output = preg_replace('/'.$pattern.'/is', $magicslideshow, $output);
                break;
            case 'blockbestsellers':
            case 'blockbestsellers_home':
            case 'blocknewproducts':
            case 'blocknewproducts_home':
                if(in_array($currentTemplate, array('blockbestsellers', 'blockbestsellers_home'))) {
                    $nb_products = $tool->params->getValue('max-number-of-products', $currentTemplate);
                    //$products = $smarty->{$this->getTemplateVars}('best_sellers');
                    //to get with description etc.
                    $products = ProductSale::getBestSales(intval($cookie->id_lang), 0, $nb_products);
                } else {
                    $products = $smarty->{$this->getTemplateVars}('new_products');
                }
                if(!is_array($products)) break;
                $pCount = count($products);
                if(!$pCount || !$products) break;
                $GLOBALS['magictoolbox']['magicslideshow']['headers'] = true;
                $productImagesData = array();
                $useLink = !$tool->params->checkValue('links', 'false');
                foreach($products as $p_key => $product) {
                    if($useLink && (!Tools::getValue('id_product', false) || (Tools::getValue('id_product', false) != $product['id_product']))) {
                        $productImagesData[$p_key]['link'] = $link->getProductLink($product['id_product'], $product['link_rewrite'], isset($product['category']) ? $product['category'] : null);
                    } else {
                        $productImagesData[$p_key]['link'] = '';
                    }
                    $productImagesData[$p_key]['title'] = $product['name'];
                    $productImagesData[$p_key]['img'] = $_link->getImageLink($product['link_rewrite'], $product['id_image'], $tool->params->getValue('thumb-image'));
                    $productImagesData[$p_key]['thumb'] = $_link->getImageLink($product['link_rewrite'], $product['id_image'], $tool->params->getValue('selector-image'));
                    $productImagesData[$p_key]['fullscreen'] = $_link->getImageLink($product['link_rewrite'], $product['id_image'], $tool->params->getValue('large-image'));
                }
                $magicslideshow = $tool->getMainTemplate($productImagesData, array("id" => $currentTemplate."MagicSlideshow"));
                if($this->isPrestahop16x) {
                    if($currentTemplate == 'blockbestsellers_home') {
                        $magicslideshow = '<div id="blockbestsellers" class="MagicToolboxContainer blockbestsellers tab-pane">'.$magicslideshow.'</div>';
                    } else if($currentTemplate == 'blocknewproducts_home') {
                        $magicslideshow = '<div id="blocknewproducts" class="MagicToolboxContainer blocknewproducts tab-pane active">'.$magicslideshow.'</div>';
                    }
                }
                $pattern = '<ul[^>]*?>.*?<\/ul>';
                $output = preg_replace('/'.$pattern.'/is', $magicslideshow, $output);
                break;
        }

        return self::prepareOutput($output);

    }

    public function getAllSpecial($id_lang, $beginning = false, $ending = false) {

        $currentDate = date('Y-m-d');
        $result = Db::getInstance()->ExecuteS('
        SELECT p.*, pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, p.`ean13`,
            i.`id_image`, il.`legend`, t.`rate`
        FROM `'._DB_PREFIX_.'product` p
        LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.intval($id_lang).')
        LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
        LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.intval($id_lang).')
        LEFT JOIN `'._DB_PREFIX_.'tax` t ON t.`id_tax` = p.`id_tax`
        WHERE (`reduction_price` > 0 OR `reduction_percent` > 0)
        '.((!$beginning AND !$ending) ?
            'AND (`reduction_from` = `reduction_to` OR (`reduction_from` <= \''.$currentDate.'\' AND `reduction_to` >= \''.$currentDate.'\'))'
        :
            ($beginning ? 'AND `reduction_from` <= \''.$beginning.'\'' : '').($ending ? 'AND `reduction_to` >= \''.$ending.'\'' : '')).'
        AND p.`active` = 1
        ORDER BY RAND()');

        if (!$result)
            return false;

        foreach ($result as $row)
            $rows[] = Product::getProductProperties($id_lang, $row);

        return $rows;
    }

    //for Prestashop ver 1.1
    public function getImageLink($name, $ids, $type = null) {
        return _THEME_PROD_DIR_.$ids.($type ? '-'.$type : '').'.jpg';
    }


    public function getProductDescription($id_product, $id_lang) {
        $sql = 'SELECT `description` FROM `'._DB_PREFIX_.'product_lang` WHERE `id_product` = '.(int)($id_product).' AND `id_lang` = '.(int)($id_lang);
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
        return isset($result[0]['description'])? $result[0]['description'] : '';
    }

    function fillDB() {
		$sql = 'INSERT INTO `'._DB_PREFIX_.'magicslideshow_settings` (`block`, `name`, `value`, `enabled`) VALUES
				(\'default\', \'thumb-image\', \'large\', 1),
				(\'default\', \'selector-image\', \'small\', 1),
				(\'default\', \'large-image\', \'original\', 1),
				(\'default\', \'width\', \'auto\', 1),
				(\'default\', \'height\', \'100%\', 1),
				(\'default\', \'orientation\', \'horizontal\', 1),
				(\'default\', \'arrows\', \'No\', 1),
				(\'default\', \'loop\', \'Yes\', 1),
				(\'default\', \'effect\', \'slide\', 1),
				(\'default\', \'effect-speed\', \'600\', 1),
				(\'default\', \'autoplay\', \'Yes\', 1),
				(\'default\', \'slide-duration\', \'3000\', 1),
				(\'default\', \'shuffle\', \'No\', 1),
				(\'default\', \'kenburns\', \'No\', 1),
				(\'default\', \'pause\', \'false\', 1),
				(\'default\', \'selectors\', \'none\', 1),
				(\'default\', \'selectors-style\', \'bullets\', 1),
				(\'default\', \'selectors-size\', \'45\', 1),
				(\'default\', \'selectors-eye\', \'Yes\', 1),
				(\'default\', \'caption\', \'No\', 1),
				(\'default\', \'caption-effect\', \'fade\', 1),
				(\'default\', \'fullscreen\', \'No\', 1),
				(\'default\', \'preload\', \'Yes\', 1),
				(\'default\', \'keyboard\', \'Yes\', 1),
				(\'default\', \'links\', \'_self\', 1),
				(\'default\', \'loader\', \'Yes\', 1),
				(\'default\', \'lazy-loading\', \'No\', 1),
				(\'default\', \'include-headers-on-all-pages\', \'No\', 1),
				(\'default\', \'show-message\', \'Yes\', 1),
				(\'default\', \'message\', \'\', 1),
				(\'product\', \'thumb-image\', \'large\', 0),
				(\'product\', \'selector-image\', \'small\', 0),
				(\'product\', \'large-image\', \'original\', 1),
				(\'product\', \'width\', \'auto\', 0),
				(\'product\', \'height\', \'100%\', 0),
				(\'product\', \'orientation\', \'horizontal\', 0),
				(\'product\', \'arrows\', \'No\', 0),
				(\'product\', \'loop\', \'Yes\', 0),
				(\'product\', \'effect\', \'slide\', 0),
				(\'product\', \'effect-speed\', \'600\', 0),
				(\'product\', \'autoplay\', \'Yes\', 0),
				(\'product\', \'slide-duration\', \'3000\', 0),
				(\'product\', \'shuffle\', \'No\', 0),
				(\'product\', \'kenburns\', \'No\', 0),
				(\'product\', \'pause\', \'false\', 0),
				(\'product\', \'selectors\', \'none\', 0),
				(\'product\', \'selectors-style\', \'bullets\', 0),
				(\'product\', \'selectors-size\', \'45\', 0),
				(\'product\', \'selectors-eye\', \'Yes\', 0),
				(\'product\', \'caption\', \'No\', 0),
				(\'product\', \'caption-effect\', \'fade\', 0),
				(\'product\', \'fullscreen\', \'No\', 0),
				(\'product\', \'preload\', \'Yes\', 0),
				(\'product\', \'keyboard\', \'Yes\', 0),
				(\'product\', \'loader\', \'Yes\', 0),
				(\'product\', \'lazy-loading\', \'No\', 0),
				(\'product\', \'enable-effect\', \'Yes\', 1),
				(\'product\', \'show-message\', \'Yes\', 0),
				(\'product\', \'message\', \'\', 0),
				(\'blocknewproducts\', \'thumb-image\', \'home\', 1),
				(\'blocknewproducts\', \'selector-image\', \'small\', 0),
				(\'blocknewproducts\', \'large-image\', \'original\', 1),
				(\'blocknewproducts\', \'width\', \'auto\', 0),
				(\'blocknewproducts\', \'height\', \'100%\', 0),
				(\'blocknewproducts\', \'orientation\', \'vertical\', 1),
				(\'blocknewproducts\', \'arrows\', \'No\', 0),
				(\'blocknewproducts\', \'loop\', \'Yes\', 0),
				(\'blocknewproducts\', \'effect\', \'slide\', 0),
				(\'blocknewproducts\', \'effect-speed\', \'600\', 0),
				(\'blocknewproducts\', \'autoplay\', \'Yes\', 0),
				(\'blocknewproducts\', \'slide-duration\', \'3000\', 0),
				(\'blocknewproducts\', \'shuffle\', \'No\', 0),
				(\'blocknewproducts\', \'kenburns\', \'No\', 0),
				(\'blocknewproducts\', \'pause\', \'false\', 0),
				(\'blocknewproducts\', \'selectors\', \'none\', 0),
				(\'blocknewproducts\', \'selectors-style\', \'bullets\', 0),
				(\'blocknewproducts\', \'selectors-size\', \'45\', 0),
				(\'blocknewproducts\', \'selectors-eye\', \'Yes\', 0),
				(\'blocknewproducts\', \'caption\', \'No\', 0),
				(\'blocknewproducts\', \'caption-effect\', \'fade\', 0),
				(\'blocknewproducts\', \'fullscreen\', \'No\', 0),
				(\'blocknewproducts\', \'preload\', \'Yes\', 0),
				(\'blocknewproducts\', \'keyboard\', \'Yes\', 0),
				(\'blocknewproducts\', \'links\', \'_self\', 0),
				(\'blocknewproducts\', \'loader\', \'Yes\', 0),
				(\'blocknewproducts\', \'lazy-loading\', \'No\', 0),
				(\'blocknewproducts\', \'enable-effect\', \'No\', 1),
				(\'blocknewproducts\', \'show-message\', \'No\', 1),
				(\'blocknewproducts\', \'message\', \'\', 0),
				(\'blocknewproducts_home\', \'thumb-image\', \'large\', 0),
				(\'blocknewproducts_home\', \'selector-image\', \'small\', 0),
				(\'blocknewproducts_home\', \'large-image\', \'original\', 1),
				(\'blocknewproducts_home\', \'width\', \'auto\', 0),
				(\'blocknewproducts_home\', \'height\', \'100%\', 0),
				(\'blocknewproducts_home\', \'orientation\', \'horizontal\', 0),
				(\'blocknewproducts_home\', \'arrows\', \'No\', 0),
				(\'blocknewproducts_home\', \'loop\', \'Yes\', 0),
				(\'blocknewproducts_home\', \'effect\', \'slide\', 0),
				(\'blocknewproducts_home\', \'effect-speed\', \'600\', 0),
				(\'blocknewproducts_home\', \'autoplay\', \'Yes\', 0),
				(\'blocknewproducts_home\', \'slide-duration\', \'3000\', 0),
				(\'blocknewproducts_home\', \'shuffle\', \'No\', 0),
				(\'blocknewproducts_home\', \'kenburns\', \'No\', 0),
				(\'blocknewproducts_home\', \'pause\', \'false\', 0),
				(\'blocknewproducts_home\', \'selectors\', \'none\', 0),
				(\'blocknewproducts_home\', \'selectors-style\', \'bullets\', 0),
				(\'blocknewproducts_home\', \'selectors-size\', \'45\', 0),
				(\'blocknewproducts_home\', \'selectors-eye\', \'Yes\', 0),
				(\'blocknewproducts_home\', \'caption\', \'No\', 0),
				(\'blocknewproducts_home\', \'caption-effect\', \'fade\', 0),
				(\'blocknewproducts_home\', \'fullscreen\', \'No\', 0),
				(\'blocknewproducts_home\', \'preload\', \'Yes\', 0),
				(\'blocknewproducts_home\', \'keyboard\', \'Yes\', 0),
				(\'blocknewproducts_home\', \'links\', \'_self\', 0),
				(\'blocknewproducts_home\', \'loader\', \'Yes\', 0),
				(\'blocknewproducts_home\', \'lazy-loading\', \'No\', 0),
				(\'blocknewproducts_home\', \'enable-effect\', \'No\', 1),
				(\'blocknewproducts_home\', \'show-message\', \'No\', 1),
				(\'blocknewproducts_home\', \'message\', \'\', 0),
				(\'blockbestsellers\', \'thumb-image\', \'home\', 1),
				(\'blockbestsellers\', \'selector-image\', \'small\', 0),
				(\'blockbestsellers\', \'large-image\', \'original\', 1),
				(\'blockbestsellers\', \'width\', \'auto\', 0),
				(\'blockbestsellers\', \'height\', \'100%\', 0),
				(\'blockbestsellers\', \'orientation\', \'vertical\', 1),
				(\'blockbestsellers\', \'arrows\', \'No\', 0),
				(\'blockbestsellers\', \'loop\', \'Yes\', 0),
				(\'blockbestsellers\', \'effect\', \'slide\', 0),
				(\'blockbestsellers\', \'effect-speed\', \'600\', 0),
				(\'blockbestsellers\', \'autoplay\', \'Yes\', 0),
				(\'blockbestsellers\', \'slide-duration\', \'3000\', 0),
				(\'blockbestsellers\', \'shuffle\', \'No\', 0),
				(\'blockbestsellers\', \'kenburns\', \'No\', 0),
				(\'blockbestsellers\', \'pause\', \'false\', 0),
				(\'blockbestsellers\', \'selectors\', \'none\', 0),
				(\'blockbestsellers\', \'selectors-style\', \'bullets\', 0),
				(\'blockbestsellers\', \'selectors-size\', \'45\', 0),
				(\'blockbestsellers\', \'selectors-eye\', \'Yes\', 0),
				(\'blockbestsellers\', \'caption\', \'No\', 0),
				(\'blockbestsellers\', \'caption-effect\', \'fade\', 0),
				(\'blockbestsellers\', \'fullscreen\', \'No\', 0),
				(\'blockbestsellers\', \'preload\', \'Yes\', 0),
				(\'blockbestsellers\', \'keyboard\', \'Yes\', 0),
				(\'blockbestsellers\', \'links\', \'_self\', 0),
				(\'blockbestsellers\', \'loader\', \'Yes\', 0),
				(\'blockbestsellers\', \'lazy-loading\', \'No\', 0),
				(\'blockbestsellers\', \'max-number-of-products\', \'1\', 0),
				(\'blockbestsellers\', \'enable-effect\', \'No\', 1),
				(\'blockbestsellers\', \'show-message\', \'No\', 1),
				(\'blockbestsellers\', \'message\', \'\', 0),
				(\'blockbestsellers_home\', \'thumb-image\', \'large\', 0),
				(\'blockbestsellers_home\', \'selector-image\', \'small\', 0),
				(\'blockbestsellers_home\', \'large-image\', \'original\', 1),
				(\'blockbestsellers_home\', \'width\', \'auto\', 0),
				(\'blockbestsellers_home\', \'height\', \'100%\', 0),
				(\'blockbestsellers_home\', \'orientation\', \'horizontal\', 0),
				(\'blockbestsellers_home\', \'arrows\', \'No\', 0),
				(\'blockbestsellers_home\', \'loop\', \'Yes\', 0),
				(\'blockbestsellers_home\', \'effect\', \'slide\', 0),
				(\'blockbestsellers_home\', \'effect-speed\', \'600\', 0),
				(\'blockbestsellers_home\', \'autoplay\', \'Yes\', 0),
				(\'blockbestsellers_home\', \'slide-duration\', \'3000\', 0),
				(\'blockbestsellers_home\', \'shuffle\', \'No\', 0),
				(\'blockbestsellers_home\', \'kenburns\', \'No\', 0),
				(\'blockbestsellers_home\', \'pause\', \'false\', 0),
				(\'blockbestsellers_home\', \'selectors\', \'none\', 0),
				(\'blockbestsellers_home\', \'selectors-style\', \'bullets\', 0),
				(\'blockbestsellers_home\', \'selectors-size\', \'45\', 0),
				(\'blockbestsellers_home\', \'selectors-eye\', \'Yes\', 0),
				(\'blockbestsellers_home\', \'caption\', \'No\', 0),
				(\'blockbestsellers_home\', \'caption-effect\', \'fade\', 0),
				(\'blockbestsellers_home\', \'fullscreen\', \'No\', 0),
				(\'blockbestsellers_home\', \'preload\', \'Yes\', 0),
				(\'blockbestsellers_home\', \'keyboard\', \'Yes\', 0),
				(\'blockbestsellers_home\', \'links\', \'_self\', 0),
				(\'blockbestsellers_home\', \'loader\', \'Yes\', 0),
				(\'blockbestsellers_home\', \'lazy-loading\', \'No\', 0),
				(\'blockbestsellers_home\', \'max-number-of-products\', \'1\', 0),
				(\'blockbestsellers_home\', \'enable-effect\', \'No\', 1),
				(\'blockbestsellers_home\', \'show-message\', \'No\', 1),
				(\'blockbestsellers_home\', \'message\', \'\', 0),
				(\'blockspecials\', \'thumb-image\', \'home\', 1),
				(\'blockspecials\', \'selector-image\', \'small\', 0),
				(\'blockspecials\', \'large-image\', \'original\', 1),
				(\'blockspecials\', \'width\', \'auto\', 0),
				(\'blockspecials\', \'height\', \'100%\', 0),
				(\'blockspecials\', \'orientation\', \'vertical\', 1),
				(\'blockspecials\', \'arrows\', \'No\', 0),
				(\'blockspecials\', \'loop\', \'Yes\', 0),
				(\'blockspecials\', \'effect\', \'slide\', 0),
				(\'blockspecials\', \'effect-speed\', \'600\', 0),
				(\'blockspecials\', \'autoplay\', \'Yes\', 0),
				(\'blockspecials\', \'slide-duration\', \'3000\', 0),
				(\'blockspecials\', \'shuffle\', \'No\', 0),
				(\'blockspecials\', \'kenburns\', \'No\', 0),
				(\'blockspecials\', \'pause\', \'false\', 0),
				(\'blockspecials\', \'selectors\', \'none\', 0),
				(\'blockspecials\', \'selectors-style\', \'bullets\', 0),
				(\'blockspecials\', \'selectors-size\', \'45\', 0),
				(\'blockspecials\', \'selectors-eye\', \'Yes\', 0),
				(\'blockspecials\', \'caption\', \'No\', 0),
				(\'blockspecials\', \'caption-effect\', \'fade\', 0),
				(\'blockspecials\', \'fullscreen\', \'No\', 0),
				(\'blockspecials\', \'preload\', \'Yes\', 0),
				(\'blockspecials\', \'keyboard\', \'Yes\', 0),
				(\'blockspecials\', \'links\', \'_self\', 0),
				(\'blockspecials\', \'loader\', \'Yes\', 0),
				(\'blockspecials\', \'lazy-loading\', \'No\', 0),
				(\'blockspecials\', \'enable-effect\', \'No\', 1),
				(\'blockspecials\', \'show-message\', \'No\', 1),
				(\'blockspecials\', \'message\', \'\', 0),
				(\'blockviewed\', \'thumb-image\', \'home\', 1),
				(\'blockviewed\', \'selector-image\', \'small\', 0),
				(\'blockviewed\', \'large-image\', \'original\', 1),
				(\'blockviewed\', \'width\', \'auto\', 0),
				(\'blockviewed\', \'height\', \'100%\', 0),
				(\'blockviewed\', \'orientation\', \'vertical\', 1),
				(\'blockviewed\', \'arrows\', \'No\', 0),
				(\'blockviewed\', \'loop\', \'Yes\', 0),
				(\'blockviewed\', \'effect\', \'slide\', 0),
				(\'blockviewed\', \'effect-speed\', \'600\', 0),
				(\'blockviewed\', \'autoplay\', \'Yes\', 0),
				(\'blockviewed\', \'slide-duration\', \'3000\', 0),
				(\'blockviewed\', \'shuffle\', \'No\', 0),
				(\'blockviewed\', \'kenburns\', \'No\', 0),
				(\'blockviewed\', \'pause\', \'false\', 0),
				(\'blockviewed\', \'selectors\', \'none\', 0),
				(\'blockviewed\', \'selectors-style\', \'bullets\', 0),
				(\'blockviewed\', \'selectors-size\', \'45\', 0),
				(\'blockviewed\', \'selectors-eye\', \'Yes\', 0),
				(\'blockviewed\', \'caption\', \'No\', 0),
				(\'blockviewed\', \'caption-effect\', \'fade\', 0),
				(\'blockviewed\', \'fullscreen\', \'No\', 0),
				(\'blockviewed\', \'preload\', \'Yes\', 0),
				(\'blockviewed\', \'keyboard\', \'Yes\', 0),
				(\'blockviewed\', \'links\', \'_self\', 0),
				(\'blockviewed\', \'loader\', \'Yes\', 0),
				(\'blockviewed\', \'lazy-loading\', \'No\', 0),
				(\'blockviewed\', \'enable-effect\', \'No\', 1),
				(\'blockviewed\', \'show-message\', \'No\', 1),
				(\'blockviewed\', \'message\', \'\', 0),
				(\'homefeatured\', \'thumb-image\', \'large\', 0),
				(\'homefeatured\', \'selector-image\', \'small\', 0),
				(\'homefeatured\', \'large-image\', \'original\', 1),
				(\'homefeatured\', \'width\', \'auto\', 0),
				(\'homefeatured\', \'height\', \'100%\', 0),
				(\'homefeatured\', \'orientation\', \'horizontal\', 0),
				(\'homefeatured\', \'arrows\', \'No\', 0),
				(\'homefeatured\', \'loop\', \'Yes\', 0),
				(\'homefeatured\', \'effect\', \'slide\', 0),
				(\'homefeatured\', \'effect-speed\', \'600\', 0),
				(\'homefeatured\', \'autoplay\', \'Yes\', 0),
				(\'homefeatured\', \'slide-duration\', \'3000\', 0),
				(\'homefeatured\', \'shuffle\', \'No\', 0),
				(\'homefeatured\', \'kenburns\', \'No\', 0),
				(\'homefeatured\', \'pause\', \'false\', 0),
				(\'homefeatured\', \'selectors\', \'none\', 0),
				(\'homefeatured\', \'selectors-style\', \'bullets\', 0),
				(\'homefeatured\', \'selectors-size\', \'45\', 0),
				(\'homefeatured\', \'selectors-eye\', \'Yes\', 0),
				(\'homefeatured\', \'caption\', \'No\', 0),
				(\'homefeatured\', \'caption-effect\', \'fade\', 0),
				(\'homefeatured\', \'fullscreen\', \'No\', 0),
				(\'homefeatured\', \'preload\', \'Yes\', 0),
				(\'homefeatured\', \'keyboard\', \'Yes\', 0),
				(\'homefeatured\', \'links\', \'_self\', 0),
				(\'homefeatured\', \'loader\', \'Yes\', 0),
				(\'homefeatured\', \'lazy-loading\', \'No\', 0),
				(\'homefeatured\', \'enable-effect\', \'No\', 1),
				(\'homefeatured\', \'show-message\', \'No\', 1),
				(\'homefeatured\', \'message\', \'\', 0),
				(\'homeslideshow\', \'thumb-image\', \'original\', 1),
				(\'homeslideshow\', \'selector-image\', \'small\', 0),
				(\'homeslideshow\', \'large-image\', \'original\', 1),
				(\'homeslideshow\', \'width\', \'auto\', 0),
				(\'homeslideshow\', \'height\', \'60%\', 1),
				(\'homeslideshow\', \'orientation\', \'horizontal\', 0),
				(\'homeslideshow\', \'arrows\', \'Yes\', 1),
				(\'homeslideshow\', \'loop\', \'Yes\', 0),
				(\'homeslideshow\', \'effect\', \'slide\', 0),
				(\'homeslideshow\', \'effect-speed\', \'600\', 0),
				(\'homeslideshow\', \'autoplay\', \'Yes\', 0),
				(\'homeslideshow\', \'slide-duration\', \'3000\', 0),
				(\'homeslideshow\', \'shuffle\', \'No\', 0),
				(\'homeslideshow\', \'kenburns\', \'No\', 0),
				(\'homeslideshow\', \'pause\', \'false\', 0),
				(\'homeslideshow\', \'selectors\', \'none\', 0),
				(\'homeslideshow\', \'selectors-style\', \'bullets\', 0),
				(\'homeslideshow\', \'selectors-size\', \'45\', 0),
				(\'homeslideshow\', \'selectors-eye\', \'Yes\', 0),
				(\'homeslideshow\', \'caption\', \'Yes\', 1),
				(\'homeslideshow\', \'caption-effect\', \'fade\', 0),
				(\'homeslideshow\', \'fullscreen\', \'No\', 0),
				(\'homeslideshow\', \'preload\', \'Yes\', 0),
				(\'homeslideshow\', \'keyboard\', \'Yes\', 0),
				(\'homeslideshow\', \'links\', \'_self\', 0),
				(\'homeslideshow\', \'loader\', \'Yes\', 0),
				(\'homeslideshow\', \'lazy-loading\', \'No\', 0),
				(\'homeslideshow\', \'enable-effect\', \'No\', 1),
				(\'homeslideshow\', \'show-message\', \'No\', 1),
				(\'homeslideshow\', \'message\', \'\', 0)';
		if(!$this->isPrestahop16x) {
			$sql = preg_replace('/\r\n\s*..(?:blockbestsellers_home|blocknewproducts_home)\b[^\r]*+/i', '', $sql);
			$sql = rtrim($sql, ',');
		}
		return Db::getInstance()->Execute($sql);
	}

	function getBlocks() {
		$blocks = array(
			'default' => 'Defaults',
			'product' => 'Product page',
			'blocknewproducts' => 'New products sidebar',
			'blocknewproducts_home' => 'New products block',
			'blockbestsellers' => 'Bestsellers sidebar',
			'blockbestsellers_home' => 'Bestsellers block',
			'blockspecials' => 'Specials sidebar',
			'blockviewed' => 'Viewed sidebar',
			'homefeatured' => 'Featured block',
			'homeslideshow' => 'Home page/custom slideshow'
		);
		if(!$this->isPrestahop16x) {
			unset($blocks['blockbestsellers_home'], $blocks['blocknewproducts_home']);
		}
		return $blocks;
	}

	function getMessages() {
		return array(
			'default' => array(
				'message' => array(
					'title' => 'Defaults message (under Magic Slideshow)',
					'translate' => $this->l('Defaults message (under Magic Slideshow)')
				)
			),
			'product' => array(
				'message' => array(
					'title' => 'Product page message (under Magic Slideshow)',
					'translate' => $this->l('Product page message (under Magic Slideshow)')
				)
			),
			'blocknewproducts' => array(
				'message' => array(
					'title' => 'New products sidebar message (under Magic Slideshow)',
					'translate' => $this->l('New products sidebar message (under Magic Slideshow)')
				)
			),
			'blocknewproducts_home' => array(
				'message' => array(
					'title' => 'New products block message (under Magic Slideshow)',
					'translate' => $this->l('New products block message (under Magic Slideshow)')
				)
			),
			'blockbestsellers' => array(
				'message' => array(
					'title' => 'Bestsellers sidebar message (under Magic Slideshow)',
					'translate' => $this->l('Bestsellers sidebar message (under Magic Slideshow)')
				)
			),
			'blockbestsellers_home' => array(
				'message' => array(
					'title' => 'Bestsellers block message (under Magic Slideshow)',
					'translate' => $this->l('Bestsellers block message (under Magic Slideshow)')
				)
			),
			'blockspecials' => array(
				'message' => array(
					'title' => 'Specials sidebar message (under Magic Slideshow)',
					'translate' => $this->l('Specials sidebar message (under Magic Slideshow)')
				)
			),
			'blockviewed' => array(
				'message' => array(
					'title' => 'Viewed sidebar message (under Magic Slideshow)',
					'translate' => $this->l('Viewed sidebar message (under Magic Slideshow)')
				)
			),
			'homefeatured' => array(
				'message' => array(
					'title' => 'Featured block message (under Magic Slideshow)',
					'translate' => $this->l('Featured block message (under Magic Slideshow)')
				)
			),
			'homeslideshow' => array(
				'message' => array(
					'title' => 'Home page/custom slideshow message (under Magic Slideshow)',
					'translate' => $this->l('Home page/custom slideshow message (under Magic Slideshow)')
				)
			)
		);
	}

	function getParamsMap() {
		$map = array(
			'default' => array(
				'Image type' => array(
					'thumb-image',
					'selector-image',
					'large-image'
				),
				'Common settings' => array(
					'width',
					'height',
					'orientation',
					'arrows',
					'loop',
					'effect',
					'effect-speed'
				),
				'Autoplay' => array(
					'autoplay',
					'slide-duration',
					'shuffle',
					'kenburns',
					'pause'
				),
				'Selectors' => array(
					'selectors',
					'selectors-style',
					'selectors-size',
					'selectors-eye'
				),
				'Caption' => array(
					'caption',
					'caption-effect'
				),
				'Other settings' => array(
					'fullscreen',
					'preload',
					'keyboard',
					'links',
					'loader',
					'lazy-loading'
				),
				'Miscellaneous' => array(
					'include-headers-on-all-pages',
					'show-message',
					'message'
				)
			),
			'product' => array(
				'Enable effect' => array(
					'enable-effect'
				),
				'Image type' => array(
					'thumb-image',
					'selector-image',
					'large-image'
				),
				'Common settings' => array(
					'width',
					'height',
					'orientation',
					'arrows',
					'loop',
					'effect',
					'effect-speed'
				),
				'Autoplay' => array(
					'autoplay',
					'slide-duration',
					'shuffle',
					'kenburns',
					'pause'
				),
				'Selectors' => array(
					'selectors',
					'selectors-style',
					'selectors-size',
					'selectors-eye'
				),
				'Caption' => array(
					'caption',
					'caption-effect'
				),
				'Other settings' => array(
					'fullscreen',
					'preload',
					'keyboard',
					'loader',
					'lazy-loading'
				),
				'Miscellaneous' => array(
					'show-message',
					'message'
				)
			),
			'blocknewproducts' => array(
				'Enable effect' => array(
					'enable-effect'
				),
				'Image type' => array(
					'thumb-image',
					'selector-image',
					'large-image'
				),
				'Common settings' => array(
					'width',
					'height',
					'orientation',
					'arrows',
					'loop',
					'effect',
					'effect-speed'
				),
				'Autoplay' => array(
					'autoplay',
					'slide-duration',
					'shuffle',
					'kenburns',
					'pause'
				),
				'Selectors' => array(
					'selectors',
					'selectors-style',
					'selectors-size',
					'selectors-eye'
				),
				'Caption' => array(
					'caption',
					'caption-effect'
				),
				'Other settings' => array(
					'fullscreen',
					'preload',
					'keyboard',
					'links',
					'loader',
					'lazy-loading'
				),
				'Miscellaneous' => array(
					'show-message',
					'message'
				)
			),
			'blocknewproducts_home' => array(
				'Enable effect' => array(
					'enable-effect'
				),
				'Image type' => array(
					'thumb-image',
					'selector-image',
					'large-image'
				),
				'Common settings' => array(
					'width',
					'height',
					'orientation',
					'arrows',
					'loop',
					'effect',
					'effect-speed'
				),
				'Autoplay' => array(
					'autoplay',
					'slide-duration',
					'shuffle',
					'kenburns',
					'pause'
				),
				'Selectors' => array(
					'selectors',
					'selectors-style',
					'selectors-size',
					'selectors-eye'
				),
				'Caption' => array(
					'caption',
					'caption-effect'
				),
				'Other settings' => array(
					'fullscreen',
					'preload',
					'keyboard',
					'links',
					'loader',
					'lazy-loading'
				),
				'Miscellaneous' => array(
					'show-message',
					'message'
				)
			),
			'blockbestsellers' => array(
				'Enable effect' => array(
					'enable-effect'
				),
				'Image type' => array(
					'thumb-image',
					'selector-image',
					'large-image'
				),
				'Common settings' => array(
					'width',
					'height',
					'orientation',
					'arrows',
					'loop',
					'effect',
					'effect-speed'
				),
				'Autoplay' => array(
					'autoplay',
					'slide-duration',
					'shuffle',
					'kenburns',
					'pause'
				),
				'Selectors' => array(
					'selectors',
					'selectors-style',
					'selectors-size',
					'selectors-eye'
				),
				'Caption' => array(
					'caption',
					'caption-effect'
				),
				'Other settings' => array(
					'fullscreen',
					'preload',
					'keyboard',
					'links',
					'loader',
					'lazy-loading'
				),
				'Miscellaneous' => array(
					'max-number-of-products',
					'show-message',
					'message'
				)
			),
			'blockbestsellers_home' => array(
				'Enable effect' => array(
					'enable-effect'
				),
				'Image type' => array(
					'thumb-image',
					'selector-image',
					'large-image'
				),
				'Common settings' => array(
					'width',
					'height',
					'orientation',
					'arrows',
					'loop',
					'effect',
					'effect-speed'
				),
				'Autoplay' => array(
					'autoplay',
					'slide-duration',
					'shuffle',
					'kenburns',
					'pause'
				),
				'Selectors' => array(
					'selectors',
					'selectors-style',
					'selectors-size',
					'selectors-eye'
				),
				'Caption' => array(
					'caption',
					'caption-effect'
				),
				'Other settings' => array(
					'fullscreen',
					'preload',
					'keyboard',
					'links',
					'loader',
					'lazy-loading'
				),
				'Miscellaneous' => array(
					'max-number-of-products',
					'show-message',
					'message'
				)
			),
			'blockspecials' => array(
				'Enable effect' => array(
					'enable-effect'
				),
				'Image type' => array(
					'thumb-image',
					'selector-image',
					'large-image'
				),
				'Common settings' => array(
					'width',
					'height',
					'orientation',
					'arrows',
					'loop',
					'effect',
					'effect-speed'
				),
				'Autoplay' => array(
					'autoplay',
					'slide-duration',
					'shuffle',
					'kenburns',
					'pause'
				),
				'Selectors' => array(
					'selectors',
					'selectors-style',
					'selectors-size',
					'selectors-eye'
				),
				'Caption' => array(
					'caption',
					'caption-effect'
				),
				'Other settings' => array(
					'fullscreen',
					'preload',
					'keyboard',
					'links',
					'loader',
					'lazy-loading'
				),
				'Miscellaneous' => array(
					'show-message',
					'message'
				)
			),
			'blockviewed' => array(
				'Enable effect' => array(
					'enable-effect'
				),
				'Image type' => array(
					'thumb-image',
					'selector-image',
					'large-image'
				),
				'Common settings' => array(
					'width',
					'height',
					'orientation',
					'arrows',
					'loop',
					'effect',
					'effect-speed'
				),
				'Autoplay' => array(
					'autoplay',
					'slide-duration',
					'shuffle',
					'kenburns',
					'pause'
				),
				'Selectors' => array(
					'selectors',
					'selectors-style',
					'selectors-size',
					'selectors-eye'
				),
				'Caption' => array(
					'caption',
					'caption-effect'
				),
				'Other settings' => array(
					'fullscreen',
					'preload',
					'keyboard',
					'links',
					'loader',
					'lazy-loading'
				),
				'Miscellaneous' => array(
					'show-message',
					'message'
				)
			),
			'homefeatured' => array(
				'Enable effect' => array(
					'enable-effect'
				),
				'Image type' => array(
					'thumb-image',
					'selector-image',
					'large-image'
				),
				'Common settings' => array(
					'width',
					'height',
					'orientation',
					'arrows',
					'loop',
					'effect',
					'effect-speed'
				),
				'Autoplay' => array(
					'autoplay',
					'slide-duration',
					'shuffle',
					'kenburns',
					'pause'
				),
				'Selectors' => array(
					'selectors',
					'selectors-style',
					'selectors-size',
					'selectors-eye'
				),
				'Caption' => array(
					'caption',
					'caption-effect'
				),
				'Other settings' => array(
					'fullscreen',
					'preload',
					'keyboard',
					'links',
					'loader',
					'lazy-loading'
				),
				'Miscellaneous' => array(
					'show-message',
					'message'
				)
			),
			'homeslideshow' => array(
				'Enable effect' => array(
					'enable-effect'
				),
				'Slideshow images' => array(
				),
				'Image type' => array(
					'thumb-image',
					'selector-image',
					'large-image'
				),
				'Common settings' => array(
					'width',
					'height',
					'orientation',
					'arrows',
					'loop',
					'effect',
					'effect-speed'
				),
				'Autoplay' => array(
					'autoplay',
					'slide-duration',
					'shuffle',
					'kenburns',
					'pause'
				),
				'Selectors' => array(
					'selectors',
					'selectors-style',
					'selectors-size',
					'selectors-eye'
				),
				'Caption' => array(
					'caption',
					'caption-effect'
				),
				'Other settings' => array(
					'fullscreen',
					'preload',
					'keyboard',
					'links',
					'loader',
					'lazy-loading'
				),
				'Miscellaneous' => array(
					'show-message',
					'message'
				)
			)
		);
		if(!$this->isPrestahop16x) {
			unset($map['blockbestsellers_home'], $map['blocknewproducts_home']);
		}
		return $map;
	}

}
