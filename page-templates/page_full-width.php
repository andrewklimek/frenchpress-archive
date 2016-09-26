<?php
/**
 * Template Name: Full-Width
 *
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/page-templates/
 *
 * @package FrenchPress
 */

get_header();
?>
<main id="primary" class="site-main main-full-width flex-item flex-item--99">
	<?php
	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile; // End of the loop.
	?>
</main>
<?php
get_footer();