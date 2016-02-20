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

	$projects_args = array(
		'posts_per_page' => 4,
		'category' => '3,10',
		'post_type' => 'post'
	);

	$news_posts = get_posts( $news_args );
	$project_posts = get_posts( $projects_args );

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
			<div class="col-md-4">
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
                        <?php // function not done yet
						/*
						<p>ADMISSION <a href="news.html" class="more">更多 招生資訊</a></p>
						</h3>
						<ul class="yellow">
							
							<li><a href="news_detail.html"> expedita quibusdam quos et tempore sequi sint repudiandae </a></li>
							
							<li><a href="news_detail.html"> corporis mollitia ut veritatis voluptatem et </a></li>
							
						</ul>
						*/
						?>
					</div>
				</div>
			</div>
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
</div>
<script>
	$('body').attr('id', 'index');
	$('li.index').attr('class', 'active index');
</script>


<?php get_footer() ?>