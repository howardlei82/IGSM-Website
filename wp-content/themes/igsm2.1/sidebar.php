<div id="sidebar">

	<div class="announcements">
	<h2>Coming up...</h2>
	<?php 
	if (function_exists('ec3_get_events2')) {
	ec3_get_events2(
	'10',                 // limit
	'<div class="event_entry">
		<div class="event_datetime">%DATE%%TIME%</div>
		<h3 class="entrytitle"><a rel="bookmark" href="%LINK%" title="%TITLE%">%TITLE%</a></h3>
	</div>',
	''                    // template_day
	); } // ec3_get_events2
	?>
	</div>

        <div class="signups">
        <h2>Signups</h2>
        <?php query_posts('cat=-196,240,244,242,241,243,246'); ?>
        <?php if (have_posts()) { ?>
                          <?php query_posts('cat=-196,240'); ?>
                          <?php if (have_posts()) { ?>
                                <b>Courses &amp; Training</b>
                          <?php } ?>
                          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <li <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?> id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></li>
                          <?php endwhile; endif; ?>

                          <?php query_posts('cat=-196,244'); ?>
                          <?php if (have_posts()) { ?>
                                <b>English Class</b>
                          <?php } ?>
                          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <li <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?> id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></li>
                          <?php endwhile; endif; ?>

                          <?php query_posts('cat=-196,242'); ?>
                          <?php if (have_posts()) { ?>
                                <b>Outings</b>
                          <?php } ?>
                          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <li <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?> id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></li>
                          <?php endwhile; endif; ?>

                          <?php query_posts('cat=-196,241'); ?>
                          <?php if (have_posts()) { ?>
                                <b>Retreats</b>
                          <?php } ?>
                          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <li <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?> id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></li>
                          <?php endwhile; endif; ?>

                          <?php query_posts('cat=-196,243'); ?>
                          <?php if (have_posts()) { ?>
                                <b>Small Groups</b>
                          <?php } ?>
                          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <li <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?> id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></li>
                          <?php endwhile; endif; ?>

                          <?php query_posts('cat=-196,246'); ?>
                          <?php if (have_posts()) { ?>
                                <b>Orders &amp; Reservations</b>
                          <?php } ?>
                          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <li <?php if (is_page()) echo 'style="margin-bottom: 20px;" ' ?> id="post-<?php the_ID(); ?>"><a title="Article-Link (Permalink)" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('<img class="editpost" alt="Edit" src="' . get_bloginfo('template_directory') . '/images/edit.gif" />', '', ''); ?></li>
                          <?php endwhile; endif; ?>

        <?php } else { ?>
                <?= 'No signups currently.'; ?>
        <?php } ?>
        <?php wp_reset_query();?>
        </div>


	<div class="sb-about">
        <h2>About</h2>
	<?php if(function_exists('iinclude_page')) iinclude_page('sidebar-about-us'); ?>
	</div> <!-- [sb-about] -->

<div id="sidebar1">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>


<h2><?php _e('Categories'); ?></h2>
    <ul>
	    <li><?php wp_list_cats('sort_column=name'); ?></li>
	</ul>

<h2>Feeds</h2>
	<ul id="feed">
		<li><a href="<?php bloginfo('rss2_url'); ?>" rel="nofollow" title="<?php _e('Subscribe to RSS'); ?>"><?php _e('RSS Posts');?></a></li>
		<li><a href="<?php bloginfo('comments_rss2_url'); ?>" rel="nofollow" title="<?php _e('RSS Comments'); ?>"><?php _e('RSS Comments');?></a></li>
	</ul>

<h2><?php _e('Search') ?></h2>

<div id="sidebarsearch">
	<form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
	<input type="text" name="s" id="s" size="18"/>
	<input id="searchsubmit" name="sbutt" type="submit" value="Go" alt="Submit"  />
	</form>
</div> <!-- [sidebarsearch] -->

<h2><?php _e('Recent Posts') ?></h2>
    <ul><?php wp_get_archives('type=postbypost&limit=10'); ?>
	</ul>
<?php endif; ?>
</div> <!-- [sidebar1] -->

<div id="sidebar2">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>


	<h2>Meta</h2>
	<ul>
		<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
	</ul>

<h2><?php  _e('Monthly Archives'); ?></h2>
	<ul><?php wp_get_archives('type=monthly'); ?></ul>

<h2><?php _e('Blogroll'); ?></h2>
    <ul><?php get_links(-1, '<li>', '</li>', ' - '); ?></ul>
<?php endif; ?>
</div> 
<!-- [sidebar2] -->

</div> <!-- [sidebar] -->
