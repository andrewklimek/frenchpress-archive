<?php
/**
 * Keeping WooCommerce integration in a seperate file for now.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 *
 * @package FrenchPress
 */

add_action( 'after_setup_theme', function() { add_theme_support( 'woocommerce' ); } );
add_action( 'widgets_init', 'frenchpress_woo_widgets_init', 11 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'frenchpress_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'frenchpress_wrapper_end', 10);

// Remove WOO Tabs - an example for child themes
// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

// Remove sidebar - in general we wouldn't want the site-wide sidebar in the store.
// If you want to show them, add this back (in child theme) with priority < 10 to put beofre woo-specific widgets, >10 for after
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// add sidebar
add_action( 'woocommerce_sidebar', 'frenchpress_sidebar_widgets', 10 );
function frenchpress_sidebar_widgets() {
	if ( is_single() && is_active_sidebar( 'single-product' ) ) {
	?>
	<div id='secondary' class='widget-area' role='complementary'>
		<?php dynamic_sidebar( "single-product" ); ?>
	</div><!-- #secondary -->
	<?php
	}
}

function frenchpress_wrapper_start() {
	?>

	<div id="content-tray" class="tray">

		<div id="primary" class="content-area">
	
			<?php if ( is_active_sidebar( 'content-before' ) ) : ?>
				<div id="content-before" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'content-before' ); ?>
				</div><!-- #content-before -->
			<?php endif; ?>
	
			<main id="main" class="site-main" role="main">
			<?php
}

function frenchpress_wrapper_end() {
			?>

			</main><!-- #main -->
	
			<?php if ( is_active_sidebar( 'content-after' ) ) : ?>
				<div id="content-after" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'content-after' ); ?>
				</div><!-- #content-after -->
			<?php endif; ?>
	
		</div><!-- #primary -->
	<?php
}



// Register widget areas
function frenchpress_woo_widgets_init() {
	register_sidebar( array(
		'name'          => 'Single Product',
		'id'            => 'single-product',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
	) );
}