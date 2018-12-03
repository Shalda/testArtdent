<?php 
	/**
	 * Before After Shortcode
	 *
	 * @param string $atts['before_image']
	 * @param string $atts['after_image']
	 * @param string $atts['ratio']
	 * @param string $atts['orientation']
	 * @param string $atts['show_label']
	 * @param string $atts['before_label']
	 * @param string $atts['after_label']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_before_after_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"before_image" => "",
			"after_image" => "",
			"ratio" => "",
			"orientation" => "",
			"show_label" => "",
			"before_label" => "",
			"after_label" => "",
			"class" => ""
		), $atts );

		$options = array(
			'ratio' => esc_attr($atts['ratio']),
			'orientation' => esc_attr($atts['orientation']),
			'show_label' => esc_attr($atts['show_label']),
			'before_label' => esc_attr($atts['before_label']),
			'after_label' => esc_attr($atts['after_label'])
		);

		ob_start();
	?>
		<div class="vu_before-after<?php dentalpress_extra_class($atts['class']); ?>" data-options="<?php echo esc_attr(json_encode($options)); ?>">
			<?php 
				if( !empty($atts['before_image']) ) {
					echo wp_get_attachment_image( $atts['before_image'], 'dentalpress_ratio-'. esc_attr($atts['ratio']), false, array('class' => 'vu_bf-img-before') );
				}

				if( !empty($atts['after_image']) ) {
					echo wp_get_attachment_image( $atts['after_image'], 'dentalpress_ratio-'. esc_attr($atts['ratio']), false, array('class' => 'vu_bf-img-after') );
				}
			?>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_before_after', 'dentalpress_before_after_shortcode');

	/**
	 * Before After VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_before_after extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_before_after", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_before_after', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Before After", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add before after images", 'dentalpress-shortcodes'),
				"base"		=> "vu_before_after",
				"class"		=> "vc_vu_before_after",
				"icon"		=> "vu_element-icon vu_before-after-icon",
				"controls"	=> "full",
				"category"  => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Before image", 'dentalpress-shortcodes'),
						"param_name" => "before_image",
						"edit_field_class" => "vc_col-xs-6",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select before image.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__("After image", 'dentalpress-shortcodes'),
						"param_name" => "after_image",
						"edit_field_class" => "vc_col-xs-6 vu_p-t-0",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select after image.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Ratio", 'dentalpress-shortcodes'),
						"param_name" => "ratio",
						"value" => dentalpress_get_image_ratios(),
						"std" => '4:3',
						"save_always" => true,
						"description" => esc_html__("Select ratio of image.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Orientation", 'dentalpress-shortcodes'),
						"param_name" => "orientation",
						"admin_label" => true,
						"value" =>  array(
							esc_html__("Horizontal", 'dentalpress-shortcodes') => "horizontal",
							esc_html__("Vertical", 'dentalpress-shortcodes') => "vertical"
						),
						"save_always" => true,
						"description" => esc_html__("Select orientation.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Show label?", 'dentalpress-shortcodes'),
						"param_name" => "show_label",
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to show before and after label.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Before label", 'dentalpress-shortcodes'),
						"param_name" => "before_label",
						"dependency" => array("element" => "show_label", "value" => "1"),
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter before label text.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("After label", 'dentalpress-shortcodes'),
						"param_name" => "after_label",
						"dependency" => array("element" => "show_label", "value" => "1"),
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter after label text.", 'dentalpress-shortcodes')
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