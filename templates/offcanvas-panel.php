<?php use Roots\Sage\Setup ?>
<?php use Roots\Sage\Util ?>

<section class="fr-offcanvas-panel" id="offcanvas-1" aria-hidden="true">
  <div class="fr-offcanvas-controls">
    <button class="button offcanvas-toggle fr-offcanvas-close" aria-label="Close primary menu">
      Close <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="fr-offcanvas-head">
    <a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home" class="fr-offcanvas-title">
      <?= Util\local_image('logo.svg', 200, 100, get_bloginfo('name')) ?>
    </a>
  </div>
  <div class="fr-offcanvas-content">
    <?php Setup\menu_offcanvas(); ?>
  </div>
</section>
<div class="fr-offcanvas-overlay" aria-hidden="true"></div>
