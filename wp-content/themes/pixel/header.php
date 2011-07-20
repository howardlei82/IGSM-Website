<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"  />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<meta name="robots" content="follow, all" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- this product is released under General Public License. Please see the attached file for details. You can also find details about the license at http://www.opensource.org/licenses/gpl-license.php -->

<!--[if lt IE 8]>
<link href="<?php bloginfo('template_url'); ?>/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lt IE 7]>
<link href="<?php bloginfo('template_url'); ?>/ie6.css" rel="stylesheet" type="text/css" />
<script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script>
<![endif]-->

<?php wp_enqueue_script( 'sfhover', get_template_directory_uri() . '/js/sfhover.js' ); ?>
<?php wp_head(); ?>
</head>

<body>
<div id="wrapper">

<div id="header">

<div id="topright">
<ul>
  <?php wp_list_pages('depth=1&title_li=0&sort_column=menu_order'); ?>
  <li><a href="#searchform">search</a></li>
  <li><a href="#main">skip to content &darr;</a></li>
</ul>
</div>
<div class="cleared"></div>

<div id="logo">
<h1><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>
<span><?php bloginfo('description'); ?></span>
</div>

</div> <!-- Closes header -->



<div id="catnav">
<div id="toprss"><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/rss-trans.png" alt="<?php bloginfo('name'); ?>" width="65" height="24" /></a></div> <!-- Closes toprss -->
<ul id="nav">
  <li><a href="<?php echo get_option('home'); ?>">Home</a></li>
  <?php wp_list_categories('sort_column=name&title_li=&depth=2'); ?>
</ul>
</div> <!-- Closes catnav -->

<div class="cleared"></div>
