<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->
<?php if (have_comments() ) : ?>
<div class="sep">&nbsp;</div><a name="comments"></a>
<div id="comments">

<h2><?php comments_number( __('No Comments', 'wpzoom'), __('1 Comment', 'wpzoom'), __('% Comments', 'wpzoom')); ?></h2>

<div id="commentspost">
	<ol class="comments"><?php wp_list_comments('type=all&avatar_size=40');?></ol>
</div><!-- #commentspost -->
	
 <?php else : // this is displayed if there are no comments so far ?>

<?php if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->
<div class="sep">&nbsp;</div><a name="comments"></a>
<div id="comments">

<h2><?php _e('No comments','wpzoom');?></h2>

<div id="commentspost">
<p><?php _e('Be the first one to leave a comment.','wpzoom');?></p>
</div>
<?php else : // comments are closed ?>

<?php if (!is_page()) { ?>
<div id="comments">

<h2><?php _e('Comments are closed','wpzoom');?></h2>
<p><?php _e('Sorry, but you cannot leave a comment for this post.','wpzoom');?></p>
</div><!-- end #comments -->
<?php } ?>
<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>

<div id="respond">

	<h2><?php comment_form_title( __('Post a Comment', 'wpzoom'), __('Leave a Reply to %s', 'wpzoom') ); ?></h2>
	
	<div class="cancel-comment-reply"><p><?php cancel_comment_reply_link(); ?></p></div>
	
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p><?php _e('You must be','wpzoom');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in','wpzoom');?></a> <?php _e('to post a comment.','wpzoom');?></p>
	<?php else : ?>
	
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	
		<?php if ( $user_ID ) : ?>
		
		<p><?php _e('Logged in as','wpzoom');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out','wpzoom');?> &raquo;</a></p>
		
		<?php else : ?>
		<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
		<label for="author"><?php _e('Name','wpzoom');?> <?php if ($req) { _e('required', 'wpzoom'); } ?></label>
		
		<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
		<label for="email"><?php _e('E-Mail','wpzoom');?> <?php if ($req) { _e('required', 'wpzoom'); } ?></label>
		
		<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
		<label for="url"><?php _e('Website','wpzoom');?></label>
		<?php endif; ?>
		<textarea name="comment" id="comment" tabindex="4" cols="140" rows="8"></textarea><br />
		<!-- <p><strong>XHTML:</strong> You can use these tags: <br /><code><?php echo allowed_tags(); ?></code></p> -->
		<input name="submit" type="submit" id="submit" value="<?php _e('submit','wpzoom');?>" />
		<div class="clear">&nbsp;</div>
		<?php comment_id_fields(); ?>
		<?php do_action('comment_form', $post->ID); ?>

	</form>

	<?php endif; // If registration required and not logged in ?>

</div><!-- end #respond -->

<?php endif; // if you delete this the sky will fall on your head ?>

<?php if ('open' == $post->comment_status || have_comments()){ ?>    
</div><!-- #comments -->
<?php } ?>