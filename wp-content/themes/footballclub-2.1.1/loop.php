<?php
/**
 * The loop for displaying posts.
 *
 * @package WordPress
 * @subpackage Football_Club
 */
?>
 <?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&#x25C2;</span> ' . __( 'Older posts', 'themeboy' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'themeboy' ) . ' <span class="meta-nav">&#x25B8;</span>' ); ?></div>
		<div class="clear"></div>
	</div><!-- #nav-above -->
<?php endif; ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h2 class="entry-title"><?php _e( 'Not Found', 'themeboy' ); ?></h2>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'themeboy' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>
	<article class="post-row clearfix">
    	<?php if (get_the_post_thumbnail( $post->ID, 'featured-image' ) != null): ?>
			<div class="post-thumbnail"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail', array('title' => get_the_title()) ); ?></a></div>
		<?php endif; ?>
		<?php if ( ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) || in_category( _x( 'gallery', 'gallery category slug', 'themeboy' ) ) ) : ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themeboy' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	
				<div class="entry-content">
	<?php if ( post_password_required() ) : ?>
					<?php the_content(); ?>
	<?php else : ?>
					<?php
						$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
						if ( $images ) :
							$total_images = count( $images );
							$image = array_shift( $images );
							$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
					?>
							<div class="gallery-thumb">
								<a class="size-thumbnail" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
							</div><!-- .gallery-thumb -->
							<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'themeboy' ),
									'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'themeboy' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
									number_format_i18n( $total_images )
								); ?></em></p>
					<?php endif; ?>
							<?php the_excerpt(); ?>
	<?php endif; ?>
				</div><!-- .entry-content -->
	
				<div class="entry-utility">
				<?php if ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) : ?>
					<a href="<?php echo get_post_format_link( 'gallery' ); ?>" title="<?php esc_attr_e( 'View Galleries', 'themeboy' ); ?>"><?php _e( 'More Galleries', 'themeboy' ); ?></a>
					<span class="meta-sep">|</span>
				<?php elseif ( in_category( _x( 'gallery', 'gallery category slug', 'themeboy' ) ) ) : ?>
					<a href="<?php echo get_term_link( _x( 'gallery', 'gallery category slug', 'themeboy' ), 'category' ); ?>" title="<?php esc_attr_e( 'View posts in the Gallery category', 'themeboy' ); ?>"><?php _e( 'More Galleries', 'themeboy' ); ?></a>
					<span class="meta-sep">|</span>
				<?php endif; ?>
					<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'themeboy' ), __( '1 Comment', 'themeboy' ), __( '% Comments', 'themeboy' ) ); ?></span>
				</div><!-- .entry-utility -->
			</div><!-- #post-## -->
	
	<?php /* Display all other posts. */ ?>
	
		<?php else : ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themeboy' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<div class="post-date"><?php echo get_the_date(); ?></div>
		<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
					<?php echo '<a class="readmore" href="'. get_permalink() . '">' . '<span class="meta-nav">&#x25B8;</span> ' . __( 'Continue reading', 'themeboy' ) . '</a>'; ?>
				</div><!-- .entry-summary -->
		<?php else : ?>
				<div class="entry-content">
					<?php the_content( __( 'Continue reading', 'themeboy' ) . ' <span class="meta-nav">&#x25B8;</span>' ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'themeboy' ), 'after' => '</div>' ) ); ?>
				</div><!-- .entry-content -->
		<?php endif; ?>
		
		<?php if (get_option('tb_post_utility_display')): ?>
				<div class="entry-utility">
					<?php if ( count( get_the_category() ) ) : ?>
						<span class="cat-links">
							<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'themeboy' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
						</span>
						<span class="meta-sep">|</span>
					<?php endif; ?>
					<?php
						$tags_list = get_the_tag_list( '', ', ' );
						if ( $tags_list ):
					?>
						<span class="tag-links">
							<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'themeboy' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
						</span>
						<span class="meta-sep">|</span>
					<?php endif; ?>
					<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'themeboy' ), __( '1 Comment', 'themeboy' ), __( '% Comments', 'themeboy' ) ); ?></span>
					<?php edit_post_link( __( 'Edit', 'themeboy' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-utility -->
			</div><!-- #post-## -->
		<?php endif; ?>
		<?php tb_social_buttons(); ?>
		<?php comments_template( '', true ); ?>
		<?php endif; // This was the if statement that broke the loop into three parts based on categories. ?>
	</article>
<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-below" class="navigation">
		<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&#x25C2;</span>' ); ?></div>
		<div class="nav-next"><?php previous_posts_link( '<span class="meta-nav">&#x25B8;</span>' ); ?></div>
	</div><!-- #nav-below -->
<?php endif; ?>
