<?php
    // Include only functions and data used in the admin panel.

function ttw_do_admin() {
/* theme admin page */

/* This generates the startup script calls, etc, for the admin page */
    global $ttw_optionsList, $ttw_myoptionsList, $ttw_options, $ttw_adminOpts, $ttw_adminOptsDefault, $ttw_optionsListDefault;

    if (!current_user_can('edit_theme_options')) wp_die("No permission to access that page.");

    $ttw_dir =	get_template_directory_uri();

    /* PROCESS $_POST VALUES FROM FORM SUBMISSION FIRST */

     /* First, process any actions from the buttons */

    if (ttw_submitted('saveoptions')) {
	// These options are defined in the Main Options form, and should all set
	// the default value when no value is set from the form.

        echo '<div id="message" class="updated fade"><p><strong>'.__("Twenty Ten Weaver main options saved.",TTW_TRANS).'</strong></p></div>';

	foreach ($ttw_options as $value) {			/* only reset main options so use $ttw_options */
	    $id = $value['id'];
	    $type = $value['type'];

	   if ($type == 'ctext') {
		if ( isset( $_POST[ $id ] ) ) {			// do the color part
                    $v = ttw_esc_code($_POST[$id]);
                    ttw_setopt( $id, $v );
                } else {
                    ttw_defaultopt( $id );
                }
		$css_id = $id . '_css';
		if ( isset( $_POST[ $css_id ] ) ) {		// do the CSS part
                    $v = ttw_esc_code($_POST[$css_id]);
		    if ((strpos($v, '{') === false) && strlen($v) > 0) {
			ttw_setopt( $css_id, '{' . $v . '}');	// tricky - allows them to add multiple rules, or sub-rules
		    }
		    else {
		        ttw_setopt( $css_id,  $v );
		    }
                } else {
                    ttw_setopt( $css_id, '/* NO OPTION SET*/' );
                }
	    } else {
		if ( isset( $_POST[ $id ] ) ) {
                    $v = ttw_esc_code($_POST[$id]);
                    ttw_setopt( $id, $v );
                } else {
                    ttw_defaultopt( $id );
                }
            }
	}
	ttw_saveopts();
    }

    if (ttw_submitted('saveadvanced')) {
        echo '<div id="message" class="updated fade"><p><strong>'.__("Twenty Ten Weaver advanced options saved.",TTW_TRANS).'</strong></p></div>';

        // THEME OPTS - advanced  theme opts - unlike the options from the Main Options form,
	// these options don't have default values, and thus use the ttw_post_xxx functions.

        ttw_post_opt('ttw_head_opts');
        ttw_post_opt('ttw_theme_head_opts');

        ttw_post_opt('ttw_footer_opts');
        ttw_post_opt('ttw_header_insert');
	ttw_post_opt_html('ttw_preheader_insert');
	ttw_post_opt_html('ttw_prefooter_insert');
	ttw_post_opt_html('ttw_postfooter_insert');
	ttw_post_opt_html('ttw_postheader_insert');
	ttw_post_opt_html('ttw_presidebar_insert');
	ttw_post_opt_html('ttw_custom_header_insert');
        ttw_post_opt('ttw_header_frontpage_only');
	ttw_post_opt('ttw_hide_front_preheader');
        ttw_post_opt('ttw_hide_rest_preheader');
	ttw_post_opt('ttw_hide_front_postheader');
        ttw_post_opt('ttw_hide_rest_postheader');
	ttw_post_opt('ttw_hide_front_prefooter');
        ttw_post_opt('ttw_hide_rest_prefooter');
	ttw_post_opt('ttw_hide_front_postfooter');
        ttw_post_opt('ttw_hide_rest_postfooter');
	ttw_post_opt('ttw_hide_front_presidebar');
        ttw_post_opt('ttw_hide_rest_presidebar');
	ttw_post_opt('ttw_hide_custom_header_template_menus');
	ttw_post_opt('ttw_hide_custom_header_template_siteinfo');
	ttw_post_opt('ttw_hide_blank_header');
	ttw_post_opt('ttw_hide_blank_footer');

        // ADMIN OPTS - per site tags - not theme related

        ttw_post_adminopt('ttw_hide_preview');
        ttw_post_adminopt('ttw_hide_theme_thumbs');
	ttw_post_adminopt('ttw_hide_auto_css_rules');
        ttw_post_adminopt('ttw_hide_metainfo');
        ttw_post_adminopt('ttw_metainfo');
        ttw_post_adminopt('ttw_end_opts');
	ttw_post_adminopt('ttw_copyright');
	ttw_post_adminopt('ttw_hide_poweredby');
	ttw_post_adminopt('ttw_force_inline_css');
	ttw_post_adminopt('ttw_hide_IE_warning_css');

        // NOW, save everything
	ttw_saveopts();
    }

    if (ttw_submitted('setsubtheme') || ttw_submitted('setsubtheme2')) {
	/* seems like Mozilla doesn't like 2 sets of select inputs on same page, so we make up 2 ids/names to use */

	if (isset($_POST['setsubtheme'])) $pID = 'ttw_subtheme';
	else $pID = 'ttw_subtheme2';

        $cur_subtheme = ttw_esc_code($_POST[ $pID]);	/* must have been set to get here */
        if ($cur_subtheme == '') $cur_subtheme = TTW_DEFAULT_THEME;	/* but just in case */

        /* now, i set all values for theme */
        st_set_subtheme($cur_subtheme);

        $t = ttw_getopt('ttw_subtheme'); if ($t == '') $t = TTW_DEFAULT_THEME;    /* did we save a theme? */
        echo '<div id="message" class="updated fade"><p><strong>'.__("Twenty Ten Weaver options reset to sub-theme: ",TTW_TRANS).$t.
	'.</strong></p></div>';
    }

    if (ttw_submitted('changethemename')) {

	if (isset($_POST['newthemename'])) {
            $new_name = sanitize_user($_POST['newthemename']);
            ttw_setopt('ttw_themename',$new_name);
            echo '<div id="message" class="updated fade"><p><strong>Theme name changed to '.$new_name.'</strong></p></div>';
        }
    }

    if (ttw_submitted('savemytheme')) {
	ttw_savemytheme();
	echo '<div id="message" class="updated fade"><p><strong>'.__('All current main and advanced options saved in <em>My Saved Theme</em>.',TTW_TRANS).'</strong></p></div>';
    }

    if (ttw_submitted('reset_weaver')) {
	// delete everything!
	echo '<div id="message" class="updated fade"><p><strong>All Weaver settings have been reset to the default.</strong></p></div>';
	delete_option('ttw_options');
	delete_option('ttw_myoptions');
	delete_option('ttw_adminoptions');

	$ttw_optionsList = $ttw_optionsListDefault;
	foreach ($ttw_options as $value ) {
	    ttw_defaultopt( $value['id'] );
	}

	$ttw_myoptionsList = $ttw_optionsList;
	$ttw_adminOpts = $ttw_adminOptsDefault;
	ttw_saveopts();
	st_set_subtheme(TTW_START_THEME);
    }

    if (ttw_submitted('filesavetheme')) {
        $base = strtolower(sanitize_file_name($_POST['savethemename']));
        $temp_url =  ttw_write_current_theme($base);
        if ($temp_url == '')
            echo '<div id="message" class="updated fade"><p><strong>Invalid name supplied to save theme to file.</strong></p></div>';
        else
            echo '<div id="message" class="updated fade"><p><strong>'.__("All current main and advanced options saved in $temp_url.",TTW_TRANS).'</strong></p></div>';
   }

    if (ttw_submitted('uploadtheme') &&  isset($_POST['uploadit']) && $_POST['uploadit'] == 'yes') {
        ttw_uploadit();
    }

    if (ttw_submitted('uploadthemeurl')) {
        // url method
        $filename = esc_url($_POST['ttw_uploadname'] );
	if (ttw_upload_theme($filename)) {
	    $t = ttw_getopt('ttw_subtheme'); if ($t == '') $t = TTW_DEFAULT_THEME;    /* did we save a theme? */
	    echo '<div id="message" class="updated fade"><p><strong>'.__("Twenty Ten Weaver theme options reset to uploaded theme, saved as: ",TTW_TRANS).$t.
		'.</strong></p></div>';
	} else {
	    echo ('<div id="message" class="updated fade"><p><strong><em style="color:red;">'.
		__('INVALID THEME URL PROVIDED - Try Again',TTW_TRANS).'</em></strong></p></div>');
	}
    }

    if (ttw_submitted('restoretheme')) {
        $wpdir = wp_upload_dir();
	$base = $_POST['ttw_restorename'];
	$valid = validate_file($base);		// make sure an ok file name
        $fn = $wpdir['basedir'].'/weaver-subthemes/'.$base;

	if ($valid < 1 && ttw_upload_theme($fn )) {
	    $t = ttw_getopt('ttw_subtheme'); if ($t == '') $t = TTW_DEFAULT_THEME;    /* did we save a theme? */
	    echo '<div id="message" class="updated fade"><p><strong>'.__("Twenty Ten Weaver theme restored from file, saved as: ",TTW_TRANS).$t.
		'.</strong></p></div>';
	} else {
	    echo ('<div id="message" class="updated fade"><p><strong><em style="color:red;">'.
		__('INVALID FILE NAME PROVIDED - Try Again',TTW_TRANS).'</em></strong></p></div>');
	}
    }

    if (ttw_submitted('deletetheme')) {
        $myFile = $_POST['selectName'];
	$valid = validate_file($myFile);
        if ($valid < 1 && $myFile != "None") {
            $wpdir = wp_upload_dir();
            unlink($wpdir['basedir'].'/weaver-subthemes/'.$myFile);
	    echo '<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p>File: <strong>'.$myFile.'</strong> has been deleted.</p></div>';
        } else {
	    echo '<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p>File: <strong>'.$myFile.'</strong> invalid file name, not deleted.</p></div>';
	}
    }

    if (ttw_submitted('ttw_save_extension')) {			/* for theme extensions */
	do_action('ttwx_save_extension');
    }
?>
<div style="float:left;"><h3><?php echo(TTW_THEMEVERSION); ?> Options</h3><a name="top_main" id="top_main"></a></div>
<div style="float:right;padding-right:30px;"><small><strong>Like Weaver? Please</strong></small>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="JUNTAHFM7YGYQ">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div><div style="clear:both;">

<div id="tabwrap">
  <div id="tab-container-1" class='yetii'>
    <ul id="tab-container-1-nav" class='yetii'>
	<li><a href="#tab0"><?php echo(__('Weaver Themes',TTW_TRANS)); ?></a></li>
	<li><a href="#tab1"><?php echo(__('Main Options',TTW_TRANS)); ?></a></li>
<?php	if (ttw_allow_multisite()) { ?>
	<li><a href="#tab2"><?php echo(__('Advanced Options',TTW_TRANS)); ?></a></li>
	<li><a href="#tab3"><?php echo(__('Save/Restore Themes',TTW_TRANS)); ?></a></li>
	<li><a href="#tab4"><?php echo(__('Snippets',TTW_TRANS)); ?></a></li>
	<?php	} ?>
	<li><a href="#tab7"><?php echo(__('CSS Help',TTW_TRANS)); ?></a></li>
	<li><a href="#tab5"><?php echo(__('Help',TTW_TRANS)); ?></a></li>
	<?php do_action('ttwx_add_extended_tab_title','<li><a href="#tab6">','</a></li>'); ?>
    </ul>

    <div id="tab0" class="tab" >
         <?php ttw_themes_admin(); ?>
    </div>
    <div id="tab1" class="tab" >
         <?php ttw_options_admin(); ?>
    </div>
<?php if (ttw_allow_multisite()) { ?>
    <div id="tab2" class="tab">
       <?php ttw_advanced_admin(); ?>
    </div>
    <div id="tab3" class="tab">
       <?php ttw_saverestore_admin(); ?>
    </div>
    <div id="tab4" class="tab">
       <?php ttw_snippets_admin(); ?>
    </div>
<?php } ?>
    <div id="tab7" class="tab">
       <?php ttw_csshelp_admin(); ?>
    </div>
    <div id="tab5" class="tab">
       <?php ttw_help_admin(); ?>
    </div>
    <?php do_action('ttwx_add_extended_tab','<div id="tab6" class="tab" >', '</div>'); /* extended option admin tab */ ?>

  </div>

<?php if (!ttw_getadminopt('ttw_hide_preview')) { ?>

<h3>Preview of site. Displays current look <em>after</em> you save options or select sub-theme.</h3>
<iframe id="preview" name="preview" src="<?php echo get_option('siteurl');  ?>?temppreview=true" style="width:100%;height:400px;border:1px solid #ccc"></iframe>
<?php } else { echo("<h3>Site Preview Disabled</h3>\n"); } ?>
</div>
    <script type="text/javascript">
	var tabber1 = new Yetii({
	id: 'tab-container-1',
	persist: true
	});
</script>
<?php
}	/* end ttw_do_admin */

