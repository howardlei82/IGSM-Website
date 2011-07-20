<?php
/*
Template Name: Announcements Category
*/
?>

<?php
get_header();
?>
<div id="contentbody"><!-- beginning of contenbody -->
  <?php query_posts('cat=20&showposts='.get_option('posts_per_page').'&paged='.$paged); ?>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="entry">
		<h3 <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?>class="entrytitle" id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></h3>
		<div class="entrymeta1">
		<?php
		
		if (! is_page()) {	// Do not display if we are on a page
			// Date and author
			if (is_single()) { $articledate = get_the_time('j. F Y, G:i') . ' Uhr'; } else { $articledate = get_the_time('j. F Y'); }
			echo '<span class="meta-time">' . $articledate . '</span><span class="meta-category">'; the_category(', '); echo '</span><span class="meta-author"><a title="author" href="'; the_author_url(); echo '">'; the_author(); echo '</a></span>';
			// Comments link 
			comments_popup_link('<span class="meta-comments">0 comments</span>', '<span class="meta-comments">1 comment</span>', '<span class="meta-comments">% comments</span>');


		} // ! is_page()
		?>
		</div> <!-- [entrymeta1] -->

		<div class="entrybody">
			<?php the_content(__('Read more &raquo;'));?>
		</div> <!-- [entrybody] -->

		<?php if (is_single()) { ?>

		<div class="entrymeta2">
		<ul>
		<?php
		// *** Trackback URI: only if ping is enabled
		if ( pings_open() ) { ?>
			<li><a class="trackback-leftalign" title="Trackback-URL for &#39;<?php the_title() ?>&#39;" href="<?php trackback_url() ?>" rel="nofollow">Trackback-URL</a></li>
<?php   }
		?>

		<?php
		// *** RSS Comments: only if comments are enabled 
		if ( comments_open() ) { ?>
			<li class="feed-leftalign"><span title="Subscribe to comments feed"><?php comments_rss_link('comments feed for this post') ?></span></li>
<?php	}
		?>
				
		<?php
		// *** Tags: only if there is any
		if ( (function_exists('UTW_ShowTagsForCurrentPost')) ) { ?>
		    <li class="utwtags"><span title="tags"><?php UTW_ShowTagsForCurrentPost("commalist") ?></span></li>
<?php   }
		?>
		</ul>
		
		</div> <!-- [entrymeta2] -->
		
		<?php comments_template(); // Get wp-comments.php template ?>
		
		<?php } // is_single() ?>

    <!--
	<?php trackback_rdf(); ?>
	-->
  </div> <!-- [entry] -->

  <?php endwhile; else: ?>
  <p><?php _e('No Entries found.'); ?></p>
  <?php endif; ?>
  <p><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></p>

</div> <!-- [contentbody] -->
<?php get_sidebar(); ?>
<div id="breadcrumb"></div>

<?php get_footer(); ?>
