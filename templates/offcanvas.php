<div class="off-canvas position-right" id="offCanvas" data-off-canvas data-transition="overlap">
  <div class="masthead">
    <button class="close-button" aria-label="Close menu" type="button" data-close>
      <span aria-hidden="true">&times;</span>
    </button>
    <p><strong>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a>
    </strong></p>
  </div>
  <div class="off-canvas-inner">
    <?php get_search_form(); ?>
    <?php if (has_nav_menu('primary_navigation')): ?>
      <?php Roots\Sage\Setup\off_canvas_nav(); ?>
    <?php endif; ?>
  </div>
</div>
