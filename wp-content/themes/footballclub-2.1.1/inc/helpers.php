<?php
// checks is WP is at least a certain version (makes sure it has sufficient comparison decimals
function is_wp_version( $is_ver ) {
	$wp_ver = explode( '.', get_bloginfo( 'version' ) );
	$is_ver = explode( '.', $is_ver );
	if( !isset( $wp_ver[0] ) ) array_push( $wp_ver, 0 );
	foreach( $is_ver as $i => $is_val )
		if( $wp_ver[$i] < $is_val ) return false;
	return true;
}

/* HELPERS */
if (!function_exists('subval_sort')) {
	function subval_sort($a,$subkey) {
		foreach($a as $k=>$v) {
			$b[$k] = strtolower($v[$subkey]);
		}
		if ($b != null) {
			asort($b);
			foreach($b as $key=>$val) {
				$c[] = $a[$key];
			}
			return $c;
		}
		return array();
	}
}

// get term slug from id
if (!function_exists('tb_get_term_slug')) {
	function tb_get_term_slug( $term, $taxonomy ) {
		$slug = null;
		if ( is_numeric( $term ) && $term > 0 ) {
			$term_object = get_term( $term, $taxonomy );
			if ( $term_object )
				$slug = $term_object->slug;
		}
		return $slug;
	}
}

if (!function_exists('tb_dropdown_posts')) {
	function tb_dropdown_posts( $args = array() ) {
		$defaults = array(
			'show_option_none' => false,
			'numberposts' => -1,
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'name' => null,
			'id' => null,
			'selected' => null
		);
		$args = array_merge( $defaults, $args );
		if ( ! $args['id'] )
			$args['id'] = $args['name'];
		echo '<select name="' . $args['name'] . '" id="' . $args['id'] . '" class="postform">';
		unset( $args['name'] );
		if ( $args['show_option_none'])
			echo '<option value="-1"' . ( '-1' == $args['selected'] ? ' selected' : '' ) . '>' . $args['show_option_none'] . '</option>';
		$posts = get_posts( $args );
		foreach ( $posts as $post ) {
			$name = get_the_title( $post->ID );
			if ( isset( $args['post_type'] ) && $args['post_type'] == 'tb_match' ) {
				$timestamp = strtotime( $post->post_date );
				$date_format = get_option( 'date_format' );
				$name = date_i18n( $date_format, $timestamp ) . ' - ' . $name; 
			}
			echo '<option class="level-0" value="' . $post->ID . '"' . ( $post->ID == $args['selected'] ? ' selected' : '' ) . '>' . $name . '</option>';
		}
		echo '</select>';
	}
}

if (!function_exists('tb_dropdown_taxonomies')) {
	function tb_dropdown_taxonomies( $args = array() ) {
		$defaults = array(
			'show_option_all' => false,
			'show_option_none' => false,
			'taxonomy' => null,
			'name' => null,
			'selected' => null
		);
		$args = array_merge( $defaults, $args ); 
		$terms = get_terms( $args['taxonomy'] );
		$name = ( $args['name'] ) ? $args['name'] : $args['taxonomy'];
		if ( $terms ) {
			printf( '<select name="%s" class="postform">', $name );
			if ( $args['show_option_all'] ) {
				printf( '<option value="0">%s</option>', $args['show_option_all'] );
			}
			if ( $args['show_option_none'] ) {
				printf( '<option value="-1">%s</option>', $args['show_option_none'] );
			}
			foreach ( $terms as $term ) {
				printf( '<option value="%s" %s>%s</option>', $term->slug, selected( true, $args['selected'] == $term->slug ), $term->name );
			}
			print( '</select>' );
		}
	}
}

if (!function_exists('form_dropdown')) {
	function form_dropdown($name, $arr = array(), $selected = null, $atts = null) {
		$output = '<select name="'.$name.'" class="'.$name.'" id="'.$name.'"';
		if ($atts):
			foreach ($atts as $key => $value):
				$output .= ' '.$key.'="'.$value.'"';
			endforeach;
		endif;
		$output .= '>';
		foreach($arr as $key => $value) {
			$output .= '<option'.($selected == $key ? ' selected' : '').' value="'.$key.'">'.$value.'</option>';
		}
		$output .= '</select>';
		return $output;
	}
}
if (!function_exists('get_age')) {
	function get_age( $p_strDate ) {
    list($Y,$m,$d)    = explode("-",$p_strDate);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}
}

if (!function_exists('darker_color')) {
	function darker_color($color, $dif = 40){
		$color = str_replace('#', '', $color);
		if (strlen($color) != 6){ return '#000'; }
		$rgb = '';	 
		for ($x=0;$x<3;$x++){
			$c = hexdec(substr($color,(2*$x),2)) - $dif;
			$c = ($c < 0) ? 0 : dechex($c);
			$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
		}	 
		return '#'.$rgb;
	}
}

