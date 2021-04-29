<?php
/**
 * Template Name: Contact Page
 * The template for displaying all contact pages.
 * Note: Page styles function gets called in header.php
 */

get_header(); ?>

<?php
$page_id = get_the_ID();
// Get Page metadata
$map_address 	= esc_attr( get_post_meta( $page_id, 'quadro_contact_map', true ) );
$sidebar_style 	= esc_attr( get_post_meta( $page_id, 'quadro_contact_sidebar', true ) );
$header_img		= get_post_meta( $page_id, 'quadro_page_header_back_usepic', true ) == 'true' ? 'header-img' : '';
$header_style 	= esc_attr( get_post_meta( $page_id, 'quadro_page_header_style', true ) );
$header_style 	= $header_style != '' ? $header_style : 'default';
$header_align 	= $header_style == 'default' ? 'left' : esc_attr( get_post_meta( $page_id, 'quadro_page_header_align', true ) );
// Header tagline, only if not default style
if ( $header_style != 'default' ) {
	$use_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_show_tagline', true ) );
	$page_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_tagline', true ) );
}

?>

	<div class="page-header contact-header page-header-<?php echo $header_align; ?> page-header-<?php echo $header_style; ?> <?php echo $header_img; ?>">
		<h1 class="page-title"><?php the_title(); ?></h1>
		<?php if ( $header_style != 'default' && $use_tagline == 'true' ) { ?>
		<h2 class="page-tagline"><?php echo $page_tagline; ?></h2>
		<?php } ?>
		<?php quadro_breadcrumbs(); ?>
	</div><!-- .page-header -->

	<?php if ( $map_address != '' ) { ?>
	<div class="contact-map">
		<div id="google-map-iframe" class="google-map-contact"></div>
		<script>
			jQuery(document).ready(function(){ 
				jQuery('.google-map-contact').gmap3({
					marker:{
						address: "<?php echo esc_attr( $map_address ); ?>",
					},
					map:{
						options:{
							zoom: 14,
							scrollwheel: false,
						}
					}
				});
			});
		</script>
	</div>
	<?php } ?>

	<?php if ( $sidebar_style == 'left' ) get_sidebar(); ?>

	<div id="primary" class="content-area sidebar-<?php echo $sidebar_style; ?>">
		
		<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->

	</div><!-- #primary -->

<?php if ( $sidebar_style == 'right' ) get_sidebar(); ?>
<?php get_footer(); ?>
