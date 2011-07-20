<?php
/*
Plugin Name: Fresh Comments widget
Plugin URI: http://beconfused.com/blog/2007/03/23/fresh-comments-121/
Description: Adds an enhanced recent comments widget to allow you to have more control on how fresh comments can be displayed.
Author: Mr. Dew
Version: 1.2.1
Author URI: http://beconfused.com
*/

function widget_freshcomments_init() {
	
	// Checks if widgets plugin is activated
	if ( !function_exists('register_sidebar_widget') )
		return;

	// This saves options and prints the widget's config form.
	function widget_freshcomments_control() {
		$options = $newoptions = get_option('widget_freshcomments');
		if ( $_POST['freshcomments-submit'] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST['freshcomments-title']));
			$newoptions['before'] = stripslashes($_POST['freshcomments-before']);
			$newoptions['format'] = stripslashes($_POST['freshcomments_format']);
			$newoptions['after'] = stripslashes($_POST['freshcomments-after']);
			$newoptions['count'] = (int) $_POST['freshcomments-count'];
			$newoptions['wordcount'] = (int) $_POST['freshcomments-wordcount'];
			$newoptions['datetimeformat'] = stripslashes($_POST['freshcomments-datetimeformat']);
			$newoptions['pingback'] = isset($_POST['freshcomments-pingback']);
			$newoptions['trackback'] = isset($_POST['freshcomments-trackback']);
			
			if ($newoptions['format'] == '') $newoptions['format'] = "<li><a href=\"%comment_permalink%\">%comment_author% in %post_title%</a>: %comment_preview%</li>";
			if ($newoptions['datetimeformat'] == '') $newoptions['datetimeformat'] = "F j, Y, g:i a";
			if ($newoptions['count'] <= 0) $newoptions['count'] = 1;
			if ($newoptions['wordcount'] <= 0) $newoptions['wordcount'] = 1;
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_freshcomments', $options);
		}
