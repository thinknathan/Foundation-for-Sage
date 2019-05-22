<?php use Roots\Sage\Util ?>

<header class="header-site headroom stick-to-top">
  <div class="header-site-inner">
    <div class="header-site-brand">
      <h1 class="header-site-title">
        <a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home" class="header-site-title-link">
          <?= Util\local_image('logo.svg', 320, 160, get_bloginfo('name')) ?>
        </a>
      </h1>
    </div>

    <div class="header-site-navigation">
      <?php get_template_part('templates/offcanvas-toggle'); ?>
      <?php get_template_part('templates/menu-primary'); ?>
    </div>
  </div>
</header>
