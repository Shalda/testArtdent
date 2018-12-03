<?php
	/**
	 *	DentalPress WordPress Theme
	 */

	class DentalPress_Filters {
		function __construct() {
			add_filter( 'widget_text', 'do_shortcode' ); // Allow Shortcodes to be used on Text Widgets
			add_filter( 'wp_title', array($this, 'dentalpress_wp_title'), 10, 2 );
			add_filter( 'document_title_separator', array($this, 'dentalpress_document_title_separator') );
			add_filter( 'body_class', array($this, 'dentalpress_body_class') );
			add_filter( 'nav_menu_link_attributes', array($this, 'dentalpress_nav_menu_link_attributes'), 10, 3 );
			add_filter( 'wp_nav_menu', array($this, 'dentalpress_wp_nav_menu'), 10, 2 );
			add_filter( 'upload_mimes', array($this, 'dentalpress_upload_mimes') );
			add_filter( 'wp_check_filetype_and_ext', array($this, 'dentalpress_wp_check_filetype_and_ext'), 75, 4 );
			add_filter( 'comment_form_fields', array($this, 'dentalpress_comment_form_fields') );
			add_filter( 'wpcf7_verify_nonce', '__return_true' );
			add_filter( 'wpcf7_ajax_loader', array($this, 'dentalpress_wpcf7_ajax_loader') );

			remove_filter('widget_text_content', 'wpautop'); // Remove p tags from text widgets in WordPress 4.8
		}
		
		// Filter wp_title
		function dentalpress_wp_title( $title, $sep ) {
			$title = get_bloginfo('name') ." ". $sep ." ". ((is_home() || is_front_page()) ? get_bloginfo('description') : $title);

			return $title;
		}
		
		// Filter document_title_separator
		function dentalpress_document_title_separator( $sep ) {
			return '|';
		}
		
		// Add specific CSS class by filter
		function dentalpress_body_class( $classes ) {
			if ( dentalpress_get_option('navigation-position', 'sidebar') == 'sidebar' ) {
				$classes[] = 'vu_nav-position-sidebar';
			} else {
				$classes[] = 'vu_nav-position-header';
			}

			return $classes;
		}

		// Add 'itemprop' attribute for links in menu
		function dentalpress_nav_menu_link_attributes( $atts, $item, $args ) {
			$atts['itemprop'] = 'url';
			return $atts;
		}

		// Add Font Awesome icons to menu - (https://wordpress.org/plugins/font-awesome-4-menus/)
		function dentalpress_wp_nav_menu( $nav ) {
			$menu_item = preg_replace_callback(
				'/(<li[^>]+class=")([^"]+)("?[^>]+>[^>]+>)([^<]+)<\/a>/',
				array($this, 'dentalpress_wp_nav_menu_replace'),
				$nav
			);
			return $menu_item;
		}
		
		function dentalpress_wp_nav_menu_replace( $a ) {
			$start = $a[ 1 ];
			$classes = $a[ 2 ];
			$rest = $a[ 3 ];
			$text = $a[ 4 ];
			$before = true;
			
			$class_array = explode( ' ', $classes );
			$fontawesome_classes = array();

			foreach( $class_array as $key => $val ){
				if( 'fa' == substr( $val, 0, 2 ) ){
					if( 'fa' == $val ){
						unset( $class_array[ $key ] );
					} elseif( 'fa-after' == $val ){
						$before = false;
						unset( $class_array[ $key ] );
					} else {
						$fontawesome_classes[] = $val;
						unset( $class_array[ $key ] );
					}
				}
			}
			
			if( !empty( $fontawesome_classes ) ){
				$fontawesome_classes[] = 'fa';
				if( $before ){
					$newtext = '<i class="'.implode( ' ', $fontawesome_classes ).'"></i><span>'.$text.'</span>';
				} else {
					$newtext = '<span>'.$text.'</span><i class="'.implode( ' ', $fontawesome_classes ).'"></i>';
				}
			} else {
				$newtext = $text;
			}
			
			$item = $start.implode( ' ', $class_array ).$rest.$newtext.'</a>';

			return $item;
		}

		// Allow uploading SVG Files
		function dentalpress_upload_mimes($mimes){
			$mimes['svg'] = 'image/svg+xml';

			return $mimes;
		}

		function dentalpress_wp_check_filetype_and_ext( $data = null, $file = null, $filename = null, $mimes = null ) {
			$ext = isset( $data['ext'] ) ? $data['ext'] : '';

			if ( strlen( $ext ) < 1 ) {
				$ext = strtolower( end( explode( '.', $filename ) ) );
			}

			if ( $ext === 'svg' ) {
				$data['type'] = 'image/svg+xml';
				$data['ext']  = 'svg';
			}

			return $data;
		}

		// Moving the Comment Text Field to Bottom
		function dentalpress_comment_form_fields($fields) {
			$comment_field = $fields['comment'];
			unset( $fields['comment'] );
			$fields['comment'] = $comment_field;
			return $fields;
		}

		// Contact Form 7 change ajax loader image
		function dentalpress_wpcf7_ajax_loader($url) {
			return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHdpZHRoPScyOHB4JyBoZWlnaHQ9JzI4cHgnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmlld0JveD0iMCAwIDEwMCAxMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIiBjbGFzcz0idWlsLXJpbmctYWx0Ij48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0ibm9uZSIgY2xhc3M9ImJrIj48L3JlY3Q+PGNpcmNsZSBjeD0iNTAiIGN5PSI1MCIgcj0iNDAiIHN0cm9rZT0iI2RkZCIgZmlsbD0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxMCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L2NpcmNsZT48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSI0MCIgc3Ryb2tlPSIjNDQ0NDQ0IiBmaWxsPSJub25lIiBzdHJva2Utd2lkdGg9IjYiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCI+PGFuaW1hdGUgYXR0cmlidXRlTmFtZT0ic3Ryb2tlLWRhc2hvZmZzZXQiIGR1cj0iMnMiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIiBmcm9tPSIwIiB0bz0iNTAyIj48L2FuaW1hdGU+PGFuaW1hdGUgYXR0cmlidXRlTmFtZT0ic3Ryb2tlLWRhc2hhcnJheSIgZHVyPSIycyIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiIHZhbHVlcz0iMTUwLjYgMTAwLjQ7MSAyNTA7MTUwLjYgMTAwLjQiPjwvYW5pbWF0ZT48L2NpcmNsZT48L3N2Zz4=';
		}
	}

	$DentalPress_Filters = new DentalPress_Filters();
?>