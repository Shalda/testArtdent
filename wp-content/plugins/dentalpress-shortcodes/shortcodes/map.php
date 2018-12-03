<?php 
	/**
	 * Map Shortcode
	 *
	 * @author Vedat Ujkani
	 */

	function dentalpress_map_shortcode($atts, $content = null) {
		$atts = shortcode_atts( array(
			"inherit_options" => "",
			"center_lat" => "",
			"center_lng" => "",
			"zoom_level" => "",
			"map_height" => "",
			"map_type" => "",
			"map_style" => "",
			"tilt_45" => "",
			"draggable" => "",
			"zoom_control" => "",
			"disable_double_click_zoom" => "",
			"scrollwheel" => "",
			"pan_control" => "",
			"map_type_control" => "",
			"scale_control" => "",
			"street_view_control" => "",
			"use_custom_marker" => "",
			"custom_marker" => "",
			"enable_map_animation" => "",
			"locations" => "",
			"class" => ""
		), $atts);

		//map options
		if( $atts['inherit_options'] != "1") {
			$map_options = array(
				"zoom_level" => esc_attr($atts['zoom_level']),
				"center_lat" => esc_attr($atts['center_lat']),
				"center_lng" => esc_attr($atts['center_lng']),
				"map_type" => esc_attr($atts['map_type']),
				"tilt_45" => esc_attr($atts['tilt_45']),
				"others_options" => array(
					"draggable" => esc_attr($atts['draggable']),
					"zoomControl" => esc_attr($atts['zoom_control']),
					"disableDoubleClickZoom" => esc_attr($atts['disable_double_click_zoom']),
					"scrollwheel" => esc_attr($atts['scrollwheel']),
					"panControl" => esc_attr($atts['pan_control']),
					"mapTypeControl" => esc_attr($atts['map_type_control']),
					"scaleControl" => esc_attr($atts['scale_control']),
					"streetViewControl" => esc_attr($atts['street_view_control'])
				),
				"use_custom_marker" => esc_attr($atts['use_custom_marker']),
				"custom_marker" => esc_url(dentalpress_get_attachment_image_src($atts['custom_marker'], 'full')),
				"enable_animation" => esc_attr($atts['enable_map_animation']),
				"locations" => json_decode(base64_decode($atts['locations']), true)
			);
		} else {
			$map_options = dentalpress_get_map_options();
		}

		//styles
		if( $map_options['map_type'] == "roadmap" ){
			$map_style_array = @explode('#', dentalpress_get_option('map-style'));
			$map_style_temp = isset($map_style_array[1]) ? $map_style_array[1] : null;

			$map_style = ($atts['inherit_options'] != "1") ? $atts['map_style'] : $map_style_temp;
			
			$map_options['styles'] = dentalpress_get_map_style($map_style);
		}

		wp_enqueue_script('google-map');

		$map_height = ($atts['inherit_options'] != "1") ? absint($atts['map_height']) : absint(dentalpress_get_option('map-height'));

		return '<div class="vu_map vu_m-fullwith'. dentalpress_extra_class($atts['class'], false) .'" data-options="'. esc_attr(json_encode($map_options)) .'"'. ($map_height > 0 ? ' style="height:'. $map_height .'px;"' : '') .'></div>';
	}

	add_shortcode('vu_map', 'dentalpress_map_shortcode');
	
	/**
	 * Map VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ){
		class WPBakeryShortCode_vu_map extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_map", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_map', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Map", 'dentalpress-shortcodes'),
				"description" => esc_html__('Add map', 'dentalpress-shortcodes'),
				"base"		=> "vu_map",
				"class"		=> "vc_vu_map",
				"icon"		=> "vu_element-icon vu_map-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Inherit from Theme Options", 'dentalpress-shortcodes'),
						"param_name" => "inherit_options",
						"admin_label" => true,
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"std" => "1",
						"save_always" => true,
						"description" => esc_html__("Map options will be inherited form general theme options. Uncheck to ignore and set up new options.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Center Latitude", 'dentalpress-shortcodes'),
						"param_name" => "center_lat",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter latitude for the map center point.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Center Longitude", 'dentalpress-shortcodes'),
						"param_name" => "center_lng",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter longitude for the map center point.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Default Zoom Level", 'dentalpress-shortcodes'),
						"param_name" => "zoom_level",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Value should be between 1-18, 1 being the entire earth and 18 being right at street level.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Height", 'dentalpress-shortcodes'),
						"param_name" => "map_height",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter map height.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "dropdown",
						"heading" => esc_html__("Type", 'dentalpress-shortcodes'),
						"param_name" => "map_type",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => array(
							esc_html__("Roadmap", 'dentalpress-shortcodes') => "roadmap",
							esc_html__("Satellite", 'dentalpress-shortcodes') => "satellite",
							esc_html__("Hybrid", 'dentalpress-shortcodes') => "hybrid",
							esc_html__("Terrain", 'dentalpress-shortcodes') => "terrain"
						),
						"save_always" => true,
						"description" => esc_html__("Select map type.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Tilt 45°", 'dentalpress-shortcodes'),
						"param_name" => "tilt_45",
						"dependency" => array("element" => "map_type", "value" => "satellite"),
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"save_always" => true
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"edit_field_class" => "vc_col-sm-12 vc_column",
						"heading" => esc_html__("Others Options", 'dentalpress-shortcodes'),
						"param_name" => "draggable",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => array(esc_html__("Draggable", 'dentalpress-shortcodes') => "1"),
						'std' => '1',
						"save_always" => true
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"edit_field_class" => "vc_col-sm-12 vc_column vu_p-t-0",
						"param_name" => "zoom_control",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => array(esc_html__("Zoom Control", 'dentalpress-shortcodes') => "1"),
						"save_always" => true
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"edit_field_class" => "vc_col-sm-12 vc_column vu_p-t-0",
						"param_name" => "disable_double_click_zoom",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => array(esc_html__("Disable Double Click Zoom", 'dentalpress-shortcodes') => "1"),
						"save_always" => true
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"edit_field_class" => "vc_col-sm-12 vc_column vu_p-t-0",
						"param_name" => "scrollwheel",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => array(esc_html__("Scroll Wheel", 'dentalpress-shortcodes') => "1"),
						"save_always" => true
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"edit_field_class" => "vc_col-sm-12 vc_column vu_p-t-0",
						"param_name" => "pan_control",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => array(esc_html__("Pan Control", 'dentalpress-shortcodes') => "1"),
						"save_always" => true
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"edit_field_class" => "vc_col-sm-12 vc_column vu_p-t-0",
						"param_name" => "map_type_control",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => array(esc_html__("Type Control", 'dentalpress-shortcodes') => "1"),
						"save_always" => true
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"edit_field_class" => "vc_col-sm-12 vc_column vu_p-t-0",
						"param_name" => "scale_control",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => array(esc_html__("Scale Control", 'dentalpress-shortcodes') => "1"),
						"save_always" => true
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"edit_field_class" => "vc_col-sm-12 vc_column vu_p-t-0",
						"param_name" => "street_view_control",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => array(esc_html__("Street View Control", 'dentalpress-shortcodes') => "1"),
						"save_always" => true,
						"description" => esc_html__("Select other options you want to apply on map.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'dentalpress-shortcodes'),
						"param_name" => "class",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Style', 'dentalpress-shortcodes'),
						"type" => "image_select",
						"heading" => esc_html__("Style", 'dentalpress-shortcodes'),
						"param_name" => "map_style",
						"dependency" => array("element" => "map_type", "value" => "roadmap"),
						"value" => array(
							"0" => array(
									"title" => esc_html__("Default", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/0.png"
								),
							"1" => array(
									"title" => esc_html__("Theme Style", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/1.png"
								),
							"2" => array(
									"title" => esc_html__("Subtle Grayscale", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/2.png"
								),
							"3" => array(
									"title" => esc_html__("Blue Water", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/3.png"
								),
							"4" => array(
									"title" => esc_html__("Shades of Grey", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/4.png"
								),
							"5" => array(
									"title" => esc_html__("Pale Dawn", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/5.png"
								),
							"6" => array(
									"title" => esc_html__("Apple Maps-esque", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/6.png"
								),
							"7" => array(
									"title" => esc_html__("Light Monochrome", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/7.png"
								),
							"8" => array(
									"title" => esc_html__("Greyscale", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/8.png"
								),
							"9" => array(
									"title" => esc_html__("Neutral Blue", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/9.png"
								),
							"10" => array(
									"title" => esc_html__("Become a Dinosaur", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/10.png"
								),
							"11" => array(
									"title" => esc_html__("Blue Gray", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/11.png"
								),
							"12" => array(
									"title" => esc_html__("Icy Blue", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/12.png"
								),
							"13" => array(
									"title" => esc_html__("Clean Cut", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/13.png"
								),
							"14" => array(
									"title" => esc_html__("Muted Blue", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/14.png"
								),
							"15" => array(
									"title" => esc_html__("Old Timey", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/15.png"
								),
							"16" => array(
									"title" => esc_html__("Red Hues", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/16.png"
								),
							"17" => array(
									"title" => esc_html__("Nature", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/17.png"
								),
							"18" => array(
									"title" => esc_html__("Turquoise Water", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/18.png"
								),
							"19" => array(
									"title" => esc_html__("Just Places", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/19.png"
								),
							"20" => array(
									"title" => esc_html__("Ultra Light", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/20.png"
								),
							"21" => array(
									"title" => esc_html__("Subtle Green", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/21.png"
								),
							"22" => array(
									"title" => esc_html__("Simple & Light", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/22.png"
								),
							"23" => array(
									"title" => esc_html__("Dankontorstole", 'dentalpress-shortcodes'),
									"image" => "http://dl.flexipress.xyz/dentalpress/assets/map-styles/23.png"
								)
						),
						"width" => "calc(33.33333% - 10px)",
						"height" => "auto",
						"std" => "1",
						"save_always" => true,
						"description" => esc_html__("Select map style.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Marker', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Use Custom Marker", 'dentalpress-shortcodes'),
						"param_name" => "use_custom_marker",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"save_always" => true,
						"description" => esc_html__("Check to use a custom image as map marker.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Marker', 'dentalpress-shortcodes'),
						"type" => "attach_image",
						"heading" => esc_html__("Custom Marker", 'dentalpress-shortcodes'),
						"param_name" => "custom_marker",
						"dependency" => array("element" => "use_custom_marker", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Upload custom image/icon marker.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Marker', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Enable Marker Animation", 'dentalpress-shortcodes'),
						"param_name" => "enable_map_animation",
						"dependency" => array("element" => "inherit_options", "value_not_equal_to" => "1"),
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"save_always" => true,
						"description" => esc_html__("If checked, marker(s) will do a quick bounce as they load in.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Locations', 'dentalpress-shortcodes'),
						"type" => "universal",
						"heading" => esc_html__("Locations", 'dentalpress-shortcodes'),
						"param_name" => "locations",
						"template" => '<div class="vc_row"><div class="vc_col-xs-6 vu_m-b-10"><div class="wpb_element_label">'. esc_html__('Latitude', 'smartestate') .'</div><input name="lat" type="text" value=""></div><div class="vc_col-xs-6 vu_m-b-10"><div class="wpb_element_label">'. esc_html__('Longitude', 'smartestate') .'</div><input name="lng" type="text" value=""></div><div class="vc_col-xs-12 vu_m-b-10"><div class="wpb_element_label">'. esc_html__('Info Window', 'smartestate') .'</div><textarea name="info"></textarea></div><div class="vc_col-xs-12 vu_m-b-10"><div class="wpb_element_label">'. esc_html__('Marker', 'smartestate') .'</div><div class="vu_param_media vc_clearfix"><div class="vu_param_m-img-holder"><span class="vu_param_m-img"></span></div><div class="vu_param_m-content"><input type="hidden" name="marker_id" class="vu_param_m-img-id"><input type="text" name="marker_url" class="vu_param_m-img-url" readonly="readonly" placeholder="'. esc_attr__('No marker selected. Custom marker will be inhereted.', 'smartestate') .'"><button type="button" class="vu_param_m-btn vu_as-param" data-control="upload" data-title="'. esc_attr__('Add Image', 'smartestate') .'" data-button="'. esc_attr__('Add Image', 'smartestate') .'">'. esc_html__('Upload', 'smartestate') .'</button><button type="button" class="vu_param_m-btn vu_as-param" data-control="remove">'. esc_html__('Remove', 'smartestate') .'</button></div></div></div></div>',
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter map locations details.", 'dentalpress-shortcodes')
					)
				)
			)
		);
	}
?>