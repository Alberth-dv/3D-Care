<?php
/*
Template Name: Portfolio Page
*/

get_header(); ?>

<?php
$page_id = get_the_ID();
// Get Page metadata
$hide_header 		= esc_attr( get_post_meta( $page_id, 'quadro_portf_header_hide', true ) );
$hide_header_class 	= $hide_header == 'true' ? ' header-hide' : ' no-header-hide';
$header_align 		= 'none';
// Bring Header meta styles only if we are showing it
if ( $hide_header != 'true' ) {
	$header_style 	= esc_attr( get_post_meta( $page_id, 'quadro_page_header_style', true ) );
	$header_style 	= $header_style != '' ? $header_style : 'default';
	$header_img		= get_post_meta( $page_id, 'quadro_page_header_back_usepic', true ) == 'true' ? 'header-img' : '';
	if ( $header_style != 'default' ) {
		$header_align 	= $header_style == 'default' ? 'left' : esc_attr( get_post_meta( $page_id, 'quadro_page_header_align', true ) );
		$use_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_show_tagline', true ) );
		$page_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_tagline', true ) );
	}
}
?>

	<?php if ( $hide_header != 'true' ) { ?>
	<div class="page-header page-header-<?php echo $header_align; ?> page-header-<?php echo $header_style; ?> <?php echo $header_img; ?>">
		<h1 class="page-title"><?php the_title(); ?></h1>
		<?php if ( $header_style != 'default' && $use_tagline == 'true' ) { ?>
		<h2 class="page-tagline"><?php echo $page_tagline; ?></h2>
		<?php } ?>
		<?php quadro_breadcrumbs(); ?>
	</div><!-- .page-header -->
	<?php } ?>

	<div id="primary" class="modular-wrapper">
		
		<div id="content" class="modular-modules <?php echo $hide_header_class; ?>" role="main">

			<?php // Begin regular page loop to bring the_content
			while ( have_posts() ) : the_post();
				the_content();
			endwhile; // end of the loop. ?>

			<?php // Query for the selected Portfolio Modules
			$args = array(
				'post_type' =>  'quadro_mods',
				'posts_per_page' => -1,
			);
			// Bring picked portfolio modules if there are some
			$args = quadro_add_selected_posts( get_the_ID(), 'quadro_mod_portfolio_modules', $args );
			$portf_mods = new WP_Query( $args );
			?>
			
			<?php if( $portf_mods->have_posts() ) : while( $portf_mods->have_posts() ) : $portf_mods->the_post(); ?>
		
				<?php // We already know is a Portfolio, so we can call the template for it
				get_template_part( 'module', 'portfolio' )?>
			
			<?php endwhile; endif; // ends 'quadro_mods' loop ?>
			<?php wp_reset_postdata(); ?>

		</div><!-- #content -->
		
	</div><!-- #primary -->

<?php get_footer(); ?>