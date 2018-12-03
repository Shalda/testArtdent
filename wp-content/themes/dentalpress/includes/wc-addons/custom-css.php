<?php 
	// Custom CSS
	if( !function_exists('dentalpress_wc_custom_css') ){
		function dentalpress_wc_custom_css($echo = false){
			// Primary Color - Default : #50b0e3
			$primary_color_hex = esc_attr(dentalpress_get_option('primary-color', '#50b0e3'));
			$primary_color_rgb = esc_attr(dentalpress_hex2rgb($primary_color_hex, true));

			// Secondary Color - Default : #a4d735
			$secondary_color_hex = esc_attr(dentalpress_get_option('secondary-color', '#a4d735'));
			$secondary_color_rgb = esc_attr(dentalpress_hex2rgb($secondary_color_hex, true));

			ob_start();
		?>
			/* WooCommerce */

			.vu_wc-title {
			  border-left: 2px solid <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce input.button,
			.woocommerce button.button,
			.woocommerce a.button {
			  border: 1px solid <?php echo ($primary_color_hex); ?>;
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_main-footer .woocommerce input.button,
			.vu_main-footer .woocommerce button.button,
			.vu_main-footer .woocommerce a.button {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce input.button:hover,
			.woocommerce button.button:hover,
			.woocommerce a.button:hover {
			  color: <?php echo ($primary_color_hex); ?> !important;
			  border-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_main-footer .woocommerce input.button:hover,
			.vu_main-footer .woocommerce button.button:hover,
			.vu_main-footer .woocommerce a.button:hover {
			  color: <?php echo ($secondary_color_hex); ?> !important;
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce .button.checkout,
			.woocommerce input.alt,
			.woocommerce button.alt,
			.woocommerce a.alt {
			  color: <?php echo ($primary_color_hex); ?> !important;
			  border-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_main-footer .woocommerce .button.checkout,
			.vu_main-footer .woocommerce input.alt,
			.vu_main-footer .woocommerce button.alt,
			.vu_main-footer .woocommerce a.alt {
			  color: <?php echo ($secondary_color_hex); ?> !important;
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce .button.checkout:hover,
			.woocommerce input.alt:hover,
			.woocommerce button.alt:hover,
			.woocommerce a.alt:hover {
			  color: #fff !important;
			  border-color: <?php echo ($primary_color_hex); ?>;
			  background-color: <?php echo ($primary_color_hex); ?> !important;
			}
			.vu_main-footer .woocommerce .button.checkout:hover,
			.vu_main-footer .woocommerce input.alt:hover,
			.vu_main-footer .woocommerce button.alt:hover,
			.vu_main-footer .woocommerce a.alt:hover {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			  background-color: <?php echo ($secondary_color_hex); ?> !important;
			}
			.woocommerce ul.products li.product .onsale,
			.woocommerce span.onsale {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce ul.products li.product .onsale:before,
			.woocommerce ul.products li.product .onsale:after {
			  border-top-color: <?php echo ($secondary_color_hex); ?>;
			  border-left-color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce ul.products li.product:hover h3,
			.woocommerce ul.products li.product:hover .woocommerce-loop-product__title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.woocommerce ul.products li.product .star-rating {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce ul.products li.product a.button.loading:before,
			.woocommerce ul.products li.product a.button.loading:after,
			.woocommerce ul.products li.product a.button.added:after {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce div.product .product_title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.woocommerce .woocommerce-product-rating .star-rating {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce #reviews #comments ol.commentlist li .star-rating {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce #review_form #respond #reply-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.woocommerce #review_form #respond p.stars a,
			.woocommerce #review_form #respond p.stars .active {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce-cart .cart-collaterals .cart_totals table th {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.woocommerce table.customer_details th,
			.woocommerce table.customer_details td,
			.woocommerce table.order_details th,
			.woocommerce table.order_details td,
			.woocommerce table.woocommerce-checkout-review-order-table th,
			.woocommerce table.woocommerce-checkout-review-order-table td {
			  color: <?php echo ($primary_color_hex); ?> !important;
			}
			.woocommerce form .form-row .required {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_wc-menu-item .vu_wc-cart-link:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_wc-menu-item .vu_wc-count {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_wc-menu-item .vu_wc-cart-notification {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_wc-menu-item .vu_wc-cart-notification:before {
			  border-bottom-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_wc-menu-item .vu_wc-cart-notification .vu_wc-item-name {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_wc-menu-item .vu_wc-cart .widget_shopping_cart_content {
			  border-bottom: 2px solid <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce.widget_shopping_cart .widget_shopping_cart_content .cart_list li a:hover {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce.widget_shopping_cart .widget_shopping_cart_content .total .amount {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_main-footer .woocommerce.widget_shopping_cart .widget_shopping_cart_content .total .amount {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce-product-search:after {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.woocommerce.widget_product_categories a:hover,
			.woocommerce.widget_product_categories a:hover + .count,
			.woocommerce.widget_layered_nav a:hover,
			.woocommerce.widget_layered_nav a:hover + .count {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_main-footer .woocommerce ul.cart_list li a:hover,
			.vu_main-footer .woocommerce ul.product_list_widget li a:hover {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce ul.cart_list li .star-rating,
			.woocommerce ul.product_list_widget li .star-rating {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce.widget_product_tag_cloud a {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.woocommerce.widget_product_tag_cloud a.active,
			.woocommerce.widget_product_tag_cloud a:hover {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.woocommerce.widget_price_filter .ui-slider .ui-slider-handle {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.woocommerce.widget_price_filter .ui-slider .ui-slider-range {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
		<?php 
			$custom_css = ob_get_contents();
			ob_end_clean();

			if( $echo ){
				echo dentalpress_css_compress($custom_css);
			} else {
				return dentalpress_css_compress($custom_css);
			}
		}
	}
?>