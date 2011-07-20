<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="distribution" content="global" />
	<meta name="robots" content="index, follow" />
	<meta name="revisit-after" content="2 days" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<title><?php bloginfo('name'); wp_title(); ?></title>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/script_quicktags.js"></script>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />
	<?php //comments_popup_script(); // off by default ?>
<style type="text/css" media="screen">
		<!-- @import url( <?php bloginfo('stylesheet_url'); ?> ); -->
</style>
<?php if (function_exists('sc_comp_start')) sc_comp_start() ?>
	<?php wp_head(); ?>
<?php if (function_exists('sc_comp_end')) sc_comp_end() ?>
</head>

<body id="home" class="log">
<div id="containerheader"><!-- begin #igsm_header -->
	<div id="ism_logo">
		<h1><?php  bloginfo('name'); ?></h1>
		<a title="<?php bloginfo('name'); ?>: Home" href="<?php bloginfo('siteurl'); ?>">
		<img border="0" alt="International Graduate Student Ministry Logo - Berkeley Graduate Students Group" src="<?php bloginfo('template_directory'); ?>/img/banner2.jpg"/>
		</a>
	</div>
	<div id="splash_message">love locally, impact globally</div>
</div><!-- end #ism_header -->
<div id="containerbody">
<?php wp_nav_menu('Main Menu'); ?>
