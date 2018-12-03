<?php

	/**
	 * Icon Box Shortcode
	 *
	 * @param string $atts['icon_library']
	 * @param string $atts['icon_dentalpress']
	 * @param string $atts['icon_fontawesome']
	 * @param string $atts['size']
	 * @param string $atts['position']
	 * @param string $atts['style']
	 * @param string $atts['link']
	 * @param string $atts['title']
	 * @param string $atts['description']
	 * @param string $atts['read_more_text']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_icon_box_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts(array(
			"icon_library" => "",
			"icon_dentalpress" => "",
			"icon_fontawesome" => "",
			"size" => "",
			"position" => "",
			"style" => "",
			"color" => "",
			"link" => "",
			"title" => "",
			"description" => "",
			"read_more_text" => "",
			"class" => ""
		), $atts);

		$link = vc_build_link( $atts['link'] );
		
		ob_start();
		?>
			<div class="vu_icon-box clearfix vu_ib-size-<?php echo esc_attr($atts['size']); ?> vu_ib-position-<?php echo esc_attr($atts['position']); ?> vu_ib-style-<?php echo esc_attr($atts['style']); ?> vu_ib-color-<?php echo esc_attr($atts['color']); ?><?php dentalpress_extra_class($atts['class']); ?>">
				<span class="vu_ib-icon"><i class="<?php echo esc_attr($atts['icon_'. esc_attr($atts['icon_library'])]); ?>"></i></span>
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
					echo '<div class="clear"></div><div class="vu_ib-read-more-container"><a href="'. esc_url( $link['url'] ) .'" title="'. esc_attr($link['title']) .'" target="'. (strlen($link['target']) > 0 ? esc_attr($link['target']) : '_self') . '" class="vu_ib-read-more vu_link-inverse"><span class="vu_ib-btn"><i class="vu_ib-btn-icon-left vu_fi vu_fi-arrow-right"></i><span class="vu_ib-btn-text">'. esc_html($atts['read_more_text']) .'</span><i class="vu_ib-btn-icon-right vu_fi vu_fi-arrow-right"></i></span></a></div>';
				} ?>
				</div>
			</div>
		<?php

		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_icon_box', 'dentalpress_icon_box_shortcode');

	/**
	 * Icon Box VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ){
		class WPBakeryShortCode_vu_icon_box extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_icon_box", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_icon_box', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Icon Box", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add icon box", 'dentalpress-shortcodes'),
				"base"		=> "vu_icon_box",
				"class"		=> "vc_vu_icon_box",
				"icon"		=> "vu_element-icon vu_icon-box-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Icon Library', 'dentalpress-shortcodes'),
						'param_name' => 'icon_library',
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
						'heading' => esc_html__('Size', 'dentalpress-shortcodes'),
						'param_name' => 'size',
						'value' => array(
							esc_html__('Large', 'dentalpress-shortcodes') => 'large',
							esc_html__('Small', 'dentalpress-shortcodes') => 'small'
						),
						"save_always" => true,
						"description" => esc_html__("Select icon size.", 'dentalpress-shortcodes')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Position', 'dentalpress-shortcodes'),
						'param_name' => 'position',
						'value' => array(
							esc_html__('Left', 'dentalpress-shortcodes') => 'left',
							esc_html__('Top', 'dentalpress-shortcodes') => 'top',
							esc_html__('Right', 'dentalpress-shortcodes') => 'right'
						),
						"save_always" => true,
						"description" => esc_html__("Select icon position.", 'dentalpress-shortcodes')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Style', 'dentalpress-shortcodes'),
						'param_name' => 'style',
						'value' => array(
							esc_html__('Circle', 'dentalpress-shortcodes') => 'circle',
							esc_html__('Square', 'dentalpress-shortcodes') => 'square',
							esc_html__('Square 45°', 'dentalpress-shortcodes') => 'square-45'
						),
						"save_always" => true,
						"description" => esc_html__("Select icon style.", 'dentalpress-shortcodes')
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
						"description" => esc_html__("Select icon box color.", 'dentalpress-shortcodes')
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