function ttw_uploadit() {
    // upload theme from users computer
           // they've supplied and uploaded a file

	$ok = true;     // no errors so far

        if (isset($_FILES['uploaded']['name']))
            $filename = $_FILES['uploaded']['name'];
        else
            $filename = "";

        if (isset($_FILES['uploaded']['tmp_name'])) {
            $openname = $_FILES['uploaded']['tmp_name'];
        } else {
            $openname = "";
        }

	//Check the file extension
	$check_file = strtolower($filename);
	$ext_check = end(explode('.', $check_file));

	if ($filename == "") {
	    $errors[] = "You didn't select a file to upload<br />";
	    $ok = false;
	}

	if ($ok && $ext_check != 'wvr'){
	    $errors[] = "Theme files must have <em>.wvr</em> extension.<br />";
	    $ok = false;
	}

        if ($ok) {
            $handle = fopen($openname,'r');     // now try to open the uploaded file
            if (!$handle) {
                $errors[] = '<strong><em style="color:red;">'.
                 __('Sorry, there was a problem uploading your file. You may need to check your folder permissions or other server settings.',TTW_TRANS).'</em></strong>'.
                    "<br />(Trying to use file '$openname')";
                $ok = false;
            }
        }

	if (!$ok) {
	    echo '<div id="message" class="updated fade"><p><strong><em style="color:red;">ERROR</em></strong></p><p>';
	    foreach($errors as $error){
		echo $error.'<br />';
	    }
	    echo '</p></div>';
	} else {    // OK - read file and save to My Saved Theme
            // $handle has file handle to temp file.
            $contents = null;
            while ( !feof($handle) ) {
                $contents .= fread($handle, 1024);
            }
            fclose($handle);

            if (!ttw_save_serialized_theme($contents)) {
                echo '<div id="message" class="updated fade"><p><strong><em style="color:red;">'.
                __('Sorry, there was a problem uploading your file. The file you picked was not a valid Weaver theme file.',TTW_TRANS).'</em></strong></p></div>';
	    } else {
                $t = ttw_getopt('ttw_subtheme'); if ($t == '') $t = TTW_DEFAULT_THEME;    /* did we save a theme? */
                echo '<div id="message" class="updated fade"><p><strong>'.__("Twenty Ten Weaver theme options reset to uploaded theme, saved as: ",TTW_TRANS).$t.
                    '.</strong></p></div>';
            }
        }
}

