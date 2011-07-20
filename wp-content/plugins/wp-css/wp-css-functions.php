<?php
/*
Copyright (C) 2008 Halmat Ferello

Released under the GPL v.2, http://www.gnu.org/copyleft/gpl.html

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

global $wp_css;

/* thanks to italianstyle */
if (defined('ABSPATH') && file_exists(ABSPATH . 'wp-includes/pluggable.php')) {
    require_once(ABSPATH . 'wp-includes/pluggable.php');
}

function wp_css_cb($m) {
	global $wp_css;
	
	$string .= $m[1].":";
	if (!empty($m[2])) {
		$string .= " ".$m[2];
	} 
	$string .= " url('".$wp_css['url'].$m[4]."') ".$m[5].";";
	return $string;
}

function wp_css_find_css_imports($string)
{
	preg_match_all("/@import\s+url\([\x27|\x22]?([^\x27|\x22|\)]+)[\x27|\x22]?\);?/", $string, $matches, PREG_SET_ORDER);
	if ( count($matches) > 0 ) return $matches;
	return NULL;
}

function wp_css_fix_urls($buffer) {
	$regex = "/(background|background-image|list-style-image)+:\s*(\#[\d\w]{3,}|transparent)?\s*url\([\x27|\x22]?(\.\.\/){0,}([^\x27|\x22|\)]+)+[\x27|\x22]?\)\s*([^;]*);?/";
			 
	return preg_replace_callback($regex, "wp_css_cb", $buffer);
}
function wp_css_fix_font_face($buffer) {
	$regex = "/(src)+:\s*url\([\x27|\x22]?(\.\.\/){0,}([^\x27|\x22|\)]+)+[\x27|\x22]?\)\s*([^;]*);?/";
			 
	return preg_replace_callback($regex, "wp_css_cb", $buffer);
}

function wp_css_cache_time()
{
	if( ! ($cache_time = get_option('wp_css_cache_time')) && !$_REQUEST['wp_css_edit_expiry'] ) {
		$cache_time = 3600;
		add_option('wp_css_cache_time', $cache_time);
	}
	return $cache_time;
}

function wp_css_modified_time($update = FALSE)
{
	if ($update == TRUE) {
		update_option('wp_css_modified_time', mktime());
	} else if( ! ($modified_time = get_option('wp_css_modified_time'))) {
		$modified_time = mktime();
		add_option('wp_css_modified_time', $modified_time);
	}
	return $modified_time;
}

function wp_css_is_expired($filename)
{
	global $wp_css;
	$filename = wp_css_filename($filename);
	if ( (mktime() - @filemtime(WP_CSS_CACHE_PATH.$filename) >= $wp_css['cache'] )) return TRUE;
	return FALSE;
}

function wp_css_filename($filename, $ext = '.css')
{
	return md5($filename).$ext;
}

function wp_css_create_file($filename, $string, $pre_path = null)
{
	$filename = $pre_path.'cache/'.$filename;
	
	if ( ! $fp = @fopen($filename, 'w+')) return false;

	flock($fp, LOCK_EX);
	fwrite($fp, $string);
	flock($fp, LOCK_UN);
	fclose($fp);

	// change file mode
    chmod($filename, 0755);

	return TRUE;
}

function wp_css_read_file($filename)
{	
	if ( !file_exists($filename) ) return FALSE;
	
	clearstatcache();
	
	if (filesize($filename) > 0) return file_get_contents($filename);
}

function wp_css_setting($array = null)
{
	if ($array)  {
		wp_css_create_file('wp-css-settings.txt', wp_css_encode_string(serialize($array)), ABSPATH.PLUGINDIR.'/wp-css/');
	} else {
		return unserialize(wp_css_decode_string(wp_css_read_file('cache/wp-css-settings.txt')));
	}
}

function wp_css_encode_string($string)
{
	return urlencode(base64_encode($string));
}

function wp_css_decode_string($string)
{
	return base64_decode(urldecode($string));
}

