<div class="off-canvas position-right" id="offCanvas" data-off-canvas>
	<?php get_search_form(); ?>
	<?php if (has_nav_menu('primary_navigation')) :?>
		<?php Roots\Sage\Extras\off_canvas_nav(); ?>
	<?php endif;?>
</div>
