<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

	<div id="container">
	<?php ttw_put_ttw_widgetarea('postpages-widget-area','ttw-top-widget','ttw_hide_special_posts'); ?>
	    <div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<div id="nav-above" class="navigation">
		    <div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', TTW_TRANS ) . '</span> %title' ); ?></div>
		    <div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', TTW_TRANS ) . '</span>' ); ?></div>
		</div><!-- #nav-above -->

		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		    <h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-meta">
			    <?php twentyten_posted_on(); ?>
			</div><!-- .entry-meta -->
			<div class="entry-content">
			    <?php ttw_the_content_featured_single(); ?>
			    <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', TTW_TRANS ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->

<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
		<div id="entry-author-info">
		    <div id="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyten_author_bio_avatar_size', 60 ) ); ?>
		    </div><!-- #author-avatar -->
		    <div id="author-description">
			<h2><?php printf( esc_attr__( 'About %s', TTW_TRANS ), get_the_author() ); ?></h2>
			<?php the_author_meta( 'description' ); ?>
			<div id="author-link">
			    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
				<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', TTW_TRANS ), get_the_author() ); ?>
			    </a>
			</div><!-- #author-link	-->
		    </div><!-- #author-description -->
		</div><!-- #entry-author-info -->
<?php endif; ?>

		<div class="entry-utility">
		    <?php twentyten_posted_in(); ?>
		    <?php edit_post_link( __( 'Edit', TTW_TRANS ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-utility -->
		</div><!-- #post-## -->

		<div id="nav-below" class="navigation">
		    <div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', TTW_TRANS ) . '</span> %title' ); ?></div>
		    <div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', TTW_TRANS ) . '</span>' ); ?></div>
		</div><!-- #nav-below -->

		<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>

	    </div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
