<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package FrenchPress
 */

if ( ! function_exists( 'frenchpress_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function frenchpress_entry_meta() {
	
	// Disable or do a custom meta
	// eg, to only show meta on 'posts' (not cutom post types): function( $skip ){ return 'post' === get_post_type() ? $skip : true; }
	// eg, to customize meta for archives only, the first line in the filter could be "if ( !is_archive() ) return $skip_the_rest;"
	if ( apply_filters( 'frenchpress_entry_meta_header', false ) ) {
		return;
	}
	// default:
	
	$time = '<time class="entry-date published" datetime="'. esc_attr(get_the_date('c')) .'">'. esc_html(get_the_date()) .'</time>';

    if ( apply_filters( 'frenchpress_entry_meta_link_time', false ) ) {
        $time = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time . '</a>';
    }
	$time = sprintf( esc_html_x( apply_filters( 'frenchpress_posted_on', 'Posted on' ) . ' %s', 'post date', 'frenchpress' ), $time );

    $byline = esc_html( get_the_author() );
    
    if ( apply_filters( 'frenchpress_entry_meta_link_author', is_multi_author() ) ) {
        $byline = '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . $byline . '</a>';
    }
	$byline = sprintf( esc_html_x( 'by %s', 'post author', 'frenchpress' ), "<span class='author vcard'>{$byline}</span>" );

	echo "<p class='entry-meta-header'><span class='posted-on'>{$time}</span><span class='byline'> {$byline}</span></p>"; // WPCS: XSS OK.
}
endif;

if ( ! function_exists( 'frenchpress_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function frenchpress_entry_footer() {
	print "<p class='entry-meta-footer'>";
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'frenchpress' ) );
		if ( $categories_list && frenchpress_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'frenchpress' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'frenchpress' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'frenchpress' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'frenchpress' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'frenchpress' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
	print "</p>";
}
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function frenchpress_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'frenchpress_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'frenchpress_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so frenchpress_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so frenchpress_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in frenchpress_categorized_blog.
 */
function frenchpress_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'frenchpress_categories' );
}
add_action( 'edit_category', 'frenchpress_category_transient_flusher' );
add_action( 'save_post',     'frenchpress_category_transient_flusher' );
