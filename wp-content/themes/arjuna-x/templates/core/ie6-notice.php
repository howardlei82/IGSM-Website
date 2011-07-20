<?php $arjunaOptions = arjuna_get_options(); ?>
<?php if($arjunaOptions['miscellaneous_IE6Notice']): ?>
<!--[if lte IE 6]>
<div class="IENotice"><?php _e('This browser is outdated. Please <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx">upgrade</a> your browser to enjoy this website to its fullest extent.', 'Arjuna'); ?></div>
<![endif]-->
<?php endif; ?>