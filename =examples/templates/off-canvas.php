<?php use Roots\Sage\Setup ?>

<div class="off-canvas position-right" id="offCanvas" data-off-canvas data-transition="overlap">
  <div class="off-canvas-inner">
    <button class="close-button" aria-label="Close menu" type="button" data-close>
      <span aria-hidden="true">&times;</span>
    </button>
    
    <p><strong>
      <a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a>
    </strong></p>

    <?php if (has_nav_menu('mobile_navigation')): ?>
      <?php Setup\off_canvas_nav(); ?>
    <?php endif; ?>
  </div>
</div>