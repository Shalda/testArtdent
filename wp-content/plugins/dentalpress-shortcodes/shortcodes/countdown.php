<?php 
	/**
	 * Countdown Shortcode
	 *
	 * @param string $atts['date']
	 * @param string $atts['format']
	 * @param string $atts['size']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_countdown_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'date' => '',
			'format' => 'dHMS',
			'size' => '',
			'class' => ''
		), $atts );

		wp_enqueue_script('countdown');

		ob_start();
	?>
		<div class="vu_countdown vu_c-size-<?php echo esc_attr($atts['size']); ?> clearfix<?php dentalpress_extra_class($atts['class']); ?>" data-date="<?php echo esc_attr($atts['date']); ?>" data-format="<?php echo esc_attr($atts['format']); ?>"></div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_countdown', 'dentalpress_countdown_shortcode');

	/**
	 * Countdown VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_countdown extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_countdown", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_countdown', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Countdown", 'dentalpress-shortcodes'),
				"description" => esc_html__('Add countdown', 'dentalpress-shortcodes'),
				"base"		=> "vu_countdown",
				"class"		=> "vc_vu_countdown",
				"icon"		=> "vu_element-icon vu_countdown-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__("Date", 'dentalpress-shortcodes'),
						"param_name" => "date",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => wp_kses( __("Enter date in '<b>yyyy-mm-dd</b>' format.", 'dentalpress-shortcodes'), array('b' => array()) )
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Format", 'dentalpress-shortcodes'),
						"param_name" => "format",
						"admin_label" => true,
						"value" => "dHMS",
						"save_always" => true,
						"description" => wp_kses( __("Enter date format. Default is <b>dHMS</b>.", 'dentalpress-shortcodes'), array('b' => array()) )
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Size", 'dentalpress-shortcodes'),
						"param_name" => "size",
						"value" => array(
							esc_html__('Large', 'dentalpress-shortcodes') => "large",
							esc_html__('Medium', 'dentalpress-shortcodes') => "medium",
							esc_html__('Small', 'dentalpress-shortcodes') => "small"
						),
						"std" => 'large',
						"save_always" => true,
						"description" => esc_html__("Select gallery item link type.", 'dentalpress-shortcodes'),
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