<?php
/**
 * Sample implementation of the Custom Header feature.
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Bushwick
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses bushwick_header_style()
 * @uses bushwick_admin_header_style()
 * @uses bushwick_admin_header_image()
 *
 * @package Bushwick
 */
function bushwick_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'bushwick_custom_header_args', array(
		'default-image'          => '%s/img/default-header.jpg',
		'default-text-color'     => 'fff',
		'width'                  => 900,
		'height'                 => 1600,
		'flex-height'            => true,
		'flex-width'             => true,
		'wp-head-callback'       => 'bushwick_header_style',
		'admin-head-callback'    => 'bushwick_admin_header_style',
		'admin-preview-callback' => 'bushwick_admin_header_image',
	) ) );

	add_action( 'admin_print_styles-appearance_page_custom-header', 'bushwick_fonts' );
}
add_action( 'after_setup_theme', 'bushwick_custom_header_setup' );

if ( ! function_exists( 'bushwick_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see bushwick_custom_header_setup().
 */
function bushwick_header_style() {
	$header_image = get_header_image();
	$text_color   = get_header_textcolor();

	if ( is_single() ) {
		$attachment   = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		$header_image = empty( $attachment[0] ) ? $header_image : $attachment[0];
	}

	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css">
	<?php if ( ! empty( $header_image ) ) : ?>
		.site-header {
			background: rgba(51, 71, 61, 0.05) url(<?php echo esc_url( $header_image ); ?>) no-repeat scroll center;
			background-size: cover;
		}
	<?php
		endif;

		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.site-header .site-title,
		.site-header .site-description {
			color: #<?php echo $text_color; ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;

if ( ! function_exists( 'bushwick_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see bushwick_custom_header_setup().
 */
function bushwick_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		background: url("<?php header_image(); ?>") no-repeat scroll center center rgba(51, 71, 61, 0.05);
		background-size: cover;
		height: <?php echo get_custom_header()->height; ?>px;
		-webkit-hyphens: auto;
		-moz-hyphens:    auto;
		-ms-hyphens:     auto;
		hyphens:         auto;
		max-height: 1000px;
		max-width: 750px;
		min-height: 850px;
		min-width: 510px;
		position: relative;
		-ms-word-wrap: break-word;
		word-wrap:     break-word;
		width: <?php echo get_custom_header()->width; ?>px;
	}

	.site-branding {
		border: none;
		bottom: 3.5em;
		left: 5%;
		padding: 1.5em;
		position: absolute;
	}
	#headimg h1 a,
	#desc {
		color: #fff;
		text-decoration: none;
		text-shadow: 0 1px 5px rgba(0, 0, 0, 0.3);
	}
	#headimg h1 {
		font: 700 66px/1 "Aleo","Skolar","ff-tisa-web-pro","Georgia",serif;
		margin: 0 0 0.5em;
	}
	#desc {
		font: 400 20px/1.5 "Lato","proxima-nova","Helvetica Neue Light","Helvetica Neue","Helvetica","Arial",sans-serif;
		margin-bottom: 1.5em;
	}
	</style>
<?php
}
endif;

if ( ! function_exists( 'bushwick_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see bushwick_custom_header_setup().
 */
function bushwick_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
?>
	<div id="headimg">
		<div class="site-branding">
			<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		</div>
	</div>
<?php
}
endif;
