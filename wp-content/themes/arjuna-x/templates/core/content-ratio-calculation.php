<?php $arjunaOptions = arjuna_get_options(); ?>
<?php
//calculate sidebar and content area ratio
if ($arjunaOptions['sidebarDisplay'] != 'none') {
	$available = 920;
	$contentArea = $arjunaOptions['contentAreaWidth'];
	$sidebar = $available - $contentArea;
	$sidebarLeftRight = floor(($sidebar - 50) / 2);
	
	print '<style type="text/css">';
		print '.contentWrapper .contentArea {width:'.$contentArea.'px;}';
		print '.contentWrapper .sidebars {width:'.$sidebar.'px;}';
		print '.contentWrapper .sidebarLeft, .contentWrapper .sidebarRight {width:'.$sidebarLeftRight.'px;}';
	print '</style>';
}
?>