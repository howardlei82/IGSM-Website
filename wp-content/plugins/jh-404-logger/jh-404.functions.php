<?php 
function jh_404_check() {
	if( is_404() ) {
		jh_404_log();
	}
}

function jh_404_log() {
	$logs = (array) get_option('jh_404_log');
	$logs[$_SERVER["REQUEST_URI"]]['date'][] = time();
	
	if( $_SERVER['HTTP_REFERER'] )
		$logs[$_SERVER["REQUEST_URI"]]['referer'] = $_SERVER['HTTP_REFERER'];
	
	update_option('jh_404_log', array_filter( $logs ) );
	
}

function jh_404_get_log() {
	$log = (array) get_option('jh_404_log');
	
	$dates = array();
	foreach( $log as $url => $l ) {
		foreach( (array) $l['date'] as $date ) {
			$dates[$date] = $url;
		}
	}
	
	ksort( $dates );
	$dates = array_reverse( $dates, true );
	
	
	foreach( $dates as $date => $url ) {
		if( $$url ) {
			unset( $dates[$date] );
		}
		$$url = $url;
	}
		
	foreach( $dates as $date => $url ) {
		$t_log[$url] = $log[$url];
	}
	
	$log = $t_log;

	return $log;
}
?>