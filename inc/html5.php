<?php
/**
 * Various tweaks to remove markup that HTML5 does not need and would throw warnings in validators
 *
 * Probably a waste of PHP processing if pages aren't cached
 *
 * @package FrenchPress
 */


// Remove resource types
add_filter( 'style_loader_tag', function( $tag ) { return str_replace( array( " type='text/css' media='all' /", "type='text/css' "), "", $tag ); } );
add_filter( 'script_loader_tag', function( $tag ) { return str_replace( "type='text/javascript' ", "", $tag ); } );

// remove role=navigation from nav elements
add_filter( 'navigation_markup_template', function($template){ return str_replace( ' role="navigation"', '', $template ); });

// remove excess markup from comment form
add_filter( 'comment_form_fields', function($fields){ 
	foreach ( $fields as $key => $field ) {
		$fields[$key] = str_replace( array( 'aria-required="true" required="required"', "aria-required='true' required='required' /" ), 'required', $field );
	}
	return $fields;
});