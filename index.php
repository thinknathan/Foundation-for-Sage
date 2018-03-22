<?php use Roots\Sage\Extras ?>

<?php get_template_part('templates/header', 'page'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/header', get_post_type()); ?>
  <?php get_template_part('templates/content', get_post_type()); ?>
<?php endwhile; ?>

<?php Extras\page_navi(); ?>
