<?php defined('ABSPATH') or die("No Hackers Sorry !"); ?>
<?php get_header() ?>
<div class="mainView top">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="pos">
          <h1>PROJECTS</h1>
          <p>數位專案</p>
          
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
	<?php // search not complete yet
  	/*
  <div class="row">
  	
    <div class="col-sm-12">
    	
    	
      <p class="properties">Search //
        <!-- 以下span為「當前的關鍵字」所使用 -->
        <span>UX, UI, C# <button type="button" class="btn btn-default btn-link ">清除 </button> </span>
        <!-- 清除後請整個span請不用顯示 -->
      </p>

      <div class="form-inline">
        <div class="form-group">
          <label class="sr-only" for="exampleInputEmail3">key words</label>
          <input type="text" class="form-control" id="exampleInputEmail3" placeholder="搜尋">
        </div>
        <button type="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-search"></span></button>
     
    </div>
    
  </div>
  */ ?>
  
  
</div>
<!-- /Capacity -->
</div>
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

	if( !isset($_GET['pjPage']) )
		$nowPage = 1;
	else
		$nowPage = $_GET['pjPage'];

	$pPerPage = 12;
	$pOffset = ($nowPage-1) * $pPerPage;

	// get post num
	$categories = get_categories('include=3,10');
	$totalNum = 0;

	foreach($categories as $category) {
		$totalNum += $category->count;
	}

	$pageNums = floor($totalNum / $pPerPage);

	// 4: news
	// 3: projects
	// 10: personnal projects
	//$categories = get_categories();
	//print_r( $categories );
	
	$projects_args = array(
		'posts_per_page' => $pPerPage,
		'category' => '3,10',
		'post_type' => 'post',
		'offset' => $pOffset
	);
	
	$project_posts = get_posts( $projects_args );
	
?>
<h3 style="border-bottom: 2px solid #CCC; padding: 10px; width: 300px">最新專案</h3>
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
  <!-- /projects -->
  <div class="text-center">
    <nav>
      <ul class="pagination">
        <li <?php if( $nowPage==1 ) echo 'class="disabled"' ?> ><a href="?pjPage=<?=max($nowPage-1,1)?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
        <?php

	        for( $i=0; $i<= $pageNums; $i++ )
	        {
	        	if( $nowPage == $i+1 )
	        		echo '<li class="active"><a href="?pjPage='.($i+1).'">'.($i+1).' <span class="sr-only">(current)</span></a></li>';
	        	else
	        		echo  '<li><a href="?pjPage='.($i+1).'">'.($i+1).'</a></li>';
	    	}

	    ?>
        <li <?php if( $nowPage==$pageNums+1 ) echo 'class="disabled"' ?> ><a href="?pjPage=<?=min($nowPage+1,$pageNums+1)?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
      </ul>
    </nav>
  </div>
  <!-- /pagination  -->
</div>
</div>
<!-- /projects -->
<script>
$('body').attr('id', 'projects');
$('li.projects').attr('class', 'active projects');
</script>

<article class="main">


</article>

<?php get_footer('simple') ?>