<?php 
	/**
	 * Carousel Item Shortcode
	 *
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_carousel_item_shortcode( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			"class" => "",
			"css" => "",
		), $atts );

		if( function_exists('vc_shortcode_custom_css_class') ) {
			$custom_css_class = vc_shortcode_custom_css_class( $atts['css'] );
		}
		
		ob_start();
	?>
		<div class="vu_carousel-item<?php dentalpress_extra_class($atts['class']); ?>">
			<?php 
				if ( isset($custom_css_class) and !empty($custom_css_class) ) {
					echo '<div class="'. esc_attr($custom_css_class) .'">'. do_shortcode($content) .'</div>';
				} else {
					echo do_shortcode($content);
				}
			?>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_carousel_item', 'dentalpress_carousel_item_shortcode');

	/**
	 * Carousel Item VC Shortcode
	 */

	if( class_exists('WPBakeryShortCodesContainer') ) {
		class WPBakeryShortCode_vu_carousel_item extends WPBakeryShortCodesContainer {
		}

		vc_map(
			array(
				"name"		=> esc_html__("Carousel Item", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add filterable item", 'dentalpress-shortcodes'),
				"base"		=> "vu_carousel_item",
				"class"		=> "vc_vu_carousel_item",
				"icon"		=> "vu_element-icon vu_carousel-item-icon",
				"controls"	=> "full",
				"as_child" => array( 'only' => 'vu_carousel' ),
				"js_view" => 'VcColumnView',
				"content_element" => true,
				"is_container" => true,
				"container_not_allowed" => false,
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				'default_content' => '',
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'dentalpress-shortcodes'),
						"param_name" => "class",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__("Design Options", 'dentalpress-shortcodes' ),
						"type" => "css_editor",
						"heading" => esc_html__("CSS box", 'dentalpress-shortcodes' ),
						"param_name" => "css"
					)
				)
			)
		);
	}
?>