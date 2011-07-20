<?php
@session_start();

function arjuna_get_default_options() {
	$options = array(
		'headerImage' => 'lightBlue',
		'commentDisplay' => 'alt', // alt, left, right
		'commentDateFormat' => 'timePassed', // timePassed, date
		'comments_hideWhenDisabledOnPages' => true,
		'comments_hideWhenDisabledOnPosts' => false,
		'trackbacks_hideWhenDisabledOnPages' => true,
		'trackbacks_hideWhenDisabledOnPosts' => true,
		'footerStyle' => 'style1', // style1, style2
		'appendToPageTitle' => 'blogName', // blogName, custom
		'appendToPageTitleCustom' => '',
		'sidebarDisplay' => 'right', // right, left, none
		'sidebarWidth' => 'normal', // small, normal, large
		'sidebar_showDefault' => true, 
		'postsShowAuthor' => true,
		'postsShowTime' => false,
		'posts_showTopPostLinks' => false,
		'posts_showBottomPostLinks' => true,
		'pages_showInfoBar' => false,
		'customCSS' => false,
		'customCSS_input' => '',
		'pagination' => true,
		'pagination_pageRange' => 2, //the number of page buttons to show before and after the current page button
		'pagination_pageAnchors' => 1, //the number of buttons to always show at the beginning and end of the pagination bar
		'pagination_pageGap' => 1, //the number of pages in a gap before an ellipsis is added
		
		//Added 1.5
		'excerpts_index' => false,
		'excerpts_categoryPages' => true,
		'excerpts_archivePages' => true,
		'excerpts_searchPages' => true,
		'excerpts_authorPages' => false,
		'background_color' => '#d9d9d9',
		'background_style' => 'gradient_blueish', //if set, overrides background_color
		'solidBackground_buttonStyle' => 'default', //will only be used if the background color is solid
		'headerLogo' => '',
		'headerLogo_width' => 0,
		'headerLogo_height' => 0,
	
		'archives_includeTags' => true,
		'archives_includeCategories' => true,
	
		'miscellaneous_IE6Notice' => true,
		'headerMenus_enableJavaScript' => true,
		'headerMenus_effect' => 'slide', //slide, fade, none
		'headerMenus_delay' => 500, //in milliseconds
		
		//Added 1.6.x
		'contentAreaWidth' => 570, //width of the content area, sidebar will be calculated
		'sidebar_showLinkedInButton' => false,
		'sidebarButtons' => array(
			'RSS' => array(
				'enabled' => true,
				'extended' => true,
				'label' => '',
			),
			'twitter' => array(
				'enabled' => false,
				'URL' => '',
				'label' => '',
			),
			'facebook' => array(
				'enabled' => false,
				'URL' => '',
				'label' => '',
			),
			'linkedIn' => array(
				'enabled' => false,
				'URL' => '',
				'label' => '',
			),
		),
		'menus' => array(
			'1' => array(
				'enabled' => true,
				'useNavMenus' => true, // false to use legacy menus
				'depth' => 3, // 1, 2, 3 (the depth of the menu, 1 being no dropdown)
				'align' => 'right', // right, left
				
				//options for legacy menus
				'display' => 'pages', // pages, categories
				'sortBy' => 'post_title', // [CATEGORIES]: name, ID, count, slug [PAGES]: post_title, ID, post_name (slug), menu_order (the page's Order value)
				'sortOrder' => 'asc', // asc, desc
				'exclude_categories' => '',
				'exclude_pages' => '',
			),
			'2' => array(
				'enabled' => true,
				'useNavMenus' => true, // false to use legacy menus
				'depth' => 3, // 1, 2, 3 (the depth of the menu, 1 being no dropdown)
				'displayHome' => true,
				'displaySeparators' => true,
				
				//options for legacy menus
				'display' => 'categories', // pages, categories
				'sortBy' => 'name', // [CATEGORIES]: name, ID, count, slug [PAGES]: post_title, ID, post_name (slug), menu_order (the page's Order value)
				'sortOrder' => 'asc', // asc, desc
				'exclude_categories' => '',
				'exclude_pages' => '',
			),
		),
		'search' => array(
			'enabled' => true,
			'position' => 'bottom' //top, bottom
		),
		//'enableSearch' => true,
		'useFeedburner' => false,
		'feedburnerURL' => '',
		'feedburnerCommentsURL' => '',
		'copyrightOwner' => '',
		'twitterWidget' => array(
			'enabled' => true,
			'title' => 'Recent Tweets',
			'username' => 'twitter',
			'height' => 250,
			'numTweets' => 4, //1 - 30
			'scrollbar' => false,
			'showTimestamps' => true,
		),
	
		'currentVersion' => '1.6.11',
	);
	
	return $options;
}


function arjuna_get_color_schemes() {
	$colorSchemes = array(
		'lightBlue' => __('Light Blue', 'Arjuna'),
		'bristolBlue' => __('Bristol Blue', 'Arjuna'),
		'darkBlue' => __('Dark Blue', 'Arjuna'),
		'regimentalBlue' => __('Regimental Blue', 'Arjuna'),
		'khaki' => __('Khaki', 'Arjuna'),
		'seaGreen' => __('Sea Green', 'Arjuna'),
		'lightRed' => __('Light Red', 'Arjuna'),
		'purple' => __('Purple', 'Arjuna'),
		'lightGray' => __('Light Gray', 'Arjuna'),
		'darkGray' => __('Dark Gray', 'Arjuna'),
	);
	
	return $colorSchemes;
}

function arjuna_parse_version($version) {
	if(substr_count($version, '.') == 1)
		return (int) (str_replace('.', '', $version) . '0');
	else return (int) str_replace('.', '', $version);
}

/**
 * Arjuna Load Default Options
 * 
 * Loads the default options into the DB.
 * This should ONLY be done when Arjuna is first installed or if a reset has been initiated.
 */
function arjuna_load_default_options() {
	//load defaults
	$options = arjuna_get_default_options();
	update_option('arjuna_options', $options);
	
	return $options;
}

/**
 * Arjuna Upgrade Options
 * 
 * Compares version numbers and upgrades the DB options accordingly.
 */
function arjuna_upgrade_options() {
	//load current defaults
	$newVersionDefaultOptions = $newVersionOptions = arjuna_get_default_options();
	
	//load options from database
	$oldVersionOptions = get_option('arjuna_options');
	
	//create options for new version
	//start by overwriting any existing option values to the new version
	foreach ( $newVersionOptions as $key => $value )
		if ( isset($oldVersionOptions[$key]) && $key != 'currentVersion' )
			$newVersionOptions[$key] = $oldVersionOptions[$key];
	
	//find upgrade profiles
	if(!isset($oldVersionOptions['currentVersion'])) {
		//old version below 1.6
	} else {
		if(arjuna_parse_version($oldVersionOptions['currentVersion']) >= 139) {
			$newVersionOptions['search']['enabled'] = $oldVersionOptions['enableSearch'];
		}
	}
	
	update_option('arjuna_options', $newVersionOptions);
	
	return $newVersionOptions;
}

function arjuna_get_options() {
	
	//get options from DB
	$DBOptions = get_option('arjuna_options');
	//get default options
	$defaultOptions = arjuna_get_default_options();
	
	//is this the first use of Arjuna?
	if(!$DBOptions)
		return arjuna_load_default_options();
	
	//determine if there is an upgrade required
	if(!isset($DBOptions['currentVersion']) || arjuna_parse_version($DBOptions['currentVersion']) < arjuna_parse_version($defaultOptions['currentVersion']))
		return arjuna_upgrade_options();
		
	//no upgrade or new installation, continue with DB options
	return $DBOptions;
}

