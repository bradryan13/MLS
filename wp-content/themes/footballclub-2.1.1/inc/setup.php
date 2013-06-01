<?php

if ( ! isset( $content_width ) )
	$content_width = 640;

if ( ! function_exists( 'tb_setup' ) ):
function tb_setup() {

	function header_style() {
		?><style type="text/css">
			#header {
				background-image: url(<?php header_image(); ?>);
			}
		</style><?php
	}
	
	function admin_header_style() {
		?><style type="text/css">
			#headimg {
				width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
				height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
			}
		</style><?php
	}
	
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	if(!get_theme_mod('background_repeat'))
		set_theme_mod('background_repeat', 'no-repeat');
	if(!get_theme_mod('background_attachment'))
		set_theme_mod('background_attachment', 'scroll');
	if(!get_theme_mod('background_position_x'))
		set_theme_mod('background_position_x', 'center');
	if(!get_theme_mod('background_position_y'))
		set_theme_mod('background_position_y', 'top');
	$version = get_bloginfo( 'version' );
	if ( version_compare( $version, '3.4' ) >= 0 ) {
		add_theme_support( 'custom-header', array(
			'flex-width' => false,
			'width' => 994,
			'flex-height' => true,
			'height' => 200,
			'default-image' => get_template_directory_uri() . '/images/headers/silver.jpg',
			'header-text' => true,
			'default-text-color' => '333333'
		) );
		add_theme_support( 'custom-background', array(
			'default-color' => 'dadada',
			'default-image' => get_bloginfo('template_directory').'/images/background.jpg'
		) );
	} else {
		define( 'HEADER_TEXTCOLOR', '333333' );
		define( 'NO_HEADER_TEXT', false );
		define( 'HEADER_IMAGE', '%s/images/headers/silver.jpg' );
		define( 'HEADER_IMAGE_WIDTH', 994 );
		define( 'HEADER_IMAGE_HEIGHT', 200 );
		add_custom_image_header( 'header_style', 'admin_header_style' );
		if(!get_theme_mod('background_image'))
			set_theme_mod('background_image', get_bloginfo('template_directory').'/images/background.jpg');
		if(!get_theme_mod('background_color'))
			set_theme_mod('background_color', 'dadada');
		add_custom_background();
	}

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'themeboy' ),
	) );
	
	set_post_thumbnail_size( 584, 584, true );
		
	add_image_size( 'featured-image',  640, 360, true );
	add_image_size( 'rotator-image',  288, 288, true );
	add_image_size( 'crest-header',  150, 940, false );
	add_image_size( 'crest-large',  100, 100, false );
	add_image_size( 'crest-medium',  50, 50, false );
	add_image_size( 'crest-small',  25, 25, false );
	add_image_size( 'side-image',  50, 50, true );
	add_image_size( 'gallery-image',  100, 100, true );
	add_image_size( 'profile-image',  240, 240, true );
	add_image_size( 'onecolumn-image',  994, 360, true );
	add_image_size( 'sponsor-logo',  640, 320, false );
	add_image_size( 'sponsor-header',  160, 120, false );
	add_image_size( 'sponsor-footer',  900, 320, false );
	
	$default_header_colors = array('silver', 'black', 'red', 'maroon', 'orange', 'gold', 'yellow', 'lime', 'green', 'turquoise', 'babyblue', 'blue', 'navy', 'purple', 'pink');
	
	$default_headers = array();
	foreach($default_header_colors as $color) {
		$default_headers[$color] = array(
			'url' => '%s/images/headers/'.$color.'.jpg',
			'thumbnail_url' => '%s/images/headers/'.$color.'-thumbnail.jpg',
			'description' => __( ucwords($color), 'themeboy' )
		);
	}
	
	register_default_headers( $default_headers );
	
}
endif;
add_action('after_setup_theme', 'tb_setup' );

?>