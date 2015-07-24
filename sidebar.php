<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package FrenchPress
 */
?>
<div id="secondary" class="widget-area" role="complementary">
	<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

		<aside id="search" class="widget widget_search">
			<?php get_search_form(); ?>
		</aside>

		<aside id="archives" class="widget">
			<h1 class="widget-title"><?php _e( 'Archives', 'shape' ); ?></h1>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</aside>

		<aside id="meta" class="widget">
			<h1 class="widget-title"><?php _e( 'Meta', 'shape' ); ?></h1>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</aside>

	<?php endif; // end sidebar widget area ?>
</div><!-- #secondary .widget-area -->

<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>

	<div id="tertiary" class="widget-area" role="supplementary">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div><!-- #tertiary .widget-area -->

<?php endif; ?>