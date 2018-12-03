<?php 
	/**
	 * Client Shortcode
	 *
	 * @param string $atts['image']
	 * @param string $atts['link']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 * @param string $atts['css']
	 */

	function dentalpress_client_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"image" => "",
			"link" => "",
			"class" => "",
			"css" => ""
		), $atts );

		$url = vc_build_link( $atts['link'] );
		$image = wp_get_attachment_image($atts['image'], 'full');

		if( function_exists('vc_shortcode_custom_css_class') ) {
			$atts['class'] .= ' '. vc_shortcode_custom_css_class( $atts['css'] );
		}

		$atts['class'] = trim($atts['class']);

		ob_start();
	?>
		<div class="vu_client<?php dentalpress_extra_class($atts['class']); ?>">
			<?php 
				if ( strlen( $atts['link'] ) > 0 && strlen( $url['url'] ) > 0 ) {
					echo '<a href="'. esc_url( $url['url'] ) .'" title="'. esc_attr( $url['title'] ) .'" target="'. ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">'. $image .'</a>';
				} else {
					echo $image;
				}
			?>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_client', 'dentalpress_client_shortcode');

	/**
	 * Client VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_client extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_client", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_client', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Client", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add client or partner", 'dentalpress-shortcodes'),
				"base"		=> "vu_client",
				"class"		=> "vc_vu_client",
				"icon"		=> "vu_element-icon vu_client-icon",
				"custom_markup" => '<input type="hidden" class="wpb_vc_param_value image attach_image" name="image" value="1"><h4 class="wpb_element_title">'. esc_html__('Client', 'dentalpress-shortcodes') .' <img width="150" height="150" src="'. vc_asset_url('vc/blank.gif') .'" class="attachment-thumbnail vc_element-icon" data-name="image" alt="" title="" style="display: none;"><span class="no_image_image vc_element-icon vu_client-icon"></span></h4>',
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Image", 'dentalpress-shortcodes'),
						"param_name" => "image",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select image from media library.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "vc_link",
						"heading" => esc_html__("URL (Link)", 'dentalpress-shortcodes'),
						"param_name" => "link",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Add the button link, link target and link title.", 'dentalpress-shortcodes')
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