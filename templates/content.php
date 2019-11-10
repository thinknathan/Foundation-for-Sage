<?php use Roots\Sage\Util ?>

<article <?php post_class(); ?>>
  <div class="content content--entry">
    <?php the_content(); ?>
  </div>
  <?php if ( Util\is_paginated_post() ): ?>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="nav--page"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
  <?php endif; ?>
</article>
