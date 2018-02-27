<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package FrenchPress
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		
		if ( is_singular() ) {
			
			echo '<header class="page-header">';
			
			if ( ! apply_filters( 'frenchpress_title_in_header', false ) ) {
				the_title( '<h1 class="title">', '</h1>' );
			}
			
			frenchpress_entry_meta();
			
			// Filter for displaying featured image. 2nd arg is bool for "is_singular"
			if ( has_post_thumbnail() && apply_filters( 'frenchpress_featured_image', 'show it', true ) ) {
				echo '<figure class="featured-image">' . get_the_post_thumbnail( null, 'medium' ) . '</figure>';
				// the_post_thumbnail();
			}
			
		} else {
			
			echo '<header class="entry-header">';
			
			the_title( '<div><h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2></div>' );
			
			frenchpress_entry_meta();
			
			// Filter for displaying featured image. 2nd arg is bool for "is_singular"
			if ( has_post_thumbnail() && apply_filters( 'frenchpress_featured_image', 'show it', false ) ) {
				echo '<figure class="featured-image">' . get_the_post_thumbnail( null, 'medium' ) . '</figure>';
				// the_post_thumbnail();
			}
			
		}
	?>
	</header>
	<?php if ( (is_home() && apply_filters( 'frenchpress_blog_excerpts', true )) || (is_archive() && apply_filters( 'frenchpress_archive_excerpts', true )) ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
	<?php else : ?>
	<div class="entry-content">
		<?php
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'frenchpress' ) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'frenchpress' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<?php endif;
	
	if ( is_singular() ) {
	
		echo '<footer class="entry-footer">';
		frenchpress_entry_footer();
		echo '</footer>';
	}
	
	?>
</article>