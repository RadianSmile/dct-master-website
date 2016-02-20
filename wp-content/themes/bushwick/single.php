<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Bushwick
 */
get_template_part( 'navigation' );
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				

				while ( have_posts() ) :
					the_post();

				get_template_part( 'content', 'single' );	

					

				endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
