<?php 
	// Custom CSS
	if( !function_exists('dentalpress_custom_css') ){
		function dentalpress_custom_css($echo = false){
			// Primary Color - Default : #50b0e3
			$primary_color_hex = esc_attr(dentalpress_get_option('primary-color', '#50b0e3'));
			$primary_color_rgb = esc_attr(dentalpress_hex2rgb($primary_color_hex, true));

			// Secondary Color - Default : #a4d735
			$secondary_color_hex = esc_attr(dentalpress_get_option('secondary-color', '#a4d735'));
			$secondary_color_rgb = esc_attr(dentalpress_hex2rgb($secondary_color_hex, true));

			ob_start();
		?>
			/* Main Style */

			body:before {
			  background: -moz-linear-gradient(left, <?php echo ($primary_color_hex); ?> 0%, <?php echo ($primary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 100%);
			  background: -webkit-linear-gradient(left, <?php echo ($primary_color_hex); ?> 0%,<?php echo ($primary_color_hex); ?> 25%,<?php echo ($secondary_color_hex); ?> 25%,<?php echo ($secondary_color_hex); ?> 50%,<?php echo ($primary_color_hex); ?> 50%,<?php echo ($primary_color_hex); ?> 75%,<?php echo ($secondary_color_hex); ?> 75%,<?php echo ($secondary_color_hex); ?> 100%);
			  background: -webkit-linear-gradient(right, <?php echo ($primary_color_hex); ?> 0%, <?php echo ($primary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 100%);background: -o-linear-gradient(right, <?php echo ($primary_color_hex); ?> 0%, <?php echo ($primary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 100%);background: -ms-linear-gradient(right, <?php echo ($primary_color_hex); ?> 0%, <?php echo ($primary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 100%);background: -moz-linear-gradient(right, <?php echo ($primary_color_hex); ?> 0%, <?php echo ($primary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 100%);/* Impossible to translate property background for webkit20110101 */background: linear-gradient(to right, <?php echo ($primary_color_hex); ?> 0%,<?php echo ($primary_color_hex); ?> 25%,<?php echo ($secondary_color_hex); ?> 25%,<?php echo ($secondary_color_hex); ?> 50%,<?php echo ($primary_color_hex); ?> 50%,<?php echo ($primary_color_hex); ?> 75%,<?php echo ($secondary_color_hex); ?> 75%,<?php echo ($secondary_color_hex); ?> 100%);
			}
			::-moz-selection {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			::selection {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			a {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			a:hover {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			a.vu_link-inverse {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			a.vu_link-inverse:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			blockquote {
			  border-left: 2px solid <?php echo ($secondary_color_hex); ?>;
			}
			.vu_info-item .vu_ii-icon {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_top-bar a:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_tb-list .sub-menu li a:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_top-bar .vu_social-icon a:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_main-navigation > ul > li:before,
			.vu_main-navigation > ul > li.current-menu-parent:before,
			.vu_main-navigation > ul > li.current-menu-ancestor:before,
			.vu_main-navigation > ul > li.current-menu-item:before {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_main-navigation ul li a:hover,
			.vu_main-navigation ul li:hover > a,
			.vu_main-navigation ul li.current-menu-parent > a,
			.vu_main-navigation ul li.current-menu-ancestor > a,
			.vu_main-navigation ul li.current-menu-item > a {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_main-navigation > ul > li.vu_appointment-menu-item a {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_mobile-menu ul li.current-menu-item > a {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_mobile-menu ul li a:hover,
			.vu_mobile-menu ul li.current-menu-item > a:hover,
			.vu_mobile-menu .vu_mm-remove:hover {
			  border-color: <?php echo ($primary_color_hex); ?>;
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_mm-open:hover,
			.vu_mm-open:focus,
			.vu_wc-menu-item.vu_wc-responsive:hover,
			.vu_wc-menu-item.vu_wc-responsive:focus {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_page-header .vu_ph-title {
			  color: <?php echo ($primary_color_hex); ?> !important;
			}
			.vu_page-header .vu_ph-breadcrumbs .divider i {
			  color: <?php echo ($secondary_color_hex); ?> !important;
			}
			.vu_page-header.vu_ph-with-bg .vu_ph-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.widget_nav_menu ul li a:hover,
			.widget_nav_menu ul li.current-menu-parent > a,
			.widget_nav_menu ul li.current-menu-ancestor > a,
			.widget_nav_menu ul li.current-menu-item > a {
			  border-color: <?php echo ($primary_color_hex); ?>;
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_sidebar .widget_nav_menu ul li a:hover,
			.vu_sidebar .widget_nav_menu ul li.current-menu-parent > a,
			.vu_sidebar .widget_nav_menu ul li.current-menu-ancestor > a,
			.vu_sidebar .widget_nav_menu ul li.current-menu-item > a {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.datepicker.dropdown-menu th.datepicker-switch {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.datepicker.dropdown-menu th.dow {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.bootstrap-timepicker-widget table td input {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_accordion .vu_a-wrapper .vu_a-header a {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_accordion .vu_a-wrapper .ui-state-default .ui-icon,
			.vu_accordion .vu_a-wrapper .ui-state-active .ui-icon {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_accordion .vu_a-wrapper .ui-state-active .ui-icon {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_toggle .vu_t-title .vu_t-icon {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_toggle .vu_t-title h4 {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_toggle .vu_t-title:hover .vu_t-icon,
			.vu_toggle.vc_toggle_active .vu_t-icon {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_tabs:not(.vu_t-nav-bottom) .vu_t-nav {
			  border-bottom: 1px solid <?php echo ($secondary_color_hex); ?> !important;
			}
			.vu_tabs.vu_t-nav-bottom .vu_t-nav {
			  border-top: 1px solid <?php echo ($secondary_color_hex); ?> !important;
			}
			.vu_tabs .vu_t-nav li.ui-tabs-active a,
			.vu_tabs .vu_t-nav li:hover a {
			  color: <?php echo ($primary_color_hex); ?> !important;
			}
			.vu_tabs.vu_t-style-3 .vu_t-nav .ui-state-default a:after {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_tour .vu_t-nav li.ui-tabs-active a {
			  color: <?php echo ($primary_color_hex); ?> !important;
			}
			.vu_progress-bar .vu_pb-bar {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_countdown .countdown-section:before {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_countdown .countdown-amount {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_widget-nav li.active > a,
			.vu_widget-nav a:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_image-box .vu_ib-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_image-box .vu_ib-read-more .vu_ib-btn i {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_team-member .vu_tm-name {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_team-member .vu_tm-social-networks a:hover {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_team-member.vu_tm-style-2 .vu_tm-info {
			  border-left: 2px solid <?php echo ($secondary_color_hex); ?>;
			}
			.vu_team-member.vu_tm-style-2 .vu_tm-social-networks a:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_testimonial.vu_t-style-1 .vu_t-author .vu_t-icon {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_testimonial.vu_t-style-1 .vu_t-author-image {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_testimonial.vu_t-style-1 .vu_t-author .vu_t-author-name {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_testimonial.vu_t-style-2 .vu_t-icon {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_testimonial.vu_t-style-2 .vu_t-author-image {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_testimonial.vu_t-style-2 .vu_t-author .vu_t-author-name {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_before-after .twentytwenty-handle {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.form-control:focus {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_contact-form-7.vu_cf7-style-inverse .vu_cf7-frm .form-control:focus {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_contact-form-7 .vu_cf7-frm .vu_lbl-as-input-file:after {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.wpcf7-form:not(.vu_cf7-frm) .wpcf7-form-control:not(.wpcf7-submit):focus {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_icon-box .vu_ib-icon {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			  border: 2px solid <?php echo ($secondary_color_hex); ?>;
			}
			.vu_icon-box .vu_ib-content .vu_ib-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_icon-box.vu_ib-color-primary .vu_ib-content .vu_ib-title {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_icon-box.vu_ib-color-primary .vu_ib-icon {
			  background-color: <?php echo ($primary_color_hex); ?>;
			  border-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_icon-box.vu_ib-color-secondary .vu_ib-content .vu_ib-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_icon-box.vu_ib-color-secondary .vu_ib-icon {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_icon-box.vu_ib-color-black .vu_ib-content .vu_ib-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_icon-box.vu_ib-color-white .vu_ib-content .vu_ib-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_icon-box .vu_ib-read-more .vu_ib-btn i {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_icon-box-2 .vu_ib-icon {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_icon-box-2.vu_ib-type-image .vu_ib-icon * {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_icon-box-2 .vu_ib-content .vu_ib-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_icon-box-2.vu_ib-style-2:after {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_icon-box-2.vu_ib-style-2:hover .vu_ib-icon,
			.vu_icon-box-2.vu_ib-style-2:hover .vu_ib-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_timeline .vu_t-date {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_timeline .vu_t-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_video-section .vu_vs-play {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.custom.tparrows:hover {
			  color: <?php echo ($primary_color_hex); ?> !important;
			}
			.custom.tparrows:hover:before {
			  color: <?php echo ($primary_color_hex); ?> !important;
			}
			.custom .tp-bullet:hover,
			.custom .tp-bullet.selected {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_carousel .owl-pagination .owl-page.active span,
			.vu_carousel .owl-pagination .owl-page span:hover {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_client:hover {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_heading.vu_h-alignment-left.vu_h-style-1 {
			  border-left: 2px solid <?php echo ($secondary_color_hex); ?>;
			}
			.vu_heading.vu_h-alignment-right.vu_h-style-1 {
			  border-right: 2px solid <?php echo ($secondary_color_hex); ?>;
			}
			.vu_heading.vu_h-style-2 .vu_h-heading:after {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_heading.vu_h-style-3 .vu_h-heading:after {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_heading.vu_h-style-4 .vu_h-heading:before,
			.vu_heading.vu_h-style-4 .vu_h-heading:after {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_pricing-table .vu_pt-title {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_pricing-table.vu_pt-active .vu_pt-title {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_pricing-table .vu_pt-button a {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_pricing-table.vu_pt-active .vu_pt-button a {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.btn.btn-primary,
			.btn.btn-primary.btn-default {
			  color: <?php echo ($primary_color_hex); ?>;
			  border-color: <?php echo ($primary_color_hex); ?>;
			}
			.btn.btn-primary:hover,
			.btn.btn-primary.btn-default:hover,
			.btn.btn-primary.btn-inverse {
			  border-color: <?php echo ($primary_color_hex); ?>;
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.btn.btn-primary.btn-inverse:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			  border-color: <?php echo ($primary_color_hex); ?>;
			}
			.btn.btn-primary-hover:hover,
			.btn.btn-primary-hover.btn-default:hover {
			  border-color: <?php echo ($primary_color_hex); ?> !important;
			  background-color: <?php echo ($primary_color_hex); ?> !important;
			}
			.btn.btn-primary-hover.btn-inverse:hover {
			  color: <?php echo ($primary_color_hex); ?> !important;
			  border-color: <?php echo ($primary_color_hex); ?> !important;
			}
			.btn.btn-secondary,
			.btn.btn-secondary.btn-default {
			  color: <?php echo ($secondary_color_hex); ?>;
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.btn.btn-secondary:hover,
			.btn.btn-secondary.btn-default:hover,
			.btn.btn-secondary.btn-inverse {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.btn.btn-secondary.btn-inverse:hover {
			  color: <?php echo ($secondary_color_hex); ?>;
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.btn.btn-secondary-hover:hover,
			.btn.btn-secondary-hover.btn-default:hover {
			  border-color: <?php echo ($secondary_color_hex); ?> !important;
			  background-color: <?php echo ($secondary_color_hex); ?> !important;
			}
			.btn.btn-secondary-hover.btn-inverse:hover {
			  color: <?php echo ($secondary_color_hex); ?> !important;
			  border-color: <?php echo ($secondary_color_hex); ?> !important;
			}
			.btn.btn-disable:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_filterable .vu_f-filters.vu_f-filters-style-1 .vu_f-filter.active {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_filterable .vu_f-filters.vu_f-filters-style-2 .vu_f-filter.active {
			  color: <?php echo ($primary_color_hex); ?>;
			  border-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_gallery .vu_g-filters.vu_g-filters-style-1 .vu_g-filter.active {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_gallery .vu_g-filters.vu_g-filters-style-2 .vu_g-filter.active {
			  color: <?php echo ($primary_color_hex); ?>;
			  border-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_gallery-item .vu_gi-details-container {
			  background-color: rgba(<?php echo ($secondary_color_rgb); ?>,0.5);
			}
			.vu_gallery-widget .vu_gw-item .vu_gw-image {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_counter .vu_c-label {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_image-slider .vu_is-item .vu_is-i-caption {
			  background-color: rgba(<?php echo ($primary_color_rgb); ?>,0.9);
			}
			.vu_posts-page .vu_blog-post .vu_bp-meta .vu_bp-m-item-icon {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_posts-page .vu_blog-post .vu_bp-meta .vu_bp-m-item a:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_posts-page .vu_blog-post .vu_bp-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_posts-page .vu_blog-post .vu_bp-read-more .vu_bp-btn i {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_posts-page .vu_blog-post.vu_bp-type-audio .vu_bp-image .mejs-controls .mejs-time-rail .mejs-time-current {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_posts-page .vu_blog-post.vu_bp-type-link:before {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_posts-page .vu_blog-post.vu_bp-type-quote .vu_bp-quote:before {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_posts-page .vu_blog-post.vu_bp-type-quote .vu_bp-quote > blockquote cite,
			.vu_posts-page .vu_blog-post.vu_bp-type-quote .vu_bp-quote .vu_bp-q-author {
			  border-left: 2px solid <?php echo ($primary_color_hex); ?>;
			}
			.vu_blog .vu_b-item.vu_blog-post .vu_bp-meta .vu_bp-m-item:before {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_blog .vu_b-item.vu_blog-post .vu_bp-title {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_blog .vu_b-item.vu_blog-post .vu_bp-read-more .vu_bp-btn i {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_comments .vu_c-count,
			.vu_comments .vu_c-text {
			  border-left: 2px solid <?php echo ($primary_color_hex); ?>;
			}
			.vu_comments .vu_c-a-author {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_comments .vu_c-a-m-item a:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_comments .vu_c-a-edit a,
			.vu_comments .vu_c-a-reply a {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_comments .vu_c-a-edit a {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_comments .vu_c-a-content .vu_c-a-moderation {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.comment-reply-title {
			  border-left: 2px solid <?php echo ($primary_color_hex); ?>;
			}
			.comment-reply-title small a {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.comment-reply-title small a:hover {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.comment-form .form-control:focus {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_pagination .vu_p-list a:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_pagination .vu_p-list .current {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_recent-posts .vu_rp-item .vu_rp-title a:hover {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_working-hours .vu_wh-item.active .vu_wh-day,
			.vu_working-hours .vu_wh-item.active .vu_wh-hours {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_error-page .vu_ep-404 {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_error-page .vu_ep-title {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.widget_title {
			  border-left: 2px solid <?php echo ($secondary_color_hex); ?>;
			}
			.widget .vu_social-icon a {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.widget .vu_social-icon a:hover {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_search-form .vu_sf-wrapper:before {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.widget .form-control:focus,
			.widget input[type="text"]:focus,
			.widget input[type="search"]:focus {
			  border-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_latest-tweets ul li:before {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_sidebar .widget.widget_recent_comments li a {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_sidebar .widget.widget_recent_comments li a.url {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.widget.widget_archive li a:hover,
			.widget.widget_pages li a:hover,
			.widget.widget_recent_comments li a:hover,
			.widget.widget_recent_entries li a:hover,
			.widget.widget_meta li a:hover,
			.widget.widget_categories li a:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.widget.widget_tag_cloud a {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.widget.widget_tag_cloud a.active,
			.widget.widget_tag_cloud a:hover {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.widget.widget_rss .rss-date {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_highlight {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_list-with-icon li a:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_list-with-icon li:before {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_list-with-icon[data-color="primary"] li a:hover,
			.vu_list-with-icon[data-color="primary"] li:before {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_list-with-icon[data-color="secondary"] li a:hover,
			.vu_list-with-icon[data-color="secondary"] li:before {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_newsletter .vu_n-form .form-control:focus {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_newsletter .vu_n-form .vu_n-button {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_newsletter .vu_n-form .form-control:focus + .vu_n-button,
			.vu_newsletter .vu_n-form .vu_n-button:hover {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_main-footer .vu_mf-widgets:before {
			  background: -moz-linear-gradient(left, <?php echo ($primary_color_hex); ?> 0%, <?php echo ($primary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 100%);
			  background: -webkit-linear-gradient(left, <?php echo ($primary_color_hex); ?> 0%,<?php echo ($primary_color_hex); ?> 25%,<?php echo ($secondary_color_hex); ?> 25%,<?php echo ($secondary_color_hex); ?> 50%,<?php echo ($primary_color_hex); ?> 50%,<?php echo ($primary_color_hex); ?> 75%,<?php echo ($secondary_color_hex); ?> 75%,<?php echo ($secondary_color_hex); ?> 100%);
			  background: -webkit-linear-gradient(right, <?php echo ($primary_color_hex); ?> 0%, <?php echo ($primary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 100%);background: -o-linear-gradient(right, <?php echo ($primary_color_hex); ?> 0%, <?php echo ($primary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 100%);background: -ms-linear-gradient(right, <?php echo ($primary_color_hex); ?> 0%, <?php echo ($primary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 100%);background: -moz-linear-gradient(right, <?php echo ($primary_color_hex); ?> 0%, <?php echo ($primary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 25%, <?php echo ($secondary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 50%, <?php echo ($primary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 75%, <?php echo ($secondary_color_hex); ?> 100%);/* Impossible to translate property background for webkit20110101 */background: linear-gradient(to right, <?php echo ($primary_color_hex); ?> 0%,<?php echo ($primary_color_hex); ?> 25%,<?php echo ($secondary_color_hex); ?> 25%,<?php echo ($secondary_color_hex); ?> 50%,<?php echo ($primary_color_hex); ?> 50%,<?php echo ($primary_color_hex); ?> 75%,<?php echo ($secondary_color_hex); ?> 75%,<?php echo ($secondary_color_hex); ?> 100%);
			}
			.vu_main-footer [class*="vu_mf-footer"]:nth-child(even) .widget_title {
			  border-left-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_main-footer .vu_mf-bottom a:hover {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_contact-info-item i {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_contact-info-list li .fa {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_useful-links li:before {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_useful-links li a:hover {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_primary-text-color {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_primary-border-color {
			  border-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_primary-bg-color {
			  background-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_secondary-text-color {
			  color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_secondary-border-color {
			  border-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_secondary-bg-color {
			  background-color: <?php echo ($secondary_color_hex); ?>;
			}
			.vu_with-icon > i.fa {
			  color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_arrow-down:after {
			  border-top-color: <?php echo ($primary_color_hex); ?>;
			}
			.vu_arrow-down.vu_secondary-bg-color:after {
			  border-top-color: <?php echo ($secondary_color_hex); ?>;
			}
			
			/* Logo */

			.vu_main-menu-container .vu_logo-container {
			  width:<?php echo absint(dentalpress_get_option('logo-width')); ?>px;
			}
			.vu_main-menu-container .vu_logo-container img {
			  max-width:<?php echo absint(dentalpress_get_option('logo-width')); ?>px;
			}

			/* Submenu width */

			.vu_main-menu ul li ul.sub-menu { width:<?php echo dentalpress_get_option('submenu-width', '200'); ?>px; }
		<?php 
			$custom_css = ob_get_contents();
			ob_end_clean();

			// Preloader Image
			if( dentalpress_get_option('preloader') == true and trim(dentalpress_get_option( array('preloader-image', 'url') )) != '' ) {
				$custom_css .= '#vu_preloader { background-image: url('. dentalpress_get_option( array('preloader-image', 'url') ) .');';
			}

			// Custom CSS from Theme Options
			if( trim(dentalpress_get_option('custom-css')) != '' ) {
				$custom_css .= dentalpress_get_option('custom-css');
			}

			if( $echo ){
				echo dentalpress_css_compress($custom_css);
			} else {
				return dentalpress_css_compress($custom_css);
			}
		}
	}
?>