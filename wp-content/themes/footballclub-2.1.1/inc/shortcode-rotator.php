<?php
add_shortcode( 'tb_rotator', 'tb_rotator_shortcode' );
function tb_rotator_shortcode( $atts, $content = null, $code = "" ) {
	extract( shortcode_atts( array(
		'cat' => get_option( 'tb_rotator_cat' ),
		'type' => 'mini',
		'show_readmore' => get_option( 'tb_rotator_show_readmore' ),
		'show_date' => get_option( 'tb_rotator_show_date' ),
		'delay' => 1000 * get_option( 'tb_rotator_delay_in_seconds' )
	), $atts ) );
	global $post;
	if ($type == 'featured') {
		$image_size =  'featured';
		$limit = 5;
	} else {
		$image_size =  'rotator';
		$limit = 4;
	}
	global $tb_default_images;
	$query = ($cat != null ? 'cat='.$cat : '');
	query_posts('posts_per_page='.$limit.'&cat='.$cat);
	$i = 0;
	if ( have_posts() ) :
		$output = '<div class="'.$type.'-rotator image-rotator">
			<div class="main_image"><ul>';
		while ( have_posts() ) :
			the_post();
				$output .= '<li data-slide="'.$i.'">';
				$output .= '<a href="'.get_permalink($post->ID).'">';
				if (has_post_thumbnail() )
					$output .= get_the_post_thumbnail( $post->ID, $image_size.'-image', array('title' => get_the_title()) );
				else
					$output .= '<img src="'.$tb_default_images[$image_size].'" />';
				$output .= '</a>';
				$output .=
				'<div class="desc">
					<div class="block">
						<h3 class="ellipsis"><a href="'.get_permalink($post->ID).'">'.get_the_title().'</a></h3>';
						if ( $show_date )
							$output .= '<time><a href="'.get_permalink($post->ID).'">'.get_the_date().'</a></time>';
					$output .=
					'</div>
				</div>
				</li>';
			$i++;
		endwhile;
		$output .='</ul></div><div class="image_thumb"><ul>';
		rewind_posts();
		$i = 0;
		while ( have_posts() ) :
				the_post();
					if (has_post_thumbnail() ):
						$attachment_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size.'-image' );
						$image = $attachment_src[0];
					else:
						$image = $tb_default_images[$image_size];
					endif;
					$output .=
					'<li data-permalink="'.get_permalink($post->ID).'" data-slide="'.$i.'">
						<a>'.get_the_post_thumbnail( $post->ID, 'side-image', array('title' => get_the_title()) ).'</a> 
						<div class="block">
							<h3 class="ellipsis">'.get_the_title().'</h3>';
							if ( $show_date )
								$output .= '<time>'.get_the_date().'</time>';
						$output .=
						'</div>';
						if ( $show_readmore )
							$output .= '<div class="more"><a href="'.get_permalink($post->ID).'">' . __( 'Read More', 'themeboy' ) . '</a></div>
					</li>';
					$i++;
				endwhile; 
				wp_reset_query();
				$output .=
				'</ul> 
			</div>
		</div>
		<script type="text/javascript">
			(function($) {
				$(\'.image-rotator\').rotator({
					\'delay\' : '.$delay.'
				});
			})(jQuery);
		</script>';
	else :
		$output = '';
	endif;
	return $output;
}
?>