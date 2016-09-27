<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package FrenchPress
 */

// hook for default page layout until I make an option page. Use 'sidebars, 'full-width', or 'no-sidebars'
$layout = apply_filters( 'frenchpress_page_layout', 'no-sidebars' );

get_header();
?>
<main id="primary" class="site-main fff-item fffi-99<?php if ( $layout === 'full-width' ) echo ' main-full-width' ?>">
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
if ( $layout === 'sidebars' ) {
	get_sidebar();
}
get_footer();