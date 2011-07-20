<?php
/*
Plugin Name: d13slideshow
Plugin URI: http://www.d13design.co.uk/wordpress/d13slideshow/
Description: Add animated slideshows of your featured pages and posts to your templates using &lt;?php d13slideshow(); ?&gt;.
Author: Dave Waller
Version: 2.2.0
Author URI: http://www.d13design.co.uk/
*/

global $post_input;
// IMPORTANT - this plugin includes 2 ways to select featured posts, either by choosing from
// a dropdown list or by manually adding post IDs. If you have lots of posts and pages you need to
// select "manual". Just un-comment the line that defines how you'd like to select posts.
//$post_input = 'manual';
$post_input = 'dropdown';
// ------------------------------------------------------------------------------------------------

// Hook for adding admin menus
add_action('admin_menu', 'd13ss_add_pages');

// Hook for adding options to DB
add_option('d13ss_width', 640);
add_option('d13ss_height', 480);
add_option('d13ss_forceSize', 'full');
add_option('d13ss_fadeTo', '#000000');
add_option('d13ss_transLength', 1);
add_option('d13ss_slideHalt', 4);
add_option('d13ss_linkTarget', '_self');
add_option('d13ss_useExcerpt', 0);
add_option('d13ss_exceprtLength', 240);
add_option('d13ss_slideNumbers', 1);
add_option('d13ss_slide0', 0);
add_option('d13ss_slide1', 0);
add_option('d13ss_slide2', 0);
add_option('d13ss_slide3', 0);
add_option('d13ss_slide4', 0);
add_option('d13ss_slide5', 0);
add_option('d13ss_slide6', 0);
add_option('d13ss_slide7', 0);
add_option('d13ss_slide8', 0);
add_option('d13ss_slide9', 0);
add_option('d13ss_animStyle', 'once');
add_option('d13ss_featStyle', 'manual');
add_option('d13ss_featCategory', 0);
add_option('d13ss_numCategory', 5);
add_option('d13ss_titleColor', '#FFFF00');
add_option('d13ss_titleHoverColor', '#FFFFFF');
add_option('d13ss_excerptColor', '#FFFFFF');
add_option('d13ss_excerptLinkColor', '#FF3300');
add_option('d13ss_excerptLinkHoverColor', '#FFFFFF');
add_option('d13ss_panelColor', '#000000');
add_option('d13ss_addCSS', 1);
add_option('d13ss_linkImage', 1);

// action function for above hook
function d13ss_add_pages() {
    // Add a new submenu under Options:
    add_options_page('D13slideshow', 'D13slideshow', 6, 'd13slideshow', 'd13ss_options_page');
}

