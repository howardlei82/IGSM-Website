<?php
/*
Plugin Name: WP CSS
Plugin URI: http://www.halmatferello.com/lab/wp-css/
Description: Automatically GZIP your CSS files and puts all @imports into one file. Also add CSS files to specific posts/pages.
Author: Halmat Ferello
Author URI: http://www.halmatferello.com
Version: 2.0.5

Copyright (C) 2008 Halmat Ferello

Released under the GPL v.2, http://www.gnu.org/copyleft/gpl.html

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

include_once('wp-css-functions.php');

define('WP_CSS_VERSION', '2.0.5');
define('WP_CSS_URL', get_option('siteurl').'/'.PLUGINDIR.'/wp-css');
define('WP_CSS_PATH', ABSPATH.PLUGINDIR.'/wp-css');
define('WP_CSS_CACHE_PATH', WP_CSS_PATH.'/cache/');

define('TEMPLATEURL', get_theme_root_uri().'/'.get_stylesheet());

if ( !is_dir(WP_CSS_CACHE_PATH) ) @mkdir(WP_CSS_CACHE_PATH);

if (!defined('WP_ADMIN')) {
	wp_css_setting(array(
		'u' => TEMPLATEURL,
		'p' => get_theme_root().'/'.get_stylesheet(),
		'c' => wp_css_cache_time()
		));
}

function wp_css($file, $echo = true)
{
	$dir = explode('/', $file);
	array_shift($dir); // get rid of blank space
	array_pop($dir); // get rid of css file
	
	if (!file_exists(WP_CSS_CACHE_PATH.'wp-css-settings.txt')) {
		$url_array = array(
			'c' => wp_css_cache_time(),
			'd' => implode('/', $dir),
			'u' => TEMPLATEURL,
			'p' => TEMPLATEPATH
		);
	} else {
		$url_array = array(
			'd' => implode('/', $dir),
		);
	}
	
	$wp_css_attributes = wp_css_url($url_array);
	
	if (wp_css_activation() == 'on') {
		$string = get_settings('siteurl') . '/wp-content/plugins/wp-css/wp-css-compress.php?f=' . $file. $wp_css_attributes . '&amp;t='.wp_css_modified_time();
	} else if (wp_css_activation() == 'off') {
		$string = TEMPLATEURL.'/' . $file;
	}	
	
	if ($echo == true) {
		echo $string;
	} else {
		return $string;
	}
}

function wp_css_url($array)
{
	if (count($array) > 0) {
		$string = '';
		foreach ($array as $key => $value) {
			$string .= "&amp;".$key."=".wp_css_encode_string($value);
		}
		return $string;
	} else {
		return FALSE;
	}	
}

function wp_css_replace($a) {
	
	if (!file_exists(WP_CSS_CACHE_PATH.'wp-css-settings.txt')) {
		$url_array = array(
			'c' => wp_css_cache_time(),
			'u' => TEMPLATEURL,
			'p' => TEMPLATEPATH
		);
	}
	
	$wp_css_attributes = wp_css_url($url_array);
		
	if (wp_css_activation() == 'on') {
		$style_path = substr($a, strlen(get_settings('siteurl')));
		$a = get_settings('siteurl') . '/wp-content/plugins/wp-css/wp-css-compress.php?f=style.css'. $wp_css_attributes . '&amp;t='.wp_css_modified_time() ;
	} else if (wp_css_activation() == 'off') {
		$a = TEMPLATEURL.'/style.css';
	}
	
	return $a;
}

function wp_css_cached_file_structure()
{
	$css_files = wp_css_directory_map(WP_CSS_CACHE_PATH);
	if (count($css_files) > 0) {
?>
<p>CSS files cached (/wp-content/themes/<?php echo get_stylesheet(); ?>):</p>
<ul>
		<?php foreach ($css_files as $file): ?>
		<?php
			$file = urldecode($file); 
			$array = unserialize(file_get_contents(WP_CSS_CACHE_PATH.$file));
		?>
			<li>
				<strong><?php echo $array['file'];  ?></strong>
				<?php if (count($array['imports']) > 0): ?>
					<ul>
						<?php foreach ($array['imports'] as $file_within): ?>
							<li>(@import) <?php echo $file_within[1]; ?></li>
						<?php endforeach ?>
					</ul>
				<?php endif ?>
			</li>
		<?php endforeach ?>
</ul>
<?php
	} else {
		echo "<p><strong>No CSS files are cached.</strong></p>";
	}
}

function wp_css_admin()
{	
	if ($_REQUEST['wp_css_clear_cache']) {
		if (wp_css_is_directory_writable(WP_CSS_CACHE_PATH)) {
			wp_css_delete();
		} else {
			$_REQUEST['wp_css_message'] = 'Unable to clear cache.';
		}
	}
	if ($_REQUEST['wp_css_edit_expiry']) {
		wp_css_modified_time(TRUE);
		update_option('wp_css_cache_time', $_REQUEST['wp_css_cache_time']);
	}
	if ($_REQUEST['wp_css_activation']) {
		wp_css_activation(true);
	}
	if ($_REQUEST['wp_css_within_posts_activation']) {
		wp_css_within_posts_activation(true);
	}
	
	$cache_time = wp_css_cache_time();
	?>
	
	<style type="text/css" media="screen">
		fieldset {
			border: 1px solid #aaa;
			padding: 12px;
		}
		fieldset#activate-within-posts, fieldset#expiry-time, fieldset#clear-cache {
			margin-top: 12px;
		}
	</style>
	
	<?php if ($_REQUEST['wp_css_message']) : ?>
		<div id="message" class="updated fade"><p><?php echo $_REQUEST['wp_css_message']; ?></p></div>
	<?php endif; ?>
	
	<div id="wp-css" class="wrap">
		<h2 style="margin: 8px 0; padding-top: 0">WP CSS v<?php echo WP_CSS_VERSION; ?></h2>
		
		<p style="color:#1CCD00;">URLs must be relative to your current theme.<br />For example: <code>wp_css('file.css')</code> = <?php echo TEMPLATEURL; ?>/file.css</p>
		
		<fieldset id="activate"> 
		<legend>Activate</legend>
		<p>Turn the plugin on / off. wp_css() will still work but no caching or compressing is applied.</p>
		<?php
		echo '<form name="wp_css_active" action="'. $_SERVER["REQUEST_URI"] . '" method="post">';
		if (wp_css_activation() == 'on') {
			echo '<label for="wp_expiry_on"><input type="radio" id="wp_expiry_on" name="wp_css_activation" value="on" checked="checked" /> On</label>';
		} else {
			echo '<label for="wp_expiry_on"><input type="radio" id="wp_expiry_on" name="wp_css_activation" value="on" /> On</label>';
		}
		if (wp_css_activation() == 'off') {
			echo ' <label for="wp_expiry_off"><input type="radio" name="wp_css_activation" id="wp_expiry_off" value="off" checked="checked" /> Off</label><br />';
		} else {
			echo ' <label for="wp_expiry_off"><input type="radio" name="wp_css_activation" id="wp_expiry_off" value="off" /> Off</label><br />';
		}
		echo '<div class="submit"><input type="submit" value="Change activation &raquo;" name="wp_css_active" /></div>';
		echo '<input type="hidden" name="wp_css_message" value="Plugin activation changed.">';
		wp_nonce_field('wp-cache');
		echo "</form>\n";
		?></fieldset>
		
		<fieldset id="activate-within-posts">
		<legend>Activate within posts</legend>
		<p>Allows you to add CSS files to specific posts/pages.</p>
		<?php
		echo '<form name="wp_css_within_posts_activation" action="'. $_SERVER["REQUEST_URI"] . '" method="post">';
		if (wp_css_within_posts_activation() == 'on') {
			echo '<label for="wp_css_within_posts_activation_on"><input type="radio" id="wp_css_within_posts_activation_on" name="wp_css_within_posts_activation" value="on" checked="checked" /> On</label>';
		} else {
			echo '<label for="wp_css_within_posts_activation_on"><input type="radio" id="wp_css_within_posts_activation_on" name="wp_css_within_posts_activation" value="on" /> On</label>';
		}
		if (wp_css_within_posts_activation() == 'off') {
			echo ' <label for="wp_css_within_posts_activation_off"><input type="radio" name="wp_css_within_posts_activation" id="wp_css_within_posts_activation_off" value="off" checked="checked" /> Off</label><br />';
		} else {
			echo ' <label for="wp_css_within_posts_activation_off"><input type="radio" name="wp_css_within_posts_activation" id="wp_css_within_posts_activation_off" value="off" /> Off</label><br />';
		}
		echo '<div class="submit"><input type="submit" value="Change activation &raquo;" name="wp_css_active" /></div>';
		echo '<input type="hidden" name="wp_css_message" value="Plugin within posts activation changed.">';
		wp_nonce_field('wp-cache');
		echo "</form>\n";
		?></fieldset>
		
		<fieldset id="expiry-time"> 
		<legend>Expiry Time</legend>
		<p>Set the time for when the browser downloads a fresh copy of your CSS files.</p>
		<?php
		echo '<form name="wp_css_edit_expiry" action="'. $_SERVER["REQUEST_URI"] . '" method="post">';
		echo '<label for="wp_expiry">Expire time:</label> ';
		echo '<input type="text" size="6" name="wp_css_cache_time" value="'.$cache_time.'" /> seconds<br />';
		echo '<div class="submit"><input type="submit" value="Change expiration &raquo;" name="wp_css_edit_expiry" /></div>';
		echo '<input type="hidden" name="wp_css_message" value="Cache expiry changed">';
		wp_nonce_field('wp-cache');
		echo "</form>\n";
		?></fieldset>
		
		<fieldset id="clear-cache"> 
		<legend>Clear cache</legend>

		<?php if (!wp_css_is_directory_writable(WP_CSS_CACHE_PATH)): ?>
			<p style="border: 1px solid #f00; padding: 2px; color: #f00;"><strong>Cache not available</strong><br/>The <code>wp-css</code> folder <strong>is not writable</strong>. Please change the plugin folder permissions to <code>777</code>.</p>
		<?php endif ?>

		<p>Clear your cache if you have updated your CSS files.</p>
		
		<?php wp_css_cached_file_structure(); ?>
		<?php
		echo '<form name="wp_css_clear_cache" action="'. $_SERVER["REQUEST_URI"] . '" method="post">';
		echo '<div class="submit"><input type="submit" value="Clear Cache" name="wp_css_clear_cache" /></div>';
		echo '<input type="hidden" name="wp_css_message" value="Cached cleared">';
		wp_nonce_field('wp-cache');
		echo "</form>\n";
		?></fieldset>
	</div><?php
}

 // Admin Panel   
function wp_css_add_pages()
{
	add_options_page('WP CSS options', 'WP CSS', 8, __FILE__, 'wp_css_admin');            
}


// Add Options Page
add_action('admin_menu', 'wp_css_add_pages');
add_filter('stylesheet_uri', 'wp_css_replace');

if (wp_css_within_posts_activation() == 'on') {
	include_once('wp-css-files-list.php');
}
?>