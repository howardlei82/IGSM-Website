<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

	<div id="container">
	<?php ttw_put_ttw_widgetarea('postpages-widget-area','ttw-top-widget','ttw_hide_special_posts'); ?>

	    <div id="content" role="main">

		<?php
		printf('<h1 id ="category-title-%s" class="page-title category-title">',strtolower(str_replace(' ','-',single_cat_title( '', false )))); echo("\n");
		printf( __( 'Category Archives: %s', TTW_TRANS ), '<span>' . single_cat_title( '', false ) . '</span></h1>' );

		$category_description = category_description();
		if ( ! empty( $category_description ) )
			echo '<div class="archive-meta">' . $category_description . '</div>';

		/* Run the loop for the category page to output the posts.
		 * If you want to overload this in a child theme then include a file
		 * called loop-category.php and that will be used instead.
		 */
		get_template_part( 'loop', 'category' );
		?>

	    </div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
