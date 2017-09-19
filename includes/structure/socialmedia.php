<?php

// Override for links links for posts before date
add_filter('post_link', function ($permalink, $post, $leavename) {
	if(get_the_date('Y-m-d') < '2017-09-19' ){
		$permalink = preg_replace('/\.html$/', '/', $permalink);
	} 
	return $permalink;
}, 10, 3);

/**
 * Facebook Open Graph Meta
 *
 * @since 1.0.0
 */
function facebook_og_meta() {
	?>
		<!-- Facebook Open Graph Tags -->
		<meta property="og:site_name"		content="" />
		<meta property="og:url" 			content="<?php echo get_permalink() ?>" />
		<meta property="og:type" 			content="article" />
		<meta property="og:title" 			content="<?php echo get_the_title(); ?>" />
		<meta property="og:description"		content="<?php echo rva_get_excerpt(500, 'content'); ?>" /> 
		<meta property="og:image" 			content="<?php echo get_the_post_thumbnail_url(); ?>" />
		<meta property="og:site_name"		content="RVA Magazine" />
		<meta property="og:image:width"		content="" />
		<meta property="og:image:height"	content="" />
		<meta property="og:image:height"	content="" />
		
		<meta name="twitter:card" 			content="summary_large_image">
		<meta name="twitter:image" 			content="<?php echo get_the_post_thumbnail_url(); ?>">
		<meta name="twitter:site" 			content="<?php echo parse_twitter_handle(genesis_get_option( 'rva_socialmedia_twitter_url', RVA_SETTINGS_FIELD )); ?>"> <!-- site's twitter handle -->
		<meta name="twitter:creator" 		content="<?php echo parse_twitter_handle(get_the_author_meta( 'twitter' ) ); ?> "> <!-- creator's twitter handle -->
		<meta name="twitter:title" 			content="<?php echo get_the_title(); ?>"> 
		<meta name="twitter:description" 	content="<?php echo wp_strip_all_tags(get_the_excerpt()); ?>">

		<meta name="author" 				content="<?php echo get_the_author(); ?>">
		<meta name="news_keywords" 			content="<?php echo_tags( ); ?>">
		<meta name="keywords" 				content="<?php echo_tags( ); ?>">
		<meta name="thumbnail" 				content="<?php echo get_the_post_thumbnail_url(); ?>">
		<meta name="description" 			content="<?php echo rva_get_excerpt(500, 'content'); ?>">
		<meta name="title"					content="<?php echo get_the_title(); ?>">

	<?php
}

function echo_tags($count = 9 ) {
	$tags = get_the_tags();
	if(is_array($tags)){
		$tags = array_slice($tags, 0, $count);
		foreach ( $tags as $tag) { 
			echo $tag->name.', '; 
		}
	}
	echo 'Richmond VA';
}

//
function parse_twitter_handle($url) {
	$twitter_url = parse_url($url);
	return str_replace('/', '@', $twitter_url['path']); 
}



/*
 * Facebook JS SDK
 *
 * @since 1.0.0
 */
function facebook_js_sdk() {
	$app_id = genesis_get_option('rva_facebook_appid' ,RVA_SETTINGS_FIELD);
	?>
		<!-- Load Facebook SDK for JavaScript -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8<?php echo (isset( $app_id )) ? '&appId='.$app_id : ''; ?>" ;  //TODO: hardcoded app id...
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	<?php
}

/*
 * Facebook Share Button
 *
 * @since 1.0.0
 */
function facebook_share_btn() {
	?>
		<!-- Your share button code -->
		<div class="fb-share-button" 
			data-href="<?php echo get_permalink(); ?>" 
			data-layout="button_count"
			data-size="small" 
			data-mobile-iframe="false"
			target="_blank"
			href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">
		</div>
	<?php
}

function facebook_comments( $atts ) {
	global $wpdb;
	global $post;
	extract( shortcode_atts( [ 
		'width' => '500px', 
		'num_posts' => '5', 
		'post_id' => $post->ID, 
		'colorscheme' => 'dark', 
		'mobile' => 'false' 
	], $atts) );
	
	$permalink = 'https://rvamag.com' + $wpdb->get_var( "SELECT old_url FROM wp_fg_redirect  WHERE id = $post_id", 0, 0 );
	if( $permalink == "" ) $permalink = get_permalink($post->ID); 

	return vsprintf('<div id="comments" class="fb-comments" data-width="%s" data-mobile="%s" data-href="%s" data-colorscheme="%s" data-numposts="%s"></div>',
	[
		$width,
		$mobile,
		$permalink, 
		$colorscheme, 
		$num_posts
	]);
} add_shortcode('fb_comments', 'facebook_comments');

/*
 * Sharing links for Posts
 *
 * @since 1.0.0
 */
