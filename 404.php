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
<main id=primary class="site-main fffi fffi-99">
	<article class="error-404 not-found">
		<?php
		
		if ( ! apply_filters( 'frenchpress_title_in_header', false ) ) {
		
			echo '<header class="page-header text-center"><h1 class=title>404</h1></header>';
		
		}
		
		echo '<div class=page-content>';
          
		if ( $custom_404 = apply_filters( 'frenchpress_replace_smart_404', false ) ) :

			echo $custom_404 === true ? '' : $custom_404;

		else :
			
			echo '<p>';
		
			if ( isset( $_SERVER['HTTP_REFERER'] ) ) {

				echo __( 'Unfortunately, you clicked a broken link.  Please try searching below.', 'frenchpress' );

			} else {
			
				echo esc_html( "“{$_SERVER['REQUEST_URI']}”" ) . __( ' does not exist on this site. Please double-check the spelling or search below.', 'frenchpress' );
			
			}
		
			get_search_form();
	
			$request = $GLOBALS['wp_query']->query;
			// $request = explode( '/', parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
			$search = preg_replace('/\W+/', '+', urldecode( end( $request ) ) );
	
			$query = new WP_Query( array( 's' => $search, 'posts_per_page' => 10, 'nopaging' => true ) );

			if ( $query->have_posts() ) {

				echo '<h3>' . __( 'Perhaps you were looking for one of these:', 'frenchpress' ) . '</h3>';
			
				while ( $query->have_posts() ) {
					
					$query->the_post();

					get_template_part( 'template-parts/content', 'search' );

				}

				wp_reset_postdata();
		
			}
			
		endif;
		
		?>
		</div>
	</article>
<?php

do_action('frenchpress_main_bottom');

echo '</main>';

get_footer();
