<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package FrenchPress
 */

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
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
		
		<?php if ( is_active_sidebar( 'content-after' ) ) : ?>
			<div id="content-after" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'content-after' ); ?>
			</div><!-- #content-after -->
		<?php endif; ?>
		
	</div><!-- #primary -->

<?php
get_sidebar(); ?>
	
</div><!-- #content-tray -->

<?php
get_footer();