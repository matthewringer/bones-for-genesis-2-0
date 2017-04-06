jQuery(function($){

	let parent = $('.post-listing').parent();
	$( '<div class="load-more"><i class="spinner"></i><span class="sr-only">Loading...</span></div>' ).appendTo( parent );

	var button = $('.load-more'); //marker for the bottom of the page.
	var page =  parseInt(rvaloadmore.startpage);
	var max_pages = -1;
	var loading = false;
	var scrollHandling = {
	    allow: true,
	    reallow: function() {
	        scrollHandling.allow = true;
	    },
	    delay: 200 //(milliseconds) adjust to the highest acceptable value
	};

	//todo: need to check for a corner case if the scrolling is already at the bottom when the ajax reply comes. 
	handleScroll();
	setTimeout( handleScroll, 3000 );
	$(window).scroll( handleScroll );

	function handleScroll() {

		if( ! loading && scrollHandling.allow ) {
			scrollHandling.allow = false;
			setTimeout(scrollHandling.reallow, scrollHandling.delay);

			//var offset = $(button).offset().top - $(window).scrollTop();

			if( isScrolledIntoView( '.load-more' ) && max_pages >= page || max_pages == -1 ){
				loading = true;
				$('.spinner').toggle(loading);
				var data = {
					action: 'rva_ajax_load_more',
					nonce: rvaloadmore.nonce,
					page: page,
					query: rvaloadmore.query,
					thumb_style: rvaloadmore.thumb_style,
					layout: rvaloadmore.layout
				};
				$.post(rvaloadmore.url, data, function(res) {
					if( res.success) {
						$('.post-listing').append( res.data.thumbs );
						$('.post-listing').parent().append( button ); // move the load target to the bottom of the page.
						page = page + 1;
						max_pages = res.data.max_pages;
						loading = false;
						$('.spinner').toggle(loading);
					} else {
						 console.log(res);
					}
				}).fail(function(xhr, textStatus, e) {
					console.log(xhr.responseText);
				});

			}
		}
	}

	function isScrolledIntoView(elem) {

		var docViewTop = $(window).scrollTop();
		var docViewBottom = docViewTop + $(window).height();

		var elemTop = $(elem).offset().top;
		var elemBottom = elemTop + $(elem).height();
		var con1 = (elemBottom <= docViewBottom);
		var con2 = (elemTop >= docViewTop);
		var result = ( con1 && con2 );
		return result;

	}

});