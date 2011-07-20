=== google-ajax-libraries-api-plugin ===
Contributors: cafespain
Donate link: http://blog.clearskys.net/
Tags: google, ajax, admin, api, library
Requires at least: 2.2.0
Tested up to: 2.6.1
Stable tag: 0.9

This plugin switches your WordPress blog to use the Google hosted AJAX libraries instead of your locally hosted versions without the need to modify your themes or plugins.

== Description ==

The Google Ajax Libraries API Plugin is designed to make it easy to use the Google hosted libraries without the need to mess with your theme and plugin code.

When activated, the plugin will “listen” to all of the scripts added (via the WordPress wp_enqueue_script function) to your pages header and automagically switch the locally hosted library to a Google hosted one. Deactivating the plugin will remove the “listener” and your site will return to using the local versions.

WordPress MU administrators should copy the plugin into their MU-Plugins directory for it to be enabled across all of your hosted blogs.

== Installation ==

Installing this plugin should be very straightforward by following the steps below:

1. Download the plugin and un-zip it.
2. Upload the usegooglelibrary.php file into your wp-content/plugins directory.
3. Login to your WordPress sites administration panel and go the the Plugins menu.
4. Click the activate link next to the Use Google Library Javascript plugin.

WordPress MU adminsistrators should copy the plugin into their MU-plugins directory in order for it to be activated for all of their hosted blogs.

== Frequently Asked Questions ==

= Can I have jQuery and prototype loaded at the same time? =

Yes, from version 0.6 onwards the plugin checks if both jQuery and Prototype are to be loaded and adds the relevant code to enable both to function together.

= Why are some of my libraries are still loaded locally =

The plugin will only switch libraries that have been loaded using the WordPress wp_enqueue_script method. Any libraries that are hard-coded into theme headers or plugins will not be modified. If you are using a custom theme - consider loading your javascript using the wp_enqueue_script method as this will also ensure that the library is not loaded more than once by other plugins, etc..

= What libraries can be switched? =

The plugin looks for and switches the following libraries:
* Prototype
* jQuery
* Moo
* Scriptaculous