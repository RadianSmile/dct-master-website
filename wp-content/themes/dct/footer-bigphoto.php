</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/jquery.preload.min.js"></script>
<script type="text/javascript">

var leftBg = $("#bigphoto-image");
var rightContent = $("#main-content");

var imgUrls = new Array();
var imgModes = new Array();
var imgPositions = new Array();

var indexNowShow = 0;
	
	function getPhotosFromContent()
	{
		// 把文章中的圖片抓起來，並設定錨點
		rightContent.find( "img, iframe" ).each(function(index, element)
		{
				if( $(element).is( 'img' ) )
				{
					var fileName = $(element).attr( "src" );
					
					// 把後面的 size 大小取消掉，便於使用者編輯
					var strToReplace = fileName.match(/\-\d*x\d*\./); // 搜尋 -nnnxnnn.
					
					if( strToReplace != null )
						fileName = fileName.replace( strToReplace, '.' );
					
					// 查看 image 的 class，並設定 cover mode / contain mode
					if( $(element).hasClass('mode-full') )
						imgModes.push( 'cover' );
					else
						imgModes.push( 'contain' );
					
					imgPositions.push( $(element).offset() );
					imgUrls.push( fileName );
					$(element).remove();
				}
				else if( $(element).is('iframe') ) // for youtube / vimeo videos
				{
					// todo
				}
        });
		
		// preload images for best experience
		$.preload( imgUrls );
		
		// set the first image
		leftBg.css("background-image", "url('" + imgUrls[0] + "')" );
		leftBg.css("background-size", imgModes[0] );
		
		// activate scroll change image
		$(window).scroll( onScroll );
		console.log( imgPositions );
		console.log( imgUrls );
	}
	
	// setting function for one photo purpose ( ex pages, authors )
	function setBigPhoto( imageUrl )
	{
		leftBg.css("background-image", "url('" + imageUrl + "')" );
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
			// change scale also! may need to fix that
			leftBg.css("background-image", "url('" + imgUrls[indexSwitchTo] + "')" );
			leftBg.css("background-size", imgModes[indexSwitchTo] );
			indexNowShow = indexSwitchTo;
			console.log( "switch !" );
		}
	}
</script>
<?php get_footer() ?>