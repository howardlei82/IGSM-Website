<?php $arjunaOptions = arjuna_get_options(); ?>
<?php get_header(); ?>

<div class="contentArea" id="contentArea">
	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	
	<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<?php if(!$arjunaOptions['pages_showInfoBar']): ?>
			<div class="postHeaderCompact"><div class="inner">
				<a href="<?php the_permalink() ?>" title="<?php _e('Permalink to', 'Arjuna'); ?> <?php the_title(); ?>"><h1 class="postTitle"><?php the_title(); ?></h1></a>
				<div class="bottom"><span></span></div>
			</div></div>
		<?php else: ?>
			<?php get_template_part( 'templates/post/single-post-header' ); ?>
		<?php endif; ?>
		<div class="postContent">
			<?php the_content(__('continue reading...', 'Arjuna')); ?>
		</div>
		<div class="postLinkPages"><?php wp_link_pages('before=<strong>'.__('Pages:', 'Arjuna').'</strong>&pagelink=<span>'.__('Page %', 'Arjuna').'</span>'); ?></div>
		<?php get_template_part( 'templates/post/single-page-footer' ); ?>
	</div>
	<?php if(arjuna_is_show_comments() || arjuna_is_show_trackbacks()): ?>
		<div class="postComments" id="comments">
			<?php comments_template('', true); ?>
		</div>
	<?php endif; ?>
	
	<?php endwhile; ?>

	<?php else : ?>
  <p><?php _e('There is nothing here.', 'Arjuna'); ?></p>
	<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
