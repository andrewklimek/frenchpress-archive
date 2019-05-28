<?php
/**
* Sometimes you don't want this overly helpful 404 page.
* You can return some custom HTML on this filter, or return true to have a blank 404 page.
*
* "True" is passed by default if you have the "Discourage search engines from indexing this site" 
* option ticked in WP "Reading" settings ( get_option( 'blog_public' ) == '0' ) 
* because it is assumed this is a private blog (like a portal) and you don't want the 404 suggestions.
*/
$short_circuit_404 = apply_filters( 'frenchpress_short_circuit_404', get_option( 'blog_public' ) == '0' );

$title_style = "";

// Setup styles for a blank 404 page:
if ( $short_circuit_404 === true )
{
	// make the "404" really big
	$title_style = " style=font-size:17vw;text-align:center;opacity:.2";
	
	// center it vertically by adding classes to the #content div
	add_filter( 'frenchpress_class_content', function($class){ return $class . " fff fff-middle"; } );
}

get_header();

?>
<main id=primary class="site-main fffi fffi-99">
	<article>
		<?php
		
		if ( ! apply_filters( 'frenchpress_title_in_header', false ) ) {
		
			echo "<header class=page-header><h1 class=title{$title_style}>404</h1></header>";
		
		}
		
		echo '<div class=page-content>';
        
		if ( $short_circuit_404 ) :

			echo $short_circuit_404 === true ? '' : $short_circuit_404;

		else :
			
			echo '<p>';
		
			if ( isset( $_SERVER['HTTP_REFERER'] ) ) {

				echo 'Unfortunately, you clicked a broken link.  Please try searching below.';

			} else {
			
				echo esc_html( "“{$_SERVER['REQUEST_URI']}”" ) . ' does not exist on this site. Please double-check the spelling or search below.';
			
			}
		
			get_search_form();
	
			$request = $GLOBALS['wp_query']->query;
			// $request = explode( '/', parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
			$search = preg_replace('/\W+/', '+', urldecode( end( $request ) ) );
	
			$query = new WP_Query( array( 's' => $search, 'posts_per_page' => 10, 'nopaging' => true ) );

			if ( $query->have_posts() ) {

				echo '<h3>Perhaps you were looking for one of these:</h3>';
			
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
