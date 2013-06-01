<?php

function tb_enqueue_styles() {
	wp_register_style( 'stylesheet', get_bloginfo('stylesheet_url' ) );
	wp_enqueue_style( 'stylesheet' );
	wp_register_style( 'jquery-fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox-1.3.4.css' );
	wp_enqueue_style( 'jquery-fancybox' );
}

function tb_admin_enqueue_styles() {
	wp_enqueue_style( 'thickbox' );
	wp_register_style( 'admin-stylesheet',  get_template_directory_uri() . '/css/admin.css' );
	wp_enqueue_style( 'admin-stylesheet' );
}

function tb_adminbar_enqueue_styles() {
	wp_register_style( 'adminbar-stylesheet',  get_template_directory_uri() . '/css/adminbar.css' );
	wp_enqueue_style( 'adminbar-stylesheet' );
}

add_action( 'wp_print_styles', 'tb_enqueue_styles' );
add_action( 'admin_init', 'tb_admin_enqueue_styles' );
add_action( 'wp_head', 'tb_adminbar_enqueue_styles' );

?>