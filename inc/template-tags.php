<?php
/**
 * current year shorcode for copyright lines
 */
add_shortcode( 'current_year', function(){ return date('Y'); } ); 

/**
 * Custom posts nav function because I'm insane
 */
function frenchpress_posts_nav( $before='', $after='.' ) {
	global $paged, $wp_query;
 
    $max_page = $wp_query->max_num_pages;
    
    if ( $max_page < 2 ) return;
    
  /*  
    <nav class="navigation posts-navigation">
		<h2 class=screen-reader-text>Posts navigation</h2>
		<div class=nav-links>
			<div class=nav-previous><a href=/blog/page/2/>Older posts</a></div>
			<div class=nav-next><a href=/blog/>Newer posts</a></div>
		</div>
	</nav>
	<nav class="navigation pagination">
		<h2 class=screen-reader-text>Posts navigation</h2>
		<div class=nav-links>
			<a class="prev page-numbers" href=/blog/>Previous</a>
			<a class=page-numbers href=/blog/><span class=screen-reader-text>Page </span>1</a>
			<span aria-current=page class="page-numbers current"><span class=screen-reader-text>Page </span>2</span>
			<a class="next page-numbers" href=/blog/page/2/>Next</a>
		</div>
	</nav>
	*/
	
    $out = '<nav class=posts-nav><h2 class=screen-reader-text>Posts navigation</h2><div class="nav-links fff fff-spacebetween">';
 
    if ( !$paged ) $paged = 1;
        
	$pagenum_link = get_pagenum_link(809);
	
	if ( $paged > 1 )
        $out .= '<a class=prev href="' . str_replace( '809', $paged - 1, $pagenum_link ) . '">Newer<span class=screen-reader-text> Posts</span></a>';
	else
		$out .= '<a class=prev style="opacity:.1"><span class=screen-reader-text>No </span>Newer<span class=screen-reader-text> Posts</span></a>';
	
	$out .= ' <span aria-current=page class="page-numbers current"><span class=screen-reader-text>Page </span>' . $before . $paged . $after . '</span> ';
	
	if ( $paged < $max_page )
        $out .= '<a class=next href="' . str_replace( '809', $paged + 1, $pagenum_link ) . '">Older<span class=screen-reader-text> Posts</span></a>';
    else
        $out .= '<a class=next style="opacity:.1"><span class=screen-reader-text>No </span>Older<span class=screen-reader-text> Posts</span></a>';
	
	$out .= '</div></nav>';
	
	return $out;
}
	
	
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'frenchpress_entry_meta' ) ) :
function frenchpress_entry_meta() {
	
	// Disable or do a custom meta
	// eg, to only show meta on 'posts' (not cutom post types): function( $skip ){ return 'post' === get_post_type() ? $skip : true; }
	// eg, to customize meta for archives only, the first line in the filter could be "if ( !is_archive() ) return $skip_the_rest;"
	if ( apply_filters( 'frenchpress_entry_meta_header', false ) ) {
		return;
	}
	
	$date = get_the_date( DATE_W3C );// PHP constant same as 'c' format
	$modified_date = get_the_modified_date( DATE_W3C );
	
	$time = $date === $modified_date ? '<time class="entry-date published updated" datetime="' . $date . '">' . get_the_date() . '</time>'
		: '<time class="entry-date published" datetime="' . $date . '">' . get_the_date() . '</time><time class=updated datetime="' . $modified_date . '">' . get_the_modified_date() . '</time>';

	if ( apply_filters( 'frenchpress_entry_meta_link_time', false ) ) {
		$time = '<a href="' . esc_url( get_permalink() ) . '" rel=bookmark>' . $time . '</a>';
	}
	
	$byline = get_the_author();
	
	if ( apply_filters( 'frenchpress_entry_meta_link_author', is_multi_author() ) ) {
		$byline = '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . $byline . '</a>';
	}
	$byline = "by <span class='author vcard'>{$byline}</span>";

	echo "<p class=entry-meta-header><span class=posted-on>{$time}</span><span class=byline> {$byline}</span></p>";
}
endif;

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
if ( ! function_exists( 'frenchpress_entry_footer' ) ) :
function frenchpress_entry_footer() {
	
	// echo "<p class=entry-meta-footer>";
	
	if ( 'post' === get_post_type() ) {// only show category and tag on posts
		
		$separate_meta = ", ";
		
		if ( frenchpress_categorized_blog() && $categories_list = get_the_category_list( $separate_meta ) ) {
			
			echo '<p class=cat-links>Filed under ' . $categories_list;
		
		}

		if ( $tags_list = get_the_tag_list( '', $separate_meta ) ) {
			
			echo '<p class=tag-links>Tagged ' . $tags_list;
		
		}
	}

	/*** Does anyone use the edit links?  They’re weird
	edit_post_link(
		sprintf(
			'Edit %s',
			the_title( '<span class=screen-reader-text>"', '"</span>', false )
		),
		'<span class=edit-link>',
		'</span>'
	);
	***/
	
	// echo "</p>";
}
endif;


/**
 * Custom Comment Callback
 */
function frenchpress_comment( $comment, $args, $depth ) {
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( !empty( $args['has_children'] ) ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class=comment-body>
			<header class="comment-meta fff fff-spacebetween">
				<div class="comment-author vcard fffi">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<cite class=fn><?php echo get_comment_author_link( $comment ) ?></cite>
				</div>
				<div class="comment-metadata fffi">
					<a class=comment-permalink href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>"><?php
							echo mysql2date( get_option('date_format') .' '. get_option('time_format'), $comment->comment_date );// could use $comment->comment_date_gmt
							/* translators: 1: comment date, 2: comment time */
							// printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment), get_comment_time() );
						?></time>
					</a>
					<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => ' | ',
						'after'     => ''
					) ) );
					edit_comment_link( 'Edit', ' | ', '' );
					?>
				</div>
				<?php 
				if ( '0' == $comment->comment_approved )
					echo '<p class=comment-awaiting-moderation>Your comment is awaiting moderation.</p>';
				?>
			</header>
			<div class=comment-content>
				<?php comment_text(); ?>
			</div>
		</article>
	<?php
	// ending </li> is handled by core or a custom end-callback
}


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function frenchpress_categorized_blog() {
	
	if ( false === ( $cats = get_transient( 'frenchpress_categories' ) ) ) {
		
		$cats = get_categories( array(
			'fields'	 => 'ids',
			'hide_empty' => 1,
			'number'	 => 2,// We only need to know if there is more than one category.
		) );

		$cats = count( $cats );

		set_transient( 'frenchpress_categories', $cats );
	}

	if ( $cats > 1 ) return true;// This blog has more than 1 category
	
	else return false;// This blog has only 1 category
	
}

/**
 * Flush out the transients used in frenchpress_categorized_blog.
 */
function frenchpress_category_transient_flusher() {
	
	if ( ! defined( 'DOING_AUTOSAVE' ) || ! DOING_AUTOSAVE ) delete_transient( 'frenchpress_categories' );

}
add_action( 'edit_category', 'frenchpress_category_transient_flusher' );
add_action( 'save_post',	 'frenchpress_category_transient_flusher' );
