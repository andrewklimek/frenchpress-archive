<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package FrenchPress
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

echo '<section id="comments" class="comments-area">';
	
	if ( have_comments() ) :
		
		echo '<h2 class="comments-title h3">';
			
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				_e( 'One Comment', 'frenchpress' );
			} else {
				printf( __( '%1$s Comments', 'frenchpress' ), $comments_number );
			}
		echo '</h2>
			<ol class="comment-list">';
		
				wp_list_comments( array(
					'callback'   => 'frenchpress_comment',// this is in inc/template-tags.php
					'style'      => 'ol',
					'short_ping' => true,
				) );
				
		echo '</ol>';
		
		the_comments_pagination( // array(
					// 'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous', 'twentyseventeen' ) . '</span>',
					// 'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
				//)
			);

	endif; // Check for have_comments().


	// If comments are closed but there are comments, say comments are closed
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {

		echo '<p class="no-comments">' . __( 'Comments are closed.', 'frenchpress' ) . '</p>';
	}

    /**
     * You can remove the "website" field from the comment form like so:
     * add_filter( 'comment_form_default_fields', function($fields){ unset($fields['url']); return $fields; } );
     */
	comment_form();
	
	echo '</section>';
	