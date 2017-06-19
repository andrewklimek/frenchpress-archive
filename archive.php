<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package FrenchPress
 */

get_header();
?>
<main id="primary" class="site-main fffi fffi-99">
<?php
if ( have_posts() ) :
	?>
	<header class="page-header">
		<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>
	</header>
	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post();

        /* specific content templates can be made like: content[-custom post type][-post format].php */
		$name = get_post_type();
		if ( 'post' === $name ) $name = '';
		$format = get_post_format();
		if ( $format ) $name = $name ? "{$name}-{$format}" : $format;

		get_template_part( 'template-parts/content', $name );

	endwhile;

	the_posts_navigation();

else :

	get_template_part( 'template-parts/content', 'none' );

endif;
?>
</main>
<?php
get_sidebar();
get_footer();