<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package quadro
 */
?>

<?php // Retrieve Theme Options
global $quadro_options; ?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php // Print Footer Widgetized area if enabled.
		quadro_widget_area( 'widgetized_footer_display', 'widgetized_footer_layout', 'inner-footer', 'footer-sidebar' ); ?>

		<div class="bottom-footer clear">
			
			<div class="site-info">
				<?php do_action( 'quadro_credits' ); ?>
				<p>
					<?php // Output WPML translations if there are set
					if ( function_exists('icl_t') ) {
						echo icl_t('Nayma WordPress Theme', 'Copyright Text', $quadro_options['copyright_text'] );
					} else {
						echo strip_tags( $quadro_options['copyright_text'], '<div><img><p><span><a><br><strong><em><i><bold><small>' );
					} ?>
				</p>
			</div><!-- .site-info -->

			<?php quadro_social_icons('social_footer_display', 'footer-social-icons', 'footer_icons_scheme', 'footer_icons_color_type'); ?>

		</div>

	</footer><!-- #colophon -->

</div><!-- #page -->

<?php // Bring Back to Top functionality if enabled
if ( $quadro_options['backto_enable'] == true ) echo '<a href="#" class="back-to-top"></a>'; ?>

<?php wp_footer(); ?>

</body>
</html>