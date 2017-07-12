<?php use Roots\Sage\Titles; ?>

<?php if (!is_front_page()): ?>

<div class="page-header">
  <div class="page-header-inner">
    <h1>
      <?= Titles\title(); ?>
    </h1>
  </div>
</div>

<?php endif; ?>
