<?php defined('ABSPATH') or die("No Hackers Sorry !"); ?>
<?php get_header( 'bigphoto' ) ?>
    
    <?php
		// 預設抓取現在頁面的 post
		$thePost = get_post();
		
	?>
        <h1 class="page-title"><?= apply_filters( 'the_title', $thePost->post_title ) ?></h1>
        <div class="page-title-line"></div>
        
        <div id="members" style="width:80%">
        <?php
		
		$members_id = get_post_meta( $thePost->ID, 'project_member' );
		
		foreach( $members_id as $index => $member_id ) :
			$targetUser = get_user_by( 'id', $member_id );
			$photoId = get_user_meta( $member_id, 'person_photo', true );
			$photo = wp_get_attachment_image_src( $photoId, 'thumbnail' );
			
			$photoUrl = $photo[0];
			$person_link = site_url().'/author/'.$targetUser->user_login;
			
			echo "<a href='$person_link' class='project-member-thumbnail' >";
			echo "<img src='$photoUrl' />";
			echo "<span class='display-name'>".$targetUser->display_name."</span>";
			echo "</a><br />";
		endforeach;
		
		?>
        </div>
        
        <article id="main-content" class="main">
        <?= apply_filters( 'the_content', $thePost->post_content ) ?>
        </article>

	<script type="text/javascript">
	
	// init the behavior
	window.onload = function(){ getPhotosFromContent() };
	
    </script>
<?php get_footer( 'bigphoto' ) ?>