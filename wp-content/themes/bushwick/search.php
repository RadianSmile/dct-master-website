<?php
/**
 * The template for displaying Search Results pages.
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
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'bushwick' ), get_search_query() ); ?></h1>
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

<?php
get_sidebar();
get_footer();
