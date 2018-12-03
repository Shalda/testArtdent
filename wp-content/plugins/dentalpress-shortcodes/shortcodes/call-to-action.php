<?php 
	/**
	 * Call to Action Shortcode
	 *
	 * @param string $atts['bg_color']
	 * @param string $atts['show_button']
	 * @param string $atts['button_style']
	 * @param string $atts['button_text']
	 * @param string $atts['button_link']
	 * @param string $atts['show_icon']
	 * @param string $atts['icon_library']
	 * @param string $atts['icon_dentalpress']
	 * @param string $atts['icon_fontawesome']
	 * @param string $atts['icon_position']
	 * @param string $atts['button_class']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_call_to_action_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"bg_color" => "",
			"show_button" => "",
			"button_style" => "",
			"button_color" => "",
			"button_text" => "",
			"button_link" => "",
			"show_icon" => "",
			"icon_library" => "",
			"icon_dentalpress" => "",
			"icon_fontawesome" => "",
			"icon_position" => "",
			"button_class" => "",
			"class" => ""
		), $atts );

		$button_link = vc_build_link( $atts['button_link'] );

		if( $atts['show_icon'] == '1' ) {
			$button_icon = '<i class="'. esc_attr($atts['icon_'. esc_attr($atts['icon_library'])]) .'"></i>';

			if( $atts['icon_position'] == 'before' ) {
				$button_text = $button_icon .'<span>'. esc_html($atts['button_text']) .'</span>';
			} else {
				$button_text = '<span>'. esc_html($atts['button_text']) .'</span>'. $button_icon;
			}
		} else {
			$button_text = '<span>'. esc_html($atts['button_text']) .'</span>';
		}

		ob_start();
	?>
		<div class="vu_call-to-action<?php dentalpress_extra_class($atts['class']); ?>"<?php echo ( !empty($atts['bg_color']) ) ? ' style="background-color:'. esc_attr($atts['bg_color']) .';"' : ''; ?>>
			<div class="container">
				<div class="row">
					<div class="vu_cta-wrapper">
						<div class="vu_cta-content col-md-<?php echo ($atts['show_button'] == '1') ? '9' : '12'; ?>">
							<?php if( function_exists('wpb_js_remove_wpautop') ) { echo wpb_js_remove_wpautop($content, true); } ?>
						</div>
						<?php if( $atts['show_button'] == '1' ) : ?>
							<div class="vu_cta-button col-md-3">
								<a href="<?php echo esc_url($button_link['url']); ?>" title="<?php echo esc_url($button_link['title']); ?>" target="<?php echo ( strlen( $button_link['target'] ) > 0 ) ? esc_attr( $button_link['target'] ) : '_self'; ?>" class="btn btn-<?php echo esc_attr($atts['button_style']); ?> btn-<?php echo esc_attr($atts['button_color']); ?><?php echo ($atts['show_icon'] == '1') ? ' btn-icon' : ''; ?><?php dentalpress_extra_class($atts['button_class']); ?>"><?php echo wp_kses($button_text, array('span' => array(), 'i' => array('class' => array()))); ?></a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_call_to_action', 'dentalpress_call_to_action_shortcode');

	/**
	 * Call to Action VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_call_to_action extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_call_to_action", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_call_to_action', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Call to Action", 'dentalpress-shortcodes'),
				"description" => esc_html__("Catch visitors attention with CTA block", 'dentalpress-shortcodes'),
				"base"		=> "vu_call_to_action",
				"class"		=> "vc_vu_call_to_action",
				"icon"		=> "vu_element-icon vu_call-to-action-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"group" => esc_html__("General", 'dentalpress-shortcodes'),
						"type" => "colorpicker",
						"heading" => esc_html__("Background Color", 'dentalpress-shortcodes'),
						"param_name" => "bg_color",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select custom background color.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__("General", 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'dentalpress-shortcodes'),
						"param_name" => "class",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__("Content", 'dentalpress-shortcodes'),
						"type" => "textarea_html",
						"heading" => esc_html__("Content", 'dentalpress-shortcodes'),
						"param_name" => "content",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Write the content of CTA.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__("Button", 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show Button", 'dentalpress-shortcodes'),
						"param_name" => "show_button",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => '1',
						"save_always" => true,
						"description" => esc_html__("Uncheck to hide button.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__("Button", 'dentalpress-shortcodes'),
						"type" => "dropdown",
						"heading" => esc_html__("Button Style", 'dentalpress-shortcodes'),
						"param_name" => "button_style",
						"dependency" => array("element" => "show_button", "value" => "1"),
						"value" => array(
							esc_html__("Default", 'dentalpress-shortcodes') => "default",
							esc_html__("Inverse", 'dentalpress-shortcodes') => "inverse"
						),
						"save_always" => true,
						"description" => esc_html__("Select button style.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__("Button", 'dentalpress-shortcodes'),
						"type" => "dropdown",
						"heading" => esc_html__("Button Color", 'dentalpress-shortcodes'),
						"param_name" => "button_color",
						"dependency" => array("element" => "show_button", "value" => "1"),
						"value" => array(
							esc_html__("Primary", 'dentalpress-shortcodes') => "primary",
							esc_html__("Secondary", 'dentalpress-shortcodes') => "secondary",
							esc_html__("Black", 'dentalpress-shortcodes') => "black",
							esc_html__("White", 'dentalpress-shortcodes') => "white"
						),
						"save_always" => true,
						"description" => esc_html__("Select button style.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__("Button", 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Button Text", 'dentalpress-shortcodes'),
						"param_name" => "button_text",
						"dependency" => array("element" => "show_button", "value" => "1"),
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter button text.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__("Button", 'dentalpress-shortcodes'),
						"type" => "vc_link",
						"heading" => esc_html__("Button URL (Link)", 'dentalpress-shortcodes'),
						"param_name" => "button_link",
						"dependency" => array("element" => "show_button", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Add the button link, link target and link title.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__("Button", 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show Icon", 'dentalpress-shortcodes'),
						"param_name" => "show_icon",
						"dependency" => array("element" => "show_button", "value" => "1"),
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => '0',
						"save_always" => true,
						"description" => esc_html__("Check to show icon.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__("Button", 'dentalpress-shortcodes'),
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
						"group" => esc_html__("Button", 'dentalpress-shortcodes'),
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
						"group" => esc_html__("Button", 'dentalpress-shortcodes'),
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
						"group" => esc_html__("Button", 'dentalpress-shortcodes'),
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
						"group" => esc_html__("Button", 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'dentalpress-shortcodes'),
						"param_name" => "button_class",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress-shortcodes')
					),
				)
			)
		);
	}
?>