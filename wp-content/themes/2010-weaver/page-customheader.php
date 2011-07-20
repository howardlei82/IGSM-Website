<?php
/**
 * Template Name: Custom Header (see Adv Opts admin)
 *
 * A custom page template with a right sidebar and alternate widget area.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 */
?>
<?php get_header('custom'); ?>
	<div id="container" class="wvr-customheader">
	<?php ttw_put_ttw_widgetarea('top-widget-area','ttw-top-widget','ttw_hide_widg_pages'); ?>
	<div id="content">
		<?php the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if ( is_front_page() ) { ?>
			<h2 class="entry-title"><?php the_title(); ?></h2>
			<?php } else { ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php } ?>

			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', TTW_TRANS ), 'after' => '</div>' ) ); ?>
				<?php edit_post_link( __( 'Edit', TTW_TRANS ), '<span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-content -->
		</div><!-- #post-<?php the_ID(); ?> -->
		<?php comments_template( '', true ); ?>
	</div><!-- #content -->
	<?php ttw_put_ttw_widgetarea('bottom-widget-area','ttw-bot-widget','ttw_hide_widg_pages'); ?>
	</div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
