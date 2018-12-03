<?php 
	/**
	 * Contact Form 7 Shortcode
	 *
	 * @param string $atts['title']
	 * @param string $atts['id']
	 * @param string $atts['style']
	 * @param string $atts['hide_valid_msgs']
	 * @param string $atts['html_id']
	 * @param string $atts['html_name']
	 * @param string $atts['html_class'] Add a class name and then refer to it in your css file.
	 * @param string $atts['css']
	 */

	function dentalpress_contact_form_7_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"title" => "",
			"id" => "",
			"style" => "",
			"hide_valid_msgs" => "",
			"html_id" => "",
			"html_name" => "",
			"html_class" => "",
			"css" => ""
		), $atts );

		$atts['html_class'] = trim( $atts['html_class'] . ' vu_cf7-frm' );

		if( function_exists('vc_shortcode_custom_css_class') ) {
			$vc_shortcode_custom_css_class = ' '. vc_shortcode_custom_css_class( $atts['css'] );
		}

		ob_start();
	?>
		<div class="vu_contact-form-7 vu_cf7-style-<?php echo esc_attr($atts['style']); ?><?php echo ($atts['hide_valid_msgs'] == '1') ? ' vu_cf7-hide-valid-msgs' : ''; ?> clearfix<?php echo (isset($vc_shortcode_custom_css_class) && !empty($vc_shortcode_custom_css_class)) ? esc_attr($vc_shortcode_custom_css_class) : ''; ?>">
			<?php if( !empty($atts['title']) ) : ?>
				<h3 class="vu_cf7-title"><?php echo esc_html( $atts['title'] ); ?></h3>
			<?php endif; ?>

			<?php echo do_shortcode( apply_filters("the_content", dentalpress_generate_shortcode('contact-form-7', $atts, $content) ) ); ?>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_contact_form_7', 'dentalpress_contact_form_7_shortcode');

	/**
	 * Contact Form 7 VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_contact_form_7 extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_contact_form_7", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_contact_form_7', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Contact Form 7", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add contact form", 'dentalpress-shortcodes'),
				"base"		=> "vu_contact_form_7",
				"class"		=> "vc_vu_contact_form_7",
				"icon"		=> "vu_element-icon vu_contact-form-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'dentalpress-shortcodes'),
						"param_name" => "title",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("What text use as form title. Leave blank if no title is needed.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Form", 'dentalpress-shortcodes'),
						"param_name" => "id",
						"admin_label" => true,
						"value" => dentalpress_get_cf7(),
						"save_always" => true,
						"description" => esc_html__("Select previously created contact form from the drop down list.", 'dentalpress-shortcodes')
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
						"description" => esc_html__("Select form style.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Hide Validation Messages?", 'dentalpress-shortcodes'),
						"param_name" => "hide_valid_msgs",
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to hide all validation messages for fields.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("ID", 'dentalpress-shortcodes'),
						"param_name" => "html_id",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Use this to option to add an ID onto your contact form. Leave blank if no title is needed.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Name", 'dentalpress-shortcodes'),
						"param_name" => "html_name",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Use this to option to add an Name onto your contact form. Leave blank if no title is needed.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Class", 'dentalpress-shortcodes'),
						"param_name" => "html_class",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Use this to option to add an extra Class onto your contact form. Leave blank if no title is needed.", 'dentalpress-shortcodes')
					),
					array(
						'group' => esc_html__( 'Design Options', 'dentalpress-shortcodes' ),
						'type' => 'css_editor',
						'heading' => esc_html__( 'CSS box', 'dentalpress-shortcodes' ),
						'param_name' => 'css'
					)
				)
			)
		);
	}
?>