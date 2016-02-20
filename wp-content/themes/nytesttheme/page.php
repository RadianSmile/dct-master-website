<?php defined('ABSPATH') or die("No Hackers Sorry !"); ?>
<?php

	// 預設抓取現在頁面的 post
	$thePost = get_post();
	
	// if is one-column, use simple design
	$postType = get_post_field( 'page-type', $thePost->ID );



?>
<?php if( $postType == 'one-column' ): ?>
	<?php get_header( 'simple' ) ?>
    
        <h1 class="page-title"><?= apply_filters( 'the_title', $thePost->post_title ) ?></h1>
        <div class="page-title-line"></div>
            
        <article class="main">
		<?= apply_filters( 'the_content', $thePost->post_content ) ?>
        </article>


	<?php get_footer( 'simple' ) ?>
<?php else: ?>
	<?php get_header( 'bigphoto' ) ?>
        	
            <h1 class="page-title"><?= apply_filters( 'the_title', $thePost->post_title ) ?></h1>
        	<div class="page-title-line"></div>
        
            <article id="main-content" class="main">
            <?= apply_filters( 'the_content', $thePost->post_content ) ?>
            </article>
    
    
        <script type="text/javascript">
        
        // init the behavior
        window.onload = function(){ getPhotosFromContent() };
        
        </script>
    <?php get_footer( 'bigphoto' ) ?>
<?php endif ?>