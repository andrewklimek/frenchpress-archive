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

// add_filter('show_admin_bar', function($b){ return currentv_user_can('administrator') ? $b : false; });

// add_filter( 'user_can_richedit' , '__return_false' );// disable visual editor

// Hide various things that don't have options yet
// add_filter( 'frenchpress_page_titles', '__return_false' );// Don't display title on pages
add_filter( 'frenchpress_page_layout', function(){ return 'no-sidebars'; } );// default to no sidebars on pages

// No Meta
// function frenchpress_posted_on() { echo '<hr>'; }
// function frenchpress_entry_footer() { return; }


/**
* SVG Logo in Header
*/
// add_filter( 'frenchpress_site_branding', 'add_svg_logo' );
function add_svg_logo( $skip_the_rest ) {
	echo "<a href=". esc_url( home_url( '/' ) ) ." rel='home'>";
	echo file_get_contents( __DIR__ .'/logo.svg' );
	echo "</a>";
	return true;// skips the rest of the site branging section
}