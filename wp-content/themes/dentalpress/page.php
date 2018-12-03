<?php 
	get_header();

	if ( have_posts() ) : while ( have_posts() ) : the_post(); 
		$dentalpress_page_options = dentalpress_get_post_meta( $post->ID, 'dentalpress_page_options' );

		$has_sidebar = dentalpress_has_sidebar($dentalpress_page_options); ?>
		
		<!-- Content -->
		<div class="vu_content col-xs-12<?php echo (dentalpress_get_option('navigation-position', 'sidebar') == 'sidebar' || $has_sidebar == true) ? ' col-md-9' : ''; ?>" role="main">
			<?php if ( (function_exists('is_woocommerce') and is_woocommerce()) or (function_exists('is_cart') and is_cart()) or (function_exists('is_checkout') and is_checkout()) or (function_exists('is_account_page') and is_account_page()) or !shortcode_exists('vc_section') ) : ?>
				<div class="vu_c-wrapper clearfix">
					<?php the_content(); ?>
				</div>
			<?php else : ?>
				<?php the_content(); ?>
			<?php endif; ?>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<div class="vu_c-wrapper clearfix">
					<div class="clear"></div>
					<div class="vu_page-comments container">
						<?php comments_template(); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<!-- /Content -->

		<?php if( $has_sidebar == true ) : ?>
			<aside class="vu_sidebar vu_s-<?php echo esc_attr($dentalpress_page_options['sidebar']); ?> col-xs-12 col-md-3" role="complementary" itemscope="itemscope" itemtype="https://schema.org/WPSideBar">
				<?php dentalpress_dynamic_sidebar( $dentalpress_page_options['sidebar'] ); ?>
			</aside>
		<?php endif; ?>

	<?php endwhile; endif;

	get_footer();
?>