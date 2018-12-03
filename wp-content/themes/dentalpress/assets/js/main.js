(function ($) {
	"use strict";

	$(document).ready(function(e){
		// Embed Page
		try {
			var hash = location.hash.substring(1),
				params = JSON.parse('{"' + decodeURI(hash).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"') + '"}');
				
			if( typeof params.lightbox !== 'undefined' && params.lightbox == "true" && typeof params.element !== 'undefined' && params.element != '' ) {
				$(params.element).wrap('<div class="vu_embed-container clearfix"/>');

				$('html').addClass('vu_embed');
				$('body').addClass('clearfix');

				$('body > :not('+ params.element +')').hide();
				$('.vu_embed-container').appendTo('body').wait(300).css({'opacity': 1});
			}
		} catch(err) {}

		// Make responsive menu
		var $vu_mobile_menu = $('<div></div>').addClass('vu_mobile-menu'),
			$vu_mobile_menu_list = $('<ul></ul>');

		$('.vu_main-menu:not(.vu_mm-clone) .vu_mm-list').each(function(){
			$vu_mobile_menu_list.append( $(this).html() );
		});

		$vu_mobile_menu_list.find('li.vu_wc-menu-item').remove();
		$vu_mobile_menu_list.find('li.vu_search-menu-item').remove();

		$vu_mobile_menu_list.appendTo( $vu_mobile_menu );
		$vu_mobile_menu.appendTo( $('.vu_main-container') );
		$vu_mobile_menu.prepend( '<div class="text-right"><a href="#" class="vu_mm-toggle vu_mm-remove"><i class="vu_fi vu_fi-cancel-button"></i></a></div>' );

		$(document).on('click', '.vu_mm-toggle', function(e){
			e.preventDefault();

			$('body').toggleClass('vu_no-scroll');
			$('.vu_mobile-menu').fadeToggle();
		});

		// Performs a smooth page scroll to an anchor on the same page
		$(document.body).on('click', 'a[href*="#"]:not([href="#"]):not([id="cancel-comment-reply-link"]):not([class*="vu_not-smooth-scroll"])', function(){
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
				var target = $(this.hash);

				target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

				if (target.length) {
					if( $('.vu_mobile-menu').is(':visible') ){
						$('body').removeClass('vu_no-scroll');
						$('.vu_mobile-menu').fadeOut();
					}

					var offset = target.offset().top;
					
					offset -= parseInt( $('#wpadminbar').outerHeight() ) || 0;

					$('html,body').stop().animate({
						scrollTop: offset
					}, 800);
					return false;
				}
			}
		});
		
		// Replace all SVG images with inline SVG
		$('img[src$=".svg"]').each(function(){
			var $img = $(this);
			var imgID = $img.attr('id');
			var imgClass = $img.attr('class');
			var imgURL = $img.attr('src');

			$.get(imgURL, function(data) {
				// Get the SVG tag, ignore the rest
				var $svg = $(data).find('svg');

				// Add replaced image's ID to the new SVG
				if(typeof imgID !== 'undefined') {
					$svg = $svg.attr('id', imgID);
				}
				// Add replaced image's classes to the new SVG
				if(typeof imgClass !== 'undefined') {
					$svg = $svg.attr('class', imgClass+' replaced-svg');
				}

				// Remove any invalid XML tags as per http://validator.w3.org
				$svg = $svg.removeAttr('xmlns:a');

				// Replace image with new SVG
				$img.replaceWith($svg);

			}, 'xml');
		});

		// Submit forms via ajax
		var $vu_frm_ajax = $('.vu_frm-ajax');

		$vu_frm_ajax.on('submit', function(e){
			e.preventDefault();

			var $form = $(this),
				$progress = $form.find('.vu_progress'),
				$msg = $form.find('.vu_msg'),
				msg_class = (' ' + $msg.data('class')) || '';
			
			$progress.removeClass('hide');
			$msg.html('');

			$.ajax({
				url: dentalpress_config.ajaxurl,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: $form.serialize(),
				success: function(data) {
					$progress.addClass('hide');

					if(data.status !== 'error'){
						$msg.html('<div class="alert alert-success'+ msg_class +'"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>'+ data.title +'</strong> '+ data.msg +'</div>');

						if( $form.hasClass('vu_clear-fields') ){
							$form.find('input[type="text"], select, textarea').val('');
						}

						if(data.redirect){
							window.location = data.redirect;
						}
					} else {
						$msg.html('<div class="alert alert-danger'+ msg_class +'"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>'+ data.title +'</strong> '+ data.msg +'</div>');
					}

					$form.find('[data-focus]').focus();
				}
			});
		});

		// Columns
		var $vu_columns = $('.vu_column[class*="vu_c-layout-stretch"]');

		$vu_columns.each(function() {
			var $this = $(this),
				$parent = $this.parent('.vu_r-content'),
				$content = $this.find('> .vu_c-wrapper').clone(true, true),
				position = $this.hasClass('vu_c-layout-stretch-left') ? 'left' : 'right';

			$content.attr({'class' : 'vu_clone vu_c-stretch-'+ position}).insertBefore($parent);
		});

		// Social Share
		var $vu_social_links = $('.vu_social-link');

		$vu_social_links.on('click', function(e){
			e.preventDefault();

			window.open( $(this).data('href'), "_blank", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0" ) 
			
			return false;
		});

		// Magnific Popup - http://dimsemenov.com/plugins/magnific-popup/
		var $vu_lightbox = $('.vu_lightbox, a[href*="lightbox=true"]');

		$vu_lightbox.each(function(){
			var $this = $(this);

			if( String($this.attr('href')).indexOf('lightbox=true') != -1 ){
				try {
					$this.magnificPopup({
						type: 'iframe',
						mainClass: "mfp-zoom-in",
						iframe: {
							markup: '<div class="mfp-iframe-scaler">'+
										'<div class="mfp-close"></div>'+
										'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
										'<div class="mfp-title"></div>'+
									'</div>'
						},
						callbacks: {
							markupParse: function(template, values, item) {
								try {
									var hash = item.el.attr('href').replace(/^.*?#/,''),
										params = JSON.parse('{"' + decodeURI(hash).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"') + '"}');

									values.title = (typeof params.title !== 'undefined') ? params.title : item.el.text();
								} catch(err) {}
							},
							beforeAppend: function() {
								var interval = setInterval(function() {
									if( $('iframe').length !== 0 ) {
										$('.mfp-content').hide();
										$('.mfp-preloader').show();

									}
								}, 50);
								this.content.find('iframe').on('load', function() {
									clearInterval(interval);
									$('.mfp-content').show();
									$('.mfp-preloader').hide();
								});
							}
						},
						closeBtnInside: false,
						closeMarkup: '<button title="%title%" type="button" class="mfp-close"></button>',
						removalDelay: 400
					});
				} catch(err) {}
			} else if( $this.hasClass('vu_l-gallery') ){
				try {
					$this.magnificPopup({
						delegate: $this.data('delegate') || 'a',
						type: 'image',
						mainClass: "mfp-zoom-in",
						gallery: {
							enabled: true,
							navigateByImgClick: true,
							preload: [0,1] // Will preload 0 - before current, and 1 after the current image
						},
						closeBtnInside: false,
						closeMarkup: '<button title="%title%" type="button" class="mfp-close"></button>',
						removalDelay: 400
					});
				} catch(err) {}
			} else {
				try {
					$this.magnificPopup({
						type: ($this.data('type') == undefined) ? 'image' : $this.data('type'),
						mainClass: "mfp-zoom-in",
						closeBtnInside: false,
						closeMarkup: '<button title="%title%" type="button" class="mfp-close"></button>',
						removalDelay: 400
					});
				} catch(err) {}
			}
		});

		// Latest Tweets
		var $vu_latest_tweets = $(".vu_latest-tweets");

		$vu_latest_tweets.each(function(){
			var $this = $(this);

			try {
				$this.tweet({
					username: $this.data("user"),
					avatar_size: ($this.data("avatarsize") == undefined) ? 90 : $this.data("avatarsize"),
					count: ($this.data("count") == undefined) ? 3 : $this.data("count"),
					loading_text: ($this.data("text") == undefined) ? null : $this.data("text"),
					modpath: ($this.data("modpath") == undefined) ? dentalpress_config.ajaxurl : $this.data("modpath"),
					action: ($this.data("action") == undefined) ? null : $this.data("action"),
					join_text: false
				});
			} catch(err) {}
		});

		// Facebook Like Box widget
		try {
			var $vu_facebook_like_box_widget = $(".vu_fb-like-box-container");

			$vu_facebook_like_box_widget.each(function(e){
				$(this).html('<iframe src="http://www.facebook.com/plugins/likebox.php?href='+ encodeURIComponent($(this).data('href')) +'&amp;width='+ $(this).data('width') +'&amp;colorscheme='+ $(this).data('colorscheme') +'&amp;show_faces='+ $(this).data('show-faces') +'&amp;show_border='+ $(this).data('show-border') +'&amp;stream='+ $(this).data('stream') +'&amp;header='+ $(this).data('header') +'&amp;height='+ $(this).data('height') +'" allowtransparency="true" style="height: '+ $(this).data('height') +'px;"></iframe>');
			});
		} catch(err) {}

		// Flickr widget
		var $vu_flickr = $(".vu_flickr-photos");

		$vu_flickr.each(function(){
			var $this = $(this),
				user = $this.data("user"),
				limit = $this.data("limit");
			try {
				$this.jflickrfeed({
					limit: limit,
					qstrings: {
						id: user
					},
					itemTemplate: '<span><a href="{{image_b}}" title="{{title}}"><img src="{{image_s}}"></a></span>'
				});
			} catch(err) {}
		});

		// Comment Form
		var $vu_comment_reply_link = $('#comments a.vu_c-a-reply-link');

		$vu_comment_reply_link.on('click', function(e){
			e.preventDefault();

			var id = $(this).data('id'),
				$appendTo = $(this).parents('article#comment-'+ id),
				$comment_form = $('#respond').clone();

			$('#respond').remove();

			$comment_form.addClass('m-t-30 m-b-30').find('a#cancel-comment-reply-link').show();
			$comment_form.find('input#comment_parent').val(id);
			$comment_form.appendTo( $appendTo );
		});

		$(document).on('click', '#respond a#cancel-comment-reply-link', function(e){
			e.preventDefault();

			var $comment_form = $('#respond').clone();

			$('#respond').remove();

			$comment_form.removeClass('m-t-30').removeClass('m-b-30').find('a#cancel-comment-reply-link').hide();
			$comment_form.find('input#comment_parent').val('0');
			$comment_form.appendTo( $('div#comments.vu_comments') );
		});

		// Carousels - http://owlgraphic.com/owlcarousel/index.html
		var $vu_carousels = $('.vu_carousel');

		$vu_carousels.each(function(){
			var $this = $(this),
				options = $this.data('options'),
				$carousel = ($this.data('owl') == undefined) ? $this : $this.find( $this.data('owl') );

			options['afterUpdate'] = function(){
				var owl = $this.data('owlCarousel');

				$this.attr({'data-items': owl.visibleItems.length});

				//Add extra class for last active element
				$this.find('.owl-item').removeClass('last');
				$this.find('.owl-item.active').last().addClass('last');
			}

			options['afterMove'] = function(){
				//Add extra class for last active element
				$this.find('.owl-item').removeClass('last');
				$this.find('.owl-item.active').last().addClass('last');

				if( options.autoHeight === true ) {
					//$(window).wait(300).trigger('resize.px.parallax');
				}
			}
			
			if( $('body').hasClass('rtl') ) {
				options.rtl = true;

				options.dragBeforeAnimFinish = false;
				options.mouseDrag = false;
				options.touchDrag = false;
			}

			try {
				$carousel.imagesLoaded(function(){
					$carousel.owlCarousel(options);
					$carousel.attr({'data-items': $carousel.find('.owl-wrapper .owl-item.active').length});
					$carousel.find('.owl-wrapper .owl-item.active').last().addClass('last');
				});
			} catch(err) {}
		});

		// Accordions
		var $vu_accordion = $('.vu_accordion');

		$vu_accordion.each(function() {
			var $this = $(this),
				$icons = $this.find('.vu_a-wrapper .ui-state-default .ui-icon');

			$icons.append('<i class="vu_a-inactive-icon vu_fi vu_fi-plus-1"></i><i class="vu_a-active-icon vu_fi vu_fi-minus-1"></i>');
		});

		// Contact Form 7
		var $vu_wcf7_ajax_loader = $('div.wpcf7 .ajax-loader');

		$vu_wcf7_ajax_loader.each(function(){
			var $this = $(this),
				$parent = $this.parent(),
				$input = $parent.children('input[type="submit"]');

			if( $parent.hasClass('text-right') || $input.hasClass('btn-block') ) {
				$this.insertBefore($input);
			}
		});

		// CF7 - Select input
		var $vu_wcf7_select_input = $('.wpcf7-form .wpcf7-form-control.wpcf7-select');

		$vu_wcf7_select_input.on('change', function() {
			var $this = $(this),
				value = $this.val();

			if ( value == '' ) {
				$this.addClass('vu_default-value');
			} else {
				$this.removeClass('vu_default-value');
			}
		});

		// CF7 - File input
		$vu_wcf7_select_input.each(function() {
			$(this).trigger('change');
		});

		var $vu_wcf7_file_input = $('.wpcf7-form .wpcf7-form-control.wpcf7-file');

		$vu_wcf7_file_input.on('change', function() {
			var $this = $(this),
				id = $this.attr('id'),
				$label = $this.parents('.wpcf7-form').find('label[for="'+ id +'"]'),
				filename = $this.val().replace(/C:\\fakepath\\/i, '');

			if ( filename == '' ) {
				filename = 'No file chosen';
			}

			$label.text(filename);
		});
		
		$('.wpcf7-response-output').on('click', function() {
			$(this).hide();
		});

		// Pie Chart
		var $vu_pie_charts = $('.vu_pie-chart .vu_pc-graph');

		$vu_pie_charts.each(function(){
			var $this = $(this),
				options = $this.data('options');

			$this.one('inview', function(event, visible){
				try {
					$this.easyPieChart(options);
				} catch(err) {}
			});
		});

		// Progress bar
		var $vu_progress_bar = $('.vu_progress-bar');

		$vu_progress_bar.each(function(){
			var $this = $(this),
				value = $this.data('value');

			$this.one('inview', function(event, visible){
				try {
					$this.find('.vu_pb-bar').css({'width': value +'%'});
				} catch(err) {}
			});
		});

		//Load image with lazy load
		var $vu_lazy_load = $('.vu_lazy-load');

		$vu_lazy_load.each(function(){
			var $this = $(this),
				img = $this.data('img') || false;

			if( img != false ) {
				$('<img/>').attr('src', img).load(function() {
					$(this).remove();
					$this.css('background-image', 'url('+ img +')');
					$this.addClass('vu_img-loaded');
				});
			}
		});

		// Counter
		var $vu_counter = $('.vu_counter .vu_c-digit');

		$vu_counter.each(function(){
			var $this = $(this),
				delay = parseInt($this.data('delay')) || 0;

			$this.wait(delay).one('inview', function(event, visible){
				try {
					$this.counterUp({
						delay: 10,
						time: ($this.data('time') == undefined) ? 1000 : $this.data('time')
					});
				} catch(err) {}
			});
		});

		// Countdown
		var $vu_countdown = $('.vu_countdown');

		$vu_countdown.each(function(){
			var date = $(this).data('date'),
				format = $(this).data('format');
			try	{
				$(this).countdown({
					until: new Date( date ),
					padZeroes: true,
					format: format
				});
			} catch(err) {}
		});

		//Datepicker - http://api.jqueryui.com/datepicker/
		var $vu_datepicker = $('.vu_datepicker');

		$vu_datepicker.each(function(){
			var $this = $(this),
				options = $this.data('options') || {
					firstDay: 1,
					minDate: 0,
					dateFormat: 'dd/mm/yy'
				};

			try {
				$this.datepicker(options);
			} catch(err) {}
		});
		
		// Add custom wrap from date & time picker
		$vu_datepicker.datepicker('widget').wrap('<div class="vu_datepicker-wrap"/>');

		//Timepicker - http://api.jqueryui.com/datepicker/ (Modified)
		var $vu_timepicker = $('.vu_timepicker');

		$vu_timepicker.each(function(){
			var $this = $(this),
				options = $this.data(options) || {};

			try {
				$this.timepicker(options);
			} catch(err) {}
		});
		
		// Add custom class for default WP Calendar Widget
		$('.vu_sidebar .widget_calendar #calendar_wrap table#wp-calendar').addClass('table table-striped');
		$('.vu_main-footer .widget_calendar #calendar_wrap table#wp-calendar').addClass('table');

		// Add custom class for tables
		$('body:not(.woocommerce-page) table:not(.booked-calendar)').addClass('table');

		// Add custom class for input classes in widget
		$('.widget input').addClass('form-control');
		$('.widget select').addClass('form-control');
		$('.widget textarea').addClass('form-control');
		
		// Animations
		var $vu_animations = $('*[data-animation]');

		$vu_animations.each(function(){
			$(this).one('inview', function(event, visible){
				var $this = $(this),
					animation = $this.data('animation'),
					delay = parseInt($this.data('delay')) || false;

				if( delay != false ){
					$this.wait(delay).addClass('vu_with-animation').animateCss(animation);
				} else {
					$this.addClass('vu_with-animation').animateCss(animation);
				}
			});
		});

		// Video Background
		var $vu_bg_videos = $('.vu_row .vu_r-wrapper.vu_r-bg-video');

		$vu_bg_videos.each(function() {
			$(this).YTPlayer();
		});

		// Post Pasword Form
		var $post_password_form = $('form.post-password-form');

		if( $post_password_form.length ) {
			var $ppf_label = $post_password_form.find('label[for^="pwbox-"]'),
				$ppf_input = $post_password_form.find('input[name="post_password"]'),
				$ppf_button = $post_password_form.find('input[type="submit"]');

			$ppf_input.addClass('form-control').attr({ 'placeholder': $ppf_label.text().replace(':', '').trim() });
			$ppf_label.remove();
			$ppf_input.insertBefore( $ppf_button );
			$ppf_button.addClass('btn btn-primary btn-inverse btn-md');

			try {
				$post_password_form.wait(400).css({'opacity': 1});
			} catch (err) {}
		}

		// Tabs - Position Bottom
		var $vu_tabs_nav_bottom = $('.vu_tabs.vu_t-nav-bottom .ui-tabs');

		$vu_tabs_nav_bottom.each(function(){
			var $this = $(this);

			$this.find('.vu_t-nav').appendTo($this);
		});
		
		// Lists with custom icon
		var $vu_list_with_custom_icon = $('.vu_list-with-icon[data-icon]');

		$vu_list_with_custom_icon.each(function() {
			$(this).find('li').attr({'data-icon': $(this).data('icon')});
		});
		
		// Before & After
		var $vu_before_after = $('.vu_before-after');

		$vu_before_after.each(function(){
			var $this = $(this),
				options = $this.data('options');

			try	{
				$this.twentytwenty(options);

				$this.parent('.twentytwenty-wrapper').addClass('vu_before-after-wrapper');
				$this.prepend('<div class="embed-responsive embed-responsive-'+ options.ratio.replace(':', 'by') +'"></div>');

				if( typeof options.before_label !== 'undefined' ) {
					$this.find('.twentytwenty-before-label').text(options.before_label)
				}

				if( typeof options.after_label !== 'undefined' ) {
					$this.find('.twentytwenty-after-label').text(options.after_label)
				}
			} catch(err){}
		});

		// Youtube Video Player
		if( !window['YT'] ) {
			var player_api = document.createElement("script");
			player_api.src = "https://www.youtube.com/player_api";
			$("head").append(player_api);
		}

		window.onYouTubePlayerAPIReady = function() {
			var $vu_video_player = $(".vu_video-section .vu_vs-player"),
				vu_video_players = [];

			$vu_video_player.each(function() {
				var $this = $(this),
					element_id = $this.attr('id'),
					options = $this.data('options');

				if( options.play_type == 'normal' || options.play_type == 'scroll' ) {
					$('#'+ $this.attr('id')).hide();
				}

				$this.parents('.vu_video-section').find('.vu_vs-play').on('click', function(e) {
					e.preventDefault();

					$('#'+ element_id).show();
					vu_video_players[options._id].playVideo();
				});

				vu_video_players[options._id] = new YT.Player(element_id, {
					width: '0',
					height: '0',
					videoId: options.video_id,
					playerVars: {
						autoplay : ( options.play_type == 'autoplay' ) ? 1 : 0,
						loop : ( options.loop == '1' ) ? 1 : 0,
						controls : ( options.controls == '1' ) ? 1 : 0,
						rel : ( options.rel == '1' ) ? 1 : 0,
						showinfo : ( options.showinfo == '1' ) ? 1 : 0
					},
					events: {
						onReady: onPlayerReady,
						onStateChange: onPlayerStateChange
					}
				});

				function onPlayerReady(event) {
					if( options.video_mute == '1' ) {
						event.target.mute();
					}
				}

				function onPlayerStateChange(event) {
					if( (options.play_type == 'normal' || options.play_type == 'autoplay') && !isPlayerFullScreen() ) {
						if( event.data == 2 ) {
							$('#'+ element_id).hide();
						} else {
							$('#'+ element_id).show();
						}
					}
				}

				function isPlayerFullScreen() {
					var fullscreenElement = document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement;

					return (fullscreenElement != null) ? true : false;
				}
			});

			$('.vu_video-section[data-play="scroll"]').on('inview', function(event, isInView) {
				var $this = $(this).find('.vu_vs-player'),
					element_id = $this.attr('id'),
					options = $this.data('options');

				if( options.play_type == 'scroll' ) {
					if (isInView) {
						if( typeof vu_video_players[options._id] !== 'undefined' && typeof vu_video_players[options._id].playVideo === 'function' ) {
							$('#'+ element_id).show();
							vu_video_players[options._id].playVideo();
						}
					} else {
						if( typeof vu_video_players[options._id] !== 'undefined' && typeof vu_video_players[options._id].playVideo === 'function' ) {
							$('#'+ element_id).hide();
							vu_video_players[options._id].pauseVideo();
						}
					}
				}
			});
		}

		// Back to top
		$('.vu_back-to-top').on('click', function(e) {
			e.preventDefault();
			$('html,body').stop().animate({scrollTop: 0}, 800);
		});

		// Generate Custom CSS for Gallery (if has custom gutter)
		var $vu_gallery = $('.vu_gallery[data-space]'),
			vu_gallery_style = '';

		$vu_gallery.each(function(){
			var $this = $(this),
				space = parseInt($this.attr('data-space')) || 30,
				space_half = parseFloat(space / 2),
				vu_gallery_custom_class = 'vu_custom_'+ Math.floor((Math.random() * 10000) + 1);

			// Default & Masonry Type
			if( $this.hasClass('vu_g-type-standard') || $this.hasClass('vu_g-type-masonry') ) {
				vu_gallery_style += '.vu_gallery.'+ vu_gallery_custom_class +' .vu_g-items{margin:-'+ space_half +'px!important;}';
				vu_gallery_style += '.vu_gallery.'+ vu_gallery_custom_class +' .vu_g-item{padding:'+ space_half +'px!important;}';
			}

			// Masonry Type
			if( $this.hasClass('vu_g-type-masonry') ) {
				vu_gallery_style += '@media (min-width: 480px) {';
				vu_gallery_style += '.vu_gallery.'+ vu_gallery_custom_class +' .vu_g-item[data-size="1x2"] .vu_gallery-item{padding-bottom:calc(200% + '+ space +'px)!important;}';
				vu_gallery_style += '.vu_gallery.'+ vu_gallery_custom_class +' .vu_g-item[data-size="2x1"] .vu_gallery-item{padding-bottom:calc(50% - '+ space_half +'px)!important;}';
				vu_gallery_style += '}';
			}

			// Carousel Type
			if( $this.hasClass('vu_g-type-carousel') ) {
				vu_gallery_style += '.vu_gallery.'+ vu_gallery_custom_class +'{margin-left:-'+ space_half +'px!important;margin-right:-'+ space_half +'px!important;}';
				vu_gallery_style += '.vu_gallery.'+ vu_gallery_custom_class +' .owl-item{padding-left:'+ space_half +'px!important;padding-right:'+ space_half +'px!important;}';
			}

			$this.addClass(vu_gallery_custom_class);
		});

		$('head').append('<style id="vu_custom_css_for_vu_gallery">'+ vu_gallery_style +'</style>');

		// Google Maps
		var vu_maps = function() {
			var $vu_maps = $('.vu_map');
		
			$vu_maps.each(function(){
				try {
					google.maps.event.addDomListener(window, 'load', vu_map_initialize($(this)));
				} catch(err) {}
			});
		}

		if (typeof google === 'object' && typeof google.maps === 'object') {
			vu_maps();
		} else {
			$.getScript('//maps.googleapis.com/maps/api/js?v=3.26'+ ((dentalpress_config.google_maps_api_key !== '') ? '&key='+ dentalpress_config.google_maps_api_key : ''), function() {
				vu_maps();
			});
		}

		// Working Hours
		var $vu_working_hours = $('.vu_working-hours');

		$vu_working_hours.each(function() {
			var $this = $(this),
				weekday = new Date().getDay();

			$this.find('.vu_wh-item').removeClass('active');

			$this.find('.vu_wh-item[data-day="'+ weekday +'"]').addClass('active');
		});

		// Comments Pagination
		if ( !$('.vu_c-pagination .vu_c-p-item').length ) {
			$('.vu_c-pagination').hide();
		}

		// Min Content Height
		$('.vu_nav-position-sidebar .vu_content[role="main"]').css({'min-height': $('.vu_main-navigation-container').outerHeight() });

		// Quote Post
		$('.vu_posts-page .vu_blog-post.vu_bp-type-quote blockquote').addClass('vu_bp-q-content')
		$('.vu_posts-page .vu_blog-post.vu_bp-type-quote blockquote').wrap('<div class="vu_bp-quote"/>');
	});

	// Preloader
	$(window).on('load', function() {
		try {
			$('body').imagesLoaded(function(){
				$('#vu_preloader').fadeOut();
			});
		} catch(err) {}
	});

	$(window).on('beforeunload', function() {
		$('#vu_preloader').fadeIn();
	});

	$(window).on('load', function() {
		// Before / After
		$(window).trigger("resize.twentytwenty");

		// Filterable
		var $vu_filterable = $('.vu_filterable');

		$vu_filterable.each(function() {
			var $this = $(this).find('.vu_f-items'),
				options = {
					itemSelector: '.vu_f-item',
					filter: '*',
					layoutMode: 'packery'
				},
				$filter = $this.parents('.vu_filterable').find('.vu_f-filters .vu_f-filter');

			try {
				$this.isotope(options);
			} catch(err) {}

			$filter.on('click', function(e){
				e.preventDefault();

				$filter.removeClass('active');
				$(this).addClass('active');

				try {
					$this.isotope({ filter: $(this).data('filter') }).on('arrangeComplete', function() {
						$(window).trigger('resize.px.parallax');
					});
				} catch(err) {}

				return false;
			});
		});
	});
	
	// Gallery: Masonry Type
	$(window).on('load resize', function() {
		var $vu_gallery = $('.vu_gallery.vu_g-type-masonry');

		$vu_gallery.each(function() {
			var $this = $(this).find('.vu_g-items');

			window.vu_gallery_columns_width = function() {
				var w = $this.width(), 
					columnNum = $this.parents('.vu_gallery').data('layout'),
					columnWidth = 0;

				//Select what will be your porjects columns according to container width
				if (w < 360) {
					columnNum = 1;
				} else if (w < 520) {
					columnNum = 2;
				} else if (w < 768) {
					columnNum = 3;
				}

				columnWidth = parseFloat( w / columnNum ).toFixed(8);

				//Default item width and height
				if( columnNum > 1 ) {
					$this.find('.vu_g-item[data-size="1x1"]').each(function() {
						var $item = $(this), 
							width = columnWidth,
							height = columnWidth;
						$item.css({ width: width, height: height });
					});

					//2x width item width and height
					$this.find('.vu_g-item[data-size="2x1"]').each(function() {
						var $item = $(this), 
							width = columnWidth * 2,
							height = columnWidth;
						$item.css({ width: width, height: height });
					});

					//2x height item width and height
					$this.find('.vu_g-item[data-size="1x2"]').each(function() {
						var $item = $(this), 
							width = columnWidth,
							height = columnWidth * 2;
						$item.css({ width: width, height: height });
					});

					//2x item width and height
					$this.find('.vu_g-item[data-size="2x2"]').each(function() {
						var $item = $(this), 
							width = columnWidth * 2,
							height = columnWidth * 2;
						$item.css({ width: width, height: height });
					});
				} else {
					$this.find('.vu_g-item[data-size]').each(function() {
						var $item = $(this), 
							width = columnWidth,
							height = columnWidth;
						$item.css({ width: width, height: height });
					});
				}

				return columnWidth;
			}

			try {
				$this.isotope({
					itemSelector: '.vu_g-item',
					filter: '*',
					layoutMode: 'packery',
					masonry: {
						columnWidth: window.vu_gallery_columns_width(),
						gutter: 0
					},
					resizable: true
				});
			} catch(err) {}

			// Gallery with filter
			if( $(this).hasClass('vu_g-filterable') ) {
				var $filter = $this.parents('.vu_gallery').find('.vu_g-filters .vu_g-filter');

				$filter.on('click', function(e){
					e.preventDefault();

					$filter.removeClass('active');
					$(this).addClass('active');

					try {
						$this.isotope({ filter: $(this).data('filter') });
					} catch(err) {}

					return false;
				});
			}
		});
	});

	// Map Initialize - https://developers.google.com/maps/documentation/javascript/reference
	function vu_map_initialize(map_element){
		"use strict";

		var $map = map_element,
			options = $map.data('options') || window.vu_map_options,
			element_id = 'map_' + Math.floor((Math.random() * 10000) + 1);

		$map.attr({'id': element_id});

		var mapOptions = { 
			zoom: options.zoom_level.toInteger(),
			center: new google.maps.LatLng(options.center_lat, options.center_lng),
			draggable: options.others_options.draggable.toBoolean(),
			zoomControl: options.others_options.zoomControl.toBoolean(),
			disableDoubleClickZoom: options.others_options.disableDoubleClickZoom.toBoolean(),	
			scrollwheel: options.others_options.scrollwheel.toBoolean(),
			panControl: options.others_options.panControl.toBoolean(),
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.LARGE,
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			mapTypeControl: options.others_options.mapTypeControl.toBoolean(),
			scaleControl: options.others_options.scaleControl.toBoolean(),
			streetViewControl: options.others_options.streetViewControl.toBoolean()
		};

		// Prevent users to start zooming the map when scrolling down the page
		if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			mapOptions.draggable = false;
			mapOptions.scrollwheel = false;
			mapOptions.panControl = true;
		}

		var map = new google.maps.Map(document.getElementById(element_id), mapOptions),
			marker = null,
			infowindows = [];

		switch(options.map_type){
			case "satellite":
				map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
				
				if( options.tilt_45.toBoolean() == true ) {
					map.setTilt(45);
				}
			break;

			case "hybrid":
				map.setMapTypeId(google.maps.MapTypeId.HYBRID);
			break;

			case "terrain":
				map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
			break;
			
			default:
				map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
				map.setOptions({styles: $.parseJSON(options.styles)});
			break;
		}

		for(var i=0; i<options.locations.length; i++){
			marker = new google.maps.Marker({
				index: i,
				map: map,
				position: new google.maps.LatLng(options.locations[i].lat, options.locations[i].lng),
				animation: ( options.enable_animation.toBoolean() == true ) ? google.maps.Animation.BOUNCE : google.maps.Animation.DROP,
				icon: (!options.locations[i].marker_url.isEmpty()) ? options.locations[i].marker_url : ((options.use_custom_marker.toBoolean() == true) ? options.custom_marker : null),
				optimized: false
			});

			if( !options.locations[i].info.isEmpty() ) {
				infowindows[i] = new google.maps.InfoWindow({
					content: options.locations[i].info,
					maxWidth: 200,
					maxHeight: 200
				});

				if ( $map.hasClass('vu_map-open-infowindows-on-click') ) {
					google.maps.event.addListener(marker, 'click', function(){
						for(var i=0; i<options.locations.length; i++){
							try {
								infowindows[i].close();
							} catch (err) {}
						}
						
						infowindows[this.index].open(map, this);
					});
				} else {
					marker.addListener('mouseover', function() {
						infowindows[this.index].open(map, this);
					});

					marker.addListener('mouseout', function() {
						infowindows[this.index].close();
					});
				}
			}
		}

		// Auto center map on resize
		if ( $map.hasClass('vu_map-auto-center') ) {
			google.maps.event.addDomListener(window, 'resize', function() {
				map.setCenter(mapOptions.center);
			});
		}
	}

	// Convert String to Boolean
	String.prototype.toBoolean = function(){
		return (this == "1" || this.toLowerCase() == "true") ? true : false;
	}

	// Convert String to Integer
	String.prototype.toInteger = function(){
		return parseInt(this);
	}

	// Checking if a string is blank or contains only white-space
	String.prototype.isEmpty = function(){
		return (this.length === 0 || !this.trim());
	}
})(jQuery);