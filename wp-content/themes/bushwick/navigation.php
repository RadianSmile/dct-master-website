<?php
/**
 * The template for the site navigation.
 *
 * @package Bushwick
 */
?>
<nav id="site-navigation" class="navigation-main" role="navigation">
	<h1 class="menu-toggle genericon"></h1>
	<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'bushwick' ); ?>"><?php _e( 'Skip to content', 'bushwick' ); ?></a></div>

	<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	<a class="widget-handle genericon" href="#"></a>
</nav><!-- #site-navigation -->
