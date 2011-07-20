<?php

function make_seed() {
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

function make_password($password_length){
srand(make_seed());
$alfa = "!@123!@4567!@890qwer!@tyuiopa@!sdfghjkl@!zxcvbn@!mQWERTYUIO@!PASDFGH@!JKLZXCVBNM!@";
$token = "";
for($i = 0; $i < $password_length; $i ++) {
  $token .= $alfa[rand(0, strlen($alfa))];
}
return $token;
}

function check_perms($name,$path,$perm)
{
    clearstatcache();
//    $configmod = fileperms($path);
    $configmod = substr(sprintf(".%o.", fileperms($path)), -4);
    $trcss = (($configmod != $perm) ? "background-color:#fd7a7a;" : "background-color:#91f587;");
    echo "<tr style=".$trcss.">";
    echo '<td style="border:0px;">' . $name . "</td>";
    echo '<td style="border:0px;">'. $path ."</td>";
    echo '<td style="border:0px;">' . $perm . '</td>';
    echo '<td style="border:0px;">' . $configmod . '</td>';
//    echo '<td style="border:0px;">' . '<input type="submit" name="' . $perm . '" value="Change now.">' . '</td>';
    echo "</tr>";
}

function mrt_get_serverinfo() {
        global $wpdb;
        $sqlversion = $wpdb->get_var("SELECT VERSION() AS version");
        $mysqlinfo = $wpdb->get_results("SHOW VARIABLES LIKE 'sql_mode'");
        if (is_array($mysqlinfo)) $sql_mode = $mysqlinfo[0]->Value;
        if (empty($sql_mode)) $sql_mode = __('Not set');
        if(ini_get('safe_mode')) $safe_mode = __('On');
        else $safe_mode = __('Off');
        if(ini_get('allow_url_fopen')) $allow_url_fopen = __('On');
        else $allow_url_fopen = __('Off');
        if(ini_get('upload_max_filesize')) $upload_max = ini_get('upload_max_filesize');
        else $upload_max = __('N/A');
        if(ini_get('post_max_size')) $post_max = ini_get('post_max_size');
        else $post_max = __('N/A');
        if(ini_get('max_execution_time')) $max_execute = ini_get('max_execution_time');
        else $max_execute = __('N/A');
        if(ini_get('memory_limit')) $memory_limit = ini_get('memory_limit');
        else $memory_limit = __('N/A');
        if (function_exists('memory_get_usage')) $memory_usage = round(memory_get_usage() / 1024 / 1024, 2) . __(' MByte');
        else $memory_usage = __('N/A');
        if (is_callable('exif_read_data')) $exif = __('Yes'). " ( V" . substr(phpversion('exif'),0,4) . ")" ;
        else $exif = __('No');
        if (is_callable('iptcparse')) $iptc = __('Yes');
        else $iptc = __('No');
        if (is_callable('xml_parser_create')) $xml = __('Yes');
        else $xml = __('No');

?>
        <li><?php _e('Operating System'); ?> : <strong><?php echo PHP_OS; ?></strong></li>
        <li><?php _e('Server'); ?> : <strong><?php echo $_SERVER["SERVER_SOFTWARE"]; ?></strong></li>
        <li><?php _e('Memory usage'); ?> : <strong><?php echo $memory_usage; ?></strong></li>
        <li><?php _e('MYSQL Version'); ?> : <strong><?php echo $sqlversion; ?></strong></li>
        <li><?php _e('SQL Mode'); ?> : <strong><?php echo $sql_mode; ?></strong></li>
        <li><?php _e('PHP Version'); ?> : <strong><?php echo PHP_VERSION; ?></strong></li>
        <li><?php _e('PHP Safe Mode'); ?> : <strong><?php echo $safe_mode; ?></strong></li>
        <li><?php _e('PHP Allow URL fopen'); ?> : <strong><?php echo $allow_url_fopen; ?></strong></li>
        <li><?php _e('PHP Memory Limit'); ?> : <strong><?php echo $memory_limit; ?></strong></li>
        <li><?php _e('PHP Max Upload Size'); ?> : <strong><?php echo $upload_max; ?></strong></li>
        <li><?php _e('PHP Max Post Size'); ?> : <strong><?php echo $post_max; ?></strong></li>
        <li><?php _e('PHP Max Script Execute Time'); ?> : <strong><?php echo $max_execute; ?>s</strong></li>
        <li><?php _e('PHP Exif support'); ?> : <strong><?php echo $exif; ?></strong></li>
        <li><?php _e('PHP IPTC support'); ?> : <strong><?php echo $iptc; ?></strong></li>
        <li><?php _e('PHP XML support'); ?> : <strong><?php echo $xml; ?></strong></li>
<?php
}

function mrt_check_table_prefix(){
if($GLOBALS['table_prefix']=='wp_'){
echo '<font color="red">Your table prefix should not be <i>wp_</i>.  <a href="admin.php?page=database">Click here</a> to change it.</font><br />';
}else{
echo '<font color="green">Your table prefix is not <i>wp_</i>.</font><br />';
}
}

function mrt_errorsoff(){
echo '<font color="green">WordPress DB Errors turned off.</font><br />';
}

function mrt_wpdberrors()
{
		global $wpdb;
		$wpdb->show_errors = false;

}

function mrt_version_removal(){
global $wp_version;
   echo '<font color="green">Your WordPress version is successfully hidden.</font><br />';
}

function mrt_remove_wp_version()
{
                 
					function filter_generator( $gen, $type ) { 
					    switch ( $type ) { 
					        case 'html':
					            $gen = '<meta name="generator" content="WordPress">';
					            break;
					        case 'xhtml':
					            $gen = '<meta name="generator" content="WordPress" />';
					            break;
					        case 'atom':
					            $gen = '<generator uri="http://wordpress.org/">WordPress</generator>';
					            break;
					        case 'rss2':
					            $gen = '<generator>http://wordpress.org/?v=</generator>';
					            break;
					        case 'rdf':
					            $gen = '<admin:generatorAgent rdf:resource="http://wordpress.org/?v=" />';
					            break;
					        case 'comment':
					            $gen = '<!-- generator="WordPress" -->';
					            break;
					    }    
					    return $gen;
					}
					foreach ( array( 'html', 'xhtml', 'atom', 'rss2', 'rdf', 'comment' ) as $type )
					    add_filter( "get_the_generator_$type", 'filter_generator', 10, 2 );


}

function mrt_check_version(){
//echo "WordPress Version: ";
global $wp_version;
$mrt_wp_ver = ereg_replace("[^0-9]", "", $wp_version);
while ($mrt_wp_ver > 10){
    $mrt_wp_ver = $mrt_wp_ver/10;
    }
if ($mrt_wp_ver >= "2.8") $g2k5 = '<font color="green"><strong>WordPress version: ' . $wp_version . '</strong> &nbsp;&nbsp;&nbsp; You have the latest stable version of WordPress.</font><br />';
if ($mrt_wp_ver < "2.8") $g2k5 = '<font color="red"><strong>WordPress version: ' . $wp_version . '</strong> &nbsp;&nbsp;&nbsp; You need version 2.8.6.  Please <a href="http://wordpress.org/download/">upgrade</a> immediately.</font><br />';
/*echo "<b>" . $wp_version . "</b>  &nbsp;&nbsp;&nbsp " ;*/echo $g2k5;
}


function mrt_javascript(){
$siteurl = get_option('siteurl');
?><script language="JavaScript" type="text/javascript" src="<?php echo WP_PLUGIN_DIR;?>/wp-security-scan/js/scripts.js"></script><?php
}

/*** make http requests, maintain cookies ***/
function wpss_http_request($url, $request, $content_type, $method) {
	static $cookie = "";
	$wsd_cookie = null;
	// performs the HTTP request
	$opts = array ('http' => array (
								'method'  => $method,
	                            'header'  => "Content-type: $content_type\r\n",
	                            'content' => $request));
	if ($cookie) $opts['http']['header'] .= "Cookie: $cookie";
	$context  = stream_context_create($opts);
	if ($fp = @fopen($url, 'r', false, $context)) {
		$response = '';
	    while($row = fgets($fp))
			$response.= trim($row)."\n";
			$meta = stream_get_meta_data($fp);
			for ($j = 0; isset($meta['wrapper_data'][$j]); $j++) {
	   			$httpline = $meta['wrapper_data'][$j];
	   	   		@list($header,$parameters) = explode(";",$httpline,2);
	   			@list($attr,$value) = explode(":",$header,2);
	   			if (strtolower(trim($attr)) == "set-cookie") {
	      			$wsd_cookie = trim($value);
	      			break;
	   			}
			$cookie = $wsd_cookie;
		}
		return $response;
	} else {
		return false;
	}
}

/*** json2 rpc post ***/
function wpss_json2_post($url, $request) {
        $request = json_encode($request);
		$response = wpss_http_request($url, $request, 'application/json', 'POST');
		if ($response !== false)
			return json_decode($response,true);
		else
			return false;
}

/*** rpc call interface ***/
function wpss_json2_func_call($method, $id, $params = Array(), $url = "http://82.79.70.124/jsrpc.php") {
	$request = array('jsonrpc' => '2.0',
		                 'id' => $id,
		                 'method' => $method,
		                 'params' => $params);
	$response = wpss_json2_post($url, $request);
	return $response;
}

function wpss_scanner_download($id, $url = "http://82.79.70.124/download.php") {
	$scanner = wpss_http_request($url . "?id=$id", "", 'application/octet-stream', 'GET');
	return $scanner;
}

/*** checks $response for errors; returns true if there were errors, false otherwise. ***/
function wpss_json2_is_error($response) {
	if ($response === false) return true;
	if (isset($response['error'])) return true;
	if ($response['result'] === false) return true;
	if ((isset($response['result']['on'])&&($response['result']['on']!==true))) return true;
	return false;
}

/*** checks $response for errors; returns a string if there were errors, false otherwise. ***/
function wpss_json2_get_error($response) {
	if (($response === false) || ((isset($response['result']))&&($response['result'] === false)))
		return "An error occurred, go to your <a href='http://dashboard.websitedefender.com/'>Dashboard</a> for support.\n";
	if (is_array($response['error'])) {
		$e = $response['error'];		
		if (($response['error']['code'] == 38) &&
			($response['error']['message'] == 'Website already registered.'))
				return 'This website is registered, login to your <a href="http://dashboard.websitedefender.com/">Dashboard</a>.';
		else
			return "Error code {$e['code']}: {$e['message']}, go to your <a href='http://dashboard.websitedefender.com/'>Dashboard</a> for support.\n";
	}
	if (isset($response['result']['on'])&&($response['result']['on']!=true))
		return $response['result']['reason'];
	return false;
}

function wpss_get_hostname() {
	if (isset($_SERVER['SERVER_NAME'])) {
		return $_SERVER['SERVER_NAME'];
	} else {
		$url = parse_url(get_option('siteurl'));
		if (is_array($url)&&isset($url['host']))
			return $url['host'];		
	}
	return false;
}

?>
