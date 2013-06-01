<?php
/**
 * The loop that displays a page.
 *
 * @package WordPress
 * @subpackage Football_Club
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_front_page() ) { ?>
				<h2 class="entry-title"><?php the_title(); ?></h2>
		<?php } else { ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php } ?>
		<div id="content" role="main">
			<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'themeboy' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
		<?php tb_social_buttons(); ?>
		</div><!-- #post-## -->
	</div>
<?php endwhile; // end of the loop. ?>