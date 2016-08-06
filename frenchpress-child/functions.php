<?php
/**
 * FrenchPress Child functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package FrenchPress Child
 */

// Add Theme Stylesheets
add_action( 'wp_enqueue_scripts', function() {
	$suffix = SCRIPT_DEBUG ? "" : ".min";// get minified parent stylesheet unless debug_script is on.
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style'.$suffix.'.css', array(), filemtime( get_template_directory() . '/style'.$suffix.'.css' ) );
});

// Don't display title on pages
add_filter( 'frenchpress_page_titles', '__return_false' );

// No "posted on" line
// function frenchpress_posted_on() { return; }
