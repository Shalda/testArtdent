(function($){
	$(function(){
		// Media frame
		var vu_media_frame;
		
		// Bind to our click event in order to open up the new media experience.
		$(document.body).on('click.vuOpenMediaManager', '.vu_open-media', function(e){
			e.preventDefault();

			var $this = $(this);

			vu_media_frame = wp.media.frames.vu_media_frame = wp.media({
				className: 'media-frame vu_media-frame',
				toolbar: 'main-insert',
				filterable: 'uploaded',
				multiple: $this.hasClass('multiple') ? 'add' : false,
				title: $this.data('title'),
				library: {
					type: ($this.data('type') !== undefined) ? $this.data('type') : 'image'
				},
				button: {
					text: $this.data('button')
				}
			});

			vu_media_frame.on('select', function(){
				if( $this.data('type') === undefined || $this.data('type') === 'image' ){
					if( !$this.hasClass('multiple') ){
						var media_attachment = vu_media_frame.state().get('selection').first().toJSON();

						// Send the attachment URL to our custom input field via jQuery.
						$('#'+ $this.data('input')).val(media_attachment.id);
						$('#'+ $this.data('img')).attr({'src': media_attachment.url});
					} else {
						var media_attachments = vu_media_frame.state().get('selection').toJSON(),
							images_url = [];

						//$('#'+ $this.data('img')).html('');

						$.each(media_attachments, function(index, obj){
							images_url[index] = obj.id;

							var media_url;

							if( obj.sizes.thumbnail !== undefined ){
								media_url = obj.sizes.thumbnail.url;
							} else {
								media_url = obj.sizes.full.url;
							}

							$('#'+ $this.data('img')).append('<div><img data-id="'+ obj.id +'" src="'+ media_url +'"><span>&times;</span></div>');
						});

						$('#'+ $this.data('input')).val(images_url.join(','));
					}
				} else {
					var media_attachment = vu_media_frame.state().get('selection').first().toJSON();

					$('#'+ $this.data('input')).val(media_attachment.url);
				}
			});

			// Now that everything has been set, let's open up the frame.
			vu_media_frame.open();
		});
		
		// Remove Media - Metabox
		var $vu_remove_media = $('.vu_remove-media');

		$vu_remove_media.on('click', function(e){
			e.preventDefault();

			var $this = $(this),
				$input = $('#'+ $this.data('input')),
				$img = $('#'+ $this.data('img'));

			$input.val('');
			$img.attr('src', '');
		});

		// Custom Post Title
		$('label#title-prompt-text').text( $('#vu_title-prompt-text').val() );

		// Change value of select on load
		var $vu_select_change = $('.vu_select-change');

		$vu_select_change.each(function(){
			$(this).val( $(this).data('value') );
		});

		//Dependency
		var $vu_dependency = $('.vu_dependency');

		$vu_dependency.each(function(){
			var $this = $(this),
				$element = $('#'+ $this.data('element')),
				values = String($this.data('value')).split('|');

			if( !$element.length ){
				$element = $('[name="'+ $this.data('element') +'"]');
			}

			//on load
			vu_dependency($this, $element, values);

			$element.on('change', function(){
				vu_dependency($this, $element, values);
			});
		});

		function vu_dependency($this, $element, values) {
			if ( $element.parents('.vu_dependency').is(':hidden') ) {
				$this.hide();
			} else {
				if ( $element.is('input:radio') || $element.is('input:checkbox') ) {
					if( $element.is(':checked') && values.indexOf( String($element.filter(':checked').data('value') || $element.filter(':checked').val()) ) != -1 ) {
						$this.show();
					} else {
						$this.hide();
					}
				} else {
					if( values.indexOf( String($element.find(':selected').data('value') || $element.data('value') || $element.val()) ) != -1 ) {
						$this.show();
					} else {
						$this.hide();
					}
				}
			}

			// multi level dependency
			var $_element = $this.find('[name^="vu_field"]'),
				$_this = $('.vu_dependency[data-element="' + $_element.attr('name') +'"');
			
			if ( $_this.length ) {
				$_element.trigger('change');
			}
		}

		// Order gallery images
		$vu_media_images = $('.vu_media-images');

		$vu_media_images.each(function(){
			var $this = $(this);

			$this.sortable({
				cursor: "move",
				items: "> div",
				opacity: 0.7,
				update: function( event, ui ){
					var images_url = [];

					$this.find('img').each(function(index, value){
						images_url[index] = $(this).data('id');
					});

					$('#'+ $this.data('input')).val(images_url.join(','));
				}
			});
		});

		// Remove image
		$(document.body).on('click', '.vu_media-images span', function(){
			var $container = $(this).parent().parent(),
				images_url = [];

			$(this).parent().remove();

			$container.find('img').each(function(index, value){
				images_url[index] = $(this).data('id');
			});

			$('#'+ $container.data('input')).val(images_url.join(','));
		});

		// Post formats
		var $vu_post_format = $('#post-formats-select input[type="radio"]');
		
		vu_post_format( $vu_post_format.filter(':checked') );

		$vu_post_format.on('change', function(){
			vu_post_format( $(this) );
		});

		function vu_post_format(element){
			var $container = $('#vu_post-format-settings.postbox'),
				input_value = element.val();

			if( input_value != '0' && input_value != 'image' ){
				$container.find('.vu_metabox-container').hide();
				$container.find('.vu_metabox-container[data-format="'+ input_value +'"]').show();
				$container.show();
			} else {
				$container.hide();
			}
		}

		// Gallery
		$(document).ajaxSuccess(function(e, xhr, settings) {
			if( settings.data !== undefined && settings.data.indexOf("action=vc_edit_form") != -1 && settings.data.indexOf("tag=vu_gallery_item") != -1 ) {
				if( vc.shortcodes.get(vc.active_panel.model.attributes.parent_id).get('params').filterable == "1" ) {
					var categories = vc.shortcodes.get(vc.active_panel.model.attributes.parent_id).get('params').categories.split("\n");
						$categories = $('#vc_ui-panel-edit-element[data-vc-shortcode="vu_gallery_item"] .vc_shortcode-param[data-vc-shortcode-param-name="category"] input.category').hide(),
						_categories = $categories.val().split(','),
						$_categories = $('<select multiple class="category"></select>');

					$.each(categories, function(key, value) {
						$_categories
							.append($("<option></option>")
							.attr("value",value)
							.text(value)); 
					});

					//selected
					$.each(_categories, function(key, value){
						$_categories.find('option[value="'+ value +'"]').prop('selected', true);
					});

					$_categories.insertAfter($categories);
				} else {
					$('#vc_ui-panel-edit-element[data-vc-shortcode="vu_gallery_item"] .vc_shortcode-param[data-vc-shortcode-param-name="category"').hide();
				}

				if( vc.shortcodes.get(vc.active_panel.model.attributes.parent_id).get('params').type == "masonry" ) {
					$('#vc_ui-panel-edit-element[data-vc-shortcode="vu_gallery_item"] .vc_shortcode-param[data-vc-shortcode-param-name="ratio"').hide();
				} else {
					$('#vc_ui-panel-edit-element[data-vc-shortcode="vu_gallery_item"] .vc_shortcode-param[data-vc-shortcode-param-name="size"').hide();
				}
			}
		});

		$(document.body).on('change', '#vc_ui-panel-edit-element[data-vc-shortcode="vu_gallery_item"] .vc_shortcode-param[data-vc-shortcode-param-name="category"] select.category', function(){
			$(this).prev('input.category').val($(this).val());
		});

		// Filterable
		$(document).ajaxSuccess(function(e, xhr, settings) {
			if( settings.data !== undefined && settings.data.indexOf("action=vc_edit_form") != -1 && settings.data.indexOf("tag=vu_filterable_item") != -1 ) {
				var categories = vc.shortcodes.get(vc.active_panel.model.attributes.parent_id).get('params').categories.split("\n");
					$categories = $('#vc_ui-panel-edit-element[data-vc-shortcode="vu_filterable_item"] .vc_shortcode-param[data-vc-shortcode-param-name="category"] input.category').hide(),
					_categories = $categories.val().split(','),
					$_categories = $('<select multiple class="category"></select>');

				$.each(categories, function(key, value) {
					$_categories
						.append($("<option></option>")
						.attr("value",value)
						.text(value)); 
				});

				//selected
				$.each(_categories, function(key, value){
					$_categories.find('option[value="'+ value +'"]').prop('selected', true);
				});

				$_categories.insertAfter($categories);
			}
		});

		$(document.body).on('change', '#vc_ui-panel-edit-element[data-vc-shortcode="vu_filterable_item"] .vc_shortcode-param[data-vc-shortcode-param-name="category"] select.category', function(){
			$(this).prev('input.category').val($(this).val());
		});

		// Countdown
		$(document).ajaxSuccess(function(e, xhr, settings) {
			if( settings.data !== undefined && settings.data.indexOf("action=vc_edit_form") != -1 && settings.data.indexOf("tag=vu_countdown") != -1 ) {
				$('#vc_ui-panel-edit-element[data-vc-shortcode="vu_countdown"] input.date.textfield').datepicker({firstDay: 1, minDate: 0, dateFormat: 'yy-mm-dd'});
			}
		});

		// Custom Sidebars
		function vu_custom_sidebars() {	
			$('.redux-container-multi_text[data-id="sidebars"][data-type="multi_text"] .redux-multi-text li input').each(function(){
				var $this = $(this);

				if( $this.val() != '' ) {
					$this.attr({'readonly': 'readonly'});
				}
			});
		}

		vu_custom_sidebars();

		$('#redux_save').on('click', function(){
			vu_custom_sidebars();
		});
	});
})(jQuery);