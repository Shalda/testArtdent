<?php 
	/**
	 * Pricing List Shortcode
	 *
	 * @param string $atts['title']
	 * @param string $atts['link']
	 * @param string $atts['description']
	 * @param string $atts['older_price']
	 * @param string $atts['current_price']
	 * @param string $atts['custom_colors']
	 * @param string $atts['description_color']
	 * @param string $atts['price_color']
	 * @param string $atts['line_color']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 * @param string $atts['css']
	 */

	function dentalpress_pricing_list_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"title" => "",
			"link" => "",
			"description" => "",
			"older_price" => "",
			"current_price" => "",
			"custom_colors" => "",
			"title_color" => "",
			"description_color" => "",
			"price_color" => "",
			"line_color" => "",
			"class" => "",
			"css" => ""
		), $atts );

		$url = vc_build_link( $atts['link'] );

		if( $atts['custom_colors'] == '1' ) {
			$custom_class = dentalpress_custom_class();
			$atts['class'] .= ' '. $custom_class;
		}

		if( function_exists('vc_shortcode_custom_css_class') ) {
			$atts['class'] .= ' '. vc_shortcode_custom_css_class( $atts['css'] );
		}

		$atts['class'] = trim($atts['class']);

		ob_start();
	?>
		<div class="vu_pricing-list<?php echo (!empty($atts['older_price'])) ? ' vu_pl-with-older-price' : ''; ?> clearfix<?php dentalpress_extra_class($atts['class']); ?>" itemscope itemtype="http://schema.org/Product">
			<?php if( $atts['custom_colors'] == '1' ) : ?>
				<style scoped>
					<?php if( !empty($atts['title_color']) ) : ?>
						.vu_pricing-list.<?php echo esc_attr($custom_class); ?> .vu_pl-title { color: <?php echo esc_attr($atts['title_color']); ?> }
					<?php endif; ?>

					<?php if( !empty($atts['description_color']) ) : ?>
						.vu_pricing-list.<?php echo esc_attr($custom_class); ?> .vu_pl-description { color: <?php echo esc_attr($atts['description_color']); ?> }
					<?php endif; ?>

					<?php if( !empty($atts['older_price_color']) ) : ?>
						.vu_pricing-list.<?php echo esc_attr($custom_class); ?> .vu_pl-price { color: <?php echo esc_attr($atts['older_price_color']); ?> }
					<?php endif; ?>

					<?php if( !empty($atts['current_price_color']) ) : ?>
						.vu_pricing-list.<?php echo esc_attr($custom_class); ?> .vu_pl-price { color: <?php echo esc_attr($atts['current_price_color']); ?> }
					<?php endif; ?>

					<?php if( !empty($atts['line_color']) ) : ?>
						.vu_pricing-list.<?php echo esc_attr($custom_class); ?> .vu_pl-line { border-color: <?php echo esc_attr($atts['line_color']); ?> }
					<?php endif; ?>
				</style>
			<?php endif; ?>

			<div class="vu_pl-wrapper">
				<h4 class="vu_pl-title" itemprop="name">
					<?php if ( strlen( $atts['link'] ) > 0 && strlen( $url['url'] ) > 0 ) {
						echo '<a href="'. esc_url( $url['url'] ) .'" title="'. esc_attr($url['title']) .'" target="'. (strlen($url['target']) > 0 ? esc_attr($url['target']) : '_self') . '">'. esc_html($atts['title']) .'</a>';
					} else { 
						echo esc_html($atts['title']);
					} ?>
				</h4>

				<div class="vu_pl-line"></div>

				<h4 class="vu_pl-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<?php if ( !empty($atts['older_price']) ) : ?>
						<span class="vu_pl-older-price"><del><?php echo esc_html($atts['older_price']); ?></del></span>
					<?php endif; ?>

					<span class="vu_pl-current-price" itemprop="price" content="<?php echo esc_attr(@preg_replace('/([^0-9\\.])/i', '', $atts['current_price'])); ?>"><?php echo esc_html($atts['current_price']); ?></span></h4>
			</div>

			<div class="clear"></div>

			<?php echo !empty($atts['description']) ? '<div class="vu_pl-description" itemprop="description">'. wpautop($atts['description']) .'</div>' : ''; ?>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_pricing_list', 'dentalpress_pricing_list_shortcode');

	/**
	 * Pricing List VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_pricing_list extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_pricing_list", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_pricing_list', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Pricing List", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add pricing list item", 'dentalpress-shortcodes'),
				"base"		=> "vu_pricing_list",
				"class"		=> "vc_vu_pricing-list",
				"icon"		=> "vu_element-icon vu_pricing-list-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'dentalpress-shortcodes'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter pricing list title.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "vc_link",
						"heading" => esc_html__("URL (Link)", 'dentalpress-shortcodes'),
						"param_name" => "link",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Add link to pricing list.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Description", 'dentalpress-shortcodes'),
						"param_name" => "description",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter description.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Older Price", 'dentalpress-shortcodes'),
						"param_name" => "older_price",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter older price.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Current Price", 'dentalpress-shortcodes'),
						"param_name" => "current_price",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter current price.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "checkbox",
						"heading" => esc_html__("Custom Colors?", 'dentalpress-shortcodes'),
						"param_name" => "custom_colors",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => '0',
						"save_always" => true,
						"description" => esc_html__("Check to use custom colors.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Title Color", 'dentalpress-shortcodes'),
						"param_name" => "title_color",
						"dependency" => array("element" => "custom_colors", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select title text custom color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Description Color", 'dentalpress-shortcodes'),
						"param_name" => "description_color",
						"dependency" => array("element" => "custom_colors", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select description text custom color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Older Price Color", 'dentalpress-shortcodes'),
						"param_name" => "older_price_color",
						"dependency" => array("element" => "custom_colors", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select price custom color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Current Price Color", 'dentalpress-shortcodes'),
						"param_name" => "current_price_color",
						"dependency" => array("element" => "custom_colors", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select price custom color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Line Color", 'dentalpress-shortcodes'),
						"param_name" => "line_color",
						"dependency" => array("element" => "custom_colors", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select line custom color.", 'dentalpress-shortcodes')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'dentalpress-shortcodes'),
						"param_name" => "class",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__("Design Options", 'dentalpress-shortcodes' ),
						"type" => "css_editor",
						"heading" => esc_html__("CSS box", 'dentalpress-shortcodes' ),
						"param_name" => "css"
					)
				)
			)
		);
	}
?>