function ttw_submitted($submit_name) {
    // do a nonce check for each form submit button
    // pairs 1:1 with ttw_nonce_field
    $nonce_act = $submit_name.'_act';
    $nonce_name = $submit_name.'_nonce';

    if (isset($_POST[$submit_name])) {
	if (isset($_POST[$nonce_name]) && wp_verify_nonce($_POST[$nonce_name],$nonce_act)) {
	    return true;
	} else {
	    die("WARNING: invalid form interaction detected ($submit_name). Failed security check: please contact wpweaver.info if you continue to receive this message.");
	}
    } else {
	return false;
    }
}

function ttw_nonce_field($submit_name) {
    // pairs 1:1 with ttw_sumbitted
    // will be one for each form submit button

    wp_nonce_field($submit_name.'_act',$submit_name.'_nonce');

}

function ttw_post_adminopt($optname) {
    if (isset($_POST[$optname]))
	ttw_setadminopt($optname, ttw_esc_code($_POST[$optname]));
    else
	ttw_deleteadminopt($optname);
}

function ttw_post_opt($optname) {
    if (isset($_POST[$optname]))
	ttw_setopt($optname, ttw_esc_code($_POST[$optname]));
    else
	ttw_deleteopt($optname);
}

function ttw_post_opt_html($optname) {
    // these options are html, but even wp's esc_html breaks user input.
    // For example, &nbsp; is changed to a blank, which is NOT what is
    // desired behavior. Someday, might build a better filter, but for
    // now, let the user do what they need to do!
    if (isset($_POST[$optname]))
	ttw_setopt($optname, ttw_esc_code($_POST[$optname]));
    else
	ttw_deleteopt($optname);
}

