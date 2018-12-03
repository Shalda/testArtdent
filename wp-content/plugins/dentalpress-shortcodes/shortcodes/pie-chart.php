<?php 
	/**
	 * Pie Chart Shortcode
	 *
	 * @param string $atts['style']
	 * @param string $atts['type']
	 * @param string $atts['text']
	 * @param string $atts['icon_library']
	 * @param string $atts['icon_fontawesome']
	 * @param string $atts['icon_dentalpress']
	 * @param string $atts['value']
	 * @param string $atts['line_width']
	 * @param string $atts['size']
	 * @param string $atts['text_color']
	 * @param string $atts['bar_color']
	 * @param string $atts['track_color']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_pie_chart_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"style" => "",
			"type" => "",
			"text" => "",
			"icon_library" => "",
			"icon_dentalpress" => "",
			"icon_fontawesome" => "",
			"font_size" => "",
			"value" => "",
			"line_width" => "",
			"size" => "",
			"text_color" => "",
			"bar_color" => "",
			"track_color" => "",
			"class" => ""
		), $atts );

		$size = absint($atts['size']);

		$pie_chart_options = array();

		$pie_chart_options['scaleColor'] = false;
		$pie_chart_options['lineCap'] = 'square';
		$pie_chart_options['animate'] = array("duration" => 1000, "enabled" => true);

		$pie_chart_options['barColor'] = esc_attr($atts['bar_color']);
		$pie_chart_options['trackColor'] = ($atts['style'] != '1') ? esc_attr($atts['track_color']) : false;
		$pie_chart_options['lineWidth'] = absint($atts['line_width']);
		$pie_chart_options['size'] = $size;

		$custom_class = 'vu_pc-custom-'. rand(100000, 999999);

		ob_start();
	?>
		<div class="vu_pie-chart vu_pc-style-<?php echo esc_attr($atts['style']); ?> <?php echo esc_attr($custom_class); ?><?php dentalpress_extra_class($atts['class']); ?>">
			<div class="vu_pc-graph" data-percent="<?php echo esc_attr($atts['value']); ?>" data-options="<?php echo esc_attr(json_encode($pie_chart_options)); ?>"<?php echo ($size > 0) ? ' style="height:'. $size .'px;"' : ''; ?>>
				<div class="vu_pc-graph-text"<?php echo ($size > 0) ? ' style="width:'. $size .'px;height:'. $size .'px;line-height:'. $size .'px;margin-left:-'. $size / 2 .'px;"' : ''; ?>>
					<?php 
						if( $atts['type'] == 'icon' ) {
							echo '<span class="vu_pc-icon"'. (!empty($atts['text_color']) ? ' style="font-size:'. esc_attr($atts['font_size']) .'px;color:'. esc_attr($atts['text_color']) .';"' : '') .'><i class="'. esc_attr($atts['icon_'. esc_attr($atts['icon_library'])]) .'"></i></span>';
						} else {
							echo '<span class="vu_pc-text" title="'. esc_attr($atts['text']) .'"'. (!empty($atts['text_color']) ? ' style="font-size:'. esc_attr($atts['font_size']) .'px;color:'. esc_attr($atts['text_color']) .';"' : '') .'>'. esc_html($atts['text']) .'</span>';
						}
					?>
				</div>

				<?php echo !empty($atts['track_color']) ? '<style scoped>.vu_pie-chart.'. esc_attr($custom_class) .' .vu_pc-graph-text:before,.vu_pie-chart.'. esc_attr($custom_class) .' .vu_pc-graph-text:after{border-color:'. esc_attr($atts['track_color']) .'!important;}.vu_pie-chart.'. esc_attr($custom_class) .' .vu_pc-graph-text:after{top:'. absint($atts['line_width']) .'px;right:'. absint($atts['line_width']) .'px;bottom:'. absint($atts['line_width']) .'px;left:'. absint($atts['line_width']) .'px;}</style>' : ''; ?>
			</div>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_pie_chart', 'dentalpress_pie_chart_shortcode');

	/**
	 * Pie Chart VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_pie_chart extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_pie_chart", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_pie_chart', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Pie Chart", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add animated pie chart", 'dentalpress-shortcodes'),
				"base"		=> "vu_pie_chart",
				"class"		=> "vc_vu_pie_chart",
				"icon"		=> "vu_element-icon vu_pie-chart-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "image_select",
						"heading" => esc_html__("Style", 'dentalpress-shortcodes'),
						"param_name" => "style",
						"value" => array(
							"1" => array(
									"title" => esc_html__("#1", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/pie-chart-styles/1.jpg"
								),
							"2" => array(
									"title" => esc_html__("#2", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/pie-chart-styles/2.jpg"
								),
							"3" => array(
									"title" => esc_html__("#3", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/pie-chart-styles/3.jpg"
								)
						),
						"width" => "calc(33.33333% - 10px)",
						"height" => "auto",
						"std" => "1",
						"save_always" => true,
						"description" => esc_html__("Select pie chart display style.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Type", 'dentalpress-shortcodes'),
						"param_name" => "type",
						"value" => array(
							esc_html__("Text", 'dentalpress-shortcodes') => "text",
							esc_html__("Icon", 'dentalpress-shortcodes') => "icon"
						),
						"save_always" => true,
						"description" => esc_html__("Select pie chart type.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Text", 'dentalpress-shortcodes'),
						"param_name" => "text",
						"dependency" => array("element" => "type", "value" => "text"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter text for pie chart.", 'dentalpress-shortcodes')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Icon Library', 'dentalpress-shortcodes'),
						'param_name' => 'icon_library',
						"dependency" => array("element" => "type", "value" => "icon"),
						'value' => array(
							esc_html__('DentalPress', 'dentalpress-shortcodes') => 'dentalpress',
							esc_html__('FontAwesome', 'dentalpress-shortcodes') => 'fontawesome'
						),
						"save_always" => true,
						"description" => esc_html__("Select icon type.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", 'dentalpress-shortcodes'),
						"param_name" => "icon_dentalpress",
						"dependency" => array("element" => "icon_library", "value" => "dentalpress"),
						"settings" => array(
							"emptyIcon" => false,
							"type" => 'dentalpress',
							"iconsPerPage" => 4000
						),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Pick an icon from the library.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "iconpicker",
						"heading" => esc_html__("Icon", 'dentalpress-shortcodes'),
						"param_name" => "icon_fontawesome",
						"dependency" => array("element" => "icon_library", "value" => "fontawesome"),
						"settings" => array(
							"emptyIcon" => false,
							"iconsPerPage" => 100
						),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Pick an icon from the library.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Value", 'dentalpress-shortcodes'),
						"param_name" => "value",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter value for graph (Note: choose range from 0 to 100).", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Line Width", 'dentalpress-shortcodes'),
						"param_name" => "line_width",
						"value" => "8",
						"save_always" => true,
						"description" => esc_html__("Enter pie chart line width in px.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Size", 'dentalpress-shortcodes'),
						"param_name" => "size",
						"value" => "160",
						"save_always" => true,
						"description" => esc_html__("Enter chart size (note: it applies for both width and height).", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Font Size", 'dentalpress-shortcodes'),
						"param_name" => "font_size",
						"value" => "28",
						"save_always" => true,
						"description" => esc_html__("Enter font size for text/icon in integer.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Text Color", 'dentalpress-shortcodes'),
						"param_name" => "text_color",
						"value" => "#414141",
						"save_always" => true,
						"description" => esc_html__("Select text/icon color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Bar Color", 'dentalpress-shortcodes'),
						"param_name" => "bar_color",
						"value" => "#a4d735",
						"save_always" => true,
						"description" => esc_html__("Select bar color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Track Color", 'dentalpress-shortcodes'),
						"param_name" => "track_color",
						"value" => "#f1f1f1",
						"save_always" => true,
						"description" => esc_html__("Select track color.", 'dentalpress-shortcodes')
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