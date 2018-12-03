<form role="search" method="get" class="vu_search-form search-form" action="<?php echo esc_url( home_url('/') ); ?>">
	<div class="vu_sf-wrapper">
		<input type="search" class="vu_sf-input form-control" placeholder="<?php esc_attr_e('Type your search...', 'dentalpress'); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"/>
		<button type="submit" class="vu_sf-submit search-submit hide"><?php esc_html_e('Search', 'dentalpress'); ?></button>
	</div>
</form>