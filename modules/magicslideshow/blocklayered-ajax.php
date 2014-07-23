<?php

chdir(dirname(__FILE__).'/../blocklayered');

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');

$magicslideshowInstance = Module::getInstanceByName('magicslideshow');

if($magicslideshowInstance && $magicslideshowInstance->active) {
    $magicslideshowTool = $magicslideshowInstance->loadTool();
    $magicslideshowFilter = 'parseTemplate'.($magicslideshowTool->type == 'standard' ? 'Standard' : 'Category');
    if($magicslideshowInstance->isSmarty3) {
        //Smarty v3 template engine
        $smarty->registerFilter('output', array($magicslideshowInstance, $magicslideshowFilter));
    } else {
        //Smarty v2 template engine
        $smarty->register_outputfilter(array($magicslideshowInstance, $magicslideshowFilter));
    }
    if(!isset($GLOBALS['magictoolbox']['filters'])) {
        $GLOBALS['magictoolbox']['filters'] = array();
    }
    $GLOBALS['magictoolbox']['filters']['magicslideshow'] = $magicslideshowFilter;
}

include(dirname(__FILE__).'/../blocklayered/blocklayered.php');

Context::getContext()->controller->php_self = 'category';
$blockLayered = new BlockLayered();
echo $blockLayered->ajaxCall();
