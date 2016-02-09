<header>
  <div class="top-bar">
    <div class="top-bar-left">
        <ul class="menu">
          <li class="menu-text"><?php bloginfo('name'); ?></li>
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
