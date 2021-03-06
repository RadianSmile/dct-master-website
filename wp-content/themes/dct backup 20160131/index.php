<?php defined('ABSPATH') or die("No Hackers Sorry !") ?>
<?php get_header('simple') ?>
<script type="text/javascript" src="<?=get_template_directory_uri().'/js/jssor.slider.min.js'?>">
</script>
<script>
	/* slider scripts */
	
	var slider_id = '';
	var jssor_slider1;

    jQuery(document).ready(function(e) {
		slider_id = 'slider1_container';
        var options = {
			$AutoPlay : true,
			$ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $ChanceToShow: 1
			}
		};

        jssor_slider1 = new $JssorSlider$( slider_id, options);

		//ScaleSlider();
    });

	//responsive code begin
	//you can remove responsive code if you don't want the slider scales
	//while window resizes
	function ScaleSlider() {
		if( slider_id == '' ) return;

		var parentWidth = jQuery('#slider1_container').parent().width();
		console.log( parentWidth );
		if (parentWidth) {
			jssor_slider1.$SetScaleWidth(parentWidth);
		}
		else
			window.setTimeout(ScaleSlider, 30);

	}

	//jQuery(window).resize(ScaleSlider);

</script>
<div class="index-header-section">
    <div class="index-header-bg" style="background-image:url(<?=get_template_directory_uri().'/images/DCT_BG.png'?>)"></div>
    <div class="index-header-pic" style="background-image:url(<?=get_template_directory_uri().'/images/DCT_Banner_Text.png'?>)"></div>
</div>
<script type="text/javascript">
	/* fansy triangle script */
	var imgUrl = '<?=get_template_directory_uri().'/images/DCT_TRA.png' ?>';
	var header_div = jQuery('.index-header-section');
	
	jQuery(document).ready(function(e) {
		fire_activate();
    });
	
	function fire_triangle()
	{
		var triangle = document.createElement('div');
		var tri_width = Math.floor( Math.random() * 4 + 1 ) * 10;
		var tri_height = Math.floor( tri_width * 0.5 );
		
		jQuery( triangle ).addClass( 'index-header-triangle' );
		jQuery( triangle ).css('background-image', 'url(' + imgUrl + ')' );
		jQuery( triangle ).css('width', 0 );
		jQuery( triangle ).css('height', tri_height );
		jQuery( triangle ).css('left', 0 );
		jQuery( triangle ).css('top', Math.random()*180 + 20 );
		
		var pixel_to_go = 800;
		var pixel_per_sec = tri_width * 2 + 20;
		var pixel_time =  1000 / pixel_per_sec;
		
		jQuery( triangle ).animate({ width: '+=' + tri_width }, tri_width*pixel_time, 'linear')
						  .animate({ left: '+=700' }, 700*pixel_time, 'linear')
						  .animate({ left: '+=200', opacity: 0 }, 200*pixel_time, 'linear', function (){ jQuery(this).remove();});
						  
		jQuery(header_div).append( triangle );
	}
	
	function fire_activate()
	{
		if( Math.random() * 1.0 > 0.5 ) // 50% chance
			fire_triangle();
		
		setTimeout( fire_activate, 1000 );
	}
</script>
<?php //<div style="color:#fff; font-size:40px; padding: 50px 10% 0px 10%">政治大學 數位內容碩士學位學程</div> ?>
<article class="main">
<?php
	
	// get posts tag as ' promotion '
	$slideshowArgs = array( 'category_name' => 'promotion' );
	$slideshowPosts = get_posts( $slideshowArgs );

	// array that store the ids
	$slideshow_post_ids = array();

	foreach ( $slideshowPosts as $post ) {
		array_push( $slideshow_post_ids, $post->ID );
	}
	


?>
    <div id="slider1_container" style="margin: 0px; position: relative; width: 800px; height: 300px; overflow: hidden">
    <!-- Slides Container -->
    <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 800px; height: 300px; overflow: hidden;">
<?php foreach( $slideshow_post_ids as $index => $data ): ?>
<?php
	$post = get_post( $data );
	$id = $data;
	$thumbnail_id = get_post_meta( $id, '_thumbnail_id', true );
	$imageUrl = wp_get_attachment_url( $thumbnail_id );
?>
        <div>
        <a href="<?=get_permalink( $id )?>" class="slider-item" style="background-image:url(<?=$imageUrl?>)">
        	<div class="caption">
        		<?=$post->post_title?>
    		</div>
        </a>
        </div>
<?php endforeach; ?>
    </div>
    <!-- Arrow Navigator Skin Begin -->
    <style>
            /* jssor slider arrow navigator skin 21 css */
            /*
            .jssora21l              (normal)
            .jssora21r              (normal
            .jssora21l:hover        (normal mouseover)
            .jssora21r:hover        (normal mouseover)
            .jssora21ldn            (mousedown)
            .jssora21rdn            (mousedown)
            */
            .jssora21l, .jssora21r, .jssora21ldn, .jssora21rdn
            {
            	position: absolute;
            	cursor: pointer;
            	display: block;
                background: url(<?=get_template_directory_uri().'/images/a21.png'?>) center center no-repeat;
                overflow: hidden;
            }
            .jssora21l { background-position: -3px -33px; }
            .jssora21r { background-position: -63px -33px; }
            .jssora21l:hover { background-position: -123px -33px; }
            .jssora21r:hover { background-position: -183px -33px; }
            .jssora21ldn { background-position: -243px -33px; }
            .jssora21rdn { background-position: -303px -33px; }
        </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora21l" style="width: 55px; height: 55px; top: 123px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora21r" style="width: 55px; height: 55px; top: 123px; right: 8px">
        </span>
        <!-- Arrow Navigator Skin End -->
        <script>
			//jssor_slider1_starter('slider1_container');
		</script>
	</div>


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

	$projects_args = array(
		'posts_per_page' => 5,
		'category' => '3,10',
		'post_type' => 'post'
	);

	$news_posts = get_posts( $news_args );
	$project_posts = get_posts( $projects_args );

?>
<h3 style="border-bottom: 2px solid #CCC; padding: 10px; width: 300px">News 最新消息</h3>
<div id="index-news-block">
	<?php
        foreach( $news_posts as $index => $data ):
            echo '<a class="index-news-post" href="'.get_permalink( $data->ID ).'">';
            echo $data->post_title;
            echo '</a>';
        endforeach;
    ?>
</div>
<br />
<br />

<h3 style="border-bottom: 2px solid #CCC; padding: 10px; width: 300px">Project 最新專案</h3>
<div id="index-project-block">
	<?php
        foreach( $project_posts as $index => $data ):
            echo '<a class="index-project-post" href="'.get_permalink( $data->ID ).'">';
            echo $data->post_title;
            echo '</a>';
        endforeach;
    ?>
    <a class="index-project-post" style="text-align:right" href="<?=site_url()?>/projects">...查看更多</a>
</div>


</article>
<?php get_footer('simple') ?>