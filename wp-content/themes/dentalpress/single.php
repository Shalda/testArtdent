<?php 
	get_header();

	$dentalpress_page_options = dentalpress_get_post_meta( get_option( 'page_for_posts' ), 'dentalpress_page_options' );

	$has_sidebar = dentalpress_has_sidebar($dentalpress_page_options); ?>

	<!-- Content -->
	<div class="vu_content vu_posts-page vu_blog-single-post col-xs-12<?php echo (dentalpress_get_option('navigation-position', 'sidebar') == 'sidebar' || $has_sidebar == true) ? ' col-md-9' : ''; ?>" role="main">
		<div class="vu_c-wrapper clearfix">
			<div class="vu_bsp-content">
				<?php 
					if ( have_posts() ) : while ( have_posts() ) : the_post();
						get_template_part( 'includes/post-templates/entry', get_post_format() );
					endwhile; endif;
				?>

				<?php wp_link_pages(); ?>

				<?php if ( comments_open() || get_comments_number() ) : ?>
					<div class="vu_bsp-comments clearfix">
						<?php comments_template(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!-- /Content -->

	<?php 
		if( $has_sidebar == true ) {
			get_sidebar();
		}
	?>

<?php get_footer(); ?>