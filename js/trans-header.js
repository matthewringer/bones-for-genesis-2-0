/*jshint esversion: 6 */
(function($){
	'use strict';
  //todo: find a way to make the header not flash black on load....
  updateHeaderOpacity();
	//update selected navigation element
    $(window).on('scroll', function(){
		updateHeaderOpacity();
    });
	function updateHeaderOpacity() {
			let header = $('header').height();
			let scrollTop = $(window).scrollTop() +1;
		if ( header < scrollTop ) {
				$('.site-header')[0].classList.remove('rva-header-trans');
			} else {
				$('.site-header')[0].classList.add('rva-header-trans');
			}
	}
})(window.jQuery);