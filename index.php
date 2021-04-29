<?php
/**
 * The main template file.
 *
 * @package quadro
 */

get_header(); ?>

	<div id="primary" class="content-area index-template-file">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php echo '<div class="blog-item">';
				get_template_part( 'content' );
				echo '</div>'; ?>

			<?php endwhile; ?>

			<?php quadro_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>