<?php
/* This is the main function.php override file - it controls most of the stuff happening with the theme */

require_once('ttw-settings.php');

define ('TTW_THEMEWIDTH','940');

function weaver2010_setup(){
/* Called after the theme stuff has been added.
   It adds additional default header images plus secondary menu and the top/bottom widget areas */
	$ttw_dir = get_template_directory_uri();
	register_default_headers( array (
	    'wheat' => array (
		'url' => "$ttw_dir/images/headers/wheat.jpg",
		'thumbnail_url' => "$ttw_dir/images/headers/wheat-thumbnail.jpg",
		'description' => __( 'Wheat 940x198 Header', TTW_TRANS )
	    ),
	    'sopris' => array (
		'url' => "$ttw_dir/images/headers/sopris.png",
		'thumbnail_url' => "$ttw_dir/images/headers/sopris-thumbnail.png",
		'description' => __( 'Sopris 940x198 Header', TTW_TRANS )
	    ),
	    'mum' => array (
		'url' => "$ttw_dir/images/headers/mum.jpg",
		'thumbnail_url' => "$ttw_dir/images/headers/mum-thumbnail.jpg",
		'description' => __( 'Mum 940x198 Header', TTW_TRANS )
	    ),
	    'ivorydrive' => array (
		'url' => "$ttw_dir/images/headers/ivorydrive.png",
		'thumbnail_url' => "$ttw_dir/images/headers/ivorydrive-thumbnail.png",
		'description' => __( 'Ivory Drive 940x198 Blank Header BG', TTW_TRANS )
	    ),
	    'indieave' => array (
		'url' => "$ttw_dir/images/headers/indieave.png",
		'thumbnail_url' => "$ttw_dir/images/headers/indieave-thumbnail.png",
		'description' => __( 'Indie Ave 940x180 Blank Header BG', TTW_TRANS )
	    ),
	    'wpweaver' => array (
		'url' => "$ttw_dir/images/headers/wpweaver.jpg",
		'thumbnail_url' => "$ttw_dir/images/headers/wpweaver-thumbnail.jpg",
		'description' => __( 'WPWeaver 940x140 Header', TTW_TRANS )
	    )
	));

	## secondary menu
	register_nav_menus( array(
		'secondary' => __( 'Secondary Navigation', TTW_TRANS ),
	) );
	## top widget area
	register_sidebar( array (
		'name' => __( 'Weaver Top Widget Area', TTW_TRANS ),
		'id' => 'top-widget-area',
		'description' => __( 'The top widget area appears above the content area.', TTW_TRANS ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	## bottom widget area
	register_sidebar( array (
		'name' => __( 'Weaver Bottom Widget Area', TTW_TRANS ),
		'id' => 'bottom-widget-area',
		'description' => __( 'The bottom widget area appears below the content.', TTW_TRANS ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	## Special Post Pages Top Widget area
	register_sidebar( array (
		'name' => __( 'Weaver Post Pages Widget Area', TTW_TRANS ),
		'id' => 'postpages-widget-area',
		'description' => __( 'This widget area will appear at the top of special post pages (archives, attachment, author, category, single post) This is not used on the main blog page.', TTW_TRANS ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	## alternative widget area
		register_sidebar( array(
		'name' => __( 'Weaver Alternative Widget Area', TTW_TRANS ),
		'id' => 'alternative-widget-area',
		'description' => __( 'An alternative widget area used only by the Alternative Left and Right page templates.', TTW_TRANS ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	## bottom widget area
	register_sidebar( array (
		'name' => __( 'Weaver Header Widget Area', TTW_TRANS ),
		'id' => 'header-widget-area',
		'description' => __( "The header widget area appears at the top of the page. It is intended
		for more advanced web pages, and is designed primarily to use Text Widgets to show social feeds
		or other custom items. Styling is via '#ttw-head-widget', '#ttw-head-widget .textwidget',
		and inline span style rules. Unless you add widgets, it doesn't show.", TTW_TRANS ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<em class="head-widget-title">',
		'after_title' => '</em>',
	) );

    	ttw_initopts();		/* load opts */

	do_action('ttwx_extended_setup');
	do_action('ttwx_themes_setup');	// needs to before get subtheme because might change it

	$cur_theme = ttw_getopt('ttw_subtheme');

	if ($cur_theme == '' && TTW_START_THEME != TTW_DEFAULT_THEME)
	{
	    require_once('ttw-subthemes.php'); // we only need to include this once on first install.
	    st_set_subtheme(TTW_START_THEME);
	}
}

function mytheme_add_admin() {
    /* adds our admin panel */

    // 'edit_theme_options' works for both single and multisite
    $page = add_theme_page(TTW_THEMENAME, TTW_THEMENAME, 'edit_theme_options', basename(__FILE__), 'mytheme_admin');
    /* using registered $page handle to hook stylesheet loading for this admin page */
    add_action('admin_print_styles-'.$page, 'ttw_admin_scripts');
}

function ttw_admin_scripts() {
    /* called only on the admin page, enqueue our special style sheet here (for tabbed pages) */

    wp_enqueue_style('ttwStylesheet', get_template_directory_uri().'/ttw-admin-style.css');
    wp_enqueue_script('ttwjscolor', get_template_directory_uri().'/js/jscolor/jscolor.js');
    wp_enqueue_script('ttwyetii', get_template_directory_uri().'/js/yetii/yetii-min.js');
    wp_enqueue_script('ttwweaverhide', get_template_directory_uri().'/js/weaver/weaver-hide-css.js');

    do_action('ttwx_extended_admin_scripts');
}

/* we use these option functions so that there is only one DB transaction per page load */

function ttw_setopt($opt, $val) {
    global $ttw_optionsList;
    $ttw_optionsList[$opt] = $val;
}
function ttw_getopt($opt) {
    global $ttw_optionsList;
    if (!isset($ttw_optionsList[$opt]))	// handles changes to data structure
      {
	$ttw_optionsList[$opt] = false;
	return false;
      }
    return $ttw_optionsList[$opt];
}
function ttw_deleteopt($opt) {
    global $ttw_optionsList;
    $ttw_optionsList[$opt] = false;
}

function ttw_setadminopt($opt, $val) {
    global $ttw_adminOpts;
    $ttw_adminOpts[$opt] = $val;
}
function ttw_getadminopt($opt) {
    global $ttw_adminOpts;
    if (!isset($ttw_adminOpts[$opt]))	// handles changes to data structure
      {
	$ttw_adminOpts[$opt] = false;
	return false;
      }
    return $ttw_adminOpts[$opt];
}
function ttw_deleteadminopt($opt) {
    global $ttw_adminOpts;
    $ttw_adminOpts[$opt] = false;
}

function ttw_defaultopt($opt) {
    global $ttw_optionsList;
    $ttw_optionsList[$opt] = ttw_getopt_std($opt);	/* set to default value */
}

function ttw_setmyopt($opt, $val) {
    global $ttw_myoptionsList;
    $ttw_myoptionsList[$opt] = $val;
}
function ttw_getmyopt($opt) {
    global $ttw_myoptionsList;
    if (!isset($ttw_myoptionsList[$opt]))	// handles changes to data structure
      {
	$ttw_myoptionsList[$opt] = false;
	return false;
      }
    return $ttw_myoptionsList[$opt];
}
function ttw_deletemyopt($opt) {
    global $ttw_myoptionsList;
    $ttw_myoptionsList[$opt] = '';
}

function ttw_initopts() {
    global $ttw_optionsList, $ttw_myoptionsList, $ttw_options, $ttw_adminOpts, $ttw_optionsListDefault;

    $settingsFound = false;		// any options saved?

    /* first thing, make sure $ttw_optionsList and $ttw_myoptionsList are set to
       good default values
    */

    $ttw_optionsList = $ttw_optionsListDefault;
    foreach ($ttw_options as $value ) {
 	ttw_defaultopt( $value['id'] );
	ttw_setmyopt($value['id'], ttw_getopt($value['id']));
    }

    $opts = get_option('ttw_options');
    if ($opts) {
	$settingsFound = true;
        $ttw_optionsList = unserialize($opts);
    }

    $myopts = get_option('ttw_myoptions');
    if (!$myopts) {
        $ttw_myoptionsList = $ttw_optionsList;
    }
    else {
	$settingsFound = true;
	$ttw_myoptionsList = unserialize($myopts);
    }

    $aopts = get_option('ttw_adminoptions');
    if ($aopts) {
	$settingsFound = true;
	$ttw_adminOpts = unserialize($aopts);
    }

    if (($end = ttw_getopt('ttw_end_opts'))) {	// old version set - 1.3 upgrade compatibility issue here...
	    ttw_setadminopt('ttw_end_opts',$end);
	    ttw_deleteopt('ttw_end_opts');
	    ttw_saveopts();
	}
}

function ttw_saveopts() {
    global $ttw_optionsList, $ttw_myoptionsList, $ttw_adminOpts;

    update_option('ttw_options',serialize($ttw_optionsList));
    update_option('ttw_myoptions',serialize($ttw_myoptionsList));
    update_option('ttw_adminoptions',serialize($ttw_adminOpts));
    require_once('ttw-generatecss.php');
    ttw_save_current_css();
}

function mytheme_admin() {
    require_once('ttw-admin.php'); // NOW - load the admin stuff
    ttw_do_admin();
}

function mytheme_wp_head() {
    get_template_part('ttw-wphead');	// require_once('ttw-wphead.php');
    ttw_generate_wphead();
}

function childtheme_set_hi_height($def) {
	/* filter to change the height of the default header image */
	$val = ttw_getopt("ttw_header_image_height");
    	return (int) $val;
}
function childtheme_set_hi_width($def) {
	/* filter to change the height of the default header image */
	$val = ttw_getopt("ttw_header_image_width");
    	return (int) $val;
}
function childtheme_excerpt_length($length) {
    $val = ttw_getopt('ttw_excerpt_length');
    if ($val > 0)
	return $val;
    return (int) $length;
}

/* add the rest of our files */
require_once('ttw-globals.php');
require_once('ttw-utils.php');
require_once('ttw-widgets.php');

/* This is where the theme hooks into the rest of Wordpress */
add_filter('twentyten_header_image_height', 'childtheme_set_hi_height');
add_filter('twentyten_header_image_width', 'childtheme_set_hi_width');
add_filter('excerpt_length','childtheme_excerpt_length',999);
add_action('after_setup_theme', 'weaver2010_setup' );
add_action('wp_head', 'mytheme_wp_head');
add_action('admin_menu', 'mytheme_add_admin');

if (!TTW_IS_CHILD) {
    require_once("2010functions.php");	/* load the parent */
}
?>
