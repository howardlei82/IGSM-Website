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

//include_once('../../../wp-config.php');
include_once('wp-css-functions.php');

if( isset($_GET['f']) ) {
	
	$wp_css['file'] = (substr($_GET['f'], 0, 1) == '/') ? substr($_GET['f'], 1) : $_GET['f'];
	
	if (eregi('wp\-config\.php', $wp_css['file'])) exit;
	
	if ($wp_css['settings'] = wp_css_setting()) {
		$wp_css['url'] = $wp_css['settings']['u'].'/';
		$wp_css['path'] = $wp_css['settings']['p'].'/';
		$wp_css['cache'] = $wp_css['settings']['c'];
	} else {
		$wp_css['url'] = wp_css_decode_string($_GET['u']).'/';
		$wp_css['path'] = wp_css_decode_string($_GET['p']).'/';
		$wp_css['cache'] = wp_css_decode_string($_GET['c']);
	}
	
	if (isset($_GET['d'])) $wp_css['dir'] = wp_css_decode_string($_GET['d']);

	if(extension_loaded('zlib') && substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
		ob_start('ob_gzhandler');
		header('Content-Encoding: gzip');
	} else {
		ob_start();
	}
	
	header("Content-type: text/css; charset: UTF-8");
	header("Cache-Control: max-age=".$wp_css['cache']);
	header("Expires: " .gmdate("D, d M Y H:i:s", time() + $wp_css['cache']) . " GMT");

	if ( !wp_css_is_expired($wp_css['file']) && file_exists(WP_CSS_CACHE_PATH.wp_css_filename($wp_css['file'])) ) {
			include(WP_CSS_CACHE_PATH.wp_css_filename($wp_css['file']));
	 } else {
		ob_start("wp_css_clean");
		
		if(file_exists($wp_css['path'].$wp_css['file'])) {
			include($wp_css['path'].$wp_css['file']);
		} else {
			echo(__FILE__." (".__LINE__.")\n");
			echo("File not found: ".$wp_css['path'].$wp_css['file']);
		}

		ob_end_flush();
	 }
	
	ob_end_flush();
	exit();
}

function wp_css_clean($buffer) {
	global $wp_css;

	$buffer = wp_css_fix_urls($buffer);
	// $buffer = wp_css_fix_font_face($buffer);
	$files = wp_css_get_css_imports($buffer);

	$buffer = $files['buffer'];
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t"), '', $buffer); 
	
	$array['imports'] = $files['files'];
	$array['file'] = $wp_css['file'];
	
	if (wp_css_is_directory_writable('cache')) {
		wp_css_create_file(wp_css_filename($wp_css['file']), $buffer);
		wp_css_create_file(wp_css_filename($wp_css['file'], '.txt'), serialize($array));
	}
	
	return $buffer;
}

?>