add_action('admin_menu', 'arjuna_add_theme_options');
$formErrors = array();
$optionsSaved = false;
function arjuna_add_theme_options() {
	global $optionsSaved, $formErrors;
	if(isset($_POST['arjuna_save_options'])) {
		
		$arjunaColorSchemes = arjuna_get_color_schemes();
		
		/*if(!wp_verify_nonce($_POST['srs_arjuna_nonce'], 'srs_arjuna')) {
			print "Sorry, your nonce did not verify.";
			exit;
		}*/
		
		//nonce checking
		check_admin_referer('srs_arjuna', 'srs_arjuna_nonce');
		
		
		$options = arjuna_get_options();
		
		//Menu 1 dropdown
		$validOptions = array('1', '2', '3');
		if(isset($_POST['menus_1_depth'])) {
			if ( in_array($_POST['menus_1_depth'], $validOptions) ) $options['menus']['1']['depth'] = $_POST['menus_1_depth'];
			else $options['menus']['1']['depth'] = '3';
		}
		
		//Menu 1 display
		$validOptions = array('pages', 'categories');
		if(isset($_POST['menus_1_display'])) {
			if ( in_array($_POST['menus_1_display'], $validOptions) ) $options['menus']['1']['display'] = $_POST['menus_1_display'];
			else $options['menus']['1']['display'] = 'pages';
		}
		
		if(isset($_POST['menus_1_display'])) {
			if ($options['menus']['1']['display']=='pages') {
				//Menu 1 sorting for PAGES
				$validOptions = array('post_title', 'ID', 'post_name', 'menu_order');
				if ( in_array($_POST['menus_1_sortBy_pages'], $validOptions) ) $options['menus']['1']['sortBy'] = $_POST['menus_1_sortBy_pages'];
				else $options['menus']['1']['sortBy'] = $validOptions[0];
				//Menu 1 sorting order
				$validOptions = array('asc', 'desc');
				if ( in_array($_POST['menus_1_sortOrder_pages'], $validOptions) ) $options['menus']['1']['sortOrder'] = $_POST['menus_1_sortOrder_pages'];
				else $options['menus']['1']['sortOrder'] = $validOptions[0];
			} elseif ($options['menus']['1']['display']=='categories') {
				//Menu 1 sorting for CATEGORIES
				$validOptions = array('name', 'ID', 'count', 'slug');
				if ( in_array($_POST['menus_1_sortBy_categories'], $validOptions) ) $options['menus']['1']['sortBy'] = $_POST['menus_1_sortBy_categories'];
				else $options['menus']['1']['sortBy'] = $validOptions[0];
				//Menu 1 sorting order
				$validOptions = array('asc', 'desc');
				if ( in_array($_POST['menus_1_sortOrder_categories'], $validOptions) ) $options['menus']['1']['sortOrder'] = $_POST['menus_1_sortOrder_categories'];
				else $options['menus']['1']['sortOrder'] = $validOptions[0];
			}
		}
		
		//Menu 1 show
		if (isset($_POST['menus_1_enabled'])) $options['menus']['1']['enabled'] = (bool) $_POST['menus_1_enabled'];
		else $options['menus']['1']['enabled'] = false;
		
		//Menu 1 use navigation menu
		if (isset($_POST['menus_1_useNavMenus'])) $options['menus']['1']['useNavMenus'] = (bool)$_POST['menus_1_useNavMenus'];
		else $options['menus']['1']['useNavMenus'] = false;
		
		//Menu 1 alignment
		$validOptions = array('right', 'left');
		if(isset($_POST['menus_1_align'])) {
			if ( in_array($_POST['menus_1_align'], $validOptions) ) $options['menus']['1']['align'] = $_POST['menus_1_align'];
			else $options['menus']['1']['align'] = $validOptions[0];
		}
		
		// Menu 1 - Exclude items
		if(isset($_POST['menus_1_exclude_categories'])) {
			if($_POST['menus_1_exclude_categories']) {
				$options['menus']['1']['exclude_categories'] = implode(',', $_POST['menus_1_exclude_categories']);
			} else $options['menus']['1']['exclude_categories'] = '';
		}
		
		if(isset($_POST['menus_1_exclude_pages'])) {
			if($_POST['menus_1_exclude_pages']) {
				$options['menus']['1']['exclude_pages'] = implode(',', $_POST['menus_1_exclude_pages']);
			} else $options['menus']['1']['exclude_pages'] = '';
		}
		
		
		//Menu 2 show
		if (isset($_POST['menus_2_enabled'])) $options['menus']['2']['enabled'] = (bool) $_POST['menus_2_enabled'];
		else $options['menus']['2']['enabled'] = false;
		
		//Menu 2 use navigation menu
		if (isset($_POST['menus_2_useNavMenus'])) $options['menus']['2']['useNavMenus'] = (bool)$_POST['menus_2_useNavMenus'];
		else $options['menus']['2']['useNavMenus'] = false;
		
		//Menu 2 dropdown
		$validOptions = array('1', '2', '3');
		if(isset($_POST['menus_2_depth'])) {
			if ( in_array($_POST['menus_2_depth'], $validOptions) ) $options['menus']['2']['depth'] = $_POST['menus_2_depth'];
			else $options['menus']['2']['depth'] = '3';
		}
		
		//Menu 2 display
		$validOptions = array('pages', 'categories');
		if(isset($_POST['menus_2_display'])) {
			if ( in_array($_POST['menus_2_display'], $validOptions) ) $options['menus']['2']['display'] = $_POST['menus_2_display'];
			else $options['menus']['2']['display'] = 'pages';
		}
		
		if(isset($_POST['menus_2_display'])) {
			if ($options['menus']['2']['display']=='pages') {
				//Menu 2 sorting for PAGES
				$validOptions = array('post_title', 'ID', 'post_name', 'menu_order');
				if ( in_array($_POST['menus_2_sortBy_pages'], $validOptions) ) $options['menus']['2']['sortBy'] = $_POST['menus_2_sortBy_pages'];
				else $options['menus']['2']['sortBy'] = $validOptions[0];
				//Menu 2 sorting order
				$validOptions = array('asc', 'desc');
				if ( in_array($_POST['menus_2_sortOrder_pages'], $validOptions) ) $options['menus']['2']['sortOrder'] = $_POST['menus_2_sortOrder_pages'];
				else $options['menus']['2']['sortOrder'] = $validOptions[0];
			} elseif ($options['menus']['2']['display']=='categories') {
				//Menu 2 sorting for CATEGORIES
				$validOptions = array('name', 'ID', 'count', 'slug');
				if ( in_array($_POST['menus_2_sortBy_categories'], $validOptions) ) $options['menus']['2']['sortBy'] = $_POST['menus_2_sortBy_categories'];
				else $options['menus']['2']['sortBy'] = $validOptions[0];
				//Menu 2 sorting order
				$validOptions = array('asc', 'desc');
				if ( in_array($_POST['menus_2_sortOrder_categories'], $validOptions) ) $options['menus']['2']['sortOrder'] = $_POST['menus_2_sortOrder_categories'];
				else $options['menus']['2']['sortOrder'] = $validOptions[0];
			}
		}
		
		//Menu 2 Home Icon
		if (isset($_POST['menus_2_displayHome'])) $options['menus']['2']['displayHome'] = true;
		else $options['menus']['2']['displayHome'] = false;
		
		//Menu 2 Home Icon
		if (isset($_POST['menus_2_displaySeparators'])) $options['menus']['2']['displaySeparators'] = true;
		else $options['menus']['2']['displaySeparators'] = false;
		
		
		// Menu 2 - Exclude items
		if(isset($_POST['menus_2_exclude_categories'])) {
			if($_POST['menus_2_exclude_categories']) {
				$options['menus']['2']['exclude_categories'] = implode(',', $_POST['menus_2_exclude_categories']);
			} else $options['menus']['2']['exclude_categories'] = '';
		}
		
		if(isset($_POST['menus_2_exclude_pages'])) {
			if($_POST['menus_2_exclude_pages']) {
				$options['menus']['2']['exclude_pages'] = implode(',', $_POST['menus_2_exclude_pages']);
			} else $options['menus']['2']['exclude_pages'] = '';
		}
		

		//Header Image
		
		if(isset($_POST['headerImage'])) {
			if ( isset($arjunaColorSchemes[$_POST['headerImage']]) ) $options['headerImage'] = $_POST['headerImage'];
			else $options['headerImage'] = 'lightBlue';
		}
		
		//Search
		if (isset($_POST['search_enabled'])) $options['search']['enabled'] = (bool)$_POST['search_enabled'];
		else $options['search']['enabled'] = false;
		
		$validOptions = array('top', 'bottom');
		if(isset($_POST['search_position'])) {
			if ( in_array($_POST['search_position'], $validOptions) ) $options['search']['position'] = $_POST['search_position'];
			else $options['search']['position'] = 'bottom';
		}
		
		//Comment display
		$validOptions = array('alt', 'left', 'right');
		if(isset($_POST['commentDisplay'])) {
			if ( in_array($_POST['commentDisplay'], $validOptions) ) $options['commentDisplay'] = $_POST['commentDisplay'];
			else $options['commentDisplay'] = 'alt';
		}
		

		// Comment display
		if (isset($_POST['comments_hideWhenDisabledOnPages'])) $options['comments_hideWhenDisabledOnPages'] = true;
		else $options['comments_hideWhenDisabledOnPages'] = false;
		
		if (isset($_POST['comments_hideWhenDisabledOnPosts'])) $options['comments_hideWhenDisabledOnPosts'] = true;
		else $options['comments_hideWhenDisabledOnPosts'] = false;
		
		if (isset($_POST['trackbacks_hideWhenDisabledOnPages'])) $options['trackbacks_hideWhenDisabledOnPages'] = true;
		else $options['trackbacks_hideWhenDisabledOnPages'] = false;
		
		if (isset($_POST['trackbacks_hideWhenDisabledOnPosts'])) $options['trackbacks_hideWhenDisabledOnPosts'] = true;
		else $options['trackbacks_hideWhenDisabledOnPosts'] = false;
		
		//Footer style
		$validOptions = array('style1', 'style2');
		if(isset($_POST['footerStyle'])) {
			if ( in_array($_POST['footerStyle'], $validOptions) ) $options['footerStyle'] = $_POST['footerStyle'];
			else $options['footerStyle'] = 'style1';
		}
		
		//Comment date format
		$validOptions = array('timePassed', 'date');
		if(isset($_POST['commentDateFormat'])) {
			if ( in_array($_POST['commentDateFormat'], $validOptions) ) $options['commentDateFormat'] = $_POST['commentDateFormat'];
			else $options['commentDateFormat'] = 'timePassed';
		}
		
		//Append to page title
		$validOptions = array('blogName', 'custom');
		if(isset($_POST['appendToPageTitle'])) {
			if ( in_array($_POST['appendToPageTitle'], $validOptions) ) $options['appendToPageTitle'] = $_POST['appendToPageTitle'];
			else $options['appendToPageTitle'] = 'blogName';
		}
		
		if(isset($_POST['appendToPageTitle'])) {
			if ($_POST['appendToPageTitle']=='custom')
				$options['appendToPageTitleCustom'] = $_POST['appendToPageTitleCustom'];
		}
		
		//Sidebar display
		$validOptions = array('right', 'left', 'none');
		if(isset($_POST['sidebarDisplay'])) {
			if ( in_array($_POST['sidebarDisplay'], $validOptions) ) $options['sidebarDisplay'] = $_POST['sidebarDisplay'];
			else $options['sidebarDisplay'] = $validOptions[0];
			
			if($options['sidebarDisplay'] != 'none' && isset($_POST['contentAreaWidth'])) {
				$options['contentAreaWidth'] = $_POST['contentAreaWidth'];
			}
		}
		
		// Whether or not to show the default bars (if no widget bars are defined)
		if (isset($_POST['sidebar_showDefault'])) $options['sidebar_showDefault'] = true;
		else $options['sidebar_showDefault'] = false;
		
		
		//Sidebar Width
		$validOptions = array('normal', 'small', 'large');
		if(isset($_POST['sidebarWidth'])) {
			if ( in_array($_POST['sidebarWidth'], $validOptions) ) $options['sidebarWidth'] = $_POST['sidebarWidth'];
			else $options['sidebarWidth'] = $validOptions[0];
		}
		
		
		//Sidebar buttons
		if(isset($_POST['sidebarButtons_RSS_enabled'])) {
			$options['sidebarButtons']['RSS']['enabled'] = (bool) $_POST['sidebarButtons_RSS_enabled'];
			$options['sidebarButtons']['RSS']['label'] = $_POST['sidebarButtons_RSS_label'];
			if(isset($_POST['sidebarButtons_RSS_extended']))
				$options['sidebarButtons']['RSS']['extended'] = (bool) $_POST['sidebarButtons_RSS_extended'];
			else $options['sidebarButtons']['RSS']['extended'] = false;
		} else {
			$options['sidebarButtons']['RSS']['enabled'] = false;
		}
		if(isset($_POST['sidebarButtons_twitter_enabled'])) {
			$options['sidebarButtons']['twitter']['enabled'] = (bool) $_POST['sidebarButtons_twitter_enabled'];
			$options['sidebarButtons']['twitter']['label'] = $_POST['sidebarButtons_twitter_label'];
			$URL = $_POST['sidebarButtons_twitter_URL'];
			if ( !preg_match('/twitter\.com/i', $URL) ) {
				$URL = "http://twitter.com/" . $URL;
			} elseif ( !preg_match('/http[s]?\:\/\//i', $URL) ) {
				$URL = "http://" . $URL;
			}
			if ( empty($URL) ) {
				$options['sidebarButtons']['twitter']['enabled'] = false;
				$options['sidebarButtons']['twitter']['label'] = '';
				$options['sidebarButtons']['twitter']['URL'] = '';
			} else
				$options['sidebarButtons']['twitter']['URL'] = $URL;
		} else {
			$options['sidebarButtons']['twitter']['enabled'] = false;
		}
		if(isset($_POST['sidebarButtons_facebook_enabled'])) {
			$options['sidebarButtons']['facebook']['enabled'] = (bool) $_POST['sidebarButtons_facebook_enabled'];
			$options['sidebarButtons']['facebook']['label'] = $_POST['sidebarButtons_facebook_label'];
			$URL = $_POST['sidebarButtons_facebook_URL'];
			if ( !preg_match('/facebook\./i', $URL) ) {
				$URL = "http://facebook.com/" . $URL;
			} elseif ( !preg_match('/http[s]?\:\/\//i', $URL) ) {
				$URL = "http://" . $URL;
			}
			if ( empty($URL) ) {
				$options['sidebarButtons']['facebook']['enabled'] = false;
				$options['sidebarButtons']['facebook']['label'] = '';
				$options['sidebarButtons']['facebook']['URL'] = '';
			} else
				$options['sidebarButtons']['facebook']['URL'] = $URL;
		} else {
			$options['sidebarButtons']['facebook']['enabled'] = false;
		}
		if(isset($_POST['sidebarButtons_linkedIn_enabled'])) {
			$options['sidebarButtons']['linkedIn']['enabled'] = (bool) $_POST['sidebarButtons_linkedIn_enabled'];
			$options['sidebarButtons']['linkedIn']['label'] = $_POST['sidebarButtons_linkedIn_label'];
			$URL = $_POST['sidebarButtons_linkedIn_URL'];
			if ( !preg_match('/linkedin\./i', $URL) ) {
				$URL = "http://linkedin.com/" . $URL;
			} elseif ( !preg_match('/http[s]?\:\/\//i', $URL) ) {
				$URL = "http://" . $URL;
			}
			if ( empty($URL) ) {
				$options['sidebarButtons']['linkedIn']['enabled'] = false;
				$options['sidebarButtons']['linkedIn']['label'] = '';
				$options['sidebarButtons']['linkedIn']['URL'] = '';
			} else
				$options['sidebarButtons']['linkedIn']['URL'] = $URL;
		} else {
			$options['sidebarButtons']['linkedIn']['enabled'] = false;
		}
			
		
		// Posts, Show Author
		if (isset($_POST['postsShowAuthor'])) $options['postsShowAuthor'] = true;
		else $options['postsShowAuthor'] = false;
		
		// Posts, Show Time
		if (isset($_POST['postsShowTime'])) $options['postsShowTime'] = true;
		else $options['postsShowTime'] = false;
		
		if (isset($_POST['pages_showInfoBar'])) $options['pages_showInfoBar'] = true;
		else $options['pages_showInfoBar'] = false;

		//Navigation links to previous and next posts
		if (isset($_POST['posts_showTopPostLinks'])) $options['posts_showTopPostLinks'] = true;
		else $options['posts_showTopPostLinks'] = false;
		
		if (isset($_POST['posts_showBottomPostLinks'])) $options['posts_showBottomPostLinks'] = true;
		else $options['posts_showBottomPostLinks'] = false;
		
		if(isset($_POST['pagination'])) {
			if ($_POST['pagination']=='1') {
				$options['pagination'] = true;
				
				$validOptions = array(1,2,3,4,5);
				if ( in_array($_POST['pagination_pageRange'], $validOptions) ) $options['pagination_pageRange'] = $_POST['pagination_pageRange'];
				else $options['pagination_pageRange'] = 3;
	
				$validOptions = array(1,2,3);
				if ( in_array($_POST['pagination_pageAnchors'], $validOptions) ) $options['pagination_pageAnchors'] = $_POST['pagination_pageAnchors'];
				else $options['pagination_pageAnchors'] = 1;
				
				$validOptions = array(1,2,3);
				if ( in_array($_POST['pagination_pageGap'], $validOptions) ) $options['pagination_pageGap'] = $_POST['pagination_pageGap'];
				else $options['pagination_pageGap'] = 1;
				
			} else $options['pagination'] = false;
		}
		
		//Custom CSS
		if (isset($_POST['customCSS'])) {
			if (trim($_POST['customCSS_input'])) {
				$options['customCSS'] = true;
				$input = trim($_POST['customCSS_input']);
				$options['customCSS_input'] = $input;
			} else {
				$options['customCSS'] = false;
				$options['customCSS_input'] = '';
			}
		} else $options['customCSS'] = false;
		
		
		//Background Styles
		
		if ($_POST['backgroundStyle'] == '') {
			$options['background_style'] = '';
			$options['background_color'] = $_POST['backgroundColor'];
			$options['solidBackground_buttonStyle'] = $_POST['backgroundButtonStyle'];
		} else {
			$validOptions = array('gradient_blueish', 'gradient_gray', 'gradient_gray_reverse', 'gradient_khaki');
			if ( in_array($_POST['backgroundStyle'], $validOptions) )
				$options['background_style'] = $_POST['backgroundStyle'];
			else $options['background_style'] = 'gradient_blueish';
		}
		
		//Index Pages
		
		if (isset($_POST['archives_includeTags'])) $options['archives_includeTags'] = true;
		else $options['archives_includeTags'] = false;
		
		if (isset($_POST['archives_includeCategories'])) $options['archives_includeCategories'] = true;
		else $options['archives_includeCategories'] = false;
		
		
		//Excerpts
		if (isset($_POST['excerpts_index'])) $options['excerpts_index'] = true;
		else $options['excerpts_index'] = false;
		
		if (isset($_POST['excerpts_categoryPages'])) $options['excerpts_categoryPages'] = true;
		else $options['excerpts_categoryPages'] = false;
	
		if (isset($_POST['excerpts_archivePages'])) $options['excerpts_archivePages'] = true;
		else $options['excerpts_archivePages'] = false;
	
		if (isset($_POST['excerpts_searchPages'])) $options['excerpts_searchPages'] = true;
		else $options['excerpts_searchPages'] = false;
	
		if (isset($_POST['excerpts_authorPages'])) $options['excerpts_authorPages'] = true;
		else $options['excerpts_authorPages'] = false;
		
		//Logo
		if(isset($_FILES['headerLogo'])) {
			if($_FILES['headerLogo']['type']) {
				if(!eregi('image/', $_FILES['headerLogo']['type'])) {
					//catch error
					$formErrors['headerLogo'] = __('The uploaded file is not a valid image. Only JPEG, PNG and GIF is supported.', 'Arjuna');
				} else {
					// check if valid image
					$info = getimagesize($_FILES['headerLogo']['tmp_name']);
					$supportedMimeTypes = array('image/gif', 'image/jpeg', 'image/png');
					if(!$info || !in_array($info['mime'], $supportedMimeTypes)) {
						//catch error
						$formErrors['headerLogo'] = __('The uploaded file is not a valid image. Only JPEG, PNG and GIF is supported.', 'Arjuna');
					} else {
						list($width, $height) = $info;
						$path = arjuna_get_upload_directory() . '/' . $_FILES['headerLogo']['name'];
						move_uploaded_file($_FILES['headerLogo']['tmp_name'], $path);
						$options['headerLogo'] = arjuna_get_upload_url() . '/' . $_FILES['headerLogo']['name'];
						$options['headerLogo_width'] = $width;
						$options['headerLogo_height'] = $height;
					}
				}
			}
		}
		
		//Javascript menus
		if (isset($_POST['headerMenus_enableJavaScript'])) $options['headerMenus_enableJavaScript'] = true;
		else $options['headerMenus_enableJavaScript'] = false;
		
		//IE6 Notice
		if (isset($_POST['miscellaneous_IE6Notice'])) $options['miscellaneous_IE6Notice'] = true;
		else $options['miscellaneous_IE6Notice'] = false;
		
		//Feedburner
		if (isset($_POST['useFeedburner'])) $options['useFeedburner'] = (bool)$_POST['useFeedburner'];
		else $options['useFeedburner'] = false;
		
		$URL = $_POST['feedburnerURL'];
		if ( !preg_match('/feedburner\.com/i', $URL) )
			$URL = "http://feeds.feedburner.com/" . $URL;
		elseif ( !preg_match('/http[s]?\:\/\//i', $URL) )
			$URL = "http://" . $URL;
		
		if ( empty($URL) ) {
			$options['useFeedburner'] = false;
			$options['feedburnerURL'] = '';
		} else
			$options['feedburnerURL'] = $URL;
		
		$URL = $_POST['feedburnerCommentsURL'];
		if(!empty($URL)) {
			if ( !preg_match('/feedburner\.com/i', $URL) )
				$URL = "http://feeds.feedburner.com/" . $URL;
			elseif ( !preg_match('/http[s]?\:\/\//i', $URL) )
				$URL = "http://" . $URL;
		}
		
		//Twitter Widget
		if (isset($_POST['twitterWidget_enabled'])) $options['twitterWidget']['enabled'] = (bool)$_POST['twitterWidget_enabled'];
		else $options['twitterWidget']['enabled'] = false;
		
		if (isset($_POST['twitterWidget_title'])) $options['twitterWidget']['title'] = $_POST['twitterWidget_title'];
		else $options['twitterWidget']['title'] = '';
		
		if (isset($_POST['twitterWidget_username'])) $options['twitterWidget']['username'] = $_POST['twitterWidget_username'];
		else $options['twitterWidget']['username'] = '';
		
		if (isset($_POST['twitterWidget_height'])) $options['twitterWidget']['height'] = (int)$_POST['twitterWidget_height'];
		else $options['twitterWidget']['height'] = 250;
		
		if (isset($_POST['twitterWidget_numTweets'])) $options['twitterWidget']['numTweets'] = (int)$_POST['twitterWidget_numTweets'];
		else $options['twitterWidget']['numTweets'] = 4;
		
		if (isset($_POST['twitterWidget_scrollbar'])) $options['twitterWidget']['scrollbar'] = (bool)$_POST['twitterWidget_scrollbar'];
		else $options['twitterWidget']['scrollbar'] = false;
		
		if (isset($_POST['twitterWidget_showTimestamps'])) $options['twitterWidget']['showTimestamps'] = (bool)$_POST['twitterWidget_showTimestamps'];
		else $options['twitterWidget']['showTimestamps'] = false;
		
		//Copyright Owner
		if($_POST['coprightOwnerType'] == 'default')
			$options['copyrightOwner'] = '';
		else $options['copyrightOwner'] = $_POST['copyrightOwner'];
		
		$options['feedburnerCommentsURL'] = $URL;
		
		
		update_option('arjuna_options', $options);
		
		
		$optionsSaved = true;
	}
	
	if(isset($_POST['removeLogo'])) {
		$options = arjuna_get_options();
		
		$options['headerLogo'] = '';
		$options['headerLogo_width'] = 0;
		$options['headerLogo_height'] = 0;
		
		update_option('arjuna_options', $options);
		$optionsSaved = true;
	}
	
	add_theme_page(__('Arjuna Options', 'Arjuna'), __('Arjuna Options', 'Arjuna'), 'edit_theme_options', basename(__FILE__), 'arjuna_add_theme_page');
}

