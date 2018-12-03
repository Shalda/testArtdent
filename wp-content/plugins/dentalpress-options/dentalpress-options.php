<?php 
	/*
		Plugin Name: DentalPress Options
		Plugin URI: http://flexipress.xyz/
		Author: FlexiPress
		Author URI: http://themeforest.net/user/flexipress
		Description: This plugin is required in order for the theme to work properly. It includes advanced and flexible options that have been developed exclusively for this theme.
		Version: 1.2
		Text Domain: dentalpress-options
		Domain Path: /languages
		License: GNU General Public License v2 or later
		License URI: license/README_License.txt
	*/

	if ( !defined('ABSPATH') ) exit();

	if( !class_exists('DentalPress_Options') ) {
		class DentalPress_Options {
			public $plugin_dir;
			
			public function __construct() {
				// Variables
				$this->plugin_dir = plugin_dir_path( __FILE__ );

				// Framework
				require_once($this->plugin_dir .'framework/framework.php');
				
				// Options
				require_once($this->plugin_dir .'options.php');
				
				// Demo Import
				require_once($this->plugin_dir .'demo-import.php');

				// Actions
				add_action('init', array($this, 'init'));
				add_action('init', array($this, 'remove_redux_admin_notices'));
			}

			public function init() {
				// Plugin Textdomain
				$textdomain = 'dentalpress-options';

				$locale = apply_filters( 'plugin_locale', get_locale(), $textdomain );

				if ( $loaded = load_textdomain( $textdomain, trailingslashit( WP_LANG_DIR ) . $textdomain . '/' . $textdomain . '-' . $locale . '.mo' ) ) {
					return $loaded;
				} else {
					load_plugin_textdomain( $textdomain, false, $this->plugin_dir . 'languages/' );
				}
			}

			public function remove_redux_admin_notices() {
				// Remove Redux Admin Notices
				if ( class_exists('ReduxFrameworkPlugin') ) {
					remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
				}
				
				if ( class_exists('ReduxFrameworkPlugin') ) {
					remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
				}
			}
		}
	}

	if( class_exists('DentalPress_Options') ) {
		$DentalPress_Options = new DentalPress_Options();
	}
?>