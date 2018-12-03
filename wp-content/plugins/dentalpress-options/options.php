<?php
	/**
	 * DentalPress Theme Options
	 */

	if ( ! class_exists( 'Redux_Framework_DentalPress_Options' ) ) {
		class Redux_Framework_DentalPress_Options {
			public $args = array();
			public $sections = array();
			public $theme;
			public $ReduxFramework;

			public function __construct() {
				if ( ! class_exists( 'ReduxFramework' ) ) {
					return;
				}

				// This is needed. Bah WordPress bugs.  ;)
				if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
					$this->initSettings();
				} else {
					add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
				}
			}

			public function initSettings() {
				// Just for demo purposes. Not needed per say.
				$this->theme = wp_get_theme();

				// Set the default arguments
				$this->setArguments();

				// Create the sections and fields
				$this->setSections();

				if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
					return;
				}

				$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
			}

			public function setSections() {
				ob_start();

				$this->theme = wp_get_theme();

				?>

				<div>
					<p class="item-uri">
						<strong><?php echo esc_html__( 'Theme URL', 'dentalpress-options' ); ?>: </strong>
						<a href="<?php echo esc_url( $this->theme->get( 'ThemeURI' ) ); ?>" target="_blank"><?php echo $this->theme->get( 'Name' ); ?></a>
					</p>

					<p class="item-author">
						<strong><?php echo esc_html__( 'Author', 'dentalpress-options' ); ?>: </strong>
						<a href="<?php echo esc_url( $this->theme->get( 'AuthorURI' ) ); ?>" target="_blank"><?php echo $this->theme->get( 'Author' ); ?></a>
					</p>

					<p class="item-version">
						<strong><?php echo esc_html__( 'Version', 'dentalpress-options' ); ?>: <?php echo $this->theme->get( 'Version' ); ?></strong>
					</p>

					<p class="item-tags">
						<strong><?php echo esc_html__( 'Tags', 'dentalpress-options' ); ?>: </strong>
						<?php echo $this->theme->display( 'Tags' ); ?>
					</p>

					<div style="margin-top: 30px;">
						<h3><?php echo esc_html__( 'Documentation', 'dentalpress-options' ); ?></h3>
					</div>
					
					<div class="redux-section-desc">
						<p>Please refer to the documentation found in the main theme files for more instructions on how to use the theme.</p><br>
					</div>

					<div style="margin-top: 30px;">
						<h3><?php echo esc_html__( 'Support', 'dentalpress-options' ); ?></h3>
					</div>
					
					<div class="redux-section-desc">
						<p>If you have any questions that are beyond the scope of this documentation, don't hesitate to <a href="https://themeforest.net/user/flexipress#contact" target="_blank">contact us</a>.</p><br>
					</div>

					<div style="margin-top: 30px;">
						<h3><?php echo esc_html__( 'Thank you!', 'dentalpress-options' ); ?></h3>
					</div>
					
					<div class="redux-section-desc">
						<p>Last but not least, thank you very much for choosing DentalPress! We've done our best to make it fast, flexible and powerful, while keeping it incredibly easy and slick to use. If you like this theme, please support us by <a href="https://www.dropbox.com/s/6f489t05xt6g1d3/rating_guide.png" target="_blank">leaving a 5 star rating</a> on Themeforest.</p><br>
					</div>
				</div>

				<?php
				$theme_info = ob_get_contents();

				ob_end_clean();

				//General
				$this->sections[] = array(
					'title'  => esc_html__( 'General', 'dentalpress-options' ),
					'icon'   => 'fa fa-cogs',
					'fields' => array(
						array(
							'id'       => 'logo',
							'type'     => 'media',
							'title'    => esc_html__( 'Logo', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Upload a custom logo for your site.', 'dentalpress-options' ),
							'default'  => array(
								'url' => get_template_directory_uri() .'/assets/img/dentalpress-logo.png',
								'width' => '675',
								'height' => '240'
							)
						),
						array(
							'id'       => 'logo-width',
							'type'     => 'slider',
							'title'    => esc_html__( 'Logo Container Width', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter logo container width in px.', 'dentalpress-options' ),
							'min'      => 50,
							'max'      => 500,
							'step'      => 1,
							'default'  => 150
						),
						array(
							'id'       => 'smooth-scroll',
							'type'     => 'switch',
							'title'    => esc_html__( 'Smooth Scrolling', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Turn on to emulate smoth scroll effect on your site. *This won\'t work on old IEs.', 'dentalpress-options' ),
							'on'       => esc_html__( 'On', 'dentalpress-options' ),
							'off'      => esc_html__( 'Off', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'preloader',
							'type'     => 'switch',
							'title'    => esc_html__( 'Preloader', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Turn on to show preloader while site is loading.', 'dentalpress-options' ),
							'on'       => esc_html__( 'On', 'dentalpress-options' ),
							'off'      => esc_html__( 'Off', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'preloader-image',
							'type'     => 'media',
							'required' => array( 'preloader', '=', true ),
							'preview'  => true,
							'title'    => esc_html__( 'Preloader image', 'dentalpress-options' ),
							'default'  => array(
								'url' => get_template_directory_uri() .'/assets/img/preloader.svg'
							)
						),
						array(
							'id'       => 'site-mode',
							'type'     => 'button_set',
							'title'    => esc_html__( 'Site Mode', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select site mode. Note: When site is \'Under Construction\', only logged in users will be able to see the site\'s content.', 'dentalpress-options' ),
							'options'  => array(
								'normal' => esc_html__( 'Normal', 'dentalpress-options'),
								'under_construction' => esc_html__( 'Under Construction', 'dentalpress-options')
							),
							'default'  => 'normal'
						),
						array(
							'id'       => 'site-mode-page',
							'type'     => 'select',
							'required' => array( 'site-mode', '=', 'under_construction' ),
							'data'     => 'pages',
							'title'    => esc_html__( 'Maintenance or Coming Soon Page', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select maintenance or coming soon page.', 'dentalpress-options' ),
							'default'  => ''
						)
					)
				);
				
				//Styling
				$this->sections[] = array(
					'title'  => esc_html__( 'Styling', 'dentalpress-options' ),
					'icon'   => 'fa fa-paint-brush',
					'fields' => array(
						array(
							'id'       => 'primary-color',
							'type'     => 'color',
							'title'    => esc_html__( 'Primary Color', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select primary color of your site.', 'dentalpress-options' ),
							'transparent' => false,
							'validate' => 'color',
							'default'  => '#50b0e3',
						),
						array(
							'id'       => 'secondary-color',
							'type'     => 'color',
							'title'    => esc_html__( 'Secondary Color', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select secondary color of your site.', 'dentalpress-options' ),
							'transparent' => false,
							'validate' => 'color',
							'default'  => '#a4d735',
						),
						array(
							'id'       => 'body-background',
							'type'     => 'background',
							'title'    => esc_html__( 'Background', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Upload a large and beautiful background image for your site. This will override the background color and background pattern.', 'dentalpress-options' ),
							'output'   => array('body'),
							'default'  => array(
								'background-color' => '#f9f9f9',
								'background-image' => get_template_directory_uri() .'/assets/img/pattern.png'
							)
						)
					)
				);
				
				//Typography
				$this->sections[] = array(
					'title'  => esc_html__( 'Typography', 'dentalpress-options' ),
					'icon'   => 'fa fa-font',
					'fields' => array(
						array(
							'id'          => 'body-typography',
							'type'        => 'typography', 
							'title'       => esc_html__( 'Body', 'dentalpress-options' ),
							'google'      => true,
							'text-align'  => false,
							'text-transform' => true,
							'all_styles'  => true,
							'units'       => 'px',
							'output'      => array('body'),
							'default'     => array(
								'font-family' => 'Open Sans',
								'font-style' => '400',
								'font-size' => '14px',
								'line-height' => '24px',
								'text-transform' => 'none',
								'color' => '#777777',
								'subsets' => 'latin'
							)
						),
						array(
							'id'          => 'nav-typography',
							'type'        => 'typography', 
							'title'       => esc_html__( 'Navigation', 'dentalpress-options' ),
							'google'      => true,
							'text-align'  => false,
							'text-transform' => true,
							'units'       => 'px',
							'output'      => array('.vu_main-navigation > ul > li > a', '.widget_nav_menu .menu > li > a'),
							'default'     => array(
								'font-family' => 'Poppins',
								'font-style' => '600',
								'font-size' => '14px',
								'line-height' => '24px',
								'text-transform' => 'uppercase',
								'color' => '#777777',
								'subsets' => 'latin'
							)
						),
						array(
							'id'          => 'nav-submenu-typography',
							'type'        => 'typography', 
							'title'       => esc_html__( 'Navigation Submenu', 'dentalpress-options' ),
							'google'      => true,
							'text-align'  => false,
							'text-transform' => true,
							'units'       => 'px',
							'output'      => array('.vu_main-navigation .sub-menu a'),
							'default'     => array(
								'font-family' => 'Open Sans',
								'font-style' => '400',
								'font-size' => '14px',
								'line-height' => '20px',
								'text-transform' => 'none',
								'color' => '#777777',
								'subsets' => 'latin'
							)
						),
						array(
							'id'          => 'h1-typography',
							'type'        => 'typography', 
							'title'       => esc_html__( 'H1', 'dentalpress-options' ),
							'google'      => true,
							'text-align'  => false,
							'text-transform' => true,
							'units'       => 'px',
							'output'      => array('h1', '.h1'),
							'default'     => array(
								'font-family' => 'Poppins',
								'font-style' => '500',
								'font-size' => '24px',
								'line-height' => '34px',
								'text-transform' => 'none',
								'color' => '#414141',
								'subsets' => 'latin'
							)
						),
						array(
							'id'          => 'h2-typography',
							'type'        => 'typography', 
							'title'       => esc_html__( 'H2', 'dentalpress-options' ),
							'google'      => true,
							'text-align'  => false,
							'text-transform' => true,
							'units'       => 'px',
							'output'      => array('h2', '.h2'),
							'default'     => array(
								'font-family' => 'Poppins',
								'font-style' => '500',
								'font-size' => '20px',
								'line-height' => '30px',
								'text-transform' => 'none',
								'color' => '#414141',
								'subsets' => 'latin'
							)
						),
						array(
							'id'          => 'h3-typography',
							'type'        => 'typography', 
							'title'       => esc_html__( 'H3', 'dentalpress-options' ),
							'google'      => true,
							'text-align'  => false,
							'text-transform' => true,
							'units'       => 'px',
							'output'      => array('h3', '.h3'),
							'default'     => array(
								'font-family' => 'Poppins',
								'font-style' => '500',
								'font-size' => '18px',
								'line-height' => '28px',
								'text-transform' => 'none',
								'color' => '#414141',
								'subsets' => 'latin'
							)
						),
						array(
							'id'          => 'h4-typography',
							'type'        => 'typography', 
							'title'       => esc_html__( 'H4', 'dentalpress-options' ),
							'google'      => true,
							'text-align'  => false,
							'text-transform' => true,
							'units'       => 'px',
							'output'      => array('h4', '.h4'),
							'default'     => array(
								'font-family' => 'Poppins',
								'font-style' => '500',
								'font-size' => '16px',
								'line-height' => '26px',
								'text-transform' => 'none',
								'color' => '#414141',
								'subsets' => 'latin'
							)
						),
						array(
							'id'          => 'h5-typography',
							'type'        => 'typography', 
							'title'       => esc_html__( 'H5', 'dentalpress-options' ),
							'google'      => true,
							'text-align'  => false,
							'text-transform' => true,
							'units'       => 'px',
							'output'      => array('h5'),
							'default'     => array(
								'font-family' => 'Poppins',
								'font-style' => '500',
								'font-size' => '14px',
								'line-height' => '24px',
								'text-transform' => 'none',
								'color' => '#414141',
								'subsets' => 'latin'
							)
						),
						array(
							'id'          => 'h6-typography',
							'type'        => 'typography', 
							'title'       => esc_html__( 'H6', 'dentalpress-options' ),
							'google'      => true,
							'text-align'  => false,
							'text-transform' => true,
							'units'       => 'px',
							'output'      => array('h6'),
							'default'     => array(
								'font-family' => 'Poppins',
								'font-style' => '400',
								'font-size' => '12px',
								'line-height' => '22px',
								'text-transform' => 'none',
								'color' => '#414141',
								'subsets' => 'latin'
							)
						),
						array(
							'id'          => 'others-typography',
							'type'        => 'typography', 
							'title'       => esc_html__( 'Others', 'dentalpress-options' ),
							'google'      => true,
							'font-style' => false,
							'font-weight' => false,
							'font-size' => false,
							'text-align' => false,
							'line-height' => false,
							'color' => false,
							'units'       => 'px',
							'output'      => array('.vu_info-item .vu_ii-title', '.datepicker.dropdown-menu th.datepicker-switch', '.datepicker.dropdown-menu th.dow', '.vu_accordion .vu_a-wrapper .vu_a-header a', '.vu_tabs .vu_t-nav li a', '.vu_tour .vu_t-wrapper .vu_t-nav a', '.vu_countdown .countdown-amount', '.vu_heading.vu_h-style-1 .vu_h-subheading p', '.btn', '.vu_filterable .vu_f-filters.vu_f-filters-style-1 .vu_f-filter', '.vu_filterable .vu_f-filters.vu_f-filters-style-2 .vu_f-filter', '.vu_gallery .vu_g-filters.vu_g-filters-style-1 .vu_g-filter', '.vu_gallery .vu_g-filters.vu_g-filters-style-2 .vu_g-filter', '.vu_gallery-item .vu_gi-details .vu_gi-content .vu_gi-title', '.vu_posts-page .vu_blog-post.vu_bp-type-quote .vu_bp-quote > blockquote cite', '.vu_posts-page .vu_blog-post.vu_bp-type-quote .vu_bp-quote .vu_bp-q-author'),
							'default'     => array(
								'font-family' => 'Poppins',
								'font-style' => '400',
								'subsets' => 'latin'
							)
						)
					)
				);

				//Top Bar
				$this->sections[] = array(
					'title'  => esc_html__( 'Top Bar', 'dentalpress-options' ),
					'icon'   => 'fa fa-toggle-up',
					'fields' => array(
						array(
							'id'       => 'top-bar-show',
							'type'     => 'switch',
							'title'    => esc_html__( 'Show Top Bar', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => true,
						),
						array(
							'id'       => 'top-bar-text-color',
							'type'     => 'color',
							'required' => array( 'top-bar-show', '=', true ),
							'title'    => esc_html__( 'Text Color', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select top bar text color.', 'dentalpress-options' ),
							'transparent' => false,
							'output'   => '.vu_top-bar',
							'default'  => '#777777'
						),
						array(
							'id'       => 'top-bar-left-content',
							'type'     => 'textarea',
							'required' => array( 'top-bar-show', '=', true ),
							'title'    => esc_html__( 'Left Content', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter top bar left side content. You can write HTML code as well.', 'dentalpress-options' ),
							'default'  => '<span>Let us take care of you and your smile!</span>',
						),
						array(
							'id'       => 'top-bar-right-content',
							'type'     => 'textarea',
							'required' => array( 'top-bar-show', '=', true ),
							'title'    => esc_html__( 'Right Content', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter top bar right side content. You can write HTML code as well.', 'dentalpress-options' ),
							'default'  => '<div class="vu_social-icon"><a href="#" target="_self"><i class="fa fa-facebook"></i></a></div><div class="vu_social-icon"><a href="#" target="_self"><i class="fa fa-twitter"></i></a></div><div class="vu_social-icon"><a href="#" target="_self"><i class="fa fa-instagram"></i></a></div>',
						)
					)
				);

				//Header
				$this->sections[] = array(
					'title'  => esc_html__( 'Header', 'dentalpress-options' ),
					'icon'   => 'fa fa-toggle-up',
					'fields' => array(
						array(
							'id'       => 'header-padding',
							'type'     => 'spacing',
							'title'    => esc_html__( 'Padding', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter header top and bottom padding.', 'dentalpress-options' ),
							'left'      => false,
							'right'      => false,
							'output'   => array('.vu_main-header .vu_h-content'),
							'units'    => array('px'),
							'default'  => array(
								'padding-top'     => '10px', 
								'padding-right'   => '0', 
								'padding-bottom'  => '10px', 
								'padding-left'    => '0',
								'units'          => 'px', 
							)
						),
						array(
							'id'       => 'header-widgets',
							'type'     => 'textarea',
							'title'    => esc_html__( 'Widgets', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Insert widgets content each separeted in a div.', 'dentalpress-options' ),
							'default'  => '<div class="vu_h-right vu_h-widgets"><div class="vu_info-item"><div class="vu_ii-icon"><i class="vu_fi vu_fi-envelope"></i></div><div class="vu_ii-details"><span class="vu_ii-title">Visit our Location</span><p class="vu_ii-desc">250 Main Street, New York</p></div></div><div class="vu_info-item"><div class="vu_ii-icon"><i class="vu_fi vu_fi-phone"></i></div><div class="vu_ii-details"><span class="vu_ii-title">Give us a Call</span><p class="vu_ii-desc">+1 123 456 789</p></div></div><div class="vu_info-item"><div class="vu_ii-icon"><i class="vu_fi vu_fi-clock-1"></i></div><div class="vu_ii-details"><span class="vu_ii-title">Opening Hours</span><p class="vu_ii-desc">Mon - Sat: 7:00 - 17:00</p></div></div></div>',
						),
						array(
							'id'       => 'navigation-position',
							'type'     => 'select',
							'title'    => esc_html__( 'Navigation Position', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select navigation position.', 'dentalpress-options' ),
							'select2'  => array('allowClear' => false),
							'options'  => array(
								'header' => esc_html__( 'Header', 'dentalpress-options'),
								'sidebar' => esc_html__( 'Sidebar', 'dentalpress-options')
							),
							'default'  => 'sidebar'
						),
						array(
							'id'       => 'navigation-submenu-width',
							'type'     => 'text',
							'title'    => esc_html__( 'Navigation Submenu width', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter navigation submenu width in px.', 'dentalpress-options' ),
							'validate' => 'numeric',
							'default' => 200
						)
					)
				);

				//Page Header
				$this->sections[] = array(
					'title'  => esc_html__( 'Page Header', 'dentalpress-options' ),
					'icon'   => 'fa fa-toggle-up',
					'fields' => array(
						array(
							'id'       => 'page-header-show',
							'type'     => 'switch',
							'title'    => esc_html__( 'Show Page Header?', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Turn on to show page header area on all pages.', 'dentalpress-options' ),
							'on'       => esc_html__( 'On', 'dentalpress-options' ),
							'off'      => esc_html__( 'Off', 'dentalpress-options' ),
							'default'  => true,
						),
						array(
							'id'       => 'page-header-bg-image',
							'type'     => 'media',
							'required' => array( 'page-header-show', '=', true ),
							'title'    => esc_html__( 'Background Image', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Upload a custom page header background image.', 'dentalpress-options' ),
							'default'  => array(
								'url' => ''
							)
						),
						array(
							'id'       => 'page-header-parallax',
							'type'     => 'switch',
							'required' => array( 'page-header-show', '=', true ),
							'title'    => esc_html__( 'Parallax Effect?', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enable parallax effect on page header background image.', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => true,
						)
					)
				);
				
				//Blog
				$this->sections[] = array(
					'title'  => esc_html__( 'Blog', 'dentalpress-options' ),
					'desc'   => esc_html__( 'All blog related options are listed here.', 'dentalpress-options' ),
					'icon'   => 'fa fa-edit',
					'fields' => array(
						array(
							'id'       => 'blog-social',
							'type'     => 'switch',
							'title'    => esc_html__( 'Social Media Sharing Buttons', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Turn on to enable social sharing buttons on blog posts.', 'dentalpress-options' ),
							'on'       => esc_html__( 'On', 'dentalpress-options' ),
							'off'      => esc_html__( 'Off', 'dentalpress-options' ),
							'default'  => true
						),
						array(
							'id'       => 'blog-social-networks',
							'type'     => 'checkbox',
							'required' => array( 'blog-social', '=', true ),
							'title'    => esc_html__( 'Social Networks', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select social networks to be shown in single posts.', 'dentalpress-options' ),
							'options'  => array(
								'facebook' => 'Facebook',
								'twitter' => 'Twitter',
								'google-plus' => 'Google+',
								'pinterest' => 'Pinterest',
								'linkedin' => 'LinkedIn'
							),
							'default'  => array(
								'facebook' => '1',
								'twitter' => '1',
								'google-plus' => '1',
								'pinterest' => '1',
								'linkedin' => '0'
							)
						),
						array(
							'id'       => 'blog-show-date',
							'type'     => 'switch',
							'title'    => esc_html__( 'Show Date', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => true
						),
						array(
							'id'       => 'blog-show-author',
							'type'     => 'switch',
							'title'    => esc_html__( 'Show Author', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'blog-show-tags',
							'type'     => 'switch',
							'title'    => esc_html__( 'Show Tags', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'blog-single-show-tags',
							'type'     => 'switch',
							'title'    => esc_html__( 'Show Tags in Single Post', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => true
						)
					)
				);
				
				//Shop
				if( in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ) {
					$this->sections[] = array(
						'title'  => esc_html__( 'Shop', 'dentalpress-options' ),
						'icon'   => 'fa fa-shopping-cart',
						'fields' => array(
							array(
								'id'       => 'shop-product-count',
								'type'     => 'spinner',
								'title'    => esc_html__( 'Products number', 'dentalpress-options' ),
								'desc'     => esc_html__( 'Select number of products per page.', 'dentalpress-options' ),
								'default'  => '9',
								'min'      => '1',
								'step'     => '1',
								'max'      => '50',
							),
							array(
								'id'       => 'shop-product-socials-show',
								'type'     => 'switch',
								'title'    => esc_html__( 'Social Media Sharing Buttons', 'dentalpress-options' ),
								'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
								'off'      => esc_html__( 'No', 'dentalpress-options' ),
								'default'  => true,
							),
							array(
								'id'       => 'shop-product-socials',
								'type'     => 'checkbox',
								'required' => array( 'shop-product-socials-show', '=', true ),
								'title'    => esc_html__( 'Social Networks', 'dentalpress-options' ),
								'desc'     => esc_html__( 'Select social networks to be shown in single products.', 'dentalpress-options' ),
								'options'  => array(
									'facebook' => 'Facebook',
									'twitter' => 'Twitter',
									'google-plus' => 'Google+',
									'pinterest' => 'Pinterest',
									'linkedin' => 'LinkedIn'
								),
								'default'  => array(
									'facebook' => '1',
									'twitter' => '1',
									'google-plus' => '1',
									'pinterest' => '1',
									'linkedin' => '0'
								)
							)
						)
					);
				}
				
				//Map
				$this->sections[] = array(
					'title'  => esc_html__( 'Map', 'dentalpress-options' ),
					'desc'   => wp_kses( __( 'Please find here all the map options. To convert an address into latitude & longitude please use <a href="http://www.latlong.net/convert-address-to-lat-long.html" target="_blank">this converter.</a>', 'dentalpress-options' ), array('a' => array('href' => array(), 'target' => array())) ),
					'icon'   => 'fa fa-map-marker',
					'fields' => array(
						array(
							'id'       => 'google-map-api-key',
							'type'     => 'text',
							'title'    => esc_html__( 'Google Map API Key', 'dentalpress-options' ),
							'desc'     => wp_kses( __( 'As of <a href="https://googlegeodevelopers.blogspot.com/2016/06/building-for-scale-updates-to-google.html" target="_blank">June 22, 2016</a> Google Maps no longer allows request for new sites that doesn’t include an API key. <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Click here</a> to generate your Google Map API key', 'dentalpress-options' ), array('a' => array('href' => array(), 'target' => array())) ),
							'default'  => ''
						),
						array(
							'id'       => 'center-lat',
							'type'     => 'text',
							'title'    => esc_html__( 'Map Center Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for the map center point.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'center-lng',
							'type'     => 'text',
							'title'    => esc_html__( 'Map Center Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for the map center point.', 'dentalpress-options' ),
							'default'  => ''
						),
						array(
							'id'       => 'zoom-level',
							'type'     => 'text',
							'title'    => esc_html__( 'Default Map Zoom Level', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter default map zoom level. Note: Value should be between 1-18, 1 being the entire earth and 18 being right at street level.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-height',
							'type'     => 'text',
							'title'    => esc_html__( 'Map Height', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter map container height in px.', 'dentalpress-options' ),
							'validate' => 'numeric',
							'default'  => '580'
						),
						array(
							'id'       => 'map-type',
							'type'     => 'select',
							'title'    => esc_html__( 'Map Type', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select map type.', 'dentalpress-options' ),
							'select2'  => array('allowClear' => false),
							'options'  => array(
								"roadmap" => esc_html__("Roadmap", 'dentalpress-options'),
								"satellite" => esc_html__("Satellite", 'dentalpress-options'),
								"hybrid" => esc_html__("Hybrid", 'dentalpress-options'),
								"terrain" => esc_html__("Terrain", 'dentalpress-options')
							),
							'default'  => 'roadmap'
						),
						array(
							'id'       => 'map-style',
							'type'     => 'select_image',
							'required' => array( 'map-type', '=', 'roadmap' ),
							'title'    => esc_html__( 'Map Style', 'dentalpress-options' ),
							'desc' => esc_html__( 'Select map style.', 'dentalpress-options' ),
							'compiler' => true,
							'options'  => array(
								"1" => array(
									'alt' => 'Theme Style',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/1.png#1'
								),
								"2" => array(
									'alt' => 'Subtle Grayscale',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/2.png#2'
								),
								"3" => array(
									'alt' => 'Blue Water',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/3.png#3'
								),
								"4" => array(
									'alt' => 'Shades of Grey',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/4#4'
								),
								"5" => array(
									'alt' => 'Pale Dawn',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/1-pale-dawn.png#5'
								),
								"6" => array(
									'alt' => 'Apple Maps-esque',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/6.png#6'
								),
								"7" => array(
									'alt' => 'Light Monochrome',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/7.png#7'
								),
								"8" => array(
									'alt' => 'Greyscale',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/8.png#8'
								),
								"9" => array(
									'alt' => 'Neutral Blue',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/9.png#9'
								),
								"10" => array(
									'alt' => 'Become a Dinosaur',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/10.png#10'
								),
								"11" => array(
									'alt' => 'Blue Gray',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/11.png#11'
								),
								"12" => array(
									'alt' => 'Icy Blue',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/12.png#12'
								),
								"13" => array(
									'alt' => 'Clean Cut',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/13.png#13'
								),
								"14" => array(
									'alt' => 'Muted Blue',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/14.png#14'
								),
								"15" => array(
									'alt' => 'Old Timey',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/15.png#15'
								),
								"16" => array(
									'alt' => 'Red Hues',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/16.png#16'
								),
								"17" => array(
									'alt' => 'Nature',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/17.png#17'
								),
								"18" => array(
									'alt' => 'Turquoise Water',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/18.png#18'
								),
								"19" => array(
									'alt' => 'Just Places',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/19.png#19'
								),
								"20" => array(
									'alt' => 'Ultra Light',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/20.png#20'
								),
								"21" => array(
									'alt' => 'Subtle Green',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/21.png#21'
								),
								"22" => array(
									'alt' => 'Simple & Light',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/22.png#22'
								),
								"23" => array(
									'alt' => 'Dankontorstole',
									'img' => 'http://dl.flexipress.xyz/dentalpress/assets/map-styles/23.png#23'
								)
							),
							'default'  => '',
						),
						array(
							'id'       => 'map-tilt-45',
							'type'     => 'switch',
							'required' => array( 'map-type', '=', 'satellite' ),
							'title'    => esc_html__( 'Tilt 45°', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'use-marker-img',
							'type'     => 'switch',
							'title'    => esc_html__( 'Use Image for Markers', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Use a custom map marker?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'marker-img',
							'type'     => 'media',
							'required' => array( 'use-marker-img', '=', true ),
							'title'    => esc_html__( 'Marker Icon Upload', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Upload image that will be used as map marker.', 'dentalpress-options' )
						),
						array(
							'id'       => 'enable-map-animation',
							'type'     => 'switch',
							'title'    => esc_html__( 'Enable Marker Animation', 'dentalpress-options' ),
							'desc'     => esc_html__( 'This will cause marker(s) to do a quick bounce as they load in.', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'map-others-options',
							'type'     => 'checkbox',
							'title'    => esc_html__( 'Others Options', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select other options you want to apply on the map.', 'dentalpress-options' ),
							'options'  => array(
								'draggable' => esc_html__('Draggable', 'dentalpress-options'),
								'zoomControl' => esc_html__( 'Zoom Control', 'dentalpress-options'),
								'disableDoubleClickZoom' => esc_html__( 'Disable Double Click Zoom', 'dentalpress-options'),
								'scrollwheel' => esc_html__( 'Scroll Wheel', 'dentalpress-options'),
								'panControl' => esc_html__( 'Pan Control', 'dentalpress-options'),
								'mapTypeControl' => esc_html__( 'Map Type Control', 'dentalpress-options'),
								'scaleControl' => esc_html__( 'Scale Control', 'dentalpress-options'),
								'streetViewControl' => esc_html__( 'Street View Control', 'dentalpress-options')
							),
							'default' => array(
								'draggable' => true
							)
						),

						// ***** Map Point 1 ***** //
						array(
							'id'       => 'map-point-1',
							'type'     => 'switch',
							'title'    => esc_html__( 'Location #1', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #1?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude1',
							'type'     => 'text',
							'required' => array( 'map-point-1', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #1.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude1',
							'type'     => 'text',
							'required' => array( 'map-point-1', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #1.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info1',
							'type'     => 'textarea',
							'required' => array( 'map-point-1', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your #1 location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 2 ***** //
						array(
							'id'       => 'map-point-2',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 2 ),
							'title'    => esc_html__( 'Location #2', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #2?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude2',
							'type'     => 'text',
							'required' => array( 'map-point-2', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #2.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude2',
							'type'     => 'text',
							'required' => array( 'map-point-2', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #2.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info2',
							'type'     => 'textarea',
							'required' => array( 'map-point-2', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your #2 location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 3 ***** //
						array(
							'id'       => 'map-point-3',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 3 ),
							'title'    => esc_html__( 'Location #3', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #3?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude3',
							'type'     => 'text',
							'required' => array( 'map-point-3', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #3.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude3',
							'type'     => 'text',
							'required' => array( 'map-point-3', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #3.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info3',
							'type'     => 'textarea',
							'required' => array( 'map-point-3', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your #3 location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 4 ***** //
						array(
							'id'       => 'map-point-4',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 4 ),
							'title'    => esc_html__( 'Location #4', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #4?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude4',
							'type'     => 'text',
							'required' => array( 'map-point-4', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #4.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude4',
							'type'     => 'text',
							'required' => array( 'map-point-4', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #4.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info4',
							'type'     => 'textarea',
							'required' => array( 'map-point-4', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your #4 location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 5 ***** //
						array(
							'id'       => 'map-point-5',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 5 ),
							'title'    => esc_html__( 'Location #5', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #5?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude5',
							'type'     => 'text',
							'required' => array( 'map-point-5', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #5.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude5',
							'type'     => 'text',
							'required' => array( 'map-point-5', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #5.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info5',
							'type'     => 'textarea',
							'required' => array( 'map-point-5', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your #5 location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 6 ***** //
						array(
							'id'       => 'map-point-6',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 6 ),
							'title'    => esc_html__( 'Location #6', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #6?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude6',
							'type'     => 'text',
							'required' => array( 'map-point-6', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #6.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude6',
							'type'     => 'text',
							'required' => array( 'map-point-6', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #6.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info6',
							'type'     => 'textarea',
							'required' => array( 'map-point-6', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your #6 location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 7 ***** //
						array(
							'id'       => 'map-point-7',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 7 ),
							'title'    => esc_html__( 'Location #7', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #7?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude7',
							'type'     => 'text',
							'required' => array( 'map-point-7', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #7.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude7',
							'type'     => 'text',
							'required' => array( 'map-point-7', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #7.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info7',
							'type'     => 'textarea',
							'required' => array( 'map-point-7', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your #7 location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 8 ***** //
						array(
							'id'       => 'map-point-8',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 8 ),
							'title'    => esc_html__( 'Location #8', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #8?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude8',
							'type'     => 'text',
							'required' => array( 'map-point-8', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #8.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude8',
							'type'     => 'text',
							'required' => array( 'map-point-8', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #8.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info8',
							'type'     => 'textarea',
							'required' => array( 'map-point-8', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your #8 location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 9 ***** //
						array(
							'id'       => 'map-point-9',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 9 ),
							'title'    => esc_html__( 'Location #9', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #9?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude9',
							'type'     => 'text',
							'required' => array( 'map-point-9', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #9.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude9',
							'type'     => 'text',
							'required' => array( 'map-point-9', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #9.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info9',
							'type'     => 'textarea',
							'required' => array( 'map-point-9', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your #9 location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 10 ***** //
						array(
							'id'       => 'map-point-10',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 10 ),
							'title'    => esc_html__( 'Location #10', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #10?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude10',
							'type'     => 'text',
							'required' => array( 'map-point-10', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #10.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude10',
							'type'     => 'text',
							'required' => array( 'map-point-10', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #10.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info10',
							'type'     => 'textarea',
							'required' => array( 'map-point-10', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your #10 location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 11 ***** //
						array(
							'id'       => 'map-point-11',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 11 ),
							'title'    => esc_html__( 'Location #11', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #11?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude11',
							'type'     => 'text',
							'required' => array( 'map-point-11', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #11.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude11',
							'type'     => 'text',
							'required' => array( 'map-point-11', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #11.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info11',
							'type'     => 'textarea',
							'required' => array( 'map-point-11', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your 11th location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 12 ***** //
						array(
							'id'       => 'map-point-12',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 12 ),
							'title'    => esc_html__( 'Location #12', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #12?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude12',
							'type'     => 'text',
							'required' => array( 'map-point-12', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #12.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude12',
							'type'     => 'text',
							'required' => array( 'map-point-12', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #12.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info12',
							'type'     => 'textarea',
							'required' => array( 'map-point-12', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your 12th location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 13 ***** //
						array(
							'id'       => 'map-point-13',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 13 ),
							'title'    => esc_html__( 'Location #13', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #13?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude13',
							'type'     => 'text',
							'required' => array( 'map-point-13', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #13.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude13',
							'type'     => 'text',
							'required' => array( 'map-point-13', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #13.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info13',
							'type'     => 'textarea',
							'required' => array( 'map-point-13', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your 13th location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 14 ***** //
						array(
							'id'       => 'map-point-14',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 14 ),
							'title'    => esc_html__( 'Location #14', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #14?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude14',
							'type'     => 'text',
							'required' => array( 'map-point-14', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #14.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude14',
							'type'     => 'text',
							'required' => array( 'map-point-14', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #14.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info14',
							'type'     => 'textarea',
							'required' => array( 'map-point-14', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your 14th location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 15 ***** //
						array(
							'id'       => 'map-point-15',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 15 ),
							'title'    => esc_html__( 'Location #15', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #15?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude15',
							'type'     => 'text',
							'required' => array( 'map-point-15', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #15.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude15',
							'type'     => 'text',
							'required' => array( 'map-point-15', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #15.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info15',
							'type'     => 'textarea',
							'required' => array( 'map-point-15', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your 15th location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 16 ***** //
						array(
							'id'       => 'map-point-16',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 16 ),
							'title'    => esc_html__( 'Location #16', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #16?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude16',
							'type'     => 'text',
							'required' => array( 'map-point-16', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #16.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude16',
							'type'     => 'text',
							'required' => array( 'map-point-16', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #16.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info16',
							'type'     => 'textarea',
							'required' => array( 'map-point-16', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your 16th location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 17 ***** //
						array(
							'id'       => 'map-point-17',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 17 ),
							'title'    => esc_html__( 'Location #17', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #17?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude17',
							'type'     => 'text',
							'required' => array( 'map-point-17', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #17.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude17',
							'type'     => 'text',
							'required' => array( 'map-point-17', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #17.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info17',
							'type'     => 'textarea',
							'required' => array( 'map-point-17', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your 17th location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 18 ***** //
						array(
							'id'       => 'map-point-18',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 18 ),
							'title'    => esc_html__( 'Location #18', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #18?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude18',
							'type'     => 'text',
							'required' => array( 'map-point-18', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #18.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude18',
							'type'     => 'text',
							'required' => array( 'map-point-18', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #18.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info18',
							'type'     => 'textarea',
							'required' => array( 'map-point-18', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your 18th location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 19 ***** //
						array(
							'id'       => 'map-point-19',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 19 ),
							'title'    => esc_html__( 'Location #19', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #19?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude19',
							'type'     => 'text',
							'required' => array( 'map-point-19', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #19.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude19',
							'type'     => 'text',
							'required' => array( 'map-point-19', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #19.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info19',
							'type'     => 'textarea',
							'required' => array( 'map-point-19', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your 19th location, please enter it here.', 'dentalpress-options' )
						),

						// ***** Map Point 20 ***** //
						array(
							'id'       => 'map-point-20',
							'type'     => 'switch',
							'required' => array( 'number-of-locations', '>=', 20 ),
							'title'    => esc_html__( 'Location #20', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show location #20?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => false
						),
						array(
							'id'       => 'latitude20',
							'type'     => 'text',
							'required' => array( 'map-point-20', '=', true ),
							'title'    => esc_html__( 'Latitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter latitude for location #20.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'longitude20',
							'type'     => 'text',
							'required' => array( 'map-point-20', '=', true ),
							'title'    => esc_html__( 'Longitude', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Enter longitude for location #20.', 'dentalpress-options' ),
							'validate' => 'numeric'
						),
						array(
							'id'       => 'map-info20',
							'type'     => 'textarea',
							'required' => array( 'map-point-20', '=', true ),
							'title'    => esc_html__( 'Map Info Window Text', 'dentalpress-options' ),
							'desc'     => esc_html__( 'If you would like to display any text in an info window for your 20th location, please enter it here.', 'dentalpress-options' )
						),
						array(
							'id'       => 'number-of-locations',
							'type'     => 'spinner',
							'title'    => esc_html__( 'Number of locations', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select number of locations to be shown in the map.', 'dentalpress-options' ),
							'default'  => '1',
							'min'      => '1',
							'step'     => '1',
							'max'      => '20'
						)
					)
				);
				
				//Footer
				$this->sections[] = array(
					'title'  => esc_html__( 'Footer', 'dentalpress-options' ),
					'desc'   => esc_html__( 'Please find here all the options related with both footer.', 'dentalpress-options' ),
					'icon'   => 'fa fa-toggle-down',
					'fields' => array(
						array(
							'id'       => 'footer-show',
							'type'     => 'switch',
							'title'    => esc_html__( 'Show Footer?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => true
						),
						array(
							'id'       => 'footer-layout',
							'type'     => 'image_select',
							'required' => array( 'footer-show', '=', true ),
							'title'    => esc_html__( 'Footer Layout', 'dentalpress-options' ),
							'options'  => array(
								'2' => array(
									'alt' => '2 Columns',
									'img' => ReduxFramework::$_url .'assets/img/2col.png'
								),
								'3' => array(
									'alt' => '3 Columns',
									'img' => ReduxFramework::$_url .'assets/img/3col.png'
								),
								'4' => array(
									'alt' => '4 Columns',
									'img' => ReduxFramework::$_url .'assets/img/4col.png'
								)
							),
							'default'  => '4'
						),
						array(
							'id'       => 'footer-bg-color',
							'type'     => 'background',
							'required' => array('footer-show', '=', true),
							'title'    => esc_html__( 'Footer Background Color', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select footer background color.', 'dentalpress-options' ),
							'background-repeat' => false,
							'background-attachment' => false,
							'background-position' => false,
							'background-image' => false,
							'background-size' => false,
							'preview' => false,
							'transparent' => false,
							'output'   => '.vu_main-footer .vu_mf-widgets',
							'default'  => array(
								'background-color' => '#ffffff'
							)
						),
						array(
							'id'       => 'footer-text-color',
							'type'     => 'color',
							'required' => array('footer-show', '=', true),
							'title'    => esc_html__( 'Footer Text Color', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select footer text color.', 'dentalpress-options' ),
							'transparent' => false,
							'output'   => '.vu_main-footer',
							'default'  => '#777777'
						),
						array(
							'id'       => 'subfooter-show',
							'type'     => 'switch',
							'title'    => esc_html__( 'Show Subfooter?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => true
						),
						array(
							'id'       => 'subfooter-text-color',
							'type'     => 'color',
							'required' => array( 'subfooter-show', '=', true ),
							'title'    => esc_html__( 'Subfooter Text Color', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select subfooter text color.', 'dentalpress-options' ),
							'transparent' => false,
							'output'   => '.vu_main-footer .vu_mf-bottom',
							'default'  => '#777777'
						),
						array(
							'id'       => 'subfooter-left-content',
							'type'     => 'textarea',
							'required' => array( 'subfooter-show', '=', true ),
							'title'    => esc_html__( 'Subfooter Left Content', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Insert subfooter left side content.', 'dentalpress-options' ),
							'validate' => 'html',
							'default'  => 'Copyright &copy; 2017 <a href="http://themeforest.net/user/flexipress/portfolio" target="_blank">FlexiPress</a>. All Rights Reserved.'
						),	
						array(
							'id'       => 'subfooter-right-content',
							'type'     => 'textarea',
							'required' => array( 'subfooter-show', '=', true ),
							'title'    => esc_html__( 'Subooter Right Content', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Insert subfooter right side content.', 'dentalpress-options' ),
							'validate' => 'html',
							'default'  => ''
						),
						array(
							'id'       => 'back-to-top-show',
							'type'     => 'switch',
							'title'    => esc_html__( 'Show Back to Top', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Show back to top button on all pages?', 'dentalpress-options' ),
							'on'       => esc_html__( 'Yes', 'dentalpress-options' ),
							'off'      => esc_html__( 'No', 'dentalpress-options' ),
							'default'  => true
						)
					)
				);

				//Sidebars
				$this->sections[] = array(
					'title'  => esc_html__( 'Sidebars', 'dentalpress-options' ),
					'icon'   => 'fa fa-tasks',
					'fields' => array(
						array(
							'id'       => 'default-sidebar',
							'type'     => 'select',
							'title'    => esc_html__( 'Default Sidebar', 'dentalpress-options' ),
							'desc'     => esc_html__( 'Select default sidebar for all pages.', 'dentalpress-options' ),
							'data'  => 'sidebars',
							'default'  => 'general-sidebar'
						),
						array(
							'id' => 'sidebars',
							'type' => 'multi_text',
							'title' => esc_html__( 'Custom Sidebars', 'dentalpress-options'),
							'desc' => wp_kses( __( 'Create a custom sidebar. Sidebar name should be <b>unique</b>. Do not use the names of existing sidebars.', 'dentalpress-options' ), array('b' => array()) ),
							'validate' => 'no_special_chars',
							'add_text' => esc_html__( 'Add Sidebar', 'dentalpress-options')
						)
					)
				);
				
				//3rd Party
				$this->sections[] = array(
					'title'  => esc_html__( '3rd Party', 'dentalpress-options' ),
					'icon'   => 'fa fa-plug',
					'fields' => array(
						array(
							'id'       => 'google-analytics-tracking-code',
							'type'     => 'textarea',
							'title'    => esc_html__( 'Google Analytics Tracking Code', 'dentalpress-options' ),
							'default'  => ''
						),
						array(
							'id'       => 'twitter-consumer-key',
							'type'     => 'text',
							'title'    => esc_html__( 'Twitter Consumer Key', 'dentalpress-options' ),
							'desc'     => wp_kses( __( '1. Go to "https://dev.twitter.com/apps", login with our twitter account and click "Create a new application".<br>2. Fill out the required fields, accept the rules of the road, and then click on the "Create your Twitter application"<br>3. Once the app has been created, click the "Create my access token" button.<br>4. You are done! You will need the following data later on', 'dentalpress-options' ), array('br' => array()) ),
							'default'  => ''
						),
						array(
							'id'       => 'twitter-consumer-secret',
							'type'     => 'text',
							'title'    => esc_html__( 'Twitter Consumer Secret', 'dentalpress-options' ),
							'default'  => ''
						),
						array(
							'id'       => 'twitter-user-token',
							'type'     => 'text',
							'title'    => esc_html__( 'Twitter Access Token', 'dentalpress-options' ),
							'default'  => ''
						),
						array(
							'id'       => 'twitter-user-secret',
							'type'     => 'text',
							'title'    => esc_html__( 'Twitter Access Token Secret', 'dentalpress-options' ),
							'default'  => ''
						),
						array(
							'id'       => 'mailchimp-api',
							'type'     => 'text',
							'title'    => esc_html__( 'MailChimp API', 'dentalpress-options' ),
							'default'  => ''
						),
						array(
							'id'       => 'mailchimp-list-id',
							'type'     => 'text',
							'title'    => esc_html__( 'MailChimp List ID', 'dentalpress-options' ),
							'default'  => ''
						)
					)
				);
				
				//Custom Code
				$this->sections[] = array(
					'title'  => esc_html__( 'Custom Code', 'dentalpress-options' ),
					'icon'   => 'fa fa-code',
					'fields' => array(
						array(
							'id'       => 'custom-css',
							'type'     => 'ace_editor',
							'title'    => esc_html__( 'CSS Code', 'dentalpress-options' ),
							'subtitle' => esc_html__( 'Paste your CSS code here', 'dentalpress-options' ),
							'mode'     => 'css',
							'theme'    => 'monokai',
							'desc'     => wp_kses( __( 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.', 'dentalpress-options' ), array('a' => array('href' => array(), 'target' => array())) ),
							'default'  => ''
						),
						array(
							'id'       => 'custom-js',
							'type'     => 'ace_editor',
							'title'    => esc_html__( 'JS Code', 'dentalpress-options' ),
							'subtitle' => esc_html__( 'Paste your JS code here', 'dentalpress-options' ),
							'mode'     => 'javascript',
							'theme'    => 'monokai',
							'desc'     => wp_kses( __( 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.', 'dentalpress-options' ), array('a' => array('href' => array(), 'target' => array())) ),
							'default'  => ''
						)
					)
				);

				$this->sections[] = array(
					'type' => 'divide'
				);

				//Import / Export
				$this->sections[] = array(
					'title'  => esc_html__( 'Import / Export', 'dentalpress-options' ),
					'desc'   => esc_html__( 'Import and Export your theme settings from file, text or URL.', 'dentalpress-options' ),
					'icon'   => 'fa fa-refresh',
					'fields' => array(
						array(
							'id'         => 'import-export',
							'type'       => 'import_export',
							'title'      => esc_html__('Import Export', 'dentalpress-options' ),
							'subtitle'   => esc_html__( 'Save and restore your theme options', 'dentalpress-options' ),
							'full_width' => false,
						),
					)
				);

				$this->sections[] = array(
					'type' => 'divide'
				);

				//Theme Information
				$this->sections[] = array(
					'icon'   => 'fa fa-info-circle',
					'title'  => esc_html__( 'Theme Information', 'dentalpress-options' ),
					'fields' => array(
						array(
							'id'      => 'theme-info',
							'type'    => 'raw',
							'content' => $theme_info,
						)
					)
				);

				$this->sections[] = array(
					'type' => 'divide'
				);

				//Install Demo Content
				$this->sections[] = array(
					'id' => 'wbc_importer_section',
					'title'  => esc_html__( 'Install Demo Content', 'dentalpress-options' ),
					'desc'   => '
						<div style="overflow: hidden;">
							<div style="background-color: #F5FAFD; margin: 0px 0px 15px 0px; padding: 0 15px; color: #0C518F; border: 1px solid #CAE0F3; clear:both; line-height:18px;">
								<p class="tie_message_hint">Importing demo content is the easiest way to setup your site. It allows you to quickly edit everything instead of creating content from scratch. When you import the data please be aware of the followings:</p>

								<ul style="padding-left: 20px; list-style-position: inside; list-style-type: square;">
									<li>Make sure that no other posts, pages or media already exist.</li>
									<li>To reset your installlation we recommend to use <a href="https://wordpress.org/plugins/wordpress-database-reset/" target="_blank">WordPress Database Reset</a> plugin.</li>
									<li>Posts, pages, images, widgets and menus will be imported.</li>
									<li>Current active widgets will be deactivated.</li>
									<li>Images shown in demo pages are copyrighted and come with a watermark when imported.</li>
									<li>Import process might take couple of minutes.</li>
								</ul>
							</div>

							<div style="background-color: #FFC7C7; margin: 10px 0 15px 0px; padding: 0 15px; color: #7B0000; border: 1px solid #FF7C7C; clear:both; line-height:18px;">
								<p class="tie_message_hint" style="margin: 15px 0 15px 0;">Before you begin, make sure <code>max_execution_time</code> is at least <code>180</code>, <code>memory_limit</code> is at least <code>256M</code> and all the required plugins are activated.</p>
							</div>
						</div>
					',
					'icon'   => 'fa fa-hand-pointer-o',
					'fields' => array(
						array(
							'id'   => 'wbc_demo_importer',
							'type' => 'wbc_importer'
						)
					)
				);
			}

			/**
			 * All the possible arguments for Redux.
			 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
			 **/
			public function setArguments() {
				$theme = wp_get_theme();

				$this->args = array(
					'opt_name'             => 'dentalpress_theme_options',
					'display_name'         => $theme->get( 'Name' ),
					'display_version'      => $theme->get( 'Version' ),
					'menu_title'           => esc_html__( 'DentalPress', 'dentalpress-options' ),
					'page_title'           => esc_html__( 'DentalPress Options', 'dentalpress-options' ),
					'admin_bar_icon'       => 'dashicons-admin-generic',
					'page_slug'            => 'dentalpress_options',
					'dev_mode'             => false,
					'forced_dev_mode_off'  => true,
					'update_notice'        => false,
					'show_import_export'   => true,
					'show_options_object'  => true,
					'footer_credit'        => wp_kses( __('Copyright &copy; 2017 <a href="http://themeforest.net/user/flexipress/portfolio" target="_blank">FlexiPress</a>. All Rights Reserved.', 'dentalpress-options'), array('a' => array('href' => array(), 'target' => array())) )
				);
			}
		}

		global $Redux_Framework_DentalPress_Options;
		$Redux_Framework_DentalPress_Options = new Redux_Framework_DentalPress_Options();
	}
?>