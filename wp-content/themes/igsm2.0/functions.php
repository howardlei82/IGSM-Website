<?php 
if ( function_exists('register_sidebar') )register_sidebars(2);

function excerpt_ellipse($text) {
   return str_replace('</p>', ' <a href="'.get_permalink().'">[more...]</a></p>', $text); 
}

add_filter('the_excerpt', 'excerpt_ellipse');

add_theme_support('menus'); 

?>
