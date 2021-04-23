<?php get_template_part('templates/header', 'page'); ?>

<div class="callout callout--warning">
  <?php the_field('acf_404_content', 'options'); ?>
</div>

<?php get_search_form(); ?>
