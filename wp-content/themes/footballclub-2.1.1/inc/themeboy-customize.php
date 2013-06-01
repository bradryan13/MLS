<?php

add_action('admin_menu', 'tb_register_themeboy_customize_page');

function tb_register_themeboy_customize_page() {
	$tb_themeboy_customize_page = add_submenu_page( 'themeboy', __( 'Customize' ), __( 'Customize' ), 'manage_options', 'themeboy-customize', 'tb_themeboy_customize_page' );
	add_action('admin_print_styles-' . $tb_themeboy_customize_page, 'tb_themeboy_customize_page_admin_styles');
}

function tb_themeboy_customize_page_admin_styles() {
	wp_enqueue_script('custom-background');
	wp_enqueue_style('farbtastic');	
}

function tb_themeboy_customize_page() {
	if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.') ); }
	$hidden_field_name = 'tb_submit_hidden';
	$version = get_bloginfo( 'version' );
	if ( version_compare( $version, '3.4' ) >= 0 ) {
	?>
	<script type="text/javascript">
		window.location.href = "<?php echo wp_customize_url(); ?>?url=<?php echo urlencode( admin_url( 'admin.php?page=themeboy' ) ); ?>";
	</script>
	<?php } else { ?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br></div>
		<h2><?php _e('Social Network Settings', 'themeboy'); ?></h2>
		<?php
			if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
				global $tb_option_fields;
				foreach( $tb_option_fields['customize'] as $option_field => $value ) {
					$new_value = isset( $_POST[$option_field] ) ? $_POST[$option_field] : null;
					update_option( $option_field, stripslashes( $new_value ) );
				}
		?>
		<div id="message" class="updated"><p><strong><?php _e( 'Settings saved.' ); ?></strong></p></div>
		<?php
			}
		?>
		<form name="themeboy_form" method="post" action="">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<?php $option_slug = 'tb_primary_color'; ?>
						<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Primary Color', 'themeboy' ); ?></label></th>
						<td>
							<input type="text" name="<?php echo $option_slug; ?>" id="background-color" value="<?php echo get_option( $option_slug ); ?>" />
							<a class="hide-if-no-js" href="#" id="pickcolor"><?php _e('Select a Color'); ?></a>
							<div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
						<td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Header Logo Image', 'themeboy' ); ?></th>
						<td>
							<?php $option_slug = 'tb_header_logo_image'; ?>
							<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="regular-text" placeholder="URL" />
						</td>
					</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Footer Logo Image', 'themeboy' ); ?></th>
					<td>
						<?php $option_slug = 'tb_footer_logo_image'; ?>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="regular-text" placeholder="URL" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Shortcut Icon Image', 'themeboy' ); ?></th>
					<td>
						<?php $option_slug = 'tb_favicon_image'; ?>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="regular-text" placeholder="URL" />
					</td>
				</tr>
				</tbody>
			</table>
			<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
			<?php submit_button( null, 'primary', 'save-themeboy-options' ); ?>
		</form>
	</div>
<?php } } ?>