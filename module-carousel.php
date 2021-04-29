<?php
/**
 * The template used for displaying Carousel Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Now, let's get all the carousel posts
$args = array(
	'post_type' => array( 'post', 'quadro_nym_portfolio', 'quadro_slide', 'product' ),
	'posts_per_page' => -1
 );

// Bring picked posts if there are some
$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_pick_carousel', $args );

$home_carousel = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-carousel <?php quadro_mod_parallax($mod_id); ?>">
	
	<?php quadro_mod_title( $mod_id ); ?>
	<?php quadro_module_content(); ?>

	<div class="carousel-wrapper">

		<ul class="carousel slides">

			<?php if( $home_carousel->have_posts() ) : while( $home_carousel->have_posts() ) : $home_carousel->the_post(); ?>

				<?php // Skipe this item if there's no thumbnail to show
				if ( '' == get_the_post_thumbnail() ) continue; ?>

				<li id="carousel-post-<?php the_ID(); ?>" class="carousel-item">
					
					<?php the_post_thumbnail( 'common-thumb', array('alt' => '' . get_the_title() . '', 'title' => '') ); ?>
					
					<div class="carousel-item-content">
						<h2><?php the_title(); ?></h2>
						<div class="carousel-item-text"><?php echo quadro_excerpt(get_the_excerpt(), 16, ''); ?></div>
						<a href="<?php the_permalink(); ?>" class="carousel-item-more qbtn"><?php echo __('See more', 'quadro'); ?></a>
					</div>
				
				</li>

			<?php endwhile; endif; // ends Carousel loop ?>
			<?php wp_reset_postdata(); ?>

		</ul>

	</div>

</section>