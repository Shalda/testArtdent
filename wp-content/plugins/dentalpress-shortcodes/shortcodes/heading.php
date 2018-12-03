<?php 
	/**
	 * Heading Shortcode
	 *
	 * @param string $atts['style']
	 * @param string $atts['heading']
	 * @param string $atts['subheading']
	 * @param string $atts['alignment']
	 * @param string $atts['custom_colors']
	 * @param string $atts['heading_color']
	 * @param string $atts['subheading_color']
	 * @param string $atts['line_color']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 * @param string $atts['css']
	 */

	function dentalpress_heading_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"style" => "",
			"heading" => "",
			"subheading" => "",
			"alignment" => "",
			"custom_colors" => "",
			"heading_color" => "",
			"subheading_color" => "",
			"line_color" => "",
			"class" => "",
			"css" => ""
		), $atts );

		ob_start();

		if( $atts['custom_colors'] == '1' ) {
			$custom_class = dentalpress_custom_class();
			$atts['class'] .= ' '. $custom_class;
		}

		if( function_exists('vc_shortcode_custom_css_class') ) {
			$atts['class'] .= ' '. vc_shortcode_custom_css_class( $atts['css'] );
		}

		$atts['class'] = trim($atts['class']);
	?>
		<header class="vu_heading vu_h-style-<?php echo esc_attr($atts['style']); ?> vu_h-alignment-<?php echo esc_attr($atts['alignment']); ?><?php dentalpress_extra_class($atts['class']); ?>">
			<?php if( $atts['custom_colors'] == '1' ) : ?>
				<style scoped>
					<?php if( !empty($atts['heading_color']) ) : ?>
						.vu_heading.<?php echo esc_attr($custom_class); ?> .vu_h-heading { color: <?php echo esc_attr($atts['heading_color']); ?>}
					<?php endif; ?>

					<?php if( !empty($atts['subheading_color']) ) : ?>
						.vu_heading.<?php echo esc_attr($custom_class); ?> .vu_h-subheading p { color: <?php echo esc_attr($atts['subheading_color']); ?>}
					<?php endif; ?>

					<?php if( !empty($atts['line_color']) ) : ?>
						.vu_heading.<?php echo esc_attr($custom_class); ?>.vu_h-alignment-left.vu_h-style-1 {border-left-color: <?php echo esc_attr($atts['line_color']); ?> }
						.vu_heading.<?php echo esc_attr($custom_class); ?>.vu_h-alignment-right.vu_h-style-1 {border-right-color: <?php echo esc_attr($atts['line_color']); ?> }
						.vu_heading.<?php echo esc_attr($custom_class); ?>.vu_h-style-2 .vu_h-heading:after,.vu_heading.<?php echo esc_attr($custom_class); ?>.vu_h-style-3 .vu_h-heading:after,.vu_heading.<?php echo esc_attr($custom_class); ?>.vu_h-style-4 .vu_h-heading:before,.vu_heading.<?php echo esc_attr($custom_class); ?>.vu_h-style-4 .vu_h-heading:after { background-color: <?php echo esc_attr($atts['line_color']); ?> }
					<?php endif; ?>
				</style>
			<?php endif; ?>

			<?php if( !empty($atts['heading']) ) : ?>
				<h2 class="vu_h-heading"><?php echo esc_html($atts['heading']); ?></h2>
			<?php endif; ?>

			<?php if( !empty($atts['subheading']) ) : ?>
				<div class="vu_h-subheading">
					<?php echo wpautop($atts['subheading']); ?>
				</div>
			<?php endif; ?>
		</header>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_heading', 'dentalpress_heading_shortcode');

	/**
	 * Heading VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_heading extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_heading", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_heading', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Heading", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add heading and subheading", 'dentalpress-shortcodes'),
				"base"		=> "vu_heading",
				"class"		=> "vc_vu_heading",
				"icon"		=> "vu_element-icon vu_heading-icon",
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
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/heading-styles/1.jpg"
								),
							"2" => array(
									"title" => esc_html__("#2", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/heading-styles/2.jpg"
								),
							"3" => array(
									"title" => esc_html__("#3", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/heading-styles/3.jpg"
								),
							"4" => array(
									"title" => esc_html__("#4", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/heading-styles/4.jpg"
								)
						),
						"width" => "calc(50% - 10px)",
						"height" => "auto",
						"std" => "1",
						"save_always" => true,
						"description" => esc_html__("Select heading display style.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Heading text", 'dentalpress-shortcodes'),
						"param_name" => "heading",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter heading text.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Subheading text", 'dentalpress-shortcodes'),
						"param_name" => "subheading",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter subheading text. Leave blank if no subheading is needed.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Alignment", 'dentalpress-shortcodes'),
						"param_name" => "alignment",
						"value" => array(
							esc_html__('Left', 'dentalpress-shortcodes') => 'left',
							esc_html__('Center', 'dentalpress-shortcodes') => 'center',
							esc_html__('Right', 'dentalpress-shortcodes') => 'right'
						),
						"std" => "left",
						"save_always" => true,
						"description" => esc_html__("Select heading alignment.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Custom Colors?", 'dentalpress-shortcodes'),
						"param_name" => "custom_colors",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => '0',
						"save_always" => true,
						"description" => esc_html__("Check to use custom colors.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Heading Color", 'dentalpress-shortcodes'),
						"param_name" => "heading_color",
						"dependency" => array("element" => "custom_colors", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select heading text custom color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Subheading Color", 'dentalpress-shortcodes'),
						"param_name" => "subheading_color",
						"dependency" => array("element" => "custom_colors", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select subheading text custom color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Line Color", 'dentalpress-shortcodes'),
						"param_name" => "line_color",
						"dependency" => array("element" => "custom_colors", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select line custom color.", 'dentalpress-shortcodes')
					),
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