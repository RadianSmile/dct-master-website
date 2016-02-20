<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset');?>" />

	<title><?php
	if (is_home())
	{
    	bloginfo('name');
        echo ' - ';
        bloginfo('description');
    }
	else
	{
		wp_title(' - ', true, 'right');
		bloginfo('name');
	} 
?></title>
<?php wp_head(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link href="<?php bloginfo('template_directory') ?>/style.css" media="screen" rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/ico" href="<?=get_template_directory_uri().'/images/dicon.png'?>">
<!-- GA for 140.119.162.60, temp use 							-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55315180-1', 'auto');
  ga('require', 'linkid', 'linkid.js');
  ga('send', 'pageview');

</script>
</head>

<body>

	<nav>
    <a href="<?=site_url()?>">
    	<img style="border:none" src="<?php bloginfo('template_directory') ?>/images/dct.png" />
    </a>
		<?php wp_nav_menu( array( 'theme_location' => 'primary-menu' ) ); ?>
    </nav>
	
	<div class="container">