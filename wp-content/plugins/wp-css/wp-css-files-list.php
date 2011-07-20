<?php
/*
Copyright (C) 2008 Halmat Ferello

Released under the GPL v.2, http://www.gnu.org/copyleft/gpl.html

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

function wp_css_files_display() {
    global $post;
	
	?>
	<style type="text/css" media="screen">
		div#wp-css {
			position: relative;
				margin-bottom: 12px;
				padding: 12px;
		}
		div#wp-css h4 {
			font-size: 14px;
		}
		div#wp-css form {
		}
		div#wp-css legend {
			font-size: 14px;
			font-weight: bold;
		}
		div#wp-css label {
			display: block;
			float: left;
			font-size: 12px;
			width: 80px;
		}
		div.wp_css_panel {
			border: 1px solid #999;
			font-size: 12px;
			float: left;
			padding: 12px;
			overflow-y: scroll;
			top: 22px; right: 22px;
			width: 310px; height: 350px;
		}
		div#wp_css_files_added_panel {
			float: right;
		}
		div#wp_css_files_panel {
		}
		div.wp_css_panel h4 {
			font-size: 12px;
			margin-top: 0;
		}
		div.wp_css_panel ul {
			padding: 0 0 0 14px; margin: 0;
		}
		div.wp_css_panel strong {
			display: block;
		}
		div#wp_css_files_list ul, div#wp_css_course_dates_list ul {
			list-style-type: none;
			margin: 0; padding: 0;
		}
		div#wp_css_files_list ul ul {
			padding-left: 15px;
		}
		div#wp_css_files_list ul ul li {
			margin: 0; padding: 0;
		}
		div#wp_css_files_list a, div#wp_css_course_dates_list a {
			padding: 8px 0 8px 20px;
			display: block;
			text-decoration: none;
		}
		div#wp_css_files_list a.add-file, div#wp_css_course_dates_list a {
			background: url('<?php echo WP_JS_URL; ?>/images/js-file.png') no-repeat center left; 
		}
		div#wp_css_files_list a.add-file:hover {
			background: url('<?php echo WP_JS_URL; ?>/images/add.png') no-repeat center left;
			color: #1CCD00;
		}
		 div#wp_css_course_dates_list a:hover {
			background: url('<?php echo WP_JS_URL; ?>/images/delete.png') no-repeat center left;
			color: #f00;
		}
		
		div#wp_css_files_list a.folder {
			background: url('<?php echo WP_JS_URL; ?>/images/folder.png') no-repeat center left;
			padding: 0;
		}
		div#wp_css_files_list a.folder span.sign {
			padding: 0 12px 0 6px;
		}
		
		div#wp_css_loading {
			background: #fff;
			display: block;
			position: absolute;
			padding: 12px 12px 12px 12px;
			border: 1px solid #ccc;
			width: 310px; height: 352px;
			text-align: center;
			z-index: 99;
		}
		.spinner, div#wp_css_loading span {
			background: url('<?php echo WP_JS_URL; ?>/images/spinner.gif') no-repeat center left;
			padding-left: 20px;
		}
		div#wp_css_loading span {
			display: block;
			font-size: 18px;
			font-weight: bold;
			margin: 150px auto 0px auto;
			width: 210px;
		}
		div.wp_css_loading_remove {
			left: 362px !important
		}
		div.wp_css_loading_remove span {
			width: 240px !important
		}
		p#wp_css_apply_to_children span {
			padding-top: 2px; padding-bottom: 2px;
			margin-left: 8px;
		}
		
	</style>
	<div id="wp-css" class="postbox closed">
	<h3>WP CSS</h3>
	<div class="inside">
		
    <h4>Add a CSS file to this <?php echo $post->post_type; ?></h4>
	<p>Theme path: /wp-content/themes/<?php echo get_stylesheet(); ?>/</p>
		
      	<div id="wp_css_files_panel" class="wp_css_panel">
		<h4>CSS files in your theme</h4>
		<div><?php wp_css_files($post->ID, FALSE); ?></div>
	</div>
	
	<div id="wp_css_files_added_panel" class="wp_css_panel">
		<h4>CSS files added</h4>
		<div><?php wp_css_files($post->ID); ?></div>
	</div>

	<script type="text/javascript" charset="utf-8">
	
		var wp_css = {};
		
		jQuery('#wp_css_files_panel').before('<div id="wp_css_loading"></div>');
		jQuery('#wp_css_loading').hide();
		
		wp_css.add = function (a) {
			
			jQuery.ajax({
				url: a.href+'&ajax=true&action=add',
				type: 'GET',
				
				beforeSend: function() {
					jQuery('#wp_css_loading').removeClass('wp_css_loading_remove').html('<span>Adding CSS file</span>').fadeIn();
				},

				complete: function() {
					jQuery('#wp_css_loading').fadeOut();
				},

				success: function(txt) {
					jQuery('#wp_css_files_added_panel div').html(txt);
					jQuery(a).parent().remove();
				},

				error: function() {
				//called when there is an error
				}
			});
			
			return false;
			
		};
		
		wp_css.remove = function (a) {
			jQuery.ajax({
				url: a.href+'&ajax=true&action=delete',
				type: 'GET',

				beforeSend: function() {
					jQuery('#wp_css_loading').addClass('wp_css_loading_remove').html('<span>Removing CSS file</span>').fadeIn();
				},

				complete: function() {
					jQuery('#wp_css_loading').fadeOut();
					jQuery('div#wp_css_files_list ul ul').hide();
				},

				success: function(txt) {
					jQuery('#wp_css_files_panel div').html(txt);
					jQuery(a).parent().remove();
				},

				error: function() {
				//called when there is an error
				}
			});
		}
		
		jQuery('div#wp_css_files_list ul ul').hide();
		
		wp_css.toogleFolderVar = false;
		
		wp_css.toogleFolder = function (a) {
			var ul = jQuery(jQuery(a).next('ul'));
			var span = jQuery(jQuery(a).children('span.sign'));
			if (wp_css.toogleFolderVar == false) {
				ul.show();
				span.html('-');
				wp_css.toogleFolderVar = true;
			} else {
				ul.hide();
				span.html('+');
				wp_css.toogleFolderVar = false;
			}
		}		
		
	</script>
	<br clear="all" />
	</div></div>

	<?php
}

function wp_css_list($id, $array, $folder = NULL, $already_there = NULL)
{
	if (!empty($array) && count($array) > 0) {
	$meta = get_post_meta($id, 'wp_css_file');
?>
	<ul>
		<?php foreach ($array as $key => $value): ?>
			<?php if (is_array($value) && count($value) > 0) : ?>
			<li>
				<a href="javascript:void(0)" onclick="wp_css.toogleFolder(this);" class="folder"><span class="sign">+</span> /<?php echo $key; ?>/</a>
				<?php wp_css_list($id, $value, $key); ?>
			</li>
			<?php elseif ( count($value) > 0 ) : ?>
				<?php $check_value = ($folder) ? '/'.$folder.'/'.$value : $value; ?>
				<?php if ( @array_search($check_value, $meta) === FALSE ) : ?>
					<li>
						<a href="<?php echo WP_CSS_URL; ?>/wp-css-ajax.php?id=<?php echo $id; ?>&amp;file=<?php echo ($folder) ? '/'.$folder.'/' : ''; ?><?php echo urlencode($value); ?>" onclick="wp_css.add(this);return false;" class="add-file"><?php echo $value; ?></a>
					</li>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach ?>
	</ul>
<?php
	}
}

function wp_css_files($id, $meta = TRUE)
{
	if ( $meta == TRUE ) {
		$meta = get_post_meta($id, 'wp_css_file');
		if (!empty($meta) && count($meta) > 0) {
			echo '<div id="wp_css_course_dates_list"><ul>';
			foreach ($meta as $value) {
				$remove_string = 'delete=true&amp;'.'id='.$id.'&amp;string='.$value;
				echo '<li><a href="'.WP_CSS_URL.'/wp-css-ajax.php?'.$remove_string.'" class="remove-file" onclick="wp_css.remove(this);return false;">'.$value.'</a></li>';
			}
			echo '</ul></div>';
		} else {
			echo '<div id="wp_css_files_list">No CSS files.</div>';
		}
	} else {
		$files = wp_css_directory_map(TEMPLATEPATH.'/', '.css$', FALSE);
	?>
		<?php if (count($files) > 0): ?>
			<div id="wp_css_files_list">
				<?php wp_css_list($id, $files); ?>
			</div>
		<?php endif ?>
	
	<?php
	}
}

function wp_css_files_for_post()
{
	global $post;
	
	$array = get_post_meta($post->ID, 'wp_css_file');
	
	if (!empty($array) && count($array) > 0) {
		$string = '';
		$string .= "<!-- WP CSS -->\n";
		
		foreach ($array as $value) {
			if (function_exists('wp_css')) {
				$string .=  '<link rel="stylesheet" href="'.wp_css($value, false).'" type="text/css" media="screen,projection" charset="utf-8" />'."\n";
			} else {
				$string .=  '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/'.$value.'" type="text/css" media="screen,projection" charset="utf-8" />'."\n";
			}
			
		}
		
		$string .= "<!-- WP CSS closes -->\n";
		echo $string;
	}
}

if (wp_css_activation() == 'on' && wp_css_within_posts_activation() == 'on') {
	add_action('wp_head', 'wp_css_files_for_post');
}

add_action('edit_form_advanced', 'wp_css_files_display');
add_action('edit_page_form', 'wp_css_files_display');

?>