<?php
	/**
	 *	DentalPress WordPress Theme
	 */

	class DentalPress_WC_Filters {
		function __construct() {
			add_filter( 'woocommerce_form_field_args', array($this, 'dentalpress_woocommerce_form_field_args'), 10, 3 );
			add_filter( 'loop_shop_per_page', array($this, 'dentalpress_loop_shop_per_page'), 20 );
			add_filter( 'loop_shop_columns', array($this, 'dentalpress_loop_shop_columns'), 1, 10 );
			add_filter( 'woocommerce_pagination_args', array($this, 'dentalpress_woocommerce_pagination_args') );
			add_filter( 'woocommerce_output_related_products_args', array($this, 'dentalpress_woocommerce_output_related_products_args') );
		}

		// Add an extra class for WC fields
		function dentalpress_woocommerce_form_field_args( $args, $key, $value ) {
			$args['input_class'] = array('form-control');

			return $args;
		}

		// Change number of products displayed per page
		function dentalpress_loop_shop_per_page($cols) {
			return absint(dentalpress_get_option('shop-product-count'));
		}

		// Change number of product columns
		function dentalpress_loop_shop_columns($number_columns) {
			$number_columns = 3;

			return $number_columns;
		}

		// Change pagination args
		function dentalpress_woocommerce_pagination_args($args) {
			$args['prev_text'] = '<i class="fa fa-angle-left"></i>';
			$args['next_text'] = '<i class="fa fa-angle-right"></i>';

			return $args;
		}

		// Change number of related products on product page
		function dentalpress_woocommerce_output_related_products_args($args) {
			$args['posts_per_page'] = 3;
			$args['columns'] = 3;

			return $args;
		}
	}

	$DentalPress_WC_Filters = new DentalPress_WC_Filters();
?>