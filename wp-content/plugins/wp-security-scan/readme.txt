=== Plugin Name ===
Contributors: WebsiteDefender
Author: WebsiteDefender
Tags: security, securityscan, chmod, permissions, admin, administration, authentication, database, dashboard, post, notification, password, plugin, posts, wsd, websitedefender,
plugins, private, protection, tracking, wordpress
Requires at least: 2.5
Tested up to: 3.1.3
Stable tag: trunk
  
Scans your WordPress installation for security vulnerabilities.

== Description ==

WP Security Scan checks your WordPress website/blog for security vulnerabilities and suggests corrective actions such as:

1. Passwords
2. File permissions
3. Database security
4. Version hiding
5. WordPress admin protection/security
6. Removes WP Generator META tag from core code

= Requirements =

* WordPress version 2.6 and higher (tested at 3.1)
* PHP5 (tested with PHP Interpreter >= 5.2.9)

For more information on the WP Security Scan and other WordPress security news, visit the <a href="http://www.websitedefender.com/blog" target="_blank">WebsiteDefender Blog</a> and join our <a href="http://www.facebook.com/websitedefender" target="_blank">Facebook</a> page. Post any questions or feedback on the <a href="http://www.websitedefender.com/forums/wp-security-scan-plugin/" target="_blank">WP Security Scan plugin forum</a>.


== Installation ==

1. Make a backup of your current installation
2. Unpack the download package
3. Upload the extracted files to the /wp-content/plugins/ directory
4. Activate the plugin through the 'Plugins' menu in WordPress

If you do encounter any bugs, or have comments or suggestions, please contact the WebsiteDefender team on support@websitedefender.com.

For more information on the WP Security Scan and other WordPress security news, visit the <a href="http://www.websitedefender.com/blog" target="_blank">WebsiteDefender Blog</a> and join our <a href="http://www.facebook.com/websitedefender" target="_blank">Facebook</a> page. Post any questions or feedback on the <a href="http://www.websitedefender.com/forums/wp-security-scan-plugin/" target="_blank">WP Security Scan plugin forum</a>.

== Changelog ==

= v3.0.1 (03/24/2011) =
* Regression: Temporarily disabled database change feature
* Fixed: Resolved conflict with plugins using the reCAPTCHA library
* Bugfix: Fixed CSS image background not showing corectly

= v3.0.0 (03/22/2011) =
* Feature: Release new stable version
* Feature: Rebranding of the plugin
* Feature: Integrated WebsiteDefender.com registration in Settings

For more information on the WP Security Scan and other WordPress security news, visit the <a href="http://www.websitedefender.com/blog" target="_blank">WebsiteDefender Blog</a> and join our <a href="http://www.facebook.com/websitedefender" target="_blank">Facebook</a> page. Post any questions or feedback on the <a href="http://www.websitedefender.com/forums/wp-security-scan-plugin/" target="_blank">WP Security Scan plugin forum</a>.

== Frequently Asked Questions ==

= Can I deactivate WP Security Scan once I've run it once? =

No.  WP Security Scan needs to be left activated to work.  Version hiding,
turning off DB errors, removing WP ID META tag from HTML output, and other
functionality will cease if you deactivate the plugin.

= How do I change the file permissions on my WordPress installation?  =

From the Linux command line (for advanced users):
    chmod xxx filename.ext
    (replace xxx with with the permissions settings for the file or folder).

From your FTP client:
    Most FTP clients, such as filezilla, etc, allow for changing file
permissions.  Please consult your client's documentation for your specific
directions.

For more information, please visit http://codex.wordpress.org/Changing_File_Permissions

= Why do I need to hide my version of WordPress?  =

Many attackers and automated tools will try and determine software versions
before launching exploit code. Removing your WordPress blog version may
discourage some attackers and certainly will mitigate virus and malware programs
that rely on software versions.

NOTE: Hiding your version of WordPress may break any plugins you have which
are version dependant.

= How do I make Dagon Design's sitemap generator plugin compatible? =
There is currently a small compatibility issue.  This can be temporarily
solved by opening securityscan.php and commenting out the line
`add_action("init",mrt_remove_wp_version,1);`


For more information on the WP Security Scan and other WordPress security news, visit the <a href="http://www.websitedefender.com/blog" target="_blank">WebsiteDefender Blog</a> and join our <a href="http://www.facebook.com/websitedefender" target="_blank">Facebook</a> page. Post any questions or feedback on the <a href="http://www.websitedefender.com/forums/wp-security-scan-plugin/" target="_blank">WP Security Scan plugin forum</a>.

== Screenshots ==

1. file/directories permissions check
2. password tools

== WordPress Security ==

Security Scanner:

1. Scans Wordpress installation for file/directory permissions vulnerabilites
2. Recommends corrective actions
3. Scans for general security vulnerabilities


For more information on the WP Security Scan and other WordPress security news, visit the <a href="http://www.websitedefender.com/blog" target="_blank">WebsiteDefender Blog</a> and join our <a href="http://www.facebook.com/websitedefender" target="_blank">Facebook</a> page. Post any questions or feedback on the <a href="http://www.websitedefender.com/forums/wp-security-scan-plugin/" target="_blank">WP Security Scan plugin forum</a>.