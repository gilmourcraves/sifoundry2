<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$fields =  array(

	'author' =>
		'<p class="comment-form-author"><div class="form-group"><label for="author">' . __( 'Name', 'domainreference' ) . '</label> ' .
		( $req ? '<span class="required">*</span>' : '' ) .
		'<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		'" ' . $aria_req . ' /></div></p>',

	'email' =>
		'<p class="comment-form-email"><div class="form-group"><label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' .
		( $req ? '<span class="required">*</span>' : '' ) .
		'<input id="email" name="email" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		'" ' . $aria_req . ' /></div></p>',

	'url' =>
		'<p class="comment-form-url"><div class="form-group"><label for="url">' . __( 'Website', 'domainreference' ) . '</label>' .
		'<input id="url" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		'"   /></div></p>',

);
$comments_args = array(

	// change "Leave a Reply" to "Comment"
	'title_reply'=>'Discuss this post ?',
	'fields' => apply_filters( 'comment_form_default_fields', $fields ),
	'comment_field' =>  '<p class="comment-form-comment"><div class="form-group"><label for="comment">' . _x( 'Comment', 'noun' ) .
	                    '</label><textarea id="comment" name="comment" class="form-control"  rows="8" aria-required="true">' .
	                    '</textarea></p></div>',
	'comment_notes_after' => ' ');

?>

<div id="comments" class="comments-area" >

	<?php if ( have_comments() ) : ?>
		<h2>Comments</h2>



		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 56,
				) );
			?>
		</ol><!-- .comment-list -->

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments">Comments are closed</p>
	<?php endif; ?>

	<?php comment_form($comments_args); ?>

</div><!-- .comments-area -->
