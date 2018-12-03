<?php
	/**
	 * Blog Shortcode
	 *
	 * @param string $atts['query']
	 * @param string $atts['type']
	 * @param string $atts['layout']
	 * @param string $atts['ratio']
	 * @param string $atts['show_date']
	 * @param string $atts['show_author']
	 * @param string $atts['show_categories']
	 * @param string $atts['show_comments']
	 * @param string $atts['show_content']
	 * @param string $atts['num_of_words']
	 * @param string $atts['read_more_text']
	 * @param string $atts['show_navigation']
	 * @param string $atts['show_pagination']
	 * @param string $atts['autoplay']
	 * @param string $atts['stop_on_hover']
	 * @param string $atts['class'] Add a class name and then refer to it in your css file.
	 */

	function dentalpress_blog_shortcode($atts, $content = null) {
		$atts = shortcode_atts(array(
			"query" => "",
			"type" => "",
			"layout" => "",
			"ratio" => "",
			"show_date" => "",
			"show_author" => "",
			"show_categories" => "",
			"show_comments" => "",
			"show_content" => "",
			"num_of_words" => "",
			"read_more_text" => "",
			"show_navigation" => "",
			"show_pagination" => "",
			"autoplay" => "",
			"stop_on_hover" => "",
			"class" => ""
		), $atts);

		if( stripos($atts['query'], 'post_type:post') === false ){
			$atts['query'] .= '|post_type:post';
		}

		if( function_exists('vc_build_loop_query') ) {
			list($args, $blog) = vc_build_loop_query( esc_attr($atts['query']) );
		} else {
			$VcLoopQueryBuilder = new VcLoopQueryBuilder( esc_attr($atts['query']) );
			$blog = $VcLoopQueryBuilder->build();
		}

		ob_start();
	?>
		<div class="vu_blog vu_b-type-<?php echo esc_attr($atts['type']); ?> vu_b-layout-<?php echo esc_attr($atts['layout']); ?> clearfix<?php dentalpress_extra_class($atts['class']); ?>">
			<?php if( $atts['type'] == 'carousel' ) : 
				$carousel_options = array(
					"singleItem" => false,
					"items" => absint($atts['layout']),
					"itemsDesktop" => array(1199, absint($atts['layout'])),
					"itemsDesktopSmall" => array(980, 2),
					"itemsTablet" => array(768, 2),
					"itemsMobile" => array(479, 1),
					"navigation" => ($atts['show_navigation'] == '1') ? true : false,
					"navigationText" => array('<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'),
					"pagination" => ($atts['show_pagination'] == '1') ? true : false,
					"autoHeight" => true,
					"rewindNav" => true,
					"scrollPerPage" => true,
					"autoPlay" => ($atts['autoplay'] == '' || $atts['autoplay'] == '0') ? false : absint($atts['autoplay']),
					"stopOnHover" => ($atts['stop_on_hover'] == '1') ? true : false
				);
			?>
				<div class="vu_b-carousel vu_carousel" data-options="<?php echo esc_attr(json_encode($carousel_options)); ?>">
			<?php else : ?>
				<div class="row">
			<?php endif; ?>

				<?php if($blog->have_posts()) : while($blog->have_posts()): $blog->the_post(); ?>
					<?php if( $atts['type'] != 'carousel' ) : ?>
						<div class="vu_b-item-wrap col-md-<?php echo (12 / absint($atts['layout'])); ?> col-sm-6 col-xs-12">
					<?php endif; ?>

						<article <?php post_class('vu_b-item vu_blog-post'); ?> data-id="<?php the_ID(); ?>" itemscope="itemscope" itemtype="https://schema.org/BlogPosting">
							<?php if( has_post_thumbnail() ) : ?>
								<div class="vu_bp-image">
									<?php the_post_thumbnail('dentalpress_ratio-'. esc_attr($atts['ratio']), array('itemprop' => 'image')); ?>

									<?php if( $atts['show_categories'] == '1' ) : ?>
										<span class="vu_bp-categories">
											<?php the_category(' '); ?>
										</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<div class="vu_bp-content-wrapper">
								<header class="vu_bp-header">
									<?php if( $atts['show_date'] == '1' || $atts['show_author'] == '1' || $atts['show_comments'] == '1' ) : ?>
										<div class="vu_bp-meta">
											<?php if( $atts['show_date'] == '1' ) : ?>
												<span class="vu_bp-m-item vu_bp-date">
													<time datetime="<?php echo esc_attr( get_the_time('c') ); ?>" itemprop="datePublished"><?php echo get_the_date('M d Y'); ?></time>
												</span>
											<?php endif; ?>

											<?php if( $atts['show_author'] == '1' ) : ?>
												<span class="vu_bp-m-item vu_bp-author">
													<?php echo esc_html__('by', 'dentalpress-shortcodes'); ?> 
													<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php esc_attr_e('Posts by', 'dentalpress-shortcodes'); ?> <?php the_author(); ?>" rel="author"><span itemprop="author"><?php the_author(); ?></span></a>
												</span>
											<?php endif; ?>

											<?php if( $atts['show_comments'] == '1' ) : ?>
												<span class="vu_bp-m-item vu_bp-comments">
													<a href="<?php comments_link(); ?>"><?php comments_number( esc_html__('No Comments', 'dentalpress-shortcodes'), esc_html__('One Comment ', 'dentalpress-shortcodes'), esc_html__('% Comments', 'dentalpress-shortcodes') ); ?></a>
												</span>
											<?php endif; ?>

											<div class="clear"></div>
										</div>
									<?php endif; ?>

									<div class="clear"></div>

									<h3 class="vu_bp-title entry-title" itemprop="name">
										<a href="<?php the_permalink(); ?>" itemprop="url" rel="bookmark" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a>
									</h3>
								</header>

								<?php if( $atts['show_content'] == '1' ) : ?>
									<div class="vu_bp-content">
										<div class="vu_bp-content-excerpt" itemprop="description">
											<?php dentalpress_the_excerpt( absint($atts['num_of_words']) ); ?>
										</div>

										<div class="clear"></div>

										<a href="<?php the_permalink(); ?>" class="vu_bp-read-more">
											<span class="vu_bp-btn">
												<i class="vu_bp-btn-icon-left vu_fi vu_fi-arrow-right"></i>
												<span class="vu_bp-btn-text"><?php echo esc_html($atts['read_more_text']); ?></span>
												<i class="vu_bp-btn-icon-right vu_fi vu_fi-arrow-right"></i>
											</span>
										</a>
									</div>
								<?php endif; ?>
							</div>
						</article>
					<?php if( $atts['type'] != 'carousel' ) : ?>
						</div>
					<?php endif; ?>
				<?php endwhile; endif; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}

	add_shortcode('vu_blog', 'dentalpress_blog_shortcode');

	/**
	 * Blog VC Shortcode
	 */

	if( class_exists('WPBakeryShortCode') ){
		class WPBakeryShortCode_vu_blog extends WPBakeryShortCode {
			public function content($atts, $content = null) {
				$atts = vc_map_get_attributes("vu_blog", $atts);

				return do_shortcode( dentalpress_generate_shortcode('vu_blog', $atts, $content) );
			}
		}

		vc_map(
			array(
				"name"		=> esc_html__("Blog", 'dentalpress-shortcodes'),
				"description" => esc_html__("Show blog posts", 'dentalpress-shortcodes'),
				"base"		=> "vu_blog",
				"class"		=> "vc_vu_blog",
				"icon"		=> "vu_element-icon vu_blog-icon",
				"controls"	=> "full",
				"category" => esc_html__('DentalPress', 'dentalpress-shortcodes'),
				"params"	=> array(
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "loop",
						"heading" => esc_html__("Blog Query", 'dentalpress-shortcodes'),
						"param_name" => "query",
						'settings' => array(
							'size'          => array('hidden' => false, 'value' => '6'),
							'order_by'      => array('value' => 'date'),
							'categories'    => array('hidden' => false),
							'tags'          => array('hidden' => false),
							'tax_query'     => array('hidden' => true),
							'authors'     	=> array('hidden' => true),
							'post_type'     => array('hidden' => true, 'value' => 'post')
						),
						'value' => 'size:6|order_by:date|post_type:post',
						"save_always" => true,
						"description" => esc_html__("Create WordPress loop, to show posts from your site.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "dropdown",
						"heading" => esc_html__("Type", 'dentalpress-shortcodes'),
						"param_name" => "type",
						"admin_label" => true,
						"value" =>  array(
							esc_html__("Standard", 'dentalpress-shortcodes') => "standard",
							esc_html__("Carousel", 'dentalpress-shortcodes') => "carousel"
						),
						"save_always" => true,
						"description" => esc_html__("Select blog type.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "dropdown",
						"heading" => esc_html__("Layout", 'dentalpress-shortcodes'),
						"param_name" => "layout",
						"admin_label" => true,
						"value" => array(
							esc_html__("1 Column", 'dentalpress-shortcodes') => '1',
							esc_html__("2 Columns", 'dentalpress-shortcodes') => '2',
							esc_html__("3 Columns", 'dentalpress-shortcodes') => '3',
							esc_html__("4 Columns", 'dentalpress-shortcodes') => '4'
						),
						"std" => '3',
						"save_always" => true,
						"description" => esc_html__("Select blog layout.", 'dentalpress-shortcodes'),
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "dropdown",
						"heading" => esc_html__("Ratio", 'dentalpress-shortcodes'),
						"param_name" => "ratio",
						"value" => dentalpress_get_image_ratios(),
						"std" => '2:1',
						"save_always" => true,
						"description" => esc_html__("Select ratio of images.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show date", 'dentalpress-shortcodes'),
						"param_name" => "show_date",
						"value" =>  array( "Yes, Please" => "1"),
						"std" => "1",
						"save_always" => true,
						"description" => esc_html__("Check to show post date.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show author", 'dentalpress-shortcodes'),
						"param_name" => "show_author",
						"value" =>  array( "Yes, Please" => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to show post author.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show categories", 'dentalpress-shortcodes'),
						"param_name" => "show_categories",
						"value" =>  array( "Yes, Please" => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to show post categories.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show comments", 'dentalpress-shortcodes'),
						"param_name" => "show_comments",
						"value" =>  array( "Yes, Please" => "1"),
						"std" => "0",
						"save_always" => true,
						"description" => esc_html__("Check to show post comments.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show content", 'dentalpress-shortcodes'),
						"param_name" => "show_content",
						"value" =>  array( "Yes, Please" => "1"),
						"std" => "1",
						"save_always" => true,
						"description" => esc_html__("Check to show post content.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Number of words", 'dentalpress-shortcodes'),
						"param_name" => "num_of_words",
						"dependency" => array("element" => "show_content", "value" => "1"),
						"value" => "20",
						"save_always" => true,
						"description" => esc_html__("Enter in number of words to show in content.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('General', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Read more text", 'dentalpress-shortcodes'),
						"param_name" => "read_more_text",
						"dependency" => array("element" => "show_content", "value" => "1"),
						"value" => esc_html__("Read More", 'dentalpress-shortcodes'),
						"save_always" => true,
						"description" => esc_html__("Enter read more text.", 'dentalpress-shortcodes')
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
						"group" => esc_html__('Carousel Options', 'dentalpress-shortcodes'),
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
						"group" => esc_html__('Carousel Options', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Show pagination", 'dentalpress-shortcodes'),
						"param_name" => "show_pagination",
						"dependency" => array("element" => "type", "value" => "carousel"),
						"value" =>  array( 'Yes Please' => "1"),
						"std" => "1",
						"save_always" => true,
						"description" => esc_html__("Check to show carousel pagination.", 'dentalpress-shortcodes')
					),
					array(
						"group" => esc_html__('Carousel Options', 'dentalpress-shortcodes'),
						"type" => "textfield",
						"heading" => esc_html__("Auto play", 'dentalpress-shortcodes'),
						"param_name" => "autoplay",
						"dependency" => array("element" => "type", "value" => "carousel"),
						"value" => "",
						"save_always" => true,
						"description" => wp_kses( __("Change to any integrer for example <b>5000</b> to play every <b>5</b> seconds. Leave blank to disable autoplay.", 'dentalpress-shortcodes'), array('b' => array()) )
					),
					array(
						"group" => esc_html__('Carousel Options', 'dentalpress-shortcodes'),
						"type" => "checkbox",
						"heading" => esc_html__("Stop autoplay on mouse hover", 'dentalpress-shortcodes'),
						"param_name" => "stop_on_hover",
						"dependency" => array("element" => "autoplay", "not_empty" => true),
						"value" =>  array( esc_html__("Yes, Please", 'dentalpress-shortcodes') => '1'),
						"save_always" => true,
						"description" => esc_html__("Check to stop carousel on hover.", 'dentalpress-shortcodes')
					)
				)
			)
		);
	}
?>