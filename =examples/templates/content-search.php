<?php use Roots\Sage\Extras ?>

<article <?php post_class(); ?>>
  <header class="entry-header">
    <h2 class="entry-title">
      <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </h2>
  </header>
  <div class="entry-summary">
    <?= Extras\snip(get_the_content(), '20', 'words'); ?>
  </div>
  <?php if (get_post_type() === 'post'): ?>
    <footer class="entry-footer">
      <?php get_template_part('templates/entry-meta'); ?>
    </footer>
  <?php endif; ?>
</article>
