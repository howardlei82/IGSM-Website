<?php
/*
Template Name: Signups Category
*/
?>

<?php
get_header();
?>
<div id="contentbody"><!-- beginning of contentbody -->
	<h3 class="entrytitle">Sign Up Forms</h3>
	<div class="entry"> 
		<ul class="signups">
			<li><b>Courses &amp; Training</b></li>
			  <li><ul>
			  <?php query_posts('cat=-196,240&showposts='.get_option('posts_per_page').'&paged='.$paged); ?> 
			  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?> id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></li>
			  <?php endwhile; else: ?>
			  <li><?php _e('No signups currently.'); ?></li>
			  <?php endif; ?>
			  </ul></li>
			<li><b>English Class</b></li>
			  <li><ul>
			  <?php query_posts('cat=-196,244&showposts='.get_option('posts_per_page').'&paged='.$paged); ?> 
			  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?> id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></li>
			  <?php endwhile; else: ?>
			  <li><?php _e('No signups currently.'); ?></li>
			  <?php endif; ?>
			  </ul></li> 
			<li><b>Outings</b></li>
			  <li><ul>
			  <?php query_posts('cat=-196,242&showposts='.get_option('posts_per_page').'&paged='.$paged); ?> 
			  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?> id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></li>
			  <?php endwhile; else: ?>
			  <li><?php _e('No signups currently.'); ?></li>
			  <?php endif; ?>
			  </ul></li>
			<li><b>Retreats</b></li>			
			  <li><ul>
			  <?php query_posts('cat=-196,241&showposts='.get_option('posts_per_page').'&paged='.$paged); ?> 
			  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?> id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></li>
			  <?php endwhile; else: ?>
			  <li><?php _e('No signups currently.'); ?></li>
			  <?php endif; ?>
			  </ul> </li>
			<li><b>Small Groups</b></li> 	
			  <li><ul>
			  <?php query_posts('cat=-196,243&showposts='.get_option('posts_per_page').'&paged='.$paged); ?> 
			  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?> id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></li>
			  <?php endwhile; else: ?>
			  <li><?php _e('No signups currently.'); ?></li>
			  <?php endif; ?>
			  </ul> </li>
		</ul>
			  <?php wp_reset_query();?>
    <!--
	<?php trackback_rdf(); ?>
	--> 

  </div> <!-- [entry] --> 

  <p><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></p>

</div> <!-- [contentbody] -->
<?php get_sidebar(); ?>
<div id="breadcrumb"></div>

<?php get_footer(); ?>
