<?php
/**
 * quadro functions and definitions
 *
 * @package quadro
 */

/**
 * Set the content width based on the Nayma's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

// Define Template Directory URI & Template Directory
$template_directory_uri = get_template_directory_uri();
$template_directory = get_template_directory();

if ( ! function_exists( 'quadro_setup' ) ) :
/**
 * Sets up Nayma defaults and registers support for various WordPress features.
 */
function quadro_setup() {

	global $template_directory;

	/**
	 * Make Nayma available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'quadro', $template_directory . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for title-tag
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'common-thumb', 470, 470, true );
	add_image_size( 'fullwidth-thumb', 1400, 326, true );
	add_image_size( 'slider-regular', 1400, 600, true );
	add_image_size( 'portfolio-grid-two', 784, 569, true );
	add_image_size( 'portfolio-grid-three', 470, 341, true );
	add_image_size( 'portfolio-grid-four', 350, 254, true );
	add_image_size( 'portfolio-masonry-two', 784, 9999, false );
	add_image_size( 'portfolio-masonry-three', 470, 9999, false );
	add_image_size( 'portfolio-masonry-four', 350, 9999, false );


	// Thumnbail Sizes Setting
	add_filter( 'intermediate_image_sizes_advanced', 'quadro_thumbnail_sizes', 10);
	function quadro_thumbnail_sizes( $sizes ) {

		// Return with already existant sizes if we have no Post ID
		if ( !isset($_REQUEST['post_id']) ) return $sizes;

		$post_type = get_post_type($_REQUEST['post_id']);

		switch ($post_type) :

			case 'quadro_slide' :
				$sizes['slider-large'] = array(
					'width' => 1400,
					'height' => 700,
					'crop' => true
				);
				$sizes['slider-wide'] = array(
					'width' => 1400,
					'height' => 500,
					'crop' => true
				);
				unset( $sizes['thumbnail']);
				unset( $sizes['medium']);
				unset( $sizes['large']);
				break;

			case 'quadro_service' :
				$sizes['service-pic'] = array(
					'width' => 160,
					'height' => 160,
					'crop' => true
				);
				unset( $sizes['thumbnail']);
				unset( $sizes['medium']);
				unset( $sizes['large']);
				break;

		endswitch;

		return $sizes;

	}

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'quadro' ),
		'secondary' => __( 'secondary Menu', 'quadro' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'status', 'gallery', 'image', 'audio', 'video', 'quote', 'link' ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );

	/**
	 * Enable WooCommerce Support
	 */
	add_theme_support( 'woocommerce' );

}
endif; // quadro_setup
add_action( 'after_setup_theme', 'quadro_setup' );


/**
 * Including Custom Fields definition (ADMIN ONLY)
 */
if ( is_admin() ) require( $template_directory . '/inc/custom-fields-definition.php' );

/**
 * Including Theme Options definition
 */
require( $template_directory . '/inc/options-definition.php' );


/**
 * Declare variables for QI Framework
 */

// Theme Options Group
function qi_return_option_group() {
	return 'quadro_nayma_options';
}

$quadro_options_group = qi_return_option_group();

if ( is_admin() ) {
	// Available Patterns Quantity (change this variable if new patterns are incorporated)
	$patterns_qty = 79;
	// Dashboard Helpers (on/off)
	$dashboard_helpers = true;
	// Welcome Message (on/off)
	$welcome_message = true;
	// Theme's Slug (internal use only)
	$theme_slug = 'nayma';
	// Theme's Docs URL
	$qi_docs_url = '//quadroideas.com/docs/Nayma_Documentation.html';
	// Theme Support URL
	$qi_support_url = 'http://quadroideas.com/support/theme/nayma-wp-theme';
	// Demo Content File Name
	$dcontent_file = 'nayma_dcontent.xml.gz';
	// Demo Content Settings File
	$dcontent_settings = 'nayma-demo-settings.txt';
	// Demo Content Widgets
	$dcontent_widgets = 'nayma_widget_data.json';
	// Demo Content Plugins
	$dcontent_plugins = array('revolution');
	// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
	$dcontent_reading = 'page';
	// Settings >> Reading : Front Page
	$dcontent_front = 'HOME';
	// Settings >> Reading : Posts Page
	$dcontent_posts = 'Blog';
}


/**
 * Including QuadroIdeas Framework
 */
require( $template_directory . '/inc/qi-framework/qi-framework.php' );


/**
 * Register widgetized areas and update sidebar with default widgets
 */
