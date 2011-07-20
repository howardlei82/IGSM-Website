<?php
/*
Plugin Name: WP Super Edit WordPress Emoticons
Plugin URI: http://funroe.net/projects/super-edit/
Description: Adds emoticon / icon button to editor that uses default installed WordPress icon set.
Author: Jess Planck
Version: 2.3.8
Author URI: http://funroe.net

Copyright (c) Jess Planck (http://funroe.net)
WP Super Edit is released under the GNU General Public
License: http://www.gnu.org/licenses/gpl.txt

This is a WordPress plugin (http://wordpress.org). WordPress is
free software; you can redistribute it and/or modify it under the
terms of the GNU General Public License as published by the Free
Software Foundation; either version 2 of the License, or (at your
option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
General Public License for more details.

For a copy of the GNU General Public License, write to:

Free Software Foundation, Inc.
59 Temple Place, Suite 330
Boston, MA  02111-1307
USA

You can also view a copy of the HTML version of the GNU General
Public License at http://www.gnu.org/copyleft/gpl.html
*/

/**
* WP Super Emoticon function to register items in WP Super Edit
* Use $wp_super_edit primary object instance to add settings to database using register_tinymce_plugin() and register_tinymce_button() as many times as needed.
* @global object $wp_super_edit 
*/
function wp_super_emoticons_activate() {
	global $wp_super_edit;
	
	// WP Super Edit options for this plugin
	
	$wp_super_edit->register_tinymce_plugin( array(
		'name' => 'superemotions', 
		'nicename' => __('Super Emoticon / Icon Plugin'), 
		'description' => __('Wordpress Emoticon / Icon images. Uses Wordpress icon set. Provides the Emoticon / Icons Button. Uses WordPress shortcodes API.'), 
		'provider' => 'wp_super_edit', 
		'status' => 'no', 
		'callbacks' => ''
	));
	
	// Tiny MCE Buttons provided by this plugin
	
	$wp_super_edit->register_tinymce_button( array(
		'name' => 'superemotions', 
		'nicename' => __('Super Emoticon / Icons'), 
		'description' => __('Interface for Wordpress Emoticon / Icon images. Uses Wordpress icon set. Uses WordPress shortcodes API.'), 
		'provider' => 'wp_super_edit', 
		'plugin' => 'superemotions', 
		'status' => 'no'
	));
}
register_activation_hook( __FILE__, 'wp_super_emoticons_activate' );


/**
* WP Super Emoticon function to unregister items in WP Super Edit
* Use $wp_super_edit primary object instance to remove settings from database using unregister_tinymce_plugin() and unregister_tinymce_button() for the registered items.
* @global object $wp_super_edit 
*/
function wp_super_emoticons_deactivate() {
	global $wp_super_edit;
	
	// Unregister WP Super Edit options for this plugin
	$wp_super_edit->unregister_tinymce_plugin( 'superemotions');
	
	// Unregister Tiny MCE Buttons provided by this plugin
	$wp_super_edit->unregister_tinymce_button( 'superemotions' );
}
register_deactivation_hook( __FILE__, 'wp_super_emoticons_deactivate' );

/**
* WP Super Emoticons to add shortcode to WordPress editor
*/
function wp_super_emoticons_shortcode ($attr, $content = null ) {
	$attr = shortcode_atts(array(
		'file'   => 'file',
		'title'    => 'title'
		), $attr);
								 
	return '<img class="superemotions" title="' . $attr['title'] . '" alt="'  . $attr['title'] . '" border="0" src="' . get_bloginfo('wpurl') . '/wp-includes/images/smilies/' . $attr['file'] . '" />';
}
add_shortcode('superemotions', 'wp_super_emoticons_shortcode');


?>