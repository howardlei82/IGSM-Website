<?php $arjunaOptions = arjuna_get_options(); ?>
<?php get_header(); ?>

<div class="contentArea" id="contentArea">
	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	<?php if($arjunaOptions['posts_showTopPostLinks'] && arjuna_has_other_posts()): ?>
		<?php get_template_part( 'templates/post/single-post-top-links' ); ?>
	<?php endif; ?>
	
	<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<?php get_template_part( 'templates/post/single-post-header' ); ?>
		
		<div class="postContent">
			<?php the_content(__('continue reading...', 'Arjuna')); ?>
		</div>
		<div class="postLinkPages"><div>
			<?php arjuna_get_post_pagination(__('Previous Page', 'Arjuna'), __('Next Page', 'Arjuna'));?>
		</div></div>
		<?php get_template_part( 'templates/post/single-post-footer' ); ?>
	</div>
	<?php if(arjuna_is_show_comments() || arjuna_is_show_trackbacks()): ?>
	<div class="postComments" id="comments">
		<?php comments_template('', true); ?>
	</div>
	<?php endif; ?>

	<?php if($arjunaOptions['posts_showBottomPostLinks'] && arjuna_has_other_posts()): ?>
		<?php get_template_part( 'templates/post/single-post-bottom-links' ); ?>
	<?php endif; ?>
	<?php endwhile; ?>



	<?php else : ?>
  <p><?php _e('There is nothing here.', 'Arjuna'); ?></p>
	<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
