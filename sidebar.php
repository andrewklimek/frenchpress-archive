<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package FrenchPress
 */

if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
<?php endif;
if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
<aside id="tertiary" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</aside>
<?php endif;