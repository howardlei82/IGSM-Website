<?php $arjunaOptions = arjuna_get_options(); ?>
<?php if($arjunaOptions['search']['enabled']): ?>
<?php 
if($arjunaOptions['search']['position'] == 'bottom')
	print '<div class="headerSearch headerSearchBottom">';
else print '<div class="headerSearch headerSearchTop">';
?>
	<form method="get" action="<?php echo home_url(); ?>/">
		<input type="text" class="searchQuery searchQueryIA" id="searchQuery" value="<?php _e('Search here...', 'Arjuna'); ?>" name="s" />
		<input type="submit" class="searchButton" value="<?php _e('Find', 'Arjuna'); ?>" />
	</form>
</div>
<?php endif; ?>