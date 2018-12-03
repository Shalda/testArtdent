<?php get_header(); ?>

	<!-- Content -->
	<div class="vu_content col-xs-12<?php echo (dentalpress_get_option('navigation-position', 'sidebar') == 'sidebar') ? ' col-md-9' : ''; ?>" role="main">
		<div class="vu_c-wrapper clearfix">
			<div class="vu_error-page">
				<div class="vu_ep-404"><?php esc_html_e("404!", 'dentalpress'); ?></div>

				<div class="vu_ep-content clearfix">
					<h2 class="vu_ep-title"><?php esc_html_e("The requested page cannot be found", 'dentalpress'); ?></h2>

					<p class="vu_ep-desc">
						<?php esc_html_e("Sorry but the page you are looking for cannot be found.", 'dentalpress')?>
						<br>
						<?php esc_html_e("Please make sure you have typed the correct url.", 'dentalpress'); ?>
					</p>
					
					<a href="<?php echo esc_url( home_url('/') ); ?>" class="vu_ep-btn btn btn-primary btn-inverse"><?php esc_html_e("Return to home", 'dentalpress'); ?></a>
				</div>
			</div>
		</div>
	</div>
	<!-- /Content -->

<?php get_footer(); ?>