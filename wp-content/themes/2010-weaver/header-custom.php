<?php
/**
 * The Cuatom Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', TTW_TRANS ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed"> <!-- CUSTOM HEADER TEMPLATE -->

    <div id="header">
	<div id="masthead">
	    <div id="branding" role="banner">
		<?php
		if (!ttw_getopt('ttw_hide_custom_header_template_siteinfo')) {	/* TTW - hide site title */ ?>
		    <?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
		    <<?php echo $heading_tag; ?> id="site-title">
			<span><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
			</<?php echo $heading_tag; ?>>
			<div id="site-description"><?php bloginfo( 'description' ); ?></div>
		<?php } /* end hide site title if */ ?>
		<?php
		if (!ttw_getopt('ttw_hide_custom_header_template_menus') && ttw_getopt('ttw_move_menu')) { 	/* TTW: move header */ ?>
		    <div id="access" role="navigation">
		    <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
			<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', TTW_TRANS ); ?>"><?php _e( 'Skip to content', TTW_TRANS ); ?></a></div>
		    <?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position
		             is the one used. If none is assigned, the menu with the lowest ID is used.  */ ?>
		    <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
		    </div><!-- #access -->
		<?php } ?>
		<?php
		if (!ttw_getopt('ttw_hide_custom_header_template_menus') && !ttw_getopt('ttw_move_menu')) { 	/* don't move header */ ?>
		    <div id="access2" role="navigation">
		    <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
			<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', TTW_TRANS ); ?>"><?php _e( 'Skip to content', TTW_TRANS ); ?></a></div>
		    <?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position
		             is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
		    <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'secondary', 'fallback_cb' => '' ) ); ?>
		    </div><!-- #access2 -->
		<?php } ?>
		<?php
		if (ttw_getopt('ttw_custom_header_insert')) {	/* header insert defined? */
		    	echo (do_shortcode(str_replace("\\", "", ttw_getopt('ttw_custom_header_insert'))));
		}

		// The Dynamic Headers shows headers on a per page basis - will also optionally add site link
		if(function_exists('show_media_header')) show_media_header();  // **Dynamic Headers** built-in support for plugin

		do_action('ttwx_extended_header_insert');	/* add any extension header insert */
		do_action('ttwx_super_header_insert');		// future extension

		?>
	    </div><!-- #branding -->

	    <?php
	    if (!ttw_getopt('ttw_hide_custom_header_template_menus') && !ttw_getopt('ttw_move_menu')) { 	/* ttw - move header */ ?>
	    <div id="access" role="navigation">
		<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
		<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', TTW_TRANS ); ?>"><?php _e( 'Skip to content', TTW_TRANS ); ?></a></div>
		<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
		<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
	    </div><!-- #access -->
	    <?php } ?>
	    <?php
	    if (!ttw_getopt('ttw_hide_custom_header_template_menus') && ttw_getopt('ttw_move_menu')) { 	/* ttw - move header */ ?>
	    <div id="access2" role="navigation">
		<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
		<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', TTW_TRANS ); ?>"><?php _e( 'Skip to content', TTW_TRANS ); ?></a></div>
		<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
		<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'secondary', 'fallback_cb' => '' ) ); ?>
	    </div><!-- #access2 -->
	    <?php } ?>
	</div><!-- #masthead -->
    </div><!-- #header -->

    <div id="main">
