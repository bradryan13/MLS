<?php
/**
 * The loop that displays a full width page.
 *
 * @package WordPress
 * @subpackage Football_Club
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div class="featured-image">
		<?php the_post_thumbnail('onecolumn-image', array('title' => get_the_title())); ?>
	</div>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if ( is_front_page() ) { ?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
			<?php } else { ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php } ?>
			<div id="content" role="main">
				<article>
						<div class="entry-content">
								<?php the_content(); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'themeboy' ), 'after' => '</div>' ) ); ?>
								<?php edit_post_link( __( 'Edit', 'themeboy' ), '<span class="edit-link">', '</span>' ); ?>
						</div><!-- .entry-content -->
				</article>
				<?php comments_template( '', true ); ?>
			</div><!-- #post-## -->
		<?php tb_social_buttons(); ?>
	</div>
<?php endwhile; // end of the loop. ?>