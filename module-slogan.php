<?php
/**
 * The template used for displaying Slogan Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Get Slogan Module data
$slogan_text = wp_kses_post( get_post_meta( $mod_id, 'quadro_mod_slogan_text', true ) );
$slogan_text = $slogan_text != '' ? $slogan_text : get_the_content();
$action_text = esc_attr( get_post_meta( $mod_id, 'quadro_mod_slogan_action_text', true ) );
$action_link = esc_url( get_post_meta( $mod_id, 'quadro_mod_slogan_action_link', true ) );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-slogan <?php quadro_mod_parallax($mod_id); ?>">

	<?php quadro_mod_title( $mod_id ); ?>

	<?php $slogan_text = apply_filters( 'the_content', $slogan_text ); ?>
	<?php echo $slogan_text; ?>

	<?php if ( $action_text != '' ) { ?>
		<a href="<?php echo $action_link; ?>" title="<?php echo $action_text; ?>" class="slogan-call-to-action qbtn"><?php echo $action_text; ?></a>
	<?php } ?>

</section><!-- .module -->
