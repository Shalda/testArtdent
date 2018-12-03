<?php 
	/**
	 * Button Shortcode
	 *
	 * @param string $atts['text']
	 * @param string $atts['link']
	 * @param string $atts['style']
	 * @param string $atts['size']
	 * @param string $atts['color']
	 * @param string $atts['show_icon']
	 * @param string $atts['icon_library']
	 * @param string $atts['icon_fontawesome']
	 * @param string $atts['icon_dentalpress']
	 * @param string $atts['icon_position']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_button_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"text" => "",
			"link" => "",
			"style" => "",
			"size" => "",
			"color" => "",
			"show_icon" => "",
			"icon_library" => "",
			"icon_dentalpress" => "",
			"icon_fontawesome" => "",
			"icon_position" => "",
			"class" => ""
		), $atts );

		$link = vc_build_link( $atts['link'] );

		if( $atts['show_icon'] == '1' ){
			$icon = '<i class="'. esc_attr($atts['icon_'. esc_attr($atts['icon_library'])]) .'"></i>';

			if( $atts['icon_position'] == 'before' ) {
				$text = $icon .'<span>'. esc_html($atts['text']) .'</span>';
			} else {
				$text = '<span>'. esc_html($atts['text']) .'</span>'. $icon;
			}
		} else {
			$text = '<span>'. esc_html($atts['text']) .'</span>';
		}

		ob_start();
	?>
		<a href="<?php echo esc_url($link['url']); ?>" title="<?php echo esc_url($link['title']); ?>" target="<?php echo ( strlen( $link['target'] ) > 0 ) ? esc_attr( $link['target'] ) : '_self'; ?>" class="vu_button btn btn-<?php echo esc_attr($atts['style']); ?> btn-<?php echo esc_attr( $atts['size'] ); ?> btn-<?php echo esc_attr( $atts['color'] ); ?><?php echo ($atts['show_icon'] == '1' ) ? ' btn-icon' : ''; ?><?php dentalpress_extra_class($atts['class']); ?>">
			<?php echo wp_kses($text, array('span' => array(), 'i' => array('class' => array()))); ?>
		</a>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_button', 'dentalpress_button_shortcode');

	/**
	 * Button VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_button extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_button", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_button', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Button", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add button", 'dentalpress-shortcodes'),
				"base"		=> "vu_button",
				"class"		=> "vc_vu_button",
				"icon"		=> "vu_element-icon vu_button-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__("Text", 'dentalpress-shortcodes'),
						"param_name" => "text",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter button text.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "vc_link",
						"heading" => esc_html__("URL (Link)", 'dentalpress-shortcodes'),
						"param_name" => "link",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Add link to button.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'dentalpress-shortcodes'),
						"param_name" => "style",
						"value" => array(
							esc_html__("Default", 'dentalpress-shortcodes') => "default",
							esc_html__("Inverse", 'dentalpress-shortcodes') => "inverse"
						),
						"save_always" => true,
						"description" => esc_html__("Select button style.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Size", 'dentalpress-shortcodes'),
						"param_name" => "size",
						"value" => array(
							esc_html__("Mini", 'dentalpress-shortcodes') => "xs",
							esc_html__("Small", 'dentalpress-shortcodes') => "sm",
							esc_html__("Normal", 'dentalpress-shortcodes') => "md",
							esc_html__("Large", 'dentalpress-shortcodes') => "lg"
						),
						"std" => 'md',
						"save_always" => true,
						"description" => esc_html__("Select button style.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Color", 'dentalpress-shortcodes'),
						"param_name" => "color",
						"value" => array(
							esc_html__("Primary", 'dentalpress-shortcodes') => "primary",
							esc_html__("Secondary", 'dentalpress-shortcodes') => "secondary",
							esc_html__("Black", 'dentalpress-shortcodes') => "black",
							esc_html__("White", 'dentalpress-shortcodes') => "white"
						),
						"std" => 'primary',
						"save_always" => true,
						"description" => esc_html__("Select button color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Show Icon", 'dentalpress-shortcodes'),
						"param_name" => "show_icon",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => '0',
						"save_always" => true,
						"description" => esc_html__("Check to show icon.", 'dentalpress-shortcodes')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Icon Library', 'dentalpress-shortcodes'),
						'param_name' => 'icon_library',
						"dependency" => array("element" => "show_icon", "value" => "1"),
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
						"type" => "dropdown",
						"heading" => esc_html__("Icon Position", 'dentalpress-shortcodes'),
						"param_name" => "icon_position",
						"dependency" => array("element" => "show_icon", "value" => "1"),
						"value" => array(
							esc_html__("Before Text", 'dentalpress-shortcodes') => "before",
							esc_html__("After Text", 'dentalpress-shortcodes') => "after"
						),
						"save_always" => true,
						"description" => esc_html__("Select icon position.", 'dentalpress-shortcodes')
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