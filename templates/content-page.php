<?php use Roots\Sage\Extras ?>

<?php the_content(); ?>

<?php if ( Extras\is_paginated_post() ): ?>
  <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
<?php endif; ?>
