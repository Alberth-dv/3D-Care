<?php
/**
 * The template used for displaying Crelly Slider Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Get Crelly Slider Shortcode
$slider_shortcode = get_post_meta( $mod_id, 'quadro_mod_crelly_shortcode', true );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-crelly-slider <?php quadro_mod_parallax($mod_id); ?>">

	<?php quadro_mod_title( $mod_id ); ?>
	<?php echo do_shortcode( $slider_shortcode ); ?>

</section><!-- .module -->
