<?php 
	// Remove VC Teaser Meta Box
	if( !function_exists("dentalpress_vc_remove_meta_box") ) {
		function dentalpress_vc_remove_meta_box() {
			remove_meta_box("vc_teaser", "page", "side");
		}
	}

	add_action( "admin_head", "dentalpress_vc_remove_meta_box" );

	// Filter to replace default css class names for vc_row shortcode and vc_column
	if( !function_exists('dentalpress_vc_shortcodes_css_class') ) {
		function dentalpress_vc_shortcodes_css_class( $class_string, $tag ) {
			if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
				$class_string = str_replace( 'vc_row-fluid', 'row-fluid', $class_string );
				$class_string = str_replace( 'vc_row', 'row', $class_string );
			}

			if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
				$class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'col-md-$1', $class_string );
			}

			$class_string = str_replace( array('wpb_row', 'wpb_column', 'vc_column_container', 'wpb_wrapper'), '', $class_string );

			$class_string = preg_replace('/\s+/', ' ', $class_string);

			return trim($class_string);
		}
	}

	add_filter( 'vc_shortcodes_css_class', 'dentalpress_vc_shortcodes_css_class', 10, 2 );

	// Remove some elements
	if( function_exists('vc_remove_element') ) {
		vc_remove_element("vc_button");
		vc_remove_element("vc_cta_button");
		vc_remove_element("vc_cta_button2");

		vc_remove_element("vc_tabs");
		vc_remove_element("vc_tour");
		vc_remove_element("vc_accordion");
		vc_remove_element("vc_tta_pageable");
		
		vc_remove_element("rev_slider_vc");
	}

	// Remove params for [vc_section] shortcode
	if( function_exists('vc_remove_param') ) {
		vc_remove_param( "vc_section", "full_width" );
		vc_remove_param( "vc_section", "full_height" );
		vc_remove_param( "vc_section", "content_placement" );
		vc_remove_param( "vc_section", "video_bg" );
		vc_remove_param( "vc_section", "video_bg_url" );
		vc_remove_param( "vc_section", "video_bg_parallax" );
		vc_remove_param( "vc_section", "parallax" );
		vc_remove_param( "vc_section", "parallax_image" );
		vc_remove_param( "vc_section", "parallax_speed_video" );
		vc_remove_param( "vc_section", "parallax_speed_bg" );
		vc_remove_param( "vc_section", "css_animation" );
		vc_remove_param( "vc_section", "el_id" );
		vc_remove_param( "vc_section", "disable_element" );
		vc_remove_param( "vc_section", "el_class" );
		vc_remove_param( "vc_section", "css" );
	}

	// Remove params for [vc_row] shortcode
	if( function_exists('vc_remove_param') ) {
		vc_remove_param( "vc_row", "full_width" );
		vc_remove_param( "vc_row", "gap" );
		vc_remove_param( "vc_row", "full_height" );
		vc_remove_param( "vc_row", "columns_placement" );
		vc_remove_param( "vc_row", "equal_height" );
		vc_remove_param( "vc_row", "content_placement" );
		vc_remove_param( "vc_row", "video_bg" );
		vc_remove_param( "vc_row", "video_bg_url" );
		vc_remove_param( "vc_row", "video_bg_parallax" );
		vc_remove_param( "vc_row", "parallax" );
		vc_remove_param( "vc_row", "parallax_image" );
		vc_remove_param( "vc_row", "parallax_speed_video" );
		vc_remove_param( "vc_row", "css_animation" );
		vc_remove_param( "vc_row", "parallax_speed_bg" );
		vc_remove_param( "vc_row", "el_id" );
		vc_remove_param( "vc_row", "disable_element" );
		vc_remove_param( "vc_row", "el_class" );
		vc_remove_param( "vc_row", "css" );
	}

	// Remove params for [vc_row_inner] shortcode
	if( function_exists('vc_remove_param') ) {
		vc_remove_param( "vc_row_inner", "el_id" );
		vc_remove_param( "vc_row_inner", "equal_height" );
		vc_remove_param( "vc_row_inner", "content_placement" );
		vc_remove_param( "vc_row_inner", "gap" );
		vc_remove_param( "vc_row_inner", "disable_element" );
		vc_remove_param( "vc_row_inner", "el_class" );
		vc_remove_param( "vc_row_inner", "css" );
	}

	// Remove params for [vc_column] shortcode
	if( function_exists('vc_remove_param') ) {
		vc_remove_param( "vc_column", "css_animation" );
		vc_remove_param( "vc_column", "video_bg" );
		vc_remove_param( "vc_column", "video_bg_url" );
		vc_remove_param( "vc_column", "video_bg_parallax" );
		vc_remove_param( "vc_column", "parallax" );
		vc_remove_param( "vc_column", "parallax_image" );
		vc_remove_param( "vc_column", "parallax_speed_video" );
		vc_remove_param( "vc_column", "parallax_speed_bg" );
	}

	if( function_exists('vc_add_params') ) {
		// Add extra params for [vc_section] shortcode
		vc_add_params("vc_section", array(
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "dropdown",
				"heading" => esc_html__("Content Layout", 'dentalpress'),
				"param_name" => "content_layout",
				"weight" => 99,
				"value" => array(
					esc_html__("Boxed", 'dentalpress') => "boxed",
					esc_html__("Full", 'dentalpress') => "full"		
				),
				"std" => "full",
				"save_always" => true,
				"description" => esc_html__("Select section content layout.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "animation_style",
				"heading" => esc_html__( "CSS Animation", 'dentalpress' ),
				"param_name" => "css_animation",
				"value" => "",
				"weight" => 97,
				"description" => esc_html__("Select type of animation for element to be animated when it 'enters' the browsers viewport (Note: works only in modern browsers).", 'dentalpress' ),
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Animation Delay", 'dentalpress'),
				"param_name" => "animation_delay",
				"weight" => 96,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Specify time delay in milliseconds before animation happens.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "checkbox",
				"heading" => esc_html__("Disable section", 'dentalpress'),
				"param_name" => "disable",
				"weight" => 95,
				"value" => array( esc_html__("Yes Please", 'dentalpress') => "true"),
				"save_always" => true,
				"description" => esc_html__("If checked the section won't be visible on the public side of your website. You can switch it back any time.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Section ID", 'dentalpress'),
				"param_name" => "id",
				"weight" => 94,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Use this to option to add an ID onto your section. This can then be used to target the section with CSS or as an anchor point to scroll to when the relevant link is clicked.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Extra class name", 'dentalpress'),
				"param_name" => "class",
				"weight" => 93,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "dropdown",
				"heading" => esc_html__("Background Type", 'dentalpress'),
				"param_name" => "bg_type",
				"weight" => 92,
				"value" => array(
					esc_html__("Image", 'dentalpress') => "image",
					esc_html__("Video", 'dentalpress') => "video"		
				),
				"std" => "image",
				"save_always" => true,
				"description" => esc_html__("Select background type.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "attach_image",
				"heading" => esc_html__("Background Image", 'dentalpress'),
				"param_name" => "bg_image",
				"dependency" => array("element" => "bg_type", "value" => "image"),
				"weight" => 91,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Select image from media library.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Background Video", 'dentalpress'),
				"param_name" => "bg_video",
				"dependency" => array("element" => "bg_type", "value" => "video"),
				"weight" => 90,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Add YouTube video url.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "colorpicker",
				"heading" => esc_html__("Color Overlay", 'dentalpress'),
				"param_name" => "color_overlay",
				"weight" => 89,
				"value" => "",
				"save_always" => true,
				"description" => ""
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "checkbox",
				"heading" => esc_html__("Enable Parallax", 'dentalpress'),
				"param_name" => "enable_parallax",
				"weight" => 88,
				"value" => array( esc_html__("Yes Please", 'dentalpress') => "true"),
				"save_always" => true,
				"description" => esc_html__("If checked parallax effect will be enable.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "checkbox",
				"heading" => esc_html__("Enable Pattern", 'dentalpress'),
				"param_name" => "enable_pattern",
				"weight" => 87,
				"value" => array( esc_html__("Yes Please", 'dentalpress') => "true"),
				"save_always" => true,
				"description" => esc_html__("If checked pattern overaly will be enable.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "attach_image",
				"heading" => esc_html__("Pattern Image", 'dentalpress'),
				"param_name" => "pattern_image",
				"dependency" => array("element" => "enable_pattern", "value" => "true"),
				"weight" => 86,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Select image from media library.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Pattern Opacity", 'dentalpress'),
				"param_name" => "pattern_opacity",
				"dependency" => array("element" => "enable_pattern", "value" => "true"),
				"weight" => 85,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Fill the number between 0 to 1", 'dentalpress')
			),
			array(
				"group" => esc_html__("Design Options", 'dentalpress' ),
				"type" => "css_editor",
				"heading" => esc_html__("CSS box", 'dentalpress' ),
				"param_name" => "css",
				"weight" => 84
			)
		));

		// Add extra params for [vc_row] shortcode
		vc_add_params("vc_row", array(
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "dropdown",
				"heading" => esc_html__("Content Layout", 'dentalpress'),
				"param_name" => "content_layout",
				"weight" => 99,
				"value" => array(
					esc_html__("Boxed", 'dentalpress') => "boxed",
					esc_html__("Full", 'dentalpress') => "full"		
				),
				"std" => "boxed",
				"save_always" => true,
				"description" => esc_html__("Select row content layout.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "checkbox",
				"heading" => esc_html__("Equal Height", 'dentalpress'),
				"param_name" => "equal_height",
				"weight" => 98,
				"value" => array( esc_html__("Yes Please", 'dentalpress') => "true"),
				"save_always" => true,
				"description" => esc_html__("If checked columns will be set to equal height.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "animation_style",
				"heading" => esc_html__( "CSS Animation", 'dentalpress' ),
				"param_name" => "css_animation",
				"value" => "",
				"weight" => 97,
				"description" => esc_html__("Select type of animation for element to be animated when it 'enters' the browsers viewport (Note: works only in modern browsers).", 'dentalpress' ),
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Animation Delay", 'dentalpress'),
				"param_name" => "animation_delay",
				"weight" => 96,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Specify time delay in milliseconds before animation happens.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "checkbox",
				"heading" => esc_html__("Disable row", 'dentalpress'),
				"param_name" => "disable",
				"weight" => 95,
				"value" => array( esc_html__("Yes Please", 'dentalpress') => "true"),
				"save_always" => true,
				"description" => esc_html__("If checked the row won't be visible on the public side of your website. You can switch it back any time.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Row ID", 'dentalpress'),
				"param_name" => "id",
				"weight" => 94,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Use this to option to add an ID onto your row. This can then be used to target the row with CSS or as an anchor point to scroll to when the relevant link is clicked.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Extra class name", 'dentalpress'),
				"param_name" => "class",
				"weight" => 93,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "dropdown",
				"heading" => esc_html__("Background Type", 'dentalpress'),
				"param_name" => "bg_type",
				"weight" => 92,
				"value" => array(
					esc_html__("Image", 'dentalpress') => "image",
					esc_html__("Video", 'dentalpress') => "video"		
				),
				"std" => "image",
				"save_always" => true,
				"description" => esc_html__("Select background type.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "attach_image",
				"heading" => esc_html__("Background Image", 'dentalpress'),
				"param_name" => "bg_image",
				"dependency" => array("element" => "bg_type", "value" => "image"),
				"weight" => 91,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Select image from media library.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Background Video", 'dentalpress'),
				"param_name" => "bg_video",
				"dependency" => array("element" => "bg_type", "value" => "video"),
				"weight" => 90,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Add YouTube video url.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "colorpicker",
				"heading" => esc_html__("Color Overlay", 'dentalpress'),
				"param_name" => "color_overlay",
				"weight" => 89,
				"value" => "",
				"save_always" => true,
				"description" => ""
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "checkbox",
				"heading" => esc_html__("Enable Parallax", 'dentalpress'),
				"param_name" => "enable_parallax",
				"weight" => 88,
				"value" => array( esc_html__("Yes Please", 'dentalpress') => "true"),
				"save_always" => true,
				"description" => esc_html__("If checked parallax effect will be enable.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "checkbox",
				"heading" => esc_html__("Enable Pattern", 'dentalpress'),
				"param_name" => "enable_pattern",
				"weight" => 87,
				"value" => array( esc_html__("Yes Please", 'dentalpress') => "true"),
				"save_always" => true,
				"description" => esc_html__("If checked pattern overaly will be enable.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "attach_image",
				"heading" => esc_html__("Pattern Image", 'dentalpress'),
				"param_name" => "pattern_image",
				"dependency" => array("element" => "enable_pattern", "value" => "true"),
				"weight" => 86,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Select image from media library.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Background", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Pattern Opacity", 'dentalpress'),
				"param_name" => "pattern_opacity",
				"dependency" => array("element" => "enable_pattern", "value" => "true"),
				"weight" => 85,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Fill the number between 0 to 1", 'dentalpress')
			),
			array(
				"group" => esc_html__("Design Options", 'dentalpress' ),
				"type" => "css_editor",
				"heading" => esc_html__("CSS box", 'dentalpress' ),
				"param_name" => "css",
				"weight" => 84
			)
		));

		// Add extra params for [vc_row_inner] shortcode
		vc_add_params("vc_row_inner", array(
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "checkbox",
				"heading" => esc_html__("Equal Height", 'dentalpress'),
				"param_name" => "equal_height",
				"weight" => 99,
				"value" => array( esc_html__("Yes Please", 'dentalpress') => "true"),
				"save_always" => true,
				"description" => esc_html__("If checked columns will be set to equal height.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "animation_style",
				"heading" => esc_html__( "CSS Animation", 'dentalpress' ),
				"param_name" => "css_animation",
				"value" => "",
				"weight" => 98,
				"description" => esc_html__("Select type of animation for element to be animated when it 'enters' the browsers viewport (Note: works only in modern browsers).", 'dentalpress' ),
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Animation Delay", 'dentalpress'),
				"param_name" => "animation_delay",
				"weight" => 97,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Specify time delay in milliseconds before animation happens.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "checkbox",
				"heading" => esc_html__("Disable row", 'dentalpress'),
				"param_name" => "disable",
				"weight" => 96,
				"value" => array( esc_html__("Yes Please", 'dentalpress') => "true"),
				"save_always" => true,
				"description" => esc_html__("If checked the row won't be visible on the public side of your website. You can switch it back any time.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Row ID", 'dentalpress'),
				"param_name" => "id",
				"weight" => 95,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Use this to option to add an ID onto your row. This can then be used to target the row with CSS or as an anchor point to scroll to when the relevant link is clicked.", 'dentalpress')
			),
			array(
				"group" => esc_html__("General", 'dentalpress'),
				"type" => "textfield",
				"heading" => esc_html__("Extra class name", 'dentalpress'),
				"param_name" => "class",
				"weight" => 94,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress')
			),
			array(
				"group" => esc_html__("Design Options", 'dentalpress' ),
				"type" => "css_editor",
				"heading" => esc_html__("CSS box", 'dentalpress' ),
				"param_name" => "css",
				"weight" => 93
			)
		));

		// Add extra params for [vc_column] shortcode
		vc_add_params("vc_column", array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Layout", 'dentalpress'),
				"param_name" => "layout",
				"weight" => 99,
				"value" => array(
					esc_html__("Normal", 'dentalpress') => "normal",
					esc_html__("Stretch Left", 'dentalpress') => "stretch-left",
					esc_html__("Stretch Right", 'dentalpress') => "stretch-right"	
				),
				"std" => "normal",
				"save_always" => true,
				"description" => esc_html__("Select column layout.", 'dentalpress' )
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Vertical Align", 'dentalpress'),
				"param_name" => "vertical_align",
				"weight" => 98,
				"value" => array(
					esc_html__("Top", 'dentalpress') => "top",
					esc_html__("Middle", 'dentalpress') => "middle",
					esc_html__("Bottom", 'dentalpress') => "bottom"	
				),
				"std" => "top",
				"save_always" => true,
				"description" => esc_html__("Select column vertical alignment.", 'dentalpress' )
			),
			array(
				"type" => "animation_style",
				"heading" => esc_html__( "CSS Animation", 'dentalpress' ),
				"param_name" => "css_animation",
				"value" => "",
				"weight" => 97,
				"description" => esc_html__("Select type of animation for element to be animated when it 'enters' the browsers viewport (Note: works only in modern browsers).", 'dentalpress' ),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Animation Delay", 'dentalpress'),
				"param_name" => "animation_delay",
				"weight" => 96,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Specify time delay in milliseconds before animation happens.", 'dentalpress')
			)
		));

		// Add extra params for [vc_column_inner] shortcode
		vc_add_params("vc_column_inner", array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Vertical Align", 'dentalpress'),
				"param_name" => "vertical_align",
				"weight" => 99,
				"value" => array(
					esc_html__("Top", 'dentalpress') => "top",
					esc_html__("Middle", 'dentalpress') => "middle",
					esc_html__("Bottom", 'dentalpress') => "bottom"	
				),
				"std" => "top",
				"save_always" => true,
				"description" => ""
			),
			array(
				"type" => "animation_style",
				"heading" => esc_html__( "CSS Animation", 'dentalpress' ),
				"param_name" => "css_animation",
				"value" => "",
				"weight" => 98,
				"description" => esc_html__("Select type of animation for element to be animated when it 'enters' the browsers viewport (Note: works only in modern browsers).", 'dentalpress' ),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Animation Delay", 'dentalpress'),
				"param_name" => "animation_delay",
				"weight" => 97,
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("Specify time delay in milliseconds before animation happens.", 'dentalpress')
			)
		));
	}

	// Remove params for [vc_tta_tabs] shortcode
	if( function_exists('vc_remove_param') ) {
		vc_remove_param( "vc_tta_tabs", "title" );
		vc_remove_param( "vc_tta_tabs", "style" );
		vc_remove_param( "vc_tta_tabs", "shape" );
		vc_remove_param( "vc_tta_tabs", "color" );
		vc_remove_param( "vc_tta_tabs", "no_fill_content_area" );
		vc_remove_param( "vc_tta_tabs", "spacing" );
		vc_remove_param( "vc_tta_tabs", "gap" );
		vc_remove_param( "vc_tta_tabs", "tab_position" );
		vc_remove_param( "vc_tta_tabs", "alignment" );
		vc_remove_param( "vc_tta_tabs", "autoplay" );
		vc_remove_param( "vc_tta_tabs", "active_section" );
		vc_remove_param( "vc_tta_tabs", "pagination_style" );
		vc_remove_param( "vc_tta_tabs", "pagination_color" );
		vc_remove_param( "vc_tta_tabs", "css_animation" );
		vc_remove_param( "vc_tta_tabs", "el_class" );
		vc_remove_param( "vc_tta_tabs", "css" );
	}

	// Add extra params for [vc_tta_tabs] shortcode
	if( function_exists('vc_add_params') ) {
		vc_add_params("vc_tta_tabs", array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Style", 'dentalpress'),
				"param_name" => "style",
				"value" => array(
					esc_html__("Style 1", 'dentalpress') => "1",
					esc_html__("Style 2", 'dentalpress') => "2",
					esc_html__("Style 3", 'dentalpress') => "3",
				),
				"save_always" => true,
				"description" => esc_html__("Select tabs style.", 'dentalpress')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Position", 'dentalpress'),
				"param_name" => "position",
				"value" => array(
					esc_html__("Top", 'dentalpress') => "top",
					esc_html__("Bottom", 'dentalpress') => "bottom"
				),
				"save_always" => true,
				"description" => esc_html__("Select tabs navigation position.", 'dentalpress')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Alignment", 'dentalpress'),
				"param_name" => "alignment",
				"value" => array(
					esc_html__("Left", 'dentalpress') => "left",
					esc_html__("Center", 'dentalpress') => "center",
					esc_html__("Right", 'dentalpress') => "right",
				),
				"save_always" => true,
				"description" => esc_html__("Select tabs section title alignment.", 'dentalpress')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Autoplay", 'dentalpress'),
				"param_name" => "autoplay",
				"value" => array(
					esc_html__("Disable", 'dentalpress') => "0",
					"3" => "3",
					"5" => "5",
					"10" => "10",
					"15" => "15"
				),
				"std" => "0",
				"save_always" => true,
				"description" => esc_html__("Select auto rotate for tabs in seconds (Note: disabled by default).", 'dentalpress')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Extra class name", 'dentalpress'),
				"param_name" => "class",
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress')
			)
		));
	}

	// Remove params for [vc_tta_tour] shortcode
	if( function_exists('vc_remove_param') ) {
		vc_remove_param( "vc_tta_tour", "title" );
		vc_remove_param( "vc_tta_tour", "style" );
		vc_remove_param( "vc_tta_tour", "shape" );
		vc_remove_param( "vc_tta_tour", "color" );
		vc_remove_param( "vc_tta_tour", "no_fill_content_area" );
		vc_remove_param( "vc_tta_tour", "spacing" );
		vc_remove_param( "vc_tta_tour", "gap" );
		vc_remove_param( "vc_tta_tour", "tab_position" );
		vc_remove_param( "vc_tta_tour", "alignment" );
		vc_remove_param( "vc_tta_tour", "controls_size" );
		vc_remove_param( "vc_tta_tour", "autoplay" );
		vc_remove_param( "vc_tta_tour", "active_section" );
		vc_remove_param( "vc_tta_tour", "pagination_style" );
		vc_remove_param( "vc_tta_tour", "pagination_color" );
		vc_remove_param( "vc_tta_tour", "css_animation" );
		vc_remove_param( "vc_tta_tour", "el_class" );
		vc_remove_param( "vc_tta_tour", "css" );
	}

	// Add extra params for [vc_tta_tour] shortcode
	if( function_exists('vc_add_params') ) {
		vc_add_params("vc_tta_tour", array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Position", 'dentalpress'),
				"param_name" => "position",
				"value" => array(
					esc_html__("Left", 'dentalpress') => "left",
					esc_html__("Right", 'dentalpress') => "right"
				),
				"save_always" => true,
				"description" => esc_html__("Select tabs navigation position.", 'dentalpress')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Autoplay", 'dentalpress'),
				"param_name" => "autoplay",
				"value" => array(
					esc_html__("Disable", 'dentalpress') => "0",
					"3" => "3",
					"5" => "5",
					"10" => "10",
					"15" => "15"
				),
				"std" => "0",
				"save_always" => true,
				"description" => esc_html__("Select auto rotate for tabs in seconds (Note: disabled by default).", 'dentalpress')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Extra class name", 'dentalpress'),
				"param_name" => "class",
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress')
			)
		));
	}

	// Remove params for [vc_tta_accordion] shortcode
	if( function_exists('vc_remove_param') ) {
		vc_remove_param( "vc_tta_accordion", "title" );
		vc_remove_param( "vc_tta_accordion", "style" );
		vc_remove_param( "vc_tta_accordion", "shape" );
		vc_remove_param( "vc_tta_accordion", "color" );
		vc_remove_param( "vc_tta_accordion", "no_fill" );
		vc_remove_param( "vc_tta_accordion", "spacing" );
		vc_remove_param( "vc_tta_accordion", "gap" );
		vc_remove_param( "vc_tta_accordion", "c_align" );
		vc_remove_param( "vc_tta_accordion", "autoplay" );
		vc_remove_param( "vc_tta_accordion", "c_icon" );
		vc_remove_param( "vc_tta_accordion", "c_position" );
		vc_remove_param( "vc_tta_accordion", "el_class" );
		vc_remove_param( "vc_tta_accordion", "css" );
	}

	// Add extra params for [vc_tta_accordion] shortcode
	if( function_exists('vc_add_params') ) {
		vc_add_params("vc_tta_accordion", array(
			array(
				"type" => "textfield",
				"heading" => esc_html__("Extra class name", 'dentalpress'),
				"param_name" => "class",
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress')
			)
		));
	}

	// Remove params for [vc_tta_section] shortcode
	if( function_exists('vc_remove_param') ) {
		vc_remove_param( "vc_tta_section", "add_icon" );
		vc_remove_param( "vc_tta_section", "i_position" );
		vc_remove_param( "vc_tta_section", "i_type" );
		vc_remove_param( "vc_tta_section", "i_icon_fontawesome" );
		vc_remove_param( "vc_tta_section", "i_icon_openiconic" );
		vc_remove_param( "vc_tta_section", "i_icon_typicons" );
		vc_remove_param( "vc_tta_section", "i_icon_entypo" );
		vc_remove_param( "vc_tta_section", "i_icon_linecons" );
		vc_remove_param( "vc_tta_section", "i_icon_monosocial" );
		vc_remove_param( "vc_tta_section", "i_icon_material" );
		vc_remove_param( "vc_tta_section", "el_class" );
	}

	// Add extra params for [vc_tta_section] shortcode
	if( function_exists('vc_add_params') ) {
		vc_add_params("vc_tta_section", array(
			array(
				"type" => "textfield",
				"heading" => esc_html__("Extra class name", 'dentalpress'),
				"param_name" => "class",
				"value" => "",
				"save_always" => true,
				"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress')
			)
		));
	}

	// Remove params for [vc_toggle] shortcode
	if( function_exists('vc_remove_param') ) {
		vc_remove_param( "vc_toggle", "use_custom_heading" );
		vc_remove_param( "vc_toggle", "style" );
		vc_remove_param( "vc_toggle", "color" );
		vc_remove_param( "vc_toggle", "size" );
		vc_remove_param( "vc_toggle", "css_animation" );
		vc_remove_param( "vc_toggle", "el_id" );
		vc_remove_param( "vc_toggle", "custom_font_container" );
		vc_remove_param( "vc_toggle", "custom_use_theme_fonts" );
		vc_remove_param( "vc_toggle", "custom_google_fonts" );
		vc_remove_param( "vc_toggle", "custom_css_animation" );
		vc_remove_param( "vc_toggle", "custom_el_class" );
		vc_remove_param( "vc_toggle", "css" );
	}
	
	// Update settings for [vc_toggle] shortcode
	if( function_exists('vc_map_update') ) {
		vc_map_update("vc_toggle", array(
			"name"		=> esc_html__("Toggle", 'dentalpress'),
			"description" => esc_html__('Add toggle element', 'dentalpress')
		));
	}
	
	if( !function_exists('dentalpress_update_vc_toggle_params') ) {
		function dentalpress_update_vc_toggle_params() {
			$title_param = WPBMap::getParam( 'vc_toggle', 'title' );
			$title_param['heading'] = esc_html__('Title', 'dentalpress');
			$title_param['edit_field_class'] = 'vc_col-sm-12';
			vc_update_shortcode_param( 'vc_toggle', $title_param );

			$content_param = WPBMap::getParam( 'vc_toggle', 'content' );
			$content_param['heading'] = esc_html__('Content', 'dentalpress');
			vc_update_shortcode_param( 'vc_toggle', $content_param );
		}
	}

	add_action( 'vc_after_init', 'dentalpress_update_vc_toggle_params' );
?>