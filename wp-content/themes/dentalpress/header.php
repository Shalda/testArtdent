<?php 
	if( dentalpress_get_option('site-mode') == 'under_construction' and get_the_ID() != dentalpress_get_option('site-mode-page') and !is_user_logged_in() ){
		wp_redirect( get_permalink( absint(dentalpress_get_option('site-mode-page')) ) ); exit;
	}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php echo esc_attr( get_bloginfo("charset") ); ?>">

	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<link rel="pingback" href="<?php echo esc_url( get_bloginfo("pingback_url") ); ?>">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope="itemscope" itemtype="https://schema.org/WebPage">
	<?php if( dentalpress_get_option('preloader') == true ) : ?>
		<div id="vu_preloader"></div>
	<?php endif; ?>
	
	<!-- Main Container -->
	<div class="vu_main-container">
		<?php if( !is_page_template('template-blank.php') ) : ?>
			<!-- Header -->
			<?php $dentalpress_page_options = ($post || is_404()) ? dentalpress_get_post_meta( (((is_home() || is_404() || (get_post_type() == 'post')) ? get_option('page_for_posts') : $post->ID)), 'dentalpress_page_options' ) : null; ?>
			<header id="vu_main-header" class="vu_main-header" role="banner" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
				<?php if( dentalpress_get_option('top-bar-show') ) : ?>
					<div class="vu_top-bar">
						<div class="container">
							<div class="row">
								<div class="vu_tp-left col-md-7">
									<?php echo do_shortcode( wp_kses_post( dentalpress_get_option('top-bar-left-content') ) ); ?>
								</div>
								<div class="vu_tp-right col-md-5">
									<?php echo do_shortcode( wp_kses_post( dentalpress_get_option('top-bar-right-content') ) ); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="vu_h-container">
					<div class="container">
						<div id="vu_menu-affix" class="vu_menu-affix">
							<div class="vu_main-menu-container" data-type="logo-center">
								<div class="vu_h-content">
									<div class="vu_d-tr">
										<div class="vu_h-left vu_logo-container vu_d-td"> 
											<div class="vu_site-logo">
												<a href="<?php echo esc_url( home_url('/') ); ?>">
													<img class="vu_sl-img" alt="site-logo" width="<?php echo esc_attr(dentalpress_get_option( array('logo', 'width') )); ?>" height="<?php echo esc_attr(dentalpress_get_option( array('logo', 'height') )); ?>" src="<?php echo esc_url(dentalpress_get_option( array('logo', 'url') )); ?>">
												</a>
											</div>

											<a href="#" class="vu_mm-toggle vu_mm-open"><i class="fa fa-bars"></i></a>

											<?php 
												if ( function_exists('dentalpress_wc_show_responsive_basket_icon') ) {
													dentalpress_wc_show_responsive_basket_icon(true);
												}
											?>
										</div>

										<div class="vu_h-right vu_h-widgets">
											<?php echo do_shortcode( wp_kses_post(dentalpress_get_option('header-widgets') ) ); ?>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="vu_menu-affix-height"></div>
					</div>
				</div>

				<?php 
					if (dentalpress_get_option('navigation-position', 'sidebar') == 'header') {
						dentalpress_main_menu();
					}
				?>
			</header><!-- /Header -->

			<?php 
				$header_title = $header_subtitle = $header_bg = null;
				$post_id = !empty($post->ID) ? $post->ID : null;

				if( is_home() or is_page() or is_single() and get_post_type() != 'product' ){
					$post_id = (get_post_type() == 'post') ? get_option( 'page_for_posts' ) : $post->ID;
				} else if( is_tax() ){
					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

					$header_title = $term->name;

					// WooCommerce
					if( $term->taxonomy == 'product_cat' ){
						$header_subtitle = sprintf(__("All products from '%s' category", 'dentalpress'), $term->name);

						if( function_exists('get_woocommerce_term_meta') ) {
							$header_bg = dentalpress_get_attachment_image_src( absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) ), 'full' );
						} else {
							$header_bg = dentalpress_get_page_header_bg( get_option( 'woocommerce_shop_page_id' ) );
						}
					} else if( $term->taxonomy == 'product_tag' ){
						$header_subtitle = sprintf(__("All products tagged with '%s'", 'dentalpress'), $term->name);
						$header_bg = dentalpress_get_page_header_bg( get_option( 'woocommerce_shop_page_id' ) );
					}
				} else if( is_tag() ){
					$post_id = get_option( 'page_for_posts' );

					$header_title = esc_html__("Archive for tag", 'dentalpress');
					$header_subtitle = sprintf("%s", single_tag_title('', false));
					$header_bg = dentalpress_get_page_header_bg( get_option( 'page_for_posts' ) );
				} else if( is_category() ){
					$post_id = get_option( 'page_for_posts' );

					$header_title = esc_html__("Archive for category", 'dentalpress');
					$header_subtitle = sprintf("%s", single_cat_title('', false));
					$header_bg = dentalpress_get_page_header_bg( get_option( 'page_for_posts' ) );
				} else if( is_author() ){
					$post_id = get_option( 'page_for_posts' );

					$current_author = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

					$header_title = esc_html__("Archive for author", 'dentalpress');
					$header_subtitle = sprintf("%s", $current_author->nickname);
					$header_bg = dentalpress_get_page_header_bg( get_option( 'page_for_posts' ) );
				} else if( is_archive() ){
					$post_id = get_option( 'page_for_posts' );

					if( is_day() ){
						$header_title = esc_html__('Archive for date', 'dentalpress');
						$date_title = get_the_date();
					} else if( is_month() ){
						$header_title = esc_html__('Archive for month', 'dentalpress');
						$date_title = get_the_date('F Y');
					} else {
						$header_title = esc_html__('Archive for year', 'dentalpress');
						$date_title = get_the_date('Y');
					}

					$header_subtitle = sprintf("%s", $date_title);
					$header_bg = dentalpress_get_page_header_bg( get_option( 'page_for_posts' ) );

					if( function_exists('is_shop') and is_shop() ) {
						$post_id = get_option( 'woocommerce_shop_page_id' );
						$header_title = $header_subtitle = $header_bg = null;
					}
				} else if( is_search() ){
					$post_id = get_option( 'page_for_posts' );

					$header_title = esc_html__("Search results for", 'dentalpress');
					$header_subtitle = sprintf("%s", get_search_query());

					$header_bg = dentalpress_get_page_header_bg( get_option( 'page_for_posts' ) );
				} else if( is_404() ) {
					$post_id = get_option( 'page_for_posts' );

					$header_title = esc_html__("Error 404", 'dentalpress');
					$header_bg = null;
					$header_subtitle = esc_html__("Page not found", 'dentalpress');
				} else if( function_exists('is_cart') and is_cart() ) {
					$post_id = get_option( 'woocommerce_cart_page_id' );
				} else if( function_exists('is_product') and is_product() ){
					$post_id = get_option( 'woocommerce_shop_page_id' );
				} else if( is_page() ) {
					$post_id = $post->ID;
				} else {
					$header_title = $header_subtitle = $header_bg = null;
				}

				dentalpress_page_header($post_id, $header_title, $header_subtitle, $header_bg);
			?>

			<!-- Container -->
			<div class="vu_container">
				<div class="row">

					<?php 
						if (dentalpress_get_option('navigation-position', 'sidebar') == 'sidebar') {
							dentalpress_main_menu();
						}
					?>
		<?php endif; ?>