<?php
/**
 * The template used for displaying Recent Posts Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Get Recent Posts Module Options
$per_page = esc_attr( get_post_meta( $mod_id, 'quadro_mod_recentposts_pper', true ) );
$per_page = $per_page != '' ? $per_page : 6;

// Now, let's get all the carousel posts
$args = array(
	'post_type' => array( 'post' ),
	'posts_per_page' => $per_page
 );

$recents_query = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-recents <?php quadro_mod_parallax($mod_id); ?>">
	
	<?php quadro_mod_title( $mod_id ); ?>
	<?php quadro_module_content(); ?>

	<div class="recents-wrapper">

		<ul class="recents slides">

			<?php if( $recents_query->have_posts() ) : while( $recents_query->have_posts() ) : $recents_query->the_post(); ?>

				<li id="recents-post-<?php the_ID(); ?>" class="recents-item">
					<div class="recents-item-content">
						<h2><a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php the_title(); ?></a></h2>
						<?php quadro_posted_on(); ?>
						<a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
							<?php the_post_thumbnail( 'portfolio-grid-three', array('alt' => get_the_title(), 'title' => get_the_title()) ); ?>
						</a>
						<div class="recents-item-text"><?php echo quadro_excerpt(get_the_excerpt(), 24, ''); ?></div>
					</div>
				</li>

			<?php endwhile; endif; // ends Recents loop ?>
			<?php wp_reset_postdata(); ?>

		</ul>

	</div>

</section>