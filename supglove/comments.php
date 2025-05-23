<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Supglove
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$layout = supro_get_option( 'single_post_layout' );
$col = 'col-md-12';

if ( 'full-content' == $layout ) {
	$col = 'col-md-8 col-md-offset-2';
}

?>

<div id="comments" class="comments-area">
	<div class="row">
		<div class="<?php echo esc_attr( $col ) ?> col-xs-12 col-sm-12">
		<?php // You can start editing here -- including this comment! ?>

		<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			printf( // WPCS: XSS OK.
				esc_html( _nx( 'No Comments', '%1$s Comments', get_comments_number(), 'comments title', 'supro' ) ),
				number_format_i18n( get_comments_number() )
			);
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-above" class="navigation comment-navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'supro' ); ?></h2>
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'supro' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'supro' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list clearfix">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'callback'    => 'supro_comment'
			) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'supro' ); ?></h2>
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'supro' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'supro' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>

		<?php endif; // Check for have_comments(). ?>

		<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'supro' ); ?></p>
		<?php endif; ?>

		<?php

		$args = array(
			'comment_field'         =>  '<p class="comment-form-comment"><textarea placeholder="' . esc_attr__( 'Your comment...', 'supro' ) . '" required id="comment" name="comment" cols="45" rows="6">' .
				'</textarea></p>',
			'comment_notes_before'  => '<p class="comment-notes">' .
				esc_html__( 'Your email address will not be published.', 'supro' ) .
				'</p>',
			'format'        => 'xhtml',
		);

		comment_form($args);
		?>
		</div>
	</div>
</div><!-- #comments -->
