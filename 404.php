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
				<h1 class="page-title"><?php esc_html_e( '404', 'frenchpress' ); ?></h1>
			</header>
			<div class="page-content">
				<p><?php
					
					if ( isset( $_SERVER['HTTP_REFERER'] ) ) {// They followed a link, so email the webmaster about the bad link

						$message = "A user tried to go to {$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']} and received a 404 (page not found) error.  ";
						$message .= "They apparently clicked a link on {$_SERVER['HTTP_REFERER']}, so try fixing that.";
						wp_mail( get_option('admin_email'), "There’s a bad link to your site: {$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}", $message );
						if ( WP_DEBUG_LOG ) error_log( $message );// why not add to error log also

						esc_html_e( 'Unfortunately, you clicked a broken link.  The webmaster has been notified.  Please try searching below.', 'frenchpress' );

					} else {
						
						echo esc_html( "“{$_SERVER['REQUEST_URI']}”" );
						esc_html_e( ' does not exist on this site. Please double-check the spelling or search below.', 'frenchpress' );

						// Probably don't want a notification about these unless you're worried about old bookmarks
						// $message = "A user tried to go to {$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']} and received a 404 (page not found) error.  ";
						// $message .= "They did not come from anywhere, so perhaps its an old bookmark?";
						// wp_mail( get_option('admin_email'), "A user tried to access {$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}", $message );
						// if ( WP_DEBUG_LOG ) error_log( $message );// why not add to error log also

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
	</main>
<?php
get_footer();