// d13g_options_page() displays the page content for the Options menu
function d13ss_options_page() { ?>
	<div class="wrap"><a name="settings_top"></a>
		<h2>Manage your D13Slideshow <sub style="font-size:0.7em;">- <a href="#help_main">Help</a></sub></h2> 
		<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		<input type="hidden" name="action" value="update" />
		<table width="100%" cellspacing="2" cellpadding="5" class="form-table"> 
		<tr><th width="33%" scope="row"><h3>Slideshow settings...</h3></th><td>Manage the basic animation settings for your slideshow.</td></tr>
		<tr> 
		<th width="33%" scope="row">Transition length: </th> 
		<td>
		<input type="text" name="d13ss_transLength" value="<?php echo get_option('d13ss_transLength'); ?>" size="10"/> seconds</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Slide pause: </th> 
		<td>
		<input type="text" name="d13ss_slideHalt" value="<?php echo get_option('d13ss_slideHalt'); ?>" size="10"/> seconds</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Link target: </th> 
		<td>
		<select name="d13ss_linkTarget">
			<option value="_self" <?php if(get_option('d13ss_linkTarget')=='_self'){ echo("selected"); } ?>>_self</option>
			<option value="_blank" <?php if(get_option('d13ss_linkTarget')=='_blank'){ echo("selected"); } ?>>_blank</option>
			<option value="_parent" <?php if(get_option('d13ss_linkTarget')=='_parent'){ echo("selected"); } ?>>_parent</option>
			<option value="_top" <?php if(get_option('d13ss_linkTarget')=='_top'){ echo("selected"); } ?>>_top</option>
		</select>
		</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Link image: </th> 
		<td>
		<select name="d13ss_linkImage">
			<option value="1" <?php if(get_option('d13ss_linkImage')=='1'){ echo("selected"); } ?>>yes</option>
			<option value="0" <?php if(get_option('d13ss_linkImage')=='0'){ echo("selected"); } ?>>no</option>
		</select>
		</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Use post exceprt: </th> 
		<td><select name="d13ss_useExcerpt">
			<option value="1" <?php if(get_option('d13ss_useExcerpt')=='1'){ echo("selected"); } ?>>yes (if available)</option>
			<option value="0" <?php if(get_option('d13ss_useExcerpt')=='0'){ echo("selected"); } ?>>no (post content will be trimmed)</option>
		</select></td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Excerpt length: </th> 
		<td>
		<input type="text" name="d13ss_exceprtLength" value="<?php echo get_option('d13ss_exceprtLength'); ?>" size="5"/> characters (only applied when trimming post content)</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Show slide numbers: </th> 
		<td>
		<select name="d13ss_slideNumbers">
			<option value="1" <?php if(get_option('d13ss_slideNumbers')=='1'){ echo("selected"); } ?>>yes</option>
			<option value="0" <?php if(get_option('d13ss_slideNumbers')=='0'){ echo("selected"); } ?>>no</option>
		</select></td> 
		</tr>
		<tr><th width="33%" scope="row"><h3>Slideshow styles...</h3></th><td>Customise the size and look of your slideshow.</td></tr>
		<tr> 
		<th width="33%" scope="row">Slideshow width: </th> 
		<td>
		<input type="text" name="d13ss_width" value="<?php echo get_option('d13ss_width'); ?>" size="10"/> px</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Slideshow height: </th> 
		<td>
		<input type="text" name="d13ss_height" value="<?php echo get_option('d13ss_height'); ?>" size="10"/> px</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Image size to use: </th> 
		<td>
		<select name="d13ss_forceSize">
			<option value="full" <?php if(get_option('d13ss_forceSize')=='full'){ echo("selected"); } ?>>fullsize (uses the image you uploaded)</option>
			<option value="medium" <?php if(get_option('d13ss_forceSize')=='medium'){ echo("selected"); } ?>>medium (currently set to <?php echo get_option('medium_size_w'); ?> x <?php echo get_option('medium_size_h'); ?>)</option>
			<option value="thumb" <?php if(get_option('d13ss_forceSize')=='thumb'){ echo("selected"); } ?>>thumbnail (currently set to <?php echo get_option('thumbnail_size_w'); ?> x <?php echo get_option('thumbnail_size_h'); ?>)</option>
		</select> (when using images added directly through Wordpress)</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Add slideshow CSS: </th> 
		<td>
		<select name="d13ss_addCSS">
			<option value="1" <?php if(get_option('d13ss_addCSS')=='1'){ echo("selected"); } ?>>yes (the plugin will add CSS)</option>
			<option value="0" <?php if(get_option('d13ss_addCSS')=='0'){ echo("selected"); } ?>>no (you must add CSS to your theme)</option>
		</select></td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Fade to: </th> 
		<td>
		<input type="text" name="d13ss_fadeTo" value="<?php echo get_option('d13ss_fadeTo'); ?>" size="10"/> (hex color starting with #)</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Panel color: </th> 
		<td>
		<input type="text" name="d13ss_panelColor" value="<?php echo get_option('d13ss_panelColor'); ?>" size="10"/> (hex color starting with #)</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Excerpt title color: </th> 
		<td>
		<input type="text" name="d13ss_titleColor" value="<?php echo get_option('d13ss_titleColor'); ?>" size="10"/> (hex color starting with #)</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Excerpt title hover color: </th> 
		<td>
		<input type="text" name="d13ss_titleHoverColor" value="<?php echo get_option('d13ss_titleHoverColor'); ?>" size="10"/> (hex color starting with #)</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Excerpt color: </th> 
		<td>
		<input type="text" name="d13ss_excerptColor" value="<?php echo get_option('d13ss_excerptColor'); ?>" size="10"/> (hex color starting with #)</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Excerpt link color: </th> 
		<td>
		<input type="text" name="d13ss_excerptLinkColor" value="<?php echo get_option('d13ss_excerptLinkColor'); ?>" size="10"/> (hex color starting with #)</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Excerpt link hover color: </th> 
		<td>
		<input type="text" name="d13ss_excerptLinkHoverColor" value="<?php echo get_option('d13ss_excerptLinkHoverColor'); ?>" size="10"/> (hex color starting with #)</td> 
		</tr>
		<tr> 
		<th width="33%" scope="row">Animation style: </th> 
		<td>
		<select name="d13ss_animStyle">
			<option value="loop" <?php if(get_option('d13ss_animStyle')=='loop'){ echo("selected"); } ?>>loop continuously</option>
			<option value="once" <?php if(get_option('d13ss_animStyle')=='once'){ echo("selected"); } ?>>play once (return to first slide)</option>
			<option value="oncelast" <?php if(get_option('d13ss_animStyle')=='oncelast'){ echo("selected"); } ?>>play once (pause on last slide)</option>
			<option value="static" <?php if(get_option('d13ss_animStyle')=='static'){ echo("selected"); } ?>>do not animate - manual navigation</option>
		</select></td> 
		</tr>
		<tr><th width="33%" scope="row"><h3>Feature selection...</h3></th><td>Decide how to choose posts to include in your slideshow.</td></tr>
		<tr> 
		<th width="33%" scope="row">Which posts to feature: </th> 
		<td>
		<select name="d13ss_featStyle">
			<option value="sticky" <?php if(get_option('d13ss_featStyle')=='sticky'){ echo("selected"); } ?>>use sticky posts</option>
			<option value="category" <?php if(get_option('d13ss_featStyle')=='category'){ echo("selected"); } ?>>feature by category (see below)</option>
			<option value="manual" <?php if(get_option('d13ss_featStyle')=='manual'){ echo("selected"); } ?>>manually select posts (see below)</option>
			<option value="5" <?php if(get_option('d13ss_featStyle')=='5'){ echo("selected"); } ?>>5 most recent posts</option>
			<option value="10" <?php if(get_option('d13ss_featStyle')=='10'){ echo("selected"); } ?>>10 most recent posts</option>
		</select></td> 
		</tr>
		<tr><th width="33%" scope="row"><h3>Choosing posts by category...</h3></th><td>If you're featuring by category, set up your category here.</td></tr>
		<tr>
		<th width="33%" scope="row">Category to feature:</th>
		<td>
			<?php 
			$categoryargs = array(
			'show_option_none' => 'Select Category',
			'show_count' => '1',
			'orderby' => 'name',
			'name' => 'd13ss_featCategory',
			'selected' => get_option('d13ss_featCategory')
			);
			wp_dropdown_categories($categoryargs);
			?>
			Posts: <select name="d13ss_numCategory">
				<option value="5" <?php if(get_option('d13ss_numCategory')=='5'){ echo("selected"); } ?>>5 most recent</option>
				<option value="10" <?php if(get_option('d13ss_numCategory')=='10'){ echo("selected"); } ?>>10 most recent</option>
				</select>
		</td>
		</tr>
		<tr><th width="33%" scope="row"><h3>Choosing posts manually...</h3></th><td>If you're choosing posts manually, choose them here.</td></tr>
		<!-- -->
		<?php //if(get_option('d13ss_featStyle')=='manual'){
			global $post_input;
			if($post_input == 'manual'){
				for($a=1;$a<11;$a++){ ?>
					<tr> 
					<th width="33%" scope="row">Featured story #<?php echo($a); ?>: </th> 
					<td><?php $temp = get_option('d13ss_slide'.($a-1)); ?>
					<input type="text" name="d13ss_slide<?php echo($a-1); ?>" size="10" value="<?php echo $temp; ?>" />
					</td> 
					</tr>
				<?php }
			}else{
				$pages = get_pages();
				$myposts = get_posts('numberposts=-1');
				for($a=1;$a<11;$a++){ ?>
					<tr> 
					<th width="33%" scope="row">Featured story #<?php echo($a); ?>: </th> 
					<td><?php $temp = get_option('d13ss_slide'.($a-1)); ?>
					<select name="d13ss_slide<?php echo($a-1); ?>">
						<option value="0" <?php if(get_option('d13ss_slide0')==0){ echo("selected"); } ?>>No story</option>
						<?php
						global $page;
						foreach($pages as $page) : ?>
							<option value="<?php echo($page->ID); ?>" <?php if($page->ID==$temp){ echo("selected"); } ?>>Page : <?php echo($page->post_title); ?></option>
						<?php
						endforeach;
						//---
						global $post;
						foreach($myposts as $post) :
						setup_postdata($post); ?>
							<option value="<?php echo(the_ID()); ?>" <?php if($post->ID==$temp){ echo("selected"); } ?>><?php the_ID(); ?>: <?php the_title(); ?></option>
						<?php endforeach; ?>
					</select>
					</td> 
					</tr>
				<?php }
				}
			//} ?>
		<!-- -->
		</table>
		<input type="hidden" name="page_options" value="d13ss_forceSize,d13ss_width,d13ss_height,d13ss_fadeTo,d13ss_transLength,d13ss_slideHalt,d13ss_linkTarget,d13ss_exceprtLength,d13ss_slideNumbers,d13ss_slide0,d13ss_slide1,d13ss_slide2,d13ss_slide3,d13ss_slide4,d13ss_slide5,d13ss_slide6,d13ss_slide7,d13ss_slide8,d13ss_slide9,d13ss_animStyle,d13ss_featStyle,d13ss_useExcerpt,d13ss_titleColor,d13ss_titleHoverColor,d13ss_excerptColor,d13ss_excerptLinkColor,d13ss_excerptLinkHoverColor,d13ss_featCategory,d13ss_numCategory,d13ss_panelColor,d13ss_addCSS,d13ss_linkImage" />
		<p class="submit">
			<input type="submit" name="Submit" value="<?php _e('Update Options &raquo;') ?>" />
		</p>
		</form>
	</div>
	<a href="http://www.woothemes.com/amember/go.php?r=7940&i=b11"><img src="http://www.woothemes.com/ads/woothemes-468x60-2.gif" border=0 alt="WooThemes - Finally a themes club that is here to stay" width=468 height=60></a>
	<div class="wrap"><a name="help_main"></a>
		<h2>Using D13Slideshow</h2>
		<p>D13Slideshow is a Wordpress plugin that will create an animated promo slideshow as part of your blog. You can use it to promote any pages or posts in your site and it is fully customisable through the admin pages of your blog. Unlike some other slideshow components, D13Slideshow makes use of the script.aculo.us and Prototype JavaScript frameworks.</p>
		<p>Once added, your slideshow will animate through each of your chosen features providing an image, an extract and a link. Once all featured stories have been shown, the slideshow will pause and provide 'next' and 'back' buttons allowing visitors to cycle through them.</p>
		<h3>Contents</h3>
		<ol style="list-style-type:decimal; margin-left:50px;">
			<li><a href="#help_section_1">Installing the plugin</a></li>
			<li><a href="#help_section_2">Adding a slideshow to your theme</a></li>
			<li><a href="#help_section_3">Modifying your settings</a></li>
			<li><a href="#help_section_4">Adding custom fields to posts</a></li>
			<li><a href="#help_section_5">Styling your slideshow</a></li>
		</ol>
		
		<h3>Installing the plugin</h3><a name="help_section_1"></a>
		<p>Installing the D13Slideshow plugin is quick and simple:</p>
		<ol style="list-style-type:decimal; margin-left:50px;">
			<li>Begin by downloading the plugin file (ZIP)</li>
			<li>Extract the files to your local machine</li>
			<li>Edit lines 15 and 16 of "d13slideshow.php" to determine how posts will be selected - IMPORTANT</li>
			<li>Upload the whole d13slideshow folder (including the folder itself) to your plugins directory - typically http://www.yourblog.com/wp-content/plugins/</li>
			<li>Activate the plugin using your Wordpress admin pages</li>
			<li>Familiarise yourself with the documentation under 'settings &gt; d13slideshow'</li>
			<li>Add the slideshow code to your theme</li>
		</ol>
		
		<h3>Adding a slideshow to your theme</h3><a name="help_section_2"></a>
		<p>Adding slideshows to your themes is incredibly easy and just requires one line of PHP code. You can introduce your slideshow as part of any of your theme files using the following code:</p>
		<pre>&lt;?php d13slideshow(); ?&gt;</pre>
		<p>You can add a slideshow to your home page by adding the code to "index.php" within your theme, or in your sidebar by editing "sidebar.php".</p>
		<p>You can extend how slideshows are embedded if you want to pass a list of posts directly to the slideshow from php. You can do this by using the following code:</p>
		<pre>&lt;?php d13slideshow( array(1,7,31,52) ); ?&gt;</pre>
		<p>In this example the slideshow would feature the posts (or pages) with IDs of 1, 7, 31 and 52.</p>
		
		<h3>Modifying your settings</h3><a name="help_section_3"></a>
		<p>The D13Slideshow options screen lets you customise almost every aspect of your slideshow. You can access this through your Wordpress admin screens under 'settings &gt; d13slideshow'.</p>
		
		<h4>Slideshow settings</h4>
		<p>These options allow you to customise how your slideshow works.</p>
		<ul>
			<li><strong>Transition length</strong> The length, in seconds, of the animated fade effect.</li>
			<li><strong>Slide pause</strong> The amount of time, in seconds, to wait before fading into the next slide.</li>
			<li><strong>Link target</strong> The window in which to launch any slideshow links.</li>
			<li><strong>Link image</strong> Decide whether your slideshow images should act as links.</li>
			<li><strong>Use post excerpt</strong> Decide whether to use your post excerpts or trim the main post content.</li>
			<li><strong>Excerpt length</strong> The number of characters to trim post content to.</li>
			<li><strong>Show slide numbers</strong> Add a counter before each slide title - "X/Y Slide title".</li>
		</ul>
		<h4>Slideshow styles</h4>
		<p>These options allow you to customise how your slideshow looks.</p>
		<ul>
			<li><strong>Slideshow width</strong> The width, in pixels, of your slideshows.</li>
			<li><strong>Slideshow height</strong> The height, in pixels, of your slideshows.</li>
			<li><strong>Image size to use</strong> Which image to use (only applies when using images added directly into Wordpress posts).</li>
			<li><strong>Add slideshow CSS</strong> Whether the plugin should automatically style the slideshow or let your <a href="#help_section_5">theme handle all styling</a>.</li>
			<li><strong>Fade to</strong> The <a href="http://www.w3schools.com/Html/html_colors.asp" target="_blank">hex color</a> to fade to when animating slide transitions.</li>
			<li><strong>Panel color</strong> The <a href="http://www.w3schools.com/Html/html_colors.asp" target="_blank">hex color</a> to use as a background for the excerpt panel and navigation buttons.</li>
			<li><strong>Excerpt title color</strong> The <a href="http://www.w3schools.com/Html/html_colors.asp" target="_blank">hex color</a> to use for slide titles.</li>
			<li><strong>Excerpt title hover color</strong> The <a href="http://www.w3schools.com/Html/html_colors.asp" target="_blank">hex color</a> to use for slide title roll-overs.</li>
			<li><strong>Excerpt color</strong> The <a href="http://www.w3schools.com/Html/html_colors.asp" target="_blank">hex color</a> to use for excerpts</li>
			<li><strong>Excerpt link color</strong> The <a href="http://www.w3schools.com/Html/html_colors.asp" target="_blank">hex color</a> to use for links within excerpts.</li>
			<li><strong>Excerpt link hover color</strong> The <a href="http://www.w3schools.com/Html/html_colors.asp" target="_blank">hex color</a> to use for link roll-overs within excerpts.</li>
			<li><strong>Animation style</strong> Decide how your slideshow should animate - once, manually or continuously.</li>
		</ul>
		<h4>Feature selection</h4>
		<p>This option allows you to choose how the plugin selects posts to feature in your slideshow.</p>
		<ul>
			<li><strong>Use sticky posts</strong> features any posts marked as sticky.</li>
			<li><strong>Feature by category</strong> displays recent posts from a chosen category.</li>
			<li><strong>Manually select posts</strong> allows you to choose specific posts to feature.</li>
			<li><strong>5 most recent posts</strong> features the 5 most recent posts from anywhere on your blog.</li>
			<li><strong>10 most recent posts</strong> features the 10 most recent posts from anywhere on your blog.</li>
		</ul>
		<h4>Choosing posts by category</h4>
		<p>If you've selected to feature posts from a specific category, these options allow you to choose a category and set the number of posts to feature.</p>
		<h4>Choosing posts manually</h4>
		<p>If you're choosing posts manually, then these options allow you to specify up to 10 posts to feature in your slideshow. Depending on your settings (on lines 15 and 16 of d13slideshow.php) this is done using dropdown lists or text entry boxes for post IDs.</p>

		<h3>Adding custom fields to posts</h3><a name="help_section_4"></a>
		<p>Using <a href="http://codex.wordpress.org/Using_Custom_Fields" target="_blank">custom fields</a> within your posts it's easy to decide which images and links to use within your featured slideshow. The d13slideshow plugin makes use of two different custom fields:</p>
		<ul>
			<li><strong>promoimage</strong> the full URL for the image to use in the slideshow. If this is omitted, a failsafe image is used which can be found in the d13slideshow plugin folder.</li>
			<li><strong>promourl</strong> the link to use when visitors click on a featured story. This is an optional field which, if omitted, falls back to use the post permalink.</li>
		</ul>
		<p>If you're using images in your posts and you'd rather use the first these for your featured slideshow then the plugin can automatically detect your images and use the first one for the feature - just leave the promoimage custom field blank, or remove it alltogether.</p>
		<img style="padding:5px; background-color:#FF; border:1px solid #666;" src="<?php echo get_bloginfo('wpurl').'/'. basename(WP_CONTENT_DIR); ?>/plugins/d13slideshow/help-custom_fields.gif" />
		
		<h3>Styling your slideshow</h3><a name="help_section_5"></a>
		<p>As of version 2.0.0 you have the option to control the styling of your slideshows yourself. You can do this by setting "add slideshow CSS" to no, in your settings. This then uses any styles in your theme to define how your slideshows will look.</p>
		<p>To help get you started, here's how the plugin automatically adds styles, use these to form the basis of your own d13slideshow CSS.</p>
		
		<pre style="border:1px solid #333; padding:3px; background-color:#FFF; width:680px; overflow:auto;">&lt;style type="text/css"&gt;
	#d13slideshow{
		background-color:#000000;
		width:(WIDTH)px;
		height:(HEIGHT)px;
		margin:0px; padding:0px; }
	#d13nav{ margin:0px; padding:0px; }
	#navleft{
		z-index:200;
		position:absolute;
		width:15px;
		height:(HEIGHT-70)px;
		margin:0px; padding:0px; }
	#navright{
		z-index:201;
		position:absolute;
		width:15px;
		height:(HEIGHT-70)px;
		margin:0px; padding:0px;
		margin-left:(WIDTH-15)px; }
	#navleft a,
	#navright a{
		width:15px;
		height:(HEIGHT-70)px;
		display:block;
		background-color:#000000;
		filter:alpha(opacity=30);-moz-opacity:.3;opacity:.3;-khtml-opacity: 0.3;
		background-position:center center;
		background-repeat:no-repeat; }
	#navleft a{ background-image:url(left.gif); }
	#navright a{ background-image:url(right.gif);  }
	#navleft a:hover{ filter:alpha(opacity=60);-moz-opacity:.6;opacity:.6;-khtml-opacity: 0.6; }
	#navright a:hover{ filter:alpha(opacity=60);-moz-opacity:.6;opacity:.6;-khtml-opacity: 0.6; }
	#navleft a span,
	#navright a span{ display:none; }
	div.d13slide{
		padding:0px;
		margin:0px; }
	div.d13slide img{
		padding:0px;
		margin:0px; }
	div.d13fader{
		background-color:#000000;
		font-family:Arial, Helvetica, sans-serif;
		filter:alpha(opacity=60);-moz-opacity:.6;opacity:.6;-khtml-opacity: 0.6;
		height:70px;
		z-index:1;
		margin:-70px 0px 0px 0px;
		padding:0px; }
	div.d13fader h3{
		font-size:12px;
		font-weight:bold;
		padding:4px;
		margin:0px; }
	div.d13fader h3 a{ color:#FFFFFF; }
	div.d13fader h3 a:hover{ color:#FFFFFF; }
	div.d13fader p{
		font-size:10px;
		font-weight:normal;
		padding:2px 4px 4px 4px;
		margin:0px;
		color:#CCCCCC; }
	div.d13fader p a{
		color:#CCCCCC; }
	div.d13fader p a:hover{
		color:#FFFFFF; }
&lt;/style&gt;</pre>
		
		<p><a href="#help_main">back to contents</a> | <a href="#settings_top">back to top</a></p>
		<p>&nbsp;</p>
	</div>
<?php }

//Core functions - do not edit below this point...
function d13slideshow($d13ss_postlist = null){
	//get the featured posts...
	$d13ss_contents = array();
	if($d13ss_postlist){ // if a list is passed as an argument...
		$d13ss_contents = $d13ss_postlist;
	}else if(get_option('d13ss_featStyle')=='manual'){ // if manually chosen...
		for($a=0;$a<10;$a++){
			if(get_option('d13ss_slide'.$a)!=0){
				$d13ss_contents[] = get_option('d13ss_slide'.$a);
			}
		}
	}else if(get_option('d13ss_featStyle')=='category'){ // if using a category...
		$args = array(
			'category' => get_option('d13ss_featCategory'),
			'numberposts' => get_option('d13ss_numCategory'),
			'orderby' => 'date',
			'order' => 'DESC'
		);
		$lastposts = get_posts($args);
		foreach($lastposts as $d13ss_temppost){
    		setup_postdata($d13ss_temppost);
			$d13ss_contents[] = $d13ss_temppost->ID;
		}
	}else if(get_option('d13ss_featStyle')=='sticky'){ // if using sticky posts...
		$sticky=get_option('sticky_posts');
		foreach($sticky as $stickypost){
			query_posts('p=' . $stickypost); global $more; $more=0;
			if (have_posts()) :
				while (have_posts()) : the_post();
					$d13ss_contents[] = get_the_ID();
				endwhile;
			endif;
		}
	}else{ // if automatically generated...
		$args = array(
			'numberposts' => get_option('d13ss_featStyle'),
			'orderby' => 'date',
			'order' => 'DESC'
		); 
		$lastposts = get_posts($args);
		foreach($lastposts as $d13ss_temppost){
    		setup_postdata($d13ss_temppost);
			$d13ss_contents[] = $d13ss_temppost->ID;
		}
	}
	// Output slideshow HTML...
	$workdir = get_bloginfo('wpurl') . "/" . basename(WP_CONTENT_DIR) . "/plugins/d13slideshow";
	?>
	<div id="d13slideshow">
		<div id="d13nav" style="display:none;">
			<div id="navleft"><a onclick="showPrev()" title="View previous article"><span>&lt;</span></a></div>
			<div id="navright"><a onclick="showNext()" title="View next article"><span>&gt;</span></a></div>
		</div>
		<?php
		for($a=0;$a<count($d13ss_contents);$a++){
			//Get the image...
			
			//First, check the post for a custom field...
			$d13ss_postdata = get_post(/*$dummyid = */$d13ss_contents[$a]);
			$d13ss_promoimage = get_post_custom_values('promoimage', $d13ss_postdata -> ID);
			//print_r('tried CF, ');
			
			//If no custom field is found, check for the first WP attachement...
			if(!$d13ss_promoimage){
				$images = get_children('post_type=attachment&post_mime_type=image&post_parent=' . $d13ss_postdata -> ID);
				if ($images){
					$keys = array_keys($images);
					$num = $keys[0];
					if(get_option('d13ss_forceSize')=='full'){
						$firstImageSrc = wp_get_attachment_url($num);
					}
					if(get_option('d13ss_forceSize')=='medium'){
						$medium_array = image_downsize( $num, 'medium' );
 						  $firstImageSrc = $medium_array[0];
					}
					if(get_option('d13ss_forceSize')=='thumb'){
						$firstImageSrc = wp_get_attachment_thumb_url($num);
					}
					$d13ss_promoimage = array($firstImageSrc);
				}
				//print_r('tried ATTACHMENT, ');
			}
			
			//Right, let's try to find the first image in the HTML content...
			if(!$d13ss_promoimage) {
				preg_match( '/<img[^>]+src=[\'"]([^\'"]+)[\'"]/', $d13ss_postdata -> post_content, $matches );
				$d13ss_promoimage = array($matches[1]);
				//print_r('tried HTML SCAN, ');
			}

			//Finally, use the failsafe image as NO image could be found...
			if(!$d13ss_promoimage || $d13ss_promoimage[0]==''){
				$d13ss_promoimage = array($workdir.'/failsafe.gif');
				//print_r('using FAILSAFE.');
			}
			
			$d13ss_promourl = get_post_custom_values('promourl', $d13ss_postdata -> ID);
			$maximgwidth = get_option('d13ss_width');
			$maximgheight = get_option('d13ss_height');
			$actualimgsize = getimagesize($d13ss_promoimage[0]);
			$actualimgwidth = $actualimgsize[0];
			$actualimgheight = $actualimgsize[1];
			
			$variation = 0;
			if($actualimgwidth > $maximgwidth && $actualimgheight > $maximgheight){
				//both too big...
				if($actualimgheight > $actualimgwidth){
					//height is the largest...
					$newimgheight = $maximgheight;
					$transform = $maximgheight/$actualimgheight;
					$newimgwidth = round($actualimgwidth*$transform);
					$variation = 1;
				}
				if($actualimgwidth > $actualimgheight){
					//width is the largest...
					$newimgwidth = $maximgwidth;
					$transform = $maximgwidth/$actualimgwidth;
					$newimgheight = round($actualimgheight*$transform);
					$variation = 2;
				}
			}else if($actualimgwidth <= $maximgwidth && $actualimgheight > $maximgheight){
				//height too big...
				$newimgheight = $maximgheight;
				$transform = $maximgheight/$actualimgheight;
				$newimgwidth = round($actualimgwidth*$transform);
				$variation = 3;
			}else if($actualimgwidth > $maximgwidth && $actualimgheight <= $maximgheight){
				//width too big...
				$newimgwidth = $maximgwidth;
				$transform = $maximgwidth/$actualimgwidth;
				$newimgheight = round($actualimgheight*$transform);
				$variation = 4;
			}else{
				//exactly right or too small...
				$newimgwidth = $actualimgwidth;
				$newimgheight = $actualimgheight;
				$variation = 5;
			}
			$topmargin = ($maximgheight-$newimgheight)/2;
			$sidemargin = ($maximgwidth-$newimgwidth)/2;
			?>
			<div id="d<?php echo($a); ?>" class="d13slide" style="display:none;">
				<?php if($d13ss_promourl){
					$d13ssurl = $d13ss_promourl[0];
				}else{
					$d13ssurl = get_permalink($d13ss_postdata -> ID);
				} ?>
				<?php if(get_option('d13ss_linkImage')=='1'){ ?>
					<a href="<?php echo $d13ssurl; ?>" title="Read more about <?php echo($d13ss_postdata -> post_title); ?>" target="<?php echo(get_option('d13ss_linkTarget')); ?>">
				<?php } ?>
				<img src="<?php echo($d13ss_promoimage[0]); ?>" alt="<?php echo($d13ss_postdata -> post_title); ?>" width="<?php echo $newimgwidth; ?>" height="<?php echo $newimgheight; ?>" style="margin:<?php echo $topmargin; ?>px <?php echo $sidemargin; ?>px <?php echo $topmargin; ?>px <?php echo $sidemargin; ?>px;" />
				<?php if(get_option('d13ss_linkImage')=='1'){ ?>
					</a>
				<?php } ?>
				<div class="d13fader">
					<h3>
						<a href="<?php echo $d13ssurl; ?>" title="Read more about <?php echo($d13ss_postdata -> post_title); ?>" target="<?php echo(get_option('d13ss_linkTarget')); ?>">
							<?php if(get_option('d13ss_slideNumbers')==1){ ?>
								<?php echo(($a+1).'/'.count($d13ss_contents).' '); echo($d13ss_postdata -> post_title); ?>
							<?php }else{ ?>
								<?php echo($d13ss_postdata -> post_title); ?>
							<?php } ?>
						</a>
					</h3>
					<p>
						<?php if(get_option('d13ss_useExcerpt')==1 && $d13ss_postdata -> post_excerpt){ // Use post excerpt...
							echo $d13ss_postdata -> post_excerpt;
							?> [ <a href="<?php echo $d13ssurl; ?>" title="Read more about <?php echo $d13ss_postdata -> post_title; ?>" target="<?php echo get_option('d13ss_linkTarget'); ?>">...</a> ]<?php
						}else{ // Trim post content...
							$d13ss_ex = strip_tags($d13ss_postdata -> post_content);
							$d13ss_ex = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $d13ss_ex );
							if(strlen($d13ss_ex)>get_option('d13ss_exceprtLength')){ ?>
								<?php echo substr($d13ss_ex,0,get_option('d13ss_exceprtLength')); ?> [ <a href="<?php echo $d13ssurl; ?>" title="Read more about <?php echo $d13ss_postdata -> post_title; ?>" target="<?php echo get_option('d13ss_linkTarget'); ?>">...</a> ]
							<?php }else{
								echo $d13ss_ex;
							}
						} ?>
					</p>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	// Output slideshow IE CSS fix...
	?>
	<!--[if IE]>
	<style type="text/css">div.d13fader{ margin:-72px 0px 0px 0px; }</style>
	<![endif]-->
	<?php
	// Output slideshow Javascript...
	?>
	<script type="text/javascript" language="javascript" charset="utf-8">
		// <![CDATA[
		currentSlide = 0;
		function startTimeline() {
			<?php
			if(get_option('d13ss_animStyle')!='static'){
				for($a=0;$a<count($d13ss_contents);$a++){
				?>
					new Effect.Appear('d<?php echo($a); ?>', { duration: <?php echo(get_option('d13ss_transLength')); ?>, queue: { position: 'end', scope: 'd13ssscope' } });
					<?php if($a<count($d13ss_contents)-1){ ?>
						new Effect.Fade('d<?php echo($a); ?>', { delay: <?php echo(get_option('d13ss_slideHalt')); ?>, duration: <?php echo(get_option('d13ss_transLength')); ?>, queue: { position: 'end', scope: 'd13ssscope' } });
					<?php }else{
						if(get_option('d13ss_animStyle')=='loop'){ ?>
							new Effect.Fade('d<?php echo($a); ?>', { delay: <?php echo(get_option('d13ss_slideHalt')); ?>, duration: <?php echo(get_option('d13ss_transLength')); ?>, queue: { position: 'end', scope: 'd13ssscope' }, afterFinish: function(){ startTimeline(); } });
						<?php }
					} ?>
				<?php
				}
			}
			?>
			<?php if(get_option('d13ss_animStyle')=='once'){ ?>
				new Effect.Fade('d<?php echo($a-1); ?>', { delay: <?php echo(get_option('d13ss_slideHalt')); ?>, duration: <?php echo(get_option('d13ss_transLength')); ?>, queue: { position: 'end', scope: 'd13ssscope' } });
				new Effect.Appear('d0', { duration: <?php echo(get_option('d13ss_transLength')); ?>, queue: { position: 'end', scope: 'd13ssscope' } });
				new Effect.Appear('d13nav', { delay: 0, duration: 0.1, queue: { position: 'end', scope: 'd13ssscope' }, afterFinish: function() { currentSlide=0; } });
			<?php }
			if(get_option('d13ss_animStyle')=='oncelast'){ ?>
				new Effect.Appear('d13nav', { delay: 0, duration: 0.1, queue: { position: 'end', scope: 'd13ssscope' }, afterFinish: function() { currentSlide=0; } });
			<?php }
			if(get_option('d13ss_animStyle')=='static'){ ?>
				new Effect.Appear('d0', { duration: <?php echo(get_option('d13ss_transLength')); ?>, queue: { position: 'end', scope: 'd13ssscope' } });
				new Effect.Appear('d13nav', { delay: 0, duration: 0.1, queue: { position: 'end', scope: 'd13ssscope' }, afterFinish: function() { currentSlide=0; } });
			<?php } ?>
		}
		function showPrev(){
			new Effect.Fade('d'+currentSlide, { duration: <?php echo(get_option('d13ss_transLength')); ?>, queue: { position: 'end', scope: 'd13ssscope' } });
			currentSlide--;
			if(currentSlide==-1){ currentSlide=<?php echo(count($d13ss_contents)-1); ?>; }
			new Effect.Appear('d'+currentSlide, { duration: <?php echo(get_option('d13ss_transLength')); ?>, queue: { position: 'end', scope: 'd13ssscope' } });
		}
		function showNext(){
			new Effect.Fade('d'+currentSlide, { duration: <?php echo(get_option('d13ss_transLength')); ?>, queue: { position: 'end', scope: 'd13ssscope' } });
			currentSlide++;
			if(currentSlide==<?php echo(count($d13ss_contents)); ?>){ currentSlide=0; }
			new Effect.Appear('d'+currentSlide, { duration: <?php echo(get_option('d13ss_transLength')); ?>, queue: { position: 'end', scope: 'd13ssscope' } });
		}
		
		startTimeline();
		// ]]>
	</script>
	<?php
}

//Add script files to head of HTML
function d13ss_addscript(){
	$workdir = get_bloginfo('wpurl') . "/" . basename(WP_CONTENT_DIR) . "/plugins/d13slideshow";
	$p_path = get_bloginfo('wpurl')."/wp-includes/js/prototype.js";
	$s_path = get_bloginfo('wpurl')."/wp-includes/js/scriptaculous/scriptaculous.js";
	$d13ss_script = "
	<!-- add prototype scripts -->
	<script language=\"JavaScript\" type=\"text/javascript\" src=\"".$p_path."\"></script>
	<!-- add scriptaculous scripts -->
	<script language=\"JavaScript\" type=\"text/javascript\" src=\"".$s_path."\"></script>\n";
	if(get_option('d13ss_addCSS')=='1') $d13ss_script .= "<style type=\"text/css\">
		#d13slideshow{
			background-color:".get_option('d13ss_fadeTo').";
			width:".get_option('d13ss_width')."px;
			height:".get_option('d13ss_height')."px;
			margin:0px; padding:0px; }
		#d13nav{
			margin:0px; padding:0px;
		}
		#navleft{
			z-index:200;
			position:absolute;
			width:15px;
			height:".(get_option('d13ss_height')-70)."px;
			margin:0px; padding:0px; }
		#navright{
			z-index:201;
			position:absolute;
			width:15px;
			height:".(get_option('d13ss_height')-70)."px;
			margin:0px; padding:0px;
			margin-left:".(get_option('d13ss_width')-15)."px; }
		#navleft a,
		#navright a{
			width:15px;
			height:".(get_option('d13ss_height')-70)."px;
			display:block;
			background-color:".get_option('d13ss_panelColor').";
			filter:alpha(opacity=30);-moz-opacity:.3;opacity:.3;-khtml-opacity: 0.3;
			background-position:center center;
			background-repeat:no-repeat; }
		#navleft a{
			background-image:url(".$workdir."/left.gif); }
		#navright a{
			background-image:url(".$workdir."/right.gif);  }
		#navleft a:hover{
			filter:alpha(opacity=60);-moz-opacity:.6;opacity:.6;-khtml-opacity: 0.6; }
		#navright a:hover{
			filter:alpha(opacity=60);-moz-opacity:.6;opacity:.6;-khtml-opacity: 0.6; }
		#navleft a span,
		#navright a span{ display:none; }
		div.d13slide{
			padding:0px;
			margin:0px; }
		div.d13slide img{
			padding:0px;
			margin:0px; }
		div.d13fader{
			background-color:".get_option('d13ss_panelColor').";
			font-family:Arial, Helvetica, sans-serif;
			filter:alpha(opacity=60);-moz-opacity:.6;opacity:.6;-khtml-opacity: 0.6;
			height:70px;
			z-index:1;
			margin:-70px 0px 0px 0px;
			padding:0px; }
		div.d13fader h3{
			font-size:12px;
			font-weight:bold;
			padding:4px;
			margin:0px; }
		div.d13fader h3 a{ color:".get_option('d13ss_titleColor')."; }
		div.d13fader h3 a:hover{ color:".get_option('d13ss_titleHoverColor')."; }
		div.d13fader p{
			font-size:10px;
			font-weight:normal;
			padding:2px 4px 4px 4px;
			margin:0px;
			color:".get_option('d13ss_excerptColor')."; }
		div.d13fader p a{
			color:".get_option('d13ss_excerptLinkColor')."; }
		div.d13fader p a:hover{
			color:".get_option('d13ss_excerptLinkHoverColor')."; }
	</style>";
	echo($d13ss_script);
}

add_action('wp_head', 'd13ss_addscript');
?>