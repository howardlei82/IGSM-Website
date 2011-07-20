<?php
/**
 * Template Name: Blank - (see Adv Opts admin)
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header('blank'); ?>
<!-- Weaver Wrapper Only -->
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
	<?php edit_post_link( __( 'Edit', TTW_TRANS ), '<span class="edit-link">', '</span>' ); ?>
<?php endwhile; ?>
<?php get_footer('blank'); ?>
