<?php $arjunaOptions = arjuna_get_options(); ?>
<?php
// This is the comments file for Wordpress 2.7+

// Forbid direct access
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('This page cannot be loaded directly.');

// Password protection
if ( post_password_required() ) {
	?>
	<p class="noComments"><?php _e('This post is password protected. Enter the password to view comments.', 'Arjuna'); ?></p>
	<?php
	return;
}

?>
<?php if(arjuna_is_show_comments() || arjuna_is_show_trackbacks()): ?>
<div class="commentHeader">
	<ul class="tabs" id="arjuna_commentTabs">
	<?php if(arjuna_is_show_comments()): ?>
		<li><a href="<?php the_permalink(); ?>#_comments" class="comments active"><span><i><?php
			_e('Comments', 'Arjuna');
		?> (<?php print arjuna_get_comments_count();?>)</i></span></a></li>
	<?php endif; ?>
	<?php if(arjuna_is_show_trackbacks()): ?>
		<li><a href="<?php the_permalink(); ?>#_trackbacks" class="trackbacks<?php
			if(!arjuna_is_show_comments()) print ' active';
		?>"><span><i><?php
			_e('Trackbacks', 'Arjuna');
		?> (<?php print arjuna_get_trackbacks_count();?>)</i></span></a></li>
	<?php endif; ?>
	</ul>
	
	<div class="buttons">
	<?php if(arjuna_is_show_comments() && comments_open()): ?>
		<a href="#respond" class="btnReply btn"><span><?php _e('Leave a comment', 'Arjuna'); ?></span></a>
	<?php endif; ?>
	<?php if(arjuna_is_show_trackbacks() && pings_open()): ?>
		<a href="<?php trackback_url(); ?>" class="btnTrackback btn"><span><?php _e('Trackback', 'Arjuna'); ?></span></a>
	<?php endif; ?>
	</div>
</div>

<div class="commentBody">
	<?php if(arjuna_is_show_comments()): ?>
	<div id="arjuna_comments" class="contentBox active">
		<?php
		if (isset($comments_by_type) && !empty($comments_by_type['comment'])) { ?>
			<ul class="commentList<?php if($arjunaOptions['commentDisplay']=='left') { echo ' commentListLeft'; } elseif($arjunaOptions['commentDisplay']=='right') { echo ' commentListRight'; } elseif($arjunaOptions['commentDisplay']=='alt') { echo ' commentListAlt'; } ?>">
				<?php wp_list_comments('callback=arjuna_get_comment&type=comment'); ?>
			</ul>
		<?php
			arjuna_get_comment_pagination();
		} elseif ('open'==$post->comment_status)
			print '<p class="noComments">'.__('No one has commented yet.', 'Arjuna').'</p>';
		else
			print '<p class="noComments">'.__('Comments are closed.', 'Arjuna').'</p>';
		?>
	</div>
	<?php endif; ?>
	<?php if(arjuna_is_show_trackbacks()): ?>
	<div id="arjuna_trackbacks" class="contentBox<?php
			if(!arjuna_is_show_comments()) print ' active';
		?>">
		<?php 
		if (isset($comments_by_type) && !empty($comments_by_type['pings'])) { ?>
			<ul class="commentList<?php if($arjunaOptions['commentDisplay']=='left') { echo ' commentListLeft'; } elseif($arjunaOptions['commentDisplay']=='right') { echo ' commentListRight'; } elseif($arjunaOptions['commentDisplay']=='alt') { echo ' commentListAlt'; } ?>">
				<?php wp_list_comments('callback=arjuna_get_trackback&type=pings'); ?>
			</ul>
		<?php
			arjuna_get_comment_pagination('#_trackbacks');
		} elseif ('open'==$post->ping_status)
			print '<p class="noComments">'.__('No trackbacks yet.', 'Arjuna').'</p>';
		else
			print '<p class="noComments">'.__('Trackbacks are disabled.', 'Arjuna').'</p>';
		?>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php
// Commment form
if ('open' == $post->comment_status)
	get_template_part( 'templates/comments/reply-form-advanced' );
else
	do_action( 'comment_form_comments_closed' );
?>