function arjuna_admin_is_panel_open($ID) {
	if(!isset($_SESSION['arjunaAdminPanels']))
		return false;
	if(!isset($_SESSION['arjunaAdminPanels'][$ID]))
		return false;
	if($_SESSION['arjunaAdminPanels'][$ID])
		return true;
}


function arjuna_add_theme_page () {
	global $optionsSaved, $formErrors, $arjunaColorSchemes;

	$options = arjuna_get_options();
	
	if ( $optionsSaved )
		echo '<div id="message" class="updated fade"><p><strong>'.__('The Arjuna options have been saved.', 'Arjuna').'</strong></p></div>';
?>
<input type="hidden" id="arjuna_themeURL" value="<?php echo get_template_directory_uri();; ?>" />
<form action="#" method="post" name="arjuna_form" id="arjuna_update_theme" enctype="multipart/form-data">
	<div class="wrap">
		<h2><?php _e('Arjuna Theme Options', 'Arjuna'); ?></h2>
		
		<!--[if lte IE 6]>
		<div class="IENotice"><?php _e('This browser is outdated. Please <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx">upgrade</a> your browser to enjoy this website to its fullest extent.', 'Arjuna'); ?></div>
		<![endif]-->
		
		<div class="tSRSIntro">
			<div class="tTop">
			<?php printf(__('Thank you for using Arjuna, the free WordPress theme designed by %s.', 'Arjuna'), '<a href="http://www.srssolutions.com/en/" class="tSRS">SRS Solutions</a>'); ?>
			<div class="tTwitter">
				<a href="http://www.twitter.com/srssolutions"><?php _e('Follow Us', 'Arjuna'); ?></a>
				<?php _e('to receive news, updates, and more.', 'Arjuna'); ?>
			</div>
			<div class="tFacebook">
				<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="http://www.facebook.com/srssolutions" show_faces="false" width="600" font="lucida grande"></fb:like>
			</div>
			<div class="logo"></div>
			</div>
			<div class="tMid">
				<div class="tReportBugs">
					<h5><?php _e('Report Bugs', 'Arjuna'); ?></h5>
					<a href="http://www.srssolutions.com/en/downloads/bug_report"><?php _e('Report a Bug', 'Arjuna'); ?></a> &mdash; <?php _e('Please include your Wordpress version, browser details and a screenshot, if necessary.', 'Arjuna'); ?>
				</div>
				<ul class="tUsefulLinks">
					<h5><?php _e('Useful Links', 'Arjuna'); ?></h5>
					<li><a href="http://www.srssolutions.com/en/downloads/arjuna_wordpress_theme#changelog"><?php _e('Changelog', 'Arjuna'); ?></a></li>
					<li><a href="http://www.srssolutions.com/en/downloads/arjuna_wordpress_theme#faq"><?php _e('FAQ', 'Arjuna'); ?></a></li>
					<li><a href="http://www.srssolutions.com/en/downloads/arjuna_wordpress_theme#roadmap"><?php _e('Roadmap', 'Arjuna'); ?></a></li>
					<li><a href="http://www.srssolutions.com/en/downloads/arjuna_wordpress_theme#comments"><?php _e('Leave Feedback', 'Arjuna'); ?></a></li>
				</ul>
				<div class="tSupport">
					<h5><?php _e('Support &amp; Sales', 'Arjuna'); ?></h5>
					<a href="http://www.srssolutions.com/en/contact/rfq"><?php _e('Contact Sales', 'Arjuna'); ?></a> &mdash; <?php _e('Need installation or integration support? Need something customized or extended?', 'Arjuna'); ?>
				</div>
			</div>
			<div class="tBottom">
				<?php /* <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GV5N8DN6XR6PY"><img src="https://www.paypal.com/<?php if(defined('WPLANG') && WPLANG != '') print WPLANG; else print 'en_US'; ?>/i/btn/btn_donate_SM.gif" /></a> */ ?>
				<span><?php _e('Arjuna is completely free. Therefore, please understand that we do NOT offer free support. If you require support of any kind other than fixing a bug that is related to Arjuna, please request a quote from us.', 'Arjuna'); ?></span>
			</div>
		</div>
		
		<?php
		if(!empty($formErrors))
			print '<div class="error">';
			foreach($formErrors as $error)
				print '<p>'.$error.'</p>';
			print '</div>';
		?>
		
		<h3><?php _e('General Blog Appearance', 'Arjuna'); ?></h3>
		
		<div self:ID="logo" class="srsContainer<?php if(!arjuna_admin_is_panel_open('logo')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('Logo', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Header Logo', 'Arjuna'); ?></th>
							<td>
							<?php if(is_writable(arjuna_get_upload_directory())): ?>
								<input type="file" name="headerLogo" id="headerLogo" />
								<?php if($options['headerLogo']): ?>
									<div class="logoPreview"><img src="<?php print $options['headerLogo']; ?>" /></div>
									<input type="submit" name="removeLogo" value="Remove Logo" />
								<?php endif; ?>
								<br /><span class="description"><?php printf(__('The custom logo will be included in the header, aligned to the left and vertically centered.', 'Arjuna'), arjuna_get_upload_directory());?></span>
							<?php else: ?>
								<span class="description"><?php printf(__('You do not have write permissions for the upload directory %s. Please check with your webmaster or host to set write permissions for this directory.', 'Arjuna'), arjuna_get_upload_directory());?></span>
							<?php endif; ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<div self:ID="firstHeaderMenu" class="srsContainer<?php if(!arjuna_admin_is_panel_open('firstHeaderMenu')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><div class="tIcon" id="icon-firstMenu"></div><?php _e('First Header Menu', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Enabled', 'Arjuna'); ?></th>
							<td>
								<label><input name="menus_1_enabled" type="checkbox"<?php checked($options['menus']['1']['enabled']); ?> /> <?php _e('Enable this menu', 'Arjuna'); ?></label>
								<br />
								<span class="description"><?php _e('If disabled, the menu will be hidden.', 'Arjuna');?></span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Dropdown', 'Arjuna'); ?></th>
							<td>
								<label>
									<input name="menus_1_depth" type="radio" value="1"<?php checked($options['menus']['1']['depth'], '1'); ?> />
									 <?php _e('No dropdown menu', 'Arjuna'); ?>
								</label><br />
								<label>
									<input name="menus_1_depth" type="radio" value="2"<?php checked($options['menus']['1']['depth'], '2'); ?> />
									 <?php _e('One-level dropdown menu', 'Arjuna'); ?>
								</label><br />
								<label>
									<input name="menus_1_depth" type="radio" value="3"<?php checked($options['menus']['1']['depth'], '3'); ?> />
									 <?php _e('Two-level dropdown menu', 'Arjuna'); ?>
								</label>
							</td>
						<tr valign="top">
							<th scope="row"><?php _e('Alignment', 'Arjuna'); ?></th>
							<td>
								<div class="tALeft"><label>
									<input name="menus_1_align" type="radio" value="left"<?php checked($options['menus']['1']['align'], 'left'); ?> />
									 <?php _e('Left', 'Arjuna'); ?>
								</label></div>
								<div class="tALeft"><label>
									<input name="menus_1_align" type="radio" value="right"<?php checked($options['menus']['1']['align'], 'right'); ?> />
									 <?php _e('Right', 'Arjuna'); ?>
								</label></div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Use', 'Arjuna'); ?></th>
							<td id="menus-1-useNavMenus">
								<div class="tALeft"><label>
									<input name="menus_1_useNavMenus" type="radio" value="1"<?php checked($options['menus']['1']['useNavMenus']); ?> />
									 <?php _e('WordPress Custom Menus', 'Arjuna'); ?>
								</label></div>
								<div class="tALeft"><label>
									<input name="menus_1_useNavMenus" type="radio" value="0"<?php checked($options['menus']['1']['useNavMenus'], false); ?> />
									 <?php _e('Legacy Menus', 'Arjuna'); ?>
								</label></div>
							</td>
						</tr>
					</tbody>
					<tbody id="menus-1-useNavMenus-legacy"<?php if($options['menus']['1']['useNavMenus']) echo ' style="display:none;"'; ?>>
						<tr valign="top">
							<th scope="row"><?php _e('Menu lists only', 'Arjuna'); ?></th>
							<td>
								<div class="tALeft"><label>
									<input name="menus_1_display" type="radio" onclick="headerMenu1_tD(this);" value="pages"<?php checked($options['menus']['1']['display'], 'pages'); ?> />
									 <?php _e('Pages', 'Arjuna'); ?>
								</label></div>
								<div class="tALeft"><label>
									<input name="menus_1_display" type="radio" onclick="headerMenu1_tD(this);" value="categories"<?php checked($options['menus']['1']['display'], 'categories'); ?> />
									 <?php _e('Categories', 'Arjuna'); ?>
								</label></div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Sorting Order', 'Arjuna'); ?></th>
							<td>
								<div id="menus_1_sortBy_categories"<?php if($options['menus']['1']['display']=='pages'): ?> style="display:none;"<?php endif; ?>>
									<?php _e('Sort menu items in', 'Arjuna'); ?> 
									<select name="menus_1_sortOrder_categories">
										<option value="asc"<?php selected($options['menus']['1']['sortOrder'], 'asc'); ?>><?php _e('ascending', 'Arjuna'); ?></option>
										<option value="desc"<?php selected($options['menus']['1']['sortOrder'], 'desc'); ?>><?php _e('descending', 'Arjuna'); ?></option>
									</select>
									<?php _e('order by', 'Arjuna'); ?>
									<select name="menus_1_sortBy_categories">
										<option value="name"<?php selected($options['menus']['1']['sortBy'], 'name'); ?>><?php _e('Category Name', 'Arjuna'); ?></option>
										<option value="ID"<?php selected($options['menus']['1']['sortBy'], 'ID'); ?>><?php _e('Category ID', 'Arjuna'); ?></option>
										<option value="count"<?php selected($options['menus']['1']['sortBy'], 'count'); ?>><?php _e('Post Count', 'Arjuna'); ?></option>
										<option value="slug"<?php selected($options['menus']['1']['sortBy'], 'slug'); ?>><?php _e('Category Slug', 'Arjuna'); ?></option>
									</select>
								</div>
								<div id="menus_1_sortBy_pages"<?php if($options['menus']['1']['display']=='categories'): ?> style="display:none;"<?php endif; ?>>
									<?php _e('Sort menu items in', 'Arjuna'); ?> 
									<select name="menus_1_sortOrder_pages">
										<option value="asc"<?php selected($options['menus']['1']['sortOrder'], 'asc'); ?>><?php _e('ascending', 'Arjuna'); ?></option>
										<option value="desc"<?php selected($options['menus']['1']['sortOrder'], 'desc'); ?>><?php _e('descending', 'Arjuna'); ?></option>
									</select>
									<?php _e('order by', 'Arjuna'); ?>
									<select name="menus_1_sortBy_pages">
										<option value="post_title"<?php selected($options['menus']['1']['sortBy'], 'post_title'); ?>><?php _e('Page Title', 'Arjuna'); ?></option>
										<option value="ID"<?php selected($options['menus']['1']['sortBy'], 'ID'); ?>><?php _e('Page ID', 'Arjuna'); ?></option>
										<option value="post_name"<?php selected($options['menus']['1']['sortBy'], 'post_name'); ?>><?php _e('Page Slug', 'Arjuna'); ?></option>
										<option value="menu_order"<?php selected($options['menus']['1']['sortBy'], 'menu_order'); ?>><?php _e('Page Order', 'Arjuna'); ?></option>
									</select>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Menu Items', 'Arjuna'); ?></th>
							<td>
							<div id="menus_1_include_categories"<?php if($options['menus']['1']['display']=='pages'): ?> style="display:none;"<?php endif; ?>>
								<?php _e('Include categories', 'Arjuna'); ?><br />
								<?php
								$categories = arjuna_get_all_categories($options['menus']['1']['exclude_categories'], '', $options['menus']['1']['depth']);
								?>
								<select multiple="multiple" size="7" name="menus_1_include_categories[]" id="hm1ic" style="height:auto;width:400px; padding-right:20px;">
									<?php arjuna_admin_walk_categories($categories); ?>
								</select>
								<div class="tArrows">
									<a href="#" class="tArrowUp" id="hm1ic_up"></a><a href="#" class="tArrowDown" id="hm1ic_down"></a>
								</div>
								<?php _e('Exclude categories', 'Arjuna'); ?><br />
								<?php
								$categories = arjuna_get_all_categories('', $options['menus']['1']['exclude_categories'], $options['menus']['1']['depth']);
								?>
								<select multiple="multiple" size="7" name="menus_1_exclude_categories[]" id="hm1ec" style="height:auto;width:400px; padding-right:20px;">
									<?php if(!empty($options['menus']['1']['exclude_categories'])) arjuna_admin_walk_categories($categories); ?>
								</select>
								<span class="description"><?php _e('Note: While the above fields show empty categories, the theme will only display categories that have at least one published post in them.', 'Arjuna'); ?></span>
							</div>
							<div id="menus_1_include_pages"<?php if($options['menus']['1']['display']!='pages'): ?> style="display:none;"<?php endif; ?>>
								<?php _e('Include pages', 'Arjuna'); ?><br />
								<?php
								$pages = arjuna_get_all_pages($options['menus']['1']['exclude_pages'], '', $options['menus']['1']['depth']);
								?>
								<select multiple="multiple" size="7" name="menus_1_include_pages[]" id="hm1ip" style="height:auto;width:400px; padding-right:20px;">
									<?php arjuna_admin_walk_pages($pages); ?>
								</select>
								<div class="tArrows">
									<a href="#" class="tArrowUp" id="hm1ip_up"></a><a href="#" class="tArrowDown" id="hm1ip_down"></a>
								</div>
								<?php _e('Exclude pages', 'Arjuna'); ?><br />
								<?php
								$pages = arjuna_get_all_pages('', $options['menus']['1']['exclude_pages'], $options['menus']['1']['depth']);
								?>
								<select multiple="multiple" size="7" name="menus_1_exclude_pages[]" id="hm1ep" style="height:auto;width:400px; padding-right:20px;">
									<?php if(!empty($options['menus']['1']['exclude_pages'])) arjuna_admin_walk_pages($pages); ?>
								</select>
							</div>
							</td>
						</tr>
					</tbody>
				</table>
				
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<div self:ID="secondHeaderMenu" class="srsContainer<?php if(!arjuna_admin_is_panel_open('secondHeaderMenu')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><div class="tIcon" id="icon-secondMenu"></div><?php _e('Second Header Menu', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Enabled', 'Arjuna'); ?></th>
							<td>
								<label><input name="menus_2_enabled" type="checkbox"<?php checked($options['menus']['2']['enabled']); ?> /> <?php _e('Enable this menu', 'Arjuna'); ?></label>
								<br />
								<span class="description"><?php _e('If disabled, the menu will be hidden.', 'Arjuna');?></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Separators', 'Arjuna'); ?></th>
							<td>
								<label><input name="menus_2_displaySeparators" type="checkbox"<?php checked($options['menus']['2']['displaySeparators']); ?> /> <?php _e('Visually separate the menu buttons', 'Arjuna'); ?></label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Dropdown', 'Arjuna'); ?></th>
							<td>
								<label>
									<input name="menus_2_depth" type="radio" value="1"<?php checked($options['menus']['2']['depth'], '1'); ?> />
									 <?php _e('No dropdown menu', 'Arjuna'); ?>
								</label><br />
								<label>
									<input name="menus_2_depth" type="radio" value="2"<?php checked($options['menus']['2']['depth'], '2'); ?> />
									 <?php _e('One-level dropdown menu', 'Arjuna'); ?>
								</label><br />
								<label>
									<input name="menus_2_depth" type="radio" value="3"<?php checked($options['menus']['2']['depth'], '3'); ?> />
									 <?php _e('Two-level dropdown menu', 'Arjuna'); ?>
								</label>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Home Button', 'Arjuna'); ?></th>
							<td>
								<label><input name="menus_2_displayHome" type="checkbox"<?php checked($options['menus']['2']['displayHome']); ?> /> <?php _e('Display Home button', 'Arjuna'); ?></label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Use', 'Arjuna'); ?></th>
							<td id="menus-2-useNavMenus">
								<div style="overflow:hidden;">
									<div class="tALeft"><label>
										<input name="menus_2_useNavMenus" type="radio" value="1"<?php checked($options['menus']['2']['useNavMenus']); ?> />
										 <?php _e('WordPress Custom Menus', 'Arjuna'); ?>
									</label></div>
									<div class="tALeft"><label>
										<input name="menus_2_useNavMenus" type="radio" value="0"<?php checked(!$options['menus']['2']['useNavMenus']); ?> />
										 <?php _e('Legacy Menus', 'Arjuna'); ?>
									</label></div>
								</div>
								<p class="description"><?php print str_replace(array('[[LINK_START]]', '[[LINK_END]]'), array('<a href="'.admin_url('nav-menus.php').'" target="_blank">', '</a>'), __('If you use WP Custom Menus, please assign a custom menu in [[LINK_START]]Appearance > Menus[[LINK_END]]. Otherwise, the menu will fall back to displaying all pages.', 'Arjuna'));?></p>
							</td>
						</tr>
					</tbody>
					<tbody id="menus-2-useNavMenus-legacy"<?php if($options['menus']['2']['useNavMenus']) echo ' style="display:none;"'; ?>>
						<tr valign="top">
							<th scope="row"><?php _e('Menu lists only', 'Arjuna'); ?></th>
							<td>
								<div class="tALeft"><label>
									<input name="menus_2_display" type="radio" onclick="headerMenu2_tD(this);" value="pages"<?php checked($options['menus']['2']['display'], 'pages'); ?> />
									 <?php _e('Pages', 'Arjuna'); ?>
								</label></div>
								<div class="tALeft"><label>
									<input name="menus_2_display" type="radio" onclick="headerMenu2_tD(this);" value="categories"<?php checked($options['menus']['2']['display'], 'categories'); ?> />
									 <?php _e('Categories', 'Arjuna'); ?>
								</label></div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Sorting Order', 'Arjuna'); ?></th>
							<td>
								<div id="menus_2_sortBy_categories"<?php if($options['menus']['2']['display']=='pages'): ?> style="display:none;"<?php endif; ?>>
									<?php _e('Sort menu items in', 'Arjuna'); ?> 
									<select name="menus_2_sortOrder_categories">
										<option value="asc"<?php selected($options['menus']['2']['sortOrder'], 'asc'); ?>><?php _e('ascending', 'Arjuna'); ?></option>
										<option value="desc"<?php selected($options['menus']['2']['sortOrder'], 'desc'); ?>><?php _e('descending', 'Arjuna'); ?></option>
									</select>
									<?php _e('order by', 'Arjuna'); ?>
									<select name="menus_2_sortBy_categories">
										<option value="name"<?php selected($options['menus']['2']['sortBy'], 'name'); ?>><?php _e('Category Name', 'Arjuna'); ?></option>
										<option value="ID"<?php selected($options['menus']['2']['sortBy'], 'ID'); ?>><?php _e('Category ID', 'Arjuna'); ?></option>
										<option value="count"<?php selected($options['menus']['2']['sortBy'], 'count'); ?>><?php _e('Post Count', 'Arjuna'); ?></option>
										<option value="slug"<?php selected($options['menus']['2']['sortBy'], 'slug'); ?>><?php _e('Category Slug', 'Arjuna'); ?></option>
									</select>
								</div>
								<div id="menus_2_sortBy_pages"<?php if($options['menus']['2']['display']=='categories'): ?> style="display:none;"<?php endif; ?>>
									<?php _e('Sort menu items in', 'Arjuna'); ?> 
									<select name="menus_2_sortOrder_pages">
										<option value="asc"<?php selected($options['menus']['2']['sortOrder'], 'asc'); ?>><?php _e('ascending', 'Arjuna'); ?></option>
										<option value="desc"<?php selected($options['menus']['2']['sortOrder'], 'desc'); ?>><?php _e('descending', 'Arjuna'); ?></option>
									</select>
									<?php _e('order by', 'Arjuna'); ?>
									<select name="menus_2_sortBy_pages">
										<option value="post_title"<?php selected($options['menus']['2']['sortBy'], 'post_title'); ?>><?php _e('Page Title', 'Arjuna'); ?></option>
										<option value="ID"<?php selected($options['menus']['2']['sortBy'], 'ID'); ?>><?php _e('Page ID', 'Arjuna'); ?></option>
										<option value="post_name"<?php selected($options['menus']['2']['sortBy'], 'post_name'); ?>><?php _e('Page Slug', 'Arjuna'); ?></option>
										<option value="menu_order"<?php selected($options['menus']['2']['sortBy'], 'menu_order'); ?>><?php _e('Page Order', 'Arjuna'); ?></option>
									</select>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Menu Items', 'Arjuna'); ?></th>
							<td>
							<div id="menus_2_include_categories"<?php if($options['menus']['2']['display']=='pages'): ?> style="display:none;"<?php endif; ?>>
								<?php _e('Include categories', 'Arjuna'); ?><br />
								<?php
								$categories = arjuna_get_all_categories($options['menus']['2']['exclude_categories'], '', $options['menus']['2']['depth']);
								?>
								<select multiple="multiple" size="7" name="menus_2_include_categories[]" id="hm2ic" style="height:auto;width:400px; padding-right:20px;">
									<?php arjuna_admin_walk_categories($categories); ?>
								</select>
								<div class="tArrows">
									<a href="#" class="tArrowUp" id="hm2ic_up"></a><a href="#" class="tArrowDown" id="hm2ic_down"></a>
								</div>
								<?php _e('Exclude categories', 'Arjuna'); ?><br />
								<?php
								$categories = arjuna_get_all_categories('', $options['menus']['2']['exclude_categories'], $options['menus']['2']['depth']);
								?>
								<select multiple="multiple" size="7" name="menus_2_exclude_categories[]" id="hm2ec" style="height:auto;width:400px; padding-right:20px;">
									<?php if(!empty($options['menus']['2']['exclude_categories'])) arjuna_admin_walk_categories($categories); ?>	
								</select>
								<span class="description"><?php _e('Note: While the above fields show empty categories, the theme will only display categories that have at least one published post in them.</span>', 'Arjuna'); ?></span>
							</div>
							<div id="menus_2_include_pages"<?php if($options['menus']['2']['display']!='pages'): ?> style="display:none;"<?php endif; ?>>
								<?php _e('Include pages', 'Arjuna'); ?><br />
								<?php
								$pages = arjuna_get_all_pages($options['menus']['2']['exclude_pages'], '', $options['menus']['2']['depth']);
								?>
								<select multiple="multiple" size="7" name="menus_2_include_pages[]" id="hm2ip" style="height:auto;width:400px; padding-right:20px;">
									<?php arjuna_admin_walk_pages($pages); ?>
								</select>
								<div class="tArrows">
									<a href="#" class="tArrowUp" id="hm2ip_up"></a><a href="#" class="tArrowDown" id="hm2ip_down"></a>
								</div>
								<?php _e('Exclude pages', 'Arjuna'); ?><br />
								<?php
								$pages = arjuna_get_all_pages('', $options['menus']['2']['exclude_pages'], $options['menus']['2']['depth']);
								?>
								<select multiple="multiple" size="7" name="menus_2_exclude_pages[]" id="hm2ep" style="height:auto;width:400px; padding-right:20px;">
									<?php if(!empty($options['menus']['2']['exclude_pages'])) arjuna_admin_walk_pages($pages); ?>	
								</select>
							</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<div self:ID="background" class="srsContainer<?php if(!arjuna_admin_is_panel_open('background')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('Background &amp; Color Schemes', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Background Style', 'Arjuna'); ?></th>
							<td>
								<?php 
								$versions = array(
									array('id' => 'backgroundStyle_blueish', 'value' => 'gradient_blueish', 'label' => __('Blueish gradient', 'Arjuna')),
									array('id' => 'backgroundStyle_gray', 'value' => 'gradient_gray', 'label' => __('Gray gradient', 'Arjuna')),
									array('id' => 'backgroundStyle_grayReverse', 'value' => 'gradient_gray_reverse', 'label' => __('Gray gradient (reverse)', 'Arjuna')),
									array('id' => 'backgroundStyle_khaki', 'value' => 'gradient_khaki', 'label' => __('Khaki gradient', 'Arjuna'))
								);
								foreach($versions as $version):
								?>
								<div class="tImageOptions">
									<input name="backgroundStyle" type="radio" id="<?php print $version['id']; ?>" value="<?php print $version['value']; ?>"<?php checked($options['background_style'], $version['value']); ?> />
									<div class="tImage" id="icon-<?php print $version['value'];?>"></div>
									<span><label for="<?php print $version['id']; ?>"><?php print $version['label']; ?></label></span>
								</div>
								<?php endforeach; ?>
								<div class="tImageOptions" style="float:none; clear:left;">
									<input name="backgroundStyle" type="radio" id="backgroundStyle_solid" value=""<?php checked($options['background_style'], ''); ?> />
									<span style="margin-top:0;"><label for="backgroundStyle_solid"><?php _e('Solid Color', 'Arjuna'); ?>:
										<div class="backgroundColor"><div id="backgroundColor_picker"><div class="inner"></div></div></div>
										<input name="backgroundColor" type="text" id="backgroundColor" value="<?php print esc_attr($options['background_color']); ?>" />
										<?php _e('Button Style', 'Arjuna'); ?>: <select name="backgroundButtonStyle" id="backgroundButtonStyle">
											<option value="default"<?php selected($options['solidBackground_buttonStyle'], 'default'); ?>>Default</option>
											<option value="light"<?php selected($options['solidBackground_buttonStyle'], 'light'); ?>>Light</option>
										</select>
									</label></span>
								</div>
								<br class="clear" /><span class="description"><?php _e('If the background is a solid color, you can choose the style of the buttons yourself.', 'Arjuna'); ?></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Header Image', 'Arjuna'); ?></th>
							<td>
								<table class="form-table">
									<tbody>
									<tr>
									<td>
										<?php 
										$arjunaColorSchemes = arjuna_get_color_schemes();
										foreach($arjunaColorSchemes as $color => $name) {
											print '<div class="tImageOptions" style="float:none;overflow:hidden;">';
												print '<input name="headerImage" type="radio" id="headerImage_'.$color.'" value="'.$color.'"' . checked($options['headerImage'], $color, false) . ' />';
												print '<div class="tImage" id="icon-'.$color.'"></div>';
												print '<span><label for="headerImage_'.$color.'">'.$name.'</label></span>';
											print '</div>';
										}
											
										?>
									</td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Footer Style', 'Arjuna'); ?></th>
							<td>
								<div class="tImageOptions" style="float:none;overflow:hidden;">
									<input name="footerStyle" style="margin-top:12px;" type="radio" id="footerStyle_style1" value="style1"<?php checked($options['footerStyle'], 'style1'); ?> />
									<div class="tImage" id="icon-footerStyle1"></div>
								</div>
								<div class="tImageOptions" style="float:none;overflow:hidden;">
									<input name="footerStyle" style="margin-top:8px;" type="radio" id="footerStyle_style2" value="style2"<?php checked($options['footerStyle'], 'style2'); ?> />
									<div class="tImage <?php print $options['headerImage']; ?>" id="icon-footerStyle2"></div>
									<span style="margin-top:4px;"><label for="footerStyle_style2"><?php _e('Match Header Image', 'Arjuna'); ?></label></span>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<div self:ID="sidebar" class="srsContainer<?php if(!arjuna_admin_is_panel_open('sidebar')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('Sidebar', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<p class="note"><?php printf(__('Note: To see how the sidebar and its widget bars work in Arjuna, please read our %sFAQ%s.', 'Arjuna'), '<a href="http://www.srssolutions.com/en/downloads/arjuna_wordpress_theme#faq">', '</a>'); ?></p>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Sidebar Position', 'Arjuna'); ?></th>
							<td>
								<div class="tImageOptions">
									<input name="sidebarDisplay" type="radio" id="sidebarDisplay_right" value="right"<?php checked($options['sidebarDisplay'], 'right'); ?> />
									<div class="tImage" id="icon-sidebarRight"></div>
									<span><label for="sidebarDisplay_right"><?php _e('Right sidebar', 'Arjuna'); ?></label></span>
								</div>
								<div class="tImageOptions">
									<input name="sidebarDisplay" type="radio" id="sidebarDisplay_left" value="left"<?php checked($options['sidebarDisplay'], 'left'); ?> />
									<div class="tImage" id="icon-sidebarLeft"></div>
									<span><label for="sidebarDisplay_left"><?php _e('Left sidebar', 'Arjuna'); ?></label></span>
								</div>
								<div class="tImageOptions">
									<input name="sidebarDisplay" type="radio" id="sidebarDisplay_none" value="none"<?php checked($options['sidebarDisplay'], 'none'); ?> />
									<div class="tImage" id="icon-sidebarNone"></div>
									<span><label for="sidebarDisplay_none"><?php _e('No sidebar', 'Arjuna'); ?></label></span>
								</div>
							</td>
						</tr>
						<tr id="sidebar-width-panel">
							<th scope="row"><?php _e('Sidebar Width', 'Arjuna'); ?></th>
							<td>
								<div id="content-area-width-slider" class="<?php print $options['sidebarDisplay']; ?>">
									<div class="preview">
										<div class="content-area" id="preview-content-area"></div>
										<div class="sidebar" id="preview-sidebar"></div>
									</div>
									<div class="right">
										<div class="slider" id="content-area-slider">
											<div class="handle" id="content-area-handle"></div>
										</div>
										<div class="custom">
											<p><?php _e('Content Area', 'Arjuna'); ?>:</p>
											<input type="text" id="content-area-width" maxlength="3" /> px
											<p><?php _e('Sidebar', 'Arjuna'); ?>:</p>
											<input type="text" id="sidebar-width" maxlength="3" /> px
										</div>
									</div>
									<input type="hidden" name="contentAreaWidth" id="real-content-area-width" value="<?php print $options['contentAreaWidth'] ?>" />
								</div>
								<br /><span class="description"><?php _e('Use the slider to adjust the width of the sidebar.', 'Arjuna'); ?></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Default Widgets', 'Arjuna'); ?></th>
							<td>
								<label><input name="sidebar_showDefault" type="checkbox"<?php checked($options['sidebar_showDefault']); ?> /> <?php _e('Display default sidebar widgets if the widget bars are empty.', 'Arjuna'); ?></label><br />
								<span class="description"><?php _e('If enabled, the following widgets will be displayed if the widget bar is empty: <b>Sidebar Top:</b> Recent Posts and Browse by Tags, <b>Sidebar Left:</b> Categories, <b>Siderbar Right:</b> Meta', 'Arjuna'); ?></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Sidebar Buttons', 'Arjuna'); ?></th>
							<td>
								<table class="sidebar-buttons" id="sidebar-buttons">
									<tr class="rss<?php if(!$options['sidebarButtons']['RSS']['enabled']) echo ' disabled'; if($options['sidebarButtons']['RSS']['extended']) echo ' rss-extended'; ?>">
										<td class="checkbox-col"><input type="checkbox" class="checkbox" name="sidebarButtons_RSS_enabled"<?php checked($options['sidebarButtons']['RSS']['enabled']); ?> /></td>
										<td><div class="preview"></div></td>
										<td class="label"><input name="sidebarButtons_RSS_extended" id="sidebarButtons_RSS_extended" type="checkbox"<?php checked($options['sidebarButtons']['RSS']['extended']); ?> /></td>
										<td class="text"><label for="sidebarButtons_RSS_extended"><?php _e('Use extended button.', 'Arjuna'); ?></label></td>
										<td class="label"><?php _e('Label', 'Arjuna'); ?>:</td>
										<td><input type="text" name="sidebarButtons_RSS_label" value="<?php print esc_attr($options['sidebarButtons']['RSS']['label']); ?>" /></td>
									</tr>
									<tr class="twitter<?php if(!$options['sidebarButtons']['twitter']['enabled']) echo ' disabled'; ?>">
										<td class="checkbox-col"><input type="checkbox" class="checkbox" name="sidebarButtons_twitter_enabled"<?php checked($options['sidebarButtons']['twitter']['enabled']); ?> /></td>
										<td><div class="preview"></div></td>
										<td class="label"><?php _e('Your Twitter URL', 'Arjuna'); ?>:</td>
										<td><input type="text" class="regular-text URL" name="sidebarButtons_twitter_URL" value="<?php print esc_attr($options['sidebarButtons']['twitter']['URL']); ?>" /></td>
										<td class="label"><?php _e('Label', 'Arjuna'); ?>:</td>
										<td><input type="text" name="sidebarButtons_twitter_label" value="<?php print esc_attr($options['sidebarButtons']['twitter']['label']); ?>" /></td>
									</tr>
									<tr class="facebook<?php if(!$options['sidebarButtons']['facebook']['enabled']) echo ' disabled'; ?>">
										<td class="checkbox-col"><input type="checkbox" class="checkbox" name="sidebarButtons_facebook_enabled"<?php checked($options['sidebarButtons']['facebook']['enabled']); ?> /></td>
										<td><div class="preview"></div></td>
										<td class="label"><?php _e('Your Facebook URL', 'Arjuna'); ?>:</td>
										<td><input type="text" class="regular-text URL" name="sidebarButtons_facebook_URL" value="<?php print esc_attr($options['sidebarButtons']['facebook']['URL']); ?>" /></td>
										<td class="label"><?php _e('Label', 'Arjuna'); ?>:</td>
										<td><input type="text" name="sidebarButtons_facebook_label" value="<?php print esc_attr($options['sidebarButtons']['facebook']['label']); ?>" /></td>
									</tr>
									<tr class="linked-in<?php if(!$options['sidebarButtons']['linkedIn']['enabled']) echo ' disabled'; ?>">
										<td class="checkbox-col"><input type="checkbox" class="checkbox" name="sidebarButtons_linkedIn_enabled"<?php checked($options['sidebarButtons']['linkedIn']['enabled']); ?> /></td>
										<td><div class="preview"></div></td>
										<td class="label"><?php _e('Your LinkedIn URL', 'Arjuna'); ?>:</td>
										<td><input type="text" class="regular-text URL" name="sidebarButtons_linkedIn_URL" value="<?php print esc_attr($options['sidebarButtons']['linkedIn']['URL']); ?>" /></td>
										<td class="label"><?php _e('Label', 'Arjuna'); ?>:</td>
										<td><input type="text" name="sidebarButtons_linkedIn_label" value="<?php print esc_attr($options['sidebarButtons']['linkedIn']['label']); ?>" /></td>
									</tr>
								</table>
								<p class="description"><?php _e('Choose which buttons will be included on the very top of the sidebar.', 'Arjuna'); ?></p>
								<p class="description"><?php _e('The extended RSS button will allow visitors to choose between all available RSS feeds, depending on the page they are currently browsing.', 'Arjuna'); ?></p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<div self:ID="search" class="srsContainer<?php if(!arjuna_admin_is_panel_open('search')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('Search', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Enabled', 'Arjuna'); ?></th>
							<td>
								<label><input name="search_enabled" id="search-enabled" type="checkbox"<?php checked($options['search']['enabled']); ?> /> <?php _e('Enable WordPress search', 'Arjuna'); ?></label>
								<br />
								<span class="description"><?php _e('If disabled, the search field will not be included in the header.', 'Arjuna');?></span>
							</td>
						</tr>
					</tbody>
					<tbody id="search-enabled-container"<?php if(!$options['search']['enabled']) echo ' style="display:none;"'; ?>>
						<tr valign="top">
							<th scope="row"><?php _e('Position Search', 'Arjuna'); ?></th>
							<td>
								<div class="tALeft"><label>
									<input name="search_position" type="radio" value="top"<?php checked($options['search']['position'], 'top'); ?> />
									 <?php _e('Top right (in header)', 'Arjuna'); ?>
								</label></div>
								<div class="tALeft"><label>
									<input name="search_position" type="radio" value="bottom"<?php checked($options['search']['position'], 'bottom'); ?> />
									 <?php _e('Bottom right (in header)', 'Arjuna'); ?>
								</label></div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<h3><?php _e('General Options', 'Arjuna'); ?></h3>
		
		<div self:ID="archives" class="srsContainer<?php if(!arjuna_admin_is_panel_open('archives')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('Index Pages', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<p class="note"><?php _e('Index pages include the homepage (unless it is static), archives, category and tag listing pages as well as search results pages. Basically any page that displays a listing of posts.', 'Arjuna'); ?></p>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Display Tags', 'Arjuna'); ?></th>
							<td>
								<label><input name="archives_includeTags" type="checkbox"<?php checked($options['archives_includeTags']); ?> /> <?php _e('Display the tags of a post right below each post.', 'Arjuna'); ?></label><br />
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Display Categories', 'Arjuna'); ?></th>
							<td>
								<label><input name="archives_includeCategories" type="checkbox"<?php checked($options['archives_includeCategories']); ?> /> <?php _e('Display the categories of a post right below each post.', 'Arjuna'); ?></label><br />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<div self:ID="singlePosts" class="srsContainer<?php if(!arjuna_admin_is_panel_open('singlePosts')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('Posts and Pages', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Display Author', 'Arjuna'); ?></th>
							<td>
								<label><input name="postsShowAuthor" type="checkbox"<?php checked($options['postsShowAuthor']); ?> /> <?php _e('Include the author of a post/page.', 'Arjuna'); ?></label><br />
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Display Time', 'Arjuna'); ?></th>
							<td>
								<label><input name="postsShowTime" type="checkbox"<?php checked($options['postsShowTime']); ?> /> <?php _e('Include the time and date of when the post/page has been published, instead of only the date.', 'Arjuna'); ?></label><br />
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Display Info Bar for Pages', 'Arjuna'); ?></th>
							<td>
								<label><input name="pages_showInfoBar" type="checkbox"<?php checked($options['pages_showInfoBar']); ?> /> <?php _e('Display the info bar right below the title of pages.', 'Arjuna'); ?></label><br />
								<span class="description"><?php _e('The info bar usually includes the author of the page, the publish date, and the comments button. If turned off, this option entirely hides the bar so that only the title of the page is shown.', 'Arjuna'); ?></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Navigation Links', 'Arjuna'); ?></th>
							<td>
								<label><input name="posts_showTopPostLinks" type="checkbox"<?php checked($options['posts_showTopPostLinks']); ?> /> <?php _e('Display links to the previous and next posts above each post.', 'Arjuna'); ?></label><br />
								<label><input name="posts_showBottomPostLinks" type="checkbox"<?php checked($options['posts_showBottomPostLinks']); ?> /> <?php _e('Display links to the previous and next posts below each post.', 'Arjuna'); ?></label><br />
								<span class="description"><?php _e('Note: The links will only be shown on permalink pages, i.e. the URL where one single post is displayed.', 'Arjuna'); ?></span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>

		<div self:ID="comments" class="srsContainer<?php if(!arjuna_admin_is_panel_open('comments')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('Comments &amp; Trackbacks', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Display comments as follows', 'Arjuna'); ?></th>
							<td>
								<div class="tImageOptions" style="float:none;overflow:hidden;">
									<input name="commentDisplay" type="radio" id="commentDisplay_left" value="left"<?php checked($options['commentDisplay'], 'left'); ?> />
									<div class="tImage" id="icon-commentsLeft"></div>
									<span><label for="commentDisplay_left"><?php _e('Aligned to the left', 'Arjuna'); ?></label></span>
								</div>
								<div class="tImageOptions" style="float:none;overflow:hidden;">
									<input name="commentDisplay" type="radio" id="commentDisplay_right" value="right"<?php checked($options['commentDisplay'], 'right'); ?> />
									<div class="tImage" id="icon-commentsRight"></div>
									<span><label for="commentDisplay_right"><?php _e('Aligned to the right', 'Arjuna'); ?></label></span>
								</div>
								<div class="tImageOptions" style="float:none;overflow:hidden;">
									<input name="commentDisplay" type="radio" id="commentDisplay_alt" value="none"<?php checked($options['commentDisplay'], 'alt'); ?> />
									<div class="tImage" id="icon-commentsAlt"></div>
									<span><label for="commentDisplay_alt"><?php _e('Alternate between left and right alignment', 'Arjuna'); ?></label></span>
								</div>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Date Format', 'Arjuna'); ?></th>
							<td>
									<label><input name="commentDateFormat" type="radio" value="timePassed"<?php checked($options['commentDateFormat'], 'timePassed'); ?> /> <?php _e('Passed Time (Example: <em>&quot;Written by admin about 3 days ago.&quot;</em>)', 'Arjuna'); ?></label><br />
									<label><input name="commentDateFormat" type="radio" value="date"<?php checked($options['commentDateFormat'], 'date'); ?> /> <?php printf(__('Default Date Format (Example: <em>&quot;Written by admin on %s&quot;</em>)', 'Arjuna'), date(get_option('date_format'))); ?></label><br />
									<span class="description"><?php _e('The default date format can be customized in Settings &gt; General.', 'Arjuna'); ?></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Comment Display', 'Arjuna'); ?></th>
							<td>
								<label><input name="comments_hideWhenDisabledOnPages" type="checkbox"<?php checked($options['comments_hideWhenDisabledOnPages']); ?> /> <?php _e('Hide any traces of comments when they are disabled for <strong>Pages</strong>.', 'Arjuna'); ?></label><br />
								<label><input name="comments_hideWhenDisabledOnPosts" type="checkbox"<?php checked($options['comments_hideWhenDisabledOnPosts']); ?> /> <?php _e('Hide any traces of comments when they are disabled for <strong>Posts</strong>.', 'Arjuna'); ?></label><br />
								<span class="description"><?php _e('Note: If enabled, the comments tab section as well as the comment form on pages/posts will be removed.', 'Arjuna'); ?></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Trackback Display', 'Arjuna'); ?></th>
							<td>
								<label><input name="trackbacks_hideWhenDisabledOnPages" type="checkbox"<?php checked($options['trackbacks_hideWhenDisabledOnPages']); ?> /> <?php _e('Hide any traces of trackbacks and pingbacks when they are disabled for <strong>Pages</strong>.', 'Arjuna'); ?></label><br />
								<label><input name="trackbacks_hideWhenDisabledOnPosts" type="checkbox"<?php checked($options['trackbacks_hideWhenDisabledOnPosts']); ?> /> <?php _e('Hide any traces of trackbacks and pingbacks when they are disabled for <strong>Posts</strong>.', 'Arjuna'); ?></label><br />
								<span class="description"><?php _e('Note: If enabled, the trackbacks tab section on pages/posts will be removed.', 'Arjuna'); ?></span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<div self:ID="excerpts" class="srsContainer<?php if(!arjuna_admin_is_panel_open('excerpts')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('Excerpts', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Show excerpts on', 'Arjuna'); ?></th>
							<td>
								<label><input name="excerpts_index" type="checkbox"<?php checked($options['excerpts_index']); ?> /> <?php _e('Homepage/Index page', 'Arjuna'); ?></label><br />
								<label><input name="excerpts_categoryPages" type="checkbox"<?php checked($options['excerpts_categoryPages']); ?> /> <?php _e('Category &amp; tag pages', 'Arjuna'); ?></label><br />
								<label><input name="excerpts_archivePages" type="checkbox"<?php checked($options['excerpts_archivePages']); ?> /> <?php _e('Archive pages', 'Arjuna'); ?></label><br />
								<label><input name="excerpts_searchPages" type="checkbox"<?php checked($options['excerpts_searchPages']); ?> /> <?php _e('Search pages', 'Arjuna'); ?></label><br />
								<label><input name="excerpts_authorPages" type="checkbox"<?php checked($options['excerpts_authorPages']); ?> /> <?php _e('Author pages', 'Arjuna'); ?></label><br />
								<span class="description"><?php _e('Note: If enabled, an excerpt will be shown instead of the full post on selected pages. If a post does not have a custom excerpt, an automatic excerpt of the first 55 words will be displayed.', 'Arjuna'); ?></span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<div self:ID="pagination" class="srsContainer<?php if(!arjuna_admin_is_panel_open('pagination')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('Pagination', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Pagination', 'Arjuna'); ?></th>
							<td>
								<label><input name="pagination" onclick="pagination_switch(this)" type="radio" value="1"<?php checked($options['pagination']); ?> /> <?php _e('Use Arjuna pagination', 'Arjuna'); ?></label><br />
								<span class="description"><?php _e('If enabled, Arjuna will use its own native pagination to allow your users to navigate the blog using pages.', 'Arjuna');?></span><br />
								<div id="pagination_input"<?php if(!$options['pagination']) echo ' style="display:none;"'; ?> style="padding:5px 0 5px 20px;">
									<table>
									<tr>
										<th scope="row"><?php _e('Page Range', 'Arjuna'); ?>:</th>
										<td>
										<select name="pagination_pageRange" style="width:50px;"><?php
										$validValues = array(1, 2, 3, 4, 5);
										foreach($validValues as $value) {
											print '<option value="'.$value.'"'.selected($options['pagination_pageRange'], $value, false).'>'.$value.'</option>';
										}
										?></select><span class="description"><?php _e('The number of page buttons that will appear before and after the current page button.', 'Arjuna'); ?></span>
										</td>
									</tr>
									<tr>
										<th scope="row"><?php _e('Page Anchors', 'Arjuna'); ?>:</th>
										<td>
										<select name="pagination_pageAnchors" style="width:50px;"><?php
											$validValues = array(1, 2, 3);
											foreach($validValues as $value) {
												print '<option value="'.$value.'"'.selected($options['pagination_pageAnchors'], $value, false).'>'.$value.'</option>';
											}
										?></select><span class="description"><?php _e('The number of page buttons that will always appear at the beginning and the end of the pagination.', 'Arjuna'); ?></span>
										</td>
									</tr>
									<tr>
										<th scope="row"><?php _e('Page Gap', 'Arjuna'); ?>:</th>
										<td>
										<select name="pagination_pageGap" style="width:50px;"><?php
											$validValues = array(1, 2, 3);
											foreach($validValues as $value) {
												print '<option value="'.$value.'"'.selected($options['pagination_pageGap'], $value, false).'>'.$value.'</option>';
											}
										?></select><span class="description"><?php _e('The number of page buttons in a gap before an ellipsis (...) is displayed.', 'Arjuna'); ?></span>
										</td>
									</tr>
								</table>
								</div>
								<label><input name="pagination" onclick="pagination_switch(this)" type="radio" value="0"<?php checked($options['pagination'], false); ?> /> <?php _e('Use WordPress default', 'Arjuna'); ?></label><br />
								<span class="description"><?php _e('The default depends on your WordPress version and whether you have any pagination plugins activated. If the wp-paginate or wp-pagenavi plugin is activated, then Arjuna will use these plugins to create the pagination.', 'Arjuna');?></span><br />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<div self:ID="rssFeeds" class="srsContainer<?php if(!arjuna_admin_is_panel_open('rssFeeds')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('RSS Feeds', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row"><?php _e('Use', 'Arjuna'); ?></th>
							<td id="useFeedburner">
								<div class="tALeft"><label>
									<input name="useFeedburner" type="radio" value="0"<?php checked($options['useFeedburner'], false); ?> />
									 <?php _e('Default RSS Feeds', 'Arjuna'); ?>
								</label></div>
								<div class="tALeft"><label>
									<input name="useFeedburner" type="radio" value="1"<?php checked($options['useFeedburner']); ?> />
									 <?php _e('Google Feedburner', 'Arjuna'); ?>
								</label></div>
							</td>
						</tr>
					</tbody>
					<tbody id="useFeedburner-feedburner"<?php if(!$options['useFeedburner']) echo ' style="display:none;"'; ?>>
						<tr>
							<th scope="row"><?php _e('Redirect Feeds to', 'Arjuna'); ?></th>
							<td>
								<input type="text" value="<?php if(!empty($options['feedburnerURL'])) print esc_attr($options['feedburnerURL']); ?>" name="feedburnerURL" /><br />
								<span class="description"><?php _e('Arjuna will redirect all of your existing feeds, including category and tag feeds, to Google Feedburner.', 'Arjuna');?></span><br />
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Redirect Comment Feeds to', 'Arjuna'); ?></th>
							<td>
								<input type="text" value="<?php if(!empty($options['feedburnerCommentsURL'])) print esc_attr($options['feedburnerCommentsURL']); ?>" name="feedburnerCommentsURL" /><br />
								<span class="description"><?php _e('Arjuna will redirect your comment feeds to Google Feedburner to this URL.', 'Arjuna');?></span><br />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<div self:ID="twitterWidget" class="srsContainer<?php if(!arjuna_admin_is_panel_open('twitterWidget')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('Twitter Widget', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<p class="note"><?php _e('Note: The minimum sidebar width for the twitter widget to not overflow the sidebar is 280px. Please adjust your sidebar accordingly.', 'Arjuna'); ?></p>
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row"><?php _e('Enabled', 'Arjuna'); ?></th>
							<td id="enableTwitter">
								<div class="tALeft"><label>
									<input name="twitterWidget_enabled" type="radio" value="1"<?php checked($options['twitterWidget']['enabled']); ?> />
									 <?php _e('Yes', 'Arjuna'); ?>
								</label></div>
								<div class="tALeft"><label>
									<input name="twitterWidget_enabled" type="radio" value="0"<?php checked($options['twitterWidget']['enabled'], false); ?> />
									 <?php _e('No', 'Arjuna'); ?>
								</label></div>
							</td>
						</tr>
					</tbody>
					<tbody id="enableTwitter-options"<?php if(!$options['twitterWidget']['enabled']) echo ' style="display:none;"'; ?>>
						<tr>
							<th scope="row"><?php _e('Widget Title', 'Arjuna'); ?></th>
							<td>
								<input type="text" value="<?php if(!empty($options['twitterWidget']['title'])) print esc_attr($options['twitterWidget']['title']); ?>" name="twitterWidget_title" style="width:350px;" />
								<p class="description"><?php _e('The title of the sidebar widget.', 'Arjuna');?></p>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Twitter Username', 'Arjuna'); ?></th>
							<td>
								<input type="text" value="<?php if(!empty($options['twitterWidget']['username'])) print esc_attr($options['twitterWidget']['username']); ?>" name="twitterWidget_username" style="width:200px;" />
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Height', 'Arjuna'); ?></th>
							<td>
								<input type="text" value="<?php if(!empty($options['twitterWidget']['height'])) print esc_attr($options['twitterWidget']['height']); ?>" name="twitterWidget_height" style="width:34px;" /> px
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Number of Tweets', 'Arjuna'); ?></th>
							<td>
								<select name="twitterWidget_numTweets">
									<?php
									for($i=1; $i<=30; $i++)
										print '<option value="'.$i.'"'.selected($options['twitterWidget']['numTweets'], $i, false).'>'.$i.'</option>';
									?>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Scrollbar', 'Arjuna'); ?></th>
							<td>
								<div class="tALeft"><label>
									<input name="twitterWidget_scrollbar" type="radio" value="1"<?php checked($options['twitterWidget']['scrollbar']) ; ?> />
									 <?php _e('Yes', 'Arjuna'); ?>
								</label></div>
								<div class="tALeft"><label>
									<input name="twitterWidget_scrollbar" type="radio" value="0"<?php checked($options['twitterWidget']['scrollbar'], false); ?> />
									 <?php _e('No', 'Arjuna'); ?>
								</label></div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Show Timestamp', 'Arjuna'); ?></th>
							<td>
								<div class="tALeft"><label>
									<input name="twitterWidget_showTimestamps" type="radio" value="1"<?php checked($options['twitterWidget']['showTimestamps']); ?> />
									 <?php _e('Yes', 'Arjuna'); ?>
								</label></div>
								<div class="tALeft"><label>
									<input name="twitterWidget_showTimestamps" type="radio" value="0"<?php checked($options['twitterWidget']['showTimestamps'], false); ?> />
									 <?php _e('No', 'Arjuna'); ?>
								</label></div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<div self:ID="miscellaneous" class="srsContainer<?php if(!arjuna_admin_is_panel_open('miscellaneous')) print ' srsContainerClosed'; ?>">
			<h4 class="title"><span><?php _e('Miscellaneous', 'Arjuna'); ?></span></h4>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Append to page title', 'Arjuna'); ?></th>
							<td>
								<label><input name="appendToPageTitle" type="radio" value="blogName"<?php checked($options['appendToPageTitle'], 'blogName'); ?> /> <?php printf(__('Blog Name (&quot; - %s&quot;)', 'Arjuna'), get_bloginfo('blogname')); ?></label><br />
								<label><input name="appendToPageTitle" type="radio" value="custom"<?php checked($options['appendToPageTitle'], 'custom'); ?> /> <?php _e('Custom:', 'Arjuna'); ?></label> <input type="text" value="<?php if(!empty($options['appendToPageTitleCustom'])) print esc_attr($options['appendToPageTitleCustom']); ?>" name="appendToPageTitleCustom" /><br />
								<span class="description"><?php _e('This will be appended to the page title of every web page (posts, pages, categories, etc.)', 'Arjuna'); ?></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Footer Copyright Notice', 'Arjuna'); ?></th>
							<td id="copyright-owner-box">
								<label><input name="coprightOwnerType" type="radio" value="default"<?php checked(empty($options['copyrightOwner'])); ?> /> <?php printf(__('Blog Name (&quot;%s&quot;)', 'Arjuna'), get_bloginfo('name')); ?></label><br />
								<label><input name="coprightOwnerType" type="radio" value="custom"<?php checked(!empty($options['copyrightOwner'])); ?> /> <?php _e('Custom:', 'Arjuna'); ?></label> <input type="text" value="<?php if(!empty($options['copyrightOwner'])) print esc_attr($options['copyrightOwner']); ?>" name="copyrightOwner" id="copyright-owner" /><br />
								<span class="description"><?php _e('The copyright notice will be displayed in the footer.', 'Arjuna'); ?></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Enable JavaScript menus', 'Arjuna'); ?></th>
							<td>
								<label><input name="headerMenus_enableJavaScript" type="checkbox"<?php checked($options['headerMenus_enableJavaScript']); ?> /> <?php _e('Enable JavaScript dropdown menus. This will improve usability of the menus. If JavaScript is disabled, CSS-based dropdown menus will be used instead.', 'Arjuna'); ?></label><br />
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Show IE6 Notice', 'Arjuna'); ?></th>
							<td>
								<label><input name="miscellaneous_IE6Notice" type="checkbox"<?php checked($options['miscellaneous_IE6Notice']); ?> /> <?php _e('Display a notice to Internet Explorer 6 users to update their browsers.', 'Arjuna'); ?></label><br />
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Custom CSS', 'Arjuna'); ?></th>
							<td>
								<?php
								//first check for permissions
								if (!is_writable(dirname(__FILE__).'/')):
								?>
								<br />
								<span class="description"><?php sprintf(__('Arjuna needs write permissions to create a new file %s, which will contain the custom CSS.'), '&quot;user-style.css&quot;'); ?></span>
								<?php else: ?>
								<label><input name="customCSS" onclick="customCSS_switch(this)" type="checkbox"<?php checked($options['customCSS']); ?> /> <?php _e('Enable custom CSS rules', 'Arjuna'); ?></label><br />
								<span class="description"><?php _e('If enabled, Arjuna will include your custom CSS rules with every page call. If you intend to make some minor changes to the theme, enabling this option ensures that you can safely upgrade Arjuna without losing your custom CSS. We recommend to use child themes for more serious customizations.', 'Arjuna');?></span>
								<div id="customCSS_input"<?php if(!$options['customCSS']) echo ' style="display:none;"'; ?>>
									<textarea name="customCSS_input"><?php
										print $options['customCSS_input'];
									?></textarea>
								</div>
								<?php endif; ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom"><span></span></div>
		</div>
		
		<p class="submit">
			<input class="button-primary" type="submit" name="arjuna_save_options" value="<?php _e('Save Changes', 'Arjuna'); ?>" />
		</p>
	</div>
	
	<?php wp_nonce_field('srs_arjuna', 'srs_arjuna_nonce'); ?>
</form>
	<?php
}

