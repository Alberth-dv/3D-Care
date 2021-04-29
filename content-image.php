<?php
/**
 * @package quadro
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		
		<div class="entry-feat_content">
			<?php the_post_thumbnail( 'full', array('alt' => get_the_title(), 'title' => get_the_title()) ); ?>
		</div>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php quadro_posted_by(); ?>
		
		<?php the_content(); ?>
		
		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'quadro' ),
			'after'  => '</div>',
		) ); ?>

		<?php quadro_cats(); ?>
	
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php quadro_posted_on(); ?>
		<?php quadro_tags(); ?>
		<?php edit_post_link( __( 'Edit', 'quadro' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->

</article><!-- #post-## -->
