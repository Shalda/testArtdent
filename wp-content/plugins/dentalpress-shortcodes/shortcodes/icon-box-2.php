<?php

	/**
	 * Icon Box 2 Shortcode
	 *
	 * @param string $atts['type']
	 * @param string $atts['image']
	 * @param string $atts['icon_library']
	 * @param string $atts['icon_dentalpress']
	 * @param string $atts['icon_fontawesome']
	 * @param string $atts['style']
	 * @param string $atts['title']
	 * @param string $atts['link']
	 * @param string $atts['description']
	 * @param string $atts['read_more_text']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_icon_box_2_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts(array(
			"type" => "",
			"image" => "",
			"icon_library" => "",
			"icon_dentalpress" => "",
			"icon_fontawesome" => "",
			"style" => "",
			"title" => "",
			"link" => "",
			"description" => "",
			"read_more_text" => "",
			"class" => ""
		), $atts);

		$link = vc_build_link( $atts['link'] );
		
		ob_start();
		?>
			<div class="vu_icon-box-2 vu_ib-type-<?php echo esc_attr($atts['type']); ?> vu_ib-style-<?php echo esc_attr($atts['style']); ?> clearfix<?php dentalpress_extra_class($atts['class']); ?>">
				<div class="vu_ib-icon">
					<?php if ( $atts['type'] == 'icon' ) { ?>
						<i class="<?php echo esc_attr($atts['icon_'. esc_attr($atts['icon_library'])]); ?>"></i>
					<?php } else { ?>
						<?php echo wp_get_attachment_image( $atts['image'], 'full' ); ?>
					<?php } ?>
				</div>

				<div class="vu_ib-content">
					<?php 
						if( !empty($atts['title']) ) {
							if ( strlen( $atts['link'] ) > 0 && strlen( $link['url'] ) > 0 ) {
								echo '<h5 class="vu_ib-title"><a href="'. esc_url( $link['url'] ) .'" title="'. esc_attr( $link['title'] ) .'" target="'. ( strlen( $link['target'] ) > 0 ? esc_attr( $link['target'] ) : '_self' ) . '">'. esc_html($atts['title']) .'</a></h5>';
							} else {
								echo '<h5 class="vu_ib-title">'. esc_html($atts['title']) .'</h5>';
							}
						} 
					?>

					<?php if( !empty($atts['description']) ) { echo '<div class="vu_ib-description">'. wpautop($atts['description']) .'</div>'; } ?>

					<?php if ( $atts['read_more_text'] != '' && strlen( $atts['link'] ) > 0 && strlen( $link['url'] ) > 0 ) {
					echo '<div class="clear"></div><a href="'. esc_url( $link['url'] ) .'" title="'. esc_attr($link['title']) .'" target="'. (strlen($link['target']) > 0 ? esc_attr($link['target']) : '_self') . '" class="vu_ib-read-more">'. esc_html($atts['read_more_text']) .'</a>';
				} ?>
				</div>
			</div>
		<?php

		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_icon_box_2', 'dentalpress_icon_box_2_shortcode');

	/**
	 * Icon Box 2 VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ){
		class WPBakeryShortCode_vu_icon_box_2 extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_icon_box_2", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_icon_box_2', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Icon Box 2", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add icon box", 'dentalpress-shortcodes'),
				"base"		=> "vu_icon_box_2",
				"class"		=> "vc_vu_icon_box_2",
				"icon"		=> "vu_element-icon vu_icon-box-2-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Type', 'dentalpress-shortcodes'),
						'param_name' => 'type',
						'value' => array(
							esc_html__('Icon', 'dentalpress-shortcodes') => 'icon',
							esc_html__('Image', 'dentalpress-shortcodes') => 'image'
						),
						"save_always" => true,
						"description" => esc_html__("Select icon type.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Image", 'dentalpress-shortcodes'),
						"param_name" => "image",
						"dependency" => array("element" => "type", "value" => "image"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select image from media library.", 'dentalpress-shortcodes')
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
						'type' => 'dropdown',
						'heading' => esc_html__('Style', 'dentalpress-shortcodes'),
						'param_name' => 'style',
						'value' => array(
							esc_html__('#1', 'dentalpress-shortcodes') => '1',
							esc_html__('#2', 'dentalpress-shortcodes') => '2'
						),
						"save_always" => true,
						"description" => esc_html__("Select icon box style.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'dentalpress-shortcodes'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter the title.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Description", 'dentalpress-shortcodes'),
						"param_name" => "description",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter the description.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Read more text", 'dentalpress-shortcodes'),
						"param_name" => "read_more_text",
						"value" => esc_html__('View More', 'dentalpress-shortcodes'),
						"save_always" => true,
						"description" => esc_html__("Enter read more text.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "vc_link",
						"heading" => esc_html__("URL (Link)", 'dentalpress-shortcodes'),
						"param_name" => "link",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Add link to icon box.", 'dentalpress-shortcodes')
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