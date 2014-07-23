var magicslideshowState = '';

$(document).ready(function() {
    if(typeof(window['display']) != 'undefined') {
        window['display_original'] = window['display'];
        window['display'] = function display(view) {
            if(typeof(MagicSlideshow) != 'undefined' && magicslideshowState != 'stopped') {
                magicslideshowState = 'stopped';
                MagicSlideshow.stop();
            }
            var r = window['display_original'].apply(window, arguments);
            if(typeof(MagicSlideshow) != 'undefined' && magicslideshowState != 'started') {
                magicslideshowState = 'started';
                MagicSlideshow.start();
            }
            return r;
        }
    }
});

if($ && $.ajax) {
    (function($) {
        //NOTE: override default ajax method
        var ajax = $.ajax;
        $.ajax = function(url, options) {
            var settings = {};
            if(typeof url === 'object') {
                settings = url;
            } else {
                settings = options || {};
            }
            if(settings.type == 'GET' && settings.url == baseDir+'modules/blocklayered/blocklayered-ajax.php') {
                if(typeof(MagicSlideshow) != 'undefined' && magicslideshowState != 'stopped') {
                    magicslideshowState = 'stopped';
                    MagicSlideshow.stop();
                }
                settings.url = baseDir+'modules/magicslideshow/blocklayered-ajax.php';
                settings.successOriginal = settings.success;
                settings.success = function(result) {
                    var r = settings.successOriginal.apply(settings, arguments);
                    if(typeof(MagicSlideshow) != 'undefined' && magicslideshowState != 'started') {
                        magicslideshowState = 'started';
                        MagicSlideshow.start();
                    }
                    return r;
                };
            }
            return ajax(url, options);
        }
    })($);
}
