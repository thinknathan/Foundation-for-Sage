<header data-sticky-container>
  <div class="title-bar" data-sticky data-sticky-on="small" data-options="marginTop:0;">
    <div class="title-bar-left">
      <strong>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a>
      </strong>
    </div>
    <div class="title-bar-right">
      <nav class="show-for-large">
        <?php if (has_nav_menu('primary_navigation')): ?>
          <?php Roots\Sage\Extras\top_nav(); ?>
        <?php endif; ?>
      </nav>
      <button class="menu-icon hide-for-large" type="button" data-open="offCanvas"></button>
    </div>
  </div>
</header>
