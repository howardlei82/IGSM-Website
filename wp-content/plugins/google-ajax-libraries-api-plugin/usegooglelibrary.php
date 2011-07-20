<?php
/*
Plugin Name: Use Google Library Javascript
Plugin URI: http://blog.clearskys.net/2008/05/28/google-ajax-libraries-api-plugin/
Description: This plugin automatically replaces local calls for javascript libraries for those supported by the Google Library API.
Version: 0.9
Author: clearskys.net
Author URI: http://blog.clearskys.net
*/
// Load the javascript text
if(addslashes($_GET['type']) == 'js') {
	header("Content-type: application/javascript; charset: UTF-8");
	echo "jQuery.noConflict();";
	die();
}


function cs_usegooglelibrary($src = "") {
		
	$googlelibraries = array(	"/jquery.js" 		=>	"http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js",
								"/jqueryui.js"		=>	"http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js",
								"/prototype.js"		=>	"http://ajax.googleapis.com/ajax/libs/prototype/1/prototype.js",
								"/mootools.js"		=>	"http://ajax.googleapis.com/ajax/libs/mootools/1/mootools-yui-compressed.js",
								"/scriptaculous.js"	=>	"http://ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js",
								"/scriptaculous/builder.js"		=>	"http://ajax.googleapis.com/ajax/libs/scriptaculous/1/builder.js",
								"/scriptaculous/effects.js"		=>	"http://ajax.googleapis.com/ajax/libs/scriptaculous/1/effects.js",
								"/scriptaculous/dragdrop.js"		=>	"http://ajax.googleapis.com/ajax/libs/scriptaculous/1/dragdrop.js",
								"/scriptaculous/controls.js"		=>	"http://ajax.googleapis.com/ajax/libs/scriptaculous/1/controls.js",
								"/scriptaculous/slider.js"		=>	"http://ajax.googleapis.com/ajax/libs/scriptaculous/1/slider.js",
								"/scriptaculous/sound.js"			=>	"http://ajax.googleapis.com/ajax/libs/scriptaculous/1/sound.js"
								);

	$matchstring = "";
	foreach($googlelibraries as $key => $value) {
		if($matchstring != "") $matchstring .= "|";
		$matchstring .= addcslashes($key,"/");
	}
	$matchstring = "/(" . $matchstring . ")/";
	
	if(preg_match($matchstring,$src, $matches)) {
		$src = $googlelibraries[$matches[1]];
	}
	
	return $src;
	
}

function cs_handlejqueryconflict($args) {
	
	$jquerypos = array_search('jquery', $args);
	if(false !== $jquerypos && in_array('prototype', $args)) {
		// Need to add a no conflict call after the jquery.
		$directories = explode(DIRECTORY_SEPARATOR,dirname(__FILE__));
		$mydir = $directories[count($directories)-1];
		$mylocation = $mydir . DIRECTORY_SEPARATOR . basename(__FILE__);
		
		wp_register_script('jquerynoconflict',get_settings('siteurl') . '/wp-content/' . $mylocation . '?type=js' ,array('jquery'));
		array_splice( $args, $jquerypos+1, 0, 'jquerynoconflict' );
	}
	
	return $args;
}

add_filter('print_scripts_array', 'cs_handlejqueryconflict');
add_filter('script_loader_src','cs_usegooglelibrary');

?>