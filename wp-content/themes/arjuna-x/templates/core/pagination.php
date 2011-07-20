<?php $arjunaOptions = arjuna_get_options(); ?>
<?php
if($arjunaOptions['pagination']) {
	arjuna_get_pagination(__('Prev', 'Arjuna'), __('Next', 'Arjuna'));
} elseif(function_exists('wp_paginate')) {
	print '<div class="pagination">';
	wp_paginate();
	print '</div>';
} elseif(function_exists('wp_pagenavi')) {
	print '<div class="pagination">';
	wp_pagenavi();
	print '</div>';
} elseif(has_pages()) {
	print '<div class="pagination"><div>';
	arjuna_get_previous_page_link(__('Newer Entries', 'Arjuna'));
	arjuna_get_next_page_link(__('Older Entries', 'Arjuna'));
	print '</div></div>';
}
?>