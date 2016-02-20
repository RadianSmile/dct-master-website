<?php
/**
 * The template for displaying search forms in Bushwick.
 *
 * @package Bushwick
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'bushwick' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'bushwick' ); ?>" value="<?php the_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'bushwick' ); ?>" />
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'bushwick' ); ?>" />
</form>
