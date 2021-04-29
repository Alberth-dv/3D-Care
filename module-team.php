<?php
/**
 * The template used for displaying Team Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
// Apply function for inline styles
quadro_mod_styles( $mod_id );

// Get Team Module data
$team = get_post_meta( $mod_id, 'quadro_mod_team_content', true );
$team_style = esc_attr( get_post_meta( $mod_id, 'quadro_mod_team_style', true ) );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-team <?php quadro_mod_parallax($mod_id); ?>">

	<?php quadro_mod_title( $mod_id ); ?>
	<?php quadro_module_content(); ?>

	<?php if ( !empty($team) ) { ?>
		
		<div class="team-<?php echo $team_style; ?>">

			<ul class="team clear">

				<?php foreach ($team as $member) { ?>
				
					<li class="team-member">

						<div class="team-member-wrapper clear">
							
							<?php // Set img size
							if ( $team_style == 'type1' ) $img_size = '-784x569';
							if ( $team_style == 'type2' ) $img_size = '-470x341';
							if ( $team_style == 'type3' ) $img_size = '-350x254'; ?>

							<?php $img_url = isset($member['Photo']) ? esc_url( $member['Photo'] ) : '';
							if ( $img_url != '' ) {
								// We modify the url string to pick our cropped size
								// saving performance time against querying for it's name in DB.
								$img_url = substr($img_url, 0, -4) . $img_size . substr($img_url, -4); 
								echo '<div class="member-photo-wrapper">';
								echo '<img src="' . $img_url . '" alt="' . esc_attr( $member['Name'] ) . '"></div>';
							} ?>
							<div class="member-content">
								<h3 class="member-name">
									<?php $url = isset($member['Link']) ? esc_url( $member['Link'] ) : ''; ?>
									<?php if ( $url != '' ) echo '<a href="' . $url . '">'; ?>
									<?php $name = isset($member['Name']) ? esc_attr( $member['Name'] ) : '';
									if ( $name != '' ) echo $name; ?>
									<?php if ( $url != '' ) echo '</a>'; ?>
								</h3>
								<span class="member-role">
									<?php $role = isset($member['Role']) ? esc_attr( $member['Role'] ) : '';
									if ( $role != '' ) echo $role; ?>
								</span>
								<?php $content = isset($member['Content']) ? esc_attr( $member['Content'] ) : '';
								// Filter through the_content filter
								$content = apply_filters( 'the_content', $content );
								$content = str_replace( ']]>', ']]&gt;', $content );
								if ( $content != '' ) echo $content; ?>
								<?php $social = isset($member['Social']) ? $member['Social'] : '';
								// Print Social Networks Links if there are some
								if ( !empty($social) ) {
									echo '<div class="member-socials">';
									foreach ($social as $network => $value) {
										if ( isset($value) && $value != '' ) {
											if ( $network == 'envelope' ) $value = 'mailto:' . $value;
											echo '<a href="' . esc_url($value) . '"><i class="fa fa-' . esc_attr($network) . '"></i></a>';
										}
									}
									echo '</div>';
								} ?>
							</div>
						</div>
					
					</li>

				<?php } ?>

			</ul>

		</div>

	<?php } ?>

</section><!-- .module -->
