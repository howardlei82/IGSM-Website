<?php
/* this code is used to define our included subthemes. Kind of big. */

st_build_theme_list();		// will need a valid subtheme list to work with.

function st_set_to_defaults() {
    global $ttw_options;

    foreach ($ttw_options as $value ) {
	$id = $value['id'];
 	ttw_defaultopt( $value['id'] );
	if ($value['type'] == 'ctext')
	    ttw_setopt($id. '_css',''); // clear CSS text, too.
    }
}

function st_set_subtheme($use_subtheme) {
    global $ttw_optionsList;
    /* update all the values for selected subtheme */

    /* not all themes have a full set of values, so set to default to begin with */
    st_set_to_defaults();

    /* and also clear 'ttw_theme_head_opts' - the special options set by a theme. We will
	  leave the other advanced options intact so users can try different themes using
	  the custom stuff they've defined */

    ttw_deleteopt( 'ttw_theme_head_opts' );	/* these are the advanced options + special theme head opts */

    if ($use_subtheme == 'My Saved Theme') { /* special handling for My Saved Theme */
	foreach ($ttw_optionsList as $key => $oval)	/* fetch saved my theme and change values */
	{
	    $val = ttw_getmyopt($key);      /* get the saved value */
	    if ($val !== false) {
		ttw_setopt( $key, $val);    /* and set value really used */
	    }
	}
    } else {			/* picked a pre-defined sub-theme */
        if (!($def = st_get_theme($use_subtheme))) {
	    if (!($def = apply_filters('ttwx_themes_gettheme',$def,$use_subtheme))) // might be plugin theme
		$def = st_get_theme(TTW_DEFAULT_THEME);
	}
        foreach ($def as $key => $val)
	{
            if ($val !== false) {
               ttw_setopt( $key, $val );
            }
	}
    }
    ttw_setopt('ttw_subtheme', $use_subtheme);
    ttw_saveopts();
}

function ttw_savemytheme() {
    /* saves current settings into My Saved Theme */
    global $ttw_optionsList;
    /* save current value into mysaved theme database */
    foreach ($ttw_optionsList as $key => $oval) {
	$val = ttw_getopt($key); /* get the current value */
	ttw_setmyopt( $key, $val ); /* and save into 'my_' db */
    }
    ttw_setopt('ttw_subtheme', 'My Saved Theme');
    ttw_saveopts();
}

function ttw_themes_admin() {
    /* The opening default admin panel - used to pick a predefined theme. Put it first because
      it is less intimidating than the Main Options tab.
    */
	global $ttw_fullThemeList;
?>

<h3>Predefined Themes</h3>
<b>Welcome to Twenty Ten Weaver</b>

<p>Twenty Ten Weaver allows you to tweak many of the setting for your Wordpress blog using the
different admin panels here. This page lets you get a quick start by picking one of our many
predefined sub-themes. Once you've picked a starter theme, use the <em>Main</em> and <em>Advanced Options</em>
panels to tweak the theme to be whatever you like. After you have a theme you're happy with,
you can save it - both in the site data base, and as a download. The <em>Snippets</em> tab has
some hints for additional fine tuning, and the <em>Help</em> tab has much more <b>useful</b> information.</p>

<h4>Get started by trying one of the predefined sub-themes!</h4>
<?php
    st_pick_theme('');

    echo("<hr />\n");
    $themeimgs = get_template_directory_uri() . '/images/subthemes/';

	/* first, show the default theme */
    if (!ttw_getadminopt('ttw_hide_theme_thumbs')) {
	echo ("<h3>Sub-theme thumbnails</h3>\n");

	echo ('<table width="900px" border="0" cellspacing="10" cellpadding="5">');

	$col=0;		/* have default, so start at 1 */

	foreach ($ttw_fullThemeList as $theme) {
	    $name = $theme['name'];
	    if ($name == 'My Saved Theme') {
		$img = '';
		$desc = '';
	    } else if ($name == '') {
		$img = 'custom.png';
		$desc = "Description not available";
	    } else {
		$img = $ttw_fullThemeList[$name]['img'];
		$desc = $ttw_fullThemeList[$name]['desc'];
	    }

	    if ($img == '') continue;	// don't show my saved theme...

	    if ($col == 0) {echo '<tr valign="top"><td width="25%">';}

		echo("<strong>$name</strong><br />");	/* info about the theme */
		echo "<img src='$img' width=200 height=150 /><br />";
		echo "<small>$desc</small>";
		echo "</td>\n";
		++$col;			/* track # of cols output */
		if ($col > 3) {
			echo '</tr>';	/* end of row? */
			$col = 0;
		} else echo '<td width=width="25%">';
	}
	if ($col != 0) echo '</tr>';
	echo "</table>\n";		/* all done with table */
    } // end don't hide thumbs
?>
<h4>Get even more sub-themes.</h4>
<p>More sub-themes are available for easy download at
<a href="http://wpweaver.info/themes/twenty-ten-weaver/more-sub-themes-and-extensions/" alt="New Twenty Ten Weaver Sub-themes" target="_blank">
Twenty Ten Weaver Sub-Themes</a>.
<?php
} /* end ttw_themes_admin */