function quadro_widgets_init() {
	
	register_sidebar( array(
		'name' 			=> __( 'Sidebar', 'quadro' ),
		'id' 			=> 'main-sidebar',
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  		=> '</aside>',
		'before_title'  		=> '<h1 class="widget-title">',
		'after_title'   		=> '</h1>',
	) );

	// Retrieve Theme Options
	$quadro_options = quadro_get_options();

	// Create Footer Widgets Area
	if ( $quadro_options['widgetized_footer_layout'] == 'widg-layout1' ) { $i = 4; }
	else if ( $quadro_options['widgetized_footer_layout'] == 'widg-layout2' || $quadro_options['widgetized_footer_layout'] == 'widg-layout3' || $quadro_options['widgetized_footer_layout'] == 'widg-layout4' ) { $i = 3; }
	else if ( $quadro_options['widgetized_footer_layout'] === 'widg-layout5' ) { $i = 2; }
	else if ( $quadro_options['widgetized_footer_layout'] == 'widg-layout6' ) { $i = 1; }

	for ($j = 1; $j <= $i ; $j++) {
		
		register_sidebar(array(
			'name' => 'Footer Column ' . $j,
			'id' => 'footer-sidebar' . $j,
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		));
		
	} // end for

	// Create Topper Header Widgets Area
	if ( $quadro_options['widgetized_header_layout'] == 'widg-layout1' ) { $i = 4; }
	else if ( $quadro_options['widgetized_header_layout'] == 'widg-layout2' || $quadro_options['widgetized_header_layout'] == 'widg-layout3' || $quadro_options['widgetized_header_layout'] == 'widg-layout4' ) { $i = 3; }
	else if ( $quadro_options['widgetized_header_layout'] === 'widg-layout5' ) { $i = 2; }
	else if ( $quadro_options['widgetized_header_layout'] === 'widg-layout6' ) { $i = 1; }

	for ($j = 1; $j <= $i ; $j++) {
		
		register_sidebar(array(
			'name' => 'Header Column ' . $j,
			'id' => 'header-sidebar' . $j,
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		));
		
	} // end for

	// Create User Added Sidebars
	if ( is_array($quadro_options['quadro_sidebars']) ) {
		foreach( $quadro_options['quadro_sidebars'] as $user_sidebar ) {
			
			// Skip iteration if there's no name for this sidebar
			if ( $user_sidebar['name'] == '' ) continue;

			register_sidebar(array(
				'name' => esc_attr($user_sidebar['name']),
				'id' => esc_attr($user_sidebar['slug']),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			));
			
		} // end for
	}

}
add_action( 'widgets_init', 'quadro_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function quadro_scripts() {

	global $quadro_options, $template_directory_uri;
	
	wp_enqueue_style( 'quadro-style', get_stylesheet_uri() );

	wp_enqueue_script( 'quadro-navigation', $template_directory_uri . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'quadro-skip-link-focus-fix', $template_directory_uri . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'quadro-keyboard-image-navigation', $template_directory_uri . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	// Call Google Maps script if enabled
	if ( $quadro_options['gmaps_enable'] == true ) {
		wp_register_script('gmapsrc', '//maps.googleapis.com/maps/api/js?sensor=false', 'jquery', '', true);
		wp_enqueue_script('gmapsrc');
	}

	wp_enqueue_script('jquery');

	wp_enqueue_script( 'jquery-effects-core', array( 'jquery' ) );

	wp_register_script('quadroscripts', $template_directory_uri . '/js/scripts.js', 'jquery', '', true);
	wp_enqueue_script('quadroscripts');

	/**
	 * Define Ajax Url for non logged requests
	 */
	wp_localize_script( 'quadroscripts', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	// Include Woocommerce Styles if plugin activated
	if ( class_exists( 'Woocommerce' ) ) {
		// Check for 2.3 version (major update) in order to provide backwards compatibility
		global $woocommerce;
		if ( ! is_object( $woocommerce ) || version_compare( $woocommerce->version, '2.3', '>=' ) ) {
			wp_register_style( 'woocommerce-styles', $template_directory_uri . '/inc/woocommerce-styles.css', array(), '' );	
		} else {
			wp_register_style( 'woocommerce-styles', $template_directory_uri . '/inc/woocommerce-styles-pre23.css', array(), '' );	
		}
		wp_enqueue_style( 'woocommerce-styles' );
	}

	// Include Visual Composer Styles if plugin activated
	if ( function_exists('vc_set_as_theme') ) {
	wp_register_style( 'vcomposer-styles', $template_directory_uri . '/inc/vcomposer-styles.css', array(), '' );	
	wp_enqueue_style( 'vcomposer-styles' );
	}

	// Call Retina.js if Retina option enabled
	if ( $quadro_options['retina_enable'] == true ) {
		wp_register_script('retina', $template_directory_uri . '/js/retina.js', 'jquery', '', true);
		wp_enqueue_script('retina');
	}

	// Call Responsive Panel Navigation CSS
	wp_enqueue_style( 'plugin-styles', $template_directory_uri . '/inc/jquery.mmenu.css', array(), '' );

}
add_action( 'wp_enqueue_scripts', 'quadro_scripts' );

/**
 * Enqueue admin scripts and styles
 */
function quadro_admin_scripts() {

	global $template_directory_uri;
	wp_register_style('adminstyles', $template_directory_uri . '/inc/back-styles.css', '');
	wp_enqueue_style('adminstyles');

}
add_action( 'admin_enqueue_scripts', 'quadro_admin_scripts' );


/**
 * Including Quadro Custom Post Types
 */
require( $template_directory . '/inc/custom-post-types.php' );

/**
 * Including Theme Specific Functions
 */
require( $template_directory . '/inc/theme-functions.php' );

/**
 * Including Quadro Widgets
 */
require( $template_directory . '/inc/quadro-widgets.php' );


/**
 * Adds the WordPress Ajax Library to frontend.
 */
function quadro_add_ajax_library() { 
	$html = '<script type="text/javascript">';
		$html .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"';
	$html .= '</script>';
 
	echo $html;
}
add_action( 'wp_head', 'quadro_add_ajax_library' );


/** 
 * Including WooCommerce Support Helper Functions
 */
// Check for WooCommerce first
if ( class_exists( 'Woocommerce' ) ) {
	require( $template_directory . '/inc/quadro-woocommerce.php' );
}

/**
 * Prepare Woocommerce Thumbnail sizes on Theme Activation
 */
global $pagenow;
if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) && is_admin() ) {
	add_action( 'admin_init', 'nayma_activation' );
	function nayma_activation() {
		update_option( 'shop_catalog_image_size', array('width' => 470, 'height' => 470, 1) );
		update_option( 'shop_single_image_size', array('width' => 400, 'height' => 9999, 1) );
		update_option( 'shop_thumbnail_image_size', array('width' => 120, 'height' => 120, 1) );
	}
}

