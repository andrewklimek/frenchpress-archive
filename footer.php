<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package FrenchPress
 */

	?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div id="footer-1" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div><!-- #footer-1 -->
		<?php endif;
		if ( is_active_sidebar( 'footer-2' ) ) : ?>
			<div id="footer-2" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-2' ); ?>
			</div><!-- #footer-2 -->
		<?php endif;
		if ( is_active_sidebar( 'footer-3' ) ) : ?>
			<div id="footer-3" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-3' ); ?>
			</div><!-- #footer-3 -->
		<?php endif;
		if ( is_active_sidebar( 'footer-4' ) ) : ?>
			<div id="footer-4" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-4' ); ?>
			</div><!-- #footer-4 -->
		<?php endif; ?>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'frenchpress' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'frenchpress' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'frenchpress' ), 'frenchpress', '<a href="http://andrewklimek.com" rel="designer">Andrew J Klimek</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
