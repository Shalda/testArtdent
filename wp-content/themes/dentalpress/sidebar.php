<?php 
	$dentalpress_page_options = dentalpress_get_post_meta( get_option( 'page_for_posts' ), 'dentalpress_page_options' );

	$has_sidebar = dentalpress_has_sidebar($dentalpress_page_options);

	if( $has_sidebar == true ) : ?>
		<aside class="vu_sidebar vu_s-<?php echo esc_attr($dentalpress_page_options['sidebar']); ?> col-xs-12 col-md-3" role="complementary" itemscope="itemscope" itemtype="https://schema.org/WPSideBar">
			<?php dentalpress_dynamic_sidebar( $dentalpress_page_options['sidebar'] ); ?>
		</aside>
	<?php endif;
?>