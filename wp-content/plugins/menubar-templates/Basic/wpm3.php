<?php
/* 
	WordPress Menubar Plugin
	PHP script for the Basic template
*/

function wpm_display_Basic ($menu, $css)
{
	wpm_menu ($menu->id, $level, $css, "\n%s", "<a%s%s>%s</a>\n");
}
?>
