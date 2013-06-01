<?php
/**
 * The loop for displaying single posts.
 *
 * @package WordPress
 * @subpackage Football_Club
 */
?>
<div class="featured-image">
	<?php the_post_thumbnail('featured-image', array('title' => get_the_title())); ?>
</div>
<div class="entry-title">
	<h1><?php the_title(); ?></h1>
	<span class="post-date text-right"><?php echo get_the_date(); ?></span>
</div>
<div id="content" role="main">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php comments_template(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'themeboy' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
			<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
				<div id="entry-author-info">
					<div id="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'footballclub_author_bio_avatar_size', 60 ) ); ?>
					</div><!-- #author-avatar -->
					<div id="author-description">
						<h2><?php printf( esc_attr__( 'About %s', 'themeboy' ), get_the_author() ); ?></h2>
						<?php the_author_meta( 'description' ); ?>
						<div id="author-link">
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
								<?php printf( __( 'View all posts by %s', 'themeboy' ), get_the_author() ); ?> <span class="meta-nav">&#x25B8;</span>
							</a>
						</div><!-- #author-link	-->
					</div><!-- #author-description -->
				</div><!-- #entry-author-info -->
			<?php endif; ?>
			<div class="entry-utility">
					<?php edit_post_link( __( 'Edit', 'themeboy' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->
		<div id="nav-below" class="navigation">
			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . '&#x25C2;' . '</span> %title', true ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . '&#x25B8;' . '</span>', true ); ?>
		</div><!-- #nav-below -->
	<?php endwhile; // end of the loop. ?>
	<?php tb_social_buttons(); ?>
</div><!-- #content -->