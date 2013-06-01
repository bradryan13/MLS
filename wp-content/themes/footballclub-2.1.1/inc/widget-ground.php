<?php
add_action('widgets_init', 'tb_ground_widget_init' );
function tb_ground_widget_init() {
	class TB_Ground_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'tb_ground',
				__( 'Ground Status', 'themeboy' ),
				array( 'description' => __( 'ThemeBoy widget', 'themeboy' ) )
			);
		}
		function widget( $args, $instance ) {
			extract( $args );
			$text = $instance['text'];
			echo '<li id="tb_ground-widget" class="widget-container">
			<h3>' . apply_filters('widget_title', $instance['title']) . '</h3>
			<div class="tb_ground_status_display">' . $text . '</div>
			</li>';
		}
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['text'] = strip_tags( $new_instance['text'] );
			return $instance;
		}
		function form( $instance ) {
			$defaults = array( 'text' => 'Grounds Open', 'title' => __( 'Ground Status', 'themeboy' ) );
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			<p>
				<?php $field = 'title'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Title', 'themeboy') ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( $field ); ?>" name="<?php echo $this->get_field_name( $field ); ?>" value="<?php echo $instance[$field]; ?>" type="text" />
			</p>
			<p>
				<?php $field = 'text'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Text', 'themeboy') ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( $field ); ?>" name="<?php echo $this->get_field_name( $field ); ?>" value="<?php echo $instance[$field]; ?>" type="text" />
			</p>
			<?php
		}
	}
	register_widget( 'tb_ground_widget' );
};
?>