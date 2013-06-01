<?php

add_action('admin_menu', 'tb_register_themeboy_reset_page');

function tb_register_themeboy_reset_page() {
	add_submenu_page( 'themeboy', __( 'Reset' ), __( 'Reset' ), 'manage_options', 'themeboy-reset', 'tb_themeboy_reset_page' );
}

/*
*/
function tb_themeboy_reset_page() {
	if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.') ); }
	$hidden_field_name = 'tb_submit_hidden';
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('Reset Theme Settings', 'themeboy'); ?></h2>
	<?php
		if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
			if ( isset( $_POST['tb_reset'] ) ) {
				global $tb_option_fields;
				foreach ( $_POST['tb_reset'] as $reset_group ) {
					if ( array_key_exists( $reset_group, $tb_option_fields ) ) {
						foreach( $tb_option_fields[$reset_group] as $key => $value ) {
							update_option( $key, $value );
						}
					} elseif ( $reset_group == 'colors' ) {
						global $tb_customize_colors;
						foreach( $tb_customize_colors as $color ) {
							update_option( $color['slug'], $color['default'] );
						}
					}
				}
	?>
	<div id="message" class="updated"><p><strong><?php _e( 'Settings have been reset.' ); ?></strong></p></div>
	<?php
			}
		}
	?>
	<form name="themeboy_form" method="post" action="">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e( 'Reset to factory settings', 'themeboy' ); ?></th>
					<td>
						<?php $option_slug = 'settings'; ?>
						<input name="tb_reset[]" type="checkbox" id="<?php echo $option_slug; ?>" value="<?php echo $option_slug; ?>" />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'General Settings', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'social'; ?>
						<input name="tb_reset[]" type="checkbox" id="<?php echo $option_slug; ?>" value="<?php echo $option_slug; ?>" />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Social Network', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'rotator'; ?>
						<input name="tb_reset[]" type="checkbox" id="<?php echo $option_slug; ?>" value="<?php echo $option_slug; ?>" />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Image Rotator', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'team'; ?>
						<input name="tb_reset[]" type="checkbox" id="<?php echo $option_slug; ?>" value="<?php echo $option_slug; ?>" />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Players & Staff', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'standings'; ?>
						<input name="tb_reset[]" type="checkbox" id="<?php echo $option_slug; ?>" value="<?php echo $option_slug; ?>" />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Standings', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'matches'; ?>
						<input name="tb_reset[]" type="checkbox" id="<?php echo $option_slug; ?>" value="<?php echo $option_slug; ?>" />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Matches', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'contact'; ?>
						<input name="tb_reset[]" type="checkbox" id="<?php echo $option_slug; ?>" value="<?php echo $option_slug; ?>" />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Contact Form', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'colors'; ?>
						<input name="tb_reset[]" type="checkbox" id="<?php echo $option_slug; ?>" value="<?php echo $option_slug; ?>" />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Colors', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'advanced'; ?>
						<input name="tb_reset[]" type="checkbox" id="<?php echo $option_slug; ?>" value="<?php echo $option_slug; ?>" />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Advanced Settings', 'themeboy' ); ?></label><br />

						<p class="description"><?php _e( 'Warning: this cannot be undone.', 'themeboy' ); ?></p><strong></strong>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
		<?php submit_button( __( 'Submit' ), 'primary', 'reset-themeboy-options', true, array( 'disabled' => true ) ); ?>
	</form>
</div>
<script type="text/javascript">
(function($) {
	$('input[name="tb_reset[]"]').change(function() {
		disabled = true;
		if($('input[name="tb_reset[]"]:checked').length > 0)
			disabled = false;
		$('input#reset-themeboy-options').prop('disabled', disabled);
	});
})(jQuery);
</script>
<?php } ?>