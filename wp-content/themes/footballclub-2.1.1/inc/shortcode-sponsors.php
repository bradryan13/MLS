<?php
add_shortcode( 'tb_sponsors', 'tb_sponsors_shortcode' );
function tb_sponsors_shortcode( $atts, $content = null, $code = "" ) {	
	extract( shortcode_atts( array(
		'limit' => -1
	), $atts ) );
	if ( $limit == 0 )
		$limit = -1;
	global $post;
	$output =
	'<ul class="sponsors">';
	$args = array(
		'post_type' => 'tb_sponsor',
		'numposts' => $limit,
		'posts_per_page' => $limit,
		'order' => 'ASC'
	);
	query_posts( $args );
	while( have_posts() ) : the_post();	
		$custom = get_post_custom( $post->ID );		
		$link_url = ( $custom['tb_link_directly'][0] ? $custom['tb_link_url'][0] : get_permalink($post->ID));
		if ($custom['tb_link_directly'][0]):
			$output .= '<li><a href="'.$custom['tb_link_url'][0].'" target="_blank">'.( has_post_thumbnail() ? get_the_post_thumbnail($post->ID, 'sponsor-footer', array( 'alt' => get_the_title( $post->ID ), 'title' => get_the_title( $post->ID ) ) ) : get_the_title($post->ID) ).'</a></li>';
		else:
			$output .= '<li><a href="'.get_permalink($post->ID).'">'.( has_post_thumbnail() ? get_the_post_thumbnail($post->ID, 'sponsor-footer', array( 'alt' => get_the_title( $post->ID ), 'title' => get_the_title( $post->ID ) ) ) : get_the_title($post->ID) ).'</a></li>';
		endif;
	endwhile;
	wp_reset_query();
	$output .= '</ul>';
	return $output;
}
?>