<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

				<div class="entry-content">
					<?php
						the_content();
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'bushwick' ),
							'after'  => '</div>',
						) );
					?>
				</div><!-- .entry-content -->
				<?php edit_post_link( __( 'Edit', 'bushwick' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
			</article><!-- #post-## -->

			<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
