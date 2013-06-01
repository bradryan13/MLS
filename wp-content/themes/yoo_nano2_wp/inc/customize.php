<?php
// WORDPRESS 3.4 THEME OPTIONS
add_action( 'customize_register', 'tb_customize_register' );
function tb_customize_register( $wp_customize ) {
	global $tb_customize_colors, $tb_customize_header_images;

  foreach( $tb_customize_colors as $color ) {
    // SETTINGS
    $wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'type' => 'option', 'capability' => 'edit_theme_options' ));

    // CONTROLS
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'colors', 'settings' => $color['slug'] )));
  }
	
  foreach( $tb_customize_header_images as $image ) {
    // SETTINGS
    $wp_customize->add_setting( $image['slug'], array( 'default' => $image['default'], 'type' => 'option', 'capability' => 'edit_theme_options' ));

    // CONTROLS
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $image['slug'], array( 'label' => $image['label'], 'section' => 'header_image', 'settings' => $image['slug'] )));
  }
}
?>