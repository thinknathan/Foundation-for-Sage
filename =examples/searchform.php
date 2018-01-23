<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="input-group">
		<input type="text" class="input-group-field" value="" name="s" id="s" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>">
		<div class="input-group-button">
      <input type="submit" class="search-submit"
          value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
		</div>
	</div>
</form>