function wp_css_is_directory_writable($directory) {
	$filename = $directory . '/' . 'tmp_file_' . time();
	$fh = @fopen($filename, 'w');
	if (!$fh) {
		return false;
	}
	
	$written = fwrite($fh, "test");
	fclose($fh);
	unlink($filename);
	
	if ($written) {
		return true;
	} else {
		return false;
	}
}

function wp_css_get_css_imports($buffer)
{	
	global $wp_css;
	
	$file_path = $wp_css['path'];
	if (isset($wp_css['dir'])) $file_path .= $wp_css['dir'].'/';
	
	$inner_file_string = '';
	
	$files_found = wp_css_find_css_imports($buffer);
	
	if ( count($files_found) == 0 ) {
		$inner_file_string = wp_css_fix_urls($file_string);
		$file_string .= $inner_file_string."\n\n";
	} else {
		foreach ($files_found as $inner_file) {
			// if import url('file.css') doesn't exist skip it
			if ( !file_exists($file_path.$inner_file[1]) ) {
				$buffer = str_replace($inner_file[0], '', $buffer);
				continue;
			}				
			$inner_file_string = wp_css_fix_urls(file_get_contents($file_path.$inner_file[1]));
			$inner_file_string = "/* ---- ".$inner_file[1]." ---- */\n".$inner_file_string."\n\n";
			$buffer = str_replace($inner_file[0], $inner_file_string, $buffer);			
		} //foreach
	} //else

	return array('buffer'=>$buffer, 'files'=>$files_found);
}

function wp_css_activation($update = FALSE)
{
	if ($update == TRUE) {
		update_option('wp_css_activation', $_REQUEST['wp_css_activation']);
		$activation = get_option('wp_css_activation');
	} else if ( ! ($activation = get_option('wp_css_activation')) ) {
		$activation = 'on';
		add_option('wp_css_activation', $activation);
	} else {
		$activation = get_option('wp_css_activation');
	}
	return $activation;
}

function wp_css_within_posts_activation($update = FALSE)
{
	if ($update == TRUE) {
		update_option('wp_css_within_posts_activation', $_REQUEST['wp_css_within_posts_activation']);
		$activation = get_option('wp_css_within_posts_activation');
	} else if ( ! ($activation = get_option('wp_css_within_posts_activation')) ) {
		$activation = 'on';
		add_option('wp_css_within_posts_activation', $activation);
	} else {
		$activation = get_option('wp_css_within_posts_activation');
	}
	return $activation;
}

function wp_css_add_meta($id, $meta_key, $meta_value, $default_value = '')
{
	if (isset($meta_value) && !empty($meta_value)) {
		
		if (!get_post_meta($id, $meta_key)) {
			add_post_meta($id, $meta_key, $meta_value);
		} else {
			update_post_meta($id, $meta_key, $meta_value, $default_value);
		}
    }
}

function wp_css_directory_map ($source, $needle = '.txt$', $top_level_only = TRUE)
{	
	$file_array = array();
	if ($fp = @opendir($source))
	{ 
		while (FALSE !== ($file = readdir($fp)))
		{
			if (is_dir($source.$file) && substr($file, 0, 1) != '.' && $top_level_only == FALSE) 
			{       
				$temp_array = array();
				$temp_array = wp_css_directory_map($source.$file."/", $needle);   
				$file_array[$file] = $temp_array;
			}
			else if (substr($file, 0, 1) != "."  && eregi($needle, $file) && !eregi('wp-css-settings.txt', $file))
			{
				$file_array[] = $file;
			}
		}

		return $file_array;        
	}
}

function wp_css_delete($dir = WP_CSS_CACHE_PATH) 
{
  if ($handle = opendir("$dir")) {
	
   while (false !== ($item = readdir($handle))) {
	
     if ($item != "." && $item != "..") {
	
       if (is_dir("$dir/$item")) {
         wp_css_delete("$dir/$item");
       } else {
         @unlink("$dir/$item");
       } //else

     } //if

   } //while

   closedir($handle);

   //rmdir($dir);	
  } //if

}

?>