// register function
//add_action('admin_menu', 'arjuna_get_options');




register_sidebar(array(
	'name'=> __('Sidebar Top', 'Arjuna'),
		'id'=>'sidebar_full_top',
		'description'=>__('This is the top widget bar in the sidebar, extending to full width of the sidebar.', 'Arjuna'),
		'before_widget' => '<div id="%1$s" class="sidebarBox %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4><span>',
		'after_title' => '</span></h4>'
));
register_sidebar(array(
	'name'=>__('Sidebar Left', 'Arjuna'),
		'id'=>'sidebar_left',
		'description'=>__('This is the widget bar on the left hand side in the sidebar. It appears right below the top widget bar.', 'Arjuna'),
		'before_widget' => '<div id="%1$s" class="sidebarBox %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4><span>',
		'after_title' => '</span></h4>'
));
register_sidebar(array(
	'name'=>__('Sidebar Right', 'Arjuna'),
		'id'=>'sidebar_right',
		'description'=>__('This is the widget bar on the right hand side in the sidebar. It appears right below the top widget bar, next to the left widget bar.', 'Arjuna'),
		'before_widget' => '<div id="%1$s" class="sidebarBox %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4><span>',
		'after_title' => '</span></h4>'
));
register_sidebar(array(
	'name'=>__('Sidebar Bottom', 'Arjuna'),
		'id'=>'sidebar_full_bottom',
		'description'=>__('This is the bottom widget bar in the sidebar, extending to full width of the sidebar. It will appear below the left and right widget bars.', 'Arjuna'),
		'before_widget' => '<div id="%1$s" class="sidebarBox %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4><span>',
		'after_title' => '</span></h4>'
));

