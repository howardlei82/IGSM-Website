<?php
/* This file has most of the code for handling the Main Options, plus some utility functions */

/* some helper functions to access values */
function ttw_getopt_newcolor($color) {
    global $ttw_options;
    $stdval = '';
    foreach ($ttw_options as $value) {      /* scan options array to find std color value */
	if ($value['id'] == $color) {
	    $stdval = $value['std'];
            break;
	    }
	}
    $setcolor = ttw_getopt($color);
    if ($setcolor != $stdval)
        return $setcolor;
    return false;
}

function ttw_getopt_std($byid) {
	/* so we can see if we're using the default value */
    global $ttw_options;

    $lim = count($ttw_options);
    for ( $i = 0; $i < $lim; $i++ )
    {
        $value = $ttw_options[$i];
	$ttw_id = $value['id'];
	if ( $ttw_id == $byid )
	{
            return $value['std'];
        }
    }
    return false;
}

function t_get_font_value($byid) {
	/* get font value if not default */
	global $ttw_options;

	foreach ($ttw_options as $value) {
		if ($value['id'] == $byid) {
			$v = ttw_getopt($value['id']);
			if ($v == '') $v = $value['std'];
			if ($v == $value['std']) return '';
			return $v;
		}
	}
	return '';
}

function ttw_allow_multisite() {
    // return true if it is allowed to use on MultiSite
    return (!is_multisite() || current_user_can('install-themes') || TTW_MULTISITE_ALLOPTIONS);
}

function ttw_put_ttw_widgetarea($area,$style,$pagetype = false) {
    // emit ttw widget area depending on various settings (for page.php and index.php)

    $showwidg = !ttw_getopt($pagetype);
    if (is_front_page() && ttw_getopt('ttw_force_widg_frontpage')) $showwidg = true;

    if ($showwidg && is_active_sidebar($area)) { /* add top and bottom widget areas */
	ob_start(); /* let's use output buffering to allow use of Dynamic Widgets plugin and not have empty sidebar */
	$success = dynamic_sidebar($area);
	$content = ob_get_clean();
	if ($success) {
	    ?>
	    <div id=<?php echo ('"'.$style.'"'); ?> class="widget-area" role="complementary" ><ul class="xoxo">
	    <?php echo($content) ; ?>
	    </ul></div>
	    <?php }
	}
}

function ttw_put_area($name) {
    // for the extra code areas between major divs

    $area_name = 'ttw_' . $name . '_insert';
    $hide_front = 'ttw_hide_front_' . $name;
    $hide_rest = 'ttw_hide_rest_' . $name;

    if (ttw_getopt($area_name)) {	/* area insert defined? */
	if (is_front_page()) {
	    if (!ttw_getopt($hide_front)) echo (do_shortcode(str_replace("\\", "", ttw_getopt($area_name))));
	} else if (!ttw_getopt($hide_rest)) {
	    echo (do_shortcode(str_replace("\\", "", ttw_getopt($area_name))));
	}
    }
}

function ttw_the_excerpt_featured() {
    if (ttw_getopt('ttw_show_featured_image_excerptedposts')) {
	?>
	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', TTW_TRANS ),
	    the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
	<?php
    }
    the_excerpt();
}

function ttw_the_content_featured($arg) {
    if (ttw_getopt('ttw_show_featured_image_fullposts') || (ttw_getopt('ttw_always_excerpt') && ttw_getopt('ttw_show_featured_image_excerptedposts')) ) {
	?>
	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', TTW_TRANS ),
	    the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
	<?php
    }
    if (ttw_getopt('ttw_always_excerpt')) {
	the_excerpt();
    } else {
	the_content($arg);
    }
}

function ttw_the_content_featured_single() {
    if (ttw_getopt('ttw_show_featured_image_fullposts')) {
	?>
	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', TTW_TRANS ),
	    the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail-single' ); ?></a>
	<?php
    }
    the_content();
}

function ttw_browser_warning() {
	// Check for <= IE 7
    $browser = $_SERVER['HTTP_USER_AGENT'];
    if  ((false !== strpos($browser, 'MSIE 5') || false !== strpos($browser, 'MSIE 6') || false !== strpos($browser, 'MSIE 7')) &&
	!ttw_getadminopt('ttw_hide_IE_warning_css')) {
	echo('<p style="background: red; padding: 4px; padding-left:20px;font-size:small;">Warning: you are using an old version of
Internet Explorer. Please <a href="http://www.microsoft.com/downloads/en/default.aspx" target="_blank">upgrade</a> to IE 8 or later
for maximum site compatibility!</p>');
    }
}

function ttw_multi_col($content){
	// layout content into two colums, multiple rows using <!--more--> to split for 2 col template
	// derived from: http://www.robsearles.com/2009/07/05/wordpress-multiple-content-columns/

	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);

	// the first "more" is converted to a span with ID
	$columns = preg_split('/(<span id="more-\d+"><\/span>)|(<!--more-->)<\/p>/', $content);
	$col_count = count($columns);


	if($col_count > 1) {
	    for($i=0; $i < $col_count; $i++) {
		// check to see if there is a final </p>, if not add it
		if(!preg_match('/<\/p>\s?$/', $columns[$i]) )  {
		    $columns[$i] .= '</p>';
		}
		// check to see if there is an appending </p>, if there is, remove
		$columns[$i] = preg_replace('/^\s?<\/p>/', '', $columns[$i]);
		// now add the div wrapper
		if ((int)($i % 2) == 0) $coldiv = 'left'; else $coldiv = 'right';
		if ($coldiv == 'right' && ($i+1) < $col_count) {
		    $break_cols ='<hr /><div class="clear-cols"></div>';
		} else {
		    $break_cols = '';
		}
		$columns[$i] = '<div class="multi-content-col-'.$coldiv.'">'.$columns[$i] .'</div>' . $break_cols ;
	    }
	    $content = join($columns, "\n").'<div class="clear-cols"></div>';
	}
	else {
	    // this page does not have dynamic columns
	    $content = wpautop($content);
	}
	// remove any left over empty <p> tags
	$content = str_replace('<p></p>', '', $content);
	return $content;
}

define('TTW_DEBUG',false);
function ttw_debug($msg) {
    if (TTW_DEBUG) {
        echo("\n*******************>$msg<*******************<br />\n");
    }
}
?>
