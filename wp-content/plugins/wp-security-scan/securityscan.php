<?php
/*
Plugin Name: WP Security Scan
Plugin URI: http://www.websitedefender.com/news/free-wordpress-security-scan-plugin/

Description: Perform security scan of WordPress installation.
Author: WebsiteDefender
Version: 3.0.1
Author URI: http://www.websitedefender.com/
*/

/*
Copyright (C) 2008-2010 Acunetix / http://www.websitedefender.com/
(info AT websitedefender DOT com)


This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
      
//main files
if(!function_exists('json_encode'))
  require_once(WP_PLUGIN_DIR . "/wp-security-scan/json.php");

require_once(WP_PLUGIN_DIR . "/wp-security-scan/support.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/scanner.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/password_tools.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/database.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/functions.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/recaptchalib.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/wsd.php");

//menus
require_once(WP_PLUGIN_DIR . "/wp-security-scan/inc/admin/security.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/inc/admin/scanner.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/inc/admin/pwtool.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/inc/admin/db.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/inc/admin/support.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/inc/admin/templates/header.php");
require_once(WP_PLUGIN_DIR . "/wp-security-scan/inc/admin/templates/footer.php");

//## this will pop up on admin login
add_action( 'admin_notices', 'mrt_update_notice', 5 );

//## this is the container for header scripts
add_action('admin_head', 'mrt_hd');

//before sending headers
add_action("init",'mrt_wpdberrors',1);

//after executing a query
add_action("parse_query",'mrt_wpdberrors',1);

//##pentru a adauga meniuri extra dupa panoul admin
add_action('admin_menu', 'add_men_pg');

add_action("init", 'mrt_remove_wp_version',1);   //comment out this line to make ddsitemapgen work

//before rendering each admin init
add_action('admin_init','mrt_wpss_admin_init');


function mrt_wpss_admin_init(){
	wp_enqueue_style('mrt_wpss_style',WP_PLUGIN_URL . '/wp-security-scan/css/style.css');
	wp_enqueue_style('wsd_style', WP_PLUGIN_URL . '/wp-security-scan/css/wsd.css');
}

remove_action('wp_head', 'wp_generator');
function add_men_pg() {
         if (function_exists('add_menu_page')){
            add_menu_page('Security', 'Security', 'edit_pages', __FILE__, 'mrt_opt_mng_pg');

            add_submenu_page(__FILE__, 'Scanner', 'Scanner', 'edit_pages', 'scanner', 'mrt_sub0');
            add_submenu_page(__FILE__, 'Password Tool', 'Password Tool', 'edit_pages', 'passwordtool', 'mrt_sub1');
            //add_submenu_page(__FILE__, 'Database', 'Database', 'edit_pages', 'database', 'mrt_sub3');
            add_submenu_page(__FILE__, 'Support', 'Support', 'edit_pages', 'support', 'mrt_sub2');
         }
}

function wpss_admin_head() {
	$scheme = 'http';
	if ( is_ssl() )
		$scheme = 'https';
?>
	<style type="text/css">
		#toplevel_page_wp-security-scan-securityscan div.wp-menu-image {
			background: url(<?php echo WP_PLUGIN_URL; ?>/wp-security-scan/images/wpss_icon_small_combined.png) center top no-repeat;
		}

		#toplevel_page_wp-security-scan-securityscan.current div.wp-menu-image,
		#toplevel_page_wp-security-scan-securityscan:hover div.wp-menu-image {
			background-position: center bottom;
		}
	</style>
<?php
}
add_action( 'admin_head', 'wpss_admin_head' );


// function for WP < 2.8
function get_plugins_url($path = '', $plugin = '') {

  if ( function_exists('plugin_url') )
    return plugins_url($path, $plugin);

  if ( function_exists('is_ssl') )
    $scheme = ( is_ssl() ? 'https' : 'http' );
  else
    $scheme = 'http';
  if ( function_exists('plugins_url') )
    $url = plugins_url();
  else
    $url = WP_PLUGIN_URL;
  if ( 0 === strpos($url, 'http') ) {
    if ( function_exists('is_ssl') && is_ssl() )
      $url = str_replace( 'http://', "{$scheme}://", $url );
  }

  if ( !empty($plugin) && is_string($plugin) )
  {
    $folder = dirname(plugin_basename($plugin));
    if ('.' != $folder)
      $url .= '/' . ltrim($folder, '/');
  }

  if ( !empty($path) && is_string($path) && strpos($path, '..') === false )
    $url .= '/' . ltrim($path, '/');

  return apply_filters('plugins_url', $url, $path, $plugin);
}


function mrt_update_notice()
{
}

function wpss_mrt_meta_box()
{  
?>
	<div id="wsd-initial-scan" class="wsd-inside">
		<div class="wsd-initial-scan-section">
			<?php mrt_check_version();?>
		</div>

		<div class="wsd-initial-scan-section">
			<?php mrt_check_table_prefix();?>
		</div>

		<div class="wsd-initial-scan-section">
			<?php mrt_version_removal();?>
		</div>

		<div class="wsd-initial-scan-section">
			<?php mrt_errorsoff();?>
		</div>
<?php
		global $wpdb;

		echo '<div class="scanpass">WP ID META tag removed form WordPress core</div>';

		echo '<div class="wsd-initial-scan-section">';
		$name = $wpdb->get_var("SELECT user_login FROM $wpdb->users WHERE user_login='admin'");
		if ($name == "admin")
			echo '<a href="http://semperfiwebdesign.com/documentation/wp-security-scan/change-wordpress-admin-username/" title="WordPress Admin" target="_blank"><font color="red">"admin" user exists.</font></a>';
		else
			echo '<font color="green">No user "admin".</font>';
		echo '</div>';

		echo '<div class="wsd-initial-scan-section">';
		$filename = '.htaccess';
		if (file_exists($filename))
		    echo '<font color="green">.htaccess exists in wp-admin/</font>';
		else
		    echo '<font color="red">The file .htaccess does not exist in wp-admin/.</font>';
		echo '</div>';

		?>

		<div class="mrt_wpss_note">
			<em>**WP Security Scan plugin must remain active for security features to remain**</em>
		</div>
	</div>
<?php
}

	
function wpss_mrt_meta_box2()
{
?>
	<ul id="wsd-information-scan-list"">
		<?php mrt_get_serverinfo(); ?>
	</ul>
<?php
}
	
function mrt_hd()
{
?>
	<script language="JavaScript" type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/wp-security-scan/js/json.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/wp-security-scan/js/md5.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/wp-security-scan/js/scripts.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/wp-security-scan/js/wsd.js"></script>
	<script type="text/javascript">
		var wordpress_site_name = "<?php echo htmlentities(get_bloginfo('siteurl'));?>"
	</script>
	<script type="text/javascript">
	  var _wsdPassStrengthProvider = null;

	  jQuery(document).ready(function($) {
		_wsdPassStrengthProvider = new wsdPassStrengthProvider($);
		_wsdPassStrengthProvider.init();

		$('#wpss_mrt_1.postbox h3, #wpss_mrt_2.postbox h3, #wpss_mrt_3.postbox h3').click(function() {
			var parent = $(this).parent();
			if (parent) parent.toggleClass('closed');
		});
		$('#wpss_mrt_1.postbox .handlediv, #wpss_mrt_2.postbox .handlediv, #wpss_mrt_3.postbox .handlediv').click(function() {
			var parent = $(this).parent();
			if (parent) parent.toggleClass('closed');
		});
		$('#wpss_mrt_1.postbox.close-me, #wpss_mrt_2.postbox.close-me, #wpss_mrt_3.postbox.close-me').each(function() {
			$(this).addClass("closed");
		});
	  });
	</script>
<?php }
?>
