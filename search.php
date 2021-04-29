<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package quadro
 */

get_header(); ?>

	<div class="page-header page-header-default">
		<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'quadro' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		<?php if ( have_posts() ) quadro_breadcrumbs(); ?>
	</div>
	
	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php // We don't want to show modules, nor services, nor slides.
				if ( get_post_type() == 'quadro_mods' || get_post_type() == 'quadro_service' || get_post_type() == 'quadro_slide' ) continue; ?>

				<?php if ( get_post_type() != 'page' && get_post_type() != 'product' && get_post_type() != 'quadro_nym_portfolio' ) {
					// For regular posts
					echo '<div class="blog-item">';
					get_template_part( 'content' );
					echo '</div>';
				} elseif ( get_post_type() == 'product' ) {
					// For products
					echo '<div class="result-item-product clear">';
					get_template_part( 'content' );
					echo '</div>';
				} elseif ( get_post_type() == 'quadro_nym_portfolio' ) {
					// For portfolio items
					echo '<div class="result-item-portfolio clear">';
					get_template_part( 'content' );
					echo '</div>';
				} else {
					// For pages
					echo '<div class="result-item">';
					get_template_part( 'content' );
					echo '</div>';
				} ?>

			<?php endwhile; ?>

			<?php quadro_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'search' ); ?>

		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>