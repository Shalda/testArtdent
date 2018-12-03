<?php
	/**
	 * Booked Calendar Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ){
		class WPBakeryShortCode_vu_booked_calendar extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_booked_calendar", $atts);

				return '<div class="vu_booked-calendar clearfix'. dentalpress_extra_class($atts['class'], false) .'">'. do_shortcode( dentalpress_generate_shortcode('booked-calendar', $atts, $content) ) .'</div>';
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Booked Calendar", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add custom calendar", 'dentalpress-shortcodes'),
				"base"		=> "vu_booked_calendar",
				"class"		=> "vc_booked-calendar",
				"icon"		=> "vu_element-icon vu_booked-calendar-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'dentalpress-shortcodes'),
						"param_name" => "style",
						"admin_label" => true,
						"value" => array(
							esc_html__("Calendar", 'dentalpress-shortcodes') => "calendar",
							esc_html__("List", 'dentalpress-shortcodes') => "list"
						),
						"save_always" => true,
						"description" => esc_html__("Select style of calendar.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Size", 'dentalpress-shortcodes'),
						"param_name" => "size",
						"admin_label" => true,
						"value" => array(
							esc_html__("Large", 'dentalpress-shortcodes') => "large",
							esc_html__("Small", 'dentalpress-shortcodes') => "small"
						),
						"save_always" => true,
						"description" => esc_html__("Select size of calendar.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Calendar", 'dentalpress-shortcodes'),
						"param_name" => "calendar",
						"admin_label" => true,
						"value" => dentalpress_get_booked_calendars(),
						"save_always" => true,
						"description" => esc_html__("Select appointment calendar.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Year", 'dentalpress-shortcodes'),
						"param_name" => "year",
						"value" => date('Y'),
						"save_always" => true,
						"description" => esc_html__("Enter year.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Month", 'dentalpress-shortcodes'),
						"param_name" => "month",
						"value" => date('n'),
						"save_always" => true,
						"description" => esc_html__("Enter month.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Day", 'dentalpress-shortcodes'),
						"param_name" => "day",
						"dependency" => array("element" => "style", "value" => "list"),
						"value" => date('j'),
						"save_always" => true,
						"description" => esc_html__("Enter day.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Switcher", 'dentalpress-shortcodes'),
						"param_name" => "switcher",
						"value" => array(esc_html__("Yes, please", 'dentalpress-shortcodes') => true),
						"save_always" => true,
						"description" => esc_html__("Check to show calendar switcher.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Member Only?", 'dentalpress-shortcodes'),
						"param_name" => "members-only",
						"value" => array(esc_html__("Yes, please", 'dentalpress-shortcodes') => true),
						"save_always" => true,
						"description" => esc_html__("Check to hide the appointment calendar from non-logged-in users.", 'dentalpress-shortcodes')
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