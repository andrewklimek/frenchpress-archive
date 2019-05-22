<?php
/**
 * Called via comments_template()
 */

if ( post_password_required() ) {
	return;
}

echo '<section id=comments class=comments-area>';
	
	if ( have_comments() ) :
		
		echo '<h2 class="comments-title h3">';
			
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				echo 'One Comment';
			} else {
				printf( '%1$s Comments', $comments_number );
			}
		echo '</h2>
			<ol class=comment-list>';
		
				wp_list_comments( array(
					'callback'   => 'frenchpress_comment',// this is in inc/template-tags.php
					'style'      => 'ol',
					'short_ping' => true,
				) );
				
		echo '</ol>';
		
		the_comments_pagination();

	endif; // Check for have_comments().


	// If comments are closed but there are comments, say comments are closed
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {

		echo '<p class=no-comments>Comments are closed.</p>';
	}

    /**
     * You can remove the "website" field from the comment form like so:
     * add_filter( 'comment_form_default_fields', function($fields){ unset($fields['url']); return $fields; } );
     */
	comment_form();
	
	echo '</section>';
	