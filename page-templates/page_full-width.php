<?php
/**
 * Template Name: Full-Width (no sidebars)
 *
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/page-templates/
 *
 * @package FrenchPress
 */

get_header(); ?>

	<div id="primary" class="content-area">
		
		<?php if ( is_active_sidebar( 'content-before' ) ) : ?>
			<div id="content-before" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'content-before' ); ?>
			</div><!-- #content-before -->
		<?php endif; ?>
		
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
		
		<?php if ( is_active_sidebar( 'content-after' ) ) : ?>
			<div id="content-after" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'content-after' ); ?>
			</div><!-- #content-after -->
		<?php endif; ?>
		
	</div><!-- #primary -->

<?php
get_footer();
