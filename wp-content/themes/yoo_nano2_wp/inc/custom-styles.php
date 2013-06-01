<?php
function tb_custom_style() {
	$primary_color = get_option('tb_primary_color');
	$lighter_color = lighter_color(get_option('tb_primary_color'));
	$lighter_color_40 = lighter_color(get_option('tb_primary_color'), 40);
	$darker_color = darker_color(get_option('tb_primary_color'));
	$darker_color_10 = darker_color(get_option('tb_primary_color'), 10);
	$darker_color_40 = darker_color(get_option('tb_primary_color'), 40);
	$darker_color_60 = darker_color(get_option('tb_primary_color'), 60);
	$darker_color_80 = darker_color(get_option('tb_primary_color'), 80);
	$darker_color_100 = darker_color(get_option('tb_primary_color'), 100);
	$secondary_color = get_option('tb_secondary_color');
	$header_textcolor = get_header_textcolor();
	$tagline_textcolor = get_option('tb_tagline_textcolor');
	$menu_textcolor = get_option('tb_menu_textcolor');
	$menu_bgcolor = get_option('tb_menu_bgcolor');
	$menu_bgcolor_lighter = lighter_color(get_option('tb_menu_bgcolor'), 40);
	$menu_bgcolor_darker = darker_color(get_option('tb_menu_bgcolor'), 40);
	$content_textcolor = get_option('tb_content_textcolor');
	$content_textcolor_lighter = lighter_color(get_option('tb_content_textcolor'), 80);
	$content_bgcolor = get_option('tb_content_bgcolor');
	$sidebar_bgcolor = get_option('tb_sidebar_bgcolor');
	$widget_bgcolor = get_option('tb_widget_bgcolor');
	$widget_bgcolor_lighter = lighter_color(get_option('tb_widget_bgcolor'), 40);
	$sponsors_bgcolor = get_option('tb_sponsors_bgcolor');
	$rotator_bgcolor = get_option('tb_rotator_bgcolor');
	$rotator_textcolor = get_option('tb_rotator_textcolor');
	$footer_bgcolor = get_option('tb_footer_bgcolor');
?>
<style type="text/css">
body,
.image-rotator .image_thumb ul li .more a,
.image-rotator .image_thumb ul li .more a:hover,
.tb_players .gallery-view li .name a,
ul.tb_matches-sidebar .kickoff time, ul.tb_matches-sidebar .kickoff .score,
#wrapper, #menu #searchform input#s,
ul.tb_matches-sidebar .kickoff a {
	color: <?php echo $content_textcolor; ?>
}
a,
.highlighted,
h2.entry-title {
	color: <?php echo $primary_color; ?>;
}
a:hover {
	color: <?php echo $darker_color_40; ?>;
}
#header {
	background-image: url(<?php header_image(); ?>);
}
#header #maintitle h1,
#header #maintitle h1 a {
	color: #<?php echo $header_textcolor; ?>;
}
#header #maintitle h2,
#header #maintitle h2 a {
	color: <?php echo $tagline_textcolor; ?>;
}
.image-rotator {
	background-color: <?php echo $rotator_bgcolor; ?>;	
}
.image-rotator .image_thumb ul li,
.image-rotator .image_thumb ul li .more a {
	color: <?php echo $rotator_textcolor; ?>;
}

/* Commented out by BR to change background color.
#wrapper,
#menu #searchform input#s {
	background-color: <?php echo $content_bgcolor; ?>;
}
*/


