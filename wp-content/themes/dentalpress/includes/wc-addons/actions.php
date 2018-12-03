<?php
	/**
	 *	DentalPress WordPress Theme
	 */

	class DentalPress_WC_Actions {
		function __construct() {
			add_action( 'init', array($this, 'dentalpress_init') );
			add_action( 'wp_enqueue_scripts', array($this, 'dentalpress_wp_enqueue_scripts') );
			add_action( 'wp_head', array($this, 'dentalpress_wp_head') );
			add_action( 'wp_footer', array($this, 'dentalpress_wp_footer') );
			add_action( 'woocommerce_share', array($this, 'dentalpress_woocommerce_share') );
		}

		// Theme initialization
		function dentalpress_init() {
			wp_register_style('dentalpress-woocommerce', DENTALPRESS_THEME_ASSETS . 'css/woocommerce.css', array('dentalpress-main'), DENTALPRESS_THEME_VERSION);
			wp_register_script('dentalpress-woocommerce', DENTALPRESS_THEME_ASSETS . 'js/woocommerce.js', array('jquery'), DENTALPRESS_THEME_VERSION, true);
		}

		// Enqueue Scripts
		function dentalpress_wp_enqueue_scripts() {
			wp_enqueue_style('dentalpress-woocommerce');
		}

		// Head Init
		function dentalpress_wp_head() {
			echo '<style type="text/css" id="dentalpress_wc-custom-css">'. dentalpress_wc_custom_css() .'</style>';
		}

		// Footer Init
		function dentalpress_wp_footer() {
			wp_enqueue_script('dentalpress-woocommerce');
		}
		
		// Print Product Socials Networks
		function dentalpress_woocommerce_share() {
			global $post;

			$url = get_permalink();
			$title = get_the_title();
			$post_id = get_the_ID();

			if( dentalpress_get_option('shop-product-socials-show') ) : ?>
				<div class="vu_wc-product-social-networks clearfix">
					<ul class="list-unstyled">
					<?php if( dentalpress_get_option( array('shop-product-socials','facebook') ) == '1' ) { ?>
						<li>
							<a href="#" class="vu_social-link" data-href="http://www.facebook.com/sharer.php?u=<?php echo esc_url($url); ?>&amp;t=<?php echo urlencode($title); ?>"><i class="fa fa-facebook"></i></a>
						</li>
					<?php } if( dentalpress_get_option( array('shop-product-socials','twitter') ) == '1' ) { ?>
						<li>
							<a href="#" class="vu_social-link" data-href="https://twitter.com/share?text=<?php echo urlencode($title); ?>&amp;url=<?php echo esc_url($url); ?>"><i class="fa fa-twitter"></i></a>
						</li>
					<?php } if( dentalpress_get_option( array('shop-product-socials','google-plus') ) == '1' ) { ?>
						<li>
							<a href="#" class="vu_social-link" data-href="https://plus.google.com/share?url=<?php echo esc_url($url); ?>"><i class="fa fa-google-plus"></i></a>
						</li>
					<?php } if( dentalpress_get_option( array('shop-product-socials','pinterest') ) == '1' ) { ?>
						<li>
							<a href="#" class="vu_social-link" data-href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($url); ?>&amp;description=<?php echo urlencode($title); ?>&amp;media=<?php echo dentalpress_get_attachment_image_src($post_id, array(705, 470)); ?>"><i class="fa fa-pinterest"></i></a>
						</li>
					<?php } if( dentalpress_get_option( array('shop-product-socials','linkedin') ) == '1' ) { ?>
						<li>
							<a href="#" class="vu_social-link" data-href="http://linkedin.com/shareArticle?mini=true&amp;title=<?php echo urlencode($title); ?>&amp;url=<?php echo esc_url($url); ?>"><i class="fa fa-linkedin"></i></a>
						</li>
					<?php } ?>
					</ul>
				</div>
		<?php 
			endif;
		}
	}

	$DentalPress_WC_Actions = new DentalPress_WC_Actions();
?>