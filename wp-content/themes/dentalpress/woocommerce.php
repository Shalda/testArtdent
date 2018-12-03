<?php 
	/*
		Template Name: WooCommerce
	*/

	get_header();

	$shop_page = get_option( 'woocommerce_shop_page_id' );
	
	$shop_sidebar = dentalpress_get_post_meta( $shop_page, 'dentalpress_page_options' );

	$has_sidebar = dentalpress_has_sidebar($shop_sidebar); ?>

	<!-- Content -->
	<div class="vu_content vu_woocommerce-page col-xs-12 col-md-9" role="main">
		<div class="<?php echo (is_single()) ? 'vu_c-wrapper ' : ''; ?>clearfix">
			<?php if( function_exists('woocommerce_content') ) { woocommerce_content(); } ?>
		</div>
	</div>
	<!-- /Content -->

	<?php if( $has_sidebar == true ) : ?>
		<aside class="vu_sidebar vu_s-<?php echo esc_attr($shop_sidebar['sidebar']); ?> col-xs-12 col-md-3" role="complementary" itemscope="itemscope" itemtype="https://schema.org/WPSideBar">
			<?php dentalpress_dynamic_sidebar( $shop_sidebar['sidebar'] ); ?>
		</aside>
	<?php endif; ?>
	
<?php get_footer(); ?>