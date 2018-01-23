<?php use Roots\Sage\Extras ?>

<?php while (have_posts()) : the_post(); ?>

  <article <?php post_class(); ?>>
    <header class="entry-header">
      <h1 class="entry-title">
        <?php the_title(); ?>
      </h1>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
    <?php if ( Extras\is_paginated_post() ): ?>
      <footer>
        <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
      </footer>
    <?php endif; ?>
  </article>

<?php endwhile; ?>