if (!function_exists('lighter_color')) {
	function lighter_color($color, $dif = 20){	 
		$color = str_replace('#', '', $color);
		if (strlen($color) != 6){ return '#fff'; }
		$rgb = '';	 
		for ($x=0;$x<3;$x++){
			$c = hexdec(substr($color,(2*$x),2)) + $dif;
			$c = ($c > 255) ? 'ff' : dechex($c);
			$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
		}
		return '#'.$rgb;
	}
}

if (!function_exists('get_tb_stats_value')) {
	function get_tb_stats_value( $stats = array(), $type = 'manual', $index = 'goals' ) {
		if ( is_array( $stats ) ) {
			if ( array_key_exists( $type, $stats ) ) {
				if ( array_key_exists( $index, $stats[$type] ) ) {
					return (float)$stats[$type][$index];
				}
			}
		}
		return 0;
	}
}

if (!function_exists('tb_stats_value')) {
	function tb_stats_value( $stats, $type, $index ) {
		echo get_tb_stats_value( $stats, $type, $index );
	}
}

if (!function_exists('get_tb_match_player_stats')) {
	function get_tb_match_player_stats( $post_id = null ) {
		if ( !$post_id ) global $post_id;
		$players = unserialize( get_post_meta( $post_id, 'tb_players', true ) );
		$output = array();
		if( is_array( $players ) ):
			foreach( $players as $id => $stats ):
				if ( $stats['checked'] )
					$output[$key] = $stats;
			endforeach;
		endif;
		return $players;
	}
}


if (!function_exists('tb_array_values_to_int')) {
	function tb_array_values_to_int( &$value, $key ) {
		$value = (int)$value;
	}
}

if (!function_exists('tb_array_filter_checked')) {
	function tb_array_filter_checked( $value) {
		return ( array_key_exists( 'checked', $value ) );
	}
}
	
if (!function_exists('is_valid_email')) {
	function is_valid_email($email)
	{
	   $isValid = true;
	   $atIndex = strrpos($email, "@");
	   if (is_bool($atIndex) && !$atIndex)
	   {
		  $isValid = false;
	   }
	   else
	   {
		  $domain = substr($email, $atIndex+1);
		  $local = substr($email, 0, $atIndex);
		  $localLen = strlen($local);
		  $domainLen = strlen($domain);
		  if ($localLen < 1 || $localLen > 64)
		  {
			 // local part length exceeded
			 $isValid = false;
		  }
		  else if ($domainLen < 1 || $domainLen > 255)
		  {
			 // domain part length exceeded
			 $isValid = false;
		  }
		  else if ($local[0] == '.' || $local[$localLen-1] == '.')
		  {
			 // local part starts or ends with '.'
			 $isValid = false;
		  }
		  else if (preg_match('/\\.\\./', $local))
		  {
			 // local part has two consecutive dots
			 $isValid = false;
		  }
		  else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
		  {
			 // character not valid in domain part
			 $isValid = false;
		  }
		  else if (preg_match('/\\.\\./', $domain))
		  {
			 // domain part has two consecutive dots
			 $isValid = false;
		  }
		  else if
	(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
					 str_replace("\\\\","",$local)))
		  {
			 // character not valid in local part unless 
			 // local part is quoted
			 if (!preg_match('/^"(\\\\"|[^"])+"$/',
				 str_replace("\\\\","",$local)))
			 {
				$isValid = false;
			 }
		  }
		  if ($isValid && !(checkdnsrr($domain,"MX") || 
			checkdnsrr($domain,"A")))
		  {
			 // domain not found in DNS
			 $isValid = false;
		  }
	   }
	   return $isValid;
	}
}

if ( ! function_exists( 'tb_social_buttons' ) ) {
	function tb_social_buttons() {
		if ( get_option( 'tb_social_show_facebook_like_button' ) ) { ?>
			<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="true" data-layout="button_count" data-show-faces="false"></div>
		<?php }
		if ( get_option( 'tb_social_show_twitter_tweet_button' ) ) { ?>
			<a href="https://twitter.com/share" class="twitter-share-button" data-via="<?php echo get_option( 'tb_social_twitter_via' ); ?>" data-lang="<?php echo str_replace( '_', '-', strtolower( get_locale() ) ); ?>" data-related="themeboy" data-hashtags="<?php echo get_option( 'tb_social_twitter_hashtags' ); ?>"><?php _e( 'Tweet', 'themeboy' ); ?></a>
	<?php }
	}
}
?>