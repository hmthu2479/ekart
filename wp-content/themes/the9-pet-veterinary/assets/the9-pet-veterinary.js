;(function($) {
'use strict'
	// Dom Ready
	var the9_preloader_init = function(action, element) {
	    if (action === 'show') {
	        $('body').addClass('overlay--enabled');
	    }

	    var runLoader = function() {
	        if ($(element).length) {
	            $(element).find('.preloader-animation').remove();
	            $(element).find('.loader').addClass('loaded');
	            $('body').removeClass('overlay--enabled');

	            setTimeout(function() {
	                $(element).remove();
	            }, 1000);
	        }
	    };

	    if (document.readyState === 'complete') {
	        runLoader(); // already loaded
	    } else {
	        $(window).one('load', runLoader); // wait for load, run once
	    }
	};
	$(function() {
		
	if( $('#the9_preloader').length ){
			the9_preloader_init('show', '#the9_preloader');
		}
    
		
	});
})(jQuery);