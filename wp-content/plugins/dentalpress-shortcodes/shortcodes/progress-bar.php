<?php 
	/**
	 * Progress Bar Shortcode
	 *
	 * @param string $atts['label']
	 * @param string $atts['value']
	 * @param string $atts['text_color']
	 * @param string $atts['bar_color']
	 * @param string $atts['bar_bg_color']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_progress_bar_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"label" => "",
			"value" => "",
			"custom_color" => "",
			"text_color" => "",
			"bar_color" => "",
			"bar_bg_color" => "",
			"class" => ""
		), $atts );

		ob_start();
	?>
		<div class="vu_progress-bar<?php dentalpress_extra_class($atts['class']); ?>"<?php echo ($atts['custom_color'] == "1" && !empty($atts['text_color'])) ? ' style="color:'. esc_attr($atts['text_color']) .';"' : ''; ?> data-value="<?php echo absint($atts['value']); ?>">
			<h5 class="vu_pb-label"><?php echo esc_attr($atts['label']); ?></h5>
			<h5 class="vu_pb-count"><?php echo esc_attr($atts['value']); ?>%</h5>
			<div class="clear"></div>
			<div class="vu_pb-container"<?php echo ($atts['custom_color'] == "1" && !empty($atts['bar_bg_color'])) ? ' style="background-color:'. esc_attr($atts['bar_bg_color']) .';"' : ''; ?>>
				<div class="vu_pb-bar"<?php echo ($atts['custom_color'] == "1" && !empty($atts['bar_color'])) ? ' style="background-color:'. esc_attr($atts['bar_color']) .';"' : ''; ?>>
				</div>
			</div>
		</div>
	<?php 
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_progress_bar', 'dentalpress_progress_bar_shortcode');

	/**
	 * Progress Bar VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_progress_bar extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_progress_bar", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_progress_bar', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Progress Bar", 'dentalpress-shortcodes'),
				"description" => esc_html__('Add progress bar', 'dentalpress-shortcodes'),
				"base"		=> "vu_progress_bar",
				"class"		=> "vc_vu_progress_bar",
				"icon"		=> "vu_element-icon vu_progress-bar-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__("Label", 'dentalpress-shortcodes'),
						"param_name" => "label",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter text used as title of bar.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Value", 'dentalpress-shortcodes'),
						"param_name" => "value",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter value of bar from 0 to 100.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Use Custom Color", 'dentalpress-shortcodes'),
						"param_name" => "custom_color",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check this to select custom colors.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Text Color", 'dentalpress-shortcodes'),
						"param_name" => "text_color",
						"dependency" => array("element" => "custom_color", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select custom bar text color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Bar Color", 'dentalpress-shortcodes'),
						"param_name" => "bar_color",
						"dependency" => array("element" => "custom_color", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select custom bar color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Bar Background Color", 'dentalpress-shortcodes'),
						"param_name" => "bar_bg_color",
						"dependency" => array("element" => "custom_color", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select custom bar background color.", 'dentalpress-shortcodes')
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