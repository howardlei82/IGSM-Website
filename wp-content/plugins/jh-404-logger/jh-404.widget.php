<?php 
function jh_404_widget() {
	
	$log = jh_404_get_log();	
	?>
	
	<table>
		<thead>
			<th class="td-url">URL</th>
			<th class="td-count">Count</th>
			<th class="td-date">Date</th>
			<th class="td-delete"></th>
		</thead>
		<tbody>
			<?php 
			if( !empty($log) && is_array( $log ) ) {
				jh_404_table_body_content($log);
			}
			else { ?>
				<tr><td colspan="4">No 404s, excellent!</td></tr>
			<?php } ?>
		</tbody>
	</table>
	
	<p class="actions">
		<a href="#" class="refresh">Refresh</a> | <a href="#" class="delete-all">Delete All</a>
		<span id="jh-404-loading">Loading...</span>
	</p>
	
	<?php
}

function jh_404_table_body_content( $log ) {
	?>
	<?php foreach( (array) $log as $url => $l ) : ?>
	    <tr>
	    	<td><?php echo $url ?> 
	    		<span class="actions">
	    			<a class="view-page" href="<?php echo get_bloginfo('url') . $url ?>" target="_blank" title="View Page">View Page</a>
	    			<?php if( $l['referer'] ) : ?>
	    				<a class="view-referer" href="<?php echo $l['referer'] ?>" target="_blank" title="View Referer">View Referer</a>
	    			<?php endif; ?>
	    		</span>
	    	</td>
	    	<td><?php echo count( $l['date'] ) ?></td>
	    	<td class="td-date"><?php echo date('jS M y H:i:s', end($l['date'] ) ); ?> </td>
	    	<td><a href="#" rel="<?php echo $url ?>" class="delete-url" title="Delete URL">X</a></td>
	    </tr>
	<?php endforeach; ?>
	<?php
}

?>