/**
 * Escaping for raw code.
 */
function ttw_esc_code( $text ) {
    // virtually all option input from Weaver can be code, and thus must not be
    // content filtered. The utf8 check is about the extent of it, although even
    // that is more restrictive than the standard text widget uses.
    // Note: this check also works OK for simple checkboxes/radio buttons/selections,
    // so it is ok to blindly pass those options in here, too.

    return wp_check_invalid_utf8( $text );
}

function ttw_options_admin() {
/* theme admin page - Main Options tab */
	global $ttw_options;
        ?>
<h3>Main Options</h3>
<p><strong>Main color<a href="#color_note">*</a> and appearance options</strong><br />
The main options are organized as <a href="#ttw_general_appearance">General Appearance</a>,
<a href="#ttw_header_options">Header Options</a>,
<a href="#ttw_footer_appearance">Footer Options</a>,
<a href="#ttw_content_appearance">Content Areas</a>,
<a href="#ttw_post_appearance">Post Page Specifics</a>, and
<a href="#ttw_widget_appearance">Widget Areas</a>.</p>
<?php
	mytheme_put_main_options_form($ttw_options, "saveoptions","Save Current Settings", true);
        echo "</br><a name='color_note'></a><small>* Note: color value boxes also allow text such as <em>blue, inherit , transparent, rgba(),</em> etc.
	The values are not checked for valid color attributes.</small>&nbsp;&nbsp;&nbsp;<a href=\"#top_main\">top</a>";
}

