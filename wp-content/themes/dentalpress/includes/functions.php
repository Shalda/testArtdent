<?php
	/**
	 *	DentalPress WordPress Theme
	 */

	// Print Pagination
	if( !function_exists('dentalpress_pagination') ) {
		function dentalpress_pagination($query = null) {
			global $wp_query, $wp_rewrite;

			if( !empty($query) ){
				$wp_query = $query;
			}
				
			$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
			$total_pages = $wp_query->max_num_pages;

			if ($total_pages > 1){
				$permalink_structure = get_option('permalink_structure');
				$query_type = (count($_GET)) ? '&' : '?';
				$format = empty( $permalink_structure ) ? $query_type.'paged=%#%' : 'page/%#%/';
			
				echo '<div class="row"><div class="col-xs-12"><div class="vu_pagination">';
				
				$paginate_links = paginate_links(array(
					'base' => get_pagenum_link(1) . '%_%',
					'format' => $format,
					'current' => $current,
					'total' => $total_pages,
					'type' => 'list',
					'prev_text' => '<i class="vu_fi vu_fi-arrow-left" aria-hidden="true"></i>',
					'next_text' => '<i class="vu_fi vu_fi-arrow-right" aria-hidden="true"></i>',
					'before_page_number' => '',
					'after_page_number' => ''
				));

				echo str_replace("<ul class='page-numbers'>", '<ul class="vu_p-list list-unstyled">', $paginate_links);
				
				echo  '</div></div></div>';
			}
		}
	}

	// Print Blog Social Networks
	if( !function_exists('dentalpress_blog_social_networks') ) {
		function dentalpress_blog_social_networks($url, $title = null, $post_id = null) {
			if( dentalpress_get_option('blog-social-networks') ) : ?>
				<div class="vu_bp-social-networks">
					<ul class="list-unstyled">
						<?php if( dentalpress_get_option( array('blog-social-networks', 'facebook') ) == '1' ) { ?>
							<li>
								<a href="#" class="vu_social-link" data-href="http://www.facebook.com/sharer.php?u=<?php echo esc_url($url); ?>&amp;t=<?php echo urlencode($title); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
							</li>
						<?php } if( dentalpress_get_option( array('blog-social-networks', 'twitter') ) == '1' ) { ?>
							<li>
								<a href="#" class="vu_social-link" data-href="https://twitter.com/share?text=<?php echo urlencode($title); ?>&amp;url=<?php echo esc_url($url); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
							</li>
						<?php } if( dentalpress_get_option( array('blog-social-networks', 'google-plus') ) == '1' ) { ?>
							<li>
								<a href="#" class="vu_social-link" data-href="https://plus.google.com/share?url=<?php echo esc_url($url); ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
							</li>
						<?php } if( dentalpress_get_option( array('blog-social-networks', 'pinterest') ) == '1' ) { ?>
							<li>
								<a href="#" class="vu_social-link" data-href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($url); ?>&amp;description=<?php echo urlencode($title); ?>&amp;media=<?php echo dentalpress_get_attachment_image_src($post_id, array(705, 470)); ?>"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
							</li>
						<?php } if( dentalpress_get_option( array('blog-social-networks', 'linkedin') ) == '1' ) { ?>
							<li>
								<a href="#" class="vu_social-link" data-href="http://linkedin.com/shareArticle?mini=true&amp;title=<?php echo urlencode($title); ?>&amp;url=<?php echo esc_url($url); ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
							</li>
						<?php } ?>
					</ul>
				</div>
		<?php 
			endif;
		}
	}

	// Single Comment Template
	if( !function_exists('dentalpress_comments') ) {
		function dentalpress_comments($comment, $args, $depth){
			$GLOBALS['comment'] = $comment;
		?>
		<li <?php comment_class('clearfix'); ?> id="vu_c-comment-<?php comment_ID(); ?>">
			<?php if ( $comment->comment_type == 'pingback' or $comment->comment_type == 'trackback' ) : ?>
				<?php edit_comment_link(esc_html__('Edit', 'dentalpress'), '<span class="vu_c-a-m-item vu_c-a-edit">', '</span>' ); ?>
				<p><?php echo esc_html__( 'Pingback:', 'dentalpress' ); ?> <?php comment_author_link(); ?></p>
			<?php else : ?>
				<article id="comment-<?php comment_ID(); ?>" class="vu_c-article">
					<div class="vu_c-a-avatar">
						<?php echo get_avatar( get_comment_author_email() ); ?>
					</div>

					<div class="vu_c-a-container">
						<header class="vu_c-a-header">
							<h5 class="vu_c-a-author">
								<?php $comment_author_url = get_comment_author_url(); ?>

								<?php if( !empty($comment_author_url) ) : ?>
									<a href="<?php comment_author_url(); ?>" rel="external nofollow"><?php comment_author(); ?></a>
								<?php 
									else :
										comment_author();
									endif;
								?>
							</h5>

							<div class="vu_c-a-meta">
								<span class="vu_c-a-m-item vu_c-a-date">
									<time datetime="<?php comment_date('c'); ?>"><?php comment_date(get_option('date_format')) ?> <?php esc_html_e('at', 'dentalpress'); ?> <?php comment_date(get_option('time_format')); ?></time>
								</span>

								<?php edit_comment_link(esc_html__('Edit', 'dentalpress'), '<span class="vu_c-a-m-item vu_c-a-edit">', '</span>' ); ?>

								<span class="vu_c-a-m-item vu_c-a-reply">
									<a href="#" class="vu_c-a-reply-link" data-id="<?php comment_ID(); ?>"><?php esc_html_e('Reply', 'dentalpress'); ?></a>
								</span>
							</div>
						</header>
						
						<div class="vu_c-a-content">
							<?php if ($comment->comment_approved == '0') : ?>
								<p><em class="vu_c-a-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'dentalpress'); ?></em></p>
							<?php endif; ?>

							<?php comment_text(); ?>
						</div>
					</div>
				</article>
			<?php endif; ?>
		<?php 
		}
	}
	
	// Check If Has Sidebar
	if( !function_exists('dentalpress_has_sidebar') ) {
		function dentalpress_has_sidebar($data) {
			if ( !isset($data['sidebar']) ) {
				return false;
			}

			if ( $data['sidebar'] == 'none' ) {
				return false;
			}

			if ( (empty($data['sidebar']) or $data['sidebar'] == 'inherit') and empty(dentalpress_get_option('default-sidebar', '')) and !is_active_sidebar(dentalpress_get_option('default-sidebar', '')) ) {
				return false;
			}

			if ( $data['sidebar'] != 'inherit' and !is_active_sidebar($data['sidebar']) ) {
				return false;
			}

			return true;
		}
	}
	
	// Print Dynamic Sidebar
	if( !function_exists('dentalpress_dynamic_sidebar') ) {
		function dentalpress_dynamic_sidebar($sidebar) {
			if ( $sidebar == 'none' ) {
				return;
			}

			if ( empty($sidebar) or $sidebar == 'inherit' ) {
				$sidebar = dentalpress_get_option('default-sidebar', '');
			}

			if ( !empty($sidebar) ) {
				dynamic_sidebar( $sidebar );
			}
		}
	}
	
	// Check if footer sidebars has widgets
	if( !function_exists('dentalpress_footer_sidebars_has_widgets') ) {
		function dentalpress_footer_sidebars_has_widgets() {
			$footer_layout = absint( dentalpress_get_option('footer-layout') );

			for ( $i = 1; $i <= $footer_layout; $i++ ) {
				if( is_active_sidebar('footer-'. $i) ) {
					return true;
				}
			}

			return false;
		}
	}
	
	// Get Current URL
	if( !function_exists('dentalpress_get_current_url') ) {
		function dentalpress_get_current_url() {
			global $wp;
			return home_url( add_query_arg( array() , $wp->request ) );
		}
	}
	
	// Convert Color from HEX to RGB
	if( !function_exists('dentalpress_hex2rgb') ){
		function dentalpress_hex2rgb($color, $string = false) {
			if ( $color[0] == '#' ) {
				$color = substr( $color, 1 );
			}

			if ( strlen( $color ) == 6 ) {
				list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
				list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
				return false;
			}

			$r = hexdec( $r );
			$g = hexdec( $g );
			$b = hexdec( $b );

			if( $string == true ) {
				return $r.','.$g.','.$b;
			} else {
				return array( 'red' => $r, 'green' => $g, 'blue' => $b );
			}
		}
	}

	// Convert Color from RGB to HEX
	if( !function_exists('dentalpress_rgb2hex') ){
		function dentalpress_rgb2hex($r, $g=-1, $b=-1) {
			if (is_array($r) && sizeof($r) == 3) {
				list($r, $g, $b) = $r;
			}

			$r = intval($r); $g = intval($g);
			$b = intval($b);

			$r = dechex($r < 0 ? 0 : ($r > 255 ? 255 : $r));
			$g = dechex($g < 0 ? 0 : ($g > 255 ? 255 : $g));
			$b = dechex($b < 0 ? 0 : ($b > 255 ? 255 : $b));

			$color = (strlen($r) < 2 ? '0' : ''). $r;
			$color .= (strlen($g) < 2 ? '0' : ''). $g;
			$color .= (strlen($b) < 2 ? '0' : ''). $b;

			return '#'.$color;
		}
	}

	// Compress the CSS
	if( !function_exists('dentalpress_css_compress') ){
		//https://github.com/matthiasmullie/minify/blob/master/src/CSS.php
		function dentalpress_css_compress($content){
			// reusable bits of code throughout these regexes:
			// before & after are used to make sure we don't match lose unintended
			// 0-like values (e.g. in #000, or in http://url/1.0)
			// units can be stripped from 0 values, or used to recognize non 0
			// values (where wa may be able to strip a .0 suffix)
			$before = '(?<=[:(, ])';
			$after = '(?=[ ,);}])';
			$units = '(em|ex|%|px|cm|mm|in|pt|pc|ch|rem|vh|vw|vmin|vmax|vm)';
			// strip units after zeroes (0px -> 0)
			$content = preg_replace('/' . $before . '(-?0*(\.0+)?)(?<=0)' . $units . $after . '/', '\\1', $content);
			// strip 0-digits (.0 -> 0)
			$content = preg_replace('/' . $before . '\.0+' . $after . '/', '0', $content);
			// 50.00 -> 50, 50.00px -> 50px (non-0 can still be followed by units)
			$content = preg_replace('/' . $before . '(-?[0-9]+)\.0+' . $units . '?' . $after . '/', '\\1\\2', $content);
			// strip negative zeroes (-0 -> 0) & truncate zeroes (00 -> 0)
			$content = preg_replace('/' . $before . '-?0+' . $after . '/', '0', $content);

			//Shorthand hex color codes
			$content = preg_replace('/(?<![\'"])#([0-9a-z])\\1([0-9a-z])\\2([0-9a-z])\\3(?![\'"])/i', '#$1$2$3', $content);

			//Strip comments from source code
			$content = preg_replace('/\/\*.*?\*\//s', '', $content);

			// remove leading & trailing whitespace
			$content = preg_replace('/^\s*/m', '', $content);
			$content = preg_replace('/\s*$/m', '', $content);
			// replace newlines with a single space
			$content = preg_replace('/\s+/', ' ', $content);
			// remove whitespace around meta characters
			// inspired by stackoverflow.com/questions/15195750/minify-compress-css-with-regex
			$content = preg_replace('/\s*([\*$~^|]?+=|[{};,>~]|!important\b)\s*/', '$1', $content);
			$content = preg_replace('/([\[(:])\s+/', '$1', $content);
			$content = preg_replace('/\s+([\]\)])/', '$1', $content);
			$content = preg_replace('/\s+(:)(?![^\}]*\{)/', '$1', $content);
			// whitespace around + and - can only be stripped in selectors, like
			// :nth-child(3+2n), not in things like calc(3px + 2px) or shorthands
			// like 3px -2px
			$content = preg_replace('/\s*([+-])\s*(?=[^}]*{)/', '$1', $content);
			// remove semicolon/whitespace followed by closing bracket
			$content = preg_replace('/;}/', '}', $content);
			return trim($content);
		}
	}

	/* ----------------------------------------------------------------------------------
	 * The following functions are also declared in the DentalPress Shortcodes Plugin.
	 * If you want to modify any of these functions you may need to make the same changes
	 * to the functions in DentalPress Shortcodes Plugin as well.
	 * ---------------------------------------------------------------------------------- */
	
	// Default Theme Options
	if( !function_exists('dentalpress_default_theme_options') ) {
		function dentalpress_default_theme_options() {
			return json_decode('{"last_tab":"0","logo":{"url":"'. get_template_directory_uri() .'/assets/img/dentalpress-logo.png","id":"","height":"240","width":"675","thumbnail":""},"logo-width":"150","smooth-scroll":"","preloader":"","preloader-image":{"url":"'. get_template_directory_uri() .'/assets/img/preloader.svg","id":"","height":"","width":"","thumbnail":""},"site-mode":"normal","site-mode-page":"","primary-color":"#50b0e3","secondary-color":"#a4d735","body-background":{"background-color":"#f9f9f9","background-repeat":"","background-size":"","background-attachment":"","background-position":"","background-image":"'. get_template_directory_uri() .'/assets/img/pattern.png","media":{"id":"","height":"","width":"","thumbnail":""}},"body-typography":{"font-family":"Open Sans","font-options":"","google":"1","font-weight":"400","font-style":"","subsets":"latin","text-transform":"none","font-size":"14px","line-height":"24px","color":"#777777"},"nav-typography":{"font-family":"Poppins","font-options":"","google":"1","font-weight":"600","font-style":"","subsets":"latin","text-transform":"uppercase","font-size":"14px","line-height":"24px","color":"#777777"},"nav-submenu-typography":{"font-family":"Open Sans","font-options":"","google":"1","font-weight":"400","font-style":"","subsets":"latin","text-transform":"none","font-size":"14px","line-height":"20px","color":"#777777"},"h1-typography":{"font-family":"Poppins","font-options":"","google":"1","font-weight":"500","font-style":"","subsets":"latin","text-transform":"none","font-size":"24px","line-height":"34px","color":"#414141"},"h2-typography":{"font-family":"Poppins","font-options":"","google":"1","font-weight":"500","font-style":"","subsets":"latin","text-transform":"none","font-size":"20px","line-height":"30px","color":"#414141"},"h3-typography":{"font-family":"Poppins","font-options":"","google":"1","font-weight":"500","font-style":"","subsets":"latin","text-transform":"none","font-size":"18px","line-height":"28px","color":"#414141"},"h4-typography":{"font-family":"Poppins","font-options":"","google":"1","font-weight":"500","font-style":"","subsets":"latin","text-transform":"none","font-size":"16px","line-height":"26px","color":"#414141"},"h5-typography":{"font-family":"Poppins","font-options":"","google":"1","font-weight":"500","font-style":"","subsets":"latin","text-transform":"none","font-size":"14px","line-height":"24px","color":"#414141"},"h6-typography":{"font-family":"Poppins","font-options":"","google":"1","font-weight":"400","font-style":"","subsets":"latin","text-transform":"none","font-size":"12px","line-height":"22px","color":"#414141"},"top-bar-show":"1","top-bar-text-color":"#777777","top-bar-left-content":"<span>Let us take care of you and your smile!</span>","top-bar-right-content":"<div class=\"vu_social-icon\"><a href=\"#\" target=\"_self\"><i class=\"fa fa-facebook\"></i></a></div><div class=\"vu_social-icon\"><a href=\"#\" target=\"_self\"><i class=\"fa fa-twitter\"></i></a></div><div class=\"vu_social-icon m-r-0\"><a href=\"#\" target=\"_self\"><i class=\"fa fa-instagram\"></i></a></div>","header-padding":{"padding-top":"10px","padding-bottom":"10px","units":"px"},"header-widgets":"","navigation-position":"sidebar","navigation-submenu-width":"200","page-header-show":"1","page-header-bg-image":{"url":"","id":"","height":"","width":"","thumbnail":""},"page-header-parallax":"1","blog-social":"1","blog-social-networks":{"facebook":"1","twitter":"1","google-plus":"1","pinterest":"1","linkedin":""},"blog-show-date":"1","blog-show-author":"","blog-show-tags":"","blog-single-show-tags":"1","center-lat":"","center-lng":"","zoom-level":"","map-height":"580","map-type":"roadmap","map-style":"","map-tilt-45":"","use-marker-img":"","marker-img":{"url":"","id":"","height":"","width":"","thumbnail":""},"enable-map-animation":"","map-others-options":{"draggable":"1","zoomControl":"","disableDoubleClickZoom":"","scrollwheel":"","panControl":"","mapTypeControl":"","scaleControl":"","streetViewControl":""},"map-point-1":"","latitude1":"","longitude1":"","map-info1":"","map-point-2":"","latitude2":"","longitude2":"","map-info2":"","map-point-3":"","latitude3":"","longitude3":"","map-info3":"","map-point-4":"","latitude4":"","longitude4":"","map-info4":"","map-point-5":"","latitude5":"","longitude5":"","map-info5":"","map-point-6":"","latitude6":"","longitude6":"","map-info6":"","map-point-7":"","latitude7":"","longitude7":"","map-info7":"","map-point-8":"","latitude8":"","longitude8":"","map-info8":"","map-point-9":"","latitude9":"","longitude9":"","map-info9":"","map-point-10":"","latitude10":"","longitude10":"","map-info10":"","map-point-11":"","latitude11":"","longitude11":"","map-info11":"","map-point-12":"","latitude12":"","longitude12":"","map-info12":"","map-point-13":"","latitude13":"","longitude13":"","map-info13":"","map-point-14":"","latitude14":"","longitude14":"","map-info14":"","map-point-15":"","latitude15":"","longitude15":"","map-info15":"","map-point-16":"","latitude16":"","longitude16":"","map-info16":"","map-point-17":"","latitude17":"","longitude17":"","map-info17":"","map-point-18":"","latitude18":"","longitude18":"","map-info18":"","map-point-19":"","latitude19":"","longitude19":"","map-info19":"","map-point-20":"","latitude20":"","longitude20":"","map-info20":"","number-of-locations":"1","footer-show":"1","footer-layout":"4","footer-bg-color":{"background-color":"#ffffff"},"footer-text-color":"#777777","subfooter-show":"1","subfooter-text-color":"#777777","subfooter-left-content":"Copyright &copy; 2017 <a href=\"http://themeforest.net/user/flexipress/portfolio\" target=\"_blank\">FlexiPress</a>. All Rights Reserved.","subfooter-right-content":"","back-to-top-show":"1","default-sidebar":"general-sidebar","sidebars":[],"google-map-api-key":"","google-analytics-tracking-code":"","twitter-consumer-key":"","twitter-consumer-secret":"","twitter-user-token":"","twitter-user-secret":"","mailchimp-api":"","mailchimp-list-id":"","custom-css":"","custom-js":"","default-options":"1"}', true);
		}
	}

	// Convert shortcode atts to string
	if( !function_exists('dentalpress_shortcode_atts') ){
		function dentalpress_shortcode_atts($atts){
			$return = '';

			foreach ($atts as $key => $value) {
				$return .= ' '. $key .'="'. esc_attr($value) .'"';
			}

			return $return;
		}
	}

	// Generate shortcode as string
	if( !function_exists('dentalpress_generate_shortcode') ){
		function dentalpress_generate_shortcode($tag, $atts, $content = null){
			$return = '['. $tag . dentalpress_shortcode_atts($atts) .']';

			if( !empty($content) ){
				$return .= $content .'[/'. $tag .']';
			}

			return $return;
		}
	}

	// Extra class for shortcode
	if( !function_exists('dentalpress_extra_class') ){
		function dentalpress_extra_class($class, $echo = true){
			$return = ((!empty($class)) ? ' '. trim(esc_attr($class)) : '');

			if( $echo == true ) {
				echo ($return);
			} else {
				return $return;
			}
		}
	}

	// Get image ratios
	if( !function_exists('dentalpress_get_image_ratios') ) {
		function dentalpress_get_image_ratios() {
			return array(
				"1:1" => "1:1",
				"2:1" => "2:1",
				"3:2" => "3:2",
				"3:4" => "3:4",
				"4:3" => "4:3",
				"16:9" => "16:9"
			);
		}
	}

	// Print Excerpt with Custom Length
	if( !function_exists('dentalpress_the_excerpt') ) {
		function dentalpress_the_excerpt($num_of_words, $post_excerpt = null) {
			$excerpt = empty($post_excerpt) ? get_the_excerpt() : $post_excerpt;

			$exwords = explode( ' ', trim( mb_substr( $excerpt, 0, mb_strlen($excerpt) - 5 ) ) );

			if( count($exwords) > $num_of_words ){
				$excerpt = array();

				$i = 0;
				foreach ($exwords as $value) {
					if( $i >= $num_of_words ) break;
					array_push($excerpt, $value);
					$i++;
				}

				echo implode(' ', $excerpt) . ' [...]';
			} else {
				echo ($excerpt);
			}
		}
	}

	// Get Map Options from Theme Options
	if( !function_exists('dentalpress_get_map_options') ) {
		function dentalpress_get_map_options(){
			$map_options = array(
				'zoom_level' => esc_attr(dentalpress_get_option('zoom-level')),
				'center_lat' => esc_attr(dentalpress_get_option('center-lat')),
				'center_lng' => esc_attr(dentalpress_get_option('center-lng')),
				"map_type" => esc_attr(dentalpress_get_option('map-type')),
				"tilt_45" => esc_attr(dentalpress_get_option('map-tilt-45')),
				'others_options' => array(
					"zoomControl" => esc_attr(dentalpress_get_option( array('map-others-options', 'zoomControl') )),
					"disableDoubleClickZoom" => esc_attr(dentalpress_get_option( array('map-others-options', 'disableDoubleClickZoom') )),
					"scrollwheel" => esc_attr(dentalpress_get_option( array('map-others-options', 'scrollwheel') )),
					"panControl" => esc_attr(dentalpress_get_option( array('map-others-options', 'panControl') )),
					"mapTypeControl" => esc_attr(dentalpress_get_option( array('map-others-options', 'mapTypeControl') )),
					"scaleControl" => esc_attr(dentalpress_get_option( array('map-others-options', 'scaleControl') )),
					"streetViewControl" => esc_attr(dentalpress_get_option( array('map-others-options', 'streetViewControl') ))
				),
				'use_marker_img' => esc_attr(dentalpress_get_option('use-marker-img')),
				'marker_img' => esc_attr(dentalpress_get_option( array('marker-img', 'url') )),
				'enable_animation' => esc_attr(dentalpress_get_option('enable-map-animation')),
				'locations' => array()
			);

			$number_of_locations = dentalpress_get_option('number-of-locations');

			for($i=1; $i<=$number_of_locations; $i++){
				if( dentalpress_get_option('map-point-'. $i) != false ){
					array_push($map_options['locations'], array('lat' => esc_attr(dentalpress_get_option('latitude'. $i)), 'lng' => esc_attr(dentalpress_get_option('longitude'. $i)), 'info' => esc_attr(dentalpress_get_option('map-info'. $i))));
				}
			}

			return $map_options;
		}
	}

	// Get Map Style
	if( !function_exists('dentalpress_get_map_style') ) {
		function dentalpress_get_map_style($map_style){
			switch ($map_style) {
				case '1':
					return '[{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]}]';
				case '2':
					return '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]';
				case '3':
					return '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]';
				case '4':
					return '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]';
				case '5':
					return '[{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]}]';
				case '6':
					return '[{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#f7f1df"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#d0e3b4"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#fbd3da"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#bde6ab"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffe15f"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efd151"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"black"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#cfb2db"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#a2daf2"}]}]';
				case '7':
					return '[{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]}]';
				case '8':
					return '[{"featureType":"all","elementType":"all","stylers":[{"saturation":-100},{"gamma":0.5}]}]';
				case '9':
					return '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}]';
				case '10':
					return '[{"elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"color":"#f5f5f2"},{"visibility":"on"}]},{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi.attraction","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","stylers":[{"visibility":"off"}]},{"featureType":"poi.school","stylers":[{"visibility":"off"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#ffffff"},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"visibility":"simplified"},{"color":"#ffffff"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"color":"#ffffff"},{"visibility":"off"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.park","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#71c8d4"}]},{"featureType":"landscape","stylers":[{"color":"#e5e8e7"}]},{"featureType":"poi.park","stylers":[{"color":"#8ba129"}]},{"featureType":"road","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.sports_complex","elementType":"geometry","stylers":[{"color":"#c7c7c7"},{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#a0d3d3"}]},{"featureType":"poi.park","stylers":[{"color":"#91b65d"}]},{"featureType":"poi.park","stylers":[{"gamma":1.51}]},{"featureType":"road.local","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"poi.government","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","stylers":[{"visibility":"simplified"}]},{"featureType":"road"},{"featureType":"road"},{},{"featureType":"road.highway"}]';
				case '11':
					return '[{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#b5cbe4"}]},{"featureType":"landscape","stylers":[{"color":"#efefef"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#83a5b0"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#bdcdd3"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e3eed3"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]';
				case '12':
					return '[{"stylers":[{"hue":"#2c3e50"},{"saturation":250}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":50},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]}]';
				case '13':
					return '[{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#C6E2FF"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#C5E3BF"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#D1D1B8"}]}]';
				case '14':
					return '[{"featureType":"all","stylers":[{"saturation":0},{"hue":"#e7ecf0"}]},{"featureType":"road","stylers":[{"saturation":-70}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"visibility":"simplified"},{"saturation":-60}]}]';
				case '15':
					return '[{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"simplified"}]},{"featureType":"road","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"visibility":"off"}]},{"featureType":"road.local","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"water","stylers":[{"color":"#84afa3"},{"lightness":52}]},{"stylers":[{"saturation":-77}]},{"featureType":"road"}]';
				case '16':
					return '[{"stylers":[{"hue":"#dd0d0d"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]}]';
				case '17':
					return '[{"featureType":"landscape","stylers":[{"hue":"#FFA800"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#53FF00"},{"saturation":-73},{"lightness":40},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FBFF00"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#00FFFD"},{"saturation":0},{"lightness":30},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#00BFFF"},{"saturation":6},{"lightness":8},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#679714"},{"saturation":33.4},{"lightness":-25.4},{"gamma":1}]},{"featureType":"poi.business","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]}]';
				case '18':
					return '[{"stylers":[{"hue":"#16a085"},{"saturation":0}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]}]';
				case '19':
					return '[{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#fffffa"}]},{"featureType":"water","stylers":[{"lightness":50}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"lightness":40}]}]';
				case '20':
					return '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]';
				case '21':
					return '[{"stylers":[{"visibility":"on"},{"saturation":-100}]},{"featureType":"water","stylers":[{"visibility":"on"},{"saturation":100},{"hue":"#00ffe6"}]},{"featureType":"road","elementType":"geometry","stylers":[{"saturation":100},{"hue":"#00ffcc"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]}]';
				case '22':
					return '[{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#fcfcfc"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#fcfcfc"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#dddddd"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#dddddd"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#dddddd"}]}]';
				case '23':
					return '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#0465b0"},{"visibility":"on"}]}]';

				default:
					return "";
			}
		}
	}
?>