function rva_entry_share_links() {
	global $post;
	$options = get_option( RVA_SETTINGS_FIELD );
	?>
		<ul class="social-buttons social-links">
			<li id="fb-share-btn"class="btn-facebook"><i class="fa fa-facebook" ></i>
				<script>
					document.getElementById('fb-share-btn').onclick = function() {
						FB.ui({
							method: 'share',
							display: 'iframe',
							mobile_iframe: 'true',
							href: '<?php echo get_permalink(); ?>',
						}, function(response){});
					}
				</script>
			</li>
			<li class="btn-twitter">
				<a id="share-twitter" href="https://twitter.com/share?text=Check%20this%20out%20on%20RVA%20Mag!"><i class="fa fa-twitter" ></i></a>
				<script>
					//share_twitter_url
					$('#share-twitter').click(function(event) {
						var width  = 575,
							height = 400,
							left   = ($(window).width()  - width)  / 2,
							top    = ($(window).height() - height) / 2,
							url    = this.href,
							opts   = 'status=1' +
									',width='  + width  +
									',height=' + height +
									',top='    + top    +
									',left='   + left;
						window.open(url, 'twitter', opts);
						return false;
					});
				</script>
			</li>
			<li class="btn-linkedin">
				<a id="share-linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>&title=<?php echo get_the_title(); ?>&summary=<?php echo urlencode(rva_get_excerpt(100, 'content'));?>&source=LinkedIn?>"><i class="fa fa-linkedin" ></i></a>
				<script>
					$('#share-linkedin').click(function(event) {
						var width  = 575,
							height = 400,
							left   = ($(window).width()  - width)  / 2,
							top    = ($(window).height() - height) / 2,
							url    = this.href,
							opts   = 'status=1' +
									',width='  + width  +
									',height=' + height +
									',top='    + top    +
									',left='   + left;
						window.open(url, 'Linked In', opts);
						return false;
					});
				</script>
			</li>
			<li class="btn-email">
				<a target="_blank" href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>" title="Send this article to a friend!"><i class="fa fa-envelope"></i></a>
			</li>
			<li class="btn-print"><a target="_blank" href="javascript:window.print()"><i class="fa fa-print" ></i></a></li>
			<li class="btn-message"><a href="#comments" alt="Comments"><i class="fa fa-comment" ></i></a></li>
		</ul>
		
	<?php
}

/**
 * Print the Facebook like button, Twitter tweet and Google +1
 * Output is conditional based on user input.
 *
 * @since 1.0.0
 */
function rva_social_sharing_buttons() {
	$perm  = get_permalink();
	$title = get_the_title();
	?> <div class="rva-entry-like-btns" > <?php
	if ( genesis_get_option( 'rva_twitter_tweet_btn', RVA_SETTINGS_FIELD ) ) {
	?>
		<div style="min-width:65px;" class="ctsettings-tweet ctsettings-social-share"> 
			<a href="https://twitter.com/share" 
				class="twitter-share-button" 
				data-count="horizontal" 
				data-url="<?php echo  $perm ?>" 
				data-text="<?php echo $title ?>">Tweet</a>
				<script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script> </div>
	<?php
}
	if ( genesis_get_option( 'rva_facebook_like_btn', RVA_SETTINGS_FIELD ) ) {
			?>
			<div class="ctsettings-fb-like ctsettings-social-share">
				<div class="fb-like"
				data-href="<?php echo $perm; ?>"
				data-layout="button_count"
				data-action="like"
				data-colorscheme="dark"
				data-show-faces="false">
				</div>
			</div>
			<?php
	}
	if ( genesis_get_option( 'rva_google_plus_btn', RVA_SETTINGS_FIELD ) ) {
		?> 
		<div class="ctsettings-google ctsettings-social-share"> <g:plusone size="medium" href="'.$perm.'"></g:plusone><script type="text/javascript">
			(function() {
   			var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
			po.src = "https://apis.google.com/js/plusone.js";
			var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
  			})();
		</script></div>
		<?php
	}
	?> </div> <?php 
} add_shortcode('rva_like_buttons', 'rva_social_sharing_buttons');

/**
 * Print the Sidebar social media account links (used on front page)
 * depricated
 */
function rva_social_account_buttons() {
	$options =  get_option( RVA_SETTINGS_FIELD );
	ob_start();
	?>
	<ul class="margin-top margin-bottom" >
		<li><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_facebook_url'] ); ?> "> 
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-media-buttons_FB.jpg" alt="RVA Facebook link" />
		</a></li>
		<li><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_twitter_url'] ); ?>">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-media-buttons_twitter.jpg" alt="RVA Twitter link" />
		</a></li>
		<li><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_youtube_url'] ); ?>">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-media-buttons_youtube.jpg" alt="RVA YouTube link" />
		</a></li>
		<li><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_instagram_url'] ); ?>">
			<img  src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-media-buttons_instagram.jpg" alt="RVA Instagram link" />
		</a></li>

		<!-- <li class="btn-tumblr"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_tumblr_url'] ); ?>"><i class="fa fa-tumblr"></i><span>Tumblr</span></a></li> -->
	</ul>

	<?php
	return ob_get_clean();
} add_shortcode('rva_social_account_buttons', 'rva_social_account_buttons');

/**
 * Print social account link buttons
 * TODO: facebook, linkedin, twitter and youtube buttons
 */
function rva_social_accounts($atts, $content=NULL, $tag='rva_social_accounts') {

	shortcode_atts( [ 
		'facebook'=> '',
		'twitter'=> '',
		'tumblr'=> '',
		'youtube'=> '',
		'instagram'=> '',
		'snapchat' => '',
		'email' => '',
	], $atts, $tag);

	ob_start();
	?>
	<ul class="rva-social-link-list">
	<?php foreach($atts as $key => $val ) :

		switch($key) {
			case 'email':
				$icon = 'envelope-o';
				$val = 'mailto:'.$val;
				break;
			default:
				$icon = $key;
		}

		if(!empty($val)) {
			echo '<li class="btn-'.$key.'"><a target="_blank" href="'.$val.'"><i class="fa fa-'.$icon.'" ></i></a></li>';
		}
	endforeach; ?>
	</ul>
	<?php
	return ob_get_clean();
}
add_shortcode('rva_social_accounts','rva_social_accounts');
