<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Bushwick
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function bushwick_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'primary',
		'render'    => 'bushwick_render_content',
	) );
}
add_action( 'after_setup_theme', 'bushwick_jetpack_setup' );

function bushwick_render_content() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'content', 'preview' );
	}
}
