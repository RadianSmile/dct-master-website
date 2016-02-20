<?php defined('ABSPATH') or die("No Hackers Sorry !"); ?>
<?php get_header('simple') ?>
<article class="main">
<?php
	// 4: news
	// 3: projects
	// 10: personnal projects
	//$categories = get_categories();
	//print_r( $categories );
	
	$projects_args = array(
		'posts_per_page' => 100,
		'category' => '3,10',
		'post_type' => 'post'
	);
	
	$project_posts = get_posts( $projects_args );
	
?>
<h3 style="border-bottom: 2px solid #CCC; padding: 10px; width: 300px">最新專案</h3>
<?php
	foreach( $project_posts as $index => $data ):
		
		$thumbnail_id = get_post_meta( $data->ID, '_thumbnail_id', true );
		$imageUrl = wp_get_attachment_url( $thumbnail_id );
?>
		<div class="project_box" style="background-image: url(<?=$imageUrl?>)">
			<h3><?=$data->post_title?></h3>
        <a href="<?=get_permalink( $data->ID )?>">
        </a>
		</div>
<?php
	endforeach;
?>

</article>

<?php get_footer('simple') ?>