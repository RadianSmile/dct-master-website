<?php $themeDir = get_template_directory_uri() ?>
<!DOCTYPE html <?php language_attributes(); ?>>
<html lang="en">
    <head>
        <meta charset="<?php bloginfo('charset');?>">
        <title>
        <?php
        
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
		
		?>
        </title>
        <?php wp_head(); ?>
        <link rel="stylesheet" type="text/css" href="<?=$themeDir?>/css/bootstrap.css">
        <link rel="stylesheet" href="<?=$themeDir?>/css/layout.css">
        <link rel="stylesheet" href="<?=$themeDir?>/css/rwd.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="<?=$themeDir?>/js/bootstrap.js"></script>
        
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    	<link rel="icon" type="image/ico" href="<?=$themeDir.'/images/dicon.png'?>">	
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
    <body id="">
        <div class="wrap">
            <nav class="navbar navbar-inverse navbar-fixed-top ">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?=site_url()?>">
                            <img src="<?=$themeDir?>/img/logo_naviRight_03.png" height="34" width="99" alt="">
                        </a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <!--<ul class="nav navbar-nav navbar-right"> -->
                            <!-- <li class="GF"></li> -->

                            <?php
							
								$navArgs = array(
									'theme_location' => 'primary-menu',
									'menu_class' => 'index',
                                    'container' => '',
									'items_wrap' => '<ul class="nav navbar-nav navbar-right">%3$s</ul>'
								)
							
							
							?>
                            <?php wp_nav_menu( $navArgs ); ?>
                            
                            
                            
                            
                            <!-- <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </li> -->
                        <!-- </ul> -->
                        <div class="GF"></div>
                        </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                    <!-- /navi -->
                    <!-- =================CONTENT================= -->