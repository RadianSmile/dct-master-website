<?php defined('ABSPATH') or die("No Hackers Sorry !"); ?>
<?php get_header( 'bigphoto' ) ?>
    
    <?php
		$displayUser = get_user_by('slug', $author_name);
		$userId = $displayUser->ID;
		
		// for left div photo
		$attachment_id = get_user_meta( $displayUser->ID, 'person_photo', true );
		$photo = wp_get_attachment_image_src( $attachment_id, 'full' );
		$userProfilePhoto = esc_attr( $photo[0] );
	?>
    
    <h1 class="author-title-name">
    <?=apply_filters( 'the_title', $displayUser->display_name )?>
	<?php //apply_filters( 'the_title', get_user_meta( $userId, 'last_name', true ).get_user_meta( $userId, 'first_name', true ) )?>
    </h1>
    
    <h2 class="author-person-title"><?=get_user_meta( $userId, 'person_title', true )?></h2>
    
    
    <?php
		// 參與專案 part
		
		
		// query projects post ids
		global $wpdb;
		
		$join_projects = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT		*
				 FROM		$wpdb->postmeta
				 WHERE		`meta_key` = 'project_member'
				 AND		`meta_value` = %d",
				 $userId
			)
		);
		
		if( count($join_projects) > 0 ) :
			echo '<div id="author-projects-in">';
			echo '<h2>參與專案</h2>';
			
				// get post ids
				foreach( $join_projects as $index => $post_id_obj ) :
					$post_data = get_post( $post_id_obj->post_id );
					$post_status = get_post_status( $post_id_obj->post_id );
					
					if( $post_status == 'publish' )
					{
						$link = get_permalink( $post_data->ID );
						echo "<a href='$link'>";
						echo $post_data->post_title;
						echo "</a>";
					}
				endforeach;
			
			echo '</div>';
		endif;
	?>
    
    
    <h2 class="author-motto">”<?=get_user_meta( $userId, 'motto', true )?>“</h2>
    
    <article id="main-content" class="main">
    <img src='<?=$userProfilePhoto?>' class="mode-full" />
    <?php echo apply_filters( 'the_content', get_user_meta( $userId, 'description', true ) )?>
    </article>
    
    <div class="author-email">
    與我聯絡：<a href='mailto:<?=$displayUser->user_email ?>'><?=$displayUser->user_email?></a>
    </div>
    
	<script type="text/javascript">
	
	// init the behavior
	window.onload = function(){ getPhotosFromContent(); };
	
    </script>
<?php get_footer( 'bigphoto' ) ?>