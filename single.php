<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package FrenchPress
 */

get_header();
?>
<div id="primary" class="content-area">
	<?php
	if ( is_active_sidebar( 'content-before' ) ) : ?>
		<div id="content-before" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'content-before' ); ?>
		</div>
	<?php endif; 
	?>
	<main id="main" class="site-main">
	<?php
	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', get_post_format() );
		
		// filter the avigation args, for example to go to next post in same category:
		// add_filter( 'frenchpress_post_navigation_args', function() { return array( 'in_same_term' => true ); } );
		the_post_navigation( apply_filters( 'frenchpress_post_navigation_args', array() ) );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile; // End of the loop.
	?>
	</main>
	<?php
	if ( is_active_sidebar( 'content-after' ) ) : ?>
		<div id="content-after" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'content-after' ); ?>
		</div>
	<?php endif;
	?>
</div>
<?php
get_sidebar();
get_footer();