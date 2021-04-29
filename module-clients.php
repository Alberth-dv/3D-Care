<?php
/**
 * The template used for displaying Clients Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Get Clients Module data
$clients = get_post_meta( $mod_id, 'quadro_mod_clients_content', true );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-clients <?php quadro_mod_parallax($mod_id); ?>">

	<?php quadro_mod_title( $mod_id ); ?>
	<?php quadro_module_content(); ?>

	<?php if ( !empty($clients) ) { ?>
		
		<div class="clients-wrapper">

			<ul class="clients slides clear">

				<?php foreach ($clients as $client) { ?>

					<li class="client-profile">
						<div class="client-content clear">
							<?php if ( isset($client['Link']) && $client['Link'] != '' ) {
								echo '<a href="' . esc_url($client['Link']) . '" target="_blank" class="client-link">';
							}
							$img_url = isset($client['Logo']) ? esc_url( $client['Logo'] ) : '';
							if ( $img_url != '' ) { 
								echo '<img src="' . $img_url . '" alt="">';
							}
							if ( isset($client['Link']) && $client['Link'] != '' ) {
								echo '</a>';
							} ?>
						</div>
					</li>

				<?php } ?>

			</ul>

		</div>

	<?php } ?>

</section><!-- .module -->
