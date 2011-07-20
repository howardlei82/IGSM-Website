<?php
/*
Plugin Name: WP Post Sorting
Plugin URI: http://www.reflectionmedia.ro/2008/12/wp-post-sorting-plugin/
Description: Allows sorting of posts by post_title (ascending or descending) or post_date (ascending or descending), customizable for each category.
Version: 1.2
Author: Reflection Media
Author URI: http://www.reflectionmedia.ro/
*/

/*
	Copyright 2008  Reflection Media  (email : gabriel@reflectionmedia.ro)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// We just like to add all the hooks via includes.
// It keeps everything nice and clean.

include 'wpps_hook_admin_menu.php'; // This is handling the administration menu
include 'wpps_hook_posts_orderby.php'; // This is handling the actual sorting

?>