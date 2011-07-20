<?php $arjunaOptions = arjuna_get_options(); ?>
<?php 
if ($arjunaOptions['headerImage'])
	$tmp = 'footer_'.$arjunaOptions['headerImage'];
else $tmp = 'footer_lightBlue';
?>
		<div class="clear"></div>
	</div><!-- .contentWrapper -->
	<div class="<?php if($arjunaOptions['footerStyle']=='style1') print 'footer'; else print 'footer2 '.$tmp; ?>">
		<div class="footerTop"></div>
		<div class="footerContainer">
			<a href="http://www.wordpress.org" class="icon1"><img src="<?php echo get_template_directory_uri(); ?>/images/<?php if($arjunaOptions['footerStyle']=='style1'): ?>wordpressIcon.png<?php else: ?>footer/WordPressIcon.png<?php endif; ?>" width="20" height="20" alt="Powered by WordPress" /></a>
			<a class="icon2"><img src="<?php echo get_template_directory_uri(); ?>/images/footer/SRSIcon.png" width="31" height="18" alt="Web Design by SRS Solutions" /></a>
			<span class="copyright">&copy; <?php print date('Y'); ?> <?php if(!empty($arjunaOptions['copyrightOwner'])) print $arjunaOptions['copyrightOwner']; else bloginfo('name'); ?></span>
			<span class="design"><a href="http://www.srssolutions.com/en/services/design/website_design/wordpress_design" title="Design by SRS Solutions">Design by <em>SRS Solutions</em></a></span>
		</div>
	</div>
	<div class="clear"></div>
</div><!-- .pageContainer -->

<?php wp_footer(); ?>
</body>
</html>
