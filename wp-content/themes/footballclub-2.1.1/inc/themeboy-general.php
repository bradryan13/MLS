<?php

add_action('admin_menu', 'themeboy_menu');

function themeboy_menu() {
	$themeboy_options_page = add_object_page(__('Theme Options', 'themeboy'), __('Theme Options', 'themeboy'), 'manage_options', 'themeboy', 'themeboy_page' );
}

function themeboy_page() {
	if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.') ); }
	$hidden_field_name = 'tb_submit_hidden';
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('General Settings', 'themeboy'); ?></h2>
	<?php
		if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
			global $tb_option_fields;
			foreach( $tb_option_fields['settings'] as $option_field => $value ) {
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
					<th scope="row"><?php _e( 'Home Team', 'themeboy' ); ?></th>
					<td>
						<?php $option_slug = 'tb_default_club'; ?>
						<?php
						tb_dropdown_posts( array(
							'post_type' => 'tb_club',
							'limit' => -1,
							'show_option_none' => __( 'None' ),
							'selected' => get_option( $option_slug ),
							'name' => $option_slug,
							'id' => $option_slug
						) );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tb_region_code"><?php _e( 'Country', 'themeboy' ); ?></label></th>
					<td>
						<?php
							global $tb_countries_of_the_world;
							asort( $tb_countries_of_the_world );
							echo form_dropdown( 'tb_region_code', $tb_countries_of_the_world, get_option( 'tb_region_code' ) );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Header' ); ?></th>
					<td>
						<?php $option_slug = 'tb_header_sponsor'; ?>
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Sponsor', 'themeboy' ); ?> 1:</label>						
						<?php
						tb_dropdown_posts( array(
							'post_type' => 'tb_sponsor',
							'limit' => -1,
							'show_option_none' => __( 'None' ),
							'selected' => get_option( $option_slug ),
							'name' => $option_slug,
							'id' => $option_slug
						) );
						?><br />
						<?php $option_slug = 'tb_header_sponsor_2'; ?>
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Sponsor', 'themeboy' ); ?> 2:</label>						
						<?php
						tb_dropdown_posts( array(
							'post_type' => 'tb_sponsor',
							'limit' => -1,
							'show_option_none' => __( 'None' ),
							'selected' => get_option( $option_slug ),
							'name' => $option_slug,
							'id' => $option_slug
						) );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Footer' ); ?></th>
					<td>
						<?php $option_slug = 'tb_footer_show_sponsors'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Sponsors', 'themeboy' ); ?></label>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
		<?php submit_button( null, 'primary', 'save-themeboy-options' ); ?>
	</form>
</div>
<?php } ?>