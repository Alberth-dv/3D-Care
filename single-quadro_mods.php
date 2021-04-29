<?php
/**
 * The Template for displaying single modular post (just for playing nice, they
 * are not supposed to be accessed individually).
 */

get_header(); ?>

	<div id="primary" class="modular-wrapper">
		
		<div id="content" class="modular-modules" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php // Retrieve Module type
			$mod_type = esc_attr( get_post_meta( get_the_ID(), 'quadro_mod_type', true ) ); ?>
			<?php // and call the template for it
			get_template_part( 'module', $mod_type ); ?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
		
	</div><!-- #primary -->

<?php get_footer(); ?>