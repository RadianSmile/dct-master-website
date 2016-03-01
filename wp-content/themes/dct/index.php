<?php defined('ABSPATH') or die("No Hackers Sorry !") ?>
<?php get_header() ?>
 <div class="mainView top">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="pos">
					<h1>DIGITAL CONTENTS & <br> TECHNOLOGIES</h1>
					<p>政治大學數位內容碩士學位學程</p>
				</div>
			</div>
		</div>
	</div>
	<div class="bottom GF">
		<div></div>
		<div></div>
	</div>
</div>
<?php
	// 4: news
	// 3: projects
	// 10: personnal projects
	//$categories = get_categories();
	//print_r( $categories );


	$news_args = array(
		'posts_per_page' => 10,
		'category' => 4,
		'post_type' => 'post',

	);

  $award_news_args = array (
    'posts_per_page' => 5,
    'category_name' => '得獎新聞',
    'post_type' => 'post'
  );

	$projects_args = array(
		'posts_per_page' => 4,
		'category' => '3,10',
		'post_type' => 'post'
	);

	$news_posts = get_posts( $news_args );
	$project_posts = get_posts( $projects_args );
  // $award_news_posts = get_posts( $award_news_args) ;

?>
<!-- /mainView -->
<div class="info">
	<div class="container">
		<hr class="none">
		<div class="row">
			<div class="col-md-8">
				<h3 class="blockTitle xl">
				<p>NEWS <a href="<?= site_url() ?>/news" class="more">更多 最新消息</a></p>
				</h3>
				<ul class="yellow">
				<?php
				foreach( $news_posts as $index => $data ):
					echo '<li><a href="'.get_permalink( $data->ID ).'">';
					echo $data->post_title;
					echo '</a>';
				endforeach;
				?>

				</ul>
			</div>
			<!-- <div class="col-md-4">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="blockTitle xl">
                        <?php // not done yet
						/*
						<p>INTERIOR <a href="news.html" class="more">更多 學生事務公告</a></p>
						</h3>
						<ul class="yellow">

							<li><a href="news_detail.html"> hic ut et non enim </a></li>

							<li><a href="news_detail.html"> deleniti id aperiam repellendus quia </a></li>

						</ul>
						*/
						?>
						<br>
					</div>
					<div class="col-sm-12">
						<h3 class="blockTitle xl">


						<p>ADMISSION <a href="news.html" class="more">更多 招生資訊</a></p>
						</h3>
						<ul class="yellow">
              <?php
                // foreach( $award_news_args as $index => $data ):
                //   echo '<li><a href="'.get_permalink( $data->ID ).'">';
                //   echo $data->post_title;
                //   echo '</a>';
                // endforeach;
              ?>
						</ul>
					</div>
				</div>
			</div> -->
		</div>
	</div>
	<hr class="none">
	<!-- /news -->
	<div class="mainView slogen" >
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="pos slogen">
						<h2>"成為創新數位生活 <br>　　培育及領導的搖籃"</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="top GF">
			<div></div>
			<div></div>
		</div>
	</div>
	<hr class="none">
	<!-- /slogen -->

	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="blockTitle xl">
				<p>PROJECTS <a href="projects" class="more">近期專案</a></p>
				</h3>
				<hr class="none">
				<div>

<?php
	foreach( $project_posts as $index => $data ):

		$thumbnail_id = get_post_meta( $data->ID, '_thumbnail_id', true );
		$imageUrl = wp_get_attachment_url( $thumbnail_id );
?>
					<div class="col-sm-6 " >
						<div class="courses_item black" style="background-image: url(<?=$imageUrl?>); ">
							<div class="info">
								<a href="<?=get_permalink( $data->ID )?>"><?=$data->post_title?></a>
								<div></div>
							</div>
						</div>
					</div>
<?php
	endforeach;
?>

				</div>
			</div>

		</div>
	</div>
	<hr>
<?php
	// $ary[ $term_num ][ user_id ]
	$display_array;



	// get all students
	$studnet_args = array(
		'role'		=>	'student',
		'meta_key'	=>	'student_id',
		'orderby'	=>	'meta_value',
		'order'		=>	'asc'
	);

	$students = get_users( $studnet_args );



  function cmp($a, $b){
    $aid = get_user_meta( $a->ID,'student_id', true ) ;
    $bid = get_user_meta( $b->ID,'student_id',true) ;
    return $aid < $bid ;
  }
  usort($students, "cmp");

  $students_length = count($students);
?>

  <div class="container">
		<div class="row">
			<div class="col-md-12">
				<hr class="none">
				<h3 class="blockTitle xl">
				<p>STUDENTS <a href="students/" class="more"> 系所學生 >> </a></p>
				</h3>
				<hr class="none">

				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="min-height:400px;">
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
						<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
						<li data-target="#carousel-example-generic" data-slide-to="2" class="active"></li>
					</ol>
					<div class="carousel-inner" role="listbox">


<?php foreach( $students as $index => $data ):
  $attachment_id = get_user_meta( $data->ID, 'person_photo', true );
  $photo = wp_get_attachment_image_src( $attachment_id, 'thumbnail', true );
  $photoUrl = esc_attr( $photo[0] );
  if( $attachment_id == null )
  	$photoUrl = get_template_directory_uri() . '/img/WhosWho.png';
?>

<?php
  if ($index % 4 == 0){
    $activeClass = ($index ==0) ? "active" : "" ;
    echo '<div class="item '. $activeClass  .'">\
            <div class="row">';
  }
?>


                <div class="col-md-3 listuser text-center">
                	<a href="<?= site_url().'/author/'.$data->user_login ?>">
                		<img src="<?= $photoUrl ?>" alt="<?= $data->display_name ?>" class="img-circle" />
                		<h4> <?= $data->display_name ?> </h4>
                		<p> <?= get_user_meta( $data->ID, 'person_title', true ) ?> </p>
                	</a>
                </div>

<?php
  if ($index % 4 == 3 || $index == $students_length-1){
        echo '</div>\
            </div>';
  }
?>

<?php endforeach; ?>

					</div>
					<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('body').attr('id', 'index');
	$('li.index').attr('class', 'active index');
</script>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>


<?php get_footer() ?>
