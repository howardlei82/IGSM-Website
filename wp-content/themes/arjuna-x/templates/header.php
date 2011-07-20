<?php $arjunaOptions = arjuna_get_options(); ?>
<div class="header">
	<?php if($arjunaOptions['menus']['1']['enabled']): ?>
	<div class="headerMenu1<?php if($arjunaOptions['menus']['1']['align']=='left'): ?> headerMenu1L<?php endif; ?>">
		<?php
		if($arjunaOptions['menus']['1']['useNavMenus']) {
			wp_nav_menu(array(
				'theme_location' => 'header_menu_1',
				'container' => false,
				'menu_class' => false,
				'menu_id' => 'headerMenu1',
				'depth' => $arjunaOptions['menus']['1']['depth'],
			));
		} else { ?>
			<ul id="headerMenu1"><?php
				if ($arjunaOptions['menus']['1']['display']=='pages') {
					wp_list_pages('sort_column='.$arjunaOptions['menus']['1']['sortBy'].'&sort_order='.$arjunaOptions['menus']['1']['sortOrder'].'&title_li=&exclude='.arjuna_parseExcludes($arjunaOptions['menus']['1']['exclude_pages'], 'page').'&depth='.$arjunaOptions['menus']['1']['depth']);
				} elseif ($arjunaOptions['menus']['1']['display']=='categories') {
					wp_list_categories('orderby='.$arjunaOptions['menus']['1']['sortBy'].'&order='.$arjunaOptions['menus']['1']['sortOrder'].'&title_li=&exclude='.arjuna_parseExcludes($arjunaOptions['menus']['1']['exclude_categories'], 'category').'&depth='.$arjunaOptions['menus']['1']['depth']);
				}
			?></ul>
		<?php } ?>
		<span class="clear"></span>
	</div>
	<?php endif; ?>
	<?php get_template_part( 'templates/header/header-main' ); ?>
	<?php if($arjunaOptions['menus']['2']['enabled']): ?>
		<?php get_template_part( 'templates/header/menu-2' ); ?>
	<?php else: ?>
		<div class="noHeaderMenu2"></div>
	<?php endif; ?>
</div>