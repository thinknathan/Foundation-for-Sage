<footer class="content-info">
  <div class="container">
    <p class="copyright">
      &copy; <?= date('Y'); ?> Nathan Bolton
    </p>
  </div>
</footer>
<footer class="hide-for-medium" data-sticky-container>
  <?php get_template_part('templates/mobile-bottom-bar'); ?>
</footer>
<?php $fileToInline = get_template_directory() . '/dist/scripts/' . basename(Roots\Sage\Assets\asset_path('scripts/footer-inline.js')); if ( file_exists($fileToInline) && filesize($fileToInline) > 0 ): ?><script><?php readfile($fileToInline); ?></script><?php endif; ?>
