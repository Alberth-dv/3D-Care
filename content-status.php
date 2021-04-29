<?php
/**
 * @package quadro
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php the_content(); ?>	
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php quadro_posted_on(); ?>
		<?php edit_post_link( __( 'Edit', 'quadro' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->

</article><!-- #post-## -->
