<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bushwick
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				get_template_part( 'navigation' );

				if ( have_posts() ) :
			?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							the_post();
							printf( __( 'Author: %s', 'bushwick' ), get_the_author() );
							rewind_posts();

						elseif ( is_day() ) :
							printf( __( 'Daily Archives: %s', 'bushwick' ), get_the_date() );

						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', 'bushwick' ), get_the_date( 'F Y' ) );

						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'bushwick' ), get_the_date( 'Y' ) );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'bushwick' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'bushwick');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'bushwick' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'bushwick' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'bushwick' );

						else :
							_e( 'Archives', 'bushwick' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->

			<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'content', 'preview' );
					endwhile;

					bushwick_paging_nav();

				else :
					get_template_part( 'content', 'none' );
				endif;
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer();
