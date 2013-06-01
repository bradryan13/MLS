<?php get_header(); ?>

		<div id="container">
			<h1 class="page-title"><?php single_cat_title(); ?></h1>
			<div id="content" role="main">

				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '<div class="archive-meta">' . $category_description . '</div>';

				get_template_part( 'loop', 'category' );
				?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
