var rva = (function ($) {
	var module = {};

	module.closeAll = function(selector) {
		let root = $(selector);
		let accordian = $( $( root ).children('.rva-accordian')[0] );
		if( !root.hasClass('open') ) {
			accordian.height(0);
		}
	}

	module.toggleOpen = function(e){

		let root = $(this).parent();
		let accordian = $( $( root ).find('.rva-accordian')[0] );
		let eventGroup = $( accordian.find('.rva-event-group')[0] );

		if( root.hasClass('open') ) {
			root.removeClass('open');
			accordian.height(0);
		} else {
			root.addClass('open');
			accordian.height(eventGroup.outerHeight(true));
		}
	};

	$.fn.once = function(a, b) {
		return this.each(function() {
			$(this).off(a).on(a,b);
		});
	};

	return module;

}(jQuery));

rva.closeAll('.event-list-date');
$('.open-trigger').once('click', rva.toggleOpen);

(function($, rva){

	let parent = $('.post-listing').parent();
	$( '<div class="load-more"><i class="spinner"></i><span class="sr-only">Loading...</span></div>' ).appendTo( parent );

	var button = $(rvaloadmore.button_selector); //marker for the bottom of the page.
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
			if( isScrolledIntoView( '.load-more' ) && max_pages >= page || max_pages == -1 ){
				loading = true;
				$('.spinner').toggle(loading);
				var data = {
					action: rvaloadmore.action, //'rva_ajax_load_more',
					nonce: rvaloadmore.nonce,
					page: page,
					query: rvaloadmore.query,
					thumb_style: rvaloadmore.thumb_style,
					layout: rvaloadmore.layout
				};
				$.post(rvaloadmore.url, data, function(res) {
					if( res.success) {

						if(rvaloadmore.layout === 'events'){
							appendEvents(res.data.thumbs, button);
						} else {
							appendPosts(res.data.thumbs, button);
						}


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

	function appendEvents(posts, btn ){
		[...$(posts)].forEach( x => {

			let date = $(x)[0].dataset['date'];
			let displayDate = $(x)[0].dataset['displayDate'];
			let slider = $( `div.event-list-date[data-date="${date}"]` );
			let id = $(x)[0].dataset['id'];

			if(slider.length === 0) {
				$('.post-listing').append(
				`<div class="event-list-date" data-date="${date}">
					<i class="fa fa-caret-right open-trigger" aria-hidden="true"></i>
					<h3 class="open-trigger">${displayDate}</h3>
					<div class="rva-accordian" >
						<div class="rva-event-group">
						</div>
					</div>
				</div>`);
				rva.closeAll(`div.event-list-date[data-date="${date}"]`);
			}

			// append to the date group
			let group = $(`div.event-list-date[data-date="${date}"]`);

			group.find('.rva-event-group').append(x);
			$.when( $(`article[data-ID="${id}"]`).length > 0 ).then(
				function(){
					group.find('.open-trigger').once('click', rva.toggleOpen);
				}
			);

			//move load more button;
			$('.post-listing').parent().append( btn );
		} );
	}

	function appendPosts( posts, btn ) {
		$('.post-listing').append( posts );
		$('.post-listing').parent().append( btn ); // move the load target to the bottom 
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

}(jQuery, rva));


