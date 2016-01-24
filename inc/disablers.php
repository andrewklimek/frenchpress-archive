<?php

/**
 * Disable capital P
 */

foreach ( array( 'the_content', 'the_title', 'wp_title', 'comment_text' ) as $filter ) {
	$priority = has_filter( $filter, 'capital_P_dangit' );
	if ( $priority !== FALSE ) {
		remove_filter( $filter, 'capital_P_dangit', $priority );
	}
}

/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );