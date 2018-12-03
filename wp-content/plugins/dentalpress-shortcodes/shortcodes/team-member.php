<?php 
	/**
	 * Team Member Shortcode
	 *
	 * @param string $atts['image']
	 * @param string $atts['name']
	 * @param string $atts['position']
	 * @param string $atts['description']
	 * @param string $atts['link']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 * @param string $atts['facebook']
	 * @param string $atts['show_social_networks']
	 * @param string $atts['twitter']
	 * @param string $atts['google_plus']
	 * @param string $atts['instagram']
	 * @param string $atts['linkedin']
	 * @param string $atts['youtube']
	 * @param string $atts['tumblr']
	 * @param string $atts['dirbbble']
	 * @param string $atts['behance']
	 */

	function dentalpress_team_member_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			"image" => "",
			"ratio" => "",
			"name" => "",
			"position" => "",
			"description" => "",
			"link" => "",
			"class" => "",
			"style" => "",
			"show_social_networks" => "",
			"social_networks" => "",
			"css" => ""
		), $atts );

		$link = vc_build_link( $atts['link'] );

		if( function_exists('vc_shortcode_custom_css_class') ) {
			$atts['class'] .= ' '. vc_shortcode_custom_css_class( $atts['css'] );
		}

		$atts['class'] = trim($atts['class']);

		$social_networks = json_decode(base64_decode($atts['social_networks']), true);

		$has_social_networks = ( ($atts['show_social_networks'] == '1') and (is_array($social_networks) and !empty($social_networks)) ) ? true : false;

		ob_start();
	?>
		<div class="vu_team-member vu_tm-style-<?php echo esc_attr($atts['style']); ?><?php echo ($has_social_networks == true) ? ' vu_tm-with-social-networks' : ''; ?><?php dentalpress_extra_class($atts['class']); ?>" itemscope="itemscope" itemtype="https://schema.org/Person">
			<div class="vu_tm-container">
				<?php if( !empty( $atts['image'] ) ) : ?>
					<div class="vu_tm-image">
						<?php echo wp_get_attachment_image( $atts['image'], 'dentalpress_ratio-'. $atts['ratio'], false, array("itemprop" => "image") ); ?>

						<?php if( $has_social_networks == true ) : ?>
							<div class="vu_tm-social-networks">
								<ul class="list-unstyled">
									<?php 
										foreach ($social_networks as $social_network) {
											if( !empty( $social_network['icon'] ) ) {
												echo '<li><a href="'. esc_url( $social_network['url'] ) .'" target="_blank" itemprop="url"><i class="'. ((strpos($social_network['icon'], 'fa-') !== false) ? 'fa '. esc_attr($social_network['icon']) : esc_attr($social_network['icon'])) .'"></i></a></li>';
											}
										}
									?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="vu_tm-info">
					<?php 
						if ( strlen( $atts['link'] ) > 0 && strlen( $link['url'] ) > 0 ) {
							echo '<h4 class="vu_tm-name"><a href="'. esc_url( $link['url'] ) .'" title="'. esc_attr( $link['title'] ) .'" target="'. ( strlen( $link['target'] ) > 0 ? esc_attr( $link['target'] ) : '_self' ) . '">'. esc_html( $atts['name'] ) .'</a></h4>';
						} else {
							echo '<h4 class="vu_tm-name">'. esc_html( $atts['name'] ) .'</h4>';
						}
					?>
					
					<?php if( !empty( $atts['position'] ) ) : ?>
						<span class="vu_tm-position" itemprop="jobTitle"><?php echo esc_html( $atts['position'] ); ?></span>
					<?php endif; ?>
				</div>
			</div>
			
			<?php if( !empty( $atts['description'] ) ) : ?>
				<div class="vu_tm-content" itemprop="description">
					<?php echo wpautop( $atts['description'] ); ?>
				</div>
			<?php endif; ?>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_team_member', 'dentalpress_team_member_shortcode');

	/**
	 * Team Member VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ) {
		class WPBakeryShortCode_vu_team_member extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_team_member", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_team_member', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Team Member", 'dentalpress-shortcodes'),
				"description" => esc_html__("Add team member", 'dentalpress-shortcodes'),
				"base"		=> "vu_team_member",
				"class"		=> "vc_vu_team_member",
				"icon"		=> "vu_element-icon vu_team-member-icon",
				"controls"	=> "full",
				"category"  => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "attach_image",
						"heading" => esc_html__("Image", 'dentalpress-shortcodes'),
						"param_name" => "image",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Select team member image.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "dropdown",
						"heading" => esc_html__("Ratio", 'dentalpress-shortcodes'),
						"param_name" => "ratio",
						"value" => dentalpress_get_image_ratios(),
						"std" => '1:1',
						"save_always" => true,
						"description" => esc_html__("Select ratio of image.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Name", 'dentalpress-shortcodes'),
						"param_name" => "name",
						"admin_label" => true,
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter team member name.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Position", 'dentalpress-shortcodes'),
						"param_name" => "position",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter team member position.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textarea",
						"heading" => esc_html__("Description", 'dentalpress-shortcodes'),
						"param_name" => "description",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Enter team member description.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "vc_link",
						"heading" => esc_html__("URL (Link)", 'dentalpress-shortcodes'),
						"param_name" => "link",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Add link to name.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'dentalpress-shortcodes'),
						"param_name" => "class",
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Style', 'dentalpress-shortcodes'),
						"type" => "image_select",
						"heading" => esc_html__("Style", 'dentalpress-shortcodes'),
						"param_name" => "style",
						"value" =>  array(
							"1" => 'http://dl.flexipress.xyz/dentalpress/assets/team-member-styles/1.jpg',
							"2" => 'http://dl.flexipress.xyz/dentalpress/assets/team-member-styles/2.jpg',
							"3" => 'http://dl.flexipress.xyz/dentalpress/assets/team-member-styles/3.jpg'
						),
						"width" => "calc(100% / 3 - 10px)",
						"height" => "auto",
						"std" => "1",
						"save_always" => true,
						"description" => esc_html__("Select style.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Social Networks', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show social networks?", 'dentalpress-shortcodes'),
						"param_name" => "show_social_networks",
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => "1"),
						"std" => '0',
						"save_always" => true,
						"description" => esc_html__("Check to show social networks.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Social Networks', 'dentalpress-shortcodes'),
						"type" => "universal",
						"heading" => esc_html__("Social Networks", 'dentalpress-shortcodes'),
						"param_name" => "social_networks",
						"dependency" => array("element" => "show_social_networks", "value" => "1"),
						"template" => '<div class="vc_row"><div class="vc_col-xs-3 vu_m-b-10"><div class="wpb_element_label">Icon</div><div class="input-group vu_ipc-container"><input data-placement="right" name="icon" class="icp vu_iconpicker" value="fa-facebook" type="text" /><span class="input-group-addon vu_ipc-icon"></span></div></div><div class="vc_col-xs-9"><div class="wpb_element_label">URL</div><input name="url" type="text" value=""></div></div>',
						"value" => "",
						"save_always" => true,
						"description" => esc_html__("Add social networks.", 'dentalpress-shortcodes')
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