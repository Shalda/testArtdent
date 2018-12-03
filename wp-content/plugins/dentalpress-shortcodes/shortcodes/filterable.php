<?php 
	/**
	 * Filterable Shortcode
	 *
	 * @param string $atts['layout']
	 * @param string $atts['style']
	 * @param string $atts['category_text']
	 * @param string $atts['categories']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_filterable_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"layout" => "",
			"style" => "",
			"filter_style" => "",
			"category_text" => "",
			"categories" => "",
			"class" => ""
		), $atts );

		ob_start();
	?>
		<div class="vu_filterable vu_f-layout-<?php echo esc_attr($atts['layout']); ?> vu_f-style-<?php echo esc_attr($atts['style']); ?><?php dentalpress_extra_class($atts['class']); ?>">
			<div class="vu_f-filters vu_f-filters-style-<?php echo esc_attr($atts['filter_style']); ?>">
				<span class="vu_f-filter active" data-filter="*"><?php echo esc_html($atts['category_text']); ?></span>

				<?php 
					$categories = @explode("\n", strip_tags($atts['categories']));

					if( is_array($categories) ) {
						foreach ($categories as $category) {
							echo '<span class="vu_f-filter" data-filter=".'. esc_attr(md5(sanitize_title($category))) .'">'. esc_html($category) .'</span>';
						}
					}
				?>
			</div>

			<div class="vu_f-items">
				<?php echo do_shortcode($content); ?>
			</div>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_filterable', 'dentalpress_filterable_shortcode');

	/**
	 * Filterable VC Shortcode
	 */

	if( class_exists('WPBakeryShortCodesContainer') ) {
		class WPBakeryShortCode_vu_filterable extends WPBakeryShortCodesContainer {
		}

		vc_map(
			array(
				"name"		=> esc_html__("Filterable", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add filterable", 'dentalpress-shortcodes'),
				"base"		=> "vu_filterable",
				"class"		=> "vc_vu_filterable",
				"icon"		=> "vu_element-icon vu_filterable-icon",
				"controls"	=> "full",
				"as_parent" => array( 'only' => 'vu_filterable_item' ),
				"js_view" => 'VcColumnView',
				"content_element" => true,
				"is_container" => true,
				"container_not_allowed" => false,
				"category"  => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				'default_content' => '[vu_filterable_item][/vu_filterable_item]',
				"params"	=> array(array(
						"type" => "dropdown",
						"heading" => esc_html__("Layout", 'dentalpress-shortcodes'),
						"param_name" => "layout",
						"value" => array(
							esc_html__("1 Column", 'dentalpress-shortcodes') => '1',
							esc_html__("2 Columns", 'dentalpress-shortcodes') => '2',
							esc_html__("3 Columns", 'dentalpress-shortcodes') => '3',
							esc_html__("4 Columns", 'dentalpress-shortcodes') => '4',
							esc_html__("5 Columns", 'dentalpress-shortcodes') => '5',
							esc_html__("6 Columns", 'dentalpress-shortcodes') => '6'
						),
						"std" => "3",
						"save_always" => true,
						"description" => esc_html__("Select filterable layout.", 'dentalpress-shortcodes'),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'dentalpress-shortcodes'),
						"param_name" => "style",
						"value" => array(
							esc_html__("With Space", 'dentalpress-shortcodes') => 'with-space',
							esc_html__("Without Space", 'dentalpress-shortcodes') => 'without-space'
						),
						"save_always" => true,
						"description" => esc_html__("Select filterable style.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Filter Style", 'dentalpress-shortcodes'),
						"param_name" => "filter_style",
						"value" => array(
							esc_html__("#1", 'dentalpress-shortcodes') => '1',
							esc_html__("#2", 'dentalpress-shortcodes') => '2'
						),
						"save_always" => true,
						"description" => esc_html__("Select gallery filter style.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("All category text", 'dentalpress-shortcodes'),
						"param_name" => "category_text",
						"value" => "All",
						"save_always" => true,
						"description" => esc_html__("Enter in all category text.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Categories", 'dentalpress-shortcodes'),
						"param_name" => "categories",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter one category per line.", 'dentalpress-shortcodes')
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