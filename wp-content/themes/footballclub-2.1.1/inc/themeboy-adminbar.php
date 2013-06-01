<?php

add_action( 'wp_before_admin_bar_render', 'themeboy_admin_bar_render' );

function themeboy_admin_bar_render() {
	if ( ! is_admin() ) {
		global $wp_admin_bar;
		$wp_admin_bar->add_menu(
			array(
				'parent' => false,
				'id' => 'themeboy',
				'title' => '<span class="ab-icon"></span> <span class="ab-label">' . __( 'ThemeBoy', 'themeboy' ) . '</span>',
				'href' => admin_url( 'admin.php?page=themeboy'),
				'meta' => false
			)
		);
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'themeboy',
				'id' => 'themeboy-general',
				'title' => __('Theme Options'),
				'href' => admin_url( 'admin.php?page=themeboy'),
				'meta' => false
			)
		);
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'themeboy',
				'id' => 'themeboy-social',
				'title' => __('Social Network'),
				'href' => admin_url( 'admin.php?page=themeboy-social'),
				'meta' => false
			)
		);
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'themeboy',
				'id' => 'themeboy-rotator',
				'title' => __('Image Rotator'),
				'href' => admin_url( 'admin.php?page=themeboy-rotator'),
				'meta' => false
			)
		);
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'themeboy',
				'id' => 'themeboy-team',
				'title' => __('Players & Staff'),
				'href' => admin_url( 'admin.php?page=themeboy-team'),
				'meta' => false
			)
		);
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'themeboy',
				'id' => 'themeboy-contact',
				'title' => __('Contact Form'),
				'href' => admin_url( 'admin.php?page=themeboy-contact'),
				'meta' => false
			)
		);
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'themeboy',
				'id' => 'themeboy-social',
				'title' => __('Social Network'),
				'href' => admin_url( 'admin.php?page=themeboy-social'),
				'meta' => false
			)
		);
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'themeboy',
				'id' => 'themeboy-customize',
				'title' => __('Customize'),
				'href' => admin_url( 'admin.php?page=themeboy-customize'),
				'meta' => false
			)
		);
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'themeboy',
				'id' => 'themeboy-advanced',
				'title' => __('Advanced Settings'),
				'href' => admin_url( 'admin.php?page=themeboy-advanced'),
				'meta' => false
			)
		);
	}
}

?>