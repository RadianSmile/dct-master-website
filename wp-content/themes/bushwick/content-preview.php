<?php
/**
 * @package Bushwick
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-preview' ); ?>>
	<?php the_title( '<header class="entry-header"><h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1></header><!-- .entry-header -->' ); ?>

	<div class="entry-permalink">
		<a class="more-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php _e( 'Read', 'bushwick' ); ?></a>
	</div><!-- .entry-permalink -->

	<footer class="entry-meta">
		<?php
			bushwick_posted_on();
			edit_post_link( __( 'Edit', 'bushwick' ), ' <span class="edit-link">', '</span>' );
		?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
