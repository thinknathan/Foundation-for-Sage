<?php use Roots\Sage\Util ?>

<header class="header header--site">
  <div class="header--site__inner">
    <div class="header--site__brand">
      <h1 class="header--site__title">
        <a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home" class="header--site__title-link">
          <?= Util\local_image('logo.svg', 320, 160, get_bloginfo('name')) ?>
        </a>
      </h1>
    </div>

    <div class="header--site__navigation">
      <?php get_template_part('templates/offcanvas-toggle'); ?>
      <?php get_template_part('templates/menu', 'primary'); ?>
    </div>
  </div>
</header>
