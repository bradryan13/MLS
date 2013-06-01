<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Football_Club
 */

get_header(); ?>

		<div id="container">
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'themeboy' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			<div id="content" role="main">

<?php if ( have_posts() ) : ?>
				<?php
				 get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
				<div id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php _e( 'Nothing Found', 'themeboy' ); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'themeboy' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
<?php endif; ?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
