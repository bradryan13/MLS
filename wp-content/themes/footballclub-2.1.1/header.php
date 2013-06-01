<!DOCTYPE html>
<html <?php language_attributes(); ?>><head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
global $page, $paged;
wp_title( get_option( 'tb_title_delimiter' ), true, 'right' );
bloginfo( 'name' );
$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description && ( is_home() || is_front_page() ) )
	echo ' ' . get_option( 'tb_title_delimiter' ) . ' ' . $site_description;
if ( $paged >= 2 || $page >= 2 )
	echo ' ' . get_option( 'tb_title_delimiter' ) . ' ' . sprintf( __( 'Page %s', 'themeboy' ), max( $paged, $page ) );
?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo get_option( 'tb_favicon_image' ) ?>" type="image/x-icon" />
<link rel="icon" href="<?php echo get_option( 'tb_favicon_image' ) ?>" type="image/x-icon" />
<?php echo get_option( 'tb_custom_scripts' ) ?>
<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="fb-root"></div>
<div id="wrapper">
	<header id="header">
		<a id="logo" href="<?php bloginfo( 'url' ); ?>"><img src="<?php echo get_option(' tb_header_logo_image ') ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
		<hgroup id="maintitle">
			<?php
				if (
					( is_wp_version( '3.4' ) && display_header_text() ) ||
					( ! is_wp_version( '3.4' ) && ! NO_HEADER_TEXT ) ) {
			?>
				<h1><a href="<?php bloginfo( 'url' ); ?>"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a></h1>
				<h2><a href="<?php bloginfo( 'url' ); ?>"><?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?></a></h2>
			<?php } ?>
		</hgroup>
		<?php if ( get_option( 'tb_header_sponsor' ) > 0 ) { ?>
			<div id="sponsor">
				<?php
					$sponsor_id = get_option( 'tb_header_sponsor' );
					$sponsor = get_post( $sponsor_id );
					$link_directly = get_post_meta( $sponsor_id, 'tb_link_directly', true );
					$link_url = $link_directly ? get_post_meta( $sponsor_id, 'tb_link_url', true ) : get_permalink( $sponsor_id );
				?>
				<a href="<?php echo $link_url; ?>" <?php if ( $link_directly ) echo 'target="_blank"'; ?>>
					<?php
						if ( has_post_thumbnail( $sponsor_id ) ) {
							echo get_the_post_thumbnail( $sponsor_id, 'sponsor-header', array( 'alt' => get_the_title( $sponsor_id ), 'title' => get_the_title( $sponsor_id ) ) );
						} else {
							echo get_the_title( $sponsor_id );
						}
					?>
				</a>
			</div>
		<?php } ?>
		<?php if ( get_option( 'tb_header_sponsor_2' ) > 0 ) { ?>
			<div id="sponsor">
				<?php
					$sponsor_id = get_option( 'tb_header_sponsor_2' );
					$sponsor = get_post( $sponsor_id );
					$link_directly = get_post_meta( $sponsor_id, 'tb_link_directly', true );
					$link_url = $link_directly ? get_post_meta( $sponsor_id, 'tb_link_url', true ) : get_permalink( $sponsor_id );
				?>
				<a href="<?php echo $link_url; ?>" <?php if ( $link_directly ) echo 'target="_blank"'; ?>>
					<?php
						if ( has_post_thumbnail( $sponsor_id ) ) {
							echo get_the_post_thumbnail( $sponsor_id, 'sponsor-header', array( 'alt' => get_the_title( $sponsor_id ), 'title' => get_the_title( $sponsor_id ) ) );
						} else {
							echo get_the_title( $sponsor_id );
						}
					?>
				</a>
			</div>
		<?php } ?>
		<ul id="social">
			<?php if ( get_option( 'tb_social_facebook' ) ) { ?><li class="facebook"><a href="<?php echo get_option( 'tb_social_facebook' ); ?>" title="<?php _e( 'Facebook', 'themeboy' ); ?>" target="_blank"><?php _e( 'Facebook', 'themeboy' ); ?></a></li><?php } ?>
			<?php if ( get_option( 'tb_social_twitter' ) ) { ?><li class="twitter"><a href="<?php echo get_option( 'tb_social_twitter' ); ?>" title="<?php _e( 'Twitter', 'themeboy' ); ?>" target="_blank"><?php _e( 'Twitter', 'themeboy' ); ?></a></li><?php } ?>
			<?php if ( get_option( 'tb_social_pinterest' ) ) { ?><li class="pinterest"><a href="<?php echo get_option( 'tb_social_pinterest' ); ?>" title="<?php _e( 'Pinterest', 'themeboy' ); ?>" target="_blank"><?php _e( 'Pinterest', 'themeboy' ); ?></a></li><?php } ?>
			<?php if ( get_option( 'tb_social_linkedin' ) ) { ?><li class="linkedin"><a href="<?php echo get_option( 'tb_social_linkedin' ); ?>" title="<?php _e( 'LinkedIn', 'themeboy' ); ?>" target="_blank"><?php _e( 'LinkedIn', 'themeboy' ); ?></a></li><?php } ?>
			<?php if ( get_option( 'tb_social_gplus' ) ) { ?><li class="gplus"><a href="<?php echo get_option( 'tb_social_gplus' ); ?>" title="<?php _e( 'Google+', 'themeboy' ); ?>" target="_blank"><?php _e( 'Google+', 'themeboy' ); ?></a></li><?php } ?>
			<?php if ( get_option( 'tb_social_youtube' ) ) { ?><li class="youtube"><a href="<?php echo get_option( 'tb_social_youtube' ); ?>" title="<?php _e( 'YouTube', 'themeboy' ); ?>" target="_blank"><?php _e( 'YouTube', 'themeboy' ); ?></a></li><?php } ?>
			<?php if ( get_option( 'tb_social_vimeo' ) ) { ?><li class="vimeo"><a href="<?php echo get_option( 'tb_social_vimeo' ); ?>" title="<?php _e( 'Vimeo', 'themeboy' ); ?>" target="_blank"><?php _e( 'Vimeo', 'themeboy' ); ?></a></li><?php } ?>
		</ul>
		<div class="clear"></div>
	</header>
	<nav id="menu" class="clearfix">
		<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
		<?php get_search_form(); ?>
	</nav>
	<div id="main" class="clearfix">