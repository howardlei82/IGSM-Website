<?php $arjunaOptions = arjuna_get_options(); ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"  />
<?php get_template_part( 'templates/core/head-title-tag' ); ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' );?>
<?php get_template_part( 'templates/core/global-includes' ); ?>
<?php get_template_part( 'templates/core/content-ratio-calculation' ); ?>
<?php print arjuna_get_custom_CSS(); ?>
<?php wp_head(); ?>
</head>

<?php get_template_part( 'templates/core/body-tag' ); ?>
<a id="skipToPosts" href="#contentArea"><?php _e('Skip to posts', 'Arjuna'); ?></a>
<?php get_template_part( 'templates/core/ie6-notice' ); ?>
<div class="pageContainer">
	<div class="headerBG"></div>
	<?php get_template_part( 'templates/header' ); ?>

	<div class="contentWrapper<?php
		//Sidebar
		if ($arjunaOptions['sidebarDisplay']=='none')
			print ' NS';
		elseif ($arjunaOptions['sidebarDisplay']=='right')
			print ' RS';
		elseif ($arjunaOptions['sidebarDisplay']=='left')
			print ' LS';
	?>">
		


