<?php
add_shortcode( 'tb_map', 'tb_map_shortcode' );
function tb_map_shortcode( $atts, $content = null, $code = "" ) {
	extract( shortcode_atts( array(
		'width' => 584,
		'height' => 320,
		'address' => null
	), $atts ) );
	global $post;
	$output = '';
	if($address):
	$output .=
	'<iframe class="google-map" width="' . $width . '" height="' . $height . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?safe=off&amp;aq=f&amp;q=' . str_replace( ' ', '+', strtolower( $address ) ) . '&amp;ie=UTF8&amp;hq=&amp;hnear=' . str_replace( ' ', '+', $address ) . '&amp;t=m&amp;z=14&amp;output=embed&amp;iwloc=near"></iframe>';
//		$output =
		'<div id="map_canvas" class="google-map" style="width: '.$width.'px; height: '.$height.'px"></div>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
		<script type="text/javascript"> 
		  var geocoder;
		  var map;
		  var query = "' . $address . '";
		  function initialize_map() {
			geocoder = new google.maps.Geocoder();
			var myOptions = {
			  zoom: 12,
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			codeAddress();
		  }
		 
		  function codeAddress() {
			var address = query;
			geocoder.geocode( { \'address\': address}, function(results, status) {
			  if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map: map, 
					position: results[0].geometry.location
				});
			  } else {
				jQuery(\'#map_canvas\').hide();
			  }
			});
		  }
		  (function($) {
			initialize_map();
		  })(jQuery);
		</script>';
	endif;
	return $output;
}
?>