<div id="sidebar">

	<div class="announcements">
	<h2>Coming up...</h2>
	<?php 
	if (function_exists('ec3_get_events2')) {
	ec3_get_events2(
	'100',                 // limit
	'<div class="entry">
		<h3 class="entrytitle"><a rel="bookmark" href="%LINK%" title="%TITLE%">%TITLE%</a></h3>
		<div class="entrybody">
			<div class="event_datetime">%DATE%%TIME%</div>
		</div>
	</div>',
	''                    // template_day
	); } // ec3_get_events2
	?>
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
