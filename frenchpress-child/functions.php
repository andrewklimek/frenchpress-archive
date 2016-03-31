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
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array(), filemtime( get_template_directory() . '/style.css' ) );
	// wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'parent-style' ), filemtime( get_stylesheet_directory() . '/style.css'), 'screen and (max-width: 900px)' );
});

// Don't display title on pages
add_filter( 'frenchpress_page_titles', '__return_false' );

// No "posted on" line
// function frenchpress_posted_on() { return; }
