=== Plugin Name ===
Contributors: ev3rywh3re
Donate link: http://funroe.net/contribute/
Tags: post, TinyMCE, editor, wysiwyg, buttons, formatting, admin
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 2.3.8

Get control of the WordPress wysiwyg visual editor and add some functionality with more buttons and custom TinyMCE plugins.

== Description ==

WP Super Edit is designed to get control of the WordPress wysiwyg visual editor and add some functionality with more buttons and customized TinyMCE plugins. WP Super edit acts as framework for TinyMCE visual editor plugins and buttons allowing administrators (or users) to arrange buttons and add TinyMCE plugins to the visual editor.

Your feedback is always welcome!

Current release announcement: [http://funroe.net/projects/2010/09/25/wp-super-edit-2-3/](http://funroe.net/projects/2010/09/25/wp-super-edit-2-3/)

**Features**

* Drag and Drop interface for arranging the WordPress visual editor buttons.
* Access to built-in WordPress visual editor buttons and functions. 
* Additional TinyMCE plugins to add buttons and features like tables, layers (div tag), advanced XHTML properties, advanced image and link properties, WordPress emoticons, style attributes, css classes for themes, search / replace, and more.
* Options for allowing users to configure visual editor settings; One editor setting for all users, role based editor settings, and individual user editor settings. **Only WordPress administrators can activate or deactivate TinyMCE wysiwyg visual editor plugins. In single or role based modes, only administrators can arrange editor buttons.**
* Easy to install and remove. WP Super Edit uses separate database tables for settings and to support multi-site configurations. Currently only the **Super Emoticon / Icon Plugin** will leave short tags in your posts or pages. 

**More Information & Documentation**

* For detailed information, visit the **[WP Super Edit project](http://funroe.net/projects/super-edit/)**
* For in depth documentation visit **[Using WP Super Edit](http://funroe.net/projects/super-edit/using/)**

**Version Notice**

This version has been tested for use with the versions of WordPress indicated. I attempt to keep WP Super Edit up to date with changes to WordPress and the visual editor, but the complex changes can make it unproductive to maintain compatiblity with some older versions of WordPress. This is a list of recent versions available for older WordPress sites.

* Use WP Super Edit 2.1 for WordPress 2.6 to 2.7.1 

**[Download Older Versions of WP Super Edit](http://wordpress.org/extend/plugins/wp-super-edit/download/)**

== Installation ==

1. Take the whole whole **wp-super-edit** folder and put it in the **WordPress Plugin** directory for your Web site. 
2. Activate the plugin on the Wordpress Plugins administration panel
3. Click on the Settings option and you will see WP Super Edit in the sub menu.
4. WP Super Edit should lead you through the final installation steps. **Please be patient!** WP Super Edit will attempt to scan and save your original wysiwyg visual editor settings while installing. WP Super Edit will not work until the installation has been completed!

== Upgrade Notice ==

**Versions 1.5 or earlier:**

Before you install WP Super Edit, you should deactivate the old version of WP Super Edit and remove the superedit folder from WordPress Plugin folder for your WordPress installation. Follow the installation instructions for the updated version. The updated version should use the wp-super-edit folder in the WordPress Plugin folder and be more compatible and easier to update in the future. Due to the changes in the WordPress editor your old settings will not be updated for the new version of WP Super Edit.

* For in depth documentation visit **[Using WP Super Edit](http://funroe.net/projects/super-edit/using/)**

== Frequently Asked Questions ==

= Can this be used in my language? =

Yes! It may require some work. You can check out the documentation at **[Using WP Super Edit](http://funroe.net/projects/super-edit/using/)**

== Screenshots ==

1. WordPress editor with all buttons activated.
2. WP Super Edit settings.
3. Drag and drop button settings.

== Changelog ==

**Visit the [WP Super Edit Bugs, Feature Requests & Change Log](http://funroe.net/projects/super-edit/using/) for more information about changes, current issues, and planned development.**

= 2.3.8 =
* Fix Custom CSS Classes plugin supporting multiple CSS files thanks @atomas

= 2.3.7 =
* Use plugin_url() for better multi-site and domain mapping support

= 2.3.6 =
* Cleanup effort to remove warnings and depreciated functions
* minor fixes for Theme Class sub-plugin

= 2.3 =
* WordPress 3.0.1 support (beta multi-site support)
* Removing callback functionality, so additional TinyMCE external plugins can be added by building independent WordPress plugins.
* uninstall.php to do the right thing when you delete this crap. 
* Moved Super-CSS-Classes and Super-Emoticons to separate plugins in this package.
* A hopefully a better method of setting up default TinyMCE settings.

= 2.2 =
* WordPress 2.8 compatibility fixes.
* Big cleanup to move some of the interface class functions to normal php functions.
* A bug fix from vituko that should work better with some server setups.
* Removed backwards compatibility checks because several changes to TinyMCE and WordPress make backwards compatibility prohibitive to maintain.
* It is now using jQuery UI scripts that ship with WordPress. No more stupid big JS downloads for button settings.
* Updates to most of the packaged TinyMCE plugins for TinyMCE 3.2.4.1 (that is a bunch of dots)

= 2.1 =
* A bonus backport added as suggested by vituko that should make things work on more server setups.
* Add font tag styling options for font face, size, etc as requested in wordpress.org forums.
* Fix missing bad javascript URL for admin interface.
* Switch to template_redirect method for settings scanning using a pseudo tinymce init.
* Do version checks and remove javascript caching options for WordPress 2.7.
* Clean up CSS for WordPress 2.7

= 2.0.x and Earlier =
* Sorry didn't keep good notes for these changes. WP Super Edit 2.0 was a major rewrite to make this plugin compatible with WordPress 2.5 to 2.6.
	