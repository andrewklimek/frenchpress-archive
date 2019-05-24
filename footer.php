<?php
/**
 * Called via get_footer()
 */

do_action('frenchpress_content_tray_bottom');
	
echo '</div>';// #content-tray

do_action('frenchpress_content_bottom');

echo '</div>';// #content

do_action('frenchpress_footer_before');

echo '<footer id=footer class="site-footer fffi">';

do_action('frenchpress_footer_top');

if ( is_active_sidebar( 'footer-top' ) ) : ?>
	<div id=footer-top class=widget-area role=complementary>
		<div class="tray footer-top-tray">
			<?php dynamic_sidebar( 'footer-top' ); ?>
		</div>
	</div>
<?php
endif;

if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) :
	
	$number_of_widget_areas = 0;
	
	ob_start();
	
	if ( is_active_sidebar( 'footer-1' ) ) {
		++$number_of_widget_areas;
		echo '<div id=footer-1 class="widget-area fffi" role=complementary>';		
		dynamic_sidebar( 'footer-1' );
		echo '</div>';	
	}
	if ( is_active_sidebar( 'footer-2' ) ) {
		++$number_of_widget_areas;
		echo '<div id=footer-2 class="widget-area fffi" role=complementary>';		
		dynamic_sidebar( 'footer-2' );
		echo '</div>';	
	}
	if ( is_active_sidebar( 'footer-3' ) ) {
		++$number_of_widget_areas;
		echo '<div id=footer-3 class="widget-area fffi" role=complementary>';		
		dynamic_sidebar( 'footer-3' );
		echo '</div>';	
	}
	if ( is_active_sidebar( 'footer-4' ) ) {
		++$number_of_widget_areas;
		echo '<div id=footer-4 class="widget-area fffi" role=complementary>';		
		dynamic_sidebar( 'footer-4' );
		echo '</div>';	
	}
	$widgets = ob_get_clean();

	echo "<div class='tray footer-tray fff fff-pad fff-x{$number_of_widget_areas}'>{$widgets}</div>";

endif;

do_action('frenchpress_footer_bottom');

// I'm using this sort of odd method to there a way to count number of widgets and remove flex classes if just one
// Might not work if there's some dynamic widget display rules... though it may only need apply_filters( 'sidebars_widgets', $sidebars_widgets ) to work.
// can do without the extra is_active function
// if ( is_active_sidebar( 'footer-bottom' ) ) :
global $sidebars_widgets;
if ( !empty( $sidebars_widgets['footer-bottom'] ) ) : ?>
	<div id=footer-bottom>
		<div class="tray footer-bottom-tray<?php if( isset( $sidebars_widgets['header-4'][1] ) ) echo ' fff fff-middle fff-spacebetween'; ?> fff-pad">
			<?php dynamic_sidebar( 'footer-bottom' ); ?>
		</div>
	</div>
<?php
endif;

?>
</footer>
<div id=wp_footer>
	<?php
	wp_footer();
	frenchpress_mini_admin_bar();
	?>
    <div id=mask></div>
</div>