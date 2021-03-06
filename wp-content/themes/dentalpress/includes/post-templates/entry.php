<article id="post-<?php the_ID(); ?>" <?php post_class('vu_blog-post vu_bp-type-standard'); ?> itemscope="itemscope" itemtype="https://schema.org/BlogPosting">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="vu_bp-image">
			<a href="<?php if ( is_single() ) { echo dentalpress_get_attachment_image_src(get_post_thumbnail_id(), 'full'); } else { echo esc_url( get_permalink() ); } ?>"<?php if ( is_single() ) { echo ' class="vu_lightbox"'; } ?>>
				<?php the_post_thumbnail('dentalpress_ratio-2:1', array('itemprop' => 'image')); ?>
			</a>

			<span class="vu_bp-categories">
				<?php the_category(' '); ?>
			</span>

			<?php if ( is_single() ) : ?>
				<?php dentalpress_blog_social_networks( get_permalink(), get_the_title(), $post->ID ); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	
	<div class="vu_bp-content-wrapper">
		<header class="vu_bp-header">
			<?php if ( !is_single() ) : ?>
				<h3 class="vu_bp-title entry-title" itemprop="name">
					<a href="<?php echo esc_url( get_permalink() ); ?>" itemprop="url" rel="bookmark" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a>
				</h3>
			<?php else : ?>
				<h1 class="vu_bp-title entry-title" itemprop="name"><?php the_title(); ?></h1>
			<?php endif; ?>

			<div class="vu_bp-meta">
				<?php if ( dentalpress_get_option('blog-show-date') ) : ?>
					<span class="vu_bp-m-item vu_bp-date">
						<i class="vu_bp-m-item-icon fa fa-calendar-o" aria-hidden="true"></i>
						<time class="entry-date published" datetime="<?php echo esc_attr( get_the_time('c') ); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time>
					</span>
				<?php endif; ?>

				<?php if ( dentalpress_get_option('blog-show-author') ) : ?>
					<span class="vu_bp-m-item vu_bp-author">
						<i class="vu_bp-m-item-icon fa fa-user-o" aria-hidden="true"></i>
						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php esc_attr_e('Posts by', 'dentalpress'); ?> <?php the_author(); ?>" rel="author"><span itemprop="author"><?php the_author(); ?></span></a>
					</span>
				<?php endif; ?>

				<span class="vu_bp-m-item vu_bp-comments">
					<i class="vu_bp-m-item-icon fa fa-comment-o" aria-hidden="true"></i>
					<a href="<?php comments_link(); ?>"><?php comments_number( esc_html__('No Comments', 'dentalpress'), esc_html__('One Comment ', 'dentalpress'), esc_html__('% Comments', 'dentalpress') ); ?></a>
				</span>

				<?php if ( !is_single() and dentalpress_get_option('blog-show-tags') and has_tag() ) : ?>
					<span class="vu_bp-m-item vu_bp-tags">
						<i class="vu_bp-m-item-icon fa fa-tags" aria-hidden="true"></i>
						<?php the_tags('', ', ' ,''); ?>
					</span>
				<?php endif; ?>

				<?php if ( is_single() and dentalpress_get_option('blog-single-show-tags') and has_tag() ) : ?>
					<span class="vu_bp-m-item vu_bp-tags">
						<i class="vu_bp-m-item-icon fa fa-tags" aria-hidden="true"></i>
						<?php the_tags('', ', ' ,''); ?>
					</span>
				<?php endif; ?>

				<div class="clear"></div>
			</div>
			
			<div class="clear"></div>
		</header>

		<div class="vu_bp-content">
			<?php if ( !is_single() ) : ?>
				<div class="vu_bp-content-excerpt" itemprop="description"><?php the_excerpt(); ?></div>
				<div class="clear"></div>
				<a href="<?php the_permalink(); ?>" class="vu_bp-read-more">
					<span class="vu_bp-btn">
						<i class="vu_bp-btn-icon-left vu_fi vu_fi-arrow-right"></i>
						<span class="vu_bp-btn-text"><?php esc_html_e('Read More', 'dentalpress'); ?></span>
						<i class="vu_bp-btn-icon-right vu_fi vu_fi-arrow-right"></i>
					</span>
				</a>
			<?php else : ?>
				<div class="vu_bp-content-full entry-content" itemprop="articleBody">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="clear"></div>
</article>