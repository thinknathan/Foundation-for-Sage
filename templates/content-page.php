<?php the_content(); ?>
<?php if ( Roots\Sage\Extras\is_paginated_post() ): ?>
  <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
<?php endif; ?>
