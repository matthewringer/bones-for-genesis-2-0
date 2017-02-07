<?php

add_shortcode ('geturl', 'get_current_page_url');
function get_current_page_url() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function facebook_share_meta() {
    ?>
        <!-- Facebook Open Graph Tags -->
        <meta property="og:url"           content="<?php echo get_current_page_url(); ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="<?php echo get_the_title(); ?>" />
        <meta property="og:description"   content="<?php echo get_the_excerpt(); ?>" />
        <meta property="og:image"         content="<?php echo get_the_post_thumbnail_url(); ?>" />
    <?php
}

function facebook_js_sdk() {
    ?>
        <!-- Load Facebook SDK for JavaScript -->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1636311590010567";  //TODO: hardcoded app id...
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <?php
}

function facebook_share_btn() {
    ?>
        <!-- Your share button code -->
        <div class="fb-share-button" 
            data-href="<?php echo get_current_page_url(); ?>" 
            data-layout="button_count"
            data-size="small" 
            data-mobile-iframe="false"
            target="_blank">
        </div>
    <?php
}


/*
 * Sharing links for Posts
 *
 * @since 2.2.18
 */
function rva_entry_share_links($post) {
	$options = get_option( RVA_SETTINGS_FIELD );

    ?>
        <ul class="social-buttons social-links">
            <li id="fb-share-btn"class="btn-facebook"><i class="fa fa-facebook" ></i></li>
            <li class="btn-twitter"><a target="_blank" href="'.genesis_get_option('share_twitter_url').get_permalink($post).'"><i class="fa fa-twitter" ></i></a></li>
            <li class="btn-linkedin"><a target="_blank" href="'.genesis_get_option('share_linkedin_url').get_permalink($post).'"><i class="fa fa-linkedin" ></i></a></li>
            <li class="btn-email"><a target="_blank" href="'.genesis_get_option('share_email_url').get_permalink($post).'"><i class="fa fa-envelope" ></i></a></li>
            <li class="btn-print"><a target="_blank" href="'.genesis_get_option('share_print_url').get_permalink($post).'"><i class="fa fa-print" ></i></a></li>
            <li class="btn-message"><a target="_blank" href="'.genesis_get_option('share_message_url').get_permalink($post).'"><i class="fa fa-comment" ></i></a></li>
        </ul>
        <script>
            document.getElementById('fb-share-btn').onclick = function() {
                FB.ui({
                    method: 'share',
                    display: 'iframe',
                    mobile_iframe: 'true',
                    href: '<?php echo get_current_page_url(); ?>',
                }, function(response){});
            }
        </script>
	<?php
}