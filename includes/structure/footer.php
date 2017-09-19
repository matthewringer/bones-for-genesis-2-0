<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function rva_footer_creds_text($content) {
	return '';
}
add_filter('genesis_footer_creds_text', 'rva_footer_creds_text');
