<?php $arjunaOptions = arjuna_get_options(); ?>
<?php
print '<input type="hidden" id="replyNameDefault" value="' . __('Your name', 'Arjuna') . '" />';
print '<input type="hidden" id="replyEmailDefault" value="' . __('Your email', 'Arjuna') . '" />';
print '<input type="hidden" id="replyURLDefault" value="' . __('Your website', 'Arjuna') . '" />';
print '<input type="hidden" id="replyMsgDefault" value="' . __('Your comment', 'Arjuna') . '" />';

comment_form(array(
	'fields' => array(
		'author' => '<div class="replyRow"><input type="text" class="inputText' . (empty($comment_author) ? ' inputIA' : '') . '" id="replyName" name="author" value="' . (!empty($commenter['comment_author']) ? echo esc_attr($commenter['comment_author']) : __('Your name', 'Arjuna')) . '" /></div>',
		'email' => '<div class="replyRow"><input type="text" class="inputText' . (empty($comment_author_email) ? ' inputIA' : '') . '" id="replyEmail" name="email" value="' . (!empty($commenter['comment_author_email']) ? echo esc_attr($commenter['comment_author_email']) : __('Your email', 'Arjuna')) . '" /></div>',
		'url' => '<div class="replyRow"><input type="text" class="inputText' . (empty($comment_author_url) ? ' inputIA' : '') . '" id="replyURL" name="url" value="' . (!empty($commenter['comment_author_url']) ? echo esc_attr($commenter['comment_author_url']) : __('Your website', 'Arjuna')) . '" /></div>',
	),
	'title_reply' => __('Leave a Comment', 'Arjuna'),
	'title_reply_to' => __('Leave a Reply to %s', 'Arjuna'),
	'cancel_reply_link' => '<span>' . __('Cancel Reply', 'Arjuna') . '</span>',
	'comment_field' => '<div class="replyRow"><textarea class="inputIA" id="comment" name="comment">' . __('Your comment', 'Arjuna') . '</textarea></div>',
	'must_log_in' => '<p style="margin-bottom:40px;">' . sprintf(__('You must be %slogged in%s to post a comment.', 'Arjuna'), '<a href="'.get_option('siteurl').'/wp-login.php?redirect_to='.get_permalink().'">', '</a>') . '</p>',
	'logged_in_as' => '<div class="replyLoggedIn">' . sprintf(__('Logged in as %s.', 'Arjuna'), '<a href="'.admin_url( 'profile.php' ).'">'.$user_identity.'</a>') . ' <a class="btnLogout btn" href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) . '" title="' . __('Log out of this account', 'Arjuna') . '"><span>' . __('Logout', 'Arjuna') . '</span></a></div>',
	'comment_notes_before' => '',
	'comment_notes_after' => '',
	'id_form'              => 'commentform',
	'id_submit'            => 'submit',
));
?>