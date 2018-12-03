<?php
/**
 *	DentalPress WordPress Theme
 */

add_action( 'add_meta_boxes', 'dentalpress_page_options_meta_box' );

function dentalpress_page_options_meta_box() {
	add_meta_box(
		'vu_page-options',
		esc_html__( 'Page Options', 'dentalpress' ),
		'dentalpress_page_options_meta_box_content',
		'page',
		'normal',
		'core'
	);
}

function dentalpress_page_options_meta_box_content() {
	global $post;

	//Get Page Options
	$dentalpress_page_options = dentalpress_get_post_meta( $post->ID, 'dentalpress_page_options' );

	wp_nonce_field( 'vu_metabox_nonce', 'vu_metabox_nonce' ); ?>

	<div class="vu_metabox-container">
		<table class="form-table vu_metabox-table">
			<tr class="vu_bt-none">
				<td scope="row">
					<label for="vu_field_header-show"><?php esc_html_e('Show Page Header?', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Check this option to show page header.', 'dentalpress'); ?></span>
				</td>
				<td>
					<label for="vu_field_header-show-yes" style="margin-right: 15px;"><input type="radio" name="vu_field[dentalpress_page_options][header]" id="vu_field_header-show-yes" value="yes" <?php echo (empty($dentalpress_page_options['header']) || $dentalpress_page_options['header'] == 'yes') ? 'checked="checked"' : ''; ?>><?php esc_html_e('Yes', 'dentalpress'); ?></label>
					<label for="vu_field_header-show-no" style="margin-right: 15px;"><input type="radio" name="vu_field[dentalpress_page_options][header]" id="vu_field_header-show-no" value="no" <?php echo (empty($dentalpress_page_options['header']) || $dentalpress_page_options['header'] == 'no') ? 'checked="checked"' : ''; ?>><?php esc_html_e('No', 'dentalpress'); ?></label>
					<label for="vu_field_header-show-inherit" style="margin-right: 15px;"><input type="radio" name="vu_field[dentalpress_page_options][header]" id="vu_field_header-show-inherit" value="inherit" data-value="<?php echo dentalpress_get_option('page-header-show'); ?>" <?php echo (empty($dentalpress_page_options['header']) || $dentalpress_page_options['header'] == 'inherit') ? 'checked="checked"' : ''; ?> ><?php esc_html_e('Inherit from Theme Options', 'dentalpress'); ?></label>
				</td>
			</tr>
			<tr class="vu_dependency" data-element="vu_field[dentalpress_page_options][header]" data-value="yes|1">
				<td scope="row">
					<label for="vu_field_header-title"><?php esc_html_e('Title', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Enter in page header title. If left blank, page name will be shown as page header title.', 'dentalpress'); ?></span>
				</td>
				<td><input id="vu_field_header-title" name="vu_field[dentalpress_page_options][title]" class="regular-text" type="text" value="<?php echo esc_attr($dentalpress_page_options['title']); ?>" /></td>
			</tr>
			<tr class="vu_dependency" data-element="vu_field[dentalpress_page_options][header]" data-value="yes|1">
				<td scope="row">
					<label for="vu_field_header-subtitle"><?php esc_html_e('Subtitle', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Enter in page header subtitle.', 'dentalpress'); ?></span>
				</td>
				<td><input id="vu_field_header-subtitle" name="vu_field[dentalpress_page_options][subtitle]" class="regular-text" type="text" value="<?php echo esc_attr($dentalpress_page_options['subtitle']); ?>" /></td>
			</tr>
			<tr class="vu_dependency" data-element="vu_field[dentalpress_page_options][header]" data-value="yes|1">
				<td scope="row">
					<label for="vu_field_header-breadcrumbs"><?php esc_html_e('Show Breadcrumbs?', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Check this option to show breadcrumbs. If yes subtitle will not be shown.', 'dentalpress'); ?></span>
				</td>
				<td><input id="vu_field_header-breadcrumbs" name="vu_field[dentalpress_page_options][breadcrumbs]" type="checkbox" <?php echo (!empty($dentalpress_page_options['breadcrumbs'])) ? 'checked="checked"' : ''; ?> value="1" /> <?php esc_html_e('Yes, Please', 'dentalpress'); ?></td>
			</tr>
			<tr class="vu_dependency" data-element="vu_field[dentalpress_page_options][header]" data-value="yes|1">
				<td scope="row">
					<label><?php esc_html_e('Background Image', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Click Upload and select header background image.The image should be between 1200px - 1920px in width and have a minimum height of 400px for best results.', 'dentalpress'); ?></span>
				</td>
				<td>
					<img id="vu_img_header-bg" class="vu_media-img" src="<?php echo dentalpress_get_attachment_image_src($dentalpress_page_options['bg'], 'full'); ?>">
					<input id="vu_field_header-bg" name="vu_field[dentalpress_page_options][bg]" class="regular-text" type="hidden" value="<?php echo absint($dentalpress_page_options['bg']); ?>" />
					<a href="#" data-input="vu_field_header-bg" data-img="vu_img_header-bg" data-title="<?php esc_attr_e('Add Image', 'dentalpress'); ?>" data-button="<?php esc_attr_e('Add Image', 'dentalpress'); ?>" class="vu_open-media button button-default"><?php esc_html_e('Upload', 'dentalpress'); ?></a>
					<a href="#" data-input="vu_field_header-bg" data-img="vu_img_header-bg" class="vu_remove-media button button-default"><?php esc_html_e('Remove', 'dentalpress'); ?></a>
				</td>
			</tr>
			<tr class="vu_dependency" data-element="vu_field[dentalpress_page_options][header]" data-value="yes|1">
				<td scope="row">
					<label for="vu_field_header-parallax"><?php esc_html_e('Parallax Effect?', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Check this option to enable parallax effect.', 'dentalpress'); ?></span>
				</td>
				<td>
					<label for="vu_field_header-parallax-yes" style="margin-right: 15px;"><input type="radio" name="vu_field[dentalpress_page_options][parallax]" id="vu_field_header-parallax-yes" value="yes" <?php echo (empty($dentalpress_page_options['parallax']) || $dentalpress_page_options['parallax'] == 'yes') ? 'checked="checked"' : ''; ?>><?php esc_html_e('Yes', 'dentalpress'); ?></label>
					<label for="vu_field_header-parallax-no" style="margin-right: 15px;"><input type="radio" name="vu_field[dentalpress_page_options][parallax]" id="vu_field_header-parallax-no" value="no" <?php echo (empty($dentalpress_page_options['parallax']) || $dentalpress_page_options['parallax'] == 'no') ? 'checked="checked"' : ''; ?>><?php esc_html_e('No', 'dentalpress'); ?></label>
					<label for="vu_field_header-parallax-inherit" style="margin-right: 15px;"><input type="radio" name="vu_field[dentalpress_page_options][parallax]" id="vu_field_header-parallax-inherit" value="inherit" <?php echo (empty($dentalpress_page_options['parallax']) || $dentalpress_page_options['parallax'] == 'inherit') ? 'checked="checked"' : ''; ?>><?php esc_html_e('Inherit from Theme Options', 'dentalpress'); ?></label>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label for="vu_field_menu"><?php esc_html_e('Menu', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Select the page menu.', 'dentalpress'); ?></span>
				</td>
				<td>
					<select id="vu_field_menu" name="vu_field[dentalpress_page_options][menu]" class="regular-text vu_select-change" style="width: 100%; margin: 5px 0;" data-value="<?php echo (isset($dentalpress_page_options['menu'])) ? esc_attr($dentalpress_page_options['menu']) : ''; ?>">
						<option value=""><?php esc_html_e('Default Menu', 'dentalpress'); ?></option>
						<?php 
							$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );

							$registered_menus = get_registered_nav_menus();

							foreach ($menus as $menu) {
								if( $registered_menus['main-navigation'] != $menu->name ) {
									echo '<option value="'. $menu->term_id .'">'. $menu->name .'</option>';
								}
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label for="vu_field_menu"><?php esc_html_e('Sidebar', 'dentalpress'); ?></label>
					<span class="vu_desc"><?php esc_html_e('Select the page sidebar.', 'dentalpress'); ?></span>
				</td>
				<td>
					<select id="vu_field_sidebar" name="vu_field[dentalpress_page_options][sidebar]" class="regular-text vu_select-change" style="width: 100%; margin: 5px 0;" data-value="<?php echo (isset($dentalpress_page_options['sidebar'])) ? esc_attr($dentalpress_page_options['sidebar']) : 'inherit'; ?>">
						<option value="inherit"><?php esc_html_e('Inherit from Theme Options', 'dentalpress'); ?></option>
						<option value="none"><?php esc_html_e('No Sidebar', 'dentalpress'); ?></option>
						<?php 
							foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
								echo '<option value="'. esc_attr($sidebar['id']) .'">'. esc_html($sidebar['name']) .'</option>';
							}
						?>
					</select>
				</td>
			</tr>
		</table>
	</div>
<?php
}