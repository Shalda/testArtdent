<?php
	/**
	 * Gallery Item Shortcode
	 *
	 * @param string $atts['image']
	 * @param string $atts['ratio']
	 * @param string $atts['title']
	 * @param string $atts['subtitle']
	 * @param string $atts['category']
	 * @param string $atts['link_type']
	 * @param string $atts['link']
	 * @param string $atts['show_icon']
	 * @param string $atts['icon_library']
	 * @param string $atts['icon_dentalpress']
	 * @param string $atts['icon_fontawesome']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_gallery_item_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"image" => "",
			"ratio" => "",
			"size" => "",
			"title" => "",
			"subtitle" => "",
			"category" => "",
			"link_type" => "",
			"link" => "",
			"show_icon" => "",
			"icon_library" => "",
			"icon_dentalpress" => "",
			"icon_fontawesome" => "",
			"class" => "",
			"type" => "",
			"layout" => ""
		), $atts );

		if( $atts['type'] == 'masonry' ) {
			$categories = @explode(',', $atts['category']);

			if( is_array($categories) ){
				foreach ($categories as $key => $value) {
					$categories[$key] = md5(sanitize_title($value));
				}
			} else {
				$categories = md5(sanitize_title($categories));
			}
		}

		ob_start();
	?>
		<?php if( $atts['type'] == 'standard' ) : ?>
			<div class="vu_g-item<?php echo ($atts['layout'] != 5) ? ' col-md-'. (12 / absint($atts['layout'])) : ''; ?> col-sm-6 col-xs-6 col-tn-12">
		<?php elseif( $atts['type'] == 'masonry' ) : ?>
			<div class="vu_g-item <?php echo esc_attr( @implode(' ', $categories) ); ?>" data-size="<?php echo esc_attr($atts['size']); ?>">
		<?php endif; ?>

			<div class="vu_gallery-item<?php dentalpress_extra_class($atts['class']); ?>">
				<?php if( !empty($atts['image']) ) : ?>
					<div class="vu_gi-image<?php echo ($atts['type'] == 'masonry') ? ' vu_lazy-load' : ''; ?>"<?php echo ($atts['type'] == 'masonry') ? ' data-img="'. dentalpress_get_attachment_image_src($atts['image'], 'full') .'"' : ''; ?>>
						<?php 
							if( $atts['type'] == 'masonry' ) {
								echo wp_get_attachment_image( $atts['image'], 'dentalpress_ratio-'. esc_attr(str_replace('x', ':', $atts['size'])) );
							} else {
								echo wp_get_attachment_image( $atts['image'], 'dentalpress_ratio-'. esc_attr($atts['ratio']) );
							}
						?>
					</div>
				<?php endif; ?>
				<div class="vu_gi-details-container<?php echo (empty($atts['title']) && empty($atts['subtitle']) && $atts['show_icon'] != '1') ? ' vu_gi-empty' : ''; ?>">
					<div class="vu_gi-details">
						<?php if( $atts['link_type'] == 'lightbox' ) { ?>
							<a href="<?php echo dentalpress_get_attachment_image_src( $atts['image'], 'full' ); ?>" title="<?php echo esc_attr($atts['title']); ?>" class="vu_gi-lightbox vu_gi-content-container">
						<?php } else if( $atts['link_type'] == 'url' ) { ?>
							<?php $link = vc_build_link( $atts['link'] ); ?>
							<a href="<?php echo esc_url($link['url']); ?>" title="<?php echo esc_attr($link['title']); ?>" class="vu_gi-content-container" target="<?php echo (strlen($link['target']) > 0 ? esc_attr($link['target']) : '_self' ); ?>">
						<?php } else { ?>
							<div class="vu_gi-content-container">
						<?php } ?>
								<span class="vu_gi-content">
									<?php if( $atts['show_icon'] == '1' ) : ?>
										<span class="vu_gi-icons">
											<span class="vu_gi-icon"><i class="<?php echo esc_attr($atts['icon_'. esc_attr($atts['icon_library'])]); ?>"></i></span>
										</span>
									<?php endif; ?>

									<?php echo !empty($atts['title']) ? '<span class="vu_gi-title">'. esc_html($atts['title']) .'</span>' : ''; ?>
									
									<?php echo !empty($atts['subtitle']) ? '<span class="vu_gi-subtitle">'. esc_html($atts['subtitle']) .'</span>' : ''; ?>
								</span>
						<?php if( $atts['link_type'] == 'none' ) { ?>
							</div>
						<?php } else { ?>
							</a>
						<?php } ?>
					</div>
				</div>
			</div>

		<?php echo ($atts['type'] == 'standard' || $atts['type'] == 'masonry') ? '</div>' : ''; ?>
	<?php 
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_gallery_item', 'dentalpress_gallery_item_shortcode');

	/**
	 * Gallery VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_gallery_item extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_gallery_item", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_gallery_item', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name" => esc_html__("Gallery Item", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add gallery item", 'dentalpress-shortcodes'),
				"base" => "vu_gallery_item",
				"icon" => "vu_gallery-item-icon",
				"custom_markup" => '<input type="hidden" class="wpb_vc_param_value image attach_image" name="image" value="1"><h4 class="wpb_element_title">'. esc_html__('Gallery Item', 'dentalpress-shortcodes') .' <img width="150" height="150" src="'. vc_asset_url('vc/blank.gif') .'" class="attachment-thumbnail vc_element-icon vu_element-icon" data-name="image" alt="" title="" style="display: none;"><span class="no_image_image vc_element-icon vu_element-icon vu_gallery-item-icon"></span></h4><span class="vc_admin_label admin_label_title hidden-label"><label>Title</label>: </span><span class="vc_admin_label admin_label_category hidden-label"><label>Category</label>: </span>',
				"controls" => "full",
				"as_child" => array( 'only' => 'vu_gallery' ),
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params" => array(
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
						"admin_label" => true,
						"value" => dentalpress_get_image_ratios(),
						"std" => '4:3',
						"save_always" => true,
						"description" => esc_html__("Select ratio of image.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Size", 'dentalpress-shortcodes'),
						"param_name" => "size",
						"admin_label" => true,
						"value" => array(
							"1x1" => "1x1",
							"1x2" => "1x2",
							"2x1" => "2x1",
							"2x2" => "2x2"
						),
						"std" => '1x1',
						"save_always" => true,
						"description" => esc_html__("Select size of image.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'dentalpress-shortcodes'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter gallery item title.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Subtitle", 'dentalpress-shortcodes'),
						"param_name" => "subtitle",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter gallery item subtitle.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Category", 'dentalpress-shortcodes'),
						"param_name" => "category",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter gallery item category.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Link Type", 'dentalpress-shortcodes'),
						"param_name" => "link_type",
						"value" => array(
							esc_html__('No Link', 'dentalpress-shortcodes') => "none",
							esc_html__('Lightbox', 'dentalpress-shortcodes') => "lightbox",
							esc_html__('Link to URL', 'dentalpress-shortcodes') => "url"
						),
						"std" => 'lightbox',
						"save_always" => true,
						"description" => esc_html__("Select gallery item link type.", 'dentalpress-shortcodes'),
					),
					array(
						"type" => "vc_link",
						"heading" => esc_html__("URL (Link)", 'dentalpress-shortcodes'),
						"param_name" => "link",
						"dependency" => array("element" => "link_type", "value" => "url"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Add link to service.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Show Icon", 'dentalpress-shortcodes'),
						"param_name" => "show_icon",
						"dependency" => array("element" => "link_type", "value_not_equal_to" => "none"),
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
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