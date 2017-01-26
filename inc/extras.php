<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package FrenchPress
 */


/**
 * Various tweaks to add HTML5 semantics or remove markup that HTML5 does not need and would throw warnings in validators
 *
 * Probably a waste of PHP processing if pages aren't cached
 */
// Remove resource types
add_filter( 'style_loader_tag', function( $tag ) { return str_replace( array( " type='text/css' media='all' /", "type='text/css' "), "", $tag ); } );
add_filter( 'script_loader_tag', function( $tag ) { return str_replace( "type='text/javascript' ", "", $tag ); } );

// remove role=navigation from nav elements and add tray class which is just for this theme.
add_filter( 'navigation_markup_template', function($template){ return str_replace( 'class="navigation %1$s" role="navigation"', 'class="navigation %1$s tray"', $template ); });

// remove excess markup from comment form
add_filter( 'comment_form_fields', function($fields){ 
	foreach ( $fields as $key => $field ) {
		$fields[$key] = str_replace( array( 'aria-required="true" required="required"', "aria-required='true' required='required' /" ), 'required', $field );
	}
	return $fields;
});
// Changes <div> to <nav> for menu widget
function frenchpress_widget_nav_menu_args( $nav_menu_args ) {
	// if ( $args['id'] === 'top' )
	$nav_menu_args['container'] = 'nav';
	return $nav_menu_args;
}
add_filter( 'widget_nav_menu_args', 'frenchpress_widget_nav_menu_args' );


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function frenchpress_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'frenchpress_body_classes' );


/**
 * Wrap the archive type in archive titles with a span so they can be hidden or styled
 * Examples:
 *   hide all:
 *     span.archive-title-prefix {display: none;}
 * replace specific:
 *     body.archive.author header.page-header h1::before {content: "All Posts By ";}
 *     body.archive.author span.archive-title-prefix {display: none;}
 */
function wrap_archive_title_prefix( $title ){
	$p = explode( ': ', $title, 2 );
	if ( !empty( $p[1] ) ) {
		$title = "<span class='archive-title-prefix'>". $p[0] .": </span>". $p[1];
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'wrap_archive_title_prefix' );


/**
 * Add no-follow links to text widgets except on home page
 * because avoiding site-wide links is supposed to be SEO best practice
 */
function frenchpress_nofollow_widgets($text) {
	if ( ! is_front_page() ) {
		$search = array( ' rel="nofollow"', " rel='nofollow'", ' rel=nofollow', 'a href' );
		$replace = array( '', '', '', 'a rel="nofollow" href' );
		$text = str_replace($search, $replace, $text);
	}
	return $text;
}
add_filter( 'widget_text', 'frenchpress_nofollow_widgets', 99 );

// Enable the use of shortcodes in text widgets.
add_filter( 'widget_text', 'do_shortcode' );