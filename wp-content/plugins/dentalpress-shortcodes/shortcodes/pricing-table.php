<?php 
	/**
	 * Pricing Table Shortcode
	 *
	 * @param string $atts['title']
	 * @param string $atts['amount']
	 * @param string $atts['currency']
	 * @param string $atts['period']
	 * @param string $atts['bg_color']
	 * @param string $atts['content']
	 * @param string $atts['show_button']
	 * @param string $atts['button_text']
	 * @param string $atts['button_link']
	 * @param string $atts['active']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_pricing_table_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"title" => "",
			"amount" => "",
			"currency" => "",
			"period" => "",
			"show_button" => "",
			"button_text" => "",
			"button_link" => "",
			"active" => "",
			"class" => ""
		), $atts );

		$button_link = vc_build_link( $atts['button_link'] );

		$amount = @explode('.', $atts['amount']);

		ob_start();
	?>
		<div class="vu_pricing-table<?php echo ($atts['active'] == '1') ? ' vu_pt-active' : ''; ?><?php dentalpress_extra_class($atts['class']); ?>">
			<div class="vu_pt-header">
				<div class="vu_pt-price">
					<?php if ( !empty($atts['currency']) ) : ?>
						<span class="vu_pt-currency"><?php echo esc_html($atts['currency']); ?></span>
					<?php endif; ?>
					
					<h3 class="vu_pt-amount<?php echo (isset($amount[1]) && !empty($amount[1])) ? ' vu_pt-a-with-decimal' : ''; ?>"><?php echo isset($amount[0]) ? esc_html($amount[0]) : esc_html($atts['amount']); ?><?php echo (isset($amount[1]) && !empty($amount[1])) ? '<sup>'. esc_html($amount[1]) .'</sup>' : ''; ?></h3>

					<?php if ( !empty($atts['period']) ) : ?>
						<span class="vu_pt-period"><?php echo esc_html($atts['period']); ?></span>
					<?php endif; ?>
				</div>

				<h4 class="vu_pt-title"><?php echo esc_html($atts['title']); ?></h4>
			</div>

			<div class="vu_pt-content">
				<?php echo wpb_js_remove_wpautop($content, true); ?>
			</div>
			
			<?php if ( $atts['show_button'] == '1' ) { ?>
				<div class="vu_pt-button">
					<?php echo '<a href="'. esc_url( $button_link['url'] ) .'" title="'. esc_attr( $button_link['title'] ) .'" target="'. ( strlen( $button_link['target'] ) > 0 ? esc_attr( $button_link['target'] ) : '_self' ) . '">'. esc_attr($atts['button_text']) .'</a>'; ?>
				</div>
			<?php } ?>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_pricing_table', 'dentalpress_pricing_table_shortcode');

	/**
	 * Pricing Table VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_pricing_table extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_pricing_table", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_pricing_table', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Pricing Table", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add pricing table item", 'dentalpress-shortcodes'),
				"base"		=> "vu_pricing_table",
				"class"		=> "vc_vu_pricing-table",
				"icon"		=> "vu_element-icon vu_pricing-table-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"group" => esc_html__('Header', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Title", 'dentalpress-shortcodes'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter pricing table title [eg. Basic Pack].", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Header', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Amount", 'dentalpress-shortcodes'),
						"param_name" => "amount",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter amount/price. [eg. 35]", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Header', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Currency", 'dentalpress-shortcodes'),
						"param_name" => "currency",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter pricing table currency. [eg. $]", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Header', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Period", 'dentalpress-shortcodes'),
						"param_name" => "period",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter price period. [eg. per month, year]", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Header', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Active", 'dentalpress-shortcodes'),
						"param_name" => "active",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check this to make pricing table active.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Header', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'dentalpress-shortcodes'),
						"param_name" => "class",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Content', 'dentalpress-shortcodes'),
						"type" => "textarea_html",
						"heading" => esc_html__("Content", 'dentalpress-shortcodes'),
						"param_name" => "content",
						"value" => "<ul><li>item</li><li>item</li><li>item</li><li>item</li><li>item</li></ul>",
						"save_always" => true,
						"description" => esc_html__("Write pricing table content.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Button', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show Button", 'dentalpress-shortcodes'),
						"param_name" => "show_button",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check this to show button.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Button', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Text", 'dentalpress-shortcodes'),
						"param_name" => "button_text",
						"dependency" => array("element" => "show_button", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter button text. [eg. get now, see more].", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Button', 'dentalpress-shortcodes'),
						"type" => "vc_link",
						"heading" => esc_html__("URL (Link)", 'dentalpress-shortcodes'),
						"param_name" => "button_link",
						"dependency" => array("element" => "show_button", "value" => "1"),
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Add button link, link target and link title.", 'dentalpress-shortcodes')
					)
				)
			)
		);
	}
?>