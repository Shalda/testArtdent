<?php 
	if ( post_password_required() ) {
		return;
	}
?>

<div id="comments" class="vu_comments">
	<?php if ( have_comments() ) : ?>
		<div class="row">
			<div class="col-md-6 vu_c-count-container">
				<h4 class="vu_c-count">
					<?php 
						$comments_number = get_comments_number();

						if( $comments_number >= 1 ) {
							printf( _n( 'One Comment', '%s Comments', $comments_number, 'dentalpress' ), number_format_i18n( $comments_number ) );
						} else {
							esc_html_e('No Comment', 'dentalpress');
						}
					?>
				</h4>
			</div>
			<div class="col-md-6 vu_c-text-container">
				<h4 class="vu_c-text"><?php esc_html_e('Leave a Comment', 'dentalpress'); ?></h4>
			</div>
		</div>

		<ol class="vu_c-list list-unstyled">
			<?php
				wp_list_comments(
					array(
						'style' => 'ol',
						'short_ping'  => true,
						'avatar_size' => 100,
						'callback' => 'dentalpress_comments'
					)
				);
			?>
		</ol>

		<div class="vu_c-pagination text-center clearfix m-b-30">
			<div class="pull-left">
				<?php previous_comments_link('<span class="vu_c-p-item" data-role="prev"><i class="vu_c-p-item-icon vu_fi vu_fi-arrow-left" aria-hidden="true"></i>'. esc_html__('Prev', 'dentalpress') .'</span>'); ?>
			</div>
			<div class="pull-right">
				<?php next_comments_link('<span class="vu_c-p-item" data-role="next">'. esc_html__('Next', 'dentalpress') .'<i class="vu_c-p-item-icon vu_fi vu_fi-arrow-right" aria-hidden="true"></i></span>'); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="vu_no-comments"><?php echo esc_html__( 'Comments are closed.', 'dentalpress' ); ?></p>
	<?php endif; ?>

	<?php 
		if ( comments_open() ) : 
			
			$is_user_logged_in = is_user_logged_in();

			$args = array(
				'id_form'           => 'vu_c-form',
				'id_submit'         => 'submit',
				'class_submit'      => 'submit-comment btn btn-secondary btn-inverse',
				'title_reply'       => esc_html__('Leave a Reply', 'dentalpress'),
				'title_reply_to'    => esc_html__('Leave a Reply to %s', 'dentalpress'),
				'cancel_reply_link' => esc_html__('Cancel Reply', 'dentalpress'),
				'label_submit'      => esc_html__('Submit Comment', 'dentalpress'),
				'comment_field' =>  '<div class="row"><div class="col-xs-12"><textarea id="comment" name="comment" class="form-control" rows="5" placeholder="'. esc_attr__('Your comment here', 'dentalpress') .'"></textarea></div></div>',
				'must_log_in' => '<p class="must-log-in m-b-15">'. wp_kses( sprintf(__( 'You must be <a href="%s">logged in</a> to post a comment.', 'dentalpress'), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )), array('a' => array('href' => array(), 'title' => array())) ) .'</p>',
				'logged_in_as' => '<p class="logged-in-as m-b-15">'. wp_kses( sprintf(__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'dentalpress'), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )), array('a' => array('href' => array(), 'title' => array())) ) .'</p>',
				'comment_notes_before' => '<p class="comment-notes m-b-20">'. esc_html__('Your email address will not be published.', 'dentalpress') .'</p>',
				'comment_notes_after' => '<div class="clear"></div>',
				'fields' => apply_filters( 'comment_form_default_fields', array(
					'author' =>
						'<div class="row"><div class="col-sm-6">'.
						'<input id="author" name="author" type="text" class="form-control" placeholder="'. esc_attr__('Your name here', 'dentalpress') .'" value="" size="30" /></div>',
					'email' =>
						'<div class="col-sm-6">'.
						'<input id="email" name="email" type="text" class="form-control" placeholder="'. esc_attr__('Your email here', 'dentalpress') .'" value="" size="30" /></div></div>',
					'url' =>
						'<div class="row"><div class="col-xs-12">'.
						'<input id="url" name="url" type="text" class="form-control" placeholder="'. esc_attr__('Your website here', 'dentalpress') .'" value="" size="30" /></div></div>'
					)
				),
			);

			comment_form($args);

		endif;
	?>
</div>