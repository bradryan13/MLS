<h1 class="entry-title"><?php _e( 'Official Sponsors', 'themeboy' ); ?></h1>
	<div id="content" role="main">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php
		$custom = get_post_custom($post->ID);
	?>

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section class="sponsor-details">
            <div class="sponsor-logo">
                <?php the_post_thumbnail('sponsor-logo', array('title' => get_the_title())); ?>
            </div>
	        <div class="entry-content">
    	        <?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'themeboy' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
            <?php if ($custom['tb_link_url'][0] != 'http://' ): ?>
				<div class="link-button"><a href="<?php echo $custom['tb_link_url'][0]; ?>" target="_blank">&#x25B8; <?php _e('Visit Website'); ?></a></div>
			<?php endif; ?>
        </section>
    </div><!-- #post-## -->

<?php endwhile; // end of the loop. ?>
</div><!-- #content -->