<?php include_once('../../../wp-load.php') ?>
jQuery(document).ready( function($) {
	
	actionsUrl = '<?php echo plugin_dir_url(__FILE__) ?>jh-404.actions.php';
	
	//delete single
	$("a.delete-url").live('click', function(e) {
		e.preventDefault();
		a = $(this);
		
		$("#jh-404-loading").fadeIn();
		
		$.ajax({
			type: "POST",
			url: actionsUrl,
			data: ({ 
				action: 'delete_url',
				url: $(this).attr('rel'),
				nonce: '<?php echo wp_create_nonce("delete_url") ?>'
			}),
			success: function( data ){
				$("#jh-404-loading").fadeOut();
				$(a).closest('tr').slideUp().fadeOut();
			}
 		});
 		
 		
	});
	
	//delete all
	$("a.delete-all").live('click', function(e) {
		e.preventDefault();
		a = $(this);
		
		$("#jh-404-loading").fadeIn();
		
		$.ajax({
			type: "POST",
			url: actionsUrl,
			data: ({ 
				action: 'delete_all',
				nonce: '<?php echo wp_create_nonce("delete_all") ?>'
			}),
			success: function( data ){
				$("#jh-404-loading").fadeOut();
				$("#jh-404-loading").fadeOut();
				$(a).closest('.inside').find('tbody').contents().remove();
			}
 		});
 		
 		
	});
	
	//refresh
	$("a.refresh").live('click', function(e) {
		e.preventDefault();
		a = $(this);
		
		$("#jh-404-loading").fadeIn();
		
		$.ajax({
			type: "POST",
			url: actionsUrl,
			data: ({ 
				action: 'refresh',
				nonce: '<?php echo wp_create_nonce("refresh") ?>'
			}),
			success: function( data ){
				$("#jh-404-loading").fadeOut();
				if( data.replace(new RegExp("^[\\s]+", "g"), "" ) > '' ) {
					$(a).closest('.inside').find('tbody').contents().remove();
					$(a).closest('.inside').find('tbody').append( data );
				}
			}
 		});
 		
 		
	});
	
});