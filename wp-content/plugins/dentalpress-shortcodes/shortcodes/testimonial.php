<?php 
	/**
	 * Testimonial Shortcode
	 *
	 * @param string $atts['style']
	 * @param string $atts['alignment']
	 * @param string $atts['image']
	 * @param string $atts['name']
	 * @param string $atts['position']
	 * @param string $atts['content']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 * @param string $atts['css']
	 */

	function dentalpress_testimonial_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"style" => "",
			"alignment" => "",
			"image" => "",
			"name" => "",
			"position" => "",
			"description" => "",
			"class" => "",
			"css" => ""
		), $atts );

		if( function_exists('vc_shortcode_custom_css_class') ) {
			$atts['class'] .= ' '. vc_shortcode_custom_css_class( $atts['css'] );
		}

		$atts['class'] = trim($atts['class']);

		ob_start();
	?>
		<div class="vu_testimonial vu_t-style-<?php echo esc_attr( $atts['style'] ); ?><?php echo ($atts['style'] == '2') ? ' vu_t-alignment-'. esc_attr($atts['alignment']) : ''; ?><?php dentalpress_extra_class($atts['class']); ?>" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
			<?php if ( $atts['style'] == '2' ) : ?>
				<?php if ( empty($atts['image']) ) : ?>
					<div class="vu_t-icon">
						<i class="vu_fi vu_fi-customer-review" aria-hidden="true"></i>
					</div>
				<?php else : ?>
					<div class="vu_t-author-image">
						<?php echo wp_get_attachment_image(absint($atts['image']), 'thumbnail'); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			
			<div class="vu_t-content clearfix" itemprop="text">
				<?php echo wpautop( $atts['description'] ); ?>
			</div>

			<div class="vu_t-author" itemscope="itemscope" itemtype="https://schema.org/Person">
				<?php if ( $atts['style'] == '1' ) : ?>
					<?php if ( empty($atts['image']) ) : ?>
						<i class="vu_t-icon vu_fi vu_fi-customer-review" aria-hidden="true"></i>
					<?php else : ?>
						<div class="vu_t-author-image">
							<?php echo wp_get_attachment_image(absint($atts['image']), 'thumbnail'); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<h4 class="vu_t-author-name<?php echo ($atts['style'] == '1' && empty( $atts['position'] )) ? ' m-t-10 m-b-10' : ''; ?>" itemprop="name"><?php echo esc_html( $atts['name'] ); ?></h4>

				<?php if( !empty( $atts['position'] ) ) : ?>
					<span class="vu_t-author-position" itemprop="jobTitle"><?php echo esc_html( $atts['position'] ); ?></span>
				<?php endif; ?>
			</div>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_testimonial', 'dentalpress_testimonial_shortcode');

	/**
	 * Video Section VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_testimonial extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_testimonial", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_testimonial', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Testimonial", 'dentalpress-shortcodes'),
				"description" => esc_html__("Show what your client say", 'dentalpress-shortcodes'),
				"base"		=> "vu_testimonial",
				"class"		=> "vc_vu_testimonial",
				"icon"		=> "vu_element-icon vu_testimonial-icon",
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
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/testimonial-styles/1.jpg"
								),
							"2" => array(
									"title" => esc_html__("#2", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/testimonial-styles/2.jpg"
								)
						),
						"width" => "calc(50% - 10px)",
						"height" => "auto",
						"std" => "1",
						"save_always" => true,
						"description" => esc_html__("Select testimonial style.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Alignment", 'dentalpress-shortcodes'),
						"param_name" => "alignment",
						"dependency" => array("element" => "style", "value" => "2"),
						"value" => array(
							esc_html__('Left', 'dentalpress-shortcodes') => 'left',
							esc_html__('Center', 'dentalpress-shortcodes') => 'center',
							esc_html__('Right', 'dentalpress-shortcodes') => 'right'
						),
						"std" => "center",
						"save_always" => true,
						"description" => esc_html__("Select testimonial alignment.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Image", 'dentalpress-shortcodes'),
						"param_name" => "image",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select image from media library.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Name", 'dentalpress-shortcodes'),
						"param_name" => "name",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter in author name.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Position", 'dentalpress-shortcodes'),
						"param_name" => "position",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter in author position.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Content", 'dentalpress-shortcodes'),
						"param_name" => "description",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter in content.", 'dentalpress-shortcodes')
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