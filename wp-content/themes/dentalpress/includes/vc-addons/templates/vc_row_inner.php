<?php 
	$atts = shortcode_atts( array(
		"equal_height" => "",
		"css_animation" => "",
		"animation_delay" => "",
		"disable" => "",
		"id" => "",
		"class" => "",
		"css" => ""
	), $atts );

	// Variables
	$custom_class = 'vu_ri-custom-'. rand(100000, 999999);

	// Equal height css class
	if ( $atts['equal_height'] == 'true' ) {
		$atts['class'] .= ' vu_ri-equal-height';
	}

	// Disable element
	if ( $atts['disable'] == 'true' ) {
		$atts['class'] .= ' hide';
	}

	// VU custom css class
	$atts['class'] .= ' '. $custom_class;

	// VC custom css class
	if( function_exists('vc_shortcode_custom_css_class') ) {
		$atts['class'] .= ' '. vc_shortcode_custom_css_class( $atts['css'] );
	}

	// Animation delay
	$atts['animation_delay'] = absint($atts['animation_delay']);

	ob_start(); ?>

	<div<?php echo !empty($atts['id']) ? ' id="'. esc_attr($atts['id']) .'"' : ''; ?> class="vu_row-inner row">
		<div class="vu_ri-wrapper<?php dentalpress_extra_class($atts['class']); ?>"<?php echo ($atts['css_animation'] != 'none' && $atts['css_animation'] != '') ? ' data-animation="'. esc_attr($atts['css_animation']) .'"' . (($atts['animation_delay'] > 0) ? ' data-delay="'. $atts['animation_delay'] .'"' : '') : ''; ?>>
			<div class="vu_ri-content clearfix">
				<?php echo wpb_js_remove_wpautop( $content ); ?>
			</div>
		</div>
	</div>

	<?php $output = ob_get_contents();
	ob_end_clean();
	
	echo ($output);
?>