/*
register_sidebar(array(
	'name'=>'header_bar',
		'before_widget' => '<div id="%1$s" class="headerbox  %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
));
register_sidebar(array(
	'name'=>'footer_bar',
		'before_widget' => '<div id="%1$s" class="footerbox  %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
));
*/

$GLOBALS['content_width'] = $content_width = 600;

// Localization
function theme_init(){
	load_theme_textdomain('Arjuna', get_template_directory() . '/languages');
	wp_enqueue_script('jquery');
}
add_action ('init', 'theme_init');

//CSS
add_action('admin_print_styles', 'arjuna_admin_initCSS');
function arjuna_admin_initCSS() {
	wp_enqueue_style('arjunaAdminCSS', get_template_directory_uri().'/admin/admin.css');
	wp_enqueue_style('fionnFarbtasticCSS', get_template_directory_uri().'/lib/farbtastic/farbtastic.css');
}

//JS for plugin page
add_action('admin_print_scripts', 'arjuna_admin_initJS');

function arjuna_admin_initJS() {
	wp_enqueue_script('fionnFarbtasticJS', get_template_directory_uri() .'/lib/farbtastic/farbtastic.js');
	wp_enqueue_script('arjunaAdminJS', get_template_directory_uri() .'/admin/admin.js');
	wp_enqueue_script('arjunaJQueryMinJS', get_template_directory_uri() .'/lib/jquery-ui-1.8.10.custom.min.js');
}


