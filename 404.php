<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package FrenchPress
 */

get_header();
?>
<main id="primary" class="site-main fffi fffi-99">
		<article class="error-404 not-found">
			<header class="page-header">
				<h1 class="title"><?php esc_html_e( '404', 'frenchpress' ); ?></h1>
			</header>
			<div class="page-content">
				<p><?php
					
					if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
						

						esc_html_e( 'Unfortunately, you clicked a broken link.  Please try searching below.', 'frenchpress' );

					} else {
						
						echo esc_html( "“{$_SERVER['REQUEST_URI']}”" );
						esc_html_e( ' does not exist on this site. Please double-check the spelling or search below.', 'frenchpress' );
						
					}
					
					get_search_form();
				
					$request = $GLOBALS['wp_query']->query;
					// $request = explode( '/', parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
					$search = preg_replace('/\W+/', '+', urldecode( end( $request ) ) );
				
					$query = new WP_Query( array( 's' => $search, 'posts_per_page' => 10, 'nopaging' => true ) );

					if ( $query->have_posts() ) : ?>

					<h3><?php esc_html_e( 'Perhaps you were looking for one of these:', 'frenchpress' ); ?></h3>

						<?php
						/* Start the Loop */
						while ( $query->have_posts() ) : $query->the_post();

						get_template_part( 'template-parts/content', 'search' );

					endwhile;

					// the_posts_navigation();

					// else :

						wp_reset_postdata();
					
					endif;
				?>
			</div>
		</article>
<?php

do_action('frenchpress_main_bottom');

echo '</main>';

get_footer();