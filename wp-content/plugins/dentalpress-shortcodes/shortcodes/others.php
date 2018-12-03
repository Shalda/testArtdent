<?php
	/**
	 * Others Shortcodes
	 */

	/**
	 * Embed Shortcode
	 *
	 * @param string $src Youtube video embed URL. eg: https://www.youtube.com/embed/{video_id} or https://player.vimeo.com/video/{video_id}
	 * @param string $ratio Video ratio that will properly scale on any device. eg: '16by9' or '4by3'. Default: '16by9'
	 */

	function dentalpress_embed_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'src' => '',
			'ratio' => '16by9'
		), $atts );

		return '<div class="embed-responsive embed-responsive-'. esc_attr($atts['ratio']) .'"><iframe class="embed-responsive-item" src="'. esc_url($atts['src']) .'"></iframe></div>';
	}

	add_shortcode('vu_embed', 'dentalpress_embed_shortcode');

	/**
	 * Custom Menu Shortcode
	 *
	 * @param int $atts['menu-slug'] The number of posts being displayed. Default: '3'
	 * @see https://codex.wordpress.org/Function_Reference/wp_get_recent_posts
	 */

	function dentalpress_custom_menu_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'menu' => '',
			'container' => 'nav',
			'container_id' => '',
			'container_class' => 'vu_custom-menu-container',
			'menu_id' => '',
			'menu_class' => 'vu_custom-menu-list'
		), $atts );

		if( empty($atts['menu']) ) {
			return '';
		}

		ob_start();

		wp_nav_menu(array(
			'menu'            => $atts['menu'],
			'container'       => $atts['container'],
			'container_id'    => $atts['container_id'],
			'container_class' => $atts['container_class'],
			'menu_id'         => $atts['menu_id'],
			'menu_class'      => trim($atts['menu_class'] .' list-unstyled')
		));

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	add_shortcode('vu_custom_menu', 'dentalpress_custom_menu_shortcode');

	/**
	 * Recent Posts Shortcode
	 *
	 * @param int $atts['numberposts'] The number of posts being displayed. Default: '2'
	 * @see https://codex.wordpress.org/Function_Reference/wp_get_recent_posts
	 */

	function dentalpress_recent_posts_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'number_of_posts' => 2,
			'show_author' => '1',
			'author_text' => esc_html__("Posted by", 'dentalpress-shortcodes'),
			'show_date' => '1',
			'date_format' => 'd M Y',
			'class' => '',
		), $atts );

		$recent_posts = new WP_Query('orderby=date&order=DESC&posts_per_page='. absint($atts['number_of_posts'])); 
		
		ob_start(); ?>

		<div class="vu_recent-posts clearfix<?php echo !empty($atts['class']) ? ' '. esc_attr($atts['class']) : ''; ?>">
			<?php if( $recent_posts->have_posts() ) :
				while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
					<article class="vu_rp-item" data-id="<?php the_ID(); ?>" itemscope="itemscope" itemtype="https://schema.org/BlogPosting">
						<?php if( has_post_thumbnail(get_the_ID()) ) : ?>
							<div class="vu_rp-img">
								<?php the_post_thumbnail('thumbnail', array('itemprop' => 'image')); ?>
							</div>
						<?php endif; ?>

						<h4 class="vu_rp-title entry-title" itemprop="name"><a href="<?php the_permalink(); ?>" itemprop="url" rel="bookmark" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h4>

						<?php if ( $atts['show_author'] == '1' ) : ?>
							<div class="vu_rp-author" itemprop="author"><?php echo esc_html($atts['author_text']) .' '. get_the_author(); ?></div>
						<?php endif; ?>

						<?php if ( $atts['show_date'] == '1' ) : ?>
							<div class="vu_rp-date"><time datetime="<?php the_time('c'); ?>" itemprop="datePublished"><?php echo get_the_date( $atts['date_format'] ); ?></time></div>
						<?php endif; ?>
					</article>
				<?php endwhile;
			endif;
			wp_reset_query(); ?>
		</div>

		<?php $output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_recent_posts', 'dentalpress_recent_posts_shortcode');

	/**
	 * MailChimp Newsletter Shortcode
	 *
	 * @param int $atts['submit_text'] The submit button text. Default: 'Subscribe'
	 * @param string $content The text to be displayed before subscribe form.
	 */

	function dentalpress_newsletter_shortcode( $atts, $content ) {
		$atts = shortcode_atts( array(
			'placeholder_text' => esc_html__('Email address', 'dentalpress-shortcodes')
		), $atts );

		ob_start(); ?>

		<div class="vu_newsletter">
			<?php echo !empty($content) ? '<div class="vu_n-content clearfix">'. wpautop( $content ) .'</div>' : ''; ?>

			<form class="vu_n-form vu_frm-ajax vu_clear-fields" role="form">
				<div class="hide">
					<input type="hidden" name="action" value="vu_newsletter">
					<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('vu_newsletter_nonce'); ?>">
				</div>

				<input type="email" name="email" class="form-control" placeholder="<?php echo esc_attr( $atts['placeholder_text'] ); ?>">
				<button type="submit" class="vu_n-button fa fa-paper-plane"></button>

				<div class="clear"></div>

				<div class="vu_msg" data-class="m-t-15 m-b-0"></div>
			</form>
		</div>


		<?php $output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_newsletter', 'dentalpress_newsletter_shortcode');

	/**
	 * MailChimp Subscribe for the newsletter
	 *
	 * @see https://github.com/drewm/mailchimp-api/
	 */

	function dentalpress_subscribe_form(){
		if(!empty($_POST['email']) and is_email($_POST['email']) and !empty($_POST['_wpnonce'])){
			$email = trim($_POST['email']);
			$_wpnonce = $_POST['_wpnonce'];

			if( !wp_verify_nonce($_wpnonce, 'vu_newsletter_nonce') ){
				echo json_encode(array('status' => 'error', 'title' => 'Error!', 'msg' => esc_html__('Validation errors occurred. Please confirm the fields and submit it again.', 'dentalpress-shortcodes') )); exit();
			}

			if( trim(dentalpress_get_option('mailchimp-api')) == '' ){
				echo json_encode(array('status' => 'error', 'title' => 'Error!', 'msg' => esc_html__('Missing MailChip API or MailChip List ID!', 'dentalpress-shortcodes') )); exit();
			}

			$MailChimp = new MailChimp( dentalpress_get_option('mailchimp-api') );
			
			$result = $MailChimp->call('lists/subscribe', array(
					'id' => dentalpress_get_option('mailchimp-list-id'),
					'email' => array('email' => $email),
					//'merge_vars' => array('FNAME'=>'', 'LNAME'=>''),
					'double_optin' => false,
					'update_existing' => true,
					'replace_interests' => false,
					'send_welcome' => false
				)
			);

			if( isset($result['status']) and $result['status'] == 'error' ){
				echo json_encode(array('status' => 'error', 'title' => 'Error!', 'msg' => $result['error'])); exit();
			} else {
				echo json_encode(array('status' => 'success', 'title' => 'Success!', 'msg' => esc_html__('You have been subscribed successfully.', 'dentalpress-shortcodes') )); exit();
			}
		} else {
			echo json_encode(array('status' => 'error', 'title' => 'Error!', 'msg' => esc_html__('Please enter a valid email address!', 'dentalpress-shortcodes') )); exit();
		}
	}

	add_action("wp_ajax_vu_newsletter", "dentalpress_subscribe_form");
	add_action("wp_ajax_nopriv_vu_newsletter", "dentalpress_subscribe_form");

	/**
	 * Social Network Shortcode
	 *
	 * @param string $atts['url'] The url of social network. Default: '#'
	 * @param string $atts['target'] The target of link. Default: '_self'
	 * @param string $atts['icon'] The icon of social network. Please get it from Font Awesome Icons. eg: 'fa fa-facebook'
	 */

	function dentalpress_social_network_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'url' => '#',
			'target' => '_self',
			'icon' => ''
		), $atts );

		return '<div class="vu_social-icon"><a href="'. esc_url( $atts['url'] ) .'" target="'. esc_attr( $atts['target'] ) .'"><i class="'. esc_attr( $atts['icon'] ) .'"></i></a></div>';
	}

	add_shortcode('vu_social_network', 'dentalpress_social_network_shortcode');

	/**
	 * Highlight Shortcode
	 *
	 * @param string $atts['bg_color']
	 * @param string $atts['text_color']
	 * @param string $atts['class']
	 */

	function dentalpress_highlight_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'bg_color' => '',
			'text_color' => '',
			'class' => ''
		), $atts );

		$style_attribute = '';

		if ( !empty($atts['bg_color']) and !empty($atts['text_color']) ) {
			$style_attribute .= ' style="';

			if ( !empty($atts['bg_color']) ) {
				$style_attribute .= 'background-color:'. esc_attr($atts['bg_color']) .';';
			}

			if ( !empty($atts['text_color']) ) {
				$style_attribute .= 'color:'. esc_attr($atts['text_color']) .';';
			}

			$style_attribute .= '"';
		}

		return '<span class="vu_highlight'. dentalpress_extra_class($atts['class']) .'"'. $style_attribute .'>'. $content .'</span>';
	}

	add_shortcode('vu_highlight', 'dentalpress_highlight_shortcode');

	/**
	 * Info Item Shortcode
	 *
	 * @param string $atts['icon']
	 * @param string $atts['title']
	 * @param string $atts['desc']
	 * @param string $atts['class']
	 */

	function dentalpress_info_item_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'icon' => '',
			'title' => '',
			'desc' => '',
			'class' => ''
		), $atts );

		ob_start(); ?>
		
		<div class="vu_info-item<?php dentalpress_extra_class($atts['class']); ?>">
			<div class="vu_ii-icon">
				<i class="<?php echo esc_attr( $atts['icon'] ); ?>"></i>
			</div>
			<div class="vu_ii-details">
				<span class="vu_ii-title"><?php echo esc_html( $atts['title'] ); ?></span>
				<p class="vu_ii-desc"><?php echo esc_html( $atts['desc'] ); ?></p>
			</div>
		</div>

		<?php $output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_info_item', 'dentalpress_info_item_shortcode');

	/**
	 * Flickr Shortcode
	 *
	 * @param string $atts['user'] The username of flickr account. eg: 38583880@N00
	 * @param string $atts['limit'] The number of images that will be shown. Default: '6'
	 */

	function dentalpress_flickr_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'user' => '',
			'limit' => 8
		), $atts );

		wp_enqueue_script( array('flickr-feed') );

		return '<div class="vu_flickr-photos vu_lightbox vu_l-gallery clearfix" data-user="'. esc_attr( $atts['user'] ) .'" data-limit="'. absint( $atts['limit'] ) .'"></div>';
	}

	add_shortcode('vu_flickr', 'dentalpress_flickr_shortcode');

	/**
	 * Latest Tweets Shortcode
	 *
	 * @param string $atts['user'] The username of twitter account.
	 * @param string $atts['count'] The number of tweets that will be shown. Default: '3'
	 * @param string $atts['loading_text'] The text that will be shown before loading tweets. Default: 'Loading tweets...'
	 */

	function dentalpress_latest_tweets_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'user' => '',
			'count' => 3,
			'loading_text' => 'Loading tweets'
		), $atts );

		$carousel_options = array(
			"singleItem" => false,
			"items" => 1,
			"navigation" => false,
			"navigationText" => array('<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'),
			"pagination" => true,
			"autoHeight" => true,
			"rewindNav" => true,
			"scrollPerPage" => true,
			"autoPlay" => false,
			"stopOnHover" => false
		);

		return '<div class="vu_latest-tweets clearfix" data-options="'. esc_attr(json_encode($carousel_options)) .'" data-user="'. esc_attr( $atts['user'] ) .'" data-count="'. absint( $atts['count'] ) .'" data-text="'. esc_attr( $atts['loading_text'] ) .'" data-action="vu_latest_tweets"></div>';
	}

	add_shortcode('vu_latest_tweets', 'dentalpress_latest_tweets_shortcode');

	/**
	 * Latest Tweets Shortcode
	 */

	function dentalpress_latest_tweets_ajax(){
		if( empty($_POST['request']) ) { exit(); }

		$consumer_key = esc_attr(dentalpress_get_option('twitter-consumer-key'));
		$consumer_secret = esc_attr(dentalpress_get_option('twitter-consumer-secret'));
		$user_token = esc_attr(dentalpress_get_option('twitter-user-token'));
		$user_secret = esc_attr(dentalpress_get_option('twitter-user-secret'));

		$ezTweet = new ezTweet($consumer_key, $consumer_secret, $user_token, $user_secret, $_POST['request']);
		$ezTweet->fetch();

		exit();
	}

	add_action("wp_ajax_vu_latest_tweets", "dentalpress_latest_tweets_ajax");
	add_action("wp_ajax_nopriv_vu_latest_tweets", "dentalpress_latest_tweets_ajax");

	/**
	 * Google Plus Badge Shortcode
	 *
	 * @param string $atts['page_id'] The page Id of google plus account. eg: '106192958286631454676'
	 * @param int $atts['width'] Width of the google plus badge. Default: '300'
	 */

	function dentalpress_google_plus_badge_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'page_id' => '',
			'width' => '300'
		), $atts );

		wp_enqueue_script( array('google-apis') );

		return '<div class="vu_google-plus-badge-container clearfix"><div class="g-page" data-width="'. esc_attr( $atts['width'] ) .'" data-href="https://plus.google.com/'. esc_attr( $atts['page_id'] ) .'" data-layout="landscape" data-rel="publisher"></div></div>';
	}

	add_shortcode('vu_google_plus_badge', 'dentalpress_google_plus_badge_shortcode');

	/**
	 * Facebook Like Box Shortcode
	 *
	 * @param string $atts['url'] The url of facebook account. eg: http://facebook.com/psdtuts
	 * @param int $atts['width'] Width of the box.
	 * @param int $atts['height'] Height of the box. Default: '300'
	 * @param int $atts['colorscheme'] Color Scheme of the box. eg: 'light' or 'dark'. Default: 'light'
	 * @param int $atts['show_face'] Show face of people who like your page. Default: 'true'
	 * @param int $atts['show_border'] Show border of the box. Default: 'true'
	 * @param int $atts['show_stream'] Show stream of the fun page. Default: 'false'
	 * @param int $atts['show_header'] Show header of the box. Default: 'false'
	 */

	function dentalpress_facebook_like_box_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'url' => '',
			'width' => '',
			'height' => '300',
			'colorscheme' => 'light',
			'show_face' => 'true',
			'show_border' => 'true',
			'show_stream' => 'false',
			'show_header' => 'false'
		), $atts );

		return '<div class="vu_fb-like-box-container clearfix" data-href="'. esc_url( $atts['url'] ) .'" data-width="'. esc_attr( $atts['width'] ) .'" data-height="'. esc_attr( $atts['height'] ) .'" data-colorscheme="'. esc_attr( $atts['colorscheme'] ) .'" data-show-faces="'. esc_attr( $atts['show_face'] ) .'" data-show-border="'. esc_attr( $atts['show_border'] ) .'" data-stream="'. esc_attr( $atts['show_stream'] ) .'" data-header="'. esc_attr( $atts['show_header'] ) .'"></div>';
	}

	add_shortcode('vu_facebook_like_box', 'dentalpress_facebook_like_box_shortcode');

	/**
	 * Gallery Widget Shortcode
	 */

	function dentalpress_gallery_widget_shortcode($atts, $content = null){
		$atts = shortcode_atts( array(
			"images" => '',
			"lightbox" => '1',
			"class" => ''
		), $atts );

		$images = @explode(',', $atts['images']);

		ob_start(); ?>

		<div class="vu_gallery-widget<?php echo ($atts['lightbox'] == '1') ? ' vu_lightbox vu_l-gallery' : ''; ?><?php dentalpress_extra_class($atts['class']); ?>"<?php echo ($atts['lightbox'] == '1') ? ' data-delegate="a.vu_gw-image"' : ''; ?>>
			<?php if ( is_array($images) and !empty($images) ) : ?>
				<?php foreach ($images as $image) { ?>
					<div class="vu_gw-item">
						<?php if ( $atts['lightbox'] == '1' ) : ?>
							<a href="<?php echo dentalpress_get_attachment_image_src( absint($image), 'full' ); ?>" class="vu_gw-image">
						<?php else : ?>
							<span class="vu_gw-image">
						<?php endif; ?>

						<?php echo wp_get_attachment_image( absint($image), 'thumbnail' ); ?>

						<?php if ( $atts['lightbox'] == '1' ) : ?>
							</a>
						<?php else : ?>
							</span>
						<?php endif; ?>
					</div>
				<?php } ?>
			<?php endif; ?>
		</div>

		<?php $output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_gallery_widget', 'dentalpress_gallery_widget_shortcode');



	/**
	 * Font Awesome Icons Shortcode
	 *
	 * @link https://wordpress.org/plugins/font-awesome-shortcodes/
	 */

	function dentalpress_font_awesome_shortcode($atts, $content = null){
		$atts = shortcode_atts( array(
			"type" => '',
			"size" => false,
			"pull" => false,
			"border" => false,
			"spin" => false,
			"list_item" => false,
			"fixed_width" => false,
			"rotate" => false,
			"flip" => false,
			"stack_size" => false,
			"inverse" => false,
			"xclass" => false
		), $atts );

		$class  = 'fa';
		$class .= ( $atts['type'] )         ? ' fa-' . $atts['type'] : '';
		$class .= ( $atts['size'] )         ? ' fa-' . $atts['size'] : '';
		$class .= ( $atts['pull'] )         ? ' pull-' . $atts['pull'] : '';
		$class .= ( $atts['border'] )       ? ' fa-border' : '';
		$class .= ( $atts['spin'] )         ? ' fa-spin' : '';
		$class .= ( $atts['list_item'] )    ? ' fa-li' : '';
		$class .= ( $atts['fixed_width'] )  ? ' fa-fw' : '';
		$class .= ( $atts['rotate'] )       ? ' fa-rotate-' . $atts['rotate'] : '';
		$class .= ( $atts['flip'] )         ? ' fa-flip-' . $atts['flip'] : '';
		$class .= ( $atts['stack_size'] )   ? ' fa-stack-' . $atts['stack_size'] : '';
		$class .= ( $atts['inverse'] )      ? ' fa-inverse' : '';
		$class .= ( $atts['xclass'] )   	? ' ' . $atts['xclass'] : '';
		  
		return sprintf( '<i class="%s"></i>', esc_attr( $class ) );
	}

	add_shortcode('vu_fa', 'dentalpress_font_awesome_shortcode');
?>