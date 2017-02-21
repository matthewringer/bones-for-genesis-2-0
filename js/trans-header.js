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
				$('.site-header')[0].classList.add('rva-header-trans'); //.css('background-color', 'rgba(13, 13, 13, 1)');
			} else {
				$('.site-header')[0].classList.remove('rva-header-trans'); //.css('background-color', 'rgba(13, 13, 13, .6)');
			}
	}
})(window.jQuery);