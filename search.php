<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package FrenchPress
 */

get_header();
?>
<main id="primary" class="site-main fffi fffi-99">
	<header class="page-header">
		<h1 class="title"><?php printf( esc_html__( 'Search Results for: %s', 'frenchpress' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	</header>
<?php

if ( have_posts() ) :

	/* Start the Loop */
	while ( have_posts() ) : the_post();

		/**
		 * Run the loop for the search to output the results.
		 * If you want to overload this in a child theme then include a file
		 * called content-search.php and that will be used instead.
		 */
		get_template_part( 'template-parts/content', 'search' );

	endwhile;

	the_posts_navigation();

else :

	get_template_part( 'template-parts/content', 'none' );

endif;

do_action('frenchpress_main_bottom');

echo '</main>';

get_sidebar();
get_footer();