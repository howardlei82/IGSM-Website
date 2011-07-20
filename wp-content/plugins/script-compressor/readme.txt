=== Script Compressor ===
Contributors: Regen
Tags: compress, javascript, css
Requires at least: 2.5
Tested up to: 2.8.4
Stable tag: 1.7.1

This plugin compresses javascript files and css files.

== Description ==

This plugin compresses javascript files and CSS files loaded by the theme or other plugins automatically.
Extra spaces, lines, and comments will be deleted.
The compressor is based on [jscsscomp](http://code.google.com/p/jscsscomp/).

= Features =

* Auto-compression for the blog header.
* Template tags which provide javascript compression.
* You can turn on/off compressions in the admin page.
* Editable CSS compression condition.
* You can select where to output scripts.
* You can exclude scripts from the compression if necessary.

== Installation ==

1. Upload the extracted plugin folder and contained files to your /wp-content/plugins/ directory
2. Give the write permission to /wp-content/plugins/script-compressor/cache
   **(Changed since version 1.4)**
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Navigate to Settings -> Script Compressor

== Frequently Asked Questions ==

= CSS does not work! =
After opening CSS directly by your browser, do super-reloading (Ctrl+F5).

= After the deactivation of this plugin, the blog style is broken! =
The mod_rewrite codes may remain in your .htaccess.
Please delete these lines in your .htaccess:

	RewriteEngine on
	RewriteRule ^(.*)\.css$ /path-to-wp/wp-content/plugins/script-compressor/jscsscomp.php?q=$1.css [NC,L]

== Screenshots ==

1. A part of the admin page.

== Changelog ==

= 1.7.1 =
* Fixed IE conditional comment bug.
* Fixed regex bug.

= 1.7 =
* Added @import compression.
* Added a new function "Remove cache files".

= 1.6.3 =
* Added some document about the deactivation.

= 1.6.2 =
* Fixed Javascript position bug.

= 1.6.1 =
* Added the auto-compression of theme scripts.

= 1.6 =
* Added a new option "Exclude Javascripts".
* Added a new option "Output Position".

= 1.5.1 =
* WordPress2.7 support.

= 1.5 =
* Addied a new option "Position of Javascripts".

= 1.4.4 =
* Fixed a bug about the condition of CSS compression.

= 1.4.3 =
* Fixed a bug about .htaccess.
* Added a .htaccess permission check.

= 1.4.2 =
* Fixed a bug CSS compression cannot be deactivated.
* Added a permission check message.

= 1.4.1 =
* Fixed a bug admin css files breaking.

= 1.4 =
* Added a new CSS compression method.
* Added a Gzip option.
* Changed the output charset into that of WP.

= 1.3.1 =
* Maked external Javascripts not picked up.
* Some bug fixs.

= 1.3 =
* Maked .htaccess in this plugin unnecessary.

= 1.2 =
* Fixed a bug that URL with parameters breaks output.

= 1.1.1 =
* Added CSS compression condition.

= 1.1 =
* Added a selecting charaset function.
* Improved Javascript regex.

= 1.0 =
* Initial release.