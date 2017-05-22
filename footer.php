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
	</div><!-- #content-tray -->
</div><!-- #content -->
<footer id="footer" class="site-footer fffi">
<?php
do_action('frenchpress_footer_top');

if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
	<div class="footer-tray fff fff-magic">
	<?php
	if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<div id="footer-1" class="widget-area fffi" role="complementary">			
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
	<?php
	endif;
	if ( is_active_sidebar( 'footer-2' ) ) : ?>
		<div id="footer-2" class="widget-area fffi" role="complementary">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>
	<?php
	endif;
	if ( is_active_sidebar( 'footer-3' ) ) : ?>
		<div id="footer-3" class="widget-area fffi" role="complementary">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>
	<?php
	endif;
	if ( is_active_sidebar( 'footer-4' ) ) : ?>
		<div id="footer-4" class="widget-area fffi" role="complementary">
			<?php dynamic_sidebar( 'footer-4' ); ?>
		</div>
	<?php
	endif;
	?>
	</div>
<?php
endif;
if ( is_active_sidebar( 'ending-credits' ) ) : ?>
	<div id="ending-credits" class="site-info">
		<div class="credits-tray">
			<?php dynamic_sidebar( 'ending-credits' ); ?>
		</div>
	</div>
<?php
endif;
do_action('frenchpress_very_bottom');
?>
</footer>
<div id="wp_footer">
	<?php
	// if ( false !== $menu ) {// from header, is the main menu active?
	// 	print "<div id='obfuscator'></div>";
	// }
	wp_footer();
	?>
</div>
</body>
</html>