#sidebar {
	background-color: <?php echo $sidebar_bgcolor; ?>;
}
.widget-container {
	background-color: <?php echo $widget_bgcolor; ?>;
}
/*
#menu li:hover a,
#menu li:hover input,
#menu #searchform input#searchsubmit:hover,
.image-rotator .image_thumb ul li.active,
.image-rotator .image_thumb ul li.active a,
#content section h3,
.widget-container h3,
.contactform .button:hover,
input[type="submit"]:hover {
	color: <?php echo $secondary_color; ?>;
}
#menu {
	background-color: <?php echo $menu_bgcolor; ?>;
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, <?php echo $menu_bgcolor_lighter; ?>),
		color-stop(0.3, <?php echo $menu_bgcolor; ?>)
	);
	background-image: -moz-linear-gradient(
	center top,
		<?php echo $menu_bgcolor_lighter; ?> 0%,
		<?php echo $menu_bgcolor; ?> 30%
	);
}
#menu li {
	border-right-color: <?php echo $menu_bgcolor_darker; ?>;
	border-left-color: <?php echo $menu_bgcolor_lighter; ?>;
}
#menu li a,
#menu #searchform input#searchsubmit {
	color: <?php echo $menu_textcolor; ?>;
}
#menu .menu li:hover {
	background-color: <?php echo $darker_color_10 ?>;
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, <?php echo $lighter_color_40 ?>),
		color-stop(0.3, <?php echo $darker_color_10 ?>),
		color-stop(1, <?php echo $darker_color_10 ?>)
	);
	background-image: -moz-linear-gradient(
	center top,
		<?php echo $lighter_color_40 ?> 0%,
		<?php echo $darker_color_10 ?> 30%,
		<?php echo $darker_color_10 ?> 100%
	);
	border-right-color: <?php echo $darker_color_80 ?>;
	border-left-color: <?php echo $primary_color ?>;
}
#menu li ul.children,
#menu li ul.sub-menu {
	background-color: <?php echo $darker_color_10 ?>;
}
*/
#content section h3,
.widget-container h3,
.tb_players .gallery-view li .number,
.navigation .nav-previous a:hover,
.navigation .nav-next a:hover,
.commentlist .comment .reply a:hover,
.contactform .button:hover,
.link-button a:hover,
input[type="submit"]:hover {
	background-image: -webkit-gradient( linear, left top, left bottom, color-stop(0, #011450), color-stop(1, #000D24) )
}
#respond h3 {
	color: <?php echo $primary_color ?>;
}
/*
.image-rotator .image_thumb ul li.active {
	background: <?php echo $darker_color_10 ?>;
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, <?php echo $primary_color ?>),
		color-stop(1, <?php echo $darker_color_60 ?>)
	);
	background-image: -moz-linear-gradient(
		center top,
		<?php echo $primary_color ?> 0%,
		<?php echo $darker_color_60 ?> 100%
	);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $primary_color ?>', endColorstr='<?php echo $darker_color_60 ?>');
	cursor: default;
	border-color: <?php echo $darker_color_100 ?>;
}
*/
.image-rotator .image_thumb ul li.active .more a:hover {
	color: <?php echo $secondary_color ?>;	
}
#footer-widgets {
	background-color: <?php echo $footer_bgcolor ?>;
}
#footer-widgets #footer-logo {
	background-image: url(<?php echo get_option('tb_footer_logo_image') ?>);
}


#content .navigation .nav-previous a:hover,
#content .navigation .nav-next a:hover {
	background: <?php echo $darker_color_10 ?>;
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, <?php echo $primary_color ?>),
		color-stop(1, <?php echo $darker_color_40 ?>)
	);
	background-image: -moz-linear-gradient(
		center top,
		<?php echo $primary_color ?> 0%,
		<?php echo $darker_color_40 ?> 100%
	);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $primary_color ?>', endColorstr='<?php echo $darker_color_40 ?>');
}

#main table tbody tr,
ul.tb_matches-sidebar li {
	border-color: <?php echo $widget_bgcolor_lighter; ?>;
}
a.tb_view_all {
	color: <?php echo $content_textcolor_lighter; ?>;
	text-shadow: 1px 1px 0 <?php echo $widget_bgcolor_lighter; ?>;
}
a.tb_view_all:hover {
	color: <?php echo $content_textcolor; ?>;
}
#sponsors {
	background-color: <?php echo $sponsors_bgcolor; ?>;
}

<?php echo get_option('tb_custom_css'); ?>
</style>
<?php
}

add_action('wp_head', 'tb_custom_style');

?>