?>
<script type="text/javascript">
// This is found in phpMyAdmin, read more here - http://www.alexking.org/blog/2003/06/02/inserting-at-the-cursor-using-javascript/
function insert(myValue) {
	myField = document.getElementById('sbadmin').freshcomments_format
	//IE support
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = myValue;
	}
	//MOZILLA/NETSCAPE support
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);
	} else {
		myField.value += myValue;
	}
}
</script>

		<div style="width:440px">
			<label for="freshcomments-title" style="float:left;width:120px;">Title:</label>
			<input type="text" id="freshcomments-title" name="freshcomments-title" style="width:300px;" value="<?php echo htmlspecialchars($options['title']); ?>" />
			
			<div style="clear:both;height:1em;"></div>
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top">						
						<label for="freshcomments-count" style="float:left;width:120px;">No. of comments: </label>
						<input type="text" id="freshcomments-count" name="freshcomments-count" style="width:40px;" value="<?php echo $options['count']; ?>" />
						<br style="clear:left" />
						
						<label for="freshcomments-wordcount" style="float:left;width:120px;">No. of words: </label>
						<input type="text" id="freshcomments-wordcount" name="freshcomments-wordcount" style="width:40px;" value="<?php echo htmlspecialchars($options['wordcount']); ?>" />
						<br style="clear:left" />
						
					</td>
					<td valign="top">						
						<label for="freshcomments-datetimeformat" style="float:left;width:120px;">Date/Time format: </label>
						<input type="text" id="freshcomments-datetimeformat" name="freshcomments-datetimeformat" style="width:70px;" value="<?php echo $options['datetimeformat']; ?>" />
						<br style="clear:left" />
						
						<label for="freshcomments-trackback" style="float:left;width:120px;">Show trackbacks: </label>
						<input type="checkbox" id="freshcomments-trackback" name="freshcomments-trackback" <?php echo $options['trackback'] ? 'checked="checked"':''; ?> />
						
						<br style="clear:left" />
						
						<label for="freshcomments-pingback" style="float:left;width:120px;margin-bottom:1em;">Show pingbacks: </label>
						<input type="checkbox" id="freshcomments-pingback" name="freshcomments-pingback" <?php echo $options['pingback'] ? 'checked="checked"':''; ?> />
						
						<br style="clear:left" />
						
					</td>
				</tr>
				<tr>
					<td>
						<label for="freshcomments-before" style="float:left;width:120px;">Before: </label> 
						<input type="text" id="freshcomments-before" name="freshcomments-before" style="width:70px;" value="<?php echo $options['before']; ?>" /> 
						<br style="clear:left" />
						
					</td>
					<td>
						<label for="freshcomments-after" style="float:left;width:120px;">After: </label>
						<input type="text" id="freshcomments-after" name="freshcomments-after" style="width:70px;" value="<?php echo $options['after']; ?>" />
						<br style="clear:left" />

					</td>
				</tr>
			</table>
			
			<div style="clear:both;height:1em;"></div>
			
			<label for="freshcomments_format" style="float:left;width:120px;">Format displayed for each comment <em>(<a href="#" onclick="document.getElementById('sbadmin').freshcomments_format.value='&lt;li&gt;&lt;a href=&quot;%comment_permalink%&quot;&gt;%comment_author% in %post_title%&lt;/a&gt;: %comment_preview%&lt;/li&gt;';return false;">reset</a>)</em>: </label>
			<textarea id="freshcomments_format" name="freshcomments_format" wrap="soft" style="width:300px;margin-bottom:5px;height:80px;"><?php echo htmlspecialchars($options['format']); ?></textarea>
			<br style="clear:left" />
			<table width="100%" border="0" cellspacing="0" style="text-align:left" cellpadding="0">
				<tr>
					<td colspan="2" style="padding-top:1em">Click to insert into format:</td>
				</tr>
				<tr>
					<td><a href="#" onclick="insert('%comment_author%');return false;">%comment_author%</a></td>
					<td><a href="#" onclick="insert('%comment_permalink%');return false;">%comment_permalink%</a></td>
				</tr>
				<tr>
					<td><a href="#" onclick="insert('%comment_author_url%');return false;">%comment_author_url%</a></td>
					<td><a href="#" onclick="insert('%comment_datetime%');return false;">%comment_datetime%</a></td>
				</tr>
				<tr>
					<td><a href="#" onclick="insert('%comment_content%');return false;">%comment_content%</a></td>
					<td><a href="#" onclick="insert('%post_title%');return false;">%post_title%</a></td>
				</tr>
				<tr>
					<td><a href="#" onclick="insert('%comment_preview%');return false;">%comment_preview%</a></td>
					<td><a href="#" onclick="insert('%post_permalink%');return false;">%post_permalink%</a></td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<div style="padding-top:2em;text-align:right;"><a href="http://beconfused.com/blog/2006/07/11/fresh-comments-1-1-wordpress-widget-is-here/" title="Read more about Fresh Comment 1.1 at //beconfused." style="text-decoration:underline;">Help?</a></div>
			<input type="hidden" name="freshcomments-submit" id="freshcomments-submit" value="1" />
		</div>
	<?php
	} //end function widget_freshcomments_control

	function widget_freshcomments($args) {
		extract($args);
		global $wpdb;	

		$options = (array) get_option('widget_freshcomments');
		
		// Use these if no options are set
		$defaultoptions = array(
			'title' => 'Fresh Comments', 
			'before' => '<ul>', 
			'format' => '<li><a href=\"%comment_permalink%\">%comment_author%</a>: %comment_preview% [...]</li>',
			'datetimeformat' => 'F j, Y, g:i a',
			'after' => '</ul>', 
			'count' => 5,
			'wordcount' => 10);

		foreach ($defaultoptions as $key => $value) {
		 	if ( !isset($options[$key]) ) {
				$options[$key] = $defaults[$key];
			};
		};

		extract($options);
		
		// Check if webpage is a category only if categorial check is activated.
		if ($options['pingback'] && $options['trackback']) {
			$comment_type = '%na%';
		} else if ($options['pingback']) {
			$comment_type = '%trackback%';
		} else if ($options['trackback']) {
			$comment_type = '%pingback%';
		} else {
			$comment_type = '%back%';
		};
		
		// Retrieves comments table
		$comments = $wpdb->get_results("SELECT comment_ID, comment_post_ID, comment_author, comment_author_url, comment_content, comment_date, post_title
			FROM $wpdb->comments, $wpdb->posts
			WHERE ID = comment_post_ID
				AND post_password = ''
				AND comment_approved = '1'
				AND comment_type NOT LIKE '$comment_type'
				AND (post_status = 'publish' OR post_status = 'static')
			ORDER BY comment_date DESC 
			LIMIT 0, $count");
		
		foreach ($comments as $comment) {
			// $comment_author
			if ($comment->comment_author == '') {
				$comment_author = "Anonymous";
			} else {
				$comment_author = stripslashes($comment->comment_author);
			}
			
			// $comment_author_url
			$comment_author_url = $comment->comment_author_url;
			
			// $comment_preview
			$comment_content = stripslashes(strip_tags($comment->comment_content));
			$comment_preview = explode(" ", $comment_content);
			$comment_preview = array_slice($comment_preview, 0, $wordcount);
			$comment_preview = implode($comment_preview, " ");
			$comment_preview = str_replace("\n", " ", $comment_preview);
			
			// $comment_datetime
			$comment_datetime = date($datetimeformat, strtotime($comment->comment_date));

			// $post_permalink
			$post_permalink = get_permalink($comment->comment_post_ID);
			
			// $comment_permalink
			$comment_permalink = $post_permalink . "#comment-" . $comment->comment_ID;
			
			// $post_title
			$post_title = $comment->post_title;
			
			// Constructing format back
			$display = str_replace("%comment_author%", $comment_author, $format);
			$display = str_replace("%comment_author_url%", $comment_author_url, $display);
			$display = str_replace("%comment_content%", $comment_content, $display);
			$display = str_replace("%comment_preview%", $comment_preview, $display);
			$display = str_replace("%post_title%", $post_title, $display);
			$display = str_replace("%comment_permalink%", $comment_permalink, $display);
			$display = str_replace("%post_permalink%", $post_permalink, $display);
			$display = str_replace("%comment_datetime%", $comment_datetime, $display);
			
			$fresh_comments .= wptexturize($display);
		};//end foreach		

		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo $before . $fresh_comments . $after;
		echo $after_widget;
	}//end function widget_freshcomments

	register_sidebar_widget('Fresh Comments', 'widget_freshcomments');
	register_widget_control('Fresh Comments', 'widget_freshcomments_control', 440, 410);
}

add_action('widgets_init', 'widget_freshcomments_init');

?>