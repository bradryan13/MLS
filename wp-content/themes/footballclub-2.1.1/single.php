<?php 
if ( $post->post_type == 'tb_club' ) {
	wp_redirect( home_url() );
	exit;
}
/**
 * The template for displaying single posts.
 *
 * @package WordPress
 * @subpackage Football_Club
 */
 get_header(); ?>

		<div id="container">
		<?php
		if ($post->post_type == 'tb_player'):
			get_template_part( 'loop', 'player' );
		elseif ($post->post_type == 'tb_staff'):
			get_template_part( 'loop', 'staff' );
		elseif ($post->post_type == 'tb_sponsor'):
			get_template_part( 'loop', 'sponsor' );
		elseif ($post->post_type == 'tb_match'):
			get_template_part( 'loop', 'match' );
		else:
			get_template_part( 'loop', 'single' );
		endif;
		?>
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>