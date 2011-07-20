<?php wp_enqueue_script('arjuna_default', get_template_directory_uri() . '/default.js'); ?>
<!--[if lte IE 7]><link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/ie7.css" type="text/css" media="screen" /><![endif]-->
<!--[if lte IE 6]>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/ie6.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/ie6.js"></script>
<![endif]-->
<?php get_template_part( 'templates/core/additional-global-includes' ); ?>
