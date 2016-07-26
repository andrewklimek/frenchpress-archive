<?php
/**
 * Keeping WooCommerce integration in a seperate file for now.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 *
 * @package FrenchPress
 */

add_action( 'after_setup_theme', function() { add_theme_support( 'woocommerce' ); } );


remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'frenchpress_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'frenchpress_wrapper_end', 10);

function frenchpress_wrapper_start() {

	get_header(); ?>

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
	if ( apply_filters( 'frenchpress_wc_sidebar', true ) ) {
		get_sidebar();
	} ?>
	
	</div><!-- #content-tray -->

	<?php
	get_footer();

}