<div id="system"> 

<?php
$args=array(
  'post_type' => 'post',
  'post_status' => 'publish',
  'posts_per_page' => 5,
  'caller_get_posts'=> 1
);
$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {  ?>
 	<TABLE border="1" summary="This is a table with no class">
  <TR><TH>Post<TH>Author<TH>Class<TH>Year
  <?php
  while ($my_query->have_posts()) : $my_query->the_post();
    $class = get_post_meta($post->ID, 'head_coach', true);
    $year = get_post_meta($post->ID, 'year', true); ?>
    <tr><th><?php the_title(); ?><td><?php the_author(); ?><td><?php echo $class; ?><td><?php echo $year; ?>
  <?php endwhile; ?>
  </TABLE>
<?php }
wp_reset_query();
?>
 
    <h3>My Custom Page</h3>  
    <?php if (have_posts()) : ?>  
        <?php while (have_posts()) : the_post(); ?>  

        <article class="item">  

<?php  // check if the post has a Post Thumbnail assigned to it.
if ( has_post_thumbnail() ) {
	the_post_thumbnail();
} 
?>
			
		
            <div class="content clearfix"><?php the_content(''); ?></div>  
            
            <img src="<?php the_field('logo'); ?>" style="width 300px; height: 200px;">
            <h1><?php the_field('head_coach'); ?></h1>
            
                        
            <?php acf_form( $options ); ?>

        </article>  

        <?php endwhile; ?>  
    <?php endif; ?>  

    <?php comments_template(); ?>  

</div>