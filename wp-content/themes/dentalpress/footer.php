	<?php if( !is_page_template('template-blank.php') ) : ?>
			</div>
		</div>
		<!-- /Container -->

		<!-- Footer -->
		<footer id="vu_main-footer" class="vu_main-footer" role="contentinfo" itemscope="itemscope" itemtype="https://schema.org/WPFooter">
			<?php if( dentalpress_get_option('footer-show') == true and dentalpress_footer_sidebars_has_widgets() ) : ?>
				<!-- Footer Widgets -->
				<div class="vu_mf-widgets<?php echo ( dentalpress_get_option('subfooter-show') == false ) ? ' m-b-20' : ''; ?>">
					<div class="container">
						<div class="row">
							<?php 
								$footer_layout = absint( dentalpress_get_option('footer-layout') );

								for ( $i = 1; $i <= $footer_layout; $i++ ) {
									echo '<div class="vu_mf-footer-'. $i .' col-md-'. absint(12 / $footer_layout) .' col-xs-12">';
									dynamic_sidebar('footer-'. $i);
									echo '</div>';
								}
							?>
						</div>
					</div>
				</div>
				<!-- /Footer Widgets -->
			<?php endif; ?>
			
			<?php if( dentalpress_get_option('subfooter-show') == true ) : ?>
				<!-- Footer Bottom -->
				<div class="vu_mf-bottom">
					<div class="container">
						<div class="vu_row row">
							<div class="vu_r-wrapper vu_r-equal-height">
								<div class="vu_r-content">
									<div class="col-sm-8 vu_c-valign-middle">
										<div class="vu_mf-b-content">
											<?php echo do_shortcode( wp_kses_post( dentalpress_get_option('subfooter-left-content') ) ); ?>
										</div>
									</div>

									<div class="col-sm-4 vu_c-valign-middle">
										<div class="vu_mf-b-content text-right">
											<?php echo do_shortcode( wp_kses_post( dentalpress_get_option('subfooter-right-content') ) ); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Footer Bottom -->
			<?php endif; ?>

			<?php if( dentalpress_get_option('back-to-top-show') == true ) : ?>
				<a href="#" class="vu_back-to-top">
					<i class="vu_fi vu_fi-arrow-up"></i>
				</a>
			<?php endif; ?>
		</footer>
		<!-- /Footer -->
	<?php endif; ?>

	</div><!-- /Main Container -->

	<?php wp_footer(); ?>
</body>
</html>