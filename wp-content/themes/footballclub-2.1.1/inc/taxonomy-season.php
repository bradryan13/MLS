<?php
add_action('init', 'tb_season_init', 0);
//add_action('tb_season_edit_form_fields','tb_season_extra_fields', 10, 2);
//add_action('edited_tb_season', 'save_tb_season_extra_fields', 10, 2);
function tb_season_init() {
	register_taxonomy(
		'tb_season',
		array( 'tb_club', 'tb_player', 'tb_staff', 'tb_match' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Seasons', 'themeboy' ),
				'singular_name' => __( 'Season', 'themeboy' ),
				'search_items' =>  sprintf( __( 'Search %s', 'themeboy' ), __( 'Seasons', 'themeboy' ) ),
				'all_items' => sprintf( __( 'All %s', 'themeboy' ), __( 'Seasons', 'themeboy' ) ),
				'parent_item' => sprintf( __( 'Parent %s', 'themeboy' ), __( 'Season', 'themeboy' ) ),
				'parent_item_colon' => sprintf( __( 'Parent %s:', 'themeboy' ), __( 'Season', 'themeboy' ) ),
				'edit_item' => sprintf( __( 'Edit %s', 'themeboy' ), __( 'Season', 'themeboy' ) ),
				'update_item' => sprintf( __( 'Update %s', 'themeboy' ), __( 'Season', 'themeboy' ) ),
				'add_new_item' => sprintf( __( 'Add New %s', 'themeboy' ), __( 'Season', 'themeboy' ) ),
				'new_item_name' => __( 'Season', 'themeboy' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'season' )
		)
	);
}
function tb_season_extra_fields( $tag ) {
	$t_id = $tag->term_id;
	$term_meta = get_option( "taxonomy_term_$t_id" );
?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label><?php _e('Clubs', 'themeboy'); ?></label>
		</th>
		<td>
			<?php
				$query = new WP_Query( array (
					'post_type' => 'tb_club',
					'orderby' => 'title'
				) );
			?>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<input type="checkbox" name="clubs[<?php the_ID(); ?>]" id="club_<?php the_ID(); ?>" /> <label for="club_<?php the_ID(); ?>"><?php the_title(); ?></label><br />
			<?php endwhile; ?>
		</td>
	</tr>
<?php
}
function save_tb_season_extra_fields( $term_id ) {
	if ( isset( $_POST['clubs'] ) ) {
		foreach( $_POST['clubs'] as $club ) {
			wp_set_post_terms( $club, array($term_id), 'tb_season');
		}
	}
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_term_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );

			foreach ( $cat_keys as $key ){
			if ( isset( $_POST['term_meta'][$key] ) ){
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		update_option( "taxonomy_term_$t_id", $term_meta );
	}
}
?>