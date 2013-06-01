<?php

function tb_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_register_script( 'html5shiv', get_bloginfo('template_directory').'/js/html5shiv.js');
	wp_enqueue_script( 'html5shiv' );
	wp_register_script( 'twitter-widgets', 'http://platform.twitter.com/widgets.js');
	wp_enqueue_script( 'twitter-widgets' );
	wp_register_script( 'themeboy-twitter', get_bloginfo('template_directory').'/js/jquery.themeboy-twitter.js');
	wp_enqueue_script( 'themeboy-twitter' );
	wp_register_script( 'themeboy-rotator', get_bloginfo('template_directory').'/js/jquery.themeboy-rotator.js');
	wp_enqueue_script( 'themeboy-rotator' );
	wp_register_script( 'jquery-evenheights', get_bloginfo('template_directory').'/js/jquery.evenHeights.1.0.0-min.js');
	wp_enqueue_script( 'jquery-evenheights' );
	wp_register_script( 'jquery-easing', get_bloginfo('template_directory').'/js/fancybox/jquery.easing-1.3.pack.js');
	wp_enqueue_script( 'jquery-easing' );
	wp_register_script( 'jquery-mousewheel', get_bloginfo('template_directory').'/js/fancybox/jquery.mousewheel-3.0.4.pack.js');
	wp_enqueue_script( 'jquery-mousewheel' );
	wp_register_script( 'jquery-fancybox', get_bloginfo('template_directory').'/js/fancybox/jquery.fancybox-1.3.4.pack.js');
	wp_enqueue_script( 'jquery-fancybox' );
}
function tb_admin_enqueue_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
}

add_action('wp_enqueue_scripts', 'tb_enqueue_scripts');
add_action('admin_enqueue_scripts', 'tb_admin_enqueue_scripts');

?>