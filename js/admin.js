(function($) {
	'use strict';

	// Toggle the related MetaBoxes for post format type video
	let toggleVideoMeta = function(show){
		$('#featured-video-plus-box').toggle(show);
		$('#video_thumbnail').toggle(show);
		$('#rva_post_video_runtime_box').toggle(show);
		$('#postimagediv').toggle(!show);
	}

	toggleVideoMeta($('#post-format-video').is(':checked'));
	$('input[name=post_format]:radio').change(function(){
		toggleVideoMeta($('#post-format-video').is(':checked'));
	});

})( window.jQuery );