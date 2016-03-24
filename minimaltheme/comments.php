<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentytwelve_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage sampletest
 * @since sample test
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
    return;
?>


    <?php if ( have_comments() ) : ?>

        <ol class="commentlist">
            <?php wp_list_comments(array(),get_comments(array('status'=>'approve'))); ?>
        </ol><!-- .commentlist -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
        <nav id="comment-nav-below" class="navigation" role="navigation">
            <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'sampletest' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'sampletest' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'sampletest' ) ); ?></div>
        </nav>
        <?php endif; // check for comment navigation ?>

        <?php
        /* If there are no comments and comments are closed, let's leave a note.
         * But we only want the note on posts and pages that had comments in the first place.
         */
        if ( ! comments_open() && get_comments_number() ) : ?>
        <p class="nocomments"><?php _e( 'Comments are closed.' , 'sampletest' ); ?></p>
        <?php endif; ?>

    <?php endif; // have_comments() ?>
    
    <div id="cmnt_write" class="cmnt_write clearfix">
               <h3>Add a comment</h3>
        <?php
		
			$commenter = wp_get_current_commenter();
			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );
			$fields =  array(
				'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="author" name="author" type="text" value="" size="30"' . $aria_req . ' /></p>',
				'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="email" name="email" type="text" value="" size="30"' . $aria_req . ' /></p>',
			);
			 
			$comments_args = array(
				'fields' =>  $fields,
				'title_reply'=>'Please give us your valuable comment',
				'label_submit' => 'Send My Comment',
				'comment_field' => '<textarea rows="8" id="comment" name="comment" aria-required="true" placeholder="Comments" cols="50"></textarea>'
			);
			 
			comment_form($comments_args);
			
 
            /*$comments_args = array(
                    // change the title of send button 
                    'label_submit'=>'Add Comment',
                    // change the title of the reply section
                    'title_reply'=>'',
                    // remove "Text or HTML to be displayed after the set of comment fields"
                    'comment_notes_after' => '',
                    // redefine your own textarea (the comment body)
                    'comment_field' => '<textarea rows="8" id="comment" name="comment" aria-required="true" placeholder="Comments" cols="50"></textarea>',
            );

            comment_form($comments_args);*/
        ?>
    </div>


<?php 
   wp_list_comments("callback=my_custom_comments"); 
?>