<?php
add_action( 'wp_ajax_tb_club_buttons', 'tb_club_buttons_ajax' );
function tb_club_buttons_ajax() {
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'tb_club_buttons_ajax_nonce')) {
		exit();
	}
	 
	global $tb_default_images;
	$defaults = array(
		'eid' => 'tb_club'
	);
	$args = array_merge( $defaults, $_GET );
	?>
	<p>
		<?php
		$clubs = get_posts( array (
			'post_type' => 'tb_club',
			'orderby' => 'title',
			'order' => 'asc',
			'numberposts' => -1,
			'posts_per_page' => -1
		) );
		?>
		<?php
		foreach( $clubs as $club ) {
			$class = 'tb-club-medium-button';
			$id = $club->ID;
			if ( has_post_thumbnail( $club->ID ) ) {
				$crest = wp_get_attachment_image_src( get_post_thumbnail_id( $club->ID ), 'crest-large', true );
			}
			else {
				$crest = array( '', '', '' );
			}
			$crest_url = $crest[0];
			$crest_width = $crest[1];
			$crest_height = $crest[2];
			$title = get_the_title( $club->ID );
			echo "<a class='$class' id='$id' title='$title' data-crest-url='$crest_url' data-crest-width='$crest_width' data-crest-height='$crest_height'>" . get_the_post_thumbnail( $club->ID, 'crest-medium', array( 'title' => $title ) ) . ' <span class="ellipsis">' . $club->post_title . '</span></a>' . PHP_EOL;
		}
		?>
	</p>
	<script type="text/javascript">
		(function($) {
			var eid = '<?php echo $args['eid']; ?>';
			var side = '<?php echo $args['side']; ?>';
			$('.tb-club-medium-button').click(function () {
				var id = $(this).attr('id');
				var title = $(this).attr('title');
				var crest_url = $(this).attr('data-crest-url');
				var crest_width = $(this).attr('data-crest-width');
				var crest_height = $(this).attr('data-crest-height');
				tb_remove();
				var img = '';
				if (crest_url)
					img = '<img width="' + crest_width + '" height="' + crest_height + '" src="' + crest_url + '" class="attachment-crest-large wp-post-image" alt="' + title + '" title="<?php printf( __( 'Select %s', 'themeboy' ), __( 'Club', 'themeboy' ) ); ?>">';
				$('#' + eid + '_button').html(
					img + '<span class="ellipsis">' + title + '</span>'
				);
				$('#' + eid).val(id);
				$('#tb_' + side + '_club').change();
			});
		})(jQuery);
	</script>
	<?php
	exit();
}
?>