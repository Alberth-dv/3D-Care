<?php
/**
 * The template used for displaying Blog Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Get Blog Module Layout Style
$blog_layout = esc_attr( get_post_meta( $mod_id, 'quadro_mod_blog_layout', true ) );
$blog_columns = esc_attr( get_post_meta( $mod_id, 'quadro_mod_blog_columns', true ) );
$blog_sidebar = esc_attr( get_post_meta( $mod_id, 'quadro_mod_blog_sidebar', true ) );
$blog_perpage = esc_attr( get_post_meta( $mod_id, 'quadro_mod_blog_perpage', true ) );
$show_nav = esc_attr( get_post_meta( $mod_id, 'quadro_mod_blog_show_nav', true ) );
$blog_nav = esc_attr( get_post_meta( $mod_id, 'quadro_mod_blog_nav', true ) );
$blog_method = esc_attr( get_post_meta( $mod_id, 'quadro_mod_blog_method', true ) );
$blog_perpage = $blog_perpage != '' ? $blog_perpage : get_option( 'posts_per_page' );
$container_class = $blog_layout == 'grid' ? 'blog-masonry masonry-wrapper clear' : 'classic-blog-container';
$blog_layout_class = $blog_layout != 'teasers' ? $blog_layout : 'classic-blog teasers';
$blog_sidebar_class = $blog_sidebar == 'true' ? 'with-sidebar' : 'no-sidebar';

// Now, let's query for blog posts
global $paged;
$page_var = is_front_page() ? 'page' : 'paged';
$paged = (get_query_var($page_var)) ? get_query_var($page_var) : 1;
$args = array(
	'post_type' =>  'post',
	'posts_per_page' => $blog_perpage,
	'paged' => $paged,
 );

// Modify Query depending on the selected Show Method
if ( $blog_method == 'tax' ) {
	// Bring Selected Categories
	$blog_terms = esc_attr( get_post_meta( $mod_id, 'quadro_mod_blog_terms', true ) );
	if ( $blog_terms != '' ) {
		// Add tax query to query arguments
		$args['cat'] = $blog_terms;
	}
}

$wp_query = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-blog <?php echo $blog_layout_class; ?>-blog clear <?php quadro_mod_parallax($mod_id); ?> <?php echo $blog_columns; ?>-columns-blog <?php echo $blog_sidebar_class; ?>">
	<?php quadro_mod_title( $mod_id ); ?>
	<?php quadro_module_content(); ?>

	<?php if( $wp_query->have_posts() ) : ?>

		<div class="blog-container">

			<div class="<?php echo $container_class; ?>">
				
				<?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

					<div class="blog-item mas-item">
						<?php // get_template_part( 'content' ); ?>
						<?php // We call the template part with include to facilitate the use of data.
						include( locate_template('content.php') ); ?>
					</div>

				<?php endwhile; ?>

			</div>
			
			<?php if ( $show_nav == 'show' ) {
				// Implement Chosen Navigation Method
				if ( $blog_nav == 'ajax' ) { ?>
					<div class="ajax-navigation">
						<div class="posts-loader-icon" style="display: none;"><i class="fa fa-spinner fa-spin"></i></div>
						<h3 class="ajax-load-more" data-modid="<?php echo $mod_id; ?>" data-pagenmbr="1" data-function="quadro_load_more_posts"><?php _e('Load more', 'quadro') ?></h3>
						<h4 class="load-no-more"><?php _e('No more posts to load.', 'quadro'); ?></h4>
					</div>
				<?php } else {
					quadro_content_nav( 'nav-below' );
				} 
			} ?>

		</div>

	<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

	<?php endif; // ends 'posts' loop ?>
	
	<?php wp_reset_postdata(); ?>

	<?php if ( $blog_sidebar == 'true' ) {
		get_sidebar();
	} ?>

</section>