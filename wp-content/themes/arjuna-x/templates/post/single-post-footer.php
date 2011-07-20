<div class="postFooter"><div class="r"></div>
	<div class="left">
		<span class="postCategories"><?php the_category(', '); ?></span>
		<?php if ( function_exists('the_tags') ): ?>
		<span class="postTags"><?php
			if (get_the_tags()) the_tags('', ', ', '');
			else print '<span>'.__('<i>none</i>', 'Arjuna').'</span>';
		?></span>
		<?php endif; ?>
	</div>
	<?php print arjuna_get_edit_link(__('Edit in Admin', 'Arjuna')); ?>
</div>