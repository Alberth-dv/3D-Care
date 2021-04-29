<?php
/*
Template Name: Modules Constructor
*/

get_header(); ?>

<?php
$page_id = get_the_ID();
// Get Page metadata
$hide_header 		= esc_attr( get_post_meta( $page_id, 'quadro_page_header_hide', true ) );
$hide_header_class 	= $hide_header == 'true' ? ' header-hide' : ' no-header-hide';
$header_align 		= 'none';
// Bring Header meta styles only if we are showing it
if ( $hide_header != 'true' ) {
	$header_img		= get_post_meta( $page_id, 'quadro_page_header_back_usepic', true ) == 'true' ? 'header-img' : '';
	$header_style 	= esc_attr( get_post_meta( $page_id, 'quadro_page_header_style', true ) );
	$header_style 	= $header_style != '' ? $header_style : 'default';
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

			<?php // Call Transients Fragment Cache
			qi_fragment_cache( 'modpage' . get_the_ID(), 7 * DAY_IN_SECONDS, function() {

				// Query for the Modular Template Modules
				$args = array(
					'post_type' =>  'quadro_mods',
					'posts_per_page' => -1,
				);
				// Bring picked posts if there are some
				$args = quadro_add_selected_posts( get_the_ID(), 'quadro_mod_temp_modules', $args );
				$quadro_mods = new WP_Query( $args );
			
				if( $quadro_mods->have_posts() ) : while( $quadro_mods->have_posts() ) : $quadro_mods->the_post();
			
					// Retrieve Module type
					$mod_type = esc_attr( get_post_meta( get_the_ID(), 'quadro_mod_type', true ) );
					// and call the template for it
					get_template_part( 'module', $mod_type );
				
				endwhile; endif; // ends 'quadro_mods' loop
				wp_reset_postdata();

			}); ?>

		</div><!-- #content -->
		
	</div><!-- #primary -->

<?php get_footer(); ?>