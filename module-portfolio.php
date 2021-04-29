<?php
/**
 * The template used for displaying Portfolio Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Get Portfolio Module Layout Style and Posts list
$portfolio_style = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_style', true ) );
$portfolio_layout = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_layout', true ) );
$portfolio_columns = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_columns', true ) );
$loading_method = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_loading', true ) );
$reveal_data = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_show_data', true ) );
$show_filters = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_filter', true ) );
$filter_terms = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_filter_terms', true ) );
$picker_method = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_method', true ) );
$items_perpage = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_perpage', true ) );
$show_nav = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_show_nav', true ) );
$portfolio_nav = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_nav', true ) );
$items_perpage = $items_perpage != '' ? $items_perpage : -1;

// Now, let's query
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
	'post_type' =>  'quadro_nym_portfolio',
	'posts_per_page' => $items_perpage,
	'paged' => $paged
 );

// Modify Query depending on the selected Show Method
if ( $picker_method == 'all' ) {
	$args['orderby'] = 'menu_order';
	$args['order'] = 'DESC';
}
elseif ( $picker_method == 'tax' ) {
	// Bring Selected Categories
	$selected_terms = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_terms', true ) );
	if ( $selected_terms != '' ) {
		$selected_terms = explode( ', ', $selected_terms );
		// Add tax query to query arguments
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'portfolio_tax',
				'field' => 'id',
				'terms' => $selected_terms
			),
		);
		$args['orderby'] = 'menu_order';
		$args['order'] = 'ASC';
	}
}
elseif ( $picker_method == 'custom' ) {
	// Bring Selected Items
	$selected_items = esc_attr( get_post_meta( $mod_id, 'quadro_mod_portfolio_picker', true ) );
	$selected_items = explode(',', $selected_items);
	// Bring picked posts if there are some
	$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_portfolio_picker', $args );
}

$wp_query = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-portfolio portfolio-<?php echo $portfolio_style; ?> portfolio-layout-<?php echo $portfolio_layout; ?> <?php echo $portfolio_columns; ?>-columns loading-<?php echo $loading_method; ?> <?php quadro_mod_parallax($mod_id); ?>">
	
	<?php quadro_mod_title( $mod_id ); ?>
	<?php quadro_module_content(); ?>

	<?php if ( $loading_method == 'ajax' ) {
		echo '<div class="loader-icon" style="display: none;"><i class="fa fa-spinner fa-spin"></i></div>';
		echo '<div class="item-wrapper"><div class="item-container clear"></div></div>';
	} ?>

	<?php if ( $show_filters == 'show' ) { ?>
	<div class="terms-filter">
		<?php if ( $filter_terms != '' ) {
			$filter_terms = explode(', ', rtrim($filter_terms, ', '));
			if ( count($filter_terms) > 1 ) {
				echo '<ul class="filter-terms">';
				echo '<li data-id="all">' . __('All', 'quadro') . '</li>';
				foreach ($filter_terms as $filter_term) {
					if ($this_term = get_term( $filter_term, 'portfolio_tax' ) )
						echo '<li data-id="' . $filter_term . '">' . $this_term->name . '</li>';
				}	
				echo '</ul>';
			}
		} else {
			$filter_terms = get_terms('portfolio_tax', array( 'hide_empty' => true ));
				if ( count($filter_terms) > 0 ) {
				echo '<ul class="filter-terms">';
				echo '<li data-id="all">' . __('All', 'quadro') . '</li>';
				foreach ($filter_terms as $filter_term) {
						echo '<li data-id="' . $filter_term->term_id . '">' . $filter_term->name . '</li>';
				}	
				echo '</ul>';
			}
		} ?>
	</div>
	<?php } ?>

	<?php if( $wp_query->have_posts() ) : ?>

		<div class="quadro-portfolio clear masonry-wrapper portfolio-type-<?php echo $portfolio_style; ?> js-masonry item-info-<?php echo $reveal_data; ?>">
			
			<?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

				<?php $terms = get_the_terms( get_the_ID(), 'portfolio_tax' ); ?>

				<div id="portf-item-<?php the_ID(); ?>" class="mas-item portf-item <?php if ( is_array($terms) ) { foreach( $terms as $term ) { echo 'cat' . $term->term_id . ' '; } } ?>catall">

					<article>
						<a href="<?php the_permalink(); ?>" class="item-linkto" title="<?php echo get_the_title(); ?>" data-id="<?php the_ID(); ?>">

							<div class="portf-item-thumb">
								<?php the_post_thumbnail( 'portfolio-' . $portfolio_style . '-' . $portfolio_columns, array('alt' => '' . get_the_title() . '', 'title' => '') ); ?>
							</div>

							<?php if ( $reveal_data != 'hide' ) { ?>
							<div class="portf-item-content">
								<?php 
									$title = '<h2>' . get_the_title() . '</h2>';
									echo apply_filters( 'qi_portf_title', $title );
								?>
							</div>
							<?php } ?>

						</a>
					</article>
				
				</div>

			<?php endwhile; ?>

		</div>

		<?php if ( $show_nav == 'show' ) {
			// Implement Chosen Navigation Method
			if ( $portfolio_nav == 'ajax' ) { ?>
				<div class="ajax-navigation">
					<div class="posts-loader-icon" style="display: none;"><i class="fa fa-spinner fa-spin"></i></div>
					<h3 class="ajax-load-more" data-modid="<?php echo $mod_id; ?>" data-pagenmbr="1" data-function="quadro_load_more_items"><?php _e('Load more', 'quadro') ?></h3>
					<h4 class="load-no-more"><?php _e('No more to load.', 'quadro'); ?></h4>
				</div>
			<?php } else {
				quadro_content_nav( 'nav-below' );
			} 
		} ?>

	<?php else : ?>

		<?php get_template_part( 'no-results', 'index' ); ?>

	<?php endif; // ends 'wp_query' loop ?>
	<?php wp_reset_postdata(); ?>

</section>