/**
 * Register Translatable Strings for WPML
 */
if ( function_exists('icl_register_string') ) {
	global $quadro_options;
	icl_register_string('Nayma WordPress Theme', '404 Page Title', $quadro_options['404_title'] );
	icl_register_string('Nayma WordPress Theme', '404 Page Text', $quadro_options['404_text'] );
	icl_register_string('Nayma WordPress Theme', 'Copyright Text', $quadro_options['copyright_text'] );
}


/**
 * Force Visual Composer to initialize as "built into the theme". 
 * This will hide certain tabs under the Settings->Visual Composer page.
 */
if ( function_exists('vc_set_as_theme') ) vc_set_as_theme($notifier = false);
if ( function_exists('vc_set_as_theme') ) vc_set_as_theme( true );


/**
 * Register the required plugins for this theme.
 *
 * Thanks to https://github.com/thomasgriffin/TGM-Plugin-Activation for
 * this awesome class!
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
add_action( 'tgmpa_register', 'quadro_register_required_plugins' );
function quadro_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Nayma Portfolio
		array(
			'name'     				=> 'Nayma WP Theme - Portfolio Type',
			'slug'     				=> 'nayma-portfolio',
			'source'   				=> get_stylesheet_directory() . '/inc/plugins/nayma-portfolio.zip',
			'required' 				=> true,
			'version' 				=> '1.0.1',
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'description'			=> __('This plugin enables the Portfolio custom post type that we use to create Portoflio Items.', 'quadro'),
		),

		// Site Origin Page Builder
		array(
			'name'					=> 'Page Builder by SiteOrigin',
			'slug'					=> 'siteorigin-panels',
			'required'				=> false,
			'version'				=> '1.5.3',
			'description'			=> __('Build responsive page layouts using the widgets you know and love using this simple drag and drop page builder.', 'quadro'),
		),

		// SiteOrigin Widgets Bundle
		array(
			'name'					=> 'SiteOrigin Widgets Bundle',
			'slug'					=> 'so-widgets-bundle',
			'required'				=> false,
			'version'				=> '1.4.2',
			'description'			=> esc_html__('A collection of widgets to be used together with Page Builder plugin.', 'quadro'),
		),

		// Crelly Slider
		array(
			'name'					=> 'Crelly Slider',
			'slug'					=> 'crelly-slider',
			'required'				=> false,
			'version'				=> '0.7.0', // we're not requiring any specific version yet,
			'description'			=> __('Crelly Slider is a Free / Open Source WordPress slider with a powerful Drag & Drop Builder. You can add Texts and Images using animations and transitions. It&#39;s perfect to display your creative content in posts and pages. With it&#39;s tons of features, Crelly Slider is the best free solution for your online WebSite.', 'quadro'),
		),

	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'quadro';

	/**
	 * Array of configuration settings.
	 */
	$config = array(
		'domain'       		=> 'quadro',         			// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'getting-started', 			// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '', 							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Required Plugins Area (Install/Update)', 'quadro' ),
			'menu_title'                       			=> __( 'Install Required Plugins', 'quadro' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'quadro' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'quadro' ),
			'notice_can_install_required'     			=> _n_noop( 'Nayma theme requires the following plugin: %1$s.', 'Nayma theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'Nayma theme recommends the following plugin: %1$s.', 'Nayma theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.<br /> Please, update them one by one if you are on Multisite to prevent any errors.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'quadro' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'quadro' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'quadro' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}