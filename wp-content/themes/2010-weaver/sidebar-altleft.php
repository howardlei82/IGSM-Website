<?php
/**
 * The Right Alternative sidebar
 *
 * @package WordPress
 * @subpackage Twenty_Ten_Weaver
 * @since Twenty Ten weaver 1.5
 */
  // An alternative sidebar for the right sidebar template
    if ( is_active_sidebar( 'alternative-widget-area' ) ) {
    printf('<div id="altleft" class="widget-area" role="complementary">
    <ul class="xoxo">'."\n");
	dynamic_sidebar( 'alternative-widget-area' );
    printf("</ul>
</div><!-- #altleft .widget-area -->\n");
    }
?>
