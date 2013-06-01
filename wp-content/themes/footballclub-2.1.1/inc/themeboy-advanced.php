<?php

add_action('admin_menu', 'tb_register_themeboy_advanced_page');

function tb_register_themeboy_advanced_page() {
	add_submenu_page( 'themeboy', __( 'Advanced Settings', 'themeboy' ), __( 'Advanced Settings', 'themeboy' ), 'manage_options', 'themeboy-advanced', 'tb_themeboy_advanced_page' );
}

function tb_themeboy_advanced_page() {
	if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.') ); }
	$hidden_field_name = 'tb_submit_hidden';
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('Advanced Settings', 'themeboy'); ?></h2>
	<?php
		if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
			global $tb_option_fields;
			foreach( $tb_option_fields['advanced'] as $option_field => $value ) {
				$new_value = isset( $_POST[$option_field] ) ? $_POST[$option_field] : null;
				update_option( $option_field, stripslashes( $new_value ) );
			}
	?>
	<div id="message" class="updated"><p><strong><?php _e( 'Settings saved.' ); ?></strong></p></div>
	<?php
		}
	?>
	<form name="themeboy_form" method="post" action="">
		<h3><?php _e( 'Delimiters', 'themeboy' ); ?></h3>
		<table class="form-table">
			<tbody>
				<tr>
					<?php $option_slug = 'tb_title_delimiter'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Site Title', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
				<tr>
					<?php $option_slug = 'tb_match_goals_delimiter'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Match goals', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
			</tbody>
		</table>
		<h3><?php _e( 'Other', 'themeboy' ); ?></h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="tb_custom_css"><?php _e( 'Custom CSS', 'themeboy' ); ?></label></th>
					<td>
						<textarea name="tb_custom_css" rows="10" id="tb_custom_css" class="large-text code"><?php echo get_option('tb_custom_css') ?></textarea><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tb_custom_scripts"><?php _e( 'Custom Scripts', 'themeboy' ); ?></label></th>
					<td>
						<textarea name="tb_custom_scripts" rows="10" id="tb_custom_scripts" class="large-text code"><?php echo get_option('tb_custom_scripts') ?></textarea><br />
						<span class="description"><?php _e('Add your analytics code here.', 'themeboy') ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
		<?php submit_button( null, 'primary', 'save-themeboy-options' ); ?>
	</form>
</div>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function() {
	jQuery('input:radio.tog').change(function() {
		if ( 'custom' == this.value )
			return;
		jQuery('#tb_match_title_structure').val( this.value );
	});
	jQuery('#tb_match_title_structure').focus(function() {
		jQuery("#tb_match_title_structure_custom_selection").attr('checked', 'checked');
	});
});
//]]>
</script>
<?php } ?>