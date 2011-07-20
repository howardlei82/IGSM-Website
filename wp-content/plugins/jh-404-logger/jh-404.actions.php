<?php 
include_once('../../../wp-load.php');

switch ($_POST['action']) :
	
	case 'delete_url' :
		if( !wp_verify_nonce( $_POST['nonce'], 'delete_url' ) ) {
			echo 'Nonce Error';
			exit;
		}
		
		$log = (array) get_option('jh_404_log');
		unset($log[$_POST['url']]);	
		update_option( 'jh_404_log', $log );
		echo 'URL Deleted';
		
		break;
		
	case 'delete_all' :
		if( !wp_verify_nonce( $_POST['nonce'], 'delete_all' ) ) {
			echo 'Nonce Error';
			exit;
		}
		
		update_option( 'jh_404_log', array() );
		echo 'All URLs Deleted';
		
		break;
	
	case 'refresh':
		if( !wp_verify_nonce( $_POST['nonce'], 'refresh' ) ) {
			echo 'Nonce Error';
			exit;
		}
		
		$log = jh_404_get_log();
		jh_404_table_body_content($log);
		
		break;
	
endswitch;

?>
