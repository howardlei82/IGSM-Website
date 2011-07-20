=== d13slideshow ===
Contributors: d13design
Donate link: http://www.d13design.co.uk/d13slideshow/
Tags: image, slideshow, promote, feature, promotion
Requires at least: 2.0.2
Tested up to: 2.8.4
Stable tag: 2.2.0

Add animated slideshows of your featured pages and posts.

== Description ==

D13Slideshow is a plugin that will create an animated promo slideshow as part of your WordPress blog. You can use it to promote any pages or posts in your site and it is fully customisable through the admin pages of your blog. Unlike some other slideshow components, D13Slideshow makes use of the script.aculo.us and Prototype JavaScript frameworks.

Once added, your slideshow will animate through each of your chosen features providing an image, an extract and a link. Once all featured stories have been shown, the slideshow will pause and provide 'next' and 'back' buttons allowing visitors to cycle through them.

= Fixes, features and additions =
Version 2.2.0 includes changes to support the requests from users:

1. Better selection of featured images, not just custom fields
1. Better resizing and positioning of featured images

Version 2.0.0 includes numerous feature requests and general fixes:

1. The ability to select posts by dropdown or text entry
1. Improved HTML and CSS
1. Improved support for Internet Explorer (if you can test in IE6 or IE8 then let me know!)
1. Improved embedding of Javascript libraries
1. Refined admin screens
1. Customisable CSS
1. Use post excerpts if available
1. Feature sticky posts
1. Feature posts from a specified category (thanks to Jordan at uncharteddesign.com)
1. Override system settings and specify posts to feature when adding the PHP code

Version 1.1.0 includes some long overdue features, primarily:

1. Automatic inclusion of the Scriptaculous and Prototype javascript files
1. Optional include files (d13slideshow.php lines 118 and 119) for choosing posts by dropdown or text field - fixes the "non-loading admin page" bug when you have lots of posts

Version 1.0.2 includes some requested additions and a few bug fixes:

1. A failsafe image if you incorrectly set your custom fields
1. Removal of HTML from post extracts
1. Some fixes made to excessive DB calls in the admin pages
1. Better use of absolute blog path URLs
1. Options to cycle once, cycle continuously or cycle manually
1. Options to automatically promote your last 5 or 10 posts
1. Use of permalinks rather than GUIDs for featured story links
	
== Installation ==

1. Begin by downloading the plugin file using the link above.
1. Extract the files to your local machine.
1. Edit lines 15 and 16 of "d13slideshow.php" to determine how posts will be selected
1. Upload the whole d13slideshow folder (including the folder itself) to your plugins directory (typically http://www.yourblog.com/wp-content/plugins/)
1. Activate the plugin using your Wordpress admin pages.
1. Familiarise yourself with the documentation under settings > d13slideshow'
1. Get cracking!

== Frequently Asked Questions ==

= How do I add my slideshow to my theme? =

Adding slideshows to your themes is incredibly easy and just requires one line of PHP code. You can introduce your slideshow as part of any of your theme files using the following code:

&lt;?php d13slideshow(); ?&gt;

Some of the key places you could add your slideshow include:

1. Your home page - add the code to index.php
1. In your sidebar - add the code to sidebar.php
1. In your header - add the code to header.php

= How do I choose which posts to feature? =

Your slideshows can feature up to 10 different posts or pages and these can be set using the 'Features' section of your d13slideshow options page. In your WordPress admin pages choose 'settings > d13slideshow' and use the select boxes to choose which posts to feature.

= How do I set up images for my featured posts? =

D13Slideshows use custom fields within your posts or pages to determine which images to use. Just set up a custom field with the key 'promoimage' and the value as an absolute URL for an uploaded image.

For example...

KEY: promoimage

VALUE: http://www.d13design.co.uk/promo/daves-wedding.jpg

Just be sure that your promo images are the same size as the slideshow (set in your options page).

= How do I link to external sites from my slides? =

As of version 2.0.0 external links can be supplied for the slideshow to use rather than the permalink of the featured post. These external links are added using an extra custom field.

For example:

KEY: promourl

VALUE: http://www.daveswedding.com

= How do I define a specific playlist each time I use the d13slideshow() command? =

As of version 2.0.0 you can add additional arguments when you embed the slideshow command within your theme. If, for example, you want your homepage slidehow to run on your admin settings, feature posts 3, 7 and 9 on your pages and posts 5, 19 and 22 on single post pages you could add:

&lt;?php d13slideshow(); ?&gt; to index.php,

&lt;?php d13slideshow( array(3,7,9) ); ?&gt; to page.php and

&lt;?php d13slideshow( array(5,19,22) ); ?&gt; to single.php.

= How do I add the Scriptaculous Javascript to my theme? =

As of plugin version 1.1.0 you no longer need to do this manually. Wordpress comes with these Javascript libraries and the plugin now adds these to your theme automatically.

= The admin page never fully loads - how do I use the plugin? =

This is generally an issue for blogs with a lot of posts. The admin screen loads all of your posts into a dropdown list for you to select them from, if you have lots of posts then the database connection times out and the page never loads.

Version 2.0.0 of the plugin contains 2 options for selecting posts - dropdown lists and text entry for manually adding post or page IDs.

On lines 15 and 16 of d13slideshow.php you'll find 2 statements, just comment out the one you don't want to use.

== Screenshots ==

1. An example of a d13slideshow.
2. An example of a d13slideshow (full).
3. The d13slideshow admin screen.
4. The d13slideshow help content.
5. An example of adding custom fields to a post.

