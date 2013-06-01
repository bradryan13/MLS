<?php /* Template name: College Team */ 
acf_form_head()
?>  

<?php 

// get warp    
$warp = Warp::getInstance();    

// load main template file    
echo $warp['template']->render('template')

?> 