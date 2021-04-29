<?php
/**
 * Displays all of the <head> section and everything up till <div id="main">
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/selectivizr-min.js"></script><![endif]-->

<?php // Retrieve Theme Options
global $quadro_options;
$quadro_options = quadro_get_options(); ?>

<?php if ( $quadro_options['favicon_img'] ) { ?>
<link rel="shortcut icon" href="<?php echo esc_url( $quadro_options['favicon_img'] ); ?>">
<?php } ?>

<?php if ( is_page() ) {
	// Apply function for inline styles
	quadro_page_styles( get_the_ID() ); 
} ?>

<?php if ( class_exists( 'Woocommerce' ) && ( is_woocommerce() ) ) {
	// Apply function for inline styles of WooCommerce special pages
	// using the selected Shop page options
	quadro_page_styles( get_option('woocommerce_shop_page_id') ); 
} ?>

<?php // Bring Header Options
$layout_style 	= esc_attr( $quadro_options['site_layout_style'] );
$header_style 	= esc_attr( $quadro_options['header_style'] );
$sticky_header 	= $quadro_options['sticky_nav_bar'] != '' ? esc_attr( $quadro_options['sticky_nav_bar'] ) : '';
$main_shape 	= ' shape-' . esc_attr( $quadro_options['main_shape'] );
$single_sidebar	= esc_attr( $quadro_options['single_sidebar'] );
$sidebar_pos	= esc_attr( $quadro_options['single_sidebar_pos'] );
?>

<?php wp_head(); ?>

</head>

<body <?php body_class('site-header-'.$header_style . ' ' . $layout_style . $main_shape . ' woo-sidebar-' . $quadro_options['woo_sidebar'] . ' onsingle-' . $single_sidebar . '-' . $sidebar_pos); ?>>

<div id="page" class="hfeed site">
	
	<?php do_action( 'before' ); ?>
	
	<header id="masthead" class="site-header <?php echo $sticky_header; ?>-header" role="banner">

		<div class="header-wrapper">

			<?php // Print Top Notice if enabled.
			quadro_top_notice(); ?>

			<?php // Print Topper Widget Area if enabled
			quadro_widget_area( 'widgetized_header_display', 'widgetized_header_layout', 'topper-header', 'header-sidebar' ); ?>

			<div class="top-header clear">

				<?php // Retrieve Top Menu and Social Icons for Header Type 1
				if ( $header_style == 'type1' ) { ?>
					<?php if ( $quadro_options['sec_menu_display'] == 'show' ) { ?>
						<nav id="top-navigation" class="secondary-navigation" role="navigation">
							<h1 class="menu-toggle"><?php _e( 'Menu', 'quadro' ); ?></h1>
							<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
						</nav><!-- #top-navigation -->
					<?php } ?>
				<?php quadro_contact_info(); ?>
				<div class="top-right-header">
					<?php quadro_social_icons('social_header_display', 'header-social-icons', 'header_icons_scheme', 'header_icons_color_type'); ?>
					<?php quadro_search_bar(); ?>
					<?php if ( class_exists( 'Woocommerce' ) ) quadro_header_cart(); ?>
				</div>
				<?php } ?>

				<?php if ( $header_style == 'type2' ) { ?>
				<?php quadro_search_bar(); ?>
				<?php if ( class_exists( 'Woocommerce' ) ) quadro_header_cart(); ?>
				<?php quadro_contact_info(); ?>
				<h1 class="menu-slider"><a href="#site-navigation" class="menu-link"><i class="fa fa-bars"></i><span><?php _e( 'Menu', 'quadro' ); ?></span></a></h1>
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'quadro' ); ?>"><?php _e( 'Skip to content', 'quadro' ); ?></a></div>
				</nav><!-- #site-navigation -->
				<?php } ?>
			
			</div>

			<div class="bottom-header clear">
				<?php if ( $header_style == 'type4' ) {
					echo '<div class="contact-wrapper">';
					quadro_contact_info(); 
					quadro_social_icons('social_header_display', 'header-social-icons', 'header_icons_scheme', 'header_icons_color_type');
					echo '</div>';
				} ?>
				<div class="site-branding <?php echo esc_attr($quadro_options['logo_type']); ?>-logo">
					<h1 class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
							<?php if ( $quadro_options['logo_type'] == 'text' ) {
								bloginfo( 'name' );
							} else { ?>
								<?php $retina_logo = $quadro_options['logo_img_retina'] != '' ? esc_url( $quadro_options['logo_img_retina'] ) : esc_url( $quadro_options['logo_img'] ); ?>
								<img src="<?php echo esc_url( $quadro_options['logo_img'] ); ?>" data-at2x="<?php echo $retina_logo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
							<?php } ?>
						</a>
					</h1>
					<?php if ( $quadro_options['tagline_display'] == 'show' && $header_style != 'type3') { ?>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					<?php } ?>
				</div>
				<?php if ( $header_style != 'type2' ) { ?>
				<?php if ( $header_style != 'type1' ) {
					quadro_search_bar();
					if ( class_exists( 'Woocommerce' ) ) quadro_header_cart();
				} ?>
				<h1 class="menu-slider"><a href="#site-navigation" class="menu-link"><i class="fa fa-bars"></i><span><?php _e( 'Menu', 'quadro' ); ?></span></a></h1>
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'quadro' ); ?>"><?php _e( 'Skip to content', 'quadro' ); ?></a></div>
				</nav><!-- #site-navigation -->
				<?php } ?>
				<?php if ( $sticky_header == 'sticky' ) { ?>
				<h1 class="menu-slider-sticky"><a href="#site-navigation" class="menu-link"><i class="fa fa-bars"></i><span><?php _e( 'Menu', 'quadro' ); ?></span></a></h1>
				<nav id="sticky-navigation" class="main-navigation sticky-navigation-menu" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'quadro' ); ?>"><?php _e( 'Skip to content', 'quadro' ); ?></a></div>
				</nav><!-- #sticky-navigation -->
				<?php } ?>
				<?php if ( $header_style == 'type2' ) quadro_social_icons('social_header_display', 'header-social-icons', 'header_icons_scheme', 'header_icons_color_type'); ?>
			</div>

		</div>
		
	</header><!-- #masthead -->

	<div id="main" class="site-main">