// custom comments
$commentCount = 0;
function arjuna_get_comment($comment, $args, $depth) {
	global $commentCount;
	$arjunaOptions = arjuna_get_options();
	$GLOBALS['comment'] = $comment;
	$commentClass = 'comment';
	
?>
	<li <?php comment_class();?> id="comment-<?php comment_ID() ?>">
		<?php 
			echo get_avatar($comment, 40);
		?>
		<div class="message">
			<div class="t"><div></div></div>
			<div class="i"><div class="i2">
				<span class="title"><a href="#comment-<?php comment_ID() ?>">#<?php print ++$commentCount;?></a> | <?php _e('Written by', 'Arjuna'); ?> <?php if (!get_comment_author_url()): print get_comment_author_link(); else: ?><a href="<?php comment_author_url(); ?>" class="authorLink"><?php comment_author(); ?></a><?php endif; ?> <?php
					if($arjunaOptions['commentDateFormat'] == 'timePassed'){
						printf(__('about %s ago', 'Arjuna'), arjuna_get_time_passed(strtotime($comment->comment_date_gmt)));
					} else {
						print __('on', 'Arjuna').' '.get_comment_time(get_option('date_format'));
					}
				?>.</span>
				<span class="links">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					<?php edit_comment_link(__('Edit', 'Arjuna'),' | ',''); ?>
				</span>
				<?php if ($comment->comment_approved == '0'): ?>
					<p><?php _e('Your comment is awaiting moderation.', 'Arjuna'); ?></p>
				<?php endif; ?>
				<div id="commentbody-<?php comment_ID() ?>">
					<?php comment_text(); ?>
				</div>
			</div></div>
			<div class="b"><div></div></div>
		</div>
	<?php //</li> , WP, as strange as this is, adds it automatically ?>
<?php
}

