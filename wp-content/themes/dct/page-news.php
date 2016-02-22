<?php defined('ABSPATH') or die("No Hackers Sorry !") ?>
<?php get_header() ?>
<div class="mainView top">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="pos">
          <h1>DCT NEWS</h1>

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
<?php
	// 4: news
	// 3: projects
	// 10: personnal projects
	//$categories = get_categories();
	//print_r( $categories );


	$news_args = array(
		'posts_per_page' => 100,
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
  $award_news_posts = get_posts( $award_news_args) ;
?>

<div class="info">
	<div class="container">
		<hr class="none">
		<div class="row">
			<div class="col-md-8">
				<h3 class="blockTitle xl">
          <p>NEWS</p>
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
        <h3 class="blockTitle xl">
          <p>ADMISSION</p>
				</h3>
        <ul class="yellow">
          <?php
            foreach( $award_news_posts as $index => $data ):
              echo '<li><a href="'.get_permalink( $data->ID ).'">';
              echo $data->post_title;
              echo '</a>';
            endforeach;
          ?>
        </ul>
        <h3 class="blockTitle xl">
          <p>INTERIOR</p>
				</h3>
      </div>


    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-7">

    </div>
  </div>
</div>
<script>
$('body').attr('id', 'index');
$('li.about').attr('class', 'active about');
</script>
<?php get_footer() ?>
