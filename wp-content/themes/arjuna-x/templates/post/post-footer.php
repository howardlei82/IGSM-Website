<?php $arjunaOptions = arjuna_get_options(); ?>
<div class="postFooter"><div class="r"></div>
	<div class="left">
	<?php if($arjunaOptions['archives_includeCategories']): ?>
		<span class="postCategories"><?php the_category(', '); ?></span>
	<?php endif; ?>
	<?php if($arjunaOptions['archives_includeTags'] && function_exists('the_tags')): ?>
		<span class="postTags"><?php
			if (get_the_tags()) the_tags('', ', ', '');
			else print '<span>'.__('<i>none</i>', 'Arjuna').'</span>';
		?></span>
	<?php endif; ?>
	</div>
	<?php if($arjunaOptions['excerpts_index']): ?>
		<a href="<?php the_permalink() ?>" class="btn btnReadMore"><span><?php _e('Read more', 'Arjuna'); ?></span></a>
	<?php endif; ?>
</div>