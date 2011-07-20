<?php
get_header();
?>

<div id="contentbody">
	
  <?php if (have_posts()) : ?>
  	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php 
	if (is_category()) { ?>				
	<?php }
	 
	elseif (is_day()) { ?>
		<h2 class='archives'>Archive for <?php the_time('F jS, Y'); ?></h2>
	<?php }
	
	elseif (is_month()) { ?>
		<h2 class='archives'>Archive for <?php the_time('F, Y'); ?></h2>
	<?php } 
	
	elseif (is_year()) { ?>
		<h2 class='archives'>Archive for <?php the_time('Y'); ?></h2>
	<?php } 
	
	elseif (is_author()) { ?>
		<h2 class='archives'>Author Archive</h2>
	<?php }
	 
	elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2>Blog Archives</h2>
	<?php } ?>
<?php while (have_posts()) : the_post(); ?>
  <div class="entry">
    <h3 class="entrytitle" id="post-<?php the_ID(); ?>"> <a href="<?php the_permalink() ?>" rel="bookmark" title="Article-Link (Permalink)"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></h3>
	  <div class="entrymeta1"> 
		    <span class="meta-time"><?php the_time('F dS, Y ') ?></span><span class="meta-comments"><strong>
			<?php comments_popup_link($comments_img_link .' Comments(0)', $comments_img_link .' Comments(1)', $comments_img_link . ' Comments(%)'); ?>
			</strong>
	  </div>
      <div class="entrybody"><?php the_content(__('Read more &raquo;'));?></div>
    <!--
	<?php trackback_rdf(); ?>
	-->
  </div>
<?php endwhile; else: ?>
  <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
  <?php endif; ?>
  <p><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></p>
</div>
<?php get_sidebar(); ?>
<div id="breadcrumb"></div>

<?php get_footer(); ?>
