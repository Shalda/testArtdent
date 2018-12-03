<?php 
	/**
	 * Gallery Shortcode
	 *
	 * @param string $atts['type']
	 * @param string $atts['layout']
	 * @param string $atts['style']
	 * @param string $atts['space']
	 * @param string $atts['filterable']
	 * @param string $atts['filter_style']
	 * @param string $atts['category_text']
	 * @param string $atts['categories']
	 * @param string $atts['items']
	 * @param string $atts['show_navigation']
	 * @param string $atts['show_pagination']
	 * @param string $atts['autoplay']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_gallery_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"type" => "",
			"layout" => "",
			"style" => "",
			"space" => "",
			"filterable" => "",
			"filter_style" => "",
			"category_text" => "",
			"categories" => "",
			"items" => "",
			"show_navigation" => "",
			"show_pagination" => "",
			"autoplay" => "",
			"class" => ""
		), $atts );

		ob_start();

		if( $atts['type'] == 'standard' ) :
	?>
		<div class="vu_gallery vu_g-type-standard vu_lightbox vu_l-gallery vu_g-style-<?php echo esc_attr($atts['style']); ?><?php dentalpress_extra_class($atts['class']); ?>" data-delegate="a.vu_gi-lightbox" data-layout="<?php echo esc_attr($atts['layout']); ?>"<?php echo ($atts['style'] == 'with-space') ? ' data-space="'. (!empty($atts['space']) ? absint($atts['space']) : '30') .'"' : ''; ?>>
			<div class="vu_g-items">
				<?php 
					$content = preg_replace('/\[(\[?)(vu_gallery_item)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/', '[$1$2$3$4 layout="'. absint($atts['layout']) .'" type="standard"]', $content);

					echo do_shortcode($content);
				?>
			</div>
		</div>
	<?php 
		elseif( $atts['type'] == 'masonry' ) :
	?>
		<div class="vu_gallery vu_g-type-masonry vu_lightbox vu_l-gallery vu_g-style-<?php echo esc_attr($atts['style']); ?><?php echo ($atts['filterable'] == '1') ? ' vu_g-filterable' : ''; ?><?php dentalpress_extra_class($atts['class']); ?>" data-delegate=".vu_g-item:visible a.vu_gi-lightbox" data-layout="<?php echo esc_attr($atts['layout']); ?>"<?php echo ($atts['style'] == 'with-space') ? ' data-space="'. (!empty($atts['space']) ? absint($atts['space']) : '30') .'"' : ''; ?>>
			<?php if( $atts['filterable'] == '1') { ?>
				<div class="container">
					<div class="vu_g-filters vu_g-filters-style-<?php echo esc_attr($atts['filter_style']); ?>">
						<span class="vu_g-filter active" data-filter="*"><?php echo esc_html($atts['category_text']); ?></span>

						<?php 
							$categories = @explode("\n", strip_tags($atts['categories']));

							if( is_array($categories) ) {
								foreach ($categories as $category) {
									echo '<span class="vu_g-filter" data-filter=".'. esc_attr(md5(sanitize_title($category))) .'">'. esc_html($category) .'</span>';
								}
							}
						?>
					</div>
				</div>
			<?php } ?>

			<div class="vu_g-items">
				<?php 
					$content = preg_replace('/\[(\[?)(vu_gallery_item)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/', '[$1$2$3$4 layout="'. absint($atts['layout']) .'" type="masonry"]', $content);

					echo do_shortcode($content);
				?>
			</div>
		</div>
	<?php 
		else :
			$carousel_options = array();

			$carousel_options['singleItem'] = false;
			$carousel_options['autoHeight'] = true;
			$carousel_options['items'] = absint($atts['items']);
			$carousel_options['itemsDesktop'] = array(1199, absint($atts['items']));
			$carousel_options['itemsDesktopSmall'] = array(980, absint($atts['items']));
			$carousel_options['itemsTablet'] = array(768, 2);
			$carousel_options['itemsMobile'] = array(479, 1);
			$carousel_options['navigation'] = ($atts['show_navigation'] == '1') ? true : false;
			$carousel_options['navigationText'] = array('<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>');
			$carousel_options['pagination'] = ($atts['show_pagination'] == '1') ? true : false;
			$carousel_options['paginationNumbers'] = false;
			$carousel_options['autoPlay'] = ($atts['autoplay'] == '' || $atts['autoplay'] == '0') ? false : absint($atts['autoplay']);
			$carousel_options['stopOnHover'] = true;
			$carousel_options['rewindNav'] = true;
			$carousel_options['scrollPerPage'] = false;
	?>
		<div class="vu_gallery vu_g-type-carousel vu_lightbox vu_l-gallery<?php dentalpress_extra_class($atts['class']); ?>" data-delegate="a.vu_gi-lightbox"<?php echo ($atts['style'] == 'with-space') ? ' data-space="'. (!empty($atts['space']) ? absint($atts['space']) : '30') .'"' : ''; ?>>
			<div class="vu_g-carousel vu_carousel" data-options="<?php echo esc_attr(json_encode($carousel_options)); ?>">
				<?php echo do_shortcode($content); ?>
			</div>
		</div>
	<?php
		endif;

		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_gallery', 'dentalpress_gallery_shortcode');

	/**
	 * Gallery VC Shortcode
	 */

	if( class_exists('WPBakeryShortCodesContainer') ) {
		class WPBakeryShortCode_vu_gallery extends WPBakeryShortCodesContainer {
		}

		vc_map(
			array(
				"name" => esc_html__("Gallery", 'dentalpress-shortcodes'),
				"description" => esc_html__('Add gallery', 'dentalpress-shortcodes'),
				"base" => "vu_gallery",
				"class" => "vc_vu_gallery",
				"icon" => "vu_element-icon vu_gallery-icon",
				"controls" => "full",
				"as_parent" => array( 'only' => 'vu_gallery_item' ),
				"js_view" => 'VcColumnView',
				"content_element" => true,
				"is_container" => true,
				"container_not_allowed" => false,
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"default_content" => '',
				"params" => array(
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Type", 'dentalpress-shortcodes'),
						"param_name" => "type",
						"value" => array(
							esc_html__("Standard", 'dentalpress-shortcodes') => 'standard',
							esc_html__("Masonry", 'dentalpress-shortcodes') => 'masonry',
							esc_html__("Carousel", 'dentalpress-shortcodes') => 'carousel'
						),
						"save_always" => true,
						"description" => esc_html__("Select gallery type.", 'dentalpress-shortcodes'),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Layout", 'dentalpress-shortcodes'),
						"param_name" => "layout",
						"dependency" => array("element" => "type", "value" => array("standard", "masonry")),
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
						"description" => esc_html__("Select gallery layout.", 'dentalpress-shortcodes'),
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
						"description" => esc_html__("Select gallery style.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Space", 'dentalpress-shortcodes'),
						"param_name" => "space",
						"dependency" => array("element" => "style", "value" => "with-space"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter in space between elements in integer. Default is 30px.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Make gallery filterable?", 'dentalpress-shortcodes'),
						"param_name" => "filterable",
						"dependency" => array("element" => "type", "value" => "masonry"),
						"value" => array(esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"save_always" => true
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Filter Style", 'dentalpress-shortcodes'),
						"param_name" => "filter_style",
						"dependency" => array("element" => "filterable", "value" => "1"),
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
						"dependency" => array("element" => "filterable", "value" => "1"),
						"value" => esc_html__("All", 'dentalpress-shortcodes'),
						"save_always" => true,
						"description" => esc_html__("Enter in all category text.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Categories", 'dentalpress-shortcodes'),
						"param_name" => "categories",
						"dependency" => array("element" => "filterable", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter one category per line.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Items to display on screen", 'dentalpress-shortcodes'),
						"param_name" => "items",
						"dependency" => array("element" => "type", "value" => "carousel"),
						"value" => "3",
						"save_always" => true,
						"description" => esc_html__("Maximum items to display at a time.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Show navigation", 'dentalpress-shortcodes'),
						"param_name" => "show_navigation",
						"dependency" => array("element" => "type", "value" => "carousel"),
						"value" =>  array( 'Yes Please' => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to show carousel navigation.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Show pagination", 'dentalpress-shortcodes'),
						"param_name" => "show_pagination",
						"dependency" => array("element" => "type", "value" => "carousel"),
						"value" =>  array( 'Yes Please' => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to show carousel pagination.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Auto play", 'dentalpress-shortcodes'),
						"param_name" => "autoplay",
						"dependency" => array("element" => "type", "value" => "carousel"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Change to any integrer for example <b>5000</b> to play every <b>5</b> seconds. Leave blank to disable autoplay.", 'dentalpress-shortcodes')
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