<?php $arjunaOptions = arjuna_get_options(); ?>
<div class="headerMenu2<?php if($arjunaOptions['menus']['2']['displaySeparators']): ?> headerMenu2DS<?php endif; ?>"><div class="helper"></div>
	<?php
	if($arjunaOptions['menus']['2']['useNavMenus']) {
		$settings = array(
			'theme_location' => 'header_menu_2',
			'container' => false,
			'menu_class' => false,
			'menu_id' => 'headerMenu2',
			'depth' => (int)$arjunaOptions['menus']['2']['depth'],
			'fallback_cb' => 'arjuna_print_page_menu',
		);
		
		if($arjunaOptions['menus']['2']['displayHome']) {
			$settings['items_wrap'] = '<ul id="%1$s" class="%2$s">';
			$settings['items_wrap'] .= '<li><a href="';
				if(function_exists('icl_get_home_url'))
					$settings['items_wrap'] .= icl_get_home_url();
				else $settings['items_wrap'] .= home_url();
			$settings['items_wrap'] .= '" class="homeIcon">' . __('Home', 'Arjuna') . '</a></li>';
			$settings['items_wrap'] .= '%3$s</ul>';
		}
		
		wp_nav_menu($settings);
	} else { ?>
		<ul id="headerMenu2">
			<?php if($arjunaOptions['menus']['2']['displayHome']): ?><li><a href="<?php print (function_exists('icl_get_home_url')?icl_get_home_url():home_url()) ?>" class="homeIcon"><?php _e('Home','Arjuna'); ?></a></li><?php endif; ?><?php
				if ($arjunaOptions['menus']['2']['display']=='pages') {
					wp_list_pages('sort_column='.$arjunaOptions['menus']['2']['sortBy'].'&sort_order='.$arjunaOptions['menus']['2']['sortOrder'].'&title_li=&exclude='.arjuna_parseExcludes($arjunaOptions['menus']['2']['exclude_pages'], 'page').'&depth='.$arjunaOptions['menus']['2']['depth']);
				} elseif ($arjunaOptions['menus']['2']['display']=='categories') {
					wp_list_categories('orderby='.$arjunaOptions['menus']['2']['sortBy'].'&order='.$arjunaOptions['menus']['2']['sortOrder'].'&title_li=&exclude='.arjuna_parseExcludes($arjunaOptions['menus']['2']['exclude_categories'], 'category').'&depth='.$arjunaOptions['menus']['2']['depth']);
				}
			?>
		</ul>
	<?php } ?>
	<span class="clear"></span>
</div>