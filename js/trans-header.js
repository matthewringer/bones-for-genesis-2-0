(function($){
	'use strict';
  //todo: find a way to make the header not flash black on load....
  updateHeaderOpacity();
	//update selected navigation element
    $(window).on('scroll', function(){
		updateHeaderOpacity();
    });
	function updateHeaderOpacity() {
		var actual = $('#top'),
			actualHeight = actual.height(),
			topMargin = actual.css('marginTop').replace('px', '');

		if ( ( parseInt(actual.offset().top +  actualHeight - topMargin - actualHeight * .5 )  < $(window).scrollTop() +1 ) ) {
				$('.site-header ').css('opacity', 1);
			} else {
				$('.site-header ').css('opacity', .6);
			}
	}
})(window.jQuery);