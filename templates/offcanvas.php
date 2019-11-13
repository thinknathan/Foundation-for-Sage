<?php use Roots\Sage\Setup ?>
<?php use Roots\Sage\Util ?>

<section class="offcanvas" id="offcanvas-1" aria-hidden="true">
  <div class="offcanvas__controls">
    <button class="button offcanvas__toggle offcanvas__close" aria-label="Close primary menu">
      Close <span class="icon icon--text" aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="offcanvas__head">
    <a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home" class="offcanvas__title">
      <?= Util\local_image('logo.svg', 200, 100, get_bloginfo('name')) ?>
    </a>
  </div>
  <div class="offcanvas__content">
    <?php Setup\menu_offcanvas(); ?>
  </div>
</section>
<div class="offcanvas__overlay" aria-hidden="true"></div>
