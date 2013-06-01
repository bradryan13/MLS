<?php
/**
 * Template Name: Full Width
 */

get_header(); ?>

		<div id="container" class="one-column">
			<div class="featured-image">
				<?php the_post_thumbnail('onecolumn-image', array('title' => get_the_title())); ?>
			</div>
      <?php get_template_part( 'loop', 'page' ); ?>
		</div><!-- #container -->

<?php get_footer(); ?>
