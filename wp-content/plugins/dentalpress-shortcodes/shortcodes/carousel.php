<?php 
	/**
	 * Carousel Shortcode
	 *
	 * @param string $atts['items']
	 * @param string $atts['items_desktop_small']
	 * @param string $atts['items_tablet']
	 * @param string $atts['items_mobile']
	 * @param string $atts['slide_speed']
	 * @param string $atts['pagination_speed']
	 * @param string $atts['rewind_speed']
	 * @param string $atts['autoplay']
	 * @param string $atts['stop_on_hover']
	 * @param string $atts['navigation']
	 * @param string $atts['pagination']
	 * @param string $atts['pagination_numbers']
	 * @param string $atts['transition_style']
	 * @param string $atts['id']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_carousel_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"items" => "",
			"items_desktop_small" => "",
			"items_tablet" => "",
			"items_mobile" => "",
			"slide_speed" => "",
			"pagination_speed" => "",
			"rewind_speed" => "",
			"scroll_per_page" => "",
			"autoplay" => "",
			"stop_on_hover" => "",
			"navigation" => "",
			"rewind_nav" => "",
			"pagination" => "",
			"pagination_numbers" => "",
			//"transition_style" => "",
			"id" => "",
			"class" => ""
		), $atts );

		$carousel_options = array();

		// Default
		$carousel_options['singleItem'] = false;
		$carousel_options['itemsScaleUp'] = false;
		$carousel_options['addClassActive'] = true;
		$carousel_options['navigationText'] = array('<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>');
		//$carousel_options['baseClass'] = "owl-carousel";
		//$carousel_options['theme'] = "owl-theme";
		$carousel_options['autoHeight'] = true;

		// General
		$carousel_options['items'] = absint($atts['items']);
		$carousel_options['itemsDesktop'] = array(1199, $carousel_options['items']);
		$carousel_options['itemsDesktopSmall'] = array(980, absint($atts['items_desktop_small']));
		$carousel_options['itemsTablet'] = array(768, absint($atts['items_tablet']));
		$carousel_options['itemsMobile'] = array(479, absint($atts['items_mobile']));

		//Speeds
		$carousel_options['slideSpeed'] = absint($atts['slide_speed']);
		$carousel_options['paginationSpeed'] = absint($atts['pagination_speed']);
		$carousel_options['rewindSpeed'] = absint($atts['rewind_speed']);

		// Autoplay
		$carousel_options['autoPlay'] = ($atts['autoplay'] == '' || $atts['autoplay'] == '0') ? false : absint($atts['autoplay']);
		$carousel_options['stopOnHover'] = ($atts['stop_on_hover'] == '1') ? true : false;

		// Navigation
		$carousel_options['navigation'] = ($atts['navigation'] == '1') ? true : false;
		$carousel_options['rewindNav'] = ($atts['rewind_nav'] == '1') ? true : false;
		$carousel_options['scrollPerPage'] = ($atts['scroll_per_page'] == '1') ? true : false;

		//Pagination
		$carousel_options['pagination'] = ($atts['pagination'] == '1') ? true : false;
		$carousel_options['paginationNumbers'] = ($atts['pagination_numbers'] == '1') ? true : false;

		ob_start();
	?>
		<div<?php echo ( !empty($atts['id']) ) ? ' id="'. esc_attr($atts['id']) .'"' : ''; ?> class="vu_carousel-container">
			<div class="vu_carousel clearfix<?php dentalpress_extra_class($atts['class']); ?>" data-options="<?php echo esc_attr(json_encode($carousel_options)); ?>">
				<?php echo do_shortcode($content); ?>
			</div>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_carousel', 'dentalpress_carousel_shortcode');

	/**
	 * Carousel VC Shortcode
	 */

	if( class_exists('WPBakeryShortCodesContainer') ) {
		class WPBakeryShortCode_vu_carousel extends WPBakeryShortCodesContainer {
		}

		vc_map(
			array(
				"name"		=> esc_html__("Carousel", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add carousel", 'dentalpress-shortcodes'),
				"base"		=> "vu_carousel",
				"class"		=> "vc_vu_carousel",
				"icon"		=> "vu_element-icon vu_carousel-icon",
				"controls"	=> "full",
				"as_parent" => array( 'only' => 'vu_carousel_item' ),
				"js_view" => 'VcColumnView',
				"content_element" => true,
				"is_container" => true,
				"container_not_allowed" => false,
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				'default_content' => '[vu_carousel_item][/vu_carousel_item]',
				"params"	=> array(
					// General
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Items to display on screen", 'dentalpress-shortcodes'),
						"param_name" => "items",
						"value" => "5",
						"save_always" => true,
						"description" => esc_html__("Maximum items to display at a time.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Items to display on small desktops", 'dentalpress-shortcodes'),
						"param_name" => "items_desktop_small",
						"value" => "3",
						"save_always" => true,
						"description" => esc_html__("Maximum items to display at a time for smaller screened desktops.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Items to display on tablets", 'dentalpress-shortcodes'),
						"param_name" => "items_tablet",
						"value" => "2",
						"save_always" => true,
						"description" => esc_html__("Maximum items to display at a time for tablet devices.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Items to display on mobile phones", 'dentalpress-shortcodes'),
						"param_name" => "items_mobile",
						"value" => "1",
						"save_always" => true,
						"description" => esc_html__("Maximum items to display at a time for mobile devices.", 'dentalpress-shortcodes')
					),
					//Basic Speeds
					array(
						"group" => esc_html__('Speeds', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Slide speed", 'dentalpress-shortcodes'),
						"param_name" => "slide_speed",
						"value" => "200",
						"save_always" => true,
						"description" => esc_html__("Slide speed in milliseconds.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Speeds', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Pagination speed", 'dentalpress-shortcodes'),
						"param_name" => "pagination_speed",
						"value" => "800",
						"save_always" => true,
						"description" => esc_html__("Pagination speed in milliseconds.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Speeds', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Rewind speed", 'dentalpress-shortcodes'),
						"param_name" => "rewind_speed",
						"value" => "1000",
						"save_always" => true,
						"description" => esc_html__("Rewind speed in milliseconds.", 'dentalpress-shortcodes')
					),
					//Autoplay
					array(
						"group" => esc_html__('Autoplay', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Auto play", 'dentalpress-shortcodes'),
						"param_name" => "autoplay",
						"value" => "",
						"save_always" => true,
						"description" => wp_kses( __("Change to any integrer for example <b>5000</b> to play every <b>5</b> seconds. Leave blank to disable autoplay.", 'dentalpress-shortcodes'), array('b' => array()) )
					),
					array(
						"group" => esc_html__('Autoplay', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Stop autoplay on mouse hover", 'dentalpress-shortcodes'),
						"param_name" => "stop_on_hover",
						"dependency" => array("element" => "autoplay", "not_empty" => true),
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"save_always" => true
					),
					// Navigation
					array(
						"group" => esc_html__('Navigation', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Display 'next' and 'prev' buttons", 'dentalpress-shortcodes'),
						"param_name" => "navigation",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => '0',
						"save_always" => true
					),
					array(
						"group" => esc_html__('Navigation', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Rewind Navigation", 'dentalpress-shortcodes'),
						"param_name" => "rewind_nav",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => '1',
						"save_always" => true,
						"description" => esc_html__("Slide to first item. Use 'Rewind speed' to change animation speed.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Navigation', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Scroll per page", 'dentalpress-shortcodes'),
						"param_name" => "scroll_per_page",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => '1',
						"save_always" => true,
						"description" => esc_html__("Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.", 'dentalpress-shortcodes')
					),
					//Pagination
					array(
						"group" => esc_html__('Pagination', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show pagination", 'dentalpress-shortcodes'),
						"param_name" => "pagination",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => '1',
						"save_always" => true
					),
					array(
						"group" => esc_html__('Pagination', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show numbers inside pagination buttons", 'dentalpress-shortcodes'),
						"param_name" => "pagination_numbers",
						"dependency" => array("element" => "pagination", "value" => "1"),
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => '0',
						"save_always" => true
					),
					// Others
					array(
						"group" => esc_html__('Others', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Carousel ID", 'dentalpress-shortcodes'),
						"param_name" => "id",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Use this to option to add an ID onto your carousel.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Others', 'dentalpress-shortcodes'),
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