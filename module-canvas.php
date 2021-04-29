<?php
/**
 * The template used for displaying Canvas Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-canvas <?php quadro_mod_parallax($mod_id); ?>">
	
	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content canvas-content">

		<?php the_content(); ?>

	</div><!-- .mod-content -->

</section><!-- .home-module -->
