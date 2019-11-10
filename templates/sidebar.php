<?php do_action( 'before_sidebar' ); ?>
<?php if ( ! dynamic_sidebar( 'sidebar-primary' ) ) : ?>
  <aside class="widget widget--search">
    <?php get_search_form(); ?>
  </aside>
  <aside class="widget widget--archives">
    <h3 class="title widget__title"><?php _e( 'Archives', 'shape' ); ?></h3>
    <ul>
      <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
    </ul>
  </aside>
  <aside class="widget widget--meta">
    <h3 class="title widget__title"><?php _e( 'Meta', 'shape' ); ?></h3>
    <ul>
      <?php wp_register(); ?>
      <li><?php wp_loginout(); ?></li>
      <?php wp_meta(); ?>
    </ul>
  </aside>
<?php endif; ?>
