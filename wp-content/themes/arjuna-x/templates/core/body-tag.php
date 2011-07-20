<?php $arjunaOptions = arjuna_get_options(); ?>
<?php
$bodyClasses = array();
if(!$arjunaOptions['headerMenus_enableJavaScript'])
	$bodyClasses[] = 'menusNoJS';
if(!$arjunaOptions['menus']['1']['enabled'])
	$bodyClasses[] = 'hideHeaderMenu1';
if($arjunaOptions['background_style'])
	$bodyClasses[] = $arjunaOptions['background_style'];
else
	$bodyClasses[] = 'buttonStyle_'.$arjunaOptions['solidBackground_buttonStyle'];
?>
<body <?php body_class($bodyClasses); ?><?php if(!$arjunaOptions['background_style']) print ' style="background-color:'.$arjunaOptions['background_color'].'"'; ?>>