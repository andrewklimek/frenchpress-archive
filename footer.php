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
		<?php endif;
		if ( is_active_sidebar( 'ending-credits' ) ) : ?>
			<div id="ending-credits" class="site-info">
				<?php dynamic_sidebar( 'ending-credits' ); ?>
			</div><!-- #ending-credits -->
		<?php endif; ?>
		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
