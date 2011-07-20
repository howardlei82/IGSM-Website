=== Moderate New Blogs ===
Contributors: dsader
Donate link: http://dsader.snowotherway.org
Tags: moderate, new blogs, moderation, multisite,
Requires at least: 3.0
Tested up to: 3.0
Stable tag: Trunk

WP3.0 multisite "mu-plugin". New blogs(aka sites) await a final click from a Super Admin to activate.

== Description ==
WP3.0 multisite "mu-plugin". New blogs(aka sites) await a final click from a Super Admin to activate. Keep blog registration enabled and open, keep Super Admin email notices enabled, and this plugin flags new blogs in SuperAdmin-->Sites as "Awaiting Moderation". 

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `ds_wp3_moderate_new_blogs.php` to the `/wp-content/mu-plugins/` directory
2. Look for new blogs with "Awaiting Moderation" action at SuperAdmin->Sites page

Optional: 
To change the default message for an inactive blog use your own drop-in plugin as described in wp-includes/ms-load.php:
	`if ( file_exists( WP_CONTENT_DIR . '/blog-inactive.php' ) )
			return WP_CONTENT_DIR . '/blog-inactive.php';`

== Frequently Asked Questions ==

* Will this plugin stop spammer blogs? No.

== Changelog ==
= 3.0.0 = 

initial release

== Upgrade Notice ==
= 3.0.0 = 

initial release