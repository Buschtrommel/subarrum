<?php 
/**
 * Comments template
 *
 * Presents the threaded comments, uses subarrum_comment and subarrum_comment_end as callback.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 * @from Twenty Twelve
 */


/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">
	
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'subarrum' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
			<small>
			 <i class="icon-rss"></i> <?php printf('<a class="hasTip" title="%1$s" href="%2$s">%3$s</a>',
				__("Subscribe to this post's comments RSS feed", "subarrum"),
				esc_url(get_permalink().'feed/'),
				__('Comments feed', 'subarrum')
				); ?>
			</small>
		</h3>

		<div class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'subarrum_comment', 
						       'style' => 'div',
						       'end-callback' => 'subarrum_comment_end' ) ); ?>
		</div><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
		  <ul class="pager">
		    <li class="previous">
		      <?php previous_comments_link( __( '&larr; Older Comments', 'subarrum' ) ); ?>
		    </li>
		    <li class="next">
		      <?php next_comments_link( __( 'Newer Comments &rarr;', 'subarrum' ) ); ?>
		    </li>
		  </ul>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<div class="alert"><?php _e( 'Comments are closed.' , 'subarrum' ); ?></div>
		<?php endif; ?>
		<hr />
	<?php endif; // have_comments() ?>

	<?php
	  
	  $commentformargs = array(
		'comment_notes_before' => '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' . __( 'Your email address will not be published.', 'subarrum' ) . ( $req ? $required_text : '' ) . '</div>',
		'comment_notes_after' => '<p class="form-allowed-tags" id="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <pre>' . allowed_tags() . '</pre>' ) . '</p>',
		'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" class="span12" rows="8" aria-describedby="form-allowed-tags" aria-required="true"></textarea></p>'
	  );
	
	  comment_form($commentformargs);
	?>
	
	<script type="text/javascript">
	  jQuery("input#submit").addClass("btn btn-primary");
	</script>

</div><!-- #comments .comments-area -->