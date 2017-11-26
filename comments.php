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
?>

<section id="comments" class="comments-area">
	<?php
	
	if ( have_comments() ) :
		
		?>
		<h2 class="comments-title h3">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				_e( 'One Comment', 'frenchpress' );
			} else {
				printf( __( '%1$s Comments', 'frenchpress' ), $comments_number );
			}
			?>
		</h2>
		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'callback'   => 'frenchpress_comment',// this is in inc/template-tags.php
					'style'      => 'ol',
					'short_ping' => true,
				) );
			?>
		</ol>
		<?php 
		
		the_comments_pagination( // array(
					// 'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous', 'twentyseventeen' ) . '</span>',
					// 'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
				//)
			);

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'frenchpress' ); ?></p>
	<?php
	endif;

	comment_form();
	?>

</section>