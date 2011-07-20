<?php $arjunaOptions = arjuna_get_options(); ?>
<?php get_header(); ?>

<div class="contentArea" id="contentArea">
	<?php if (have_posts()) : ?>
	<h3 class="contentHeader"><?php 
		if (is_search()) { 
			printf(__('Search Results on <em>%s</em>', 'Arjuna'), $s);
		}
	?></h3>
	
	<?php while (have_posts()) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<?php get_template_part( 'templates/post/post-header' ); ?>
		
		<div class="postContent">
			<?php 
			if($arjunaOptions['excerpts_searchPages'])
				the_excerpt();
			else the_content(__('continue reading...', 'Arjuna'));
			?>
		</div>
		<?php if($arjunaOptions['excerpts_index'] || $arjunaOptions['archives_includeCategories'] || $arjunaOptions['archives_includeTags']): ?>
			<?php get_template_part( 'templates/post/post-footer' ); ?>
		<?php endif; ?>
	</div>
	<?php endwhile; ?>

	<?php get_template_part( 'templates/core/pagination' ); ?>

	<?php else : ?>
  <p><?php _e('Your search returned no results.', 'Arjuna'); ?></p>
	<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
