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
<main id="primary" class="site-main fffi fffi-99">
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
get_sidebar();
get_footer();