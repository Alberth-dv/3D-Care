<?php
/**
 * @package quadro
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		
		<div class="entry-feat_content">
			
			<?php 
			// Commented code should be replaced one the issue with Visual Composer gets solved
			// if ( get_post_gallery(get_the_ID()) ) {
			$content = get_the_content();
			preg_match_all( '/\[gallery.*ids=[^\]]+\.*]/', $content, $galleries, PREG_SET_ORDER );
			if ( !empty($galleries) ) {
				// $gallery = get_post_gallery( get_the_ID(), false );
				// if ( isset($gallery['ids']) ) {
					// Remove Galleries from content
					// $content = quadro_strip_shortcode_gallery( get_the_content() );
					$content = preg_replace('/\[gallery.*ids=[^\]]+\.*]/', '',  $content );

					echo '<div class="entry-gallery">';
					echo '<ul class="slides">';
					/* Loop through all images and output them one by one */
					// $gallery_ids = explode(',', $gallery['ids']);
					$gallery_ids = explode( ',', quadro_get_string_between($galleries[0][0], 'ids="', '"') );
					foreach( $gallery_ids as $pic_id ) {
						echo '<li class="gallery-item">';
						echo wp_get_attachment_image( $pic_id, 'portfolio-masonry-two' );
						echo ( get_post($pic_id) && get_post($pic_id)->post_excerpt != '' ) ? '<p class="gallery-caption">' . get_post($pic_id)->post_excerpt . '</p>' : '';
						echo '</li>';
					}
					echo '</ul></div>';
				// } else {
					// Leave content intact if no ids for gallery (old gallery versions)
					// $content = get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'quadro' ) );
				// }
			} else {
				the_post_thumbnail( 'slider-regular', array('alt' => get_the_title(), 'title' => get_the_title()) );
				// Leave content intact if no galleries inside
				$content = get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'quadro' ) );
			} ?>
		
		</div>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php quadro_posted_by(); ?>
		
		<?php // Filter through the_content filter
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		echo $content; ?>
		
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
