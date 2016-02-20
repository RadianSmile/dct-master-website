<?php
/**
 * Bushwick functions and definitions.
 *
 * @package Bushwick
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'bushwick_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bushwick_setup() {

	/*
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Bushwick, use a find and replace to
	 * change 'bushwick' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'bushwick', get_template_directory() . '/languages' );

	/*
	 * Add default posts and comments RSS feed links to head.
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails', array( 'post' ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array(
		'fonts/genericons.css',
		'fonts/aleo.css',
		bushwick_fonts_url(),
		'editor-style.css',
	) );

	/*
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'bushwick' ),
	) );

	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif; // bushwick_setup
add_action( 'after_setup_theme', 'bushwick_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function bushwick_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'bushwick' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'bushwick_widgets_init' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Lato by default is localized. For languages that use characters
 * not supported by the font, the font can be disabled.
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function bushwick_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lato, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato: on or off', 'bushwick' ) ) {
		$fonts_url = add_query_arg( array(
			'family' => 'Lato:400,700,400italic,700italic,900',
			'subset' => 'latin,latin-ext',
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Loads our special font CSS file.
 *
 * To disable in a child theme, use wp_dequeue_style()
 * function mytheme_dequeue_fonts() {
 *     wp_dequeue_style( 'bushwick-fonts' );
 * }
 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
 *
 * @return void
 */
function bushwick_fonts() {
	$fonts_url = bushwick_fonts_url();
	if ( ! empty( $fonts_url ) ) {
		wp_enqueue_style( 'bushwick-lato', esc_url_raw( $fonts_url ), array(), null );
	}

	wp_enqueue_style( 'bushwick-aleo', get_template_directory_uri() . '/fonts/aleo.css', array(), '20130623' );
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '3.0.2' );
}
add_action( 'wp_enqueue_scripts', 'bushwick_fonts' );

/**
 * Enqueue scripts and styles
 */
function bushwick_scripts() {
	wp_enqueue_style( 'bushwick-style', get_stylesheet_uri() );

	wp_enqueue_script( 'bushwick-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery-masonry' ), '20130623', true );
	wp_localize_script( 'bushwick-functions', 'bushwick_functions_vars', array(
		'home_url' => user_trailingslashit( home_url() )
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'bushwick-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'bushwick_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
