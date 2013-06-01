<?php

/**
 * Football Club functions and definitions
 *
 * @package WordPress
 * @subpackage Football Club
 * @since Football Club 2.0
 */

// translations
load_theme_textdomain( 'themeboy', TEMPLATEPATH . '/languages' );
$locale = get_locale();
$locale_file = TEMPLATEPATH . '/languages/$locale.php';
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

// defaults
require_once('inc/defaults.php');

// helpers
require_once('inc/helpers.php');
require_once('inc/helpers-club.php');
require_once('inc/helpers-player.php');
require_once('inc/helpers-match.php');

// ajax
include_once( 'inc/ajax-club_buttons.php' );
include_once( 'inc/ajax-players_table.php' );
include_once( 'inc/ajax-match_shortcode.php' );
include_once( 'inc/ajax-fixtures_shortcode.php' );
include_once( 'inc/ajax-results_shortcode.php' );
include_once( 'inc/ajax-standings_shortcode.php' );
include_once( 'inc/ajax-player_shortcode.php' );
include_once( 'inc/ajax-players_shortcode.php' );
include_once( 'inc/ajax-staff_shortcode.php' );
include_once( 'inc/ajax-rotator_shortcode.php' );
include_once( 'inc/ajax-contact_shortcode.php' );
include_once( 'inc/ajax-map_shortcode.php' );

// shortcodes
require_once( 'inc/shortcode-contact.php' );
require_once( 'inc/shortcode-fixtures.php' );
require_once( 'inc/shortcode-map.php' );
require_once( 'inc/shortcode-match.php' );
require_once( 'inc/shortcode-player.php' );
require_once( 'inc/shortcode-players.php' );
require_once( 'inc/shortcode-results.php' );
require_once( 'inc/shortcode-rotator.php' );
require_once( 'inc/shortcode-sponsors.php' );
require_once( 'inc/shortcode-staff.php' );
require_once( 'inc/shortcode-standings.php' );
require_once( 'inc/shortcode-tinymce.php' );

// setup
require_once('inc/setup.php');

// customize
require_once('inc/customize.php');

// theme options
include_once( 'inc/themeboy-general.php' );
include_once( 'inc/themeboy-social.php' );
include_once( 'inc/themeboy-rotator.php' );
include_once( 'inc/themeboy-team.php' );
include_once( 'inc/themeboy-standings.php' );
include_once( 'inc/themeboy-matches.php' );
include_once( 'inc/themeboy-contact.php' );
include_once( 'inc/themeboy-customize.php' );
include_once( 'inc/themeboy-advanced.php' );
include_once( 'inc/themeboy-reset.php' );
include_once( 'inc/themeboy-adminbar.php' );

// post types
require_once('inc/post-type-club.php');
require_once('inc/post-type-player.php');
require_once('inc/post-type-staff.php');
require_once('inc/post-type-match.php');
require_once('inc/post-type-sponsor.php');

// taxonomies
require_once('inc/taxonomy-comp.php');
require_once('inc/taxonomy-venue.php');
require_once('inc/taxonomy-season.php');
require_once('inc/taxonomy-team.php');
require_once('inc/taxonomy-position.php');

// widgets
include_once('inc/widget-fixtures.php');
include_once('inc/widget-results.php');
include_once('inc/widget-standings.php');
include_once('inc/widget-facebook.php');
include_once('inc/widget-twitter.php');
include_once('inc/widget-image.php');
include_once('inc/widget-ground.php');

// sidebars
require_once('inc/sidebars.php');

// scripts
include('inc/enqueue-scripts.php');

// styles
include('inc/enqueue-styles.php');
include('inc/custom-styles.php');


?>