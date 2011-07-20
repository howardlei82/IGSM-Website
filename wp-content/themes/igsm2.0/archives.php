<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
<div id="contentbody">

  <?php while (have_posts()) : the_post(); ?>
	
	<div class="entry">

		<h3 style="margin-bottom: 5px;" class="entrytitle" id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></h3>

		<div class="entrybody">
			<?php the_content(__('go on reading &raquo;'));?>
		</div> <!-- [entrybody] -->

        <h3>By month:</h3>
	      <ul>
	        <?php wp_get_archives('type=monthly&show_post_count=1'); ?>
          </ul>
			
        <h3>By category:</h3>
	      <ul>
	        <?php wp_list_cats('sort_column=name&optioncount=1&feed=rss'); ?>
	      </ul>
    
	</div> <!-- [entry] -->

  <?php endwhile; ?>

</div> <!-- [contentwrap] -->

<?php get_sidebar(); ?>
<div id="breadcrumb"></div>
<?php get_footer(); ?>
