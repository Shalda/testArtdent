<?php

	/**
	 * Image Switch Shortcode
	 *
	 * @param string $atts['default_image']
	 * @param string $atts['hover_image']
	 * @param string $atts['ratio']
	 * @param string $atts['effect']
	 * @param string $atts['link']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 * @param string $atts['css']
	 */

	function dentalpress_image_switch_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts(array(
			"default_image" => "",
			"hover_image" => "",
			"ratio" => "",
			"effect" => "",
			"link" => "",
			"class" => "",
			"css" => ""
		), $atts);

		$url = vc_build_link( $atts['link'] );

		if( function_exists('vc_shortcode_custom_css_class') ) {
			$atts['class'] .= ' '. vc_shortcode_custom_css_class( $atts['css'] );
		}

		$atts['class'] = trim($atts['class']);
		
		ob_start();
	?>
		<div class="vu_image-switch clearfix<?php dentalpress_extra_class($atts['class']); ?>" data-effect="<?php echo esc_attr($atts['effect']); ?>">
			<div class="vu_is-wrapper">
				<div class="vu_is-content embed-responsive embed-responsive-<?php echo esc_attr( str_replace(':', 'by', $atts['ratio'])); ?>">
					<?php if ( strlen( $atts['link'] ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
						<a href="<?php echo esc_url( $url['url'] ); ?>" class="vu_is-link" title="<?php echo esc_attr($url['title']); ?>" target="<?php echo (strlen($url['target']) > 0 ? esc_attr($url['target']) : '_self'); ?>">
					<?php endif; ?>

					<span class="vu_is-image vu_is-default-image">
						<?php echo wp_get_attachment_image(absint($atts['default_image']), 'dentalpress_ratio-'. esc_attr($atts['ratio'])); ?>
					</span>

					<span class="vu_is-image vu_is-hover-image">
						<?php echo wp_get_attachment_image(absint($atts['hover_image']), 'dentalpress_ratio-'. esc_attr($atts['ratio'])); ?>
					</span>

					<?php if ( strlen( $atts['link'] ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_image_switch', 'dentalpress_image_switch_shortcode');

	/**
	 * Image Switch VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ){
		class WPBakeryShortCode_vu_image_switch extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_image_switch", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_image_switch', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Image Switch", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add image switch", 'dentalpress-shortcodes'),
				"base"		=> "vu_image_switch",
				"class"		=> "vc_vu_image_switch",
				"icon"		=> "vu_element-icon vu_image-switch-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Default Image", 'dentalpress-shortcodes'),
						"param_name" => "default_image",
						"edit_field_class" => "vc_col-xs-6",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select default image from media library.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Hover Image", 'dentalpress-shortcodes'),
						"param_name" => "hover_image",
						"edit_field_class" => "vc_col-xs-6 vu_p-t-0",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select hover image from media library.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Ratio", 'dentalpress-shortcodes'),
						"param_name" => "ratio",
						"value" => dentalpress_get_image_ratios(),
						"admin_label" => true,
						"std" => '4:3',
						"save_always" => true,
						"description" => esc_html__("Select ratio of images.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Switch Effect", 'dentalpress-shortcodes'),
						"param_name" => "effect",
						"admin_label" => true,
						"value" => array(
							esc_html__("Fade", 'dentalpress-shortcode') => "fade",
							esc_html__("Blur", 'dentalpress-shortcode') => "blur",
							esc_html__("Zoom", 'dentalpress-shortcode') => "zoom",
							esc_html__("Rotate", 'dentalpress-shortcode') => "rotate",
							esc_html__("Flip Vertical", 'dentalpress-shortcode') => "flipX",
							esc_html__("Flip Horizontal", 'dentalpress-shortcode') => "flipY",
							esc_html__("SlideUp", 'dentalpress-shortcode') => "slideUp",
							esc_html__("SlideDown", 'dentalpress-shortcode') => "slideDown",
							esc_html__("SlideLeft", 'dentalpress-shortcode') => "slideLeft",
							esc_html__("SlideRight", 'dentalpress-shortcode') => "slideRight"
						),
						"std" => '',
						"save_always" => true,
						"description" => esc_html__("Select switch effect of images.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "vc_link",
						"heading" => esc_html__("URL (Link)", 'dentalpress-shortcodes'),
						"param_name" => "link",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Add link to image switch.", 'dentalpress-shortcodes')
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