$trackbackCount = 0;
function arjuna_get_trackback($comment, $args, $depth) {
	global $trackbackCount;
	$arjunaOptions = arjuna_get_options();
	$GLOBALS['comment'] = $comment;
	$commentClass = 'comment';
	
?>
	<li <?php comment_class();?> id="comment-<?php comment_ID() ?>">
		<?php 
			if (function_exists('get_avatar'))
				echo get_avatar($comment, 40);
		?>
		<div class="message">
			<div class="t"><div></div></div>
			<div class="i"><div class="i2">
				<span class="title"><a href="#comment-<?php comment_ID() ?>">#<?php print ++$trackbackCount;?></a> | <?php _e('Pinged by', 'Arjuna'); ?> <?php if (!get_comment_author_url()): print get_comment_author_link(); else: ?><a href="<?php comment_author_url(); ?>" class="authorLink"><?php comment_author(); ?></a><?php endif; ?> <?php
					if($arjunaOptions['commentDateFormat'] == 'timePassed'){
						printf(__('about %s ago', 'Arjuna'), arjuna_get_time_passed(strtotime($comment->comment_date_gmt)));
					} else {
						print __('on', 'Arjuna').' '.get_comment_time(get_option('date_format'));
					}
				?>.</span>
				<span class="links">
					<?php edit_comment_link(__('Edit', 'Arjuna'),'',''); ?>
				</span>
				<?php if ($comment->comment_approved == '0'): ?>
					<p><?php _e('Your trackback is awaiting moderation.', 'Arjuna'); ?></p>
				<?php endif; ?>
				<div id="commentbody-<?php comment_ID() ?>">
					<?php comment_text(); ?>
				</div>
			</div></div>
			<div class="b"><div></div></div>
		</div>
	<?php //</li> , WP, as strange as this is, adds it automatically ?>
<?php
}

function arjuna_cancel_comment_reply_link($text) {
	$style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
	$link = esc_html( remove_query_arg('replytocom') ) . '#respond';
	echo apply_filters('cancel_comment_reply_link', '<a rel="nofollow" id="cancel-comment-reply-link" class="btnCancel btn" href="' . $link . '"' . $style . '>' . $text . '</a>', $link, $text);
}

/**
 * Arjuna Get Time Passed
 * 
 * We are not using human_time_diff() since it only returns minutes, hours and days.
 * It lacks support for weeks, months and years, which is helpful for comments in aged posts.
 */
function arjuna_get_time_passed($pastTime) {
	$currentTime = time();
	$seconds = $currentTime - $pastTime;
	
	
	if ($seconds > 28944000) { //older than 335 days
		$years = round($seconds/31557600); //365.25 days
		return $years==1 ? __('1 year', 'Arjuna') : sprintf(__('%d years', 'Arjuna'), $years);
	} 
	if ($seconds > 2592000) { //older than 30 days
		$months = round($seconds/2629800); //1 month (average)
		return $months==1 ? __('1 month', 'Arjuna') : sprintf(__('%d months', 'Arjuna'), $months);
	} 
	if ($seconds > 518400) { //older than 6 days
		$weeks = round($seconds/604800); //1 week
		return $weeks==1 ? __('1 week', 'Arjuna') : sprintf(__('%d weeks', 'Arjuna'), $weeks);
	} 
	if ($seconds > 82800) { //older than 23 hours
		$days = round($seconds/86400); //1 day
		return $days==1 ? __('1 day', 'Arjuna') : sprintf(__('%d days', 'Arjuna'), $days);
	} 
	if ($seconds > 3540) { //older than 59 minutes
		$hours = round($seconds/3600); //1 hour
		return $hours==1 ? __('1 hour', 'Arjuna') : sprintf(__('%d hours', 'Arjuna'), $hours);
	} 
	if ($seconds > 59) { //older than 59 seconds
		$minutes = round($seconds/60); //1 minute
		return $minutes==1 ? __('1 minute', 'Arjuna') : sprintf(__('%d minutes', 'Arjuna'), $minutes);
	}
	
	return $seconds==1 ? __('1 second', 'Arjuna') : sprintf(__('%d seconds', 'Arjuna'), $seconds);
}

function has_pages() {
	global $wp_query;
	if ( !is_single() && $wp_query->max_num_pages > 1 )
		return true;
		
	return false;
}

add_filter('next_posts_link_attributes', 'arjuna_get_next_page_link_attributes');
function arjuna_get_next_page_link_attributes() {
	return 'class="older"';
}

add_filter('previous_posts_link_attributes', 'arjuna_get_previous_page_link_attributes');
function arjuna_get_previous_page_link_attributes() {
	return 'class="newer"';
}

function arjuna_get_previous_page_link($label) {
	previous_posts_link('<span>' . $label . '</span>');
}
function arjuna_get_next_page_link($label) {
	next_posts_link('<span>' . $label . '</span>');
	return;
}

// Returns true if there is at least one other post than the one being viewed currently
function arjuna_has_other_posts() {
	if (get_adjacent_post(false, '', false))
		return true;
	if (get_adjacent_post(false, '', true))
		return true;
	return false;
}

function arjuna_get_next_post_link($label) {
	$post = get_adjacent_post(false, '', false);
	if (!$post) return;
	echo '<a href="'.get_permalink($post).'" rel="next" class="older"><span>'.$label.'</span></a>';
}

function arjuna_get_previous_post_link($label) {
	$post = get_adjacent_post(false, '', true);
	if (!$post) return;
	echo '<a href="'.get_permalink($post).'" rel="prev" class="newer"><span>'.$label.'</span></a>';
}

function arjuna_get_appendToPageTitle() {
	$arjunaOptions = get_option('arjuna_options');
	
	if ($arjunaOptions['appendToPageTitle']=='blogName') {
		echo " - ";
		bloginfo('name');
	} elseif ($arjunaOptions['appendToPageTitle']=='custom' && !empty($arjunaOptions['appendToPageTitleCustom'])) {
		echo " - " . $arjunaOptions['appendToPageTitleCustom'];
	}
}

function arjuna_get_custom_CSS() {
	$arjunaOptions = arjuna_get_options();
	if($arjunaOptions['customCSS'] && $arjunaOptions['customCSS_input'])
		return '<style>'.$arjunaOptions['customCSS_input'].'</style>';
	return '';
}

function arjuna_get_pagination($previousLabel, $nextLabel) {
	$arjunaOptions = arjuna_get_options();
	global $wp_query;	
	
	$currentPage = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
	$postsPerPage = intval(get_query_var('posts_per_page'));
	$totalPages = intval(ceil($wp_query->found_posts/$postsPerPage));
		
	if ($totalPages > 1) {
		$output = '';
		$output .= '<div class="pagination"><div><ol>';
		
		
		//display page info, e.g. "Page 2 of 7"
		$output .= '<li class="info"><span>'.sprintf(__('Page %s of %s', 'Arjuna'), $currentPage, $totalPages).'</span></li>';
		
		//previous button
		$previousPageURL = get_pagenum_link($currentPage - 1);
		if ($currentPage > 1 && !empty($previousPageURL))
			$output .= '<li class="prev"><a href="'.$previousPageURL.'"><span>'.$previousLabel.'</span></a></li>';
		
		//the pages to be included in the pagination
		$include = array();

		$startPaginationAt = $currentPage - $arjunaOptions['pagination_pageRange'];
		if($startPaginationAt<1) $startPaginationAt = 1;
		$endPaginationAt = $currentPage + $arjunaOptions['pagination_pageRange'];
		if($endPaginationAt>$totalPages) $endPaginationAt = $totalPages;

		if($startPaginationAt > $arjunaOptions['pagination_pageAnchors'])
			for ($i=1; $i<=$arjunaOptions['pagination_pageAnchors']; $i++)
				$include[] = $i;
			
		if( $startPaginationAt - $arjunaOptions['pagination_pageGap'] > $arjunaOptions['pagination_pageAnchors'] )
			$include[] = 'gap';
			
		for ($i=$startPaginationAt; $i<=$endPaginationAt; $i++) {
			$include[] = $i;
		}
		
		if( $endPaginationAt + $arjunaOptions['pagination_pageGap'] < $totalPages-$arjunaOptions['pagination_pageAnchors']+1 )
			$include[] = 'gap';

		if($endPaginationAt < $totalPages-$arjunaOptions['pagination_pageAnchors']+1)
			for ($i=$totalPages-$arjunaOptions['pagination_pageAnchors']+1; $i<=$totalPages; $i++)
				$include[] = $i;
			
		


		//write to output string
		foreach($include as $value) {
			if($value=='gap') {
				$output .= '<li class="gap"><span>...</span></li>';
			} elseif($value==$currentPage) {
				$URL = get_pagenum_link($value);
				$output .= '<li class="current"><a href="'.$URL.'" title="'.sprintf(__('Page %s', 'Arjuna'), $value).'"><span>'.$value.'</span></a></li>';
			} else {
				$URL = get_pagenum_link($value);
				$output .= '<li><a href="'.$URL.'" title="'.sprintf(__('Page %s', 'Arjuna'), $value).'"><span>'.$value.'</span></a></li>';
			}
		}
		
		//next button
		$nextPageURL = get_pagenum_link($currentPage + 1);
		if ($currentPage < $totalPages && !empty($nextPageURL))
			$output .= '<li class="next"><a href="'.$nextPageURL.'"><span>'.$nextLabel.'</span></a></li>';
	
		$output .= '</ol></div></div>';
		
		echo $output;
	}
	return;
}

