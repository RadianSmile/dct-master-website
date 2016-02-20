<?php defined('ABSPATH') or die("No Hackers Sorry !"); ?>
<?php
		$displayUser = get_user_by('slug', $author_name);
		$userId = $displayUser->ID;
		
		// for left div photo
		$attachment_id = get_user_meta( $displayUser->ID, 'person_photo', true );
		$photo = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
		$userProfilePhoto = esc_attr( $photo[0] );

    $cover_id = get_user_meta( $displayUser->ID, 'cover_photo', true );
    $cover_photo = wp_get_attachment_image_src( $cover_id, 'large' );
    if( $cover_id != null )
      $coverPhotoStr = 'style="background-image:url('.esc_attr( $cover_photo[0] ).')" ';
    else
      $coverPhotoStr = "";
?>
<?php get_header() ?>
<div class="mainView top" <?= $coverPhotoStr ?> >
  <div class="container">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1 col-md-12">
        <div class="pos">
          
          <p><?=get_user_meta( $userId, 'motto', true )?></p>
          
        </div>
      </div>
    </div>
  </div>
  <div class="bottom GF">
    <div></div>
    <div></div>
  </div>
</div>
<!-- /mainView -->
<div class="container">
  <div class="row ST-userTitle">
    <!-- student's photo  -->
    <div class="col-xs-12 col-sm-3 col-md-2  ">
      <img src="<?= $userProfilePhoto ?>" alt="student name" class="img-circle" style=" width:100%;" />
    </div>
    <!-- /student's photo  -->
    <!-- student's name  -->
    <div class="col-xs-12 col-sm-4  col-md-5  namePos">
      <h1 class="posLeft"><?= $displayUser->display_name ?></h1>
      <div class="divTitle posRight">
        <?= get_user_meta( $userId, 'term_num', true ) ?>th <span></span>
      </div>
      <div class="clearfix"></div>
    </div>
    <!-- /student's name  -->
    <div class="col-md-8 ">
    <div class="row">
      <div class="col-xs-12 col-sm-8  col-md-12 ">
      	<p style="color:#333"><?=get_user_meta( $userId, 'person_title', true )?></p>
        <!-- Skills -->
        <!-- oops, now fully funcion yet
        <a href="" class="label label-danger"> blanditiis omnis</a>
        
        <a href="" class="label label-danger"> accusamus ducimus</a>
        
        <a href="" class="label label-danger"> doloribus dolores</a>
        
        <a href="" class="label label-danger"> facilis</a>
        
        <a href="" class="label label-danger"> in velit</a>
        
        <a href="" class="label label-danger"> et</a>
        
        <a href="" class="label label-danger"> quas non</a>
        
        <a href="" class="label label-danger"> et</a>
        -->
        <!-- /Skills -->
        <hr class="none ">
        <!-- introduction  -->
        <div>
          <?php echo apply_filters( 'the_content', get_user_meta( $userId, 'description', true ) )?>
        </div>
        <hr class="none xl">
        <b>與我聯絡：<a href='mailto:<?=$displayUser->user_email ?>'><?=$displayUser->user_email?></a></b>
        <!-- /introduction  -->
      </div>
    </div>
    </div>
    
  </div>
  <!-- /ST-userTitle -->
  
</div>
<!-- /personal information -->
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
?>
<hr>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      
      <hr class="none">
      <div class="divTitle">
        PROJECTS
      </div>
      <hr class="none">
    </div>
    <!-- /title -->
    <div>
<?php
			
				// get post ids
				foreach( $join_projects as $index => $post_id_obj ) :
					$post_data = get_post( $post_id_obj->post_id );
					$post_status = get_post_status( $post_id_obj->post_id );
					$thumbnail_id = get_post_meta( $post_id_obj->post_id, '_thumbnail_id', true );
					$imageUrl = wp_get_attachment_url( $thumbnail_id );

					if( $post_status == 'publish' )
					{
						$link = get_permalink( $post_data->ID );
?>
    <div class="col-sm-6 " >
        <div class="courses_item black" style="background-image: url(<?= $imageUrl ?>); ">
          <div class="info">
            <a href="<?=$link?>"><?= $post_data->post_title ?></a>
            <div></div>
          </div>
        </div>
     </div>
<?php
					}
				endforeach;
?>
    </div>
    
  </div>
</div>
<!-- /projects -->

<?php 
		endif;
?>
<script>
$('body').attr('id', 'student');
$('li.students').attr('class', 'active students');
</script>
<?php get_footer() ?>