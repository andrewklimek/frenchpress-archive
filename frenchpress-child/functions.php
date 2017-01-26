<?php
/**
 * FrenchPress Child functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package FrenchPress Child
 */

// Add Theme Stylesheets
add_action( 'wp_enqueue_scripts', 'frenchpress_child_enqueue_scripts' );
function frenchpress_child_enqueue_scripts() {
	// $suffix = SCRIPT_DEBUG ? "" : ".min";// get minified parent stylesheet unless debug_script is on.
	$suffix = "";
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style'.$suffix.'.css', array(), filemtime( get_template_directory() . '/style'.$suffix.'.css' .'-P' ) );
	wp_enqueue_style( 'fonts', get_stylesheet_directory_uri() . '/fonts.css', array(), null );
	
	// wp_register_script( 'psb-smooth-scroll', get_template_directory_uri() . '/js/smooth-scroll.js', array( 'jquery' ), null, true );
}

// add_filter( 'frenchpress_menu_breakpoint', function(){ return 0; } );// mobile nav breakpoint in pixels, 0 to disable

add_action( 'wp_head', 'frenchpress_browser_color' );
function frenchpress_browser_color() {
	print "
	<meta name='theme-color' content='#f66'>
	<meta name='msapplication-navbutton-color' content='#f66'>";
}


function frenchpress_sidebar( $show_sidebar ) {
	// if ( is_archive() || is_home() )
		$show_sidebar = false;
	return $show_sidebar;
}
add_filter( 'frenchpress_sidebar', 'frenchpress_sidebar' );


// add_filter('show_admin_bar', function($b){ return currentv_user_can('administrator') ? $b : false; });

// add_filter( 'user_can_richedit' , '__return_false' );// disable visual editor

// Hide various things that don't have options yet
add_filter( 'frenchpress_page_titles', '__return_false' );// Don't display title on pages
// hook for default page layout until I make an option page. Use 'sidebars, 'full-width', or 'no-sidebars' (the default)
// add_filter( 'frenchpress_page_layout', function(){ return 'full-width'; } );


// function frenchpress_full_width( $show_sidebar ) {
// 	if ( is_front_page() )
// 		$show_sidebar = true;
// 	return $show_sidebar;
// }
// add_filter( 'frenchpress_full_width', 'frenchpress_full_width' );
// add_filter( 'frenchpress_full_width' , '__return_true' );// full width layout


// add_filter( 'frenchpress_featured_image' , '__return_true' );// show featured images on single posts

// add_filter( 'frenchpress_archive_excerpts', false );// show full post in archives

// No Meta
// function frenchpress_entry_meta() { echo '<hr>'; }
// function frenchpress_entry_footer() { return; }

// set_post_thumbnail_size( 1100, 400, true );// width, height, crop




