<?php

/*
Plugin Name: JH 404 Logger
Plugin URI: http://www.joehoyle.co.uk/jh-404-logger/
Description: Admin dashboard panel for logging 404s
Author: Joe Hoyle
Version: 1.1
Author URI: http://www.joehoyle.co.uk/
*/

include_once('jh-404.functions.php');
include_once('jh-404.widget.php');

//add the dashboard widget
add_action('wp_dashboard_setup', 'jh_404_setup_widget' );
function jh_404_setup_widget() {
	wp_add_dashboard_widget('jh-404-widget', 'JH 404 Logger', 'jh_404_widget');
	wp_enqueue_script( 'jh_404_js', plugin_dir_url( __FILE__ ) . 'jh-404.js.php', array( 'jquery' ) );
	wp_enqueue_style( 'jh_404_css', plugin_dir_url( __FILE__ ) . 'jh-404.style.css' );
}

//log the 404
add_action('wp_head', 'jh_404_check');

?>