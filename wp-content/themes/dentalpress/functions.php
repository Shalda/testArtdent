<?php
	/**
	 * DentalPress WordPress Theme
	 */

	// Constants
	define('DENTALPRESS_THEME_DIR', get_template_directory() .'/');
	define('DENTALPRESS_THEME_URL', get_template_directory_uri() .'/');
	define('DENTALPRESS_THEME_ASSETS', DENTALPRESS_THEME_URL .'assets/');
	define('DENTALPRESS_THEME_ADMIN_ASSETS', DENTALPRESS_THEME_URL .'includes/admin/');
	define('DENTALPRESS_THEME_VERSION', '1.2');

	// Core Files
	require_once(DENTALPRESS_THEME_DIR .'includes/functions.php');
	require_once(DENTALPRESS_THEME_DIR .'includes/actions.php');
	require_once(DENTALPRESS_THEME_DIR .'includes/filters.php');

	// Meta
	require_once(DENTALPRESS_THEME_DIR .'includes/meta/config.php');
	require_once(DENTALPRESS_THEME_DIR .'includes/meta/page-options.php');
	require_once(DENTALPRESS_THEME_DIR .'includes/meta/post-meta.php');

	// Library Files
	require_once(DENTALPRESS_THEME_DIR .'includes/lib/breadcrumbs.php');
	require_once(DENTALPRESS_THEME_DIR .'includes/lib/class-tgm-plugin-activation.php');

	// Custom CSS
	require_once(DENTALPRESS_THEME_DIR .'includes/custom-css.php');

	// VC Files
	if( in_array('js_composer/js_composer.php', apply_filters('active_plugins', get_option('active_plugins'))) ) {
		require_once(DENTALPRESS_THEME_DIR .'includes/vc-addons/config.php');
		require_once(DENTALPRESS_THEME_DIR .'includes/vc-addons/params.php');
		require_once(DENTALPRESS_THEME_DIR .'includes/vc-addons/modify.php');
	} else {
		require_once(DENTALPRESS_THEME_DIR .'includes/vc-addons/functions.php');
	}

	// WC Files
	if( in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ) {
		require_once(DENTALPRESS_THEME_DIR .'includes/wc-addons/custom-css.php');
		require_once(DENTALPRESS_THEME_DIR .'includes/wc-addons/actions.php');
		require_once(DENTALPRESS_THEME_DIR .'includes/wc-addons/filters.php');
	}

	// ---------------------------------------------- Functions ----------------------------------------------

	// Print Main Menu
	if( !function_exists('dentalpress_main_menu') ) {
		function dentalpress_main_menu() {
			?>
				<!-- Main Navigation -->
				<div class="vu_main-navigation-container<?php echo (dentalpress_get_option('navigation-position', 'sidebar') == 'sidebar') ? ' col-xs-12 col-md-3' : ''; ?>">
					<nav class="vu_main-navigation vu_main-menu" role="navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">
						<?php 
							// Main Menu
							wp_nav_menu(
									array(
									'theme_location'  => ( isset($dentalpress_page_options['menu-navigation']) && $dentalpress_page_options['navigation'] != '' ) ? '' : 'main-navigation',
									'menu'            => ( isset($dentalpress_page_options['navigation']) && $dentalpress_page_options['navigation'] != '' ) ? $dentalpress_page_options['navigation'] : '',
									'container'       => false,
									'container_id'    => false,
									'container_class' => false,
									'menu_id'         => 'vu_mm-navigation',
									'menu_class'      => 'vu_mm-list vu_mm-navigation list-unstyled',
									'items_wrap'      => dentalpress_main_menu_wrap(),
									'fallback_cb'     => dentalpress_main_menu_fallback_cb('main-navigation'),
								)
							);
						?>
					</nav>
					<div class="clear"></div>
				</div>
				<!-- /Main Navigation -->
			<?php 
		}
	}

	// Main Menu Wrap
	if( !function_exists('dentalpress_main_menu_wrap') ) {
		function dentalpress_main_menu_wrap() {
			$wrap  = '<ul id="%1$s" class="%2$s'. (trim(dentalpress_get_option( array('main-submenu-typography', 'text-align') )) != '' ? ' vu_mm-submenu-'. dentalpress_get_option( array('main-submenu-typography', 'text-align') ) : '') .'">';
			$wrap .= '%3$s';
			
			// WC Cart
			if( function_exists('dentalpress_wc_show_menu_basket_icon') ) {
				$wrap .= dentalpress_wc_show_menu_basket_icon();
			}

			$wrap .= '</ul>';

			return $wrap;
		}
	}

	// Main Menu fallback_cb
	if( !function_exists('dentalpress_main_menu_fallback_cb') ) {
		function dentalpress_main_menu_fallback_cb($menu_location = 'main-menu-full') {
			$nav_menu_locations = get_theme_mod('nav_menu_locations');
			
			if( !isset($nav_menu_locations[$menu_location]) or $nav_menu_locations[$menu_location] == 0 ) {
				$menu = wp_page_menu(
					array(
						'menu_id'     => 'vu_mm-top',
						'menu_class'  => 'vu_mm-list vu_mm-top list-unstyled',
						'container'   => 'ul',
						'echo'        => false,
						'before'      => '',
						'after'       => ''
					)
				);

				$menu = preg_replace("/class='children'/", "class='children sub-menu'", $menu );

				$menu = preg_replace("/page_item_has_children/", "page_item_has_children menu-item-has-children", $menu );

				echo preg_replace("/current_page_item/", "current_page_item current-menu-item", $menu );
			}
		}
	}

	// Print Page Header
	if( !function_exists('dentalpress_page_header') ) {
		function dentalpress_page_header($post_id, $title = null, $subtitle = null, $bg = null){
			$dentalpress_page_options = dentalpress_get_post_meta( $post_id, 'dentalpress_page_options' );

			if ( isset($dentalpress_page_options['header']) && ( $dentalpress_page_options['header'] == 'no' || ( $dentalpress_page_options['header'] == 'inherit' && dentalpress_get_option('page-header-show') == false ) ) ) {
				return;
			}

			if( empty($title) ) {
				if( !empty($dentalpress_page_options['title']) ) {
					$title = $dentalpress_page_options['title'];
				} else if( is_front_page() and is_home() ) {
					$title = esc_html__('Latest Posts', 'dentalpress');
				} else if ( is_single() and get_post_type() != 'product' ) {
					$title = ( get_option('page_for_posts', false) != false ) ? get_the_title( get_option('page_for_posts') ) : esc_html__('Latest Posts', 'dentalpress');
				} else {
					$title = get_the_title($post_id);
				}
			}

			if( empty($subtitle) ) {
				$subtitle = $dentalpress_page_options['subtitle'];
			}

			if( empty($bg) ) {
				$bg = absint($dentalpress_page_options['bg']);
			}

			if( empty($bg) ) {
				$bg = absint(dentalpress_get_option( array('page-header-bg-image', 'id') ));
			}

			$parallax = ( isset($dentalpress_page_options['parallax']) && ( $dentalpress_page_options['parallax'] == 'yes' || ( $dentalpress_page_options['parallax'] == 'inherit' && dentalpress_get_option('page-header-parallax') == true ) ) ) ? true : false;
			?>
				<!-- Page Header -->
				<section class="vu_page-header<?php echo ( !empty($bg) ) ? ' vu_ph-with-bg' : ''; ?><?php echo ( !empty($bg) && $parallax != true ) ? ' vu_ph-with-bg vu_lazy-load' : ''; ?>"<?php echo ( !empty($bg) && $parallax == true ) ? ' data-parallax="scroll" data-image-src="'. dentalpress_get_attachment_image_src($bg, 'full') .'"' : ' data-img="'. dentalpress_get_attachment_image_src($bg, 'full') .'"'; ?>>
					<div class="vu_ph-container">
						<div class="vu_ph-content">
							<?php echo !empty($title) ? '<h1 class="vu_ph-title">'. esc_html($title) .'</h1>' : ''; ?>

							<?php if ( isset($dentalpress_page_options['breadcrumbs']) && $dentalpress_page_options['breadcrumbs'] == '1' ) : ?>
							<div class="vu_ph-breadcrumbs">
								<?php dentalpress_breadcrumbs(); ?>
							</div>
						<?php else : ?>
							<?php if ( !empty($subtitle) ) : ?>
								<span class="vu_ph-subtitle"><?php echo nl2br($subtitle); ?></span>
							<?php endif; ?>
						<?php endif; ?>
						</div>
					</div>
				</section>
				<!-- /Page Header -->
			<?php 
		}
	}

	// Get Page Header Background
	if( !function_exists('dentalpress_get_page_header_bg') ) {
		function dentalpress_get_page_header_bg($post_id){
			$dentalpress_page_options = dentalpress_get_post_meta( $post_id, 'dentalpress_page_options' );

			if( isset($dentalpress_page_options['bg']) and !empty($dentalpress_page_options['bg']) ){
				return absint($dentalpress_page_options['bg']);
			}

			return false;
		}
	}

	// Get the URL (src) for an image attachment
	if( !function_exists('dentalpress_get_attachment_image_src') ){
		function dentalpress_get_attachment_image_src($attachment_id, $size = 'thumbnail', $icon = false, $return = 'url'){
			$image_attributes = wp_get_attachment_image_src( $attachment_id, $size, $icon );
			
			if( $image_attributes ) {
				switch ($return) {
					case 'all':
						return $image_attributes;
						break;
					case 'url':
						return esc_url( $image_attributes[0] );
						break;
					case 'width':
						return $image_attributes[1];
						break;
					case 'height':
						return $image_attributes[2];
						break;
					case 'resized ':
						return $image_attributes[3];
						break;
				}
			} else {
				return false;
			}
		}
	}

	// Get theme option value
	if( !function_exists('dentalpress_get_option') ){
		function dentalpress_get_option($option, $default = ''){
			global $dentalpress_theme_options;

			if( (empty($dentalpress_theme_options) or !isset($dentalpress_theme_options['last_tab'])) and !isset($dentalpress_theme_options['default-options']) ) {
				$dentalpress_theme_options = dentalpress_default_theme_options();
			}

			if( is_array($option) ){
				$count = count($option);

				switch ($count) {
					case 2:
						return isset($dentalpress_theme_options[$option[0]][$option[1]]) ? $dentalpress_theme_options[$option[0]][$option[1]] : $default;
						break;
					case 3:
						return isset($dentalpress_theme_options[$option[0]][$option[1]][$option[2]]) ? $dentalpress_theme_options[$option[0]][$option[1]][$option[2]] : $default;
						break;
						
					default:
						return isset($dentalpress_theme_options[$option[0]]) ? $dentalpress_theme_options[$option[0]] : $default;
						break;
				}
			} else {
				return isset($dentalpress_theme_options[$option]) ? $dentalpress_theme_options[$option] : $default;
			}
		}
	}
?>