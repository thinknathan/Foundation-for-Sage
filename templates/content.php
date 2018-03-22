<?php use Roots\Sage\Extras ?>

<article <?php post_class(); ?>>
  <div class="entry-content">
    <?php the_content(); ?>
  </div>
  <?php if ( Extras\is_paginated_post() ): ?>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
  <?php endif; ?>
</article>
