=== WP CSS ===
Tags: css, caching, optimization, gzip, modular css, plugin, post, posts
Requires at least: 2.5.1
Tested up to: 2.6.2
Stable tag: 2.0.5

GZIP and strip whitespace from your CSS files. Add specific CSS files to post/pages. Development of modular CSS without the making the user download several CSS files.

== Description ==

This plugin GZIP and strip whitespace from your CSS files. It allows you to confidently use @import inside a CSS file and not worry about what happens on the user's end. It will look through your style.css file and put any @import files into it. A cache expiry time can also be set.

NEW:
* SECURITY PATCH - please update the plugin. (Thanks to Dario Caregnato)
* Will now work with Child Themes (Thanks to Wupperpirat)

Now in version 2.0 you can add CSS files to a specific page or post and putting all of them into one file.

Version 2.0

* Ability to add CSS files to specific page/post
* Improved security
* Reduced URL outputted

The default `style.css` is scanned automatically.

Using WP CSS with other CSS files:

`<link rel="stylesheet" href="<?php wp_css('path/to/css/file.css'); ?>" type="text/css" media="screen" />`

OR you can also concatenate CSS files (comma separated):

`<link rel="stylesheet" href="<?php wp_css('path/to/js/file.css, path/to/js/file2. css, path/to/js/file3. css'); ?>" type="text/css" media="screen" />`

OR you can use `@import` method inside a CSS file to group CSS files:

`
@import url('css/reset.css');
@import url('css/typography.css');
@import url('css/form.css');
@import url('css/list.css');
@import url('css/layout.css');
@import url('css/menu.css');
@import url('css/buttons.css');
@import url('css/special.css');
@import url('css/javascript.css');
`

Visit the WP CSS site for more information: http://www.halmatferello.com/lab/wp-css/

Try the JavaScript version of the this plugin: http://wordpress.org/extend/plugins/wp-js/


== Installation ==

1. Upload `wp-css` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Set the permissions for `/wp-css/` folder to `777`
1. Go to Settings > WP CSS in the admin site. This setup the plugin.
1. Your default stylesheet (style.css) is automatically scanned
1. Use `<?php wp_css('path/to/css/file.css'); ?>` to link to other css files

i.e. `<link rel="stylesheet" href="<?php wp_css('path/to/css/file.css'); ?>" type="text/css" media="screen" />`

== Screenshots ==

1. Tests were measured using a Firefox plugin called Firebug. Firefox was run a Mac Pro (2008) using OS X 10.5.3. Eight CSS files were include in this test: typography.css, form.css, list.css, special.css, skin.css, menu.css, other.css, sIFR-screen.css - all created to simulate an average size of a typical website.

2. The default style.css will be automatically picked up by the plugin. `<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />`

3. Adding other css files. `<link rel="stylesheet" href="<?php wp_css('services.css'); ?>" type="text/css" media="screen" />`

4. The admin section

5. Add a CSS file into a specific page.

== Frequently Asked Questions ==

= How do I write the URL to my CSS file inside the wp_css() function? =

All URLs must be relative to your current theme. So for example:

If your current theme was the default and you had forms.css file inside folder called css. You would write the following

`<link rel="stylesheet" href="<?php wp_css('forms.css'); ?>" type="text/css" media="screen" />`


= Can I suggest an feature for the plugin? =

Of course, visit <a href="http://www.halmatferello.com/lab/wp-css/">WP CSS Home Page</a>

= Are you available for hire? =

Yes I am, visit my <a href="http://www.halmatferello.com/services/">services</a> page to find out more.