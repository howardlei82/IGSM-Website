<?php $arjunaOptions = arjuna_get_options(); ?>
<div class="postHeader">
	<h2 class="postTitle"><a href="<?php the_permalink() ?>" title="<?php _e('Permalink to', 'Arjuna'); ?> <?php the_title(); ?>"><span><?php the_title(); ?></span></a></h2>
	<div class="bottom"><div>
		<span class="postDate"><?php the_time(get_option('date_format')); ?><?php
			//Time
			if($arjunaOptions['postsShowTime']) {
				print _e(' at ', 'Arjuna'); the_time(get_option('time_format'));
			}
		?></span>
		<?php if($arjunaOptions['postsShowAuthor']): ?>
		<span class="postAuthor"><?php the_author_posts_link(); ?></span>
		<?php endif; ?>
		<?php if(arjuna_is_show_comments() || arjuna_is_show_trackbacks()): ?>
		<a href="<?php comments_link(); ?>" class="postCommentLabel"><span><?php
			if (function_exists('post_password_required') && post_password_required()) {
				_e('Pass required', 'Arjuna');
			} elseif(0 == $post->comment_count && !comments_open() && !pings_open()) {
				_e('Comments off', 'Arjuna'); 
			} else {
				comments_number(__('No comments', 'Arjuna'), __('1 comment', 'Arjuna'), __('% comments', 'Arjuna'));
			}
		?></span></a>
		<?php endif; ?>
	</div></div>
</div>