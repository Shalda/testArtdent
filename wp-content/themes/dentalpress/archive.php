<?php 
	get_header();

	$dentalpress_page_options = dentalpress_get_post_meta( get_option( 'page_for_posts' ), 'dentalpress_page_options' );

	$has_sidebar = dentalpress_has_sidebar($dentalpress_page_options); ?>

	<!-- Content -->
	<div class="vu_content vu_archive-page vu_posts-page col-xs-12<?php echo (dentalpress_get_option('navigation-position', 'sidebar') == 'sidebar' || $has_sidebar == true) ? ' col-md-9' : ''; ?>" role="main">
		<?php if ( have_posts() ) :  ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="row">
					<div class="col-xs-12">
						<?php get_template_part( 'includes/post-templates/entry', get_post_format() ); ?>
					</div>
				</div>
			<?php endwhile; ?>
		<?php else : ?>
			<div class="vu_section">
				<div class="vu_c-wrapper clearfix">
				<p class="m-b-0"><?php esc_html_e('No posts found', 'dentalpress'); ?></p>
			</div>
		<?php endif; ?>
		
		<?php dentalpress_pagination(); ?>
	</div>
	<!-- /Content -->

	<?php 
		if( $has_sidebar == true ) {
			get_sidebar();
		}
	?>

<?php get_footer(); ?>