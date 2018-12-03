<article id="post-<?php the_ID(); ?>" <?php post_class('vu_blog-post vu_bp-type-quote'); ?> itemscope="itemscope" itemtype="https://schema.org/BlogPosting">
	<div class="vu_bp-content-wrapper">
		<div class="vu_bp-content">
			<div class="vu_bp-content-full">
				<?php 
					$dentalpress_post_format_settings = dentalpress_get_post_meta( $post->ID, 'dentalpress_post_format_settings' );

					if( !empty($dentalpress_post_format_settings['quote']['content']) ) {
						echo '<div class="vu_bp-quote">';
						echo '<blockquote class="vu_bp-q-content">';
						echo wpautop(esc_html($dentalpress_post_format_settings['quote']['content']));
						echo '<div class="vu_bp-q-author">'. esc_html($dentalpress_post_format_settings['quote']['author']) .'</div>';
						echo '</blockquote>';
						echo '</div>';
					} else {
						the_content();
					}
				?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</article>