<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package quadro
 */

get_header(); ?>

<?php // Retrieve Theme Options
global $quadro_options; ?>

	<header class="page-header page-header-default">
		<h1 class="page-title">
			<?php // Output WPML translations if there are set
			if ( function_exists('icl_t') ) {
				echo icl_t('Nayma WordPress Theme', '404 Page Title', $quadro_options['404_title'] );
			} else {
				echo esc_attr( $quadro_options['404_title'] ); 
			} ?>
		</h1>
	</header><!-- .page-header -->

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<section class="error-404 not-found">
				<div class="page-content">
					
					<div class="error-404-text">
					<?php // Output WPML translations if there are set
					if ( function_exists('icl_t') ) {
						echo icl_t('Nayma WordPress Theme', '404 Page Text', $quadro_options['404_text'] );
					} else {
						echo strip_tags( $quadro_options['404_text'], '<div><img><p><span><a><br><strong><em><i><bold><small>' );
					} ?>
					</div>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>