function arjuna_get_post_pagination($previousLabel, $nextLabel) {
	$arjunaOptions = arjuna_get_options();
	global $post, $page, $numpages, $multipage, $more, $pagenow;
	
	$currentPage = $page;
	$totalPages = $numpages;
		
	if ($multipage) {
		$output = '';
		$output .= '<div class="pagination"><div><ol>';
		
		
		//display page info, e.g. "Page 2 of 7"
		$output .= '<li class="info"><span>'.sprintf(__('Page %s of %s', 'Arjuna'), $currentPage, $totalPages).'</span></li>';
		
		//previous button
		$previousPageURL = arjuna_post_pagination_get_url($currentPage - 1);
		if ($currentPage > 1 && !empty($previousPageURL))
			$output .= '<li class="prev"><a href="'.$previousPageURL.'"><span>'.$previousLabel.'</span></a></li>';
		
		//the pages to be included in the pagination
		$include = array();

		for ($i=1; $i<=$totalPages; $i++) {
			if($i==$currentPage) {
				$URL = arjuna_post_pagination_get_url($i);
				$output .= '<li class="current"><a href="'.$URL.'" title="'.sprintf(__('Page %s', 'Arjuna'), $i).'"><span>'.$i.'</span></a></li>';
			} else {
				$URL = arjuna_post_pagination_get_url($i);
				$output .= '<li><a href="'.$URL.'" title="'.sprintf(__('Page %s', 'Arjuna'), $i).'"><span>'.$i.'</span></a></li>';
			}
		}

		//next button
		$nextPageURL = arjuna_post_pagination_get_url($currentPage + 1);
		if ($currentPage < $totalPages && !empty($nextPageURL))
			$output .= '<li class="next"><a href="'.$nextPageURL.'"><span>'.$nextLabel.'</span></a></li>';
	
		$output .= '</ol></div></div>';
		
		echo $output;
	}
	return;
}
function arjuna_post_pagination_get_url($page) {
	global $post;
	
	if($page == 1)
		return add_query_arg('page', $page, get_permalink());
	elseif('' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')))
		return add_query_arg('page', $page, get_permalink());
	elseif('page' == get_option('show_on_front') && get_option('page_on_front') == $post->ID)
		return trailingslashit(get_permalink()) . user_trailingslashit('page/' . $page, 'single_paged');
	
	return trailingslashit(get_permalink()) . user_trailingslashit($page, 'single_paged');
}

function arjuna_get_comment_pagination($fragment = '#_comments') {
	if ( !is_singular() || !get_option('page_comments') )
		return;
	if(get_comment_pages_count() <= 1)
		return;
	
	echo '<div class="pagination commentPagination"><div>';
	
	echo '<span class="title">' . __('Comment Pages:', 'Arjuna') . '</span>';
	paginate_comments_links('prev_text='.__('Previous', 'Arjuna').'&next_text='.__('Next', 'Arjuna').'&type=list&add_fragment='.$fragment);
	
	echo '</div></div>';
}

function arjuna_get_edit_link($label) {
	global $post;
		
	if ( !$url = get_edit_post_link( $post->ID ) ) return;
	
	return '<a href="'.$url.'" class="btn postEdit"><span>'.$label.'</span></a>';
}


function arjuna_parseExcludes($IDs, $type) {
	if(!function_exists('icl_object_id'))
		return $IDs;
	
	$array = explode(',', $IDs);
	$newArray = array();
	foreach($array as $ID)
		$newArray[] = icl_object_id($ID,$type);
	
	return implode(',', $newArray);
}

function arjuna_get_all_pages($exclude, $include, $depth) {
	$pages = array();
	
	$parameters = 'depth='.$depth;
	if($exclude)
		$parameters .= '&exclude='.$exclude;
	if($include)
		$parameters .= '&include='.$include;
	$wp_pages = get_pages($parameters);
	
	foreach($wp_pages as $wp_page) {
		if($wp_page->post_parent) {
			//find parent
			if(!arjuna_get_all_pages_iterator($pages, $wp_page))
				$pages[$wp_page->ID] = (object) array(
				'ID' => $wp_page->ID,
				'title' => $wp_page->post_title,
				'children' => array()
			);
		} else {
			$pages[$wp_page->ID] = (object) array(
				'ID' => $wp_page->ID,
				'title' => $wp_page->post_title,
				'children' => array()
			);
		}
	}
	
	return $pages;
}
function arjuna_get_all_pages_iterator(&$pages, $wp_page) {
	foreach($pages as $ID => $page) {
		if($ID == $wp_page->post_parent) {
			$pages[$ID]->children[$wp_page->ID] = (object) array(
				'ID' => $wp_page->ID,
				'title' => $wp_page->post_title,
				'children' => array()
			);
			return true;
		} elseif(!empty($page->children)) {
			if(arjuna_get_all_pages_iterator($page->children, $wp_page))
				return true;
		}
	}
	return false;
}

function arjuna_admin_walk_pages($pages, $level=0) {
	if(empty($pages))
		return true;
	
	foreach($pages as $page) {
		print '<option value="'.$page->ID.'"'.($level ? ' style="margin-left:'. 15*$level .'px;"' : '').'>'.$page->title.'</option>';
		if(!empty($page->children))
			arjuna_admin_walk_pages($page->children, $level+1);
	}
}

function arjuna_get_all_categories($exclude, $include, $depth) {
	global $_tmp_buffer;
	$_tmp_buffer = array();
	
	$categories = array();
	
	$parameters = 'depth='.$depth . '&hide_empty=0';
	if($exclude)
		$parameters .= '&exclude='.$exclude;
	if($include)
		$parameters .= '&include='.$include;
	$wp_categories = get_categories($parameters);
	
	foreach($wp_categories as $wp_category) {
		if($wp_category->parent) {
			//put into buffer
			if(!isset($_tmp_buffer[$wp_category->parent]))
				$_tmp_buffer[$wp_category->parent] = array();
			$_tmp_buffer[$wp_category->parent][] = (object) array(
				'ID' => $wp_category->cat_ID,
				'title' => $wp_category->cat_name,
				'children' => array()
			);
		} else {
			$categories[$wp_category->cat_ID] = (object) array(
				'ID' => $wp_category->cat_ID,
				'title' => $wp_category->cat_name,
				'children' => array()
			);
		}
	}
	
	//now use the buffer
	foreach($categories as $ID => $category)
		$categories[$ID] = arjuna_get_all_categories_iterator($category);
	
	return $categories;
}
function arjuna_get_all_categories_iterator($category) {
	global $_tmp_buffer;
	
	if(!isset($_tmp_buffer[$category->ID]))
		return $category;
	
	$categories = $_tmp_buffer[$category->ID];
	foreach($categories as $key => $cat)
		$categories[$key] = arjuna_get_all_categories_iterator($cat);
	
		
	$category->children = $categories;
		
	return $category;
}

function arjuna_admin_walk_categories($categories, $level=0) {
	if(empty($categories))
		return true;
	
	foreach($categories as $category) {
		print '<option value="'.$category->ID.'"'.($level ? ' style="margin-left:'. 15*$level .'px;"' : '').'>'.$category->title.'</option>';
		if(!empty($category->children))
			arjuna_admin_walk_categories($category->children, $level+1);
	}
}

function arjuna_get_upload_directory() {
	$uploadpath = wp_upload_dir();
	$path = $uploadpath['basedir'] . '/arjuna';
	if(!is_dir($path))
		@mkdir($path, 0777, true);
	return $path;
}
function arjuna_get_upload_url() {
	$uploadpath = wp_upload_dir();
	if ($uploadpath['baseurl']=='')
		$uploadpath['baseurl'] = get_bloginfo('siteurl').'/wp-content/uploads';
	return $uploadpath['baseurl'] . '/arjuna';
}

add_filter('get_comments_number', 'arjuna_comment_count', 0);
function arjuna_comment_count( $count ) {
	if (!is_admin()) {
		global $id;
		$comments = get_comments('status=approve&post_id=' . $id);
		$comments_by_type = separate_comments($comments);
		return count($comments_by_type['comment']);
	} 
	return $count;
}

function arjuna_is_show_comments() {
	global $comments_by_type, $post, $id;
	$arjunaOptions = arjuna_get_options();
	$comments = get_comments('status=approve&post_id=' . $id);
	$comments_by_type = separate_comments($comments);
	
	if($post->comment_status == 'open')
		return true;
	
	if(count($comments_by_type['comment']))
		return true;
		
	if($post->post_type == 'page' && !$arjunaOptions['comments_hideWhenDisabledOnPages'])
		return true;
	
	if($post->post_type == 'post' && !$arjunaOptions['comments_hideWhenDisabledOnPosts'])
		return true;
		
	return false;
}

function arjuna_is_show_trackbacks() {
	global $comments_by_type, $post, $id;
	$arjunaOptions = arjuna_get_options();
	$comments = get_comments('status=approve&post_id=' . $id);
	$comments_by_type = separate_comments(get_comments('status=approve&post_id=' . $id));
	
	if($post->ping_status == 'open')
		return true;
	
	if(count($comments_by_type['pings']))
		return true;
		
	if($post->post_type == 'page' && !$arjunaOptions['trackbacks_hideWhenDisabledOnPages'])
		return true;
	
	if($post->post_type == 'post' && !$arjunaOptions['trackbacks_hideWhenDisabledOnPosts'])
		return true;
		
	return false;
}

function arjuna_get_comments_count() {
	global $id;
	$comments = get_comments('status=approve&post_id=' . $id);
	$comments_by_type = separate_comments($comments);
	
	return count($comments_by_type['comment']);
}

function arjuna_get_trackbacks_count() {
	global $id;
	$comments = get_comments('status=approve&post_id=' . $id);
	$comments_by_type = separate_comments($comments);
	
	return count($comments_by_type['pings']);
}

function arjuna_nav_menus() {
	register_nav_menus(array(
		'header_menu_1' => __('First Header Menu', 'Arjuna'),
		'header_menu_2' => __('Second Header Menu', 'Arjuna'),
	));
}
add_action('init', 'arjuna_nav_menus');

function arjuna_redirect_feeds() {
	global $feed, $withcomments;
	$arjunaOptions = arjuna_get_options();
	
	if (!is_feed())
		return;
	
	if(!$arjunaOptions['useFeedburner'])
		return;
		
	if (preg_match('/feedburner/i', $_SERVER['HTTP_USER_AGENT']))
		return;
		
	if(!$arjunaOptions['useFeedburner'])
		return;
		
	$URL = $arjunaOptions['feedburnerURL'];
	$commentsURL = $arjunaOptions['feedburnerCommentsURL'];
		
	// Get category
	$category = get_query_var('category_name');
	if ($category) {
		$URL .= '_'.$category;
	}
	
	// Get tag
	$tag = get_query_var('tag');
	if ($tag) {
		$URL .= '_'.$tag;
	}

	// Get search terms
	$search = get_query_var('s');
	
	if ($feed == 'comments-rss2' || is_single() || $withcomments) {
		if ($commentsURL) {
			header("Location: ".$commentsURL);
			exit;
		}
	} else {
		switch($feed) {
			case 'feed':
			case 'rdf':
			case 'rss':
			case 'rss2':
			case 'atom':
				if ($URL) {
					// Redirect the feed
					header("Location: ".$URL);
					exit;
				}
		}
	}
	
	
}
add_action('template_redirect', 'arjuna_redirect_feeds');

function arjuna_create_twitter_widget($args) {
	$arjunaOptions = arjuna_get_options();
	extract($args);
	
	echo $before_widget;
	echo $before_title . $arjunaOptions['twitterWidget']['title'] . $after_title;
	
		//calc width
		print '<div id="arjuna-tmp"></div>';
		
		print '<script src="http://widgets.twimg.com/j/2/widget.js"></script>';
		print '<script>';
		print 'new TWTR.Widget({';
		  print 'version: 2,';
		  print 'type: "profile",';
		  print 'rpp: '.$arjunaOptions['twitterWidget']['numTweets'].',';
		  print 'interval: 6000,';
		  print 'width: jQuery("#arjuna-tmp").width(),';
		  print 'height: '.$arjunaOptions['twitterWidget']['height'].',';
		  print 'theme: {';
		    print 'shell: {';
		      print 'background: "#e0e0e0",';
		      print 'color: "#000000"';
		    print '},';
		    print 'tweets: {';
		      print 'background: "#e0e0e0",';
		      print 'color: "#333333",';
		      print 'links: "#5C7A99"';
		    print '}';
		  print '},';
		  print 'features: {';
		    print 'scrollbar: '.($arjunaOptions['twitterWidget']['scrollbar'] ? 'true' : 'false').',';
		    print 'loop: false,';
		    print 'live: false,';
		    print 'hashtags: true,';
		    print 'timestamp: '.($arjunaOptions['twitterWidget']['showTimestamps'] ? 'true' : 'false').',';
		    print 'avatars: false,';
		    print 'behavior: "all"';
		  print '}';
		print '}).render().setUser("'.$arjunaOptions['twitterWidget']['username'].'").start();';
		print '</script>';
	
    echo $after_widget;
}

function arjuna_create_twitter_widget_control() {
	print '<p>'.__('Please go to Appearance > Arjuna Options to configure your Arjuna twitter widget.', 'Arjuna').'</p>';
}

add_action('init', 'arjuna_register_twitter_widget');
function arjuna_register_twitter_widget() {
    wp_register_sidebar_widget(
    	'arjuna_twitter_widget',
    	__('Arjuna Twitter Profile Widget', 'Arjuna'),
    	'arjuna_create_twitter_widget',
    	array(
    		'classname' => 'arjuna_twitter_widget',
    		'description' => __("Display Twitter Goodies Profile Widget", "Arjuna"),
    	)
    );
    wp_register_widget_control(
    	'arjuna_twitter_widget',
    	__('Arjuna Twitter Profile Widget', 'Arjuna'),
    	'arjuna_create_twitter_widget_control',
    	array('id_base' => 'arjuna_twitter_widget')
    );
}

//fallback for nav menus
function arjuna_print_page_menu() {
	$arjunaOptions = arjuna_get_options();
	
	$html = '';
	
	$html .= '<ul id="headerMenu2">';
		if($arjunaOptions['menus']['2']['displayHome'])
			$html .= '<li><a href="' . (function_exists('icl_get_home_url')?icl_get_home_url():home_url('/')) . '" class="homeIcon">' . __('Home','Arjuna') . '</a></li>';
		
		$html .= wp_list_pages('title_li=&echo=0&depth='.$arjunaOptions['menus']['2']['depth']);
	$html .= '</ul>';
	
	print $html;
}

add_theme_support('automatic-feed-links');
