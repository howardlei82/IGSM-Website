<?php
// The "my_plugin_menu" function is hooked to the "admin_menu" hook.
add_action('admin_menu', 'my_plugin_menu');

// This is where it says where to put the menu, it's name, etc.
function my_plugin_menu() {
  add_submenu_page( 'edit.php', 'Post Sorting Options', 'Post Sorting', 'manage_categories', __FILE__, 'my_plugin_options');
}

// This is the function which describes the menu.
function my_plugin_options() {
	// This is where the CSS file is added.
	echo '<link type="text/css" rel="stylesheet" href="' . WP_PLUGIN_URL . '/wp-post-sorting/wpps_dashboard.css" />';

	// This just declares and defines some database stuff
	include 'wpps_include_db.php';

	// If our table does not exist, we create it right now.
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	
		$sql = "CREATE TABLE " . $table_name . " (
			category mediumint(9),
			sorting mediumint(9)
		);";

		// Whatever, apparently this is what needs to be done in order to create it.
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	// If the user has posted some info, 'mt_submit_hidden' will be set to 'Y'
    if( $_POST[ 'mt_submit_hidden' ] == 'Y' ) {
        // We read the posted value for 'default-sorting'
		$def_sorting=$_POST['default-sorting'];
		// And we save it in the database as a option
        update_option( 'def-sorting', $def_sorting );

		// Then we wipe clean the entire table
		$wpdb->query('delete from '.$table_name);
		
		// And we do the following for each category
		$cat_rows = $wpdb->get_results("SELECT term_id FROM ".$wpdb->prefix."term_taxonomy WHERE taxonomy = 'category'");
		foreach ($cat_rows as $cat_row) {
			$my_row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."terms WHERE term_id = ".$cat_row->term_id);
			$cat_name = $my_row->name;
			$cat_slug = $my_row->slug;
			// We now have the name, slug, and ID for our category
			
			// If the sorting is not set to default (1),
			// we insert the category and the sorting type into our table
			if ($_POST[$cat_slug]!=1){
				$insert = "INSERT INTO " . $table_name .
					" (category, sorting) " .
					"VALUES ('" . $cat_row->term_id . "','" . $_POST[$cat_slug] . "')";
				$wpdb->query( $insert );
			}
		}

// We display a message saying that the new options have been saved

?>
<div class="updated"><p><strong>Your new post sorting options have been successfully saved.</strong></p></div>
<?php

    }
	
	// Now we read from the database the previous value for the first field, "def_sorting"
	$def_sorting = get_option('def-sorting');
	$def_sel[$def_sorting]='selected="selected"';
	
	// Then we read from the database to see what are the previous values for the other fields
	// We select each category.
	$cat_rows = $wpdb->get_results("SELECT term_id FROM ".$wpdb->prefix."term_taxonomy WHERE taxonomy = 'category'");
	foreach ($cat_rows as $cat_row) {
		// we search $table_name for our current category
		$my_table_row = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE category = ".$cat_row->term_id);
		// and we put the 'selected="selected"' value where it needs to be, in $sorting_val[category][sorting]
		$sorting_val[$my_table_row->category][$my_table_row->sorting]='selected="selected"';
	}
	
    // Now we display the screen for editing the options
    echo '<div class="wrap">';

    // header
    echo "<h2>Post Sorting Options</h2>";

    // options form, with the first field being the default sorting
    ?>

<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="mt_submit_hidden" value="Y">

<label class="sBasicLabel" for="default-sorting">Default sorting (for all categories): </label>
<div class="sFormInputWarp">
	<select class="sFormSelect" name="default-sorting" value="<?php echo $def_sorting; ?>" >
		<option value="1">WordPress default</option>
		<option value="2" <?php echo $def_sel[2]; ?>>post title, ascending</option>
		<option value="3" <?php echo $def_sel[3]; ?>>post title, descending</option>
		<option value="4" <?php echo $def_sel[4]; ?>>post date, ascending</option>
		<option value="5" <?php echo $def_sel[5]; ?>>post date, descending</option>
	<!-- <option value="5" <?php echo $def_sel[6]; ?>>SOME OTHER SORTING</option> -->
	</select>
</div>
<h3>Categories:</h3>

	<?php
	// Now, for each existent category we make another table input
	$cat_rows = $wpdb->get_results("SELECT term_id FROM ".$wpdb->prefix."term_taxonomy WHERE taxonomy = 'category'");
	foreach ($cat_rows as $cat_row) {
		$my_row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."terms WHERE term_id = ".$cat_row->term_id);
		$cat_name = $my_row->name;
		$cat_slug = $my_row->slug;
	?>
		
<label class="sBasicLabel" for="<?php echo $cat_slug; ?>"><?php echo $cat_name; ?>: </label>
<div class="sFormInputWarp">
	<select class="sFormSelect" name="<?php echo $cat_slug; ?>">
		<option value="1">use default sorting</option>
		<option value="2" <?php echo $sorting_val[$cat_row->term_id][2]; ?>>post title, ascending</option>
		<option value="3" <?php echo $sorting_val[$cat_row->term_id][3]; ?>>post title, descending</option>
		<option value="4" <?php echo $sorting_val[$cat_row->term_id][4]; ?>>post date, ascending</option>
		<option value="5" <?php echo $sorting_val[$cat_row->term_id][5]; ?>>post date, descending</option>
	<!-- <option value="5" <?php echo $sorting_val[$cat_row->term_id][6]; ?>>SOME OTHER SORTING</option> -->
	</select>
</div>
<br />
	<?php
	}
// And finally the submit button.
	?>
		
<hr />
<p class="submit">
<input type="submit" name="Submit" value="Save Options" />
</p>

</form>

</div>

<?php
}
// That's all folks
?>