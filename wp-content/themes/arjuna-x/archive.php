<?php $arjunaOptions = arjuna_get_options(); ?>
<?php get_header(); ?>

<div class="contentArea" id="contentArea">
	<?php if (have_posts()) : ?>
	<h3 class="contentHeader"><?php 
		if (is_category()) { 
			printf(__('Browsing Posts in <em>%s</em>', 'Arjuna'), single_cat_title(NULL, false));
		} elseif( is_tag() ) {
			printf(__('Browsing Posts tagged <em>%s</em>', 'Arjuna'), single_tag_title(NULL, false));
		} elseif (is_day()) {
			printf( __('Browsing Posts published on %s', 'Arjuna'), get_the_time(get_option('date_format')) );
		} elseif (is_month()) {
			printf( __('Browsing Posts published in %s', 'Arjuna'), get_the_time(__('F, Y', 'Arjuna')) );
		} elseif (is_year()) {
			printf( __('Browsing Posts published in %s', 'Arjuna'), get_the_time(__('Y', 'Arjuna')) );
		} elseif (is_author()) {
			$currentAuthor = get_queried_object();
			printf(__('Browsing Posts published by <em>%s</em>', 'Arjuna'), $currentAuthor->display_name?$currentAuthor->display_name:$currentAuthor->nickname);
		} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { 
			_e('Blog Archives', 'Arjuna');
		} ?>
	</h3>
	
	<?php while (have_posts()) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<?php get_template_part( 'templates/post/post-header' ); ?>
		
		<div class="postContent">
			<?php
			if($arjunaOptions['excerpts_categoryPages'] && (is_category() || is_tag()))
				the_excerpt();
			elseif($arjunaOptions['excerpts_archivePages'] && (is_day() || is_month() || is_year()))
				the_excerpt();
			elseif($arjunaOptions['excerpts_authorPages'] && is_author())
				the_excerpt();
			else
				the_content(__('continue reading...', 'Arjuna'));
			?>
		</div>
		
		<?php get_template_part( 'templates/post/post-footer' ); ?>
	</div>
	<?php endwhile; ?>

	<?php get_template_part( 'templates/core/pagination' ); ?>

	<?php else : ?>
  <p><?php _e('There is nothing here (yet).', 'Arjuna'); ?></p>
	<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
