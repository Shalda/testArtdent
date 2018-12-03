<?php 
	/**
	 * Timeline Shortcode
	 *
	 * @param string $atts['position']
	 * @param string $atts['date']
	 * @param string $atts['title']
	 * @param string $atts['desctription']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_timeline_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"position" => "",
			"date" => "",
			"title" => "",
			"description" => "",
			"class" => ""
		), $atts );

		ob_start();
	?>
		<div class="vu_timeline vu_t-position-<?php echo esc_attr( $atts['position'] ); ?><?php dentalpress_extra_class($atts['class']); ?>">
			<div class="vu_t-date"><?php echo esc_html( $atts['date'] ); ?></div>

			<div class="vu_t-container">
				<div class="vu_t-content">
					<?php if( !empty($atts['title']) ) : ?>
						<h4 class="vu_t-title"><?php echo esc_html( $atts['title'] ); ?></h4>
					<?php endif; ?>

					<?php if( !empty($atts['description']) ) : ?>
						<div class="vu_t-description">
							<?php echo wpautop( $atts['description'] ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_timeline', 'dentalpress_timeline_shortcode');

	/**
	 * Timeline VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_timeline extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_timeline", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_timeline', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Timeline", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add timeline", 'dentalpress-shortcodes'),
				"base"		=> "vu_timeline",
				"class"		=> "vc_vu_timeline",
				"icon"		=> "vu_element-icon vu_timeline-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Position", 'dentalpress-shortcodes'),
						"param_name" => "position",
						"value" => array(
							esc_html__("Left", 'dentalpress-shortcodes') => "left",
							esc_html__("Right", 'dentalpress-shortcodes') => "right",
						),
						"save_always" => true,
						"description" => esc_html__("Select position display style.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Date", 'dentalpress-shortcodes'),
						"param_name" => "date",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter history date.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'dentalpress-shortcodes'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter history title.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Content", 'dentalpress-shortcodes'),
						"param_name" => "description",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter history content.", 'dentalpress-shortcodes')
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