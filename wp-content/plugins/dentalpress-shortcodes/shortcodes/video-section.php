<?php 
	/**
	 * Video Section Shortcode
	 *
	 * @param string $atts['image']
	 * @param string $atts['custom_height']
	 * @param string $atts['ratio']
	 * @param string $atts['height']
	 * @param string $atts['title']
	 * @param string $atts['video_url']
	 * @param string $atts['video_popup']
	 * @param string $atts['video_mute']
	 * @param string $atts['play_type']
	 * @param string $atts['pattern_overlay']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_video_section_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"image" => "",
			"custom_height" => "",
			"ratio" => "",
			"height" => "",
			"title" => "",
			"video_url" => "",
			"video_popup" => "",
			"video_mute" => "",
			"play_type" => "",
			"pattern_overlay" => "",
			"class" => ""
		), $atts );

		ob_start();
	?>
		<div class="vu_video-section<?php echo (!empty($atts['title'])) ? ' vu_vs-with-title' : ''; ?> vu_lazy-load<?php echo ($atts['pattern_overlay'] == '1') ? ' vu_vs-with-pattern' : ''; ?><?php dentalpress_extra_class($atts['class']); ?>" data-img="<?php echo esc_url(dentalpress_get_attachment_image_src($atts['image'], 'full')); ?>"<?php echo ($atts['video_popup'] != '1') ? ' data-play="'. esc_attr($atts['play_type']) .'"' : '';?>>
			<div class="vu_vs-shadow"></div>
			<div class="vu_vs-inner <?php echo ($atts['custom_height'] != '1') ? 'embed-responsive embed-responsive-'. esc_attr( str_replace(':', 'by', $atts['ratio'])) : 'p-b-0'; ?>"<?php echo ($atts['custom_height'] == '1') ? ' style="height:'. esc_attr($atts['height']) .'"' : ''; ?>>
				<a href="<?php echo ($atts['video_popup'] == '1') ? esc_url($atts['video_url']) : '#' ?>" class="vu_vs-play<?php echo ($atts['video_popup'] == '1') ? ' vu_lightbox' : ''; ?>" data-type="iframe"><i class="fa fa-play"></i></a>

				<?php if( !empty($atts['title']) ) : ?>
					<h5 class="vu_vs-title"><?php echo esc_html($atts['title']); ?></h5>
				<?php endif; ?>

				<?php if( $atts['video_popup'] != '1' && (strpos($atts['video_url'], 'youtube') == true || strpos($atts['video_url'], 'youtu.be') == true ) ) : ?>
					<?php 
						$_id = rand(100000, 999999);

						$options = array(
							"_id" => $_id,
							"video_id" => dentalpress_get_youtube_video_id( $atts['video_url'] ),
							"play_type" => $atts['play_type'],
							"video_mute" => ($atts['video_mute'] == '1') ? 1 : 0
						);
					?>
					<div id="vu_vs-player-<?php echo $_id; ?>" class="vu_vs-player" data-options="<?php echo esc_attr( json_encode( $options ) ); ?>"></div>
				<?php endif; ?>
			</div>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_video_section', 'dentalpress_video_section_shortcode');

	/**
	 * Video Section VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_video_section extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_video_section", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_video_section', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Video section", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add video section", 'dentalpress-shortcodes'),
				"base"		=> "vu_video_section",
				"class"		=> "vc_vu_video_section",
				"icon"		=> "vu_element-icon vu_video-section-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Image", 'dentalpress-shortcodes'),
						"param_name" => "image",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select background image.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Custom Height?", 'dentalpress-shortcodes'),
						"param_name" => "custom_height",
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to use custom height.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Aspect Ratio", 'dentalpress-shortcodes'),
						"param_name" => "ratio",
						"dependency" => array("element" => "custom_height", "value_not_equal_to" => "1"),
						"value" => dentalpress_get_image_ratios(),
						"std" => '16:9',
						"save_always" => true,
						"description" => esc_html__("Select ratio of video.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Height", 'dentalpress-shortcodes'),
						"param_name" => "height",
						"dependency" => array("element" => "custom_height", "value" => "1"),
						"value" => "600px",
						"save_always" => true,
						"description" => esc_html__("Enter custom height. (Note: CSS measurement units allowed).", 'dentalpress-shortcodes')
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
						"type" => "textfield",
						"heading" => esc_html__("Video URL", 'dentalpress-shortcodes'),
						"param_name" => "video_url",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter video URL. Eg. https://www.youtube.com/watch?v=1234567.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Open video as popup?", 'dentalpress-shortcodes'),
						"param_name" => "video_popup",
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"std" => "1",
						"save_always" => true,
						"description" => esc_html__("Check to open the video as popup.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Video mute?", 'dentalpress-shortcodes'),
						"param_name" => "video_mute",
						"dependency" => array("element" => "video_popup", "value_not_equal_to" => "1"),
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to video mute.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Play type", 'dentalpress-shortcodes'),
						"param_name" => "play_type",
						"dependency" => array("element" => "video_popup", "value_not_equal_to" => "1"),
						"value" => array(
							esc_html__('Normal', 'dentalpress-shortcodes') => 'normal',
							esc_html__('Autoplay', 'dentalpress-shortcodes') => 'autoplay',
							esc_html__('On scroll', 'dentalpress-shortcodes') => 'scroll',
						),
						"std" => 'normal',
						"save_always" => true,
						"description" => wp_kses( __("Select video play type. <b>*</b> Works only for youtube videos.", 'dentalpress-shortcodes'), array('b' => array()) )
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Pattern overlay?", 'dentalpress-shortcodes'),
						"param_name" => "pattern_overlay",
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to show pattern overlay.", 'dentalpress-shortcodes')
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