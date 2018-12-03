<?php 
	/**
	 * Image Slider Shortcode
	 *
	 * @param string $atts['images']
	 * @param string $atts['ratio']
	 * @param string $atts['show_captions']
	 * @param string $atts['lightbox']
	 * @param string $atts['navigation']
	 * @param string $atts['pagination']
	 * @param string $atts['autoplay']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_image_slider_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"images" => "",
			"ratio" => "",
			"show_captions" => "",
			"lightbox" => "",
			"navigation" => "",
			"pagination" => "",
			"autoplay" => "",
			"class" => ""
		), $atts );

		$images = @explode(',', esc_attr($atts['images']));

		$slider_options = array();

		$slider_options['singleItem'] = true;
		$slider_options['autoHeight'] = true;
		$slider_options['items'] = 1;
		$slider_options['autoPlay'] = ($atts['autoplay'] == '' || $atts['autoplay'] == '0') ? false : absint($atts['autoplay']);
		$slider_options['stopOnHover'] = true;
		$slider_options['navigation'] = ($atts['navigation'] == 'always' || $atts['navigation'] == 'hover') ? true : false;
		$slider_options['navigationText'] = array('<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>');
		$slider_options['rewindNav'] = true;
		$slider_options['scrollPerPage'] = true;
		$slider_options['pagination'] = ($atts['pagination'] == 'always' || $atts['pagination'] == 'hover') ? true : false;
		$slider_options['paginationNumbers'] = false;

		ob_start();
	?>
		<div class="vu_image-slider vu_is-navigation-<?php echo esc_attr($atts['navigation']); ?> vu_is-pagination-<?php echo esc_attr($atts['pagination']); ?> <?php echo ($atts['show_captions'] == '1') ? 'vu_is-with-captions' : 'vu_is-without-captions'; ?> vu_carousel<?php echo ($atts['lightbox'] == '1') ? ' vu_lightbox vu_l-gallery' : ''; ?><?php dentalpress_extra_class($atts['class']); ?>" data-options="<?php echo esc_attr(json_encode($slider_options)); ?>" data-delegate="a.vu_is-lightbox">
			<?php 
				foreach ($images as $image) {
					if( $atts['show_captions'] == '1' ) {
						$image_info =  get_post( absint($image) );
					}

					echo '<div class="vu_is-item">';
					echo ($atts['lightbox'] == '1') ? '<a href="'. dentalpress_get_attachment_image_src(absint($image), 'full') .'" '. ( $atts['show_captions'] == '1' ? 'title="'. esc_attr($image_info->post_excerpt) .'"' : '') .' class="vu_is-lightbox">' : '';
					echo '<figure class="vu_is-i-figure">';

					echo wp_get_attachment_image(absint($image), 'dentalpress_ratio-'. esc_attr($atts['ratio']));

					if( $atts['show_captions'] == '1' ) {
						echo '<figcaption class="vu_is-i-caption">'. esc_html($image_info->post_excerpt) .'</figcaption>';
					}

					echo '</figure>';
					echo ($atts['lightbox'] == '1') ? '</a>' : '';
					echo '</div>';
				}
			?>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_image_slider', 'dentalpress_image_slider_shortcode');

	/**
	 * Image Slider VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_image_slider extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_image_slider", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_image_slider', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Image Slider", 'dentalpress-shortcodes'),
				"description" => esc_html__("Animated slider with images", 'dentalpress-shortcodes'),
				"base"		=> "vu_image_slider",
				"class"		=> "vc_vu_image-slider",
				"icon"		=> "vu_element-icon vu_image-slider-icon",
				"custom_markup" => "",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "attach_images",
						"heading" => esc_html__("Images", 'dentalpress-shortcodes'),
						"param_name" => "images",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select images from media library.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Ratio", 'dentalpress-shortcodes'),
						"param_name" => "ratio",
						"admin_label" => true,
						"value" => dentalpress_get_image_ratios(),
						"std" => '4:3',
						"save_always" => true,
						"description" => esc_html__("Select ratio of images.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Show Captions", 'dentalpress-shortcodes'),
						"param_name" => "show_captions",
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to show captions for images.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Enable lightbox", 'dentalpress-shortcodes'),
						"param_name" => "lightbox",
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to enable lightbox for images.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Show navigation", 'dentalpress-shortcodes'),
						"param_name" => "navigation",
						"value" => array(
							esc_html__("None", 'dentalpress-shortcodes') => "none",
							esc_html__("Always", 'dentalpress-shortcodes') => "always",
							esc_html__("Only on hover", 'dentalpress-shortcodes') => "hover"
						),
						"std" => 'hover',
						"save_always" => true
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Show pagination", 'dentalpress-shortcodes'),
						"param_name" => "pagination",
						"value" => array(
							esc_html__("None", 'dentalpress-shortcodes') => "none",
							esc_html__("Always", 'dentalpress-shortcodes') => "always",
							esc_html__("Only on hover", 'dentalpress-shortcodes') => "hover"
						),
						"std" => 'hover',
						"save_always" => true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Auto play", 'dentalpress-shortcodes'),
						"param_name" => "autoplay",
						"value" => "",
						"save_always" => true,
						"description" => wp_kses( __("Change to any integrer for example <b>5000</b> to play every <b>5</b> seconds. Leave blank to disable autoplay.", 'dentalpress-shortcodes'), array('b' => array()) )
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