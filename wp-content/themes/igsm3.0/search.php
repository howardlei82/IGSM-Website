<?php
get_header();
?>

<div id="contentbody"><!-- beginning of contenbody -->

<h2 class="archives">Search results</h2>

  <?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
  	<div class="entry">
    <p><strong> <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></strong> </p>
	  <div class="entrymeta">
		<?php the_time('F dS, Y ');?>
	</div>
        <div class="excerpt">
               <?php the_excerpt();?>
        </div>
  </div>
  <?php endwhile; else: ?>
  <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

  <?php endif; ?>
  <p><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></p>

</div> <!-- [contentbody] -->
<?php get_sidebar(); ?>
<div id="breadcrumb"></div>
<?php get_footer(); ?>
