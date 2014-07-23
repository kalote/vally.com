<?php

if(!defined('MagicSlideshowModuleCoreClassLoaded')) {

    define('MagicSlideshowModuleCoreClassLoaded', true);

    require_once(dirname(__FILE__).'/magictoolbox.params.class.php');

    /**
     * MagicSlideshowModuleCoreClass
     *
     */
    class MagicSlideshowModuleCoreClass {

        /**
         * MagicToolboxParamsClass class
         *
         * @var   MagicToolboxParamsClass
         *
         */
        var $params;

        /**
         * Tool type
         *
         * @var   string
         *
         */
        var $type = 'category';

        /**
         * Constructor
         *
         * @return void
         */
        function MagicSlideshowModuleCoreClass() {
            $this->params = new MagicToolboxParamsClass();
            $this->loadDefaults();
            $this->params->setMapping(array(
                'loop' => array('Yes' => 'true', 'No' => 'false'),
                'autoplay' => array('Yes' => 'true', 'No' => 'false'),
                'shuffle' => array('Yes' => 'true', 'No' => 'false'),
                'kenburns' => array('Yes' => 'true', 'No' => 'false'),
                'selectors-eye' => array('Yes' => 'true', 'No' => 'false'),
                'caption' => array('Yes' => 'true', 'No' => 'false'),
                'fullscreen' => array('Yes' => 'true', 'No' => 'false'),
                'preload' => array('Yes' => 'true', 'No' => 'false'),
                'keyboard' => array('Yes' => 'true', 'No' => 'false'),
                'loader' => array('Yes' => 'true', 'No' => 'false'),
                'arrows' => array('Yes' => 'true', 'No' => 'false'),
            ));
        }

        /**
         * Metod to get headers string
         *
         * @param string $jsPath  Path to JS file
         * @param string $cssPath Path to CSS file
         *
         * @return string
         */
        function getHeadersTemplate($jsPath = '', $cssPath = null) {
            //to prevent multiple displaying of headers
            if(!defined('MagicSlideshowModuleHeaders')) {
                define('MagicSlideshowModuleHeaders', true);
            } else {
                return '';
            }
            if($cssPath == null) $cssPath = $jsPath;
            $headers = array();
            $headers[] = '<!-- Magic Slideshow Prestashop module version v5.5.11 [v1.4.12:v2.0.13] -->';
            $headers[] = '<link type="text/css" href="'.$cssPath.'/magicslideshow.css" rel="stylesheet" media="screen" />';
            $headers[] = '<script type="text/javascript" src="'.$jsPath.'/magicslideshow.js"></script>';
            $headers[] = $this->getOptionsTemplate();
            return "\r\n".implode("\r\n", $headers)."\r\n";
        }

        /**
         * Metod to get options string
         *
         * @param mixed $id Extra options ID
         *
         * @return string
         */
        function getOptionsTemplate($id = null) {
            $addition = '';
            $selectorsSize = '';
            if($this->params->getParam('selectors-size')) {
                $selectorsSize = $this->params->getValue('selectors-size');
            } else {
                if($this->params->checkValue('selectors', array('bottom', 'top'))) {
                    $selectorsSize = $this->params->getValue('selector-max-height');
                } else if($this->params->checkValue('selectors', array('right', 'left'))) {
                    $selectorsSize = $this->params->getValue('selector-max-width');
                }
            }
            if($selectorsSize) {
                $addition .= "\n\t\t'selectors-size':'{$selectorsSize}',";
            }
            return "<script type=\"text/javascript\">\n\tMagicSlideshow.".($id == null?"options":"extraOptions.".$id)." = {{$addition}\n\t\t".$this->params->serialize(true, ",\n\t\t")."\n\t}\n</script>";
        }

        /**
         * Metod to get MagicSlideshow HTML
         *
         * @param array $data   MagicSlideshow items data
         * @param array $params Additional params
         *
         * @return string
         */
        function getMainTemplate($data, $params = array()) {

            $id = '';
            $width = '';
            $height = '';
            $html = array();

            extract($params);

            if(empty($width)) $width = ''; else $width = " width=\"{$width}\"";
            if(empty($height)) $height = ''; else $height = " height=\"{$height}\"";

            if(empty($id)) {
                $id = '';
            } else {
                $html[] = $this->getOptionsTemplate($id);
                $id = ' id="'.addslashes($id).'"';
            }

            $html[] = '<div'.$id.' class="MagicSlideshow"'.$width.$height.'>';

            foreach($data as $item) {

                $img = '';//main image
                $thumb = '';//thumbnail image
                $fullscreen = '';//image shown in Full Screen
                $link = '';
                $target = '';
                $alt = '';
                $title = '';
                $description = '';
                $width = '';
                $height = '';

                extract($item);

                if(empty($link)) {
                    $link = '';
                } else {
                    //NOTICE: use 'links' option ?
                    if(empty($target)) {
                        $target = '';
                    } else {
                        $target = ' target="'.$target.'"';
                    }
                    $link = $target.' href="'.addslashes($link).'"';
                }

                if(empty($alt)) {
                    $alt = '';
                } else {
                    $alt = htmlspecialchars(htmlspecialchars_decode($alt, ENT_QUOTES));
                }

                if(empty($title)) {
                    $caption = $title = '';
                } else {
                    $caption = $title;
                    $title = htmlspecialchars(htmlspecialchars_decode($title, ENT_QUOTES));
                    if(empty($alt)) {
                        $alt = $title;
                    }
                    $title = " title=\"{$title}\"";
                }

                if(empty($description)) {
                    $description = '';
                } else {
                    $description = preg_replace("/<(\/?)a([^>]*)>/is", "[$1a$2]", $description);
                    $description = "<span>{$description}</span>";
                }

                if(empty($width)) $width = ''; else $width = " width=\"{$width}\"";
                if(empty($height)) $height = ''; else $height = " height=\"{$height}\"";

                if(empty($img)) {
                    if(empty($caption)) {
                        $html[] = "<div>{$description}</div>";
                    } else {
                        $html[] = "<div><div data-mss-caption>{$caption}</div><div data-mss-thumbnail>{$description}</div></div>";
                    }
                } else {
                    if(empty($thumb)) $thumb = $img;
                    if(empty($fullscreen)) $fullscreen = $img;
                    $img = $this->params->checkValue('lazy-loading', 'No') ? ' src="'.$img.'"' : ' data-image="'.$img.'"';
                    $thumb = ' data-thumb-image="'.$thumb.'"';
                    $fullscreen = ' data-fullscreen-image="'.$fullscreen.'"';
                    $html[] = "<a{$link}><img{$width}{$height}{$img}{$thumb}{$fullscreen}{$title} alt=\"{$alt}\" />{$description}</a>";
                }

            }

            $html[] = '</div>';

            if($this->params->checkValue('show-message', 'Yes')) {
                $html[] = '<div class="MagicToolboxMessage">'.$this->params->getValue('message').'</div>';
            }

            return implode('', $html);
        }

        /**
         * Metod to load defaults options
         *
         * @return void
         */
        function loadDefaults() {
            $params = array("thumb-image"=>array("id"=>"thumb-image","group"=>"Image type","order"=>"10","default"=>"large","label"=>"What image type should be used as thumb image","description"=>"(NOTE: Original image can't be shown when 'Friendly URLs' option is enabled)","type"=>"array","subType"=>"select","values"=>array("original","large")),"selector-image"=>array("id"=>"selector-image","group"=>"Image type","order"=>"20","default"=>"small","label"=>"What image type should be used for selectors","description"=>"(NOTE: Original image can't be shown when 'Friendly URLs' option is enabled)","type"=>"array","subType"=>"select","values"=>array("original","small")),"large-image"=>array("id"=>"large-image","group"=>"Image type","order"=>"30","default"=>"thickbox","label"=>"What image type should be used as fullscreen image","description"=>"(NOTE: Original image can't be shown when 'Friendly URLs' option is enabled)","type"=>"array","subType"=>"select","values"=>array("original")),"width"=>array("id"=>"width","group"=>"Common settings","order"=>"10","default"=>"auto","label"=>"Slideshow width","description"=>"auto | pixels | percentage","type"=>"text","scope"=>"tool"),"height"=>array("id"=>"height","group"=>"Common settings","order"=>"20","default"=>"100%","label"=>"Slideshow height","description"=>"auto | pixels | percentage","type"=>"text","scope"=>"tool"),"orientation"=>array("id"=>"orientation","group"=>"Common settings","order"=>"30","default"=>"horizontal","label"=>"Orientation of slideshow","type"=>"array","subType"=>"radio","values"=>array("horizontal","vertical"),"scope"=>"tool"),"arrows"=>array("id"=>"arrows","group"=>"Common settings","order"=>"40","default"=>"No","label"=>"Show arrows","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"loop"=>array("id"=>"loop","group"=>"Common settings","order"=>"45","default"=>"Yes","label"=>"Continue slideshow after the last slide","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"effect"=>array("id"=>"effect","group"=>"Common settings","order"=>"50","default"=>"slide","label"=>"Effect for slide changing","description"=>"milliseconds","type"=>"array","subType"=>"radio","values"=>array("slide","fade","dissolve"),"scope"=>"tool"),"effect-speed"=>array("id"=>"effect-speed","group"=>"Common settings","order"=>"60","default"=>"600","label"=>"Duration of the effects in milliseconds","type"=>"num","scope"=>"tool"),"autoplay"=>array("id"=>"autoplay","group"=>"Autoplay","order"=>"10","default"=>"Yes","label"=>"Autoplay slideshow after initialization","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"slide-duration"=>array("id"=>"slide-duration","group"=>"Autoplay","order"=>"20","default"=>"3000","label"=>"Time to play each slide in milliseconds","description"=>"milliseconds","type"=>"num","scope"=>"tool"),"shuffle"=>array("id"=>"shuffle","group"=>"Autoplay","order"=>"30","default"=>"No","label"=>"Shuffle slides order","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"kenburns"=>array("id"=>"kenburns","group"=>"Autoplay","order"=>"40","default"=>"No","label"=>"Ken Burns effect on slides","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"pause"=>array("id"=>"pause","group"=>"Autoplay","order"=>"50","default"=>"false","label"=>"Pause autoplay","type"=>"array","subType"=>"radio","values"=>array("hover","click","selector-click","false"),"scope"=>"tool"),"selectors"=>array("id"=>"selectors","group"=>"Selectors","order"=>"10","default"=>"none","label"=>"How to show selectors","type"=>"array","subType"=>"radio","values"=>array("bottom","top","right","left","none"),"scope"=>"tool"),"selectors-style"=>array("id"=>"selectors-style","group"=>"Selectors","order"=>"20","default"=>"bullets","label"=>"Style of the selectors","type"=>"array","subType"=>"radio","values"=>array("bullets","thumbnails"),"scope"=>"tool"),"selectors-size"=>array("id"=>"selectors-size","group"=>"Selectors","order"=>"30","default"=>"45","label"=>"Size of selectors","description"=>"pixels | size (e.g. 90x60)","type"=>"text","scope"=>"tool"),"selectors-eye"=>array("id"=>"selectors-eye","group"=>"Selectors","order"=>"40","default"=>"Yes","label"=>"Nice highlighter of active selector","description"=>"effective when selectors-style is set to thumbnails","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"caption"=>array("id"=>"caption","group"=>"Caption","order"=>"10","default"=>"No","label"=>"Display caption for a slide","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"caption-effect"=>array("id"=>"caption-effect","group"=>"Caption","order"=>"20","default"=>"fade","label"=>"Effect for caption changing","type"=>"array","subType"=>"radio","values"=>array("fade","dissolve","fixed"),"scope"=>"tool"),"fullscreen"=>array("id"=>"fullscreen","group"=>"Other settings","order"=>"10","default"=>"No","label"=>"Enable Full Screen slideshow","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"preload"=>array("id"=>"preload","group"=>"Other settings","order"=>"20","default"=>"Yes","label"=>"Load images at start or on demand","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"keyboard"=>array("id"=>"keyboard","group"=>"Other settings","order"=>"30","default"=>"Yes","label"=>"Change slides with keyboard left and right arrows","description"=>"always enabled in Full Screen mode","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"links"=>array("id"=>"links","group"=>"Other settings","order"=>"40","default"=>"_self","label"=>"Page where to open links associated with image slides","description"=>"use false to disable links","type"=>"array","subType"=>"radio","values"=>array("_self","_blank","false"),"scope"=>"tool"),"loader"=>array("id"=>"loader","group"=>"Other settings","order"=>"50","default"=>"Yes","label"=>"Enable loading icon","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"lazy-loading"=>array("id"=>"lazy-loading","group"=>"Other settings","order"=>"70","default"=>"No","label"=>"Lazy image loading","type"=>"array","subType"=>"radio","values"=>array("Yes","No")),"max-number-of-products"=>array("id"=>"max-number-of-products","group"=>"Miscellaneous","order"=>"0","default"=>"1","label"=>"Products displayed","description"=>"Set the number of products to be displayed in this block","type"=>"num"),"enable-effect"=>array("id"=>"enable-effect","group"=>"Miscellaneous","order"=>"10","default"=>"Yes","label"=>"Enable effect","type"=>"array","subType"=>"select","values"=>array("Yes","No")),"include-headers-on-all-pages"=>array("id"=>"include-headers-on-all-pages","group"=>"Miscellaneous","order"=>"21","default"=>"No","label"=>"Include headers on all pages","description"=>"To be able to apply an effect on any page","type"=>"array","subType"=>"radio","values"=>array("Yes","No")),"show-message"=>array("id"=>"show-message","group"=>"Miscellaneous","order"=>"200","default"=>"Yes","label"=>"Show message under slideshow","type"=>"array","subType"=>"radio","values"=>array("Yes","No")),"message"=>array("id"=>"message","group"=>"Miscellaneous","order"=>"210","default"=>"","label"=>"Message under slideshow","type"=>"text"));
            $this->params->appendParams($params);
        }

    }

}

?>