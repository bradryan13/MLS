<?php
add_shortcode( 'tb_staff', 'tb_staff_shortcode' );
function tb_staff_shortcode( $atts, $content = null, $code = "" ) {
	extract( shortcode_atts( array(
		'id' => null,
		'limit' => -1,
		'season' => null,
		'club' => null,
		'team' => null,
		'title' => __( 'Staff', 'themeboy' ),
		'team' => null,
		'linktext' => __( 'View all staff', 'themeboy' ),
		'linkpage' => null
	), $atts ) );
	if ( $limit == 0 )
		$limit = -1;
	if ( $id <= 0 )
		$id = null;
	if ( $team <= 0 )
		$team = null;
	global $post;	
	$output = '';
	if ( $id ) {
		$post = get_post( $id );
		$posts = array();
		$posts[] = $post;
	} else {
		$args = array(
			'post_type' => 'tb_staff',
			'tax_query' => array(),
			'numposts' => $limit,
			'posts_per_page' => $limit
		);
		if ( $club ) {
			$args['meta_query'] = array(
				array(
					'key' => 'tb_club',
					'value' => $club,
				)
			);
		}
		if ( $season ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'tb_season',
				'terms' => $season,
				'field' => 'term_id'
			);
		}
		if ( $team ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'tb_team',
				'terms' => $team,
				'field' => 'term_id'
			);
		}
		$posts = query_posts($args);
	}
	$count = 0;
	$size = sizeof($posts);
	if ($size > 0):
		$output .=
		'<section class="staff">
			<h3>' . $title . '</h3>';
		while ( have_posts() ) : the_post();
			$count++;
			$output .=
			'<article class="post-row clearfix'.($count >= $size ? ' last' : '').'">';
			if (get_the_post_thumbnail( $post->ID, 'featured-image' ) != null):
				$output.= '<div class="post-thumbnail">'.get_the_post_thumbnail( $post->ID, 'thumbnail', array('title' => get_the_title()) ).'</div>';
			endif;
			$output .= '<div class="staff-post">
				<h2 class="entry-title">'.get_the_title($post->ID).'</h2>
				<div class="entry-summary">'.apply_filters('the_content', get_the_content($post->ID)).'</div></div>
			<div class="clear"></div>
			</article>';
		endwhile;
		if ( isset( $linkpage ) ) $output .= '<a href="' . get_page_link( $linkpage ) . '" class="tb_view_all">' . $linktext . '</a>';
		$output .= '</section>';
	endif;
	
	wp_reset_query();
	return $output;
}
?>