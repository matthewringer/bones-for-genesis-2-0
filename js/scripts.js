(function($) {

	'use strict';

	// Remove the 'no-js' <body> class
	$('html').removeClass('no-js');

	// Enable FitVids on the content area
	fitvids('.content');

	//open navigation on mobile
	$('.cd-nav-trigger').on('click', function(){
		$('header').toggleClass('nav-is-visible');
	});

})( window.jQuery );

(function($){
	'use strict';
	//update selected navigation element
    $(window).on('scroll', function(){
		updateHeaderOpacity();
    });
	function updateHeaderOpacity() {
		var actual = $('#top'),
			actualHeight = actual.height(),
			topMargin = actual.css('marginTop').replace('px', '');

		if ( ( parseInt(actual.offset().top +  actualHeight - topMargin - actualHeight * .5 )  < $(window).scrollTop() +1 ) ) {
				$('.site-header .wrap').css('opacity', 1);
			} else {
				$('.site-header .wrap').css('opacity', .6);
			}
	}
})(window.jQuery);