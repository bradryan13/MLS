<?php
add_action('widgets_init', 'tb_twitter_widget_init' );
function tb_twitter_widget_init() {
	class TB_Twitter_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'tb_twitter',
				__( 'Twitter', 'themeboy' ),
				array( 'description' => __( 'ThemeBoy widget', 'themeboy' ) )
			);
		}
		function widget( $args, $instance ) {
			extract( $args );
			$title = apply_filters('widget_title', $instance['title']);
			$username = $instance['username'];
			$limit = $instance['limit'];
			$display_avatar = isset($instance['display_avatar']) ? ($instance['display_avatar'] ? 'true' : 'false') : 'true';
			echo '<li id="'.$args['widget_id'].'" class="widget-container twitter-widget">
			<h3 class="widget-title">'.$title.'</h3>
			<div class="loading"></div>
			</li>
			<script type="text/javascript">
			(function($) {
				$(\'#'.$args['widget_id'].'\').twitter({
					username: \''.$username.'\',
					limit: \''.$limit.'\',
					display_avatar: '.$display_avatar.'
				});
			})(jQuery);    
			</script>';
		}
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['username'] = strip_tags( $new_instance['username'] );
			$instance['limit'] = strip_tags( $new_instance['limit'] );
			$instance['display_avatar'] = (bool)$new_instance['display_avatar'];
			return $instance;
		}
		function form( $instance ) {
			$defaults = array( 'title' => __('Twitter', 'themeboy'), 'username' => 'themeboy', 'limit' => 3 );
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'themeboy') ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Username:', 'themeboy') ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" type="text" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e('Number of tweets to show:', 'themeboy') ?></label>
				<input id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo $instance['limit']; ?>" type="text" size="2" />
			</p>
			<p>
				<input id="<?php echo $this->get_field_id( 'display_avatar' ); ?>" name="<?php echo $this->get_field_name( 'display_avatar' ); ?>" type="checkbox" <?php checked( (isset($instance['display_avatar']) ? $instance['display_avatar'] : true), true ); ?>/>
				<label for="<?php echo $this->get_field_id( 'display_avatar' ); ?>"><?php _e('Display avatar image', 'themeboy') ?></label>
			</p>
			<?php
		}
	}
	register_widget( 'tb_twitter_widget' );
};
?>