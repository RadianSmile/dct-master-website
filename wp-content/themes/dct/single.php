<?php defined('ABSPATH') or die("No Hackers Sorry !"); ?>
<?php

function AddFeatureImageOnHead() {
	global $featureImageUrl;
	echo '<meta property="og:image" name="og:image" content="'.$featureImageUrl.'" />';
}

	// 預設抓取現在頁面的 post
	$thePost = get_post();

	// get feature image for share link
	$thumbnail_id = get_post_meta( $thePost->ID, '_thumbnail_id', true );
	$featureImageUrl = wp_get_attachment_url( $thumbnail_id );

	add_action('wp_head', 'AddFeatureImageOnHead');

	$cat = get_the_category( $thePost->ID );
	$isProject = false;
	// 專案：3
	// 個人作品：10
	foreach( $cat as $index => $data )
	{
		if( $data->term_id == 3 || $data->term_id == 10 )
		{
			$isProject = true;
			break;
		}
	}
?>
<?php get_header() ?>
<?php

    // 預設抓取現在頁面的 post
    $thePost = get_post();


    $thumbnail_id = get_post_meta( $thePost->ID, '_thumbnail_id', true );
    $imageUrl = wp_get_attachment_url( $thumbnail_id );

?>


<?php if( $isProject ): ?>

<div class="mainView top " style="background-image: url(<?=$imageUrl?>); ">
  <div class="coverMask"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="pos">
          <h1 class="text-center" title="專案名稱">
          <!-- Project name -->
          <?= $thePost->post_title ?>
          </h1>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /mainView ================================================= -->
<div class="container">
  <!-- Team member -->
  <div class="row">
    <div class="col-md-8 col-md-offset-2 text-center" title="團隊成員">
<?php
		$members_id = get_post_meta( $thePost->ID, 'project_member' );

		foreach( $members_id as $index => $member_id ) :
			$targetUser = get_user_by( 'id', $member_id );
			$photoId = get_user_meta( $member_id, 'person_photo', true );
			$photo = wp_get_attachment_image_src( $photoId, 'thumbnail' );

			$photoUrl = $photo[0];
			$person_link = site_url().'/author/'.$targetUser->user_login;
?>
	  <div class="listuser text-center">
        <a href="<?=$person_link?>">
          <img src="<?=$photoUrl?>" alt="student name" class="img-circle" />
          <p><?=$targetUser->display_name?></p>
        </a>
      </div>
<?php
		endforeach;
?>


    </div>
  </div>
  <!-- /Team member  =================================================  -->
  <!-- Project detail -->
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <!-- Project detail: html -->
      <?= $thePost->post_content ?>
    </div>
  </div>
  <!-- /Project detail  =================================================  -->
  <!-- Course  -->
  <?php /* not yet ready
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <hr>
    </div>
    <div class="col-md-4 col-md-offset-2">
      <div class="divTitle">
        COURSE <span>課程資訊</span>
      </div>
      <br>
      <p> <a href="course.html"><span>觸控介面設計</span> by <span>余能豪</span>老師
    </a></p>
  </div>
  <div class="col-md-4">
    <div class="row">
      <div class="col-xs-4">
        <a href="teacher.html"> <img src="img/bt_theme_nav_01.png" class="img-responsive facultyImg" alt="Responsive image"></a>
      </div>
      <div class="col-xs-8">
        <ul class="red ">
          <li>人機互動</li>
          <li>長期數位多媒體資訊典藏系統建立及管理</li>
          <li>數位內容技術</li>
          <li>資訊設計</li>
        </ul>
      </div>

    </div>
  </div>
  </div>
  */ ?>
  <!-- /Course   =================================================  -->
  <br />
  <br />
</div>
<script>
$('body').attr('id', 'projectDe');
$('li.projects').attr('class', 'active projects');
</script>

<?php else : ?>
<div id="pageMainView" class="mainView top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pos">
                    <h1><?=$thePost->post_title?></h1>
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
    <?= apply_filters( 'the_content', $thePost->post_content ) ?>
</div>
<?php if( $imageUrl != "" ): ?>
    <script>
        $('#pageMainView').css('background','url(<?=$imageUrl?>)');
    </script>
<?php endif ?>
<?php endif ?>
<?php get_footer() ?>
