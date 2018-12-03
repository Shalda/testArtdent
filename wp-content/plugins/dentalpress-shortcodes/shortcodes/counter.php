<?php 
	/**
	 * Counter Shortcode
	 *
	 * @param string $atts['digit']
	 * @param string $atts['digit_color']
	 * @param string $atts['label']
	 * @param string $atts['label_color']
	 * @param string $atts['delay']
	 * @param string $atts['time']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_counter_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"size" => "",
			"digit" => "",
			"digit_color" => "",
			"label" => "",
			"label_color" => "",
			"delay" => "",
			"time" => "",
			"class" => ""
		), $atts );

		ob_start();
	?>
		<div class="vu_counter vu_c-size-<?php echo esc_attr($atts['size']); ?><?php dentalpress_extra_class($atts['class']); ?>">
			<span class="vu_c-digit"<?php echo ((!empty($atts['delay'])) ? ' data-delay="'. esc_attr($atts['delay']) .'"' : '') . ((!empty($atts['time'])) ? ' data-time="'. esc_attr($atts['time']) .'"' : ''); ?><?php echo (!empty($atts['digit_color'])) ? ' style="color:'. esc_attr($atts['digit_color']) .'"' : ''; ?>><?php echo esc_html($atts['digit']); ?></span>
			<h5 class="vu_c-label"<?php echo (!empty($atts['label_color'])) ? ' style="color:'. esc_attr($atts['label_color']) .'"' : ''; ?>><?php echo esc_html($atts['label']); ?></h5>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_counter', 'dentalpress_counter_shortcode');

	/**
	 * Counter VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_counter extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_counter", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_counter', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Counter", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add counter", 'dentalpress-shortcodes'),
				"base"		=> "vu_counter",
				"class"		=> "vc_vu_counter",
				"icon"		=> "vu_element-icon vu_counter-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Size', 'dentalpress-shortcodes'),
						'param_name' => 'size',
						'value' => array(
							esc_html__("Large", 'dentalpress-shortcodes') => 'large',
							esc_html__("Small", 'dentalpress-shortcodes') => 'small'
						),
						"save_always" => true,
						"description" => esc_html__("Select counter size.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Digit", 'dentalpress-shortcodes'),
						"param_name" => "digit",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter counter digit. Eg. 1234.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Digit Color", 'dentalpress-shortcodes'),
						"param_name" => "digit_color",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select digit custom color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Label", 'dentalpress-shortcodes'),
						"param_name" => "label",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter counter label. Eg. Customers.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Label Color", 'dentalpress-shortcodes'),
						"param_name" => "label_color",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select label custom color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Delay", 'dentalpress-shortcodes'),
						"param_name" => "delay",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Specify time delay in milliseconds after which counter digit will begin to increase.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Time", 'dentalpress-shortcodes'),
						"param_name" => "time",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Specify time interval in milliseconds by which the last counter digit will be displayed. Default is 1000ms", 'dentalpress-shortcodes')
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