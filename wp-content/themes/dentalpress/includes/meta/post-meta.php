<?php
/**
 *	DentalPress WordPress Theme
 */

add_action( 'add_meta_boxes', 'dentalpress_post_format_settings_meta_box' );

function dentalpress_post_format_settings_meta_box() {
	add_meta_box(
		'vu_post-format-settings',
		esc_html__('Post Format Settings', 'dentalpress'),
		'dentalpress_post_format_settings_meta_box_content',
		'post',
		'normal',
		'core'
	);
}

function dentalpress_post_format_settings_meta_box_content() {
	global $post;

	//Get Post Format Settings
	$dentalpress_post_format_settings = dentalpress_get_post_meta( $post->ID, 'dentalpress_post_format_settings' );

	wp_nonce_field( 'vu_metabox_nonce', 'vu_metabox_nonce' ); ?>
	
	<!-- Audio Settings -->
	<div class="vu_metabox-container" data-format="audio">
		<table class="form-table vu_metabox-table">
			<tr class="vu_bt-none">
				<td scope="row">
					<label for="vu_field_audio-mp3-file-url"><?php esc_html_e('MP3 File URL', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Enter the URL of the .mp3 file', 'dentalpress'); ?></span>
				</td>
				<td><input id="vu_field_audio-mp3-file-url" name="vu_field[dentalpress_post_format_settings][audio][mp3-file-url]" class="regular-text" type="text" value="<?php echo esc_url($dentalpress_post_format_settings['audio']['mp3-file-url']); ?>" /></td>
			</tr>
			<tr>
				<td scope="row">
					<label for="vu_field_audio-oga-file-url"><?php esc_html_e('OGA File URL', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Enter the URL of the .ogg or .oga file', 'dentalpress'); ?></span>
				</td>
				<td><input id="vu_field_audio-oga-file-url" name="vu_field[dentalpress_post_format_settings][audio][oga-file-url]" class="regular-text" type="text" value="<?php echo esc_url($dentalpress_post_format_settings['audio']['oga-file-url']); ?>" /></td>
			</tr>
		</table>
	</div>
	<!-- /Audio Settings -->
	
	<!-- Video Settings -->
	<div class="vu_metabox-container" data-format="video">
		<table class="form-table vu_metabox-table">
			<tr class="vu_bt-none">
				<td scope="row">
					<label for="vu_field_video-m4v"><?php esc_html_e('M4V File URL', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php echo wp_kses( __('Please upload the .m4v video file.<br><b>You must include both formats.</b>', 'dentalpress'), array('br' => array(), 'b' => array()) ); ?></span>
				</td>
				<td>
					<input id="vu_field_video-m4v" name="vu_field[dentalpress_post_format_settings][video][m4v]" class="regular-text" style="margin: 0 0 10px 0;" type="text" value="<?php echo esc_url($dentalpress_post_format_settings['video']['m4v']); ?>" /><br>
					<a href="#" data-input="vu_field_video-m4v" data-title="<?php esc_attr_e('Choose a File', 'dentalpress'); ?>" data-button="<?php esc_attr_e('Select File', 'dentalpress'); ?>" data-type="video" class="vu_open-media button button-default"><?php esc_html_e('Add Media', 'dentalpress'); ?></a>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label for="vu_field_video-ogg"><?php esc_html_e('OGV File URL', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php echo wp_kses( __('Please upload the .ogv video file<br><b>You must include both formats.</b>', 'dentalpress'), array('br' => array(), 'b' => array()) ); ?></span>
				</td>
				<td>
					<input id="vu_field_video-ogg" name="vu_field[dentalpress_post_format_settings][video][ogg]" class="regular-text" style="margin: 0 0 10px 0;" type="text" value="<?php echo esc_url($dentalpress_post_format_settings['video']['ogg']); ?>" /><br>
					<a href="#" data-input="vu_field_video-ogg" data-title="<?php esc_attr_e('Choose a File', 'dentalpress'); ?>" data-button="<?php esc_attr_e('Select File', 'dentalpress'); ?>" data-type="video" class="vu_open-media button button-default"><?php esc_html_e('Add Media', 'dentalpress'); ?></a>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label for=""><?php esc_html_e('Preview Image', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Image should be at least 800px wide. Click the "Upload" button to begin uploading your image, followed by "Select File" once you have made your selection. Only applies to self hosted videos.', 'dentalpress'); ?></span>
				</td>
				<td>
					<img id="vu_img_video-poster" class="vu_media-img" src="<?php echo esc_url($dentalpress_post_format_settings['video']['poster']); ?>">
					<input id="vu_field_video-poster" name="vu_field[dentalpress_post_format_settings][video][poster]" class="regular-text" type="hidden" value="<?php echo esc_url($dentalpress_post_format_settings['video']['poster']); ?>" />
					<a href="#" data-input="vu_field_video-poster" data-img="vu_img_video-poster" data-title="<?php esc_attr_e('Add Image', 'dentalpress'); ?>" data-button="<?php esc_attr_e('Add Image', 'dentalpress'); ?>" class="vu_open-media button button-default"><?php esc_html_e('Upload', 'dentalpress'); ?></a>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label for="vu_field_video-embed-code"><?php esc_html_e('Embed Video', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php echo esc_html__('Enter the Vimeo or Youtube video embed URL here.', 'dentalpress'); ?></span>
				</td>
				<td>
					<textarea name="vu_field[dentalpress_post_format_settings][video][embed-code]" id="vu_field_video-embed-code" rows="7"><?php echo esc_url($dentalpress_post_format_settings['video']['embed-code']); ?></textarea>
				</td>
			</tr>
		</table>
	</div>
	<!-- Video Settings -->
	
	<!-- Gallery Settings -->
	<div class="vu_metabox-container" data-format="gallery">
		<table class="form-table vu_metabox-table">
			<tr class="vu_bt-none">
				<td scope="row">
					<label><?php esc_html_e('Gallery', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Click the "Upload" button to begin uploading your images, followed by "Add Images" once you have made your selection.', 'dentalpress'); ?></span>
				</td>
				<td>
					<div id="vu_img_gallery-images" data-input="vu_field_gallery-images" class="vu_media-images">
						<?php 
							$gallery_images = !empty($dentalpress_post_format_settings['gallery']['images']) ? explode(',', $dentalpress_post_format_settings['gallery']['images']) : '';

							if( !empty($gallery_images) ){
								foreach ($gallery_images as $img_id) {
									echo '<div><img data-id="'. $img_id .'" src="'. dentalpress_get_attachment_image_src($img_id) .'"><span>&times;</span></div>';
								}
							}
						?>
					</div>

					<input id="vu_field_gallery-images" name="vu_field[dentalpress_post_format_settings][gallery][images]" class="regular-text" type="hidden" value="<?php echo esc_attr($dentalpress_post_format_settings['gallery']['images']); ?>" />
					<a href="#" data-input="vu_field_gallery-images" data-title="<?php esc_attr_e('Add Images', 'dentalpress'); ?>" data-button="<?php esc_attr_e('Add Images', 'dentalpress'); ?>" data-img="vu_img_gallery-images" class="vu_open-media multiple button button-default"><?php esc_html_e('Upload', 'dentalpress'); ?></a>
				</td>
			</tr>
		</table>
	</div>
	<!-- Gallery Settings -->
	
	<!-- Link Settings -->
	<div class="vu_metabox-container" data-format="link">
		<table class="form-table vu_metabox-table">
			<tr class="vu_bt-none">
				<td scope="row">
					<label for="vu_field_link-url"><?php esc_html_e('Link URL', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Please input the URL. i.e. http://www.flexipress.xyz', 'dentalpress'); ?></span>
				</td>
				<td><input id="vu_field_link-url" name="vu_field[dentalpress_post_format_settings][link][url]" class="regular-text" type="text" value="<?php echo esc_url($dentalpress_post_format_settings['link']['url']); ?>" /></td>
			</tr>
		</table>
	</div>
	<!-- /Link Settings -->
	
	<!-- Quote Settings -->
	<div class="vu_metabox-container" data-format="quote">
		<table class="form-table vu_metabox-table">
			<tr class="vu_bt-none">
				<td scope="row">
					<label for="vu_field_quote-content"><?php esc_html_e('Quote Content', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Please enter your quote here.', 'dentalpress'); ?></span>
				</td>
				<td>
					<textarea name="vu_field[dentalpress_post_format_settings][quote][content]" id="vu_field_quote-content" class="regular-text" rows="7"><?php echo esc_attr($dentalpress_post_format_settings['quote']['content']); ?></textarea>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label for="vu_field_quote-author"><?php esc_html_e('Quote Author', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Please enter the qoute author.', 'dentalpress'); ?></span>
				</td>
				<td><input id="vu_field_quote-author" name="vu_field[dentalpress_post_format_settings][quote][author]" class="regular-text" type="text" value="<?php echo (isset($dentalpress_post_format_settings['quote']['author'])) ? esc_attr($dentalpress_post_format_settings['quote']['author']) : ''; ?>" /></td>
			</tr>
		</table>
	</div>
	<!-- /Quote Settings -->
	
	<!-- Aside Settings -->
	<div class="vu_metabox-container" data-format="aside">
		<table class="form-table vu_metabox-table">
			<tr class="vu_bt-none">
				<td scope="row">
					<label for="vu_field_aside-content"><?php esc_html_e('Aside Content', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Please enter the text for your aside here.', 'dentalpress'); ?></span>
				</td>
				<td>
					<textarea name="vu_field[dentalpress_post_format_settings][aside][content]" id="vu_field_aside-content" class="regular-text" rows="5"><?php echo esc_attr($dentalpress_post_format_settings['aside']['content']); ?></textarea>
				</td>
			</tr>
		</table>
	</div>
	<!-- /Aside Settings -->
<?php
}