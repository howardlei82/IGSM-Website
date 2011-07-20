</div> <!-- [containerbody] -->
<!-- The main column ends  -->

<!-- begin footer -->

<div id="containerfooter">
	<div id="extra">
		<img alt="" src="<?php bloginfo('template_directory'); ?>/img/login.png" width="17" height="17" />
		<a href="<?php bloginfo('url'); ?>/wp-login.php">Login</a>
		<img alt="" src="<?php bloginfo('template_directory'); ?>/img/register.jpg" height="17"/>
		<a href="<?php bloginfo('url'); ?>/wp-login.php?action=register">Register</a>
		<img alt="" src="<?php bloginfo('template_directory'); ?>/img/mail.png"/>
		<a href="<?php bloginfo('url'); ?>/contact-us">Contact us</a>
		<img alt="" src="<?php bloginfo('template_directory'); ?>/img/rss.png"/>
		<a href="<?php bloginfo('url'); ?>/feed">RSS feed</a>
	</div>

	<div id="copyright">
	<?php bloginfo('name'); ?> &copy; International Graduate Student Ministry <?php echo date('Y');?> 
	</div>

</div> <!-- [footer] -->
<?php if (function_exists('sc_comp_start')) sc_comp_start() ?>
<?php do_action('wp_footer'); ?>
<?php if (function_exists('sc_comp_end')) sc_comp_end() ?>
<!--<?php echo 'Datenbank: ' . $wpdb->num_queries; ?> Queries, <?php timer_stop(1); ?> Seconds. -->

</body>
</html>