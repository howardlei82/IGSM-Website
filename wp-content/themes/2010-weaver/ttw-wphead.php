<?php
// This file is included from functions.php. It will be loaded only when the wp_head action is called from Wordpress.
function ttw_generate_wphead() {
    /* this guy does ALL the work for generating theme look - it writes out the over-rides to the standard style.css */
    global $ttw_options, $ttwHeadOptions;

    printf("<!-- This site is using %s %s subtheme: %s -->\n",TTW_THEMENAME, TTW_VERSION, ttw_getopt('ttw_subtheme'));

    if (!ttw_getadminopt('ttw_hide_metainfo'))
	echo(str_replace("\\", "", ttw_getadminopt('ttw_metainfo')."\n"));

    // handle 3 stylesheed situations
    //	default: used weaver-style.css
    //	no weaver-style.css: when first installed, there will not be a weaver-style.css, so use inline instead
    //	force inline: user wants inline css

    $css_file = ttw_get_css_filename();		// fetch the name of the css file

    if (ttw_getadminopt('ttw_force_inline_css') || !file_exists($css_file)) { // generate inline CSS
	get_template_part('ttw-generatecss'); 	// require_once('ttw-generatecss.php');	// include only now at runtime.
	echo('<style type="text/css">'."\n");
	$output = fopen('php://output','w+');
	ttw_output_style($output);
	echo("</style> <!-- end of main options style section -->\n");
    } else {
	printf("<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"%s\" />\n", ttw_get_css_url());
    }

   /* now head options */
    echo(str_replace("\\", "", ttw_getopt('ttw_theme_head_opts')));
    echo(str_replace("\\", "", ttw_getopt('ttw_head_opts')));		/* let the user have the last word! */

    do_action('ttwx_extended_wp_head'); 	/* call extended wp_head stuff */
    do_action('ttwx_super_wp_head');		// future header plugin

    echo("\n<!-- End of Weaver options -->\n");

}

function ttw_get_css_filename() {
    $wpdir = wp_upload_dir();		// get the upload directory
    $save_dir = $wpdir['basedir'] . '/weaver-subthemes/';
    return $save_dir . 'style-weaver.css';
}

function ttw_get_css_url() {
    $wpdir = wp_upload_dir();		// get the upload directory
    $save_url = $wpdir['baseurl'] . '/weaver-subthemes/';
    return $save_url . 'style-weaver.css';
}
?>
