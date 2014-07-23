
var magictoolboxImagesOrder = [];

window['displayImage'] = function(jQuerySetOfAnchors) {

}

window['findCombinationOriginal'] = window['findCombination'];
window['findCombination'] = function(firstTime) {
    window['findCombinationOriginal'].apply(window, arguments);
    if(typeof(firstTime) != 'undefined' && firstTime) {
        return;
    }
    //NOTE: check if MagicSlideshow is ready
    if(!isProductMagicSlideshowReady) {
        //NOTE: does not scroll the slideshow until it is ready
        return;
    }
    var idCombination = $('#idCombination').val();
    for(var i in combinations) {
        if(combinations[i]['idCombination'] == idCombination) {
            var position = jQuery.inArray(combinations[i]['image'], magictoolboxImagesOrder);
            MagicSlideshow.jump('productMagicSlideshow', position+1);
            $('#bigpic').attr('src', $('#productMagicSlideshow .mss-slide-wrapper img').get(position).src);
            break;
        }
    }
}

window['refreshProductImagesOriginal'] = window['refreshProductImages'];
window['refreshProductImages'] = function(id_product_attribute) {
}

