<?php
// The "post_sorting" function is hooked to the "posts_orderby" hook.
add_filter('posts_orderby', 'post_sorting' );

// This is the function that is doing all the post sorting.
function post_sorting( $orderby ){
	if (!is_category()) return $orderby;
	
	// This just declares and defines some database stuff
	include 'wpps_include_db.php';

	// The current category ID
	$cat = get_query_var('cat');
	
	// We read the current category row from the plugin table
	$my_table_row = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE category = ".$cat);
	
	// This is where we make the correspondence between the sorting type ID,
	// and the actual sorting, and we also return the desired value
	if( $my_table_row->sorting==2 ) return "post_title ASC";
	if( $my_table_row->sorting==3 ) return "post_title DESC";
	if( $my_table_row->sorting==4 ) return "post_date ASC";
	if( $my_table_row->sorting==5 ) return "post_date DESC";
//	if( $my_table_row->sorting==6 ) return "SOME OTHER SORTING";

	// If our current category does not belong to the sorting categories,
	// we return the default sorting value, which is saved in the database as an option
	$def_sorting = get_option('def-sorting');
	if($def_sorting==2) return "post_title ASC";
	if($def_sorting==3) return "post_title DESC";
	if($def_sorting==4) return "post_date ASC";
	if($def_sorting==5) return "post_date DESC";
//	if($def_sorting==6) return "SOME OTHER SORTING";

	// If it's none of theese, then it's either 1 (WordPress default)
	// or some erroneous value, in which case we also return the WordPress default
	return $orderby;
}

?>