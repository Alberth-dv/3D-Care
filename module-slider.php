<?php
/**
 * The template used for displaying Slider Modules content
 *
 */
?>

<?php
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

$slider_style 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slider_style', true ) );
$caption_style 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_caption_style', true ) );
$slider_time 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slider_time', true ) );

// Now, let's get all the slides
$args = array(
	'post_type' =>  'quadro_slide',
	'posts_per_page' => -1
 );
// Bring picked posts if there are some
$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_slides_show', $args );
$quadro_slides = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod slider-<?php echo $slider_style; ?> type-slider clear <?php quadro_mod_parallax($mod_id); ?>">
	
	<input type="hidden" id="slider-time" value="<?php echo $slider_time; ?>">

	<ul class="quadro-slides slides">
		
		<?php if( $quadro_slides->have_posts() ) : while( $quadro_slides->have_posts() ) : $quadro_slides->the_post(); ?>

			<?php
			// Get options for this slide
			$slide_id 		= get_the_ID();
			$show_title 	= get_post_meta( $slide_id, 'quadro_show_slide_title', true );
			$caption_link 	= esc_url( get_post_meta( $slide_id, 'quadro_caption_link', true ) );
			$caption_anchor = esc_attr( get_post_meta( $slide_id, 'quadro_caption_anchor', true ) );
			$caption_pos 	= esc_attr( get_post_meta( $slide_id, 'quadro_caption_position', true ) );
			$caption_back 	= esc_attr( get_post_meta( $slide_id, 'quadro_caption_background', true ) );
			$caption_styles = $caption_back != '#' && $caption_style == 'drop' ? 'background-color: ' . $caption_back . '"' : '';
			$caption_styles_in = $caption_back != '#' && $caption_style == 'striped' ? 'style="background-color: ' . $caption_back . '"' : '';
			?>

			<li class="quadro-slide <?php echo $caption_style; ?>-slide" data-back="<?php echo $caption_back; ?>">
				<?php the_post_thumbnail( 'slider-' . $slider_style, array('alt' => '' . get_the_title() . '', 'title' => '') ); ?>
				<div class="slide-caption <?php echo $caption_pos . ' ' . $caption_style; ?>-caption" <?php echo $caption_styles; ?>>
					<?php if ( $caption_link != '' ) { ?>
						<a href="<?php echo $caption_link; ?>" class="slider-caption-link" title="<?php echo get_the_title(); ?>">
					<?php } ?>
					<?php if ( $show_title == 'true') { ?>
						<h3 <?php echo $caption_styles_in; ?>><?php the_title(); ?></h3>
					<?php } ?>
					<?php if ( get_the_content() != '' ) { ?>
					<div class="caption-text" <?php echo $caption_styles_in; ?>><?php the_content(); ?></div>
					<?php } ?>
					<?php if ( $caption_anchor != '' ) { ?>
						<span class="slider-caption-rmore" <?php echo $caption_styles_in; ?>><?php echo $caption_anchor; ?></span>
					<?php } ?>
					<?php if ( $caption_link != '' ) { ?>
						</a>
					<?php } ?>
				</div>
			</li>

		<?php endwhile; endif; // ends 'quadro_slide' loop ?>
		<?php wp_reset_postdata(); ?>

	</ul>

</section>
