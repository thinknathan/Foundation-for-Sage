<?php use Roots\Sage\Util ?>

<?php get_template_part('templates/header', 'page'); ?>

<?php if (!have_posts()) : ?>
  <div class="callout callout--warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/header', get_post_type()); ?>
  <?php get_template_part('templates/content', get_post_type()); ?>
<?php endwhile; ?>

<?php Util\pagination(); ?>
