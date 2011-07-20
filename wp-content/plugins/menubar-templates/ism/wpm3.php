<?php
/* 
	WordPress Menubar Plugin
	PHP script for the ISM menu template

	Credits:
*/

function wpm_display_ism ($menu, $css)
{
	wpm_menu ($menu->id, $level, $css, "\n<ul>%s</ul>", "<li%s><a%s>%s</a>%s</li>\n");
}
?>
