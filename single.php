<?php
/**
 * The Template for displaying all single posts.
 *
 * @package quadro
 */

get_header(); ?>

	<div id="primary" class="content-area">
		
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php $post_format = get_post_format() != '' ? get_post_format() : 'single' ; ?>
			<?php get_template_part( 'content', $post_format ); ?>

			<?php quadro_content_nav( 'nav-below' ); ?>

			<?php // If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() ) comments_template(); ?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
		
	</div><!-- #primary -->

<?php $single_sidebar = esc_attr( $quadro_options['single_sidebar'] );
if ( $single_sidebar == 'sidebar') get_sidebar(); ?>
<?php get_footer(); ?>