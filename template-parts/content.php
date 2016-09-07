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
	<header class="entry-header">
		<?php
			if ( has_post_thumbnail() && ( ! is_single() || apply_filters( 'frenchpress_featured_image', false ) ) ) {
				the_post_thumbnail();
			}
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
		if ( 'post' === get_post_type() ) frenchpress_entry_meta();
		?>
	</header>
	<?php if ( is_archive() && apply_filters( 'frenchpress_archive_excerpts', true ) ) : // Only display Excerpts for Archive ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
	<?php else : ?>
	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'frenchpress' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'frenchpress' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<?php endif; ?>
	<footer class="entry-footer">
		<?php frenchpress_entry_footer(); ?>
	</footer>
</article>
