<?php
/*
Plugin Name: WP Super Edit Theme Classes
Plugin URI: http://funroe.net/projects/super-edit/
Description: Adds CSS classes from your themes editor.css file to the visual editor.
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
* WP Super Class function to register items in WP Super Edit
* Use $wp_super_edit primary object instance to add settings to database using register_tinymce_plugin() and register_tinymce_button() as many times as needed.
* @global object $wp_super_edit 
*/
function wp_super_css_classes_activate() {
	global $wp_super_edit;
	
	// WP Super Edit options for this plugin
		
	$wp_super_edit->register_tinymce_plugin( array(
		'name' => 'supercssclasses', 
		'nicename' => __('Custom CSS Classes'), 
		'description' => __('Adds Custom styles button and CLASSES from an editor.css file in your <strong>Currently active THEME</strong> directory. Provides the Custom CSS Classes Button.'), 
		'provider' => 'wp_super_edit', 
		'status' => 'no', 
		'callbacks' => ''
	));
	
	// Tiny MCE Buttons provided by this plugin
	
	$wp_super_edit->register_tinymce_button( array(
		'name' => 'styleselect', 
		'nicename' => __('Custom CSS Classes'), 
		'description' => __('Shows a drop down list of CSS Classes that the editor has access to.'), 
		'provider' => 'tinymce', 
		'plugin' => 'supercssclasses', 
		'status' => 'no'
	));
}
register_activation_hook( __FILE__, 'wp_super_css_classes_activate' );


/**
* WP Super Class function to unregister items in WP Super Edit
* Use $wp_super_edit primary object instance to remove settings from database using unregister_tinymce_plugin() and unregister_tinymce_button() for the registered items.
* @global object $wp_super_edit 
*/
function wp_super_css_classes_deactivate() {
	global $wp_super_edit;
	
	// Unregister WP Super Edit options for this plugin
	$wp_super_edit->unregister_tinymce_plugin( 'wp-super-class');
	
	// Unregister Tiny MCE Buttons provided by this plugin
	$wp_super_edit->unregister_tinymce_button( 'styleselect' );
}
register_deactivation_hook( __FILE__, 'wp_super_css_classes_deactivate' );

/**
* WP Super Class custom CSS filter to add a theme/editor.css file to TinyMCE
*/
function wp_super_css_classes($mce_css) {
	if ( !empty( $mce_css ) ) $mce_css .= ',';
	$mce_css .= get_stylesheet_directory_uri() . '/editor.css';
	return $mce_css; 
}
add_filter('mce_css', 'wp_super_css_classes');

?>