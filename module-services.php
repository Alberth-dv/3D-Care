<?php
/**
 * The template used for displaying Services Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Get Service Module Layout Style and Posts list
$services_layout = esc_attr( get_post_meta( $mod_id, 'quadro_mod_services_layout', true ) );
$services_columns = esc_attr( get_post_meta( $mod_id, 'quadro_mod_services_columns', true ) );

// Now, let's get all the services
$args = array(
	'post_type' =>  'quadro_service',
	'posts_per_page' => -1
 );

// Bring picked posts if there are some
$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_pick_services', $args );

$quadro_services = new WP_Query( $args );

// Retrieve Theme Options
global $quadro_options;

?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-services services-<?php echo $services_layout; ?> <?php echo $services_columns; ?>-columns <?php quadro_mod_parallax($mod_id); ?>">
	
	<?php quadro_mod_title( $mod_id ); ?>
	<?php quadro_module_content(); ?>

	<ul class="quadro-services clear">
		
		<?php if( $quadro_services->have_posts() ) : while( $quadro_services->have_posts() ) : $quadro_services->the_post(); ?>

			<?php
			// Get options for this Service
			$service_id = get_the_ID();
			$service_tagline = esc_attr( get_post_meta( $service_id, 'quadro_service_tagline', true ) );
			$service_link = esc_url( get_post_meta( $service_id, 'quadro_service_link', true ) );
			$link_text = esc_attr( get_post_meta( $service_id, 'quadro_service_link_text', true ) );
			$service_back = esc_attr( get_post_meta( $service_id, 'quadro_service_background', true ) );
			$service_back = $service_back != '#' ? $service_back : $quadro_options['main_color'];
			$service_show = esc_attr( get_post_meta( $service_id, 'quadro_service_show', true ) );
			$service_icon = esc_attr( get_post_meta( $service_id, 'quadro_service_icon', true ) );
			$back_styles = 'style="background-color: ' . $service_back . '"';
			?>

			<li id="service-<?php the_ID(); ?>" class="quadro-service service-table" data-hover="<?php echo $service_back ?>">
				
			<?php // Add link for touch devices
			if ( $services_layout == 'type1' && $service_link != '' ) echo '<a href="' . $service_link . '" title="' . get_the_title() . '">'; ?>

				<header>

					<span class="service-icon" <?php echo $back_styles; ?>>
						<?php if ( $service_link != '' && $services_layout != 'type1' ) echo '<a href="' . $service_link . '">'; ?>
							<?php // Bring Icon or Image
							if ( $service_show == 'icon' ) {
								echo '<i class="' . $service_icon . '"></i>';
							} elseif ( $service_show == 'image' ) {
								the_post_thumbnail( 'service-pic', array('alt' => '' . get_the_title() . '', 'title' => '') );
							} ?>
						<?php if ( $service_link != '' && $services_layout != 'type1' ) echo '</a>'; ?>
					</span>

					<div class="service-heading">
						<h2>
							<?php if ( $services_layout != 'type1' && $service_link != '' ) echo '<a href="' . $service_link . '" title="' . get_the_title() . '">';
							the_title();
							if ( $services_layout != 'type1' && $service_link != '' ) echo '</a>'; ?>
						</h2>
						
						<?php if ( $service_tagline != '' ) echo '<span class="service-tagline">' . $service_tagline . '</span>';?>
					</div>

				</header>
				
				<?php if ( get_the_content() != '' ) { ?>
				<div class="service-content">
					<?php if ( $services_layout == 'type1' ) echo '<p>' . quadro_excerpt(get_the_content(), 18, '') . '</p>'; ?>
					<?php if ( $services_layout != 'type1' ) the_content(); ?>
					<?php if ( $service_link != '' ) {
						$link_text = $link_text != '' ? $link_text : __('Read more', 'quadro');
						if ( $services_layout != 'type1') {
							echo '<a href="' . $service_link . '" class="service-link" title="' . $link_text . '">';
						} else {
							echo '<span class="service-link">';
						}
						// Print the Read More text
						echo $link_text;
						if ( $services_layout != 'type1') { echo '</a>'; } else { echo '</span>'; }
					} ?>
				</div>
				<?php } ?>

			<?php // Close link for Type1 on touch devices
			if ( $services_layout == 'type1' && $service_link != '' ) echo '</a>'; ?>
			
			</li>

		<?php endwhile; endif; // ends 'quadro_service' loop ?>
		<?php wp_reset_postdata(); ?>

	</ul>

</section>