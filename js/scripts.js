(function($) {

	'use strict';

	// Remove the 'no-js' <body> class
	$('html').removeClass('no-js');

	// Enable FitVids on the content area
	fitvids('.content');

	//open navigation on mobile
	$('.rva-nav-trigger').on('click', function(){
		
		$('body').toggleClass('rva-no-scroll');

		$('header').toggleClass('nav-is-visible');

	});


	var type_elements = $('.ad-text').toArray();
	var dict = [];

	type_elements.forEach(function(element) {
		var last = dict.push({
    		element:		$(element).parent().eq(0),
    		description: 	$(element).find( "span" ).eq(0)  //.children('span').eq(0)
		});
		setAdRatios(dict[last-1].element, dict[last-1].description);
	}, this);
	
	$(window).on('resize', function(){
		dict.forEach(function(element) {
			setAdRatios(element.element, element.description);
		}, this);
	});

	function setAdRatios(element, textElement) {
		var height = element.css('height'),
			width = element.css('width');
		textElement.text('H: '+height + ' x '+ 'W: '+width);
	}

	// Smooth scroll for id links. 
	$('a[href^="#"]').on('click', function(event) {
		var target = $(this.getAttribute('href'));
		if( target.length ) {
			event.preventDefault();
			$('html, body').stop().animate({
				scrollTop: target.offset().top
			}, 1000);
		}
	});

	// Prevent youtube autoplay
	// TODO: hackish 80% case, maybe set this in the video plugin provider
	$('iframe[src*="https://www.youtube.com/embed/"]').each(function(index) {
		$(this).attr('src',     $(this).attr('src').replace('autoplay=1','autoplay=0'));
		return false;
	});

})( window.jQuery );