<title><?php
if (is_home ()) { bloginfo('name'); echo " - "; bloginfo('description'); }
elseif (is_category() || is_tag()) {single_cat_title(); arjuna_get_appendToPageTitle(); }
elseif (is_single() || is_page()) {single_post_title(); arjuna_get_appendToPageTitle(); }
elseif (is_search()) {_e('Search Results:', 'Arjuna'); echo " ".esc_html($s); arjuna_get_appendToPageTitle(); }
else { echo trim(wp_title(' ',false)); arjuna_get_appendToPageTitle(); }
?></title>