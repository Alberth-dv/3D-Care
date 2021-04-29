<?php
/**
 * Template Name: Page - Left Sidebar
 * The template for displaying all standard pages.
 * Note: Page styles function gets called in header.php
 */

get_header(); ?>

<?php
$page_id = get_the_ID();
// Get Page metadata
$header_style 	= esc_attr( get_post_meta( $page_id, 'quadro_page_header_style', true ) );
$header_style 	= $header_style != '' ? $header_style : 'default';
$header_align 	= $header_style == 'default' ? 'left' : esc_attr( get_post_meta( $page_id, 'quadro_page_header_align', true ) );
$header_img		= get_post_meta( $page_id, 'quadro_page_header_back_usepic', true ) == 'true' ? 'header-img' : '';
// Header tagline, only if not default style
if ( $header_style != 'default' ) {
	$use_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_show_tagline', true ) );
	$page_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_tagline', true ) );
}
?>

	<div class="page-header page-header-<?php echo $header_align; ?> page-header-<?php echo $header_style; ?> <?php echo $header_img; ?>">
		<h1 class="page-title"><?php the_title(); ?></h1>
		<?php if ( $header_style != 'default' && $use_tagline == 'true' ) { ?>
		<h2 class="page-tagline"><?php echo $page_tagline; ?></h2>
		<?php } ?>
		<?php quadro_breadcrumbs(); ?>
	</div><!-- .page-header -->

	<div id="primary" class="content-area">
		
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

<?php get_sidebar(); ?>
<?php get_footer(); ?>
