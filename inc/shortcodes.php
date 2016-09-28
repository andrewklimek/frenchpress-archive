<?php

/*****
*
Main FrenchPress building-block Shortcode
*
*
attributes:
el (element, default "div")
class
id
style
bg (background image or color)
grid (flexbox conatainer)
cell (flexbox item)
*
*
Possible flexbox values (for grid/cell):

GRID-ONLY:

true (just apply default: row wrap)
column
nowrap

(justify-content)
left
center
right
spacebetween
spacearound

GRID or CELL:

(align-items/self)
top
middle
bottom

(flex)
none		(0 0 auto)
auto		(1 1 auto)
initial	(0 1 auto)
noshrink	(1 0 auto)
magic		(1 1 auto + width:18em)
even		(1 1 0)

(flex-basis)
x1 (100% )
x2 (50%)
x3 (33.3%)
x4 (25%)

CELL-ONLY
(grow)
1 - 11
99 (flex-grow:99 - essentially prevents other items from growing at all UNTIL they wrap to their own row. e.g.: main content vs sidebars)
*
*
***/

add_shortcode( 'section', 'frenchpress_shortcode' );
add_shortcode( 'grid', 'frenchpress_shortcode' );
add_shortcode( 'cell', 'frenchpress_shortcode' );

for ( $i='a'; $i != 'k'; $i++ ) {
	
	add_shortcode( 'section_' . $i, 'frenchpress_shortcode' );
	add_shortcode( 'grid_' . $i, 'frenchpress_shortcode' );
	add_shortcode( 'cell_' . $i, 'frenchpress_shortcode' );
}

function frenchpress_shortcode( $a, $c = '', $tag ) {
	
	if ( !empty( $a['el'] ) ) {
		$el = $a['el'];
	} else {
		$el = ( false !== strpos( $tag, 'section' ) ) ? 'section' : 'div';
	}
	
	$id = !empty( $a['id'] ) ? " id='{$a['id']}'" : "";
	$class = !empty( $a['class'] ) ? " {$a['class']}" : "";
	
	// build Style attribute
	if ( !empty( $a['bg'] ) ) {
		if ( false === strpos( $a['bg'], '/' ) ) {// no slash so presume a color
			$style = "background:{$a['bg']};";
		} else {// has slash: presume image
			$style = "background-image:url({$a['bg']});";
		}
		if ( !empty( $a['style'] ) ) {
			$style .= $a['style'];
		}
		$style = " style='{$style}'";
	} else {// no bg
		$style = !empty( $a['style'] ) ? " style='{$a['style']}'" : "";
	}
	
	// Flex
	if ( false !== strpos( $tag, 'grid' ) || !empty( $a['grid'] ) ) {
		$class .= 'fff';
		if ( !empty( $a['grid'] ) && 'true' !== $a['grid'] ) {// anything but true, lets add the modifiers
			$class .= " fff-" . str_replace( " ", " fff-", $a['grid'] );
		}
	}
	if ( false !== strpos( $tag, 'cell' ) || !empty( $a['cell'] ) ) {
		$class .= 'fffi';
		if ( !empty( $a['cell'] ) && 'true' !== $a['cell'] ) {// anything but true, lets add the modifiers
			$class .= " fffi-" . str_replace( " ", " fffi-", $a['cell'] );
		}
	}
	
	// final check for any classes, add attribute
	$class = $class ? " class='{$class}'" : "";
	
	// process other shortcodes
	$c = do_shortcode($c);
	
	// string it all together
	return "<{$el}{$id}{$class}{$style}>{$c}</{$el}>";
}