<?php get_header() ?>
	<div id="single-image">
    </div>
    
    <?php
		// 預設抓取現在頁面的 post
		$thePost = get_post();
		
	?>
	<div id="single-content">
        
        <article>
        <?= apply_filters( 'the_content', $thePost->post_content ) ?>
        </article>
	
    </div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/jquery.preload.min.js"></script>
<script type="text/javascript">

var leftBg = $("#single-image");
var rightContent = $("#single-content");

var imgUrls = new Array();
var imgPositions = new Array();

var indexNowShow = 0;
	
	window.onload = function ()
	{	
	
		// 把文章中的圖片抓起來，並設定錨點
		rightContent.find( "img" ).each(function(index, element)
		{		
				var fileName = $(element).attr( "src" );
				
				// 把後面的 size 大小取消掉，便於使用者編輯
				var strToReplace = fileName.match(/\-\d*x\d*\./); // 搜尋 -nnnxnnn.
				
				if( strToReplace != null )
					fileName = fileName.replace( strToReplace, '.' );
				
				imgPositions.push( $(element).offset() );
				imgUrls.push( fileName );
				$(element).remove();	
        });
		
		// preload images for best experience
		$.preload( imgUrls );
		
		// set the first image
		leftBg.css("background-image", "url('" + imgUrls[0] + "')" );
		
		$(window).scroll( onScroll );
		console.log( imgPositions );
		console.log( imgUrls );
	}
	
	function onScroll( e )
	{
		var scrollY = $( window ).scrollTop();
		var indexSwitchTo = 0;


		for( var i=0; i< imgPositions.length; i++ )
		{
			// -300 是為了讓教後面的圖片不會看不到
			if( scrollY >= imgPositions[i].top - 300 )
				indexSwitchTo = i;
		}
		
		// only trigger if photo change
		if( indexNowShow != indexSwitchTo )
		{
			leftBg.css("background-image", "url('" + imgUrls[indexSwitchTo] + "')" );
			indexNowShow = indexSwitchTo;
			console.log( "switch !" );
		}
	}
</script>
<?php get_footer() ?>