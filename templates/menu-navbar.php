<?php use Roots\Sage\Setup ?>

<?php if ( has_nav_menu( 'navigation_navbar' ) ): ?>

<nav class="nav nav--navbar stick-to-bottom" aria-label="Frequently used links">
  <?php Setup\menu_navbar(); ?>
</nav>

<?php endif; ?>
