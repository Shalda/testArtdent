<?php 
	$atts = shortcode_atts( array(
		"layout" => "",
		"vertical_align" => "",
		"css_animation" => "",
		"animation_delay" => "",
		"el_class" => "",
		"css" => "",
		"width" => "",
		"offset" => ""
	), $atts );

	// Layout
	$atts['el_class'] .= ' vu_c-layout-'. esc_attr($atts['layout']);

	// Vertical align
	$atts['el_class'] .= ' vu_c-valign-'. esc_attr($atts['vertical_align']);

	// VU custom css class
	$custom_class = 'vu_c-custom-'. rand(100000, 999999);
	$atts['el_class'] .= ' '. $custom_class;

	// Width & Offset
	$width = wpb_translateColumnWidthToSpan( $atts['width'] );
	$width = vc_column_offset_class_merge( $atts['offset'], $width );

	if ( !empty($width) ) {
		$atts['el_class'] .= ' '. $width;
	}

	// VC custom css class
	if ( function_exists('vc_shortcode_custom_css_class') ) {
		$atts['el_class'] .= ' '. vc_shortcode_custom_css_class( $atts['css'] );
	}

	// VC default css classes
	$atts['el_class'] = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $atts['el_class'], $this->settings['base'], $atts ) );

	// Animation delay
	$atts['animation_delay'] = absint($atts['animation_delay']);

	ob_start(); ?>

	<div class="vu_column<?php dentalpress_extra_class($atts['el_class']); ?>"<?php echo ($atts['css_animation'] != 'none' && $atts['css_animation'] != '') ? ' data-animation="'. esc_attr($atts['css_animation']) .'"' . (($atts['animation_delay'] > 0) ? ' data-delay="'. $atts['animation_delay'] .'"' : '') : ''; ?>>
		<div class="vu_c-wrapper">
			<?php echo wpb_js_remove_wpautop( $content ); ?>
		</div>
	</div>

	<?php $output = ob_get_contents();
	ob_end_clean();
	
	echo ($output);
?>