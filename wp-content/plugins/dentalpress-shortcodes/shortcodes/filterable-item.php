<?php 
	/**
	 * Filterable Item Shortcode
	 *
	 * @param string $atts['category']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_filterable_item_shortcode( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			"category" => "",
			"class" => ""
		), $atts );

		$categories = @explode(',', $atts['category']);

		if( is_array($categories) ){
			foreach ($categories as $key => $value) {
				$categories[$key] = md5(sanitize_title($value));
			}
		} else {
			$categories = md5(sanitize_title($categories));
		}
		
		ob_start();
	?>
		<div class="vu_f-item <?php echo esc_attr( @implode(' ', $categories) ); ?><?php dentalpress_extra_class($atts['class']); ?>">
			<?php echo do_shortcode($content); ?>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_filterable_item', 'dentalpress_filterable_item_shortcode');

	/**
	 * Filterable Item VC Shortcode
	 */

	if( class_exists('WPBakeryShortCodesContainer') ) {
		class WPBakeryShortCode_vu_filterable_item extends WPBakeryShortCodesContainer {
		}

		vc_map(
			array(
				"name"		=> esc_html__("Filterable Item", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add filterable item", 'dentalpress-shortcodes'),
				"base"		=> "vu_filterable_item",
				"class"		=> "vc_vu_filterable_item",
				"icon"		=> "vu_filterable-item-icon",
				"controls"	=> "full",
				"as_child" => array( 'only' => 'vu_filterable' ),
				"js_view" => 'VcColumnView',
				"content_element" => true,
				"is_container" => true,
				"container_not_allowed" => false,
				"category"  => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				'default_content' => '',
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__("Category", 'dentalpress-shortcodes'),
						"param_name" => "category",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select filterable item category.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'dentalpress-shortcodes'),
						"param_name" => "class",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress-shortcodes')
					)
				)
			)
		);
	}
?>