/**
* Shortcode for category listing, used for timeline
*/
add_shortcode( 'quickcat', 'quickcat');
function quickcat($atts){
	$atts = shortcode_atts( array(
		'cat' => '',
		'num' => '16',
		'order' => 'DESC',
		'body' => 1,
		'excerpt' => 1,
		'thumb' => 1,
		'thumb_before' => 1,
		'chars' => 80,
		'type' => 'post',
		'more' => null,
		'more_class' => '',
		'header' => 'h2',
		'date' => 0,
		'posted_on' => 'Posted on',
		'byline' => 0
	), $atts, 'quickcat' );
	$query = new WP_Query( array( 
		'category_name' => $atts['cat'], 
		'posts_per_page' => $atts['num'], 
		'order' => $atts['order'], 
		'post_type' => $atts['type']
	) );	
	
	ob_start();
	// The Loop
	if ( $query->have_posts() ) {
		echo '<div class="quickcat">';
		while ( $query->have_posts() ) {
			$query->the_post();
			// get_template_part( 'template-parts/content', get_post_format() );
			?>
<article id="post-<?php the_ID(); ?>" <?php post_class('quickcat fff'); ?>>
	<div class="entry-header quickcat fffi fffi-initial">
		<a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark">
			<?php
			if ( ! $atts['thumb_before'] ) {
				the_title( '<'. $atts['header'] .' class="entry-title quickcat">', '</'. $atts['header'] .'>' );
			}
			if ( $atts['thumb'] && has_post_thumbnail() ) {
				the_post_thumbnail( 'thumbnail' );
			}
			?>
		</a>
	</div>
	<div class="entry-content quickcat fffi fffi-magic">
		<?php
			if ( $atts['body'] || $atts['thumb_before'] ) {
				
				print "<div class='quickcat-body'>";
				
				if ( $atts['thumb_before'] ) {
					the_title( '<'. $atts['header'] .' class="entry-title quickcat"><a href="' . get_permalink() .'" rel="bookmark">', '</a></'. $atts['header'] .'>' );
				}
			
				// meta
				if ( $atts['date'] || $atts['byline'] ) {
					
					$meta_date = $byline = '';
					
					if ( $atts['date'] ) {
						$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
						$time_string = sprintf( $time_string,
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date() )
						);
						$meta_date = sprintf(
							esc_html_x( '%s %s', 'post date', 'frenchpress' ),
							$atts['posted_on'],
							'<span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></span>'
						);
					}
				
					if ( $atts['byline'] ) {
						$byline = sprintf(
							esc_html_x( 'by %s', 'post author', 'frenchpress' ),
							'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
						);
					}
					print "<p class='entry-meta-header'>{$meta_date}{$byline}</p>"; // WPCS: XSS OK.
				}
				
				if ( $atts['body'] ) {
					
					if ( $atts['excerpt'] && $excerpt = get_the_excerpt() ) {
						if ( ! has_excerpt() && ( strlen( $excerpt ) > (int) $atts['chars'] ) ) {
							$excerpt = substr( $excerpt, 0, strpos( $excerpt, ' ', (int) $atts['chars'] ) ) .'…';
						}
						print "<p class='quickcat-excerpt'>{$excerpt}</p>";
						print "<a class='readmore {$atts['more_class']}' href='". get_permalink() ."' rel='bookmark'>";
						print $atts['more'] ? $atts['more'] : "Read More &rarr;";
						print "</a>";
				
					} else {
						the_content( $atts['more'] );
					}
				}
				print "</div>";
			}
		?>
	</div>
</article>
			<?php
		}
		echo '</div>';
	}
	/* Restore original Post Data */
	wp_reset_postdata();
	return ob_get_clean();
}
/**
* Masonry Shortcode
*/
add_shortcode('frenchmason', 'frenchpress_masonry' );
function frenchpress_masonry( $a, $content = '' ) {
	
	if ( ! $content ) return "no content in [frenchmason] shortcode";
	
	$id = mt_rand();
	$child = !empty( $a['child'] ) ? ' > :first-child' : '';// bad CSS
	$container = !empty( $a['container'] ) ? " {$a['container']}" : "";
	$selector = !empty( $a['selector'] ) ? $a['selector'] : '#frenchmason > *';// bad CSS
	if ( empty( $a['width'] ) ) {
		$width = "'{$selector}'";
	} elseif ( is_numeric( $a['width'] ) ) {
		$width = $a['width'];
	} else {
		$width = "'{$a['width']}'";
	}
	
	$snippet = "
	var grid = document.querySelector('#frenchmason-{$id}{$child}{$container}');
	imagesLoaded( grid, function() {
		var msnry = new Masonry( grid, {
			itemSelector: '{$selector}',
			columnWidth: {$width},
			percentPosition: true,
			// gutter: 10
		});
	});
	";
	wp_enqueue_script( 'masonry' );
	wp_add_inline_script( 'masonry', $snippet );
	
	$out = "<div id='frenchmason-{$id}' class='frenchmason'>". do_shortcode($content) ."</div>";
	
	return $out;
}