function st_get_theme($theme) {
    /* utility to search for the info of a specified theme */

    if (true) {		/* trick for my folding editor */
$ttw_themes =
    array ( /* array of theme arrays */
            /* Theme name must match the name used in the pick select list on the admin page.
               When you add a theme here, you need to add the name to the $ttw_themeList in ttw-globals.php. */
        array ( "name" => "WP Weaver", "def" => array (
            "ttw_menubar_color" => '#994D15',
            "ttw_menubar_hoverbg_color" => '#733A10',
            "ttw_menubar_text_color" => '#FFFFCD',
            "ttw_menubar_hover_color" => '#EDEDBE',
	    'ttw_menubar_curpage_color' => '#FFFF66',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
	    "ttw_large_tagline" => 'checked',
            "ttw_hide_site_title" => 'checked',
            "ttw_header_image_height" => '140',
            "ttw_after_header" => '10',
            "ttw_sidebars" => SB_1l,
            'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_small_content_font' => 'checked',
            'ttw_title_font' => 'Palatino (serif)',
	    'ttw_header_underline' => false,
            'ttw_widget_header_underline' => '1',
            'ttw_rounded_corners' => 'checked',
            'ttw_useborders' => 'checked',
	    'ttw_footer_border_color' => '#7A3D11',
	    'ttw_hr_color' => '#7A3D11',
            "ttw_title_color" => '#7A3D11',
            "ttw_text_color" => '#7A3D11',
	    "ttw_page_title_color" => '#7A3D11',
	    "ttw_content_color" => '#000000',
            "ttw_widget_title_color" => '#7A3D11',
            "ttw_widget_color" => '#000000',
            "ttw_link_color" => '#E32019',
            "ttw_link_visited_color" => '#BD1A15',
            "ttw_link_hover_color" => '#E37120',
            "ttw_wlink_color" => '#E32019',
            "ttw_wlink_visited_color" => '#BD1A15',
            "ttw_wlink_hover_color" => '#E37120',
            "ttw_plink_color" => '#7A3D11',
            "ttw_plink_visited_color" => '#7A3D11',
            "ttw_plink_hover_color" => '#E37120',
            "ttw_info_color" => '#7A3D11',
            "ttw_ilink_color" => '#AB5518',
            "ttw_ilink_visited_color" => '#AB5518',
            "ttw_ilink_hover_color" => '#E37120',
            "ttw_page_bgcolor" => '#FFFFCD',
	    "ttw_main_bgcolor" => 'transparent',
            "ttw_content_bgcolor" => 'transparent',
            "ttw_side1_bgcolor" => '#F0EBA8',
            "ttw_side2_bgcolor" => '#FCE6C9',
	    "ttw_side3_bgcolor" => '#F0EBA8',
	    'ttw_stickypost_bgcolor' => '#F7F4A1',
	    "ttw_topbottom_bgcolor" => '#FCE6C9',
	    "ttw_footer_bgcolor" => '#FFFAB3',
            'ttw_body_bgcolor' => '#F5F5DC',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => true,
            'ttw_themename' => "WP Weaver",
            'ttw_themedir' => 'wpweaver',
            'ttw_theme_description' => "An Ivory tone theme - used by WPWeaver.info. Use WP Weaver header to see full design.",
            'ttw_theme_image' => 'wpweaver.png',
	    "ttw_theme_head_opts" => false)
        ) ,
        array ( "name" => "IndieAve", "def" => array (
            "ttw_menubar_color" => '#3F9718',
            "ttw_menubar_hoverbg_color" => '#1A7A0B',
            "ttw_menubar_text_color" => '#D9D9D9',
            "ttw_menubar_hover_color" => '#FFFFFF',
	    'ttw_menubar_curpage_color' => '#FFFFFF',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_large_tagline" => false,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => '180',
            "ttw_after_header" => '10',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Verdana (sans-serif)',
            'ttw_small_content_font' => 'checked',
            'ttw_title_font' => 'Verdana (sans-serif)',
            'ttw_rounded_corners' => 'checked',
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => '#FAFAFA',
	    'ttw_hr_color' => '#3F9718',
            "ttw_title_color" => '#FFFFFF',
	    "ttw_title_color_css" => '{position: absolute; margin-top: 50px; margin-left:40px; font-size:300%;width:900px;font-weight:bold;}',
	    'ttw_desc_color' => '#eee',
	    'ttw_desc_color_css' => '{position:absolute;  margin-top: 120px; margin-left:300px; width:600px;font-size:150%;font-weight:bold;}',
            "ttw_text_color" => '#000000',
            "ttw_content_color" => '#000000',
            "ttw_widget_title_color" => '#222222',
            "ttw_widget_color" => '#737373',
            "ttw_link_color" => '#007700',
            "ttw_link_visited_color" => '#005500',
            "ttw_link_hover_color" => '#003300',
            "ttw_wlink_color" => false,
            "ttw_wlink_visited_color" => false,
            "ttw_wlink_hover_color" => false,
            "ttw_plink_color" => '#000000',
            "ttw_plink_visited_color" => '#000000',
            "ttw_plink_hover_color" => '#007700',
            "ttw_info_color" => '#737373',
            "ttw_ilink_color" => '#007700',
            "ttw_ilink_visited_color" => '#005500',
            "ttw_ilink_hover_color" => '#003300',
            "ttw_page_bgcolor" => '#FFFFFE',
	    "ttw_main_bgcolor" => '#FFFFFE',
	    "ttw_container_bgcolor" => '#F4F4F4',
            "ttw_content_bgcolor" => 'trasparent',
            "ttw_side1_bgcolor" => '#D4F7D8',
            "ttw_side2_bgcolor" => '#D4F7D8',
	    "ttw_side3_bgcolor" => '#D4F7D8',
	    "ttw_topbottom_bgcolor" => '#D4F7D8',
	    "ttw_footer_bgcolor" => '#FFFFFE',
            'ttw_body_bgcolor' => '#00AA00',
	    'ttw_stickypost_bgcolor' => '#99DB9E',
            'ttw_fadebody_bg' => true,
            'ttw_wrap_shadow' => true,
            'ttw_themename' => "IndieAve",
            'ttw_themedir' => 'indieave',
            'ttw_theme_description' => "A Green oriented theme based on IndieAve.com. Use Indie Ave header to see full design.",
            'ttw_theme_image' => 'indieave.png',
	    "ttw_theme_head_opts" => false)
        ) ,
        array ( "name" => "Ivory Drive","def" => array (
            "ttw_menubar_color" => '#000000',
            "ttw_menubar_hoverbg_color" => '#CC0000',
            "ttw_menubar_text_color" => '#FFFFFF',
            "ttw_menubar_hover_color" => '#FFFFFF',
	    'ttw_menubar_curpage_color' => '#B8B8B8',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => 'checked',
            "ttw_large_tagline" => false,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => '198',
            "ttw_after_header" => '0',
            "ttw_sidebars" => SB_1l,
	    'ttw_sidebar_width' => '280',
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Verdana (sans-serif)',
            'ttw_small_content_font' => 'checked',
            'ttw_title_font' => 'Verdana (sans-serif)',
            'ttw_header_underline' => false,
            'ttw_widget_header_underline' => '2',
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => false,
	    'ttw_hr_color' => false,
            "ttw_title_color" => '#262626',
	    "ttw_title_color_css" => '{position: absolute; margin-top: 50px; margin-left:340px; font-size:300%;width:600px;}',
	    'ttw_desc_color' => '#FF0000',
	    'ttw_desc_color_css' => '{position:absolute;  margin-top: 180px; margin-left:340px; width:600px;
font-size:150%; font-weight:bold;text-decoration:underline;}',
            "ttw_text_color" => '#000000',
	    "ttw_page_title_color" => '#000000',
	    "ttw_page_title_color_css" => '{border-bottom: 2px solid #737373; font-variant: small-caps;}',
            "ttw_content_color" => '#000000',
            "ttw_widget_title_color" => '#CC0000',
            "ttw_widget_color" => '#FFFFFF',
            "ttw_link_color" => '#8B0000',
            "ttw_link_visited_color" => '#5E0000',
            "ttw_link_hover_color" => '#4B0082',
            "ttw_wlink_color" => '#FFFFFF',
            "ttw_wlink_visited_color" => '#F0F0F0',
            "ttw_wlink_hover_color" => '#CC0000',
            "ttw_plink_color" => '#8B0000',
            "ttw_plink_visited_color" => '#8B0000',
            "ttw_plink_hover_color" => '#4B0082',
            "ttw_info_color" => '#737373',
            "ttw_ilink_color" => '#595959',
            "ttw_ilink_visited_color" => '#737373',
            "ttw_ilink_hover_color" => '#4B0082',
            "ttw_page_bgcolor" => '#000000',
	    "ttw_main_bgcolor" => '#262626',
	    'ttw_container_bgcolor' => '#FFFFFF',
            "ttw_content_bgcolor" => '#FFFFFF',
            "ttw_side1_bgcolor" => '#262626',
            "ttw_side2_bgcolor" => '#262626',
	    "ttw_side3_bgcolor" => '#262626',
	    "ttw_topbottom_bgcolor" => '#A1A1A1',
	    "ttw_footer_bgcolor" => '#525252',
            'ttw_body_bgcolor' => '#000000',
	    'ttw_stickypost_bgcolor' => '#C2C2C2',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => "Ivory Drive",
            'ttw_themedir' => 'ivorydrive',
            'ttw_theme_description' => "Modelled after IvoryDrive.com website. Use the Ivory Drive header to see full design.",
            'ttw_theme_image' => 'ivorydrive.png',
	    "ttw_theme_head_opts" => false)
        ) ,
        array ( "name" => "Black and White", "def" => array (
            "ttw_menubar_color" => '#000000',
            "ttw_menubar_hoverbg_color" => '#333333',
            "ttw_menubar_text_color" => '#EEEEEE',
            "ttw_menubar_hover_color" => '#FFFFFF',
	    'ttw_menubar_curpage_color' => '#BABABA',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_large_tagline" => false,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => false,
            "ttw_after_header" => '0',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Arial (sans-serif)',
            'ttw_small_content_font' => false,
            'ttw_title_font' => 'Arial (sans-serif)',
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => false,
	    'ttw_hr_color' => false,
            "ttw_title_color" => '#FFFFFF',
	    'ttw_desc_color' => '#aaa',
            "ttw_text_color" => '#FFFFFF',
	    "ttw_page_title_color" => '#FFFFFF',
            "ttw_content_color" => '#FFFFFF',
            "ttw_widget_title_color" => '#FFFFFF',
            "ttw_widget_color" => '#FFFFFF',
            "ttw_link_color" => '#DDDDDD',
            "ttw_link_visited_color" => '#EEEEEE',
            "ttw_link_hover_color" => '#AAAAAA',
            "ttw_wlink_color" => '#DDDDDD',
            "ttw_wlink_visited_color" => '#EEEEEE',
            "ttw_wlink_hover_color" => '#AAAAAA',
            "ttw_plink_color" => '#FFFFFF',
            "ttw_plink_visited_color" => '#FFFFFF',
            "ttw_plink_hover_color" => '#AAAAAA',
            "ttw_info_color" => '#BBBBBB',
            "ttw_ilink_color" => '#DDDDDD',
            "ttw_ilink_visited_color" => '#EEEEEE',
            "ttw_ilink_hover_color" => '#AAAAAA',
            "ttw_page_bgcolor" => '#000000',
	    "ttw_main_bgcolor" => '#000000',
            "ttw_content_bgcolor" => '#000000',
            "ttw_side1_bgcolor" => '#000000',
            "ttw_side2_bgcolor" => '#000000',
	    "ttw_side3_bgcolor" => '#000000',
	    'ttw_stickypost_bgcolor' => '#666666',
	    'ttw_input_bgcolor' => '#666666',
	    'ttw_input_bgcolor_css' => '{color:#FFFFFF;}',
	    "ttw_topbottom_bgcolor" => '#000000',
	    "ttw_footer_bgcolor" => '#000000',
            'ttw_body_bgcolor' => '#000000',
	    'ttw_stickypost_bgcolor' => '#2E2E2E',
	    'ttw_media_lib_captioned_border' => 'transparent',
	    'ttw_caption_color' => '#FFFFFF',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => "Black and White",
            'ttw_themedir' => 'blackandwhite',
            'ttw_theme_description' => "Black and White - no color here.",
            'ttw_theme_image' => 'blackandwhite.png',
	    "ttw_theme_head_opts" => false)
        ) ,
        array ( "name" => "Dark - 2 Left Sidebars", "def" => array (
            "ttw_menubar_color" => '#110B0C',
            "ttw_menubar_hoverbg_color" => '#734E4F',
            "ttw_menubar_text_color" => '#B8B8B8',
            "ttw_menubar_hover_color" => '#FFFFFF',
	    'ttw_menubar_curpage_color' => '#FFFFFF',
            "ttw_bold_menu" => false,
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => false,
            "ttw_large_tagline" => false,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => false,
            "ttw_after_header" => '0',
            "ttw_sidebars" => SB_2l,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Tahoma (sans-serif)',
            'ttw_small_content_font' => "checked",
            'ttw_title_font' => 'Georgia (serif)',
            'ttw_header_underline' => false,
            'ttw_widget_header_underline' => '1',
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => false,
	    'ttw_hr_color' => false,
            "ttw_title_color" => '#110B0C',
            "ttw_text_color" => '#000055',
	    "ttw_page_title_color" => '#000055',
	    "ttw_page_title_color_css" => '{margin-bottom:10px;}',
            "ttw_content_color" => '#0D0D0D',
            "ttw_widget_title_color" => '#000055',
            "ttw_widget_color" => '#0D0D0D',
            "ttw_link_color" => '#2753C2',
            "ttw_link_visited_color" => '#2045A1',
            "ttw_link_hover_color" => '#1C2BFF',
            "ttw_wlink_color" => '#2753C2',
            "ttw_wlink_visited_color" => '#2045A1',
            "ttw_wlink_hover_color" => '#1C2BFF',
            "ttw_plink_color" => '#000055',
            "ttw_plink_visited_color" => '#000055',
            "ttw_plink_hover_color" => '#1C2BFF',
            "ttw_info_color" => '#888888',
            "ttw_ilink_color" => '#2753C2',
            "ttw_ilink_visited_color" => '#2045A1',
            "ttw_ilink_hover_color" => '#1C2BFF',
            "ttw_page_bgcolor" => '#734E4F',
	    "ttw_main_bgcolor" => '#F5F5F4',
            "ttw_content_bgcolor" => '#F5F5F4',
            "ttw_side1_bgcolor" => '#F5F5F4',
            "ttw_side2_bgcolor" => '#F5F5F4',
	    "ttw_side3_bgcolor" => '#F5F5F4',
	    "ttw_topbottom_bgcolor" => '#F5F5F4',
	    "ttw_footer_bgcolor" => '#F5F5F4',
            'ttw_body_bgcolor' => '#734E4F',
	    'ttw_stickypost_bgcolor' => '#D9D9D9',
            'ttw_fadebody_bg' => true,
            'ttw_wrap_shadow' => true,
            'ttw_themename' => "Dark - 2 Left Sidebars",
            'ttw_themedir' => 'dark',
            'ttw_theme_description' => "A Dark Theme with 2 sidebars on the left.",
            'ttw_theme_image' => 'dark2.png',
	    "ttw_theme_head_opts" => false)
        ) ,
        array ( "name" => "Blue", "def" => array (
            "ttw_menubar_color" => '#A8B4FF',
            "ttw_menubar_hoverbg_color" => '#97A2E6',
            "ttw_menubar_text_color" => '#EBEBEB',
            "ttw_menubar_hover_color" => '#FFFFFE',
	    'ttw_menubar_curpage_color' => '#FFFFFF',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => false,
            "ttw_large_tagline" => false,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => false,
            "ttw_after_header" => '0',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Arial (sans-serif)',
            'ttw_small_content_font' => 'checked',
            'ttw_title_font' => 'Arial (sans-serif)',
            'ttw_header_underline' => false,
            'ttw_widget_header_underline' => false,
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => '#A8B4FF',
	    'ttw_hr_color' => '#A8B4FF',
            "ttw_title_color" => '#2A2A7D',
            "ttw_text_color" => '#000000',
            "ttw_content_color" => '#000000',
            "ttw_widget_title_color" => '#222222',
            "ttw_widget_color" => '#141414',
            "ttw_link_color" => '#3C3CB3',
            "ttw_link_visited_color" => '#2A2A7D',
            "ttw_link_hover_color" => '#F54831',
            "ttw_wlink_color" => '#0066CC',
            "ttw_wlink_visited_color" => '#004487',
            "ttw_wlink_hover_color" => '#F54831',
            "ttw_plink_color" => '#000000',
            "ttw_plink_visited_color" => '#000000',
            "ttw_plink_hover_color" => '#0066CC',
            "ttw_info_color" => '#888888',
            "ttw_ilink_color" => '#0066CC',
            "ttw_ilink_visited_color" => '#2A2A7D',
            "ttw_ilink_hover_color" => '#F54831',
            "ttw_page_bgcolor" => '#A8B4FF',
	    "ttw_main_bgcolor" => '#FCFCFC',
            "ttw_content_bgcolor" => '#FCFCFC',
	    "ttw_content_bgcolor_css" => '{padding-top:15px;}',
            "ttw_side1_bgcolor" => '#F0F0F0',
            "ttw_side2_bgcolor" => '#F0F0F0',
	    "ttw_side3_bgcolor" => '#F0F0F0',
	    "ttw_topbottom_bgcolor" => '#F0F0F0',
	    "ttw_footer_bgcolor" => '#F0F0F0',
            'ttw_body_bgcolor' => '#C2CEFF',
	    'ttw_stickypost_bgcolor' => '#DEE6FF',
            'ttw_fadebody_bg' => true,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => "Blue",
            'ttw_themedir' => 'blue',
            'ttw_theme_description' => "A simple theme, based on blue.",
            'ttw_theme_image' => 'blue.png',
	    "ttw_theme_head_opts" => false)
        ) ,
	array ( "name" => "Dark with Green", "def" => array (
            "ttw_menubar_color" => '#1F1F1F',
            "ttw_menubar_hoverbg_color" => '#4D4D4D',
            "ttw_menubar_text_color" => '#EEEEEE',
            "ttw_menubar_hover_color" => '#FFFFFF',
	    'ttw_menubar_curpage_color' => '#B8B8B8',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => false,
            "ttw_large_tagline" => 'checked',
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => '0',
            "ttw_after_header" => '0',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Arial (sans-serif)',
            'ttw_small_content_font' => 'checked',
            'ttw_title_font' => 'Georgia (serif)',
            'ttw_header_underline' => '1',
            'ttw_widget_header_underline' => false,
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => '#1F1F1F',
	    'ttw_hr_color' => '#00FF00',
            "ttw_title_color" => '#00FF00',
            "ttw_text_color" => '#00FF00',
	    "ttw_page_title_color" => '#00FF00',
	    "ttw_page_title_color_css" => '{font-style:italic;}',
            "ttw_content_color" => '#FFFFFF',
            "ttw_widget_title_color" => '#FFFFFF',
            "ttw_widget_color" => '#BABABA',
            "ttw_link_color" => '#00FF00',
            "ttw_link_visited_color" => '#00C700',
            "ttw_link_hover_color" => '#FFFF00',
            "ttw_wlink_color" => '#00FF00',
            "ttw_wlink_visited_color" => '#00C700',
            "ttw_wlink_hover_color" => '#FFFF00',
            "ttw_plink_color" => '#00FF00',
            "ttw_plink_visited_color" => '#00FF00',
            "ttw_plink_hover_color" => '#FFFF00',
            "ttw_info_color" => '#FFFFFF',
            "ttw_ilink_color" => '#00FF00',
            "ttw_ilink_visited_color" => '#00C700',
            "ttw_ilink_hover_color" => '#FFFF00',
	    'ttw_input_bgcolor' => '#666666',
            "ttw_page_bgcolor" => '#262626',
	    "ttw_main_bgcolor" => '#1F1F1F',
            "ttw_content_bgcolor_css" => '{padding-top:15px;}',
	    "ttw_content_bgcolor" => '#1F1F1F',
            "ttw_side1_bgcolor" => '#1F1F1F',
            "ttw_side2_bgcolor" => '#1F1F1F',
	    "ttw_side3_bgcolor" => '#1F1F1F',
	    "ttw_topbottom_bgcolor" => '#1F1F1F',
	    "ttw_footer_bgcolor" => '#262626c',
            'ttw_body_bgcolor' => '#1F1F1F',
	    'ttw_stickypost_bgcolor' => '#3B3B3B',
	    'ttw_stickypost_bgcolor_css' => '{ border-top: 2px dotted #00FF00; border-bottom: 2px dotted #00FF00;}',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => "Dark with Green",
            'ttw_themedir' => 'darkwithgreen',
            'ttw_theme_description' => "Almost Black, with Green titles",
            'ttw_theme_image' => 'darkgreen.png',
	    "ttw_theme_head_opts" => false)
        ) ,
	array ( "name" => "Browns", "def" => array (
            "ttw_menubar_color" => '#2B1915',
            "ttw_menubar_hoverbg_color" => '#522D25',
            "ttw_menubar_text_color" => '#C59C87',
            "ttw_menubar_hover_color" => '#FFCAAF',
	    'ttw_menubar_curpage_color' => '#FFFFFF',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => 'checked',
            "ttw_large_tagline" => false,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => false,
            "ttw_after_header" => '5',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Verdana (sans-serif)',
            'ttw_small_content_font' => false,
            'ttw_title_font' => 'Garamond (serif)',
            'ttw_header_underline' => false,
            'ttw_widget_header_underline' => '1',
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => '#2B1915',
	    'ttw_hr_color' => '#2B1915',
            "ttw_title_color" => '#C7A7A0',
            "ttw_text_color" => '#D1A68F',
	    "ttw_page_title_color" => '#D1A68F',
            "ttw_content_color" => '#D1A68F',
            "ttw_widget_title_color" => '#C7A7A0',
            "ttw_widget_color" => '#E3B49B',
            "ttw_link_color" => '#A57862',
            "ttw_link_visited_color" => '#A57862',
            "ttw_link_hover_color" => '#E8A98A',
            "ttw_wlink_color" => '#A57862',
            "ttw_wlink_visited_color" => '#A57862',
            "ttw_wlink_hover_color" => '#E8A98A',
            "ttw_plink_color" => '#D1A68F',
            "ttw_plink_visited_color" => '#D1A68F',
            "ttw_plink_hover_color" => '#A57862',
            "ttw_info_color" => '#D1A68F',
            "ttw_ilink_color" => '#C59C87',
            "ttw_ilink_visited_color" => '#C59C87',
            "ttw_ilink_hover_color" => '#E8A98A',
            "ttw_page_bgcolor" => '#3A221C',
	    "ttw_page_bgcolor_css" => '{padding-bottom:15px;margin-bottom:15px;}',
	    "ttw_main_bgcolor" => '#522D25',
            "ttw_content_bgcolor" => '#522D25',
            "ttw_side1_bgcolor" => '#522D25',
            "ttw_side2_bgcolor" => '#2E1914',
	    "ttw_side3_bgcolor" => '#522D25',
	    'ttw_stickypost_bgcolor' => '#666666',
	    'ttw_input_bgcolor' => '#666666',
	    "ttw_topbottom_bgcolor" => '#522D25',
	    "ttw_footer_bgcolor" => '#2E1914',
            'ttw_body_bgcolor' => '#522D25',
	    'ttw_stickypost_bgcolor' => '#63372D',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => "Browns",
            'ttw_themedir' => 'browns',
            'ttw_theme_description' => "Brown theme - almost a camo look.",
            'ttw_theme_image' => 'browns.png',
	    "ttw_theme_head_opts" => '')
        ) ,
	array ( "name" => "Reds", "def" => array (
            "ttw_menubar_color" => '#660000',
            "ttw_menubar_hoverbg_color" => '#AA0000',
            "ttw_menubar_text_color" => '#D8D8D8',
            "ttw_menubar_hover_color" => '#FFFFFF',
	    'ttw_menubar_curpage_color' => '#FFFFFF',
            "ttw_bold_menu" => 'checked',
            "ttw_move_menu" => false,
            "ttw_large_tagline" => false,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => false,
            "ttw_after_header" => '10',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Verdana (sans-serif)',
            'ttw_small_content_font' => 'checked',
            'ttw_title_font' => 'Garamond (serif)',
            'ttw_header_underline' => false,
            'ttw_widget_header_underline' => '1',
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => '#660000',
	    'ttw_hr_color' => '#ED0000',
            "ttw_title_color" => '#FFFFCC',
            "ttw_text_color" => '#FFFFCC',
	    "ttw_page_title_color" => '#FFFFCC',
            "ttw_content_color" => '#FFFFFE',
            "ttw_widget_title_color" => '#FFFFFE',
	    "ttw_widget_title_color_css" => '{margin-bottom:12px;}',
            "ttw_widget_color" => '#FFFFFE',
            "ttw_link_color" => '#FFFFCC',
            "ttw_link_visited_color" => '#FFFFCC',
            "ttw_link_hover_color" => '#FFFFFE',
            "ttw_wlink_color" => '#FFFFCC',
            "ttw_wlink_visited_color" => '#FFFFCC',
            "ttw_wlink_hover_color" => '#FFFFFE',
            "ttw_plink_color" => '#FFFFCC',
            "ttw_plink_visited_color" => '#FFFFCC',
            "ttw_plink_hover_color" => '#FFFFFE',
            "ttw_info_color" => '#F0F0F0',
            "ttw_ilink_color" => '#FFFFCC',
            "ttw_ilink_visited_color" => '#FFFFCC',
            "ttw_ilink_hover_color" => '#FFFFFE',
	    'ttw_input_bgcolor' =>'#666666;',
	    'ttw_input_bgcolor_css' =>'{color:#FFFFCC}',
            "ttw_page_bgcolor" => '#FFFFFE',
	    "ttw_main_bgcolor" => '#990000',
	    "ttw_main_bgcolor_css" => '{border-top-style:solid; border-top-width: 5px; border-top-color: #FFFFFF;}',
            "ttw_content_bgcolor" => '#990000',
	    "ttw_content_bgcolor_css" => 'padding-top: 10px;',
            "ttw_side1_bgcolor" => '#990000',
	    "ttw_side1_bgcolor_css" => '{border-left-style:solid; border-left-width: 5px; border-left-color: #FFFFFF;padding-top:10px;}',
            "ttw_side2_bgcolor" => '#990000',
	    "ttw_side2_bgcolor_css" => '{border-left-style:solid; border-left-width: 5px; border-left-color: #FFFFFF;}',
	    "ttw_side3_bgcolor" => '#990000',
	    "ttw_side3_bgcolor_css" => '{border-left-style:solid; border-left-width: 5px; border-left-color: #FFFFFF;padding-top:10px;}',
	    "ttw_topbottom_bgcolor" => '#990000',
	    "ttw_footer_bgcolor" => '#990000',
            'ttw_body_bgcolor' => '#660000',
	    'ttw_stickypost_bgcolor' => '#CF0000',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => "Reds",
            'ttw_themedir' => 'reds',
            'ttw_theme_description' => "Red based theme - good example of some custom CSS entries.",
            'ttw_theme_image' => 'reds.png',
	    "ttw_theme_head_opts" =>
'<style>
#altleft{border-right-style:solid; border-right-width: 5px; border-right-color: #FFFFFF;padding-top:10px;}
#branding{background-color:#660000;}
#branding a{margin-left:15px;font-style:italic;}
#content h2, #content h1{font-style:italic;}
h3#comments-title, h3#reply-title, .comment-author cite  { color: #F0F0F0;}
.comment-meta a:link, .comment-meta a:visited { color: #A0A0A0; }
.comment-meta a:active, .comment-meta a:hover, .reply a:hover, a.comment-edit-link:hover { color: #FFFFFF; }
#respond .required { color: #FFAAAA; } #respond label, #respond .form-allowed-tags { color: #A0A0A0; }
</style>')
        ) ,
	array ( "name" => "Tan and Gray", "def" => array (
            "ttw_menubar_color" => '#9D8851',
            "ttw_menubar_hoverbg_color" => '#BAA160',
            "ttw_menubar_text_color" => '#303030',
            "ttw_menubar_hover_color" => '#000000',
	    'ttw_menubar_curpage_color' => '#FFFFFF',
            "ttw_bold_menu" => false,
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => false,
            "ttw_large_tagline" => 'checked',
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => false,
            "ttw_after_header" => '0',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Helvetica Neue (sans-serif)',
            'ttw_small_content_font' => false,
            'ttw_title_font' => 'Helvetica Neue (sans-serif)',
            'ttw_header_underline' => false,
            'ttw_widget_header_underline' => false,
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => '#9D8851',
	    'ttw_hr_color' => '#9D8851',
            "ttw_title_color" => '#FFFFFF',
	    "ttw_title_color_css" => '{padding-left:15px;}',
            "ttw_text_color" => '#333333',
	    "ttw_page_title_color" => '#333333',
            "ttw_content_color" => '#333333',
	    "ttw_content_color_css" => '{padding-top:15px;}',
            "ttw_widget_title_color" => '#282828',
	    "ttw_widget_title_color_css" => '{font-size:30px;font-weight:normal;line-height:35px;margin-bottom:5px;}',
            "ttw_widget_color" => '#282828',
            "ttw_link_color" => '#000000',
            "ttw_link_visited_color" => '#202020',
            "ttw_link_hover_color" => '#170D75',
            "ttw_wlink_color" => '#000000',
            "ttw_wlink_visited_color" => '#202020',
            "ttw_wlink_hover_color" => '#170D75',
            "ttw_plink_color" => '#333333',
            "ttw_plink_visited_color" => '#333333',
            "ttw_plink_hover_color" => '#170D75',
            "ttw_info_color" => '#6E6E6E',
            "ttw_ilink_color" => '#000000',
            "ttw_ilink_visited_color" => '#202020',
            "ttw_ilink_hover_color" => '#170D75',
	    'ttw_header_bgcolor' => '#9D8851',
            "ttw_page_bgcolor" => '#FFFFFF',
	    "ttw_main_bgcolor" => '#FFFFFF',
            "ttw_content_bgcolor" => '#FFFFFF',
            "ttw_side1_bgcolor" => '#999999',
            "ttw_side2_bgcolor" => '#999999',
	    "ttw_side3_bgcolor" => '#999999',
	    "ttw_topbottom_bgcolor" => '#999999',
	    "ttw_footer_bgcolor" => '#9D8851',
	    "ttw_footer_bgcolor_css" => 'a{color:#333333;}',
            'ttw_body_bgcolor' => '#999999',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => "Tan and Gray",
            'ttw_themedir' => 'tanandgray',
            'ttw_theme_description' => "A clean tan, gray, and white theme.",
            'ttw_theme_image' => 'tanandgray.png',
	    "ttw_theme_head_opts" =>false )
        ) ,
	array ( "name" => "Orange", "def" => array (
            "ttw_menubar_color" => '#EA7521',
            "ttw_menubar_hoverbg_color" => '#FF8024',
            "ttw_menubar_text_color" => '#E8E8E8',
            "ttw_menubar_hover_color" => '#FFFFFF',
	    'ttw_menubar_curpage_color' => '#FFFFFF',
            "ttw_bold_menu" => false,
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => false,
            "ttw_large_tagline" => false,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => false,
            "ttw_after_header" => '20',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Arial (sans-serif)',
            'ttw_small_content_font' => 'checked',
            'ttw_title_font' => 'Arial (sans-serif)',
            'ttw_header_underline' => false,
            'ttw_widget_header_underline' => false,
            'ttw_rounded_corners' => 'checked',
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => '#EA7521',
	    'ttw_hr_color' => '#EA7521',
            "ttw_title_color" => false,
            "ttw_text_color" => '#EA7521',
	    "ttw_page_title_color" => '#EA7521',
            "ttw_content_color" => '#444444',
            "ttw_widget_title_color" => '#222222',
	    "ttw_widget_title_color_css" => '{font-size:130%;margin-bottom:8px;border-bottom: 1px dotted #C4BCB0;}',
            "ttw_widget_color" => '#404040',
            "ttw_link_color" => '#000000',
            "ttw_link_visited_color" => '#000000',
            "ttw_link_hover_color" => '#EA7521',
            "ttw_wlink_color" => '#000000',
            "ttw_wlink_visited_color" => '#000000',
            "ttw_wlink_hover_color" => '#EA7521',
            "ttw_plink_color" => '#000000',
            "ttw_plink_visited_color" => '#000000',
            "ttw_plink_hover_color" => '#EA7521',
            "ttw_info_color" => '#888888',
            "ttw_ilink_color" => '#AE927D',
            "ttw_ilink_visited_color" => '#AE927D',
            "ttw_ilink_hover_color" => '#EA7521',
            "ttw_page_bgcolor" => '#FFFFFF',
	    "ttw_main_bgcolor" => '#FFFFFF',
            "ttw_content_bgcolor" => '#FFFFFF',
	    "ttw_content_bgcolor_css" => 'p {padding-left:15px;}, #content .post {border-top: 1px dotted #DBD2C4;border-bottom: 1px dotted #C4BCB0;margin-bottom:10px;}',
            "ttw_side1_bgcolor" => '#EBEBEB',
	    "ttw_side2_bgcolor" => '#FFFFFF',
	    "ttw_side3_bgcolor" => '#EBEBEB',
	    "ttw_topbottom_bgcolor" => '#FFFFFF',
	    "ttw_footer_bgcolor" => '#FFFFFF',
            'ttw_body_bgcolor' => '#C9651C',
	    'ttw_stickypost_bgcolor' => '#FAD7AA',
            'ttw_fadebody_bg' => true,
            'ttw_wrap_shadow' => true,
            'ttw_themename' => "Orange",
            'ttw_themedir' => 'orange',
            'ttw_theme_description' => "Simple Orange headers",
            'ttw_theme_image' => 'orange.png',
	    "ttw_theme_head_opts" => false )
	  ) ,
	array ( "name" => "Simple Silver", "def" => array (
            "ttw_menubar_color" => '#707070',
            "ttw_menubar_hoverbg_color" => '#545454',
            "ttw_menubar_text_color" => '#D1CDCD',
            "ttw_menubar_hover_color" => '#28ACF0',
	    'ttw_menubar_curpage_color' => '#FFFFFF',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => false,
            "ttw_large_tagline" => 'checked',
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => '0',
            "ttw_after_header" => '20',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Verdana (sans-serif)',
            'ttw_small_content_font' => 'checked',
            'ttw_title_font' => 'Georgia (serif)',
            'ttw_header_underline' => false,
            'ttw_widget_header_underline' => '2',
            'ttw_rounded_corners' => 'checked',
            'ttw_useborders' => 'checked',
	    'ttw_footer_border_color' => false,
	    'ttw_hr_color' => false,
            "ttw_title_color" => '#000000',
            "ttw_text_color" => '#000000',
            "ttw_content_color" => '#000000',
            "ttw_widget_title_color" => '#000000',
            "ttw_widget_color" => '#000000',
            "ttw_link_color" => '#9E1FCC',
            "ttw_link_visited_color" => '#743399',
            "ttw_link_hover_color" => '#28ACF0',
            "ttw_wlink_color" => '#9E1FCC',
            "ttw_wlink_visited_color" => '#743399',
            "ttw_wlink_hover_color" => '#28ACF0',
            "ttw_plink_color" => '#000000',
            "ttw_plink_visited_color" => '#000000',
            "ttw_plink_hover_color" => '#28ACF0',
            "ttw_info_color" => '#000000',
            "ttw_ilink_color" => '#0000FF',
            "ttw_ilink_visited_color" => '#000088',
            "ttw_ilink_hover_color" => '#28ACF0',
            "ttw_page_bgcolor" => '#E1E0E0',
	    "ttw_main_bgcolor" => '#E1E0E0',
            "ttw_content_bgcolor" => '#E1E0E0',
            "ttw_side1_bgcolor" => '#C0C0C0',
            "ttw_side2_bgcolor" => '#C0C0C0',
	    "ttw_side3_bgcolor" => '#C0C0C0',
	    "ttw_topbottom_bgcolor" => '#C0C0C0',
	    "ttw_footer_bgcolor" => '#C0C0C0',
            'ttw_body_bgcolor' => '#C0C0C0',
	    'ttw_infotop_bgcolor' => '#F8F8F8',
	    'ttw_infotop_bgcolor_css' => '{padding:4px 0 4px 20px; border: solid 1px #A0A0A0;font-style:bold;}',
	    'ttw_infobottom_bgcolor' => '#C0C0C0',
	    'ttw_infobottom_bgcolor_css' => '{padding:4px 0 4px 20px; border: solid 1px #A0A0A0;font-style:bold;}',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => true,
            'ttw_themename' => "Simple Silver",
            'ttw_themedir' => 'simplesilver',
            'ttw_theme_description' => "A simple silver theme.",
            'ttw_theme_image' => 'simplesilver.png',
	    "ttw_theme_head_opts" => false)
        ) ,
	        array ( "name" => 'White', "def" => array (
            "ttw_menubar_color" => '#FCFCFC',
	    "ttw_menubar_color_css" => '{border: 1px solid #DDDDDD; margin-top: 2px;}',
            "ttw_menubar_hoverbg_color" => '#DDDDDD',
            "ttw_menubar_text_color" => '#000000',
            "ttw_menubar_hover_color" => '#444444',
	    'ttw_menubar_curpage_color' => '#00008F',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => false,
            "ttw_large_tagline" => 'checked',
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => false,
            "ttw_after_header" => '4',
            "ttw_sidebars" => SB_1rw,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Verdana (sans-serif)',
            'ttw_small_content_font' => false,
            'ttw_title_font' => 'Verdana (sans-serif)',
            'ttw_header_underline' => false,
            'ttw_widget_header_underline' => false,
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => false,
	    'ttw_hr_color' => false,
            "ttw_title_color" => '#3366BB',
            "ttw_text_color" => '#3366BB',
	    "ttw_page_title_color" => '#3366BB',
            "ttw_content_color" => false,
            "ttw_widget_title_color" => false,
            "ttw_widget_color" => false,
            "ttw_link_color" => false,
            "ttw_link_visited_color" => false,
            "ttw_link_hover_color" => false,
            "ttw_wlink_color" => false,
            "ttw_wlink_visited_color" => false,
            "ttw_wlink_hover_color" => false,
            "ttw_plink_color" => '#3366BB',
            "ttw_plink_visited_color" => '#3366BB',
            "ttw_plink_hover_color" => '#FF4B32',
            "ttw_info_color" => false,
            "ttw_ilink_color" => false,
            "ttw_ilink_visited_color" => false,
            "ttw_ilink_hover_color" => false,
            "ttw_page_bgcolor" => '#FCFCFC',
	    "ttw_main_bgcolor" => '#FCFCFC',
            "ttw_content_bgcolor" => '#FCFCFC',
	    "ttw_content_bgcolor_css" => '{border: 1px solid #DDDDDD; padding-left:15px; padding-top:10px; padding-right:15px;}',
            "ttw_side1_bgcolor" => '#FCFCFC',
            "ttw_side2_bgcolor" => '#FCFCFC',
	    "ttw_side3_bgcolor" => '#FCFCFC',
	    "ttw_topbottom_bgcolor" => '#FCFCFC',
	    "ttw_footer_bgcolor" => '#FCFCFC',
            'ttw_body_bgcolor' => '#FCFCFC',
	    'ttw_stickypost_bgcolor' => '#CFCFCF',
	    'ttw_infotop_bgcolor' => '#DDDDDD',
	    'ttw_infotop_bgcolor_css' => '{padding:4px 4px 4px 20px;}',
	    'ttw_infobottom_bgcolor' => '#DDDDDD',
	    'ttw_infobottom_bgcolor_css' => '{padding:4px 4px 4px 20px;}',
	    'ttw_border_adjust_sidebar' => '4',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => "White",
            'ttw_themedir' => 'white',
            'ttw_theme_description' => "White Theme with content border. (Doesn't work with all sidebar arrangements.)",
            'ttw_theme_image' => 'white.png',
	    "ttw_theme_head_opts" => false)
        ) ,
	array ( "name" => 'Shadows', "def" => array (
            "ttw_menubar_color" => '#444444',
            "ttw_menubar_hoverbg_color" => '#222222',
            "ttw_menubar_text_color" => '#D0D0D0',
            "ttw_menubar_hover_color" => '#888888',
	    'ttw_menubar_curpage_color' => '#FFFFFE',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => false,
            "ttw_large_tagline" => 'checked',
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => false,
            "ttw_after_header" => '15',
            "ttw_sidebars" => SB_1rw,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Arial (sans-serif)',
            'ttw_small_content_font' => 'checked',
            'ttw_title_font' => 'Times New Roman (serif)',
            'ttw_header_underline' => '1',
            'ttw_widget_header_underline' => '1',
            'ttw_rounded_corners' => true,
            'ttw_useborders' => true,
	    'ttw_footer_border_color' => '#444444',
	    'ttw_hr_color' => '#444444',
            "ttw_title_color" => '#000000',
	    "ttw_title_color_css" => '{text-shadow:1px 1px 1px #999;}',
            "ttw_text_color" => '#445566',
	    "ttw_page_title_color" => '#445566',
	    "ttw_page_title_color_css" => '{text-shadow:1px 1px 1px #999;}',
            "ttw_content_color" => '#333333',
            "ttw_widget_title_color" => '#445566',
	    "ttw_widget_title_color_css" => '{text-shadow:1px 1px 1px #999; font-size:140%;margin-bottom:10px; }',
            "ttw_widget_color" => '#333333',
            "ttw_link_color" => '#666666',
            "ttw_link_visited_color" => '#555555',
            "ttw_link_hover_color" => '#4448BD',
            "ttw_wlink_color" => '#666666',
            "ttw_wlink_visited_color" => '#555555',
            "ttw_wlink_hover_color" => '#4448BD',
            "ttw_plink_color" => '#445566',
	    "ttw_plink_color_css" => '{text-shadow:1px 1px 1px #999;}',
            "ttw_plink_visited_color" => '#445566',
	    "ttw_plink_visited_color_css" => '{text-shadow:1px 1px 1px #999;}',
            "ttw_plink_hover_color" => '#4448BD',
	    "ttw_plink_hover_color_css" => '{text-shadow:1px 1px 1px #999;}',
            "ttw_info_color" => '#888888',
            "ttw_ilink_color" => '#666666',
            "ttw_ilink_visited_color" => '#555555',
            "ttw_ilink_hover_color" => '#4448BD',
            "ttw_page_bgcolor" => '#F7F7F7',
	    "ttw_main_bgcolor" => '#F7F7F7',
            "ttw_content_bgcolor" => '#F7F7F7',
            "ttw_side1_bgcolor" => '#F2F2F2',
            "ttw_side2_bgcolor" => '#F2F2F2',
	    "ttw_side3_bgcolor" => '#F2F2F2',
	    "ttw_topbottom_bgcolor" => '#F2F2F2',
	    "ttw_footer_bgcolor" => '#F7F7F7',
            'ttw_body_bgcolor' => '#F7F7F7',
	    'ttw_stickypost_bgcolor' => '#E3E3E3',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => true,
            'ttw_themename' => "Shadows",
            'ttw_themedir' => 'shadows',
            'ttw_theme_description' => "Gray with Shadows",
            'ttw_theme_image' => 'shadows.png',
	    "ttw_theme_head_opts" => false)
        ) ,
        array ( "name" => 'Sopris', "def" => array (
            "ttw_menubar_color" => '#8EBAD7',
            "ttw_menubar_hoverbg_color" => '#53A13F',
            "ttw_menubar_text_color" => '#22421A',
            "ttw_menubar_hover_color" => '#79EB5C',
	    'ttw_menubar_curpage_color' => '#366929',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => false,
            "ttw_large_tagline" => false,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => '198',
            "ttw_after_header" => '0',
            "ttw_sidebars" => SB_1rw,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Arial (sans-serif)',
            'ttw_small_content_font' => 'checked',
            'ttw_title_font' => 'Arial (sans-serif)',
            'ttw_header_underline' => false,
            'ttw_widget_header_underline' => false,
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => '#53A13F',
	    'ttw_hr_color' => '#326126',
            "ttw_title_color" => '#22421A',
	    "ttw_title_color_css" => '{padding-left:20px; padding-top:15px;}',
            "ttw_text_color" => '#22421A',
	    "ttw_page_title_color" => '#22421A',
	    "ttw_page_title_color_css" => '{border-bottom: 1px dotted #53A13F; width: 100%;}',
            "ttw_content_color" => '#333333',
            "ttw_widget_title_color" => '#22421A',
	    "ttw_widget_title_color_css" => '{font-size:130%;margin-bottom:8px;border-bottom: 1px solid #53A13F; background-color:#70DB56;padding:5px;}',
            "ttw_widget_color" => '#444444',
            "ttw_link_color" => '#16569E',
            "ttw_link_visited_color" => '#0F3A6B',
            "ttw_link_hover_color" => '#79EB5C',
            "ttw_wlink_color" => '#16569E',
            "ttw_wlink_visited_color" => '#0F3A6B',
            "ttw_wlink_hover_color" => '#79EB5C',
            "ttw_plink_color" => '#22421A',
            "ttw_plink_visited_color" => '#22421A',
            "ttw_plink_hover_color" => '#79EB5C',
            "ttw_info_color" => '#444444',
            "ttw_ilink_color" => '#16569E',
            "ttw_ilink_visited_color" => '#0F3A6B',
            "ttw_ilink_hover_color" => '#79EB5C',
            "ttw_page_bgcolor" => '#8EBAD7',
	    'ttw_header_bgcolor' => 'transparent',
	    'ttw_header_bgcolor_css' => '#branding {background-color:#53A13F;}',
	    "ttw_main_bgcolor" => '#FFFFFE',
            "ttw_content_bgcolor" => '#FFFFFE',
            "ttw_side1_bgcolor" => '#D9ECFF',
            "ttw_side2_bgcolor" => '#CBFFAD',
	    "ttw_side3_bgcolor" => '#D9ECFF',
	    "ttw_topbottom_bgcolor" => '#CBFFAD',
	    "ttw_footer_bgcolor" => '#CBFFAD',
            'ttw_body_bgcolor' => '#4592C4',
	    'ttw_stickypost_bgcolor' => '#DAFFC4',
	    'ttw_infobottom_bgcolor' => '#70DB56',
	    'ttw_infobottom_bgcolor_css' => '{padding:4px 0 4px 10px;border-bottom: dotted 1px #53A13F;}',
            'ttw_fadebody_bg' => true,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => "Sopris",
            'ttw_themedir' => 'sopris',
            'ttw_theme_description' => "Mountain Blues and Greens",
            'ttw_theme_image' => 'sopris.png',
	    "ttw_theme_head_opts" => false)
        ) ,
    array ( "name" => TTW_DEFAULT_THEME, "def" => array (
            "ttw_menubar_color" => '#000000',
            "ttw_menubar_hoverbg_color" => '#333333',
            "ttw_menubar_text_color" => '#AAAAAA',
            "ttw_menubar_hover_color" => '#FFFFFF',
	    'ttw_menubar_curpage_color' => '#FFFFFF',
            "ttw_bold_menu" => false,
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => false,
            "ttw_large_tagline" => false,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => '198',
            "ttw_after_header" => '40',
            "ttw_sidebars" => SB_default,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Bitstream Charter (default,serif)',
            'ttw_small_content_font' => false,
            'ttw_title_font' => 'Helvetica Neue (default, sans)',
            'ttw_header_underline' => false,
            'ttw_widget_header_underline' => false,
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => '#000000',
	    'ttw_hr_color' => '#000000',
            "ttw_title_color" => '#000000',
            "ttw_text_color" => '#000000',
            "ttw_content_color" => '#444444',
            "ttw_widget_title_color" => '#222222',
            "ttw_widget_color" => '#666666',
            "ttw_link_color" => '#0066CC',
            "ttw_link_visited_color" => '#743399',
            "ttw_link_hover_color" => '#FF4B33',
            "ttw_wlink_color" => '#0066CC',
            "ttw_wlink_visited_color" => '#743399',
            "ttw_wlink_hover_color" => '#FF4B33',
            "ttw_plink_color" => '#000000',
            "ttw_plink_visited_color" => '#000000',
            "ttw_plink_hover_color" => '#FF4B33',
            "ttw_info_color" => '#888888',
            "ttw_ilink_color" => '#888888',
            "ttw_ilink_visited_color" => '#888888',
            "ttw_ilink_hover_color" => '#FF4B33',
            "ttw_page_bgcolor" => '#FFFFFF',
	    "ttw_main_bgcolor" => 'transparent',
            "ttw_content_bgcolor" => 'transparent',
            "ttw_side1_bgcolor" => 'transparent',
            "ttw_side2_bgcolor" => 'transparent',
	    "ttw_side3_bgcolor" => 'transparent',
	    "ttw_topbottom_bgcolor" => 'transparent',
	    "ttw_footer_bgcolor" => 'transparent',
            'ttw_body_bgcolor' => '#F1F1F1',
	    'ttw_header_bgcolor_css' => '#branding img {border-top: 4px solid #000;border-bottom: 1px solid #000;clear: both;display: block;}',
	    'ttw_stickypost_bgcolor' => '#CFCFCF',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => 'Twenty Ten',
            'ttw_themedir' => 'twenty-ten',
            'ttw_theme_description' => "Twenty Ten Theme (with Weaver modifications)",
            'ttw_theme_image' => 'twentyten.png',
	    "ttw_theme_head_opts" => '')
        ) ,

	array ( "name" => "Wheat", "def" => array (
            "ttw_menubar_color" => '#AB9B7D',
            "ttw_menubar_hoverbg_color" => '#BAA987',
            "ttw_menubar_text_color" => '#FFFAEF',
            "ttw_menubar_hover_color" => '#F0EBE0',
	    'ttw_menubar_curpage_color' => '#474134',
	    'ttw_desc_color' => '#FFFAEF',
            "ttw_bold_menu" => true,
	    'ttw_gradient_menu' => true,
	    "ttw_hide_menu" => false,
            "ttw_move_menu" => false,
            "ttw_large_tagline" => true,
            "ttw_hide_site_title" => false,
	    'ttw_title_on_header' => true,
            "ttw_header_image_height" => false,
            "ttw_after_header" => '15',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
            'ttw_content_font' => 'Helvetica Neue (sans-serif)',
            'ttw_small_content_font' => 'checked',
            'ttw_title_font' => 'Helvetica Neue (default, sans-serif)',
            'ttw_header_underline' => '1',
            'ttw_widget_header_underline' => '1',
            'ttw_rounded_corners' => 'checked',
            'ttw_useborders' => true,
	    'ttw_footer_border_color' => '#AB9B7D',
	    'ttw_hr_color' => '#AB9B7D',
            'ttw_title_color' => '#FEF9EE',
            "ttw_text_color" => '#0A0A0A',
	    "ttw_page_title_color" => '#0A0A0A',
            "ttw_content_color" => '#292929',
            "ttw_widget_title_color" => '#222222',
            "ttw_widget_color" => '#333333',
            "ttw_link_color" => '#474134',
            "ttw_link_visited_color" => '#706752',
            "ttw_link_hover_color" => '#C91640',
            "ttw_wlink_color" => '#474134',
            "ttw_wlink_visited_color" => '#706752',
            "ttw_wlink_hover_color" => '#C91640',
            "ttw_plink_color" => '#0A0A0A',
            "ttw_plink_visited_color" => '#0A0A0A',
            "ttw_plink_hover_color" => '#C91640',
            "ttw_info_color" => '#706752',
            "ttw_ilink_color" => '#474134',
            "ttw_ilink_visited_color" => '#706752',
            "ttw_ilink_hover_color" => '#C91640',
            "ttw_page_bgcolor" => '#FEF3DD',
	    "ttw_main_bgcolor" => 'transparent',
            "ttw_content_bgcolor" => 'transparent',
            "ttw_side1_bgcolor" => '#F5DEB3',
	    "ttw_side2_bgcolor" => '#F5DEB3',
	    "ttw_side3_bgcolor" => '#F5DEB3',
	    'ttw_stickypost_bgcolor' => '#E6DCC8',
	    "ttw_topbottom_bgcolor" => '#F5DEB3',
	    "ttw_footer_bgcolor" => '#F5DEB3',
            'ttw_body_bgcolor' => '#C7B491',
            'ttw_fadebody_bg' => true,
            'ttw_wrap_shadow' => true,
            'ttw_themename' => "wheat",
            'ttw_themedir' => 'wheat',
            'ttw_theme_description' => "Wheat-toned theme",
            'ttw_theme_image' => 'wheat.png',
	    "ttw_theme_head_opts" => false )
	  ) ,
        array ( "name" => "Transparent Dark", "def" => array (
            "ttw_menubar_color" => 'rgba(0,0,0,.3)',
            "ttw_menubar_hoverbg_color" => 'rgba(0,0,0,.3)',
            "ttw_menubar_text_color" => '#EEEEEE',
            "ttw_menubar_hover_color" => '#FFFFFF',
	    'ttw_menubar_curpage_color' => '#BABABA',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_large_tagline" => true,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => '0',
            "ttw_after_header" => '15',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
	    'ttw_wide_top_bottom' => false,
	    'ttw_post_icons' => true,
	    'ttw_hide_post_fill' => true,
            'ttw_content_font' => 'Arial (sans-serif)',
            'ttw_small_content_font' => false,
            'ttw_title_font' => 'Arial (sans-serif)',
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => '#a0a0a0',
	    'ttw_hr_color' => '#a0a0a0',
            "ttw_title_color" => '#FFFFFF',
            "ttw_text_color" => '#FFFFFF',
	    "ttw_page_title_color" => '#FFFFFF',
            "ttw_content_color" => '#FFFFFF',
            "ttw_widget_title_color" => '#FFFFFF',
            "ttw_widget_color" => '#FFFFFF',
            "ttw_link_color" => '#DDDDDD',
            "ttw_link_visited_color" => '#EEEEEE',
            "ttw_link_hover_color" => '#AAAAAA',
            "ttw_wlink_color" => '#DDDDDD',
            "ttw_wlink_visited_color" => '#EEEEEE',
            "ttw_wlink_hover_color" => '#AAAAAA',
            "ttw_plink_color" => '#FFFFFF',
            "ttw_plink_visited_color" => '#FFFFFF',
            "ttw_plink_hover_color" => '#AAAAAA',
            "ttw_info_color" => '#BBBBBB',
            "ttw_ilink_color" => '#DDDDDD',
            "ttw_ilink_visited_color" => '#EEEEEE',
            "ttw_ilink_hover_color" => '#AAAAAA',
            "ttw_page_bgcolor" => 'transparent',
	    "ttw_main_bgcolor" => 'transparent',
            "ttw_content_bgcolor" => 'transparent',
	    'ttw_container_bgcolor' => 'transparent',
            "ttw_side1_bgcolor" => 'rgba(0,0,0,.2)',
            "ttw_side2_bgcolor" => 'rgba(0,0,0,.2)',
	    "ttw_side3_bgcolor" => 'rgba(0,0,0,.2)',
	    'ttw_stickypost_bgcolor' => '#666666',
	    'ttw_input_bgcolor' => '#666666',
	    "ttw_topbottom_bgcolor" => 'rgba(0,0,0,.2)',
	    "ttw_footer_bgcolor" => 'rgba(0,0,0,.3)',
            'ttw_body_bgcolor' => 'transparent',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => "Transparent Dark",
            'ttw_themedir' => 'transparentdark',
            'ttw_theme_description' => "A Trasparent theme for dark backgrounds. It <i>requires</i> a dark background image to look good.",
            'ttw_theme_image' => 'transparentdark.png',
	    "ttw_theme_head_opts" =>
'<style>h3#comments-title, h3#reply-title, .comment-author cite  { color: #F0F0F0;}
.comment-meta a:link, .comment-meta a:visited { color: #A0A0A0; }
.comment-meta a:active, .comment-meta a:hover, .reply a:hover, a.comment-edit-link:hover { color: #FFFFFF; }
#respond .required { color: #FFAAAA; } #respond label, #respond .form-allowed-tags { color: #A0A0A0; }</style>')
        ) ,
        array ( "name" => "Transparent Light", "def" => array (
            "ttw_menubar_color" => 'rgba(0,0,0,.3)',
            "ttw_menubar_hoverbg_color" => 'rgba(0,0,0,.15)',
            "ttw_menubar_text_color" => '#FFFFFF',
            "ttw_menubar_hover_color" => '#BDBDBD',
	    'ttw_menubar_curpage_color' => '#D6D6D6',
            "ttw_bold_menu" => 'checked',
	    "ttw_hide_menu" => false,
            "ttw_large_tagline" => true,
            "ttw_hide_site_title" => false,
            "ttw_header_image_height" => '0',
            "ttw_after_header" => '15',
            "ttw_sidebars" => false,
	    'ttw_hide_widg_pages' => false,
	    'ttw_hide_widg_posts' => false,
	    'ttw_wide_top_bottom' => false,
	    'ttw_post_icons' => true,
	    'ttw_hide_post_fill' => true,
            'ttw_content_font' => 'Arial (sans-serif)',
            'ttw_small_content_font' => false,
            'ttw_title_font' => 'Arial (sans-serif)',
            'ttw_rounded_corners' => false,
            'ttw_useborders' => false,
	    'ttw_footer_border_color' => '#191919',
	    'ttw_hr_color' => '#191919',
            "ttw_title_color" => '#000000',
            "ttw_text_color" => '#000000',
            "ttw_content_color" => '#000000',
            "ttw_widget_title_color" => '#000000',
            "ttw_widget_color" => '#000000',
            "ttw_link_color" => '#111199',
            "ttw_link_visited_color" => '#0c0c85',
            "ttw_link_hover_color" => '#1A32C9',
            "ttw_wlink_color" => '#111199',
            "ttw_wlink_visited_color" => '#0c0c85',
            "ttw_wlink_hover_color" => '#1A32C9',
            "ttw_plink_color" => '#000000',
            "ttw_plink_visited_color" => '#000000',
            "ttw_plink_hover_color" => '#1A32C9',
            "ttw_info_color" => '#4f4f4f',
            "ttw_ilink_color" => '#4f4f88',
            "ttw_ilink_visited_color" => '#4f4f77',
            "ttw_ilink_hover_color" => '#1A32C9',
            "ttw_page_bgcolor" => 'transparent',
	    "ttw_main_bgcolor" => 'transparent',
            "ttw_content_bgcolor" => 'transparent',
	    'ttw_container_bgcolor' => 'transparent',
            "ttw_side1_bgcolor" => 'rgba(0,0,0,.2)',
            "ttw_side2_bgcolor" => 'rgba(0,0,0,.2)',
	    "ttw_side3_bgcolor" => 'rgba(0,0,0,.2)',
	    "ttw_topbottom_bgcolor" => 'rgba(0,0,0,.2)',
	    "ttw_footer_bgcolor" => 'rgba(0,0,0,.3)',
            'ttw_body_bgcolor' => 'transparent',
            'ttw_fadebody_bg' => false,
            'ttw_wrap_shadow' => false,
            'ttw_themename' => "Transparent Light",
            'ttw_themedir' => 'transparentlight',
            'ttw_theme_description' => "A Trasparent theme for light backgrounds. It <i>requires</i> a light background image to look good.",
            'ttw_theme_image' => 'transparentlight.png',
	    "ttw_theme_head_opts" =>
'<style>input[type="text"], textarea, input[type=submit] { background: rgba(0,0,0,.2);color:#222222;} /* suitable for dark themes */
.home .sticky, #entry-author-info { border-top: 2px dotted #555; border-bottom: 2px dotted #555;}
ins {background:rgba(0,0,0,.2);}
h3#comments-title, h3#reply-title, .comment-author cite  { color: #444444;}
.comment-meta a:link, .comment-meta a:visited { color: #444488; }
.comment-meta a:active, .comment-meta a:hover, .reply a:hover, a.comment-edit-link:hover { color: #444488; }
#respond .required { color: #444444; } #respond label, #respond .form-allowed-tags { color: #444444; }</style>')
        )
    );

  }	/* end of block for my folding editor */

    $lim = count($ttw_themes);

    for ( $i = 0; $i < $lim; $i++ )
    {
        $needle = $ttw_themes[$i];
	$ttw_id = $needle['name'];
	if ( $ttw_id == $theme)
	{
            return $needle['def'];
        }
    }

    return false;
}

function st_build_theme_list() {
    // called when ttw-subthemes is loaded, it will build the list of themes once per session
    global $ttw_themeList, $ttw_fullThemeList;		// the default list and the master list

    $ttw_fullThemeList = array();		// start with empty list

    // first, build the list from built in themes
    foreach ($ttw_themeList as $name)	{	// this is the default list, sorted the way we want
	if ($name == 'My Saved Theme') {
	    $img = 'custom.png';
	    $desc = "Custom theme";
	} else {
	    $curTheme = st_get_theme($name);
	    if ($curTheme == '') {
		$img = 'custom.png';
		$desc = "Description not available";
	    } else {
		$img = $curTheme['ttw_theme_image'];
		$desc = $curTheme['ttw_theme_description'];
	    }
	}
	ttw_add_theme_to_list($name, $desc, get_template_directory_uri() . '/images/subthemes/' . $img);
    }

    do_action('ttwx_themes_add_to_list');		// let plugin themes add themeselves to end of the list
}

function ttw_add_theme_to_list($name, $description, $image) {
    // add a theme to the end of the theme list
    global $ttw_fullThemeList;
    $ttw_fullThemeList[$name]['name'] = $name;
    $ttw_fullThemeList[$name]['desc'] = $description;
    $ttw_fullThemeList[$name]['img'] = $image;
}

function st_pick_theme($altID) {
    // display a picker for the list of themes.
    global $ttw_fullThemeList;		// the master list

   /* define control items for theme picker */

    $curTheme = ttw_getopt('ttw_subtheme');
    $showImg = $ttw_fullThemeList[$curTheme]['img'];

    $selectID = 'ttw_subtheme'.$altID;	// allows more than one form on the same admin page
    $subName = 'setsubtheme'.$altID;

    ?>
    <form method="post">  <table class="optiontable">
     <tr>
	<th scope="row" align="right">Select a theme: &nbsp;</th>
	<td>
	<select <?php echo("name='$selectID' id='$selectID'"); ?> >
        <?php
	    foreach ($ttw_fullThemeList as $nextTheme) { ?>
	    <option<?php if ( $curTheme == $nextTheme['name']) {
		echo ' selected="selected"';
		}?>><?php echo $nextTheme['name']; ?></option>
	    <?php } ?>
 	</select>
	</td>
	<td><small>Select a predefined sub-theme from the list.</small></td>
	<td valign="middle">
	<?php echo("&nbsp; &nbsp;<small>Current theme: <strong>$curTheme</strong></small></td><td>");
	echo ("&nbsp;&nbsp;<img src='$showImg' width=67 height=50 />");
		?>
	</td>
	</tr>

	<tr><td>&nbsp;</td><td><span class='submit'><input <?php echo("name='$subName'"); ?> type='submit' value='Set to Selected Sub-Theme'/></span></td>
<?php if (is_multisite()) { ?>
                <td colspan=3><small><strong>Please note:</strong> Changing sub-theme will replace all your current "Main Options" settings. You can save them first with the "Save in My Saved Theme" button below.</small></td>
                </tr>
		<tr><td width='70px'>&nbsp;</td>
		<td><span class='submit'><input name='savemytheme' type='submit' value='Save in My Saved Theme'/></span></td>
		<td colspan='2'><small>Save <u>all</u> currently saved options as <strong>My Saved Theme</strong>.
 You will be able to restore these later by selecting <strong>My Saved Theme</strong>. Please note: be sure to click <em>Save Current Settings</em>
 on the Main Options panel first to save any changes you might have made.</td>
		</tr>
<?php } else { ?>
                <td colspan=3><small><strong>Please note:</strong> Changing sub-theme will replace <u>all</u> current "Main Options" settings,
                <u>plus</u> "Advanced Options" <em>Predefined Theme CSS Rules</em> settings. Other "Advanced Options" settings are <u>not</u> changed. (You can save all current settings from the Save/Restore tab).</small></td>
                </tr>
<?php }     /* end TTW_MULTISITE */ ?>
        </table>
	<?php ttw_nonce_field($subName); ttw_nonce_field('savemytheme'); ?>
	</form>
<?php
}

function st_show_subtheme_form() {
    st_pick_theme('2');
    ?>
    <form method='post'>
	<table cellspacing='10' cellpadding='5'>
		<tr><td width=70px'>&nbsp;</td>
		<td><span class='submit'><input name='savemytheme' type='submit' value='Save in My Saved Theme'/></span></td>
		<td><small>Save <u>all</u> currently saved options (both Main and Advanced) as <strong>My Saved Theme</strong>.
 You will be able to restore these later by selecting <strong>My Saved Theme</strong>.</td>
		</tr>
                <tr><td colspan=3>Theme name:&nbsp;
                <input name="newthemename" id="newthemename" type="text" value="<?php if ( ttw_getopt('ttw_themename') != "") { echo ttw_getopt('ttw_themename'); } else { echo ''; } ?>" />
                <span class='submit'><input name='changethemename' type='submit' value='Change Theme Name'/></span>&nbsp;<small>This name is used
                only here, but is preserved when you "Save" a theme using this admin tab.</small>
		</td></tr>
        </table>
	<?php ttw_nonce_field('savemytheme');
	ttw_nonce_field('changethemename'); ?>
    </form>
     <?php
}

function ttw_saverestore_admin() {
    /* admin tab for saving and restoring theme */

    $wpdir = wp_upload_dir();
    $ttw_theme_dir = $wpdir['baseurl'].'/weaver-subthemes/';

    $upload_link = ttw_write_current_theme('current_ttw_subtheme');	// make a temp copy
    ?>

    <h2>Save/Restore Themes</h2>
    <h4>You can save all the settings from the current theme by:</h4>
    <ol style="font-size: 85%">
    <li>"Save in My Saved Theme" - Saves a copy in server's database. Survives Weaver Theme updates. -or-</li>
   <li>Download current theme settings to a file on your own computer. -or-</li>
   <li>Save settings to a file on your Site's file system (in <?php echo($ttw_theme_dir);?>.</li></ol>

    <h4>You can restore a saved theme by:</h4>
    <ol style="font-size: 85%">
   <li>Picking "My Saved Theme" from the standard themes list. -or-</li>
   <li>Restoring a theme that you saved in a file on your site (to "My Saved Theme"). -or-</li>
   <li>Uploading a theme from a file saved on your own computer (to "My Saved Theme"). -or-</li>
    <li>Uploading a theme from a web based URL (to "My Saved Theme").</li></ol>
    <hr />
    <h3><span style="color:blue;">Use "My Saved Theme"</span></h3>
    <?php st_show_subtheme_form();    /* add the picker for subthemes */ ?>

    <hr />
    <h3><span style="color:blue;">Save Current Theme to File or Download to your computer</span></h3>
     <small><strong>Save</strong> <u>all</u> currently saved options (both Main and Advanced) either by downloading
    to <strong>your computer</strong> or saving a <strong>file</strong> on your Wordpress Site's <em><?php echo($ttw_theme_dir);?></em> directory.
    You will be able to restore this theme later using the <strong>Restore Theme</strong> button. Please note: be sure to click
    <em>Save Current Settings</em> first to save any changes you might have made.</small><br /><br />

  <strong>Save as file on this website's server</strong>
 <p>Please provide a name for your file, then click the "Save File" button. <b>Warning:</b> Duplicate names will automatically overwrite existing file without notification.</p>
 <form enctype="multipart/form-data" name='savetheme' method='post'><table cellspacing='10' cellpadding='5'>
    <table>
    <td>Name for saved theme: <input type="text" name="savethemename" size="30" />&nbsp;<small>(Please use a meaningful name - do not provide file extension. Name might be altered to standard form.)</small></td></tr>
	<tr>
	<td><span class='submit'><input name='filesavetheme' type='submit' value='Save File'/></span>&nbsp;&nbsp;
	<small><strong>Save Theme in File</strong> - Theme will be saved in <em><?php echo($ttw_theme_dir);?></em> directory on your site server.</small></td>
        </tr>
    </table>
    <?php ttw_nonce_field('filesavetheme'); ?>
 </form><br />

    <strong>Download to your computer</strong>

 <p>Please <em>right</em>-click <a href="<?php echo("$upload_link"); ?>"><strong>[* here *]</strong></a> to download the saved theme to your computer. </p>


<hr />

    <h3><span style="color:blue;">Restore Saved Theme from file or URL</span></h3>
    <small>You can restore a previously saved theme file, directly from your Wordpress
     Site's <em><?php echo($ttw_theme_dir);?></em> directory, from a file saved on your computer, or by providing an "http" URL address
     of the file (this might be from another site with Weaver themes). Note: after you restore a saved theme,
    it will be loaded into "My Saved Theme". If you've uploaded the theme from your computer or a URL, you might want to also then
    save a local copy on your website server.</small><br /><br />

    <form enctype="multipart/form-data" name='localrestoretheme' method='post'><table cellspacing='10' cellpadding='5'>
    <table>
    <tr><td><strong>Restore from file saved on this website's server</strong></td></tr>
    <tr>
        <td>Select theme file name: <?php ttw_subtheme_list('ttw_restorename'); ?>&nbsp;(Restores to "My Saved Theme")</td></tr>
	<tr>
	<td><span class='submit'><input name='restoretheme' type='submit' value='Restore Theme'/></span>&nbsp;&nbsp;
	<small><strong>Restore</strong> a theme you've previously uploaded to your site's <em><?php echo($ttw_theme_dir);?></em> directory. Will become current "My Saved Theme".</small></td>
    </tr>
        <tr><td>&nbsp;</td></tr>
    </table>
    <?php ttw_nonce_field('restoretheme') ; ?>
    </form>
    <form enctype="multipart/form-data" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST">
	<table>
            <tr><td><strong>Upload file saved on your computer</strong></td></tr>
		<tr valign="top">
			<td>Select theme file to upload: <input name="uploaded" type="file" />
			<input type="hidden" name="uploadit" value="yes" />&nbsp;(Restores to "My Saved Theme")
                        </td>
		</tr>
                <tr><td><span class='submit'><input name="uploadtheme" type="submit" value="Upload theme" /></span>&nbsp;<small><strong>Upload and Restore</strong> a theme from file on your computer. Will become current "My Saved Theme".</small></td></tr>
                <tr><td>&nbsp;</td></tr>
	</table>
	<?php ttw_nonce_field('uploadtheme'); ?>
    </form>

    <form enctype="multipart/form-data" name='upload-theme' method='post'><table cellspacing='10' cellpadding='5'>
    <table>
	<tr><td><strong>Restore from a URL</strong></td></tr>
        <tr><td>Enter theme file URL: <input type="text" name="ttw_uploadname" size="60" />&nbsp;(Restores to "My Saved Theme")</td></tr>
	<tr><td><span class='submit'><input name='uploadthemeurl' type='submit' value='Upload Theme from URL'/></span></td></tr>
	<tr><td><small><strong>Upload and Restore</strong> a theme from a web URL address. Will become current "My Saved Theme".</small></td></tr>
    </table>
    <?php ttw_nonce_field('uploadthemeurl'); ?>
    </form>
    <hr />

    <form enctype="multipart/form-data" name='maintaintheme' method='post'>
    <h3><span style="color:green;">Sub-theme Maintenance</span></h3>
        <?php ttw_subtheme_list('selectName'); ?>

        <span class='submit'><input name='deletetheme' type='submit' value='Delete Sub-Theme File'/></span>
          <strong>Warning!</strong>This action can't be undone, so be sure you mean to delete a file!
	  <?php ttw_nonce_field('deletetheme'); ?>
    </form>
    <hr />
<?php
}

function ttw_subtheme_list($lbl) {
    // output the form to select a file list from subtheme directory
?>
    <select name="<?php echo($lbl);?>" id="<?php echo($lbl);?>">
	    <option value="None">-- Select File --</option>
	    <?php
		// echo the theme file list
		$wpdir = wp_upload_dir();		// get the upload directory
                $ttw_theme_dir = $wpdir['basedir'].'/weaver-subthemes/';
		if($media_dir = opendir($ttw_theme_dir)){
		    while ($m_file = readdir($media_dir)) {
			if($m_file != "." && $m_file != ".." && $m_file[0]!='.' && $m_file != 'current_ttw_subtheme.wvr'){
			    echo '<option value="'.$m_file.'">'.$m_file.'</option>';
			}
		    }
		}
	    ?>
	</select>

    <?php
}

function ttw_write_current_theme($savefile) {
    // write the current theme to file, return true or false
    global $ttw_optionsList;

    ttw_saveopts(); // let's save it in case the user forgot (saves everything)

    $wpdir = wp_upload_dir();		// get the upload directory

    $save_dir = $wpdir['basedir'] . '/weaver-subthemes';
    $save_url = $wpdir['baseurl'] . '/weaver-subthemes';

    $usename = strtolower(sanitize_file_name($savefile));
    $usename = str_replace('.wvr','',$usename);
    if (strlen($usename) < 1) return '';
    $usename = $usename . '.wvr';

    $ttw_theme_dir_exists = wp_mkdir_p($save_dir);
    $ttw_theme_dir_writable = $ttw_theme_dir_exists;

    if (!$ttw_theme_dir_exists) {      // it either already exisits, or was created
	    echo '<div class="error"><p>';
	    echo 'It looks like <strong>'.$save_dir.'</strong> does not exist.<br /><br /> You will need to create this writeable directory in order to save sub-themes on your site.<br /><br />Maybe <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">This Article</a> from WordPress will help.';
	    echo '</p></div><br />';
    } else if (!is_writable($save_dir)) {
        if(!is_writable($save_dir)){
            echo '<div class="error"><p>';
	    echo 'It looks like <strong>'.$save_dir.'</strong> is not writable.<br /><br /> You will need to directory writable in order to save sub-themes on your site.<br /><br />Maybe <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">This Article</a> from WordPress will help.';
	    echo '</p></div><br />';
            $ttw_theme_dir_writable = false;
        }
    }
    if (!$ttw_theme_dir_writable) return '';

    $filename = $save_dir . '/'. $usename;    // we will add txt

    if ( !($handle = fopen($filename, 'w')) ) {
	?>
	    <h4>Sorry, something went wrong.</h4>
	    <p>We were unable to create the temporary file to save the theme on the server. It is likely
	    some kind of server file permission problem.</p>
	    <?php
	    return '';
	}
        fwrite($handle,"TTW-V01.10");		/* 10 byte header */

	/* copy all current settings to the $ttw_optionsList array so we can serialize it */
	foreach ($ttw_optionsList as $key => $val)
	{
		$curVal = ttw_getopt($key);
		$ttw_optionsList[$key] = $curVal;
	}
	/* ok, write that sucker out! */

	$tosave = serialize($ttw_optionsList);
	fwrite($handle, $tosave);
	fclose($handle);

        return $save_url . '/' . $usename;
}


 function ttw_upload_theme($filename) {

    $handle = fopen($filename,'r');
    if (!$handle) return ttw_file_fail("Can't open $filename");     	/* can't open */
    $contents = null;
    while ( !feof($handle) ) {
	$contents .= fread($handle, 1024);
    }

    fclose($handle);
    return ttw_save_serialized_theme($contents);
 }

 function ttw_save_serialized_theme($contents)  {
    global $ttw_optionsList;
    if (substr($contents,0,10) != "TTW-V01.10") return ttw_file_fail("Wrong theme file version"); 	/* simple check for one of ours */
    $restore = array();
    $restore = unserialize(substr($contents,10));

    if (!$restore) return ttw_file_fail("Unserialize failed");

    foreach ($ttw_optionsList as $key => $val) {               /* first, clear EVERYTHING in both current and mysaved */
	ttw_deleteopt( $key );
	ttw_deletemyopt( $key );
    }
    st_set_to_defaults();                                   /* now restore defaults - saved will override changes */

    /* now can set the new values from $restore */
    foreach ($restore as $rkey => $rval) {
	if ($rval != '') {
		ttw_setopt( $rkey, $rval ); /* and set both sets of values */
		ttw_setmyopt($rkey, $rval);
	}
    }
    ttw_setopt('ttw_subtheme', "My Saved Theme");
    ttw_saveopts();                                 /* and write them to db! */
    return true;
 }

function ttw_file_fail($msg) { // might someday do something with this
    ttw_debug($msg);
    return false;
}
?>
