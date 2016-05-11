<header>
  <div class="title-bar" data-responsive-toggle="top-menu" data-hide-for="medium">
    <button class="menu-icon" type="button" data-toggle></button>
    <div class="title-bar-title">Menu</div>
  </div>
  <div class="top-bar" id="top-menu">
    <div class="top-bar-left">
        <ul class="menu">
          <li class="home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></li>
        </ul>
    </div>
    <div class="top-bar-right">
      <ul class="dropdown menu" data-dropdown-menu>
        <?php if (has_nav_menu('primary_navigation')) :?>
          <?php wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'container' => '', 'items_wrap' => '%3$s', 'walker' => new Roots\Sage\Extras\Foundation_Nav_Menu()]);?>
        <?php endif;?>
      </ul>
    </div>
  </div>
</header>
