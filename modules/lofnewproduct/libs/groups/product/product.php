<?php

/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	$Subpackage
 * @copyright	Copyright (C) May 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website 	htt://landofcoder.com
 * @license		GNU General Public License version 2
 */
if (!defined('_CAN_LOAD_FILES_')) {
    define('_CAN_LOAD_FILES_', 1);
}
if (!class_exists('LofNewProductDataSource', false)) {

    class LofNewProductDataSource extends LofNewProductDataSourceBase {

        function getNewProducts($params) {
            global $cookie, $link;
            $id_lang = intval($cookie->id_lang);

            $maxDesc = $params->get('des_max_chars', 100);
            $limit_items = $params->get('limit_items', 5);
            $order_by = $params->get('order_by', 'date_add');
            $order_way = $params->get('order_way', 'ASC');
            $newProducts = Product::getNewProducts((int) $id_lang, 0, $limit_items, false, $order_by, $order_way, null);
            $newProducts = Product::getProductsProperties((int) $id_lang, $newProducts);
            foreach ($newProducts as $k => $v) {
                //add data for product
                $newProducts[$k]['description'] = substr(trim(strip_tags($newProducts[$k]['description_short'])), 0, $maxDesc);
                $newProducts[$k]['price'] = Tools::displayPrice($newProducts[$k]['price']);
                $newProducts[$k] = $this->parseImages($newProducts[$k], $params);
                $newProducts[$k] = $this->generateImages($newProducts[$k], $params);
            }

            return $newProducts;
        }

        /**
         * get main image and thumb
         *
         * @param poiter $row .
         * @return void
         */
        public function parseImages($product, $params) {
            global $link;

            $isRenderedMainImage = $params->get("cre_main_size", 0);
            $mainImageSize = $params->get("main_img_size", 'thickbox_default');

            if ($isRenderedMainImage) {
                if ((int) Configuration::get('PS_REWRITING_SETTINGS') == 1) {
                    $product["mainImge"] = $this->getImageLink($product["link_rewrite"], $product["id_image"]);
                } else {
                    $product["mainImge"] = $link->getImageLink($product["link_rewrite"], $product["id_image"]);
                }
            } else {
                $product["mainImge"] = $link->getImageLink($product["link_rewrite"], $product["id_image"], $mainImageSize);
            }
            $product["thumbImge"] = $product["mainImge"];

            return $product;
        }

    }

}
?>