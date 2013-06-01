<?php
	$played = get_post_meta( $post->ID, 'tb_played', true );
	$match_type = (	$played ? __( 'Results', 'themeboy' ) : __( 'Fixture', 'themeboy' ) );
?>
<h1 class="entry-title">
	<?php echo $match_type; ?>
</h1>
<div id="content" role="main">
	<h2 class="entry-title"><?php the_title( ); ?></h2>
	<?php echo do_shortcode( '[tb_match id=' . $post->ID .']' ); ?>
	<?php tb_social_buttons(); ?>
</div><!-- #content-## -->