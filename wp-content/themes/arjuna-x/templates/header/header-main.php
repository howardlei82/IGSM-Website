<?php $arjunaOptions = arjuna_get_options(); ?>
<?php
if ($arjunaOptions['headerImage'])
	$tmp = ' header_'.$arjunaOptions['headerImage'];
else $tmp = ' header_lightBlue';
?>
<div class="headerMain<?php print $tmp; ?>">
	<?php if($arjunaOptions['headerLogo']): ?>
		<a href="<?php echo home_url(); ?>"><img src="<?php print $arjunaOptions['headerLogo']; ?>" height="<?php print $arjunaOptions['headerLogo_height']; ?>" width="<?php print $arjunaOptions['headerLogo_width']; ?>" style="position:absolute;top:50%;margin:-<?php print ceil($arjunaOptions['headerLogo_height']/2); ?>px 0 0 20px;" /></a>
	<?php else: ?>
		<h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
		<span><?php bloginfo('description'); ?></span>
	<?php endif; ?>
	
	<?php get_template_part( 'templates/header/search' ); ?>
</div>