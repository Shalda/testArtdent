<?php 
	/*
		Plugin Name: DentalPress Shortcodes
		Plugin URI: http://flexipress.xyz/
		Author: FlexiPress
		Author URI: http://themeforest.net/user/flexipress
		Description: This plugin is required in order for the theme to work properly. It includes various shortcodes that have been developed exclusively for this theme.
		Version: 1.2
		Text Domain: dentalpress-shortcodes
		Domain Path: /languages
		License: GNU General Public License v2 or later
		License URI: license/README_License.txt
	*/

	if ( !defined('ABSPATH') ) exit();

	if( !class_exists('DentalPress_Shortcodes') ) {
		class DentalPress_Shortcodes {
			public $plugin_dir;
			
			public function __construct() {
				// Variables
				$this->plugin_dir = plugin_dir_path( __FILE__ );

				// Functions
				require_once($this->plugin_dir .'functions.php');

				// Library Files
				require_once($this->plugin_dir .'lib/twitter/class-ezTweet.php');
				require_once($this->plugin_dir .'lib/MailChimp.php');

				// VC
				if( !in_array('js_composer/js_composer.php', apply_filters('active_plugins', get_option('active_plugins'))) ) {
					require_once($this->plugin_dir .'lib/vc-addons/class-VcLoopQueryBuilder.php');
				}

				// Actions
				add_action('init', array($this, 'init'));
				add_action('init', array($this, 'shortcodes'));
			}

			public function init() {
				// Plugin Textdomain
				$textdomain = 'dentalpress-shortcodes';

				$locale = apply_filters( 'plugin_locale', get_locale(), $textdomain );

				if ( $loaded = load_textdomain( $textdomain, trailingslashit( WP_LANG_DIR ) . $textdomain . '/' . $textdomain . '-' . $locale . '.mo' ) ) {
					return $loaded;
				} else {
					load_plugin_textdomain( $textdomain, false, $this->plugin_dir . 'languages/' );
				}
			}

			public function shortcodes() {
				// Shortcodes
				require_once($this->plugin_dir .'shortcodes/heading.php');
				require_once($this->plugin_dir .'shortcodes/icon-box.php');
				require_once($this->plugin_dir .'shortcodes/icon-box-2.php');
				require_once($this->plugin_dir .'shortcodes/booked-calendar.php');
				require_once($this->plugin_dir .'shortcodes/image-box.php');
				require_once($this->plugin_dir .'shortcodes/image-switch.php');
				require_once($this->plugin_dir .'shortcodes/hover-box.php');
				require_once($this->plugin_dir .'shortcodes/pie-chart.php');
				require_once($this->plugin_dir .'shortcodes/blog.php');
				require_once($this->plugin_dir .'shortcodes/before-after.php');
				require_once($this->plugin_dir .'shortcodes/counter.php');
				require_once($this->plugin_dir .'shortcodes/gallery.php');
				require_once($this->plugin_dir .'shortcodes/gallery-item.php');
				require_once($this->plugin_dir .'shortcodes/filterable.php');
				require_once($this->plugin_dir .'shortcodes/filterable-item.php');
				require_once($this->plugin_dir .'shortcodes/video-section.php');
				require_once($this->plugin_dir .'shortcodes/map.php');
				require_once($this->plugin_dir .'shortcodes/contact-form-7.php');
				require_once($this->plugin_dir .'shortcodes/team-member.php');
				require_once($this->plugin_dir .'shortcodes/testimonial.php');
				require_once($this->plugin_dir .'shortcodes/timeline.php');
				require_once($this->plugin_dir .'shortcodes/countdown.php');
				require_once($this->plugin_dir .'shortcodes/progress-bar.php');
				require_once($this->plugin_dir .'shortcodes/client.php');
				require_once($this->plugin_dir .'shortcodes/pricing-table.php');
				require_once($this->plugin_dir .'shortcodes/pricing-list.php');
				require_once($this->plugin_dir .'shortcodes/call-to-action.php');
				require_once($this->plugin_dir .'shortcodes/image-slider.php');
				require_once($this->plugin_dir .'shortcodes/carousel.php');
				require_once($this->plugin_dir .'shortcodes/carousel-item.php');
				require_once($this->plugin_dir .'shortcodes/button.php');
				require_once($this->plugin_dir .'shortcodes/others.php');
			}
		}
	}

	if( class_exists('DentalPress_Shortcodes') ) {
		$DentalPress_Shortcodes = new DentalPress_Shortcodes();
	}
?>