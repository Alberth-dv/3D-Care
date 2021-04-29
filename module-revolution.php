<?php
/**
 * The template used for displaying Revolution Slider Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Get Revolution Slider Shortcode
$slider_shortcode = esc_attr( get_post_meta( $mod_id, 'quadro_mod_revolution_shortcode', true ) );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-rev-slider <?php quadro_mod_parallax($mod_id); ?>">

	<?php quadro_mod_title( $mod_id ); ?>
	<?php echo do_shortcode( $slider_shortcode ); ?>

</section><!-- .module -->
