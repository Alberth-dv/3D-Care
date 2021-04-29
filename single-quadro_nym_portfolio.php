<?php
/**
 * The Template for displaying Portfolio type (quadro_nym_portfolio) single posts.
 */

get_header(); ?>

	<div id="primary" class="content-area">
		
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php quadro_single_portfolio_item( get_the_id() ); ?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
		
	</div><!-- #primary -->

<?php get_footer(); ?>