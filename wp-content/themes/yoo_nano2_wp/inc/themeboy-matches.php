<?php

add_action('admin_menu', 'tb_register_themeboy_matches_page');

function tb_register_themeboy_matches_page() {
	add_submenu_page( 'themeboy', __( 'Matches', 'themeboy' ), __( 'Matches', 'themeboy' ), 'manage_options', 'themeboy-matches', 'tb_themeboy_matches_page' );
}

function tb_themeboy_matches_page() {
	if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.') ); }
	$hidden_field_name = 'tb_submit_hidden';
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div>
<h2><?php _e('Match Settings', 'themeboy'); ?></h2>
<?php
if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
	global $tb_option_fields;
	foreach( $tb_option_fields['matches'] as $option_field => $value ) {
		$new_value = isset( $_POST[$option_field] ) ? $_POST[$option_field] : null;
		update_option( $option_field, stripslashes( $new_value ) );
	}
?>
<div id="message" class="updated"><p><strong><?php _e( 'Settings saved.' ); ?></strong></p></div>
<?php
}
?>
<form name="themeboy_form" method="post" action="">
<?php
$home_title_format = get_option('tb_match_home_title_format');
$away_title_format = get_option('tb_match_away_title_format');
$formats = array(
	0 => $prefix . '%home% vs %away%',
	1 => $prefix . '%away% vs %home%'
);
?>
<h3><?php _e( 'Title Format', 'themeboy' ); ?></h3>
<table class="form-table">
	<tr>
		<th><label><input name="selection" type="radio" value="<?php echo esc_attr($formats[0]); ?>" class="tog" <?php checked( $formats[0] == $home_title_format && $away_title_format == $home_title_format ); ?> /> <?php _e( 'Default', 'themeboy' ); ?></label></th>
		<td><code><?php echo __( 'Home', 'themeboy' ) . ' vs ' . __( 'Away', 'themeboy' ); ?></code></td>
	</tr>
	<tr>
		<th><label><input name="selection" type="radio" value="<?php echo esc_attr($formats[1]); ?>" class="tog" <?php checked( $formats[1] == $home_title_format && $away_title_format == $home_title_format ); ?> /> <?php _e( 'Reverse', 'themeboy' ); ?></label></th>
		<td><code><?php echo __( 'Away', 'themeboy' ) . ' vs ' . __( 'Home', 'themeboy' ); ?></code></td>
	</tr>
	<tr>
		<th>
			<label><input name="selection" id="title_custom_selection" type="radio" value="custom" class="tog" <?php checked( !in_array($home_title_format, $formats) || !in_array($away_title_format, $formats) ); ?> />
			<?php _e('Custom'); ?>
			</label>
		</th>
		<td>
			<?php _e( 'Home', 'themeboy' ); ?>
			<input name="tb_match_home_title_format" id="tb_match_home_title_format" type="text" value="<?php echo esc_attr($home_title_format); ?>" class="regular-text code" /><br />
			<?php _e( 'Away', 'themeboy' ); ?>
			<input name="tb_match_away_title_format" id="tb_match_away_title_format" type="text" value="<?php echo esc_attr($away_title_format); ?>" class="regular-text code" />
		</td>
	</tr>
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
		jQuery('#tb_match_home_title_format').val( this.value );
		jQuery('#tb_match_away_title_format').val( this.value );
	});
	jQuery('#tb_match_home_title_format, #tb_match_away_title_format').focus(function() {
		jQuery("#title_custom_selection").attr('checked', 'checked');
	});
});
//]]>
</script>
<?php } ?>