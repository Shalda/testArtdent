<?php
	/**
	 *	DentalPress WordPress Theme
	 */

	class DentalPress_Actions {
		function __construct() {
			add_action( 'init', array($this, 'dentalpress_init') );
			add_action( 'init', array($this, 'dentalpress_fonts') );
			add_action( 'after_setup_theme', array($this, 'dentalpress_load_theme_textdomain') );
			add_action( 'after_setup_theme', array($this, 'dentalpress_after_setup_theme') );
			add_action( 'after_setup_theme', array($this, 'dentalpress_content_width'), 0 );
			add_action( 'wp_enqueue_scripts', array($this, 'dentalpress_wp_enqueue_scripts') );
			add_action( 'admin_enqueue_scripts', array($this, 'dentalpress_admin_enqueue_scripts') );
			add_action( 'wp_head', array($this, 'dentalpress_wp_head') );
			add_action( 'wp_footer', array($this, 'dentalpress_wp_footer') );
			add_action( 'widgets_init', array($this, 'dentalpress_widgets_init') );
			add_action( 'tgmpa_register', array($this, 'dentalpress_tgmpa_register') );
		}

		// Theme Initialization
		function dentalpress_init() {
			// Font Awesome
			wp_register_style('font-awesome', DENTALPRESS_THEME_ASSETS . 'lib/font-awesome/css/font-awesome.min.css', array(), '4.7.0');

			// Font DentalPress
			wp_register_style('font-dentalpress', DENTALPRESS_THEME_ASSETS . 'lib/font-dentalpress/css/font-dentalpress.css', array(), DENTALPRESS_THEME_VERSION);

			// Bootstrap
			wp_register_style('bootstrap', DENTALPRESS_THEME_ASSETS . 'lib/bootstrap/css/bootstrap.min.css', array(), '3.3.6');
			wp_register_script('bootstrap', DENTALPRESS_THEME_ASSETS . 'lib/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.6', true);

			// Datepicker
			wp_register_style('bootstrap-datepicker', DENTALPRESS_THEME_ASSETS . 'lib/bootstrap-datepicker/bootstrap-datepicker.css', array(), '1.5');
			wp_register_script('bootstrap-datepicker', DENTALPRESS_THEME_ASSETS . 'lib/bootstrap-datepicker/bootstrap-datepicker.js', array('jquery'), '1.5', true);
			
			// Timepicker
			wp_register_style('bootstrap-timepicker', DENTALPRESS_THEME_ASSETS . 'lib/bootstrap-timepicker/bootstrap-timepicker.min.css', array(), '0.2.6');
			wp_register_script('bootstrap-timepicker', DENTALPRESS_THEME_ASSETS . 'lib/bootstrap-timepicker/bootstrap-timepicker.min.js', array('jquery'), '0.2.6', true);
			
			// Owl Carousel
			wp_register_style('owl-carousel', DENTALPRESS_THEME_ASSETS . 'lib/owl-carousel/owl.carousel.min.css', array(), '1.3.3');
			wp_register_script('owl-carousel', DENTALPRESS_THEME_ASSETS . 'lib/owl-carousel/owl.carousel.min.js', array('jquery'), '1.3.3', true);

			// Magnific Popup
			wp_register_style('magnific-popup', DENTALPRESS_THEME_ASSETS . 'lib/magnific-popup/magnific-popup.min.css', array(), '1.1.0');
			wp_register_script('magnific-popup', DENTALPRESS_THEME_ASSETS . 'lib/magnific-popup/magnific-popup.min.js', array('jquery'), '1.1.0', true);

			// Common
			wp_register_style('dentalpress-common-css', DENTALPRESS_THEME_ASSETS . 'css/common.css', array(), DENTALPRESS_THEME_VERSION);
			wp_register_script('dentalpress-common-js', DENTALPRESS_THEME_ASSETS . 'js/common.js', array('jquery', 'jquery-ui-core', 'jquery-ui-tabs'), DENTALPRESS_THEME_VERSION, true);
			
			// Main
			wp_register_style('dentalpress-main', DENTALPRESS_THEME_URL . 'style.css', array(), DENTALPRESS_THEME_VERSION);
			wp_register_script('dentalpress-main', DENTALPRESS_THEME_ASSETS . 'js/main.js', array('jquery'), DENTALPRESS_THEME_VERSION, true);
			
			// Config Object
			wp_localize_script( 'dentalpress-main', 'dentalpress_config',
				array(
					'ajaxurl' => admin_url("admin-ajax.php"),
					'home_url' => esc_url( home_url('/') ),
					'google_maps_api_key' => dentalpress_get_option('google-map-api-key', '')
				)
			);

			// Admin
			wp_register_style('dentalpress-admin-style', DENTALPRESS_THEME_ADMIN_ASSETS . 'css/admin.css', array(), DENTALPRESS_THEME_VERSION);
			wp_register_script('dentalpress-admin-script', DENTALPRESS_THEME_ADMIN_ASSETS . 'js/admin.js', array( 'jquery', 'wp-color-picker' ), DENTALPRESS_THEME_VERSION, true);

			// Editor Style
			add_editor_style('editor-style.css');
		}

		// Register Fonts
		function dentalpress_fonts() {
			$fonts_url = '';
			$fonts     = array();
			$subsets   = 'latin,latin-ext';

			/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
			if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'dentalpress' ) ) {
				$fonts[] = 'Open Sans:300,300i,400,400i,600,600i,700,700i';
			}

			/* translators: If there are characters in your language that are not supported by Poppins, translate this to 'off'. Do not translate into your own language. */
			if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'dentalpress' ) ) {
				$fonts[] = 'Poppins:300,400,500,600,700';
			}

			if ( $fonts ) {
				$fonts_url = add_query_arg( array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( $subsets ),
				), 'https://fonts.googleapis.com/css' );
			}

			wp_register_style('dentalpress-fonts', $fonts_url, array(), DENTALPRESS_THEME_VERSION);
		}

		// Theme Textdomain
		function dentalpress_load_theme_textdomain() {
			if ( $loaded = load_theme_textdomain( 'dentalpress', trailingslashit( WP_LANG_DIR ) . 'dentalpress' ) ) {
				return $loaded;
			} else if ( $loaded = load_theme_textdomain( 'dentalpress', get_stylesheet_directory() . '/languages' ) ) {
				return $loaded;
			} else {
				load_theme_textdomain( 'dentalpress', get_template_directory() . '/languages' );
			}
		}

		// After Setup Theme
		function dentalpress_after_setup_theme() {
			// Theme Support
			add_theme_support('menus');
			add_theme_support('widgets');
			add_theme_support('title-tag');
			add_theme_support('automatic-feed-links');
			add_theme_support('post-thumbnails');
			add_theme_support('featured-image');
			add_theme_support('woocommerce');
			add_theme_support('custom-header');
			add_theme_support('custom-background');
			add_theme_support('post-formats', array('image', 'audio', 'video', 'gallery', 'link', 'quote', 'aside') );

			// Attachment Sizes
			add_image_size('dentalpress_ratio-1:1', 600, 600, true);
			add_image_size('dentalpress_ratio-2:1', 800, 400, true);
			add_image_size('dentalpress_ratio-3:2', 800, 533, true);
			add_image_size('dentalpress_ratio-3:4', 450, 600, true);
			add_image_size('dentalpress_ratio-4:3', 800, 600, true);
			add_image_size('dentalpress_ratio-16:9', 800, 450, true);
			
			// Register Menus
			register_nav_menus(
				array(
					'main-navigation' => esc_html__('Main Navigation', 'dentalpress')
				)
			);
		}

		// Theme Content Width
		function dentalpress_content_width() {
			$GLOBALS['content_width'] = apply_filters( 'dentalpress_content_width', 1170 );
		}

		// Enqueue Scripts
		function dentalpress_wp_enqueue_scripts() {
			// Styles
			wp_enqueue_style(
				array(
					'dentalpress-fonts',
					'wp-mediaelement',
					'font-awesome',
					'font-dentalpress',
					'bootstrap',
					'bootstrap-datepicker',
					'bootstrap-timepicker',
					'magnific-popup',
					'owl-carousel',
					'dentalpress-common-css',
					'dentalpress-main'
				)
			);

			// Comment Reply
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		// Enqueue Admin Scritps
		function dentalpress_admin_enqueue_scripts() {
			// Styles
			wp_enqueue_style(
				array(
					'font-awesome',
					'font-dentalpress',
					'wp-color-picker',
					'dentalpress-admin-style'
				)
			);

			//Media Frame
			wp_enqueue_media();

			// Scripts
			wp_enqueue_script( 'dentalpress-admin-script' );
		}

		// Head Init
		function dentalpress_wp_head() {
			if( !function_exists('_wp_render_title_tag') ) : ?>
				<title><?php wp_title(''); ?></title>
			<?php endif; ?>

			<meta name="generator" content="Powered by FlexiPress" />
			<?php echo '<style type="text/css" id="dentalpress_custom-css">'. dentalpress_custom_css() .'</style>'; ?>
		<?php
		}

		// Footer Init
		function dentalpress_wp_footer() {
			// Scripts
			wp_enqueue_script(
				array(
					'wp-mediaelement',
					'jquery-ui-core',
					'jquery-ui-accordion',
					'jquery-ui-tabs',
					'bootstrap',
					'bootstrap-datepicker',
					'bootstrap-timepicker',
					'magnific-popup',
					'owl-carousel',
					'dentalpress-common-js',
					'dentalpress-main'
				)
			);

			// Custom JS form Theme Options
			if( trim(dentalpress_get_option('custom-js')) !== '' ) {
				echo '<scr'.'ipt>'. dentalpress_get_option('custom-js') .'</scr'.'ipt>';
			}

			// Google Analytics Tracking Code
			if( trim(dentalpress_get_option('google-analytics-tracking-code')) !== '' ) {
				echo dentalpress_get_option('google-analytics-tracking-code');
			}
		}

		// Widgets Init
		function dentalpress_widgets_init() {
			// General Sidebar
			register_sidebar(
				array(
					'id' => 'general-sidebar',
					'name' => esc_html__('General Sidebar', 'dentalpress'),
					
					'before_widget' => '<div class="widget %2$s %1$s clearfix">',
					'after_widget' => '</div>',
					
					'before_title' => '<h3 class="widget_title">',
					'after_title' => '</h3>'
				)
			);
			
			// Blog Sidebar
			register_sidebar(
				array(
					'id' => 'blog-sidebar',
					'name' => esc_html__('Blog Sidebar', 'dentalpress'),
					
					'before_widget' => '<div class="widget %2$s %1$s clearfix">',
					'after_widget' => '</div>',
					
					'before_title' => '<h3 class="widget_title">',
					'after_title' => '</h3>'
				)
			);

			// Footer #1
			register_sidebar(
				array(
					'id' => 'footer-1',
					'name' => esc_html__('Footer #1', 'dentalpress'),
					
					'before_widget' => '<div class="widget %2$s %1$s clearfix">',
					'after_widget' => '</div>',
					
					'before_title' => '<h3 class="widget_title">',
					'after_title' => '</h3>'
				)
			);

			// Footer #2
			register_sidebar(
				array(
					'id' => 'footer-2',
					'name' => esc_html__('Footer #2', 'dentalpress'),
					
					'before_widget' => '<div class="widget %2$s %1$s clearfix">',
					'after_widget' => '</div>',
					
					'before_title' => '<h3 class="widget_title">',
					'after_title' => '</h3>'
				)
			);

			// Footer #3
			register_sidebar(
				array(
					'id' => 'footer-3',
					'name' => esc_html__('Footer #3', 'dentalpress'),
					
					'before_widget' => '<div class="widget %2$s %1$s clearfix">',
					'after_widget' => '</div>',
					
					'before_title' => '<h3 class="widget_title">',
					'after_title' => '</h3>'
				)
			);

			// Footer #4
			register_sidebar(
				array(
					'id' => 'footer-4',
					'name' => esc_html__('Footer #4', 'dentalpress'),
					
					'before_widget' => '<div class="widget %2$s %1$s clearfix">',
					'after_widget' => '</div>',
					
					'before_title' => '<h3 class="widget_title">',
					'after_title' => '</h3>'
				)
			);

			// Custom Sidebars
			$sidebars = dentalpress_get_option('sidebars');

			if( is_array($sidebars) ) {
				foreach ($sidebars as $sidebar) {
					if( !empty($sidebar) ){
						register_sidebar(
							array(
								'id' => sanitize_title($sidebar),
								'name' => $sidebar,
								
								'before_widget' => '<div class="widget %2$s %1$s clearfix">',
								'after_widget' => '</div>',
								
								'before_title' => '<h3 class="widget_title">',
								'after_title' => '</h3>'
							)
						);
					}
				}
			}
		}

		// Register Theme Plugins
		function dentalpress_tgmpa_register() {
			$plugins = array(
				array(
					'name'                   => 'DentalPress Options',
					'slug'                   => 'dentalpress-options',
					'source'                 => DENTALPRESS_THEME_DIR .'plugins/dentalpress-options.zip',
					'required'               => true,
					'version'                => DENTALPRESS_THEME_VERSION,
					'force_activation'       => false,
					'force_deactivation'     => false,
				),
				array(
					'name'                   => 'DentalPress Shortcodes',
					'slug'                   => 'dentalpress-shortcodes',
					'source'                 => DENTALPRESS_THEME_DIR .'plugins/dentalpress-shortcodes.zip',
					'required'               => true,
					'version'                => DENTALPRESS_THEME_VERSION,
					'force_activation'       => false,
					'force_deactivation'     => false,
				),
				array(
					'name'                   => 'WP Bakery Visual Composer',
					'slug'                   => 'js_composer',
					'source'                 => DENTALPRESS_THEME_DIR .'plugins/js_composer.zip',
					'required'               => true,
					'version'                => '5.3',
					'force_activation'       => false,
					'force_deactivation'     => false,
				),
				array(
					'name'                   => 'Slider Revolution',
					'slug'                   => 'revslider',
					'source'                 => DENTALPRESS_THEME_DIR .'plugins/revslider.zip',
					'required'               => true,
					'version'                => '5.4.6.1',
					'force_activation'       => false,
					'force_deactivation'     => false,
				),
				array(
					'name'                   => 'Booked',
					'slug'                   => 'booked',
					'source'                 => DENTALPRESS_THEME_DIR .'plugins/booked.zip',
					'required'               => true,
					'version'                => '2.0.5',
					'force_activation'       => false,
					'force_deactivation'     => false,
				),
				array(
					'name'                   => 'Contact Form 7',
					'slug'                   => 'contact-form-7',
					'required'               => true
				)
			);
			
			$config = array(
				'domain'                              => 'dentalpress', 
				'default_path'                        => '',
				'parent_slug'                         => 'themes.php',
				'capability'                          => 'edit_theme_options',
				'menu'                                => 'install-required-plugins',
				'has_notices'                         => true,
				'dismissable'                         => true,
				'is_automatic'                        => false,
				'message'                             => '',
				'strings'                             => array(
					'page_title'                         => esc_html__( 'Install Required Plugins', 'dentalpress' ),
					'menu_title'                         => esc_html__( 'Install Plugins', 'dentalpress' ),
					'installing'                         => esc_html__( 'Installing Plugin: %s', 'dentalpress' ),
					'oops'                               => esc_html__( 'Something went wrong with the plugin API.', 'dentalpress' ),
					'notice_can_install_required'        => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'dentalpress' ),
					'notice_can_install_recommended'     => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'dentalpress' ),
					'notice_cannot_install'              => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'dentalpress' ),
					'notice_can_activate_required'       => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'dentalpress' ),
					'notice_can_activate_recommended'    => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'dentalpress' ), 
					'notice_cannot_activate'             => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'dentalpress' ),
					'notice_ask_to_update'               => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'dentalpress' ),
					'notice_cannot_update'               => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'dentalpress' ),
					'install_link'                       => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'dentalpress' ),
					'activate_link'                      => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'dentalpress' ),
					'return'                             => esc_html__( 'Return to Required Plugins Installer', 'dentalpress' ),
					'plugin_activated'                   => esc_html__( 'Plugin activated successfully.', 'dentalpress' ),
					'complete'                           => esc_html__( 'All plugins installed and activated successfully. %s', 'dentalpress' ), 
					'nag_type'                           => 'updated'
				)
			);

			tgmpa( $plugins, $config );
		}
	}

	$DentalPress_Actions = new DentalPress_Actions();
?>