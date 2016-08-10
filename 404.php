<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( '404', 'frenchpress' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'Unfortunately, you clicked a broken link.', 'frenchpress' ); ?></p>

					<?php
					
					$request = $GLOBALS['wp_query']->query;
					// $request = explode( '/', parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
					$search = preg_replace('/\W+/', '+', urldecode( array_pop( $request ) ) );
					
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
						
						endif; ?>
						
						<h3><?php esc_html_e( 'Feel free to search for what you&rsquo;re looking for.', 'frenchpress' ); ?></h3>
						
						<?php get_search_form();
						
					?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
		
		<?php if ( is_active_sidebar( 'content-after' ) ) : ?>
			<div id="content-after" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'content-after' ); ?>
			</div><!-- #content-after -->
		<?php endif; ?>
		
	</div><!-- #primary -->

</div><!-- #content-tray -->

<?php
get_footer();