function mytheme_put_main_options_form($ttw_options_list, $actname, $flabel, $showFirstInput) {
    /* output a list of options - this really does the layout for the options defined in an array */

    echo '<form method="post">  <table class="optiontable">' ."\n";

    if ($showFirstInput) {          /* maybe show extra submit button at top */
	// Don't change this - IE8 an IE9 have troubles if not done this way.
        // echo("<span class='submit'><input name='$actname' type='submit' value='$flabel' class = 'button-primary' /></span><br />");
	echo("<input name='$actname' type='submit' value='$flabel' class = 'button-primary' /><br />");

    }

    foreach ($ttw_options_list as $value) {
	if ($value['type'] == "text") { ?>
		<tr>
		<th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
		<td>
		<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" style="width:80px" class="regular-text" value="<?php if ( ttw_getopt( $value['id'] ) != "") { echo ttw_getopt( $value['id'] ); } else { echo $value['std']; } ?>" />
		</td>
		<?php if ($value['info'] != '') {
		    echo('<td style="padding-left: 10px"><small>'); echo $value['info']; echo("</small></td>");
		} ?>
		</tr>
	<?php } elseif ($value['type'] == "ctext") {
                $pclass = 'color {hash:true, adjust:false}';    // starting with V 1.3, allow text in color pickers
		$img_css = '<img src="'. get_template_directory_uri() . '/images/weaver/css.png" />' ;
		$img_hide = get_template_directory_uri() . '/images/weaver/hide.png' ;
		$img_show = get_template_directory_uri() . '/images/weaver/show.png' ;
		$help_file = get_template_directory_uri() . '/css-help.html';
		$css_id = $value['id'] . '_css';
		$css_id_text = ttw_getopt($css_id);
		if ($css_id_text && !ttw_getadminopt( 'ttw_hide_auto_css_rules' )) {
		    $img_toggle = $img_hide;
		} else {
		    $img_toggle = $img_show;
		}
        ?>
		<tr>
		<th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
		<td>
		<input class="<?php echo $pclass; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" style="width:110px" value="<?php if ( ttw_getopt( $value['id'] ) != "") { echo ttw_getopt( $value['id'] ); } else { echo $value['std']; } ?>" />
		<?php echo $img_css; ?><a href="javascript:void(null);"
			onclick="wvr_ToggleRowCSS(document.getElementById('<?php echo $css_id . '_js'; ?>'), this, '<?php echo $img_show; ?>', '<?php echo $img_hide; ?>')"><?php echo '<img src="' . $img_toggle . '" />'; ?></a>
		</td>
		<?php if ($value['info'] != '') {
		    echo('<td style="padding-left: 10px"><small>'); echo $value['info']; echo("</small></td>");
		} ?>
		</tr>
		<?php if ($css_id_text && !ttw_getadminopt( 'ttw_hide_auto_css_rules' )) { ?>
		<tr id="<?php echo $css_id . '_js'; ?>">
		<th scope="row" align="right"><span style="color:green;"><small>Custom CSS styling:</small></span></th>
		<td align="right"><small>&nbsp;</small></td>
		<td>
		    <small>You can enter CSS rules, enclosed in {}'s, and separated by <strong>;</strong>.
		    See <a href="<?php echo $help_file; ?>" target="_blank">CSS Help</a> for more details.</small><br />
		    <textarea name="<?php echo $css_id; ?>" rows=1 style="width: 85%"><?php echo(str_replace("\\", "", $css_id_text)); ?></textarea>
		</td>
		<?php } else { ?>
		<tr id="<?php echo $css_id . '_js'; ?>" style="display:none;">
		<th scope="row" align="right"><span style="color:green;"><small>Custom CSS styling:</small></span></th>
		<td align="right"><small>&nbsp;</small></td>
		<td>
		    <small>You can enter CSS rules, enclosed in {}'s, and separated by <strong>;</strong>.
		    See <a href="<?php echo $help_file; ?>" target="_blank">CSS Help</a> for more details.</small><br />
		    <textarea name="<?php echo $css_id; ?>" rows=1 style="width: 85%"><?php echo(str_replace("\\", "", $css_id_text)); ?></textarea>
		</td>
		<?php } ?>
	<?php } elseif ($value['type'] == "checkbox") { ?>
		<tr>
		<th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
		<td>
		<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" <?php echo (ttw_getopt( $value['id'] ) ? "checked" : ""); ?> >
		</td>
		<?php if ($value['info'] != '') {
		    echo('<td style="padding-left: 10px"><small>'); echo $value['info']; echo("</small></td>");
		} ?>
	<?php } elseif ($value['type'] == "link_checkbox") { 	// full implementation in next version ?>
		<tr>
		<th scope="row" align="right"><small>Options</small>:&nbsp;</th>
		<td>
		<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" <?php echo (ttw_getopt( $value['id'] ) ? "checked" : ""); ?> >
		</td>
		<?php if ($value['info'] != '') {
		    echo('<td style="padding-left: 10px"><small>'); echo $value['info']; echo("</small></td>");
		} ?>
	<?php } elseif ($value['type'] == "select") { ?>
		<tr>
		<th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
		<td>
		<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                <?php foreach ($value['value'] as $option) { ?>
                <option<?php if ( ttw_getopt( $value['id'] ) == $option) { echo ' selected="selected"'; }?>><?php echo $option; ?></option>
                <?php } ?>
		</select>
		</td>
		</td>
		<?php if ($value['info'] != '') {
		    echo('<td style="padding-left: 10px"><small>'); echo $value['info']; echo("</small></td>");
		} ?>
		</tr>
        <?php } elseif ($value['type'] == "imgselect") {
                /* special handling of bullet images - will add the bullet image to each item */ ?>
		<tr>
		<th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
		<td>
		<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                <?php

                foreach ($value['value'] as $opt) {
                    $img = get_template_directory_uri() . '/images/bullets/' . $opt . '.gif';
                    if ($opt == '')     /* special case - the empty default option */
                        $style = '';
                    else
                        $style = ' style="background-image:url('. $img . ');background-repeat:no-repeat;padding-left:16px;height:16px;line-height:16px;"';

                    if (ttw_getopt( $value['id'] ) == $opt)
                        $sel = ' selected="selected" ';
                    else
                        $sel = '';
                    printf('<option%s%s>%s</option>',$sel,$style,$opt); echo("\n");
                }
                ?>
                </select>
		</td>
		</td>
		<?php if ($value['info'] != '') {
		    echo('<td style="padding-left: 10px"><small>'); echo $value['info']; echo("</small></td>");
		} ?>
		</tr>
	<?php } elseif ($value['type'] == "header") { ?>
		<tr>
		<th scope="row" align="left"><?php
		echo '<a name="'. $value['id'] . '" id="' . $value['id'] .'"></a><br /><span style="color:blue;"><em><u>'.$value['name'].'</u></em></span>'; ?></th>
		<?php if ($value['info'] != '') {
		    echo('<td>&nbsp;</td><td style="padding-left: 10px"><small><em><u>'); echo $value['info'];
		    echo("</u></em></small>&nbsp;&nbsp;&nbsp;<a href=\"#top_main\">top</a></td>");
		} ?>
		</tr>
	<?php }
	} ?>
 </table>
	<br />
	<input name="<?php echo($actname); ?>" type="submit" value="<?php echo($flabel); ?>" class = "button-primary" />
	<input type="hidden" name="action" value="<?php echo($actname); ?>" />
	<?php ttw_nonce_field($actname); ?>
	<br /><br />
</form>
<?php
}

// now that we are in the admin code, we can load the rest of the stuff needed
require_once('ttw-subthemes.php');
require_once('ttw-advancedopts.php');
require_once('ttw-help.php');
?>
