<?php $arjunaOptions = arjuna_get_options(); ?>
<?php
global $user_identity;
$commenter = wp_get_current_commenter();
?>
<?php do_action( 'comment_form_before' ); ?>
<div class="commentReply" id="respond">
	<div class="replyHeader">
		<h4><?php comment_form_title( __('Leave a Comment', 'Arjuna'), __('Leave a Reply to %s', 'Arjuna') ); ?></h4>
		<?php if (function_exists('cancel_comment_reply_link')) { ?>
			<div id="cancel-comment-reply" class="cancelReply"><?php arjuna_cancel_comment_reply_link('<span>'.__('Cancel Reply', 'Arjuna').'</span>');?></div>
		<?php } ?>
	</div>
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p style="margin-bottom:40px;"><?php printf(__('You must be %slogged in%s to post a comment.', 'Arjuna'), '<a href="'.get_option('siteurl').'/wp-login.php?redirect_to='.get_permalink().'">', '</a>'); ?></p>
		<?php do_action('comment_form_must_log_in_after'); ?>
	<?php else : ?>
		<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" name="reply" method="post" id="commentform">
			<?php do_action( 'comment_form_top' ); ?>
			<input type="hidden" id="replyNameDefault" value="<?php echo esc_attr(__('Your name', 'Arjuna')); ?>" />
			<input type="hidden" id="replyEmailDefault" value="<?php echo esc_attr(__('Your email', 'Arjuna')); ?>" />
			<input type="hidden" id="replyURLDefault" value="<?php echo esc_attr(__('Your website', 'Arjuna')); ?>" />
			<input type="hidden" id="replyMsgDefault" value="<?php echo esc_attr(__('Your comment', 'Arjuna')); ?>" />
			<?php if ( is_user_logged_in() ): ?>
				<div class="replyLoggedIn">
				<?php echo apply_filters( 'comment_form_logged_in', '<div class="replyLoggedIn">' . sprintf(__('Logged in as %s.', 'Arjuna'), '<a href="'.admin_url( 'profile.php' ).'">'.$user_identity.'</a>') . ' <a class="btnLogout btn" href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) . '" title="' . __('Log out of this account', 'Arjuna') . '"><span>' . __('Logout', 'Arjuna') . '</span></a></div>', $commenter, $user_identity ); ?>
				</div>
				<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
			<?php else : ?>
				<?php do_action( 'comment_form_before_fields' ); ?>
				<div class="replyRow"><input type="text" class="inputText<?php if(empty($commenter['comment_author'])): ?> inputIA<?php endif; ?>" id="replyName" name="author" value="<?php if(!empty($commenter['comment_author'])) { echo esc_attr($commenter['comment_author']); } else { echo esc_attr(__('Your name', 'Arjuna')); } ?>" /></div>
				<div class="replyRow"><input type="text" class="inputText<?php if(empty($commenter['comment_author_email'])): ?> inputIA<?php endif; ?>" id="replyEmail" name="email" value="<?php if(!empty($commenter['comment_author_email'])) { echo esc_attr($commenter['comment_author_email']); } else { echo esc_attr(__('Your email', 'Arjuna')); } ?>" /></div>
				<div class="replyRow"><input type="text" class="inputText<?php if(empty($commenter['comment_author_url'])): ?> inputIA<?php endif; ?>" id="replyURL" name="url" value="<?php if(!empty($commenter['comment_author_url'])) { echo esc_attr($commenter['comment_author_url']); } else { echo esc_attr(__('Your website', 'Arjuna')); } ?>" /></div>
				<?php do_action( 'comment_form_after_fields' ); ?>
			<?php endif; ?>
			<?php
			if (function_exists('cancel_comment_reply_link')) { 
				//comment loop code
				comment_id_fields();
			}
			?>
			<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
			<div class="replyRow"><?php echo apply_filters( 'comment_form_field_comment', '<div class="replyRow"><textarea class="inputIA" id="comment" name="comment">' . esc_textarea(__('Your comment', 'Arjuna')) . '</textarea></div>' ); ?></div>
			<div class="replySubmitArea">
				<a href="<?php echo get_post_comments_feed_link(); ?>" class="btnSubscribe btn"><span><?php _e('Subscribe to comments', 'Arjuna'); ?></span></a>
				<button type="submit" class="inputBtn" value="Submit" name="submit"><?php _e('Leave comment', 'Arjuna'); ?></button>
			</div>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
	<?php endif; // If registration required and not logged in ?>
	<?php do_action( 'comment_form_after' ); ?>
</div>