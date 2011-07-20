<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>

<p class="nocomments">
  <?php _e("This post is password protected. Enter the password to view comments."); ?>
<p>
  <?php
				return;
            }
        }
		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>
<div id="commentblock">
  <!--comments area-->
  <?php if ($comments) : ?>
  <h2 id="comments">
    <?php comments_number(__('no comments.'), __('1 comment:'), __('% comments:')); ?>
  </h2>
  <ol id="commentlist">
    <?php foreach ($comments as $comment) : ?>
    <li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
      <div class="commentname">
        <?php 
			$commenttype = '';
			if(get_comment_type() == 'pingback') {
				$commenttype = ' <strong>(Pingback)</strong>';
			} elseif (get_comment_type() == 'trackback') {
				$commenttype = ' <strong>(Trackback)</strong>';
			}
		?>
        <?php comment_author_link(); echo $commenttype . ', ' . get_comment_time('j. F Y, G:i'); ?> 
		<?php edit_comment_link(__("Edit This"), ''); ?> 
		 
      </div>
     	 <?php if ($comment->comment_approved == '0') : ?>
     	 <em>Your comment is awaiting moderation.</em>
      	<?php endif; ?>
		<div class="commenttext">
			<div class="commbgtop"></div>

			<?php
			if(get_comment_type() == 'pingback' || get_comment_type() == 'trackback') {
			?>
				<div class="gravatar">&nbsp;</div>			
			<?php
			} else {
			?>
				<div class="gravatar"><img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo md5($comment->comment_author_email); ?>&amp;rating=PG&amp;size=32" /></div>	
			<?	
			}
			?>
			
			

			<div class="commentp"><?php comment_text();?></div>
			<div class="commbgbottom">&nbsp;</div>
		</div> <!-- [commenttext] -->
					
    </li>
    <?php /* Changes every other comment to a different class */	
					if ('alt' == $oddcomment){
						$oddcomment = 'standard';
					}
					else {
						$oddcomment = 'alt';
					}
				?>
    <?php endforeach; /* end for each comment */ ?>
  </ol>
  <?php else : // this is displayed if there are no comments so far ?>
  <?php if ('open' == $post-> comment_status) : ?>
  <!-- If comments are open, but there are no comments. -->
  <h2 style="margin-bottom: 25px;" id="comments">No comments yet.</h2>
  <?php else : // comments are closed ?>
  <!-- If comments are closed. -->
	<!-- <p class="nocomments">Kommentare sind geschlossen.</p> -->
  <?php endif; ?>
  <?php endif; ?>
  <?php if ('open' == $post-> comment_status) : ?>
  <!--comments form -->
  <h2><?php _e('Write a comment');?>:</h2>
  <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
  <p> You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment. </p>
  <?php else : ?>
  <div id="commentsform">
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<div class="quicktags">
			<script type="text/javascript">displayQuicktags('comment');</script>
		</div>
	  
	  <p style="margin-top:0;">
        <textarea name="comment" id="comment" cols="100%" rows="10" tabindex="1"></textarea>
      </p>

      <?php if ( $user_ID ) : ?>
      <p> Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"> Logout &raquo; </a> </p>
      <?php else : ?>
      
	  <p>
        <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="2" />
        <label class="label" for="author">Name (required)</label>
      </p>
      <p>
        <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="3" />
        <label class="label" for="email">E-Mail (will not be published)(required)</label>
      </p>
      <p>
        <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="4" />
        <label class="label" for="url">Website (optional)</label>
      </p>
      
		<?php
		/****** Math Comment Spam Protection Plugin ******/
		if ( function_exists('math_comment_spam_protection') ) {
		$mcsp_info = math_comment_spam_protection();
		?> <p><input type="text" name="mcspvalue" id="mcspvalue" value="" size="22" tabindex="5" />
		<label class="label" for="mcspvalue">Summe von <?php echo $mcsp_info['operand1'] . ' + ' . $mcsp_info['operand2'] . ' ?' ?> (Spamschutz)</label>
		<input type="hidden" name="mcspinfo" value="<?php echo $mcsp_info['result']; ?>" />
		</p>
		<?php } // if function_exists... ?> 
      
      
      <?php endif; ?>
      <p>
        <input name="submit" type="submit" id="submit" tabindex="6" value="Submit Comment" />
        <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
      </p>
      <?php do_action('comment_form', $post->ID); ?>
    </form>
  </div>
  <?php endif; // If registration required and not logged in ?>
  <?php endif; // if you delete this the sky will fall on your head ?>
</div>
