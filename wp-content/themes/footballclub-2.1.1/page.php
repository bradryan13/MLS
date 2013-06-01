<?php get_header(); ?>

		<div id="container">
			<div class="featured-image">
				<?php the_post_thumbnail('featured-image', array('title' => get_the_title())); ?>
			</div>
			<?php
			get_template_part( 'loop', 'page' );
			?>
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
