<?php

	/**
	 * Image Box Shortcode
	 *
	 * @param string $atts['image']
	 * @param string $atts['ratio']
	 * @param string $atts['title']
	 * @param string $atts['link']
	 * @param string $atts['description']
	 * @param string $atts['read_more_text']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_image_box_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts(array(
			"image" => "",
			"ratio" => "",
			"title" => "",
			"link" => "",
			"description" => "",
			"read_more_text" => "",
			"class" => ""
		), $atts);

		$link = vc_build_link( $atts['link'] );
		
		ob_start();
	?>
		<div class="vu_image-box clearfix<?php dentalpress_extra_class($atts['class']); ?>">
			<div class="vu_ib-image">
				<?php if ( strlen( $atts['link'] ) > 0 && strlen( $link['url'] ) > 0 ) {
					echo '<a href="'. esc_url( $link['url'] ) .'" title="'. esc_attr($link['title']) .'" target="'. (strlen($link['target']) > 0 ? esc_attr($link['target']) : '_self') . '">'. wp_get_attachment_image(absint($atts['image']), 'dentalpress_ratio-'. esc_attr($atts['ratio'])) .'</a>';
				} else { 
					echo wp_get_attachment_image(absint($atts['image']), 'dentalpress_ratio-'. esc_attr($atts['ratio']));
				} ?>
			</div>

			<div class="vu_ib-content">
				<h4 class="vu_ib-title">
					<?php if ( strlen( $atts['link'] ) > 0 && strlen( $link['url'] ) > 0 ) {
						echo '<a href="'. esc_url( $link['url'] ) .'" title="'. esc_attr($link['title']) .'" target="'. (strlen($link['target']) > 0 ? esc_attr($link['target']) : '_self') . '">'. esc_html($atts['title']) .'</a>';
					} else { 
						echo esc_html($atts['title']);
					} ?>
				</h4>

				<?php echo !empty($atts['description']) ? '<div class="vu_ib-description">'. wpautop($atts['description']) .'</div>' : ''; ?>

				<?php if ( $atts['read_more_text'] != '' && strlen( $atts['link'] ) > 0 && strlen( $link['url'] ) > 0 ) {
					echo '<div class="clear"></div><a href="'. esc_url( $link['url'] ) .'" title="'. esc_attr($link['title']) .'" target="'. (strlen($link['target']) > 0 ? esc_attr($link['target']) : '_self') . '" class="vu_ib-read-more vu_link-inverse"><span class="vu_ib-btn"><i class="vu_ib-btn-icon-left vu_fi vu_fi-arrow-right"></i><span class="vu_ib-btn-text">'. esc_html($atts['read_more_text']) .'</span><i class="vu_ib-btn-icon-right vu_fi vu_fi-arrow-right"></i></span></a>';
				} ?>
			</div>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_image_box', 'dentalpress_image_box_shortcode');

	/**
	 * Image Box VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ){
		class WPBakeryShortCode_vu_image_box extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_image_box", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_image_box', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Image Box", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add image box", 'dentalpress-shortcodes'),
				"base"		=> "vu_image_box",
				"class"		=> "vc_vu_image_box",
				"icon"		=> "vu_element-icon vu_image-box-icon",
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
						"type" => "dropdown",
						"heading" => esc_html__("Ratio", 'dentalpress-shortcodes'),
						"param_name" => "ratio",
						"value" => dentalpress_get_image_ratios(),
						"std" => '2:1',
						"save_always" => true,
						"description" => esc_html__("Select ratio of images.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'dentalpress-shortcodes'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter title.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Description", 'dentalpress-shortcodes'),
						"param_name" => "description",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter description.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Read more text", 'dentalpress-shortcodes'),
						"param_name" => "read_more_text",
						"admin_label" => true,
						"value" => "Read More",
						"save_always" => true,
						"description" => esc_html__("Enter read more text.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "vc_link",
						"heading" => esc_html__("URL (Link)", 'dentalpress-shortcodes'),
						"param_name" => "link",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Add link to image box.", 'dentalpress-shortcodes')
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