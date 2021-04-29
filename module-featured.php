<?php
/**
 * The template used for displaying Featured Post Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Get Featured Post Module Layout Style
$feat_layout = esc_attr( get_post_meta( $mod_id, 'quadro_mod_featured_style', true ) );
$text_color = esc_attr( get_post_meta( $mod_id, 'quadro_mod_featured_color', true ) );
$feat_thumb = $feat_layout == 'type1' ? 'fullwidth-thumb' : 'portfolio-grid-two';

// Now, let's get the Featured post (it can be a regular post or a Portfolio post)
$args = array(
	'post_type' => array( 'post', 'quadro_nym_portfolio' ),
	'posts_per_page' => 1
);

// Bring the picked post if there is one
$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_pick_featured', $args );

$home_featured = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-featured <?php quadro_mod_parallax($mod_id); ?>">
	
	<?php quadro_mod_title( $mod_id ); ?>

	<?php if( $home_featured->have_posts() ) : while( $home_featured->have_posts() ) : $home_featured->the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('featured-item clear feat-' . $feat_layout); ?>>

			<div class="feat-post-img">
				<?php // Loop through post formats possibilities
				$post_format = get_post_format();
				switch ( $post_format ) {
					
					case 'video':
						$media_return = quadro_print_media(get_the_content(), array('video', 'iframe', 'embed'), 1, '', '');
						echo $media_return['media'];	
						break;

					case 'audio':
						$media_return = quadro_print_media(get_the_content(), array('audio', 'iframe', 'embed'), 1, '', '');
						echo $media_return['media'];	
						break;

					case 'gallery':
						if ( get_post_gallery() ) {
							// Remove Galleries from content
							$content = quadro_strip_shortcode_gallery( get_the_content() );
							// Filter through the_content filter
							$content = apply_filters( 'the_content', $content );
							$content = str_replace( ']]>', ']]&gt;', $content );
							echo '<div class="entry-gallery">';
							echo '<ul class="slides">';
							$gallery = get_post_gallery( get_the_ID(), false );
							/* Loop through all images and output them one by one */
							$gallery_ids = explode(',', $gallery['ids']);
							foreach( $gallery_ids as $pic_id ) {
								echo '<li class="gallery-item">';
								echo wp_get_attachment_image( $pic_id, $feat_thumb );
								echo ( get_post($pic_id) && get_post($pic_id)->post_excerpt != '' ) ? '<p class="gallery-caption">' . get_post($pic_id)->post_excerpt . '</p>' : '';
								echo '</li>';
							}
							echo '</ul></div>';
						} else {
							$content = get_the_content();
						}
						break;

					default:
						the_post_thumbnail( $feat_thumb, array('alt' => '' . get_the_title() . '', 'title' => '') );
						break;
				} ?>
			</div>
			
			<div class="featured-item-content" style="color: <?php echo $text_color; ?>">
				<h2 class="feat-item-title" style="color: <?php echo $text_color; ?>">
					<a href="<?php the_permalink(); ?>" title="<?php get_the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</h2>
				<div class="feat-meta">
					<div class="post-icon-wrapper">
						<span class="post-icon"></span>
					</div>
					<?php quadro_cats(); ?>
				</div>
				<div class="featured-item-text" style="color: <?php echo $text_color; ?>">
					<?php // Display the content according to what we did before with it.
					if ( $post_format == 'video' || $post_format == 'audio' ) echo quadro_excerpt($media_return['content'], 40, '<span class="read-more">' . __('Read more', 'quadro') . '</span><i class="fa fa-chevron-right"></i>');
					elseif ( $post_format == 'gallery' && get_post_gallery() ) echo quadro_excerpt($content, 40, '<span class="read-more">' . __('Read more', 'quadro') . '</span><i class="fa fa-chevron-right"></i>');
					else quadro_excerpt(get_the_excerpt(), 40, '<span class="read-more">' . __('Read more', 'quadro') . '</span><i class="fa fa-chevron-right"></i>');
					?>
				</div>
			</div>
		
		</article>

	<?php endwhile; endif; // ends Featured loop ?>
	<?php wp_reset_postdata(); ?>

</section>