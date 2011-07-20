<?php
/* admin tab for Advanced Options */

function ttw_advanced_admin() {
    global $ttw_options;

    $myName = esc_attr( get_bloginfo( 'name', 'display' ) );
    $myDescrip = esc_attr( get_bloginfo( 'description', 'display' ) );
    if (strcasecmp($myDescrip,'Just another WordPress site') == 0) $myDescrip = '';

    $headText = "<!-- Add your own CSS snippets between the style tags. -->
<style type=\"text/css\">
</style>";
    $SEOText = "<meta name=\"description\" content=\" $myName - $myDescrip \" />
<meta name=\"keywords\" content=\"$myName blog, $myName\" />";

    if (!ttw_getopt('ttw_head_opts'))
	ttw_setopt('ttw_head_opts', $headText);		// fill in something first time
    if (ttw_getadminopt('ttw_metainfo') == '' && !ttw_getadminopt('ttw_hide_metainfo'))
	ttw_setadminopt('ttw_metainfo', $SEOText);	// fill in something first time
   ?>

    <div style="padding-right: 20px;">

        <form name="ttw_options_form" method="post">
	    <input type="hidden" name="updated" value="1" />

	    <h3>Advanced Options </h3>
	    <p><strong>Advanced Options - Insert your own code or snippets</strong>
<?php /*
	    <div style="float:right; width:33%; border:1px solid #888; padding-left:8px;"><small>Are you a professional website designer?
	    If Weaver is helping you do your job, please make a donation to this theme!</small></div> */
?>
	    </p>

	    <br /><input type="submit" name="saveadvanced" value="Update Advanced Options" class="button-primary" /><br /><br />

	    <fieldset class="options">
		<p>This page has options for more advanced control of your site. Many of the fields on this page allow you to
		add HTML code (sometimes required by third-party plugins and widgets). While you can copy/paste/edit many of
		the CSS Snippets provided from the <b>Snippets</b> tab, it may be helpful if you understand a bit about
		HTML coding to used these fields most effectively.</p>

		<p>The values you put here are saved in the WordPress database, and will survive theme upgrades and other changes.</p>

		<p>PLEASE NOTE: NO validation is made on the field values, so be careful not to paste invalid code.
                Invalid code is usually harmless, but it can make your site display incorrectly. If your site looks broken after make changes here,
                please double check that what you entered uses valid HTML or CSS rules. Also note that backslashes will be stripped.</p>

                <hr />

		 <!-- ======== -->

		<label><span style="color:blue;"><b>&lt;HEAD&gt; Section</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>

                This input area is one of the most important options in Weaver for customizing your site.
		Code entered into this box is included right before the &lt;/HEAD&gt; tag in your site. The most important
		use for this area is to enter custom CSS rules to control the look of your site. Note: The <b>Snippets</b>
		tab (above) contains many examples of CSS rules to customize your site.
		<small>This field can also for entering JavaScript or links to JavaScript files or anything else that
                belongs in the &lt;HEAD&gt;. For example, Google Analytics code belongs here.</small>
		<br />

		<textarea name="ttw_head_opts" rows=7 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getopt('ttw_head_opts'))); ?></textarea>
                <br /><br />

		<!-- ==================================================== -->
		<hr />
		<label><span style="color:blue; font-weight:bold; font-size: larger;">HTML Code Insertion Areas</span></label><br />
		The following options allow you to insert HTML code into various regions of you page. These areas must use
		HTML markup code, and all can include <a href="http://codex.wordpress.org/Shortcode" target="_blank">WP shortcodes</a>.
		<em>Important:</em> You almost certainly will need to provide CSS styling rules for these code blocks, either as in-tag
		<em>style="..."</em> rules, or by adding CSS rules the the &lt;HEAD&gt; Section above.
		<br /><small>Note: Providing <em>margin</em> style values, including negative values, can be used to control the spacing
		before and after these code blocks.</small>
		<br /><br />

		<!-- ======== -->

		<label><span style="color:blue;"><b>Pre-Header Code</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
                This code will be inserted right before the header area (between the "wrapper" and the "header" div tags), above the
		menus and site image. This block also can be used as an alternative to the Weaver Header Widget Area.
		<br />
		<textarea name="ttw_preheader_insert" rows=3 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getopt('ttw_preheader_insert'))); ?></textarea>
		<br />
		<label>Hide on front page: </label><input type="checkbox" name="ttw_hide_front_preheader" id="ttw_hide_front_preheader" <?php echo (ttw_getopt( 'ttw_hide_front_preheader' ) ? "checked" : ""); ?> />
		<small>If you check this box, then the code from this area will not be displayed on the front (home) page.</small><br />
		<label>Hide on non-front pages: </label><input type="checkbox" name="ttw_hide_rest_preheader" id="ttw_hide_rest_preheader" <?php echo (ttw_getopt( 'ttw_hide_rest_preheader' ) ? "checked" : ""); ?> />
		<small>If you check this box, then the code from this area will not be displayed on non-front pages.</small>
		<br /><br />

		<!-- ======== -->

		<label><span style="color:blue;"><b>Site Header Insert Code</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
		This code HTML will be inserted into the <em>#branding div</em> header area right above where the standard site
		header image goes. You can use it for logos, better site name text - whatever. When used in combination with hiding the site title,
		header image, and the menu, you can design a completely custom header. If you hide the title, image, and header, no other code is generated
		in the #branding div, so this code can be a complete header replacement. You can also use WP shortcodes to embed plugins, including
		rotating image slideshows such as <a href="http://www.jleuze.com/plugins/meteor-slides/" target="_blank">Meteor Slides</a>.
		And Weaver automatically supports the
		<a href="http://wordpress.org/extend/plugins/dynamic-headers/" target="_blank">Dynamic Headers</a> plugin which allows you
		create highly dynamic headers from its control panel - just install and it will work without any other code edits.
		<br />
		<textarea name="ttw_header_insert" rows=3 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getopt('ttw_header_insert'))); ?></textarea>
		<br />
		<label>Insert on Front Page Only: </label><input type="checkbox" name="ttw_header_frontpage_only" id="ttw_header_frontpage_only" <?php echo (ttw_getopt( 'ttw_header_frontpage_only' ) ? "checked" : ""); ?> />
		<small>If you check this box, then this Header code will be used only when the front page is displayed. Other
		pages will be displayed using normal header settings. Checking this will also automatically hide the standard
		header image on the front page so you can use a slide show on the front page, and standard header images on other pages.</small>
		<br /><br />

		<!-- ======== -->

		<label><span style="color:blue;"><b>Post-Header Code</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
                This code will be inserted right after the header area and before the main content area (between the "header"
		and the "main" div tags), below the menus and site image.
		<br />
		<textarea name="ttw_postheader_insert" rows=3 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getopt('ttw_postheader_insert'))); ?></textarea>
		<br />
		<label>Hide on front page: </label><input type="checkbox" name="ttw_hide_front_postheader" id="ttw_hide_front_postheader" <?php echo (ttw_getopt( 'ttw_hide_front_postheader' ) ? "checked" : ""); ?> />
		<small>If you check this box, then the code from this area will not be displayed on the front (home) page.</small><br />
		<label>Hide on non-front pages: </label><input type="checkbox" name="ttw_hide_rest_postheader" id="ttw_hide_rest_postheader" <?php echo (ttw_getopt( 'ttw_hide_rest_postheader' ) ? "checked" : ""); ?> />
		<small>If you check this box, then the code from this area will not be displayed on non-front pages.</small>
		<br /><br />

		<!-- ======== -->

		<label><span style="color:blue;"><b>Pre-Footer Code</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
                This code will be inserted right after the main content area and before the footer area (between the "main"
		and the "footer" div tags).
		<br />
		<textarea name="ttw_prefooter_insert" rows=3 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getopt('ttw_prefooter_insert'))); ?></textarea>
		<br />
		<label>Hide on front page: </label><input type="checkbox" name="ttw_hide_front_prefooter" id="ttw_hide_front_prefooter" <?php echo (ttw_getopt( 'ttw_hide_front_prefooter' ) ? "checked" : ""); ?> />
		<small>If you check this box, then the code from this area will not be displayed on the front (home) page.</small><br />
		<label>Hide on non-front pages: </label><input type="checkbox" name="ttw_hide_rest_prefooter" id="ttw_hide_rest_prefooter" <?php echo (ttw_getopt( 'ttw_hide_rest_prefooter' ) ? "checked" : ""); ?> />
		<small>If you check this box, then the code from this area will not be displayed on non-front pages.</small>
		<br /><br />

		<!-- ======== -->

		<label><span style="color:blue;"><b>Site Footer Area Code</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
                This code will be inserted into the site footer area, right before the before the "Powered by" credits, but after any Footer widgets. This
                could include extra information, visit counters, etc.
		<br />
		<textarea name="ttw_footer_opts" rows=3 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getopt('ttw_footer_opts'))); ?></textarea>
		<br /><br />

		<!-- ======== -->

		<label><span style="color:blue;"><b>Post-Footer Code</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
                This code will be inserted right after the footer area (between the "footer" and the "wrapper" /div tags).
		<br />
		<textarea name="ttw_postfooter_insert" rows=3 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getopt('ttw_postfooter_insert'))); ?></textarea>
		<br />
		<label>Hide on front page: </label><input type="checkbox" name="ttw_hide_front_postfooter" id="ttw_hide_front_postfooter" <?php echo (ttw_getopt( 'ttw_hide_front_postfooter' ) ? "checked" : ""); ?> />
		<small>If you check this box, then the code from this area will not be displayed on the front (home) page.</small><br />
		<label>Hide on non-front pages: </label><input type="checkbox" name="ttw_hide_rest_postfooter" id="ttw_hide_rest_postfoter" <?php echo (ttw_getopt( 'ttw_hide_rest_postfooter' ) ? "checked" : ""); ?> />
		<small>If you check this box, then the code from this area will not be displayed on non-front pages.</small>
		<br /><br />

		<!-- ======== -->

		<label><span style="color:blue;"><b>Pre-Sidebar Code</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
                This code will be inserted right above the first sidebar area. <small>(Note: some HTML elements may require using 'style="display:inline"' to avoid
		display over entire page width. This also doesn't work well with the "Two, left and right sides" sidebar arrangement.)</small>
		<br />
		<textarea name="ttw_presidebar_insert" rows=3 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getopt('ttw_presidebar_insert'))); ?></textarea>
		<br />
		<label>Hide on front page: </label><input type="checkbox" name="ttw_hide_front_presidebar" id="ttw_hide_front_presidebar" <?php echo (ttw_getopt( 'ttw_hide_front_presidebar' ) ? "checked" : ""); ?> />
		<small>If you check this box, then the code from this area will not be displayed on the front (home) page.</small><br />
		<label>Hide on non-front pages: </label><input type="checkbox" name="ttw_hide_rest_presidebar" id="ttw_hide_rest_presidebar" <?php echo (ttw_getopt( 'ttw_hide_rest_presidebar' ) ? "checked" : ""); ?> />
		<small>If you check this box, then the code from this area will not be displayed on non-front pages.</small>
		<br /><br />
		<!-- ================================================================= -->

		<input type="submit" name="saveadvanced" value="Update Advanced Options" class="button-primary" /><br />
		<hr />
		<label><span style="color:#a44; font-weight:bold; font-size: larger;">Custom Page Template Options</span></label><br />
		<small>Weaver includes several page templates. Some have extra options here. * The <em>2 Col Content</em> template splits content into two columns.
		you manually set the column split using the standard WP '&lt;--more-->' convention. Columns will split first horizontally, then vertically (you
		can have more than one &lt;--more--> tag). * The <em>Alternative Sidebar</em> templates have a single, fixed width sidebar that uses only the
		<em>Alternative Widget Area</em>. * The <em>One column, no sidebar</em> template produces a single content column with no sidebars. * The
		other templates are explained below.</small><br /><br />

		<label><span style="color:#bb2222;"><b>"Custom Header Page Template" Code and Options</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
		<small>This block functions exactly the same as <strong>Site Header Insert Code</strong> when used with pages created with the
		<em>Custom Header (see Adv Opts admin)</em> page template. The template creates pages that use
		only this code to display a header (they don't use the standard site header image), plus the options below.</small>
		<br />
		<textarea name="ttw_custom_header_insert" rows=2 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getopt('ttw_custom_header_insert'))); ?></textarea>
		<br />
		<label>Hide Menus on Custom Header pages:
		 </label><input type="checkbox" name="ttw_hide_custom_header_template_menus" id="ttw_hide_custom_header_template_menus" <?php echo (ttw_getopt( 'ttw_hide_custom_header_template_menus' ) ? "checked" : ""); ?> />
		<small>If you check this box, then pages created using the <em>Custom Header</em> template will not display the standard menus.</small>
		<br />
		<label>Hide Site Title/Description on Custom Header pages: </label>
		 <input type="checkbox" name="ttw_hide_custom_header_template_siteinfo" id="ttw_hide_custom_header_template_siteinfo" <?php echo (ttw_getopt( 'ttw_hide_custom_header_template_siteinfo' ) ? "checked" : ""); ?> />
		<small>If you check this box, then pages created using the <em>Custom Header</em> template will not display the Site title or description.</small>
		<br /><br />

		<!-- ======== -->

		<label><span style="color:#bb2222;"><b>"Blank Page Template" Options</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
		<small>The <em>Blank - (see Adv Opts admin)</em> page template will wrap the content of an associated page only
		with the '#wrapper' HTML div surrounding the optional #header and #footer divs, and the #main div for the actual content.
		('&lt;div id="wrapper">&lt;div id="header">header&lt;/div>&lt;div id="main">Content of page&lt;/div>&lt;div id="footer">footer&lt;/div>').
		It does not include the page's title or other info. You will probably want to wrap your content in its own div with styling defined
		by a class added to the &lt;HEAD> Section. The following options allow you to hide the header and footer from the page.</small>
		<br />
		<label>Hide Header on Blank pages:
		 </label><input type="checkbox" name="ttw_hide_blank_header" id="ttw_hide_blank_header" <?php echo (ttw_getopt( 'ttw_hide_blank_header' ) ? "checked" : ""); ?> />
		<small>If you check this box, then pages created using the <em>Blank</em> template will not display the standard header, including the image and menus.</small>
		<br />
		<label>Hide Footer on Blank pages: </label>
		 <input type="checkbox" name="ttw_hide_blank_footer" id="ttw_hide_blank_footer" <?php echo (ttw_getopt( 'ttw_hide_blank_footer' ) ? "checked" : ""); ?> />
		<small>If you check this box, then pages created using the <em>Blank</em> template will not display the standard footer area.</small>
		<br /><br />

		<!-- ======== -->

		<label><span style="color:#8888FF;"><b>Predefined Theme CSS Rules</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
		<small>Beginning with Weaver Version 1.5, this area is essentially unnecessary. If a predefined theme
		requires some CSS that can't be applied with a Main Options CSS rule, then that CSS will appear here.
		You may edit it if needed to make your own theme work. If you are defining a theme you want to share, you should move any definitions from
		the &lt;HEAD&gt; Section to here for your final version. That will leave the &lt;HEAD&gt; Section empty for others to add more customizations.
		This code is included before the &lt;HEAD&gt; Section code in the final HTML output file.</small>
		<br />
		<textarea name="ttw_theme_head_opts" rows=2 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getopt('ttw_theme_head_opts'))); ?></textarea>

		<!-- ===================================================== -->
		<hr />
		<label><span style="color:#4444CC; font-weight:bold; font-size: larger;">Site Options</span></label><br />
		The following options are related to the current site. There are also some administrative options. These
		options are <strong>not</strong> considered to be a part of the theme, and are not saved in the theme
		settings file when you save a theme. These options are saved in the WP database, and will survive an
		upgrade to a new Weaver version. (The settings above this section are all saved when you save your theme settings.)
		<hr />
                <label><span style="color:#4444CC;"><b>SEO Tags</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
		<small>Every site should have at least "description" and "keywords" meta tags
		for basic SEO (Search Engine Optimization) support. Please edit these tags to provide more information about your site, which is inserted
		into the &lt;HEAD&gt; section of your site. You might want to check out other WordPress SEO plugins if you need more advanced SEO. Note
		that this information is not part of your theme settings, and will not be included when you save or restore your theme.</small>
		<br />

		<textarea name="ttw_metainfo" rows=2 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getadminopt('ttw_metainfo'))); ?></textarea>
		<br>
                <label>Don't add SEO meta tags: </label><input type="checkbox" name='ttw_hide_metainfo' id='ttw_hide_metainfo' <?php echo (ttw_getadminopt( 'ttw_hide_metainfo' ) ? "checked" : ""); ?> />
		<small>If you check this box, then this meta information will not be added to your site. You might want to check this box if you are using
		more advanced WordPress SEO plugins.</small>
                <br /><br />

		<!-- ======== -->

                <label><span style="color:#4444CC;"><b>Site Copyright</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
		<small>If you fill this in, the default copyright notice in the footer will be replaced with the text here. It will not
		automatically update from year to year. Use &amp;copy; to display &copy;. You can use other HTML as well.</small>
		<br />

		<textarea name="ttw_copyright" rows=1 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getadminopt('ttw_copyright'))); ?></textarea>
		<br>
                <label>Hide Powered By tag: </label><input type="checkbox" name='ttw_hide_poweredby' id='ttw_hide_poweredby' <?php echo (ttw_getadminopt( 'ttw_hide_poweredby' ) ? "checked" : ""); ?> />
		<small>Check this to hide the "Proudly powered by" notice in the footer.</small>
                <br /><br />

		<!-- ======== -->

                <label><span style="color:#4444CC;"><b>The Last Thing</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
		<small>This code is inserted right before the closing &lt;/body&gt; tag.
                Some outside sites may provide you with JavaScript code that should be put here. (Note
		that this information is not part of your theme settings, and will not be included when you save or restore your theme.)</small>
		<br />

		<textarea name="ttw_end_opts" rows=1 style="width: 95%"><?php echo(str_replace("\\", "", ttw_getadminopt('ttw_end_opts'))); ?></textarea>

                <br /><br />


		<hr />
		<label><span style="color:green;"><b>Administrative Options</b></span></label>&nbsp;&nbsp;&nbsp;<a href="#top_main">top</a><br/>
		These options control some administrative options and appearance features.
		<br /><br />
		<label>Hide Site Preview: </label><input type="checkbox" name="ttw_hide_preview" id="ttw_hide_preview" <?php echo (ttw_getadminopt( 'ttw_hide_preview' ) ? "checked" : ""); ?> />
		    <small>Checking this box will hide the Site Preview at the bottom of the screen which might speed up response a bit.</small><br />
		<label>Hide Theme Thumbnails: </label>
		<input type="checkbox" name="ttw_hide_theme_thumbs" id="ttw_hide_theme_thumbs" <?php echo (ttw_getadminopt( 'ttw_hide_theme_thumbs' ) ? "checked" : ""); ?> />
		    <small>Checking this box will hide the Sub-theme preview thumbnails on the Weaver Themes tab which might speed up response a bit.</small><br />
		    <label>Don't auto-display CSS rules: </label>
		<input type="checkbox" name="ttw_hide_auto_css_rules" id="ttw_hide_auto_css_rules" <?php echo (ttw_getadminopt( 'ttw_hide_auto_css_rules' ) ? "checked" : ""); ?> />
		    <small>Checking this box will disable the auto-display of Main Option elements that have CSS settings.</small><br />
		<label>Hide old IE version warning: </label>
		<input type="checkbox" name="ttw_hide_IE_warning_css" id="ttw_hide_IE_warning_css" <?php echo (ttw_getadminopt( 'ttw_hide_IE_warning_css' ) ? "checked" : ""); ?> />
		    <small>Check this box to hide the warning Weaver automatically displays when the visitor is using IE 7 or earlier.</small><br />
		<label>Use Inline CSS: </label>
		<input type="checkbox" name="ttw_force_inline_css" id="ttw_force_inline_css" <?php echo (ttw_getadminopt( 'ttw_force_inline_css' ) ? "checked" : ""); ?> />
		    <small>Checking this box will have Weaver generate CSS inline rather than use the style-weaver.css external style sheet.</small><br />
		</fieldset>

		<br /><input type="submit" name="saveadvanced" value="Update Advanced Options" class="button-primary" /><br /><br />
		<?php ttw_nonce_field('saveadvanced'); ?>
	</form>
	<hr />
	<form name="ttw_resetweaver_form" method="post" onSubmit="return confirm('Are you sure you want to reset all Weaver settings?');">
	    <strong>Click the Clear button to reset all Weaver settings to the default values.</strong><br > <em>Warning: You will lose all current settings.</em> You should use the Save/Restore tab to save a copy
	    of your current settings before clearing! <span class="submit"><input type="submit" name="reset_weaver" value="Clear All Weaver Settings"/></submit>
	    <?php ttw_nonce_field('reset_weaver'); ?>
	</form>
     </div>

<hr />
<?php
}
?>
