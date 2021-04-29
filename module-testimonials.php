<?php
/**
 * The template used for displaying Testimonials Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Get Testimonials Module data
$testimonials = get_post_meta( $mod_id, 'quadro_mod_testimonial_content', true );
$testimonial_style = esc_attr( get_post_meta( $mod_id, 'quadro_mod_testimonial_style', true ) );
$text_color = esc_attr( get_post_meta( $mod_id, 'quadro_mod_testimonial_color', true ) );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-testimonials <?php quadro_mod_parallax($mod_id); ?>">

	<?php quadro_mod_title( $mod_id ); ?>
	<?php quadro_module_content(); ?>

	<?php if ( !empty($testimonials) ) { ?>
		
		<div class="testimonials-wrapper">

			<div class="testimonials-<?php echo $testimonial_style; ?>">

				<ul class="testimonials slides clear">

					<?php foreach ($testimonials as $testimonial) { ?>
					
						<li class="testimonial-item">
							<div class="testimonial-item-wrapper">
								<div class="testimonial-item-content" style="color: <?php echo $text_color; ?>">
									<?php $content = isset($testimonial['Content']) ? esc_attr( $testimonial['Content'] ) : '';
									if ( $content != '' ) echo '<p>' . $content . '</p>'; ?>
									<span>
										<?php $url = isset($testimonial['Link']) ? esc_url( $testimonial['Link'] ) : ''; ?>
										<?php if ( $url != '' ) echo '<a href="' . $url . '">'; ?>
										<?php $author = isset($testimonial['Author']) ? esc_attr( $testimonial['Author'] ) : '';
										if ( $author != '' ) echo $author; ?>
										<?php if ( $url != '' ) echo '</a>'; ?>
									</span>
								</div>
							</div>
						</li>

					<?php } ?>

				</ul>

			</div>

		</div><!-- .testimonials-wrapper -->

	<?php } ?>

</section><!-- .module -->
