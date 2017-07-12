<?php get_template_part('templates/content-single', get_post_type()); ?>

<?php 
// Setup aside content: related posts

// Get the custom post type's taxonomy terms
$custom_taxonomy = 'category';
$custom_taxterms = wp_get_object_terms( $post->ID, $custom_taxonomy, ['fields' => 'ids'] );
// Arguments
$args = [
  'post_type'      => 'post',
  'post_status'    => 'publish',
  'posts_per_page' => 2,
  'orderby'        => 'rand',
  'tax_query' => [
    [
      'taxonomy' => $custom_taxonomy,
      'field'    => 'id',
      'terms'    => $custom_taxterms
    ]
  ],
  'post__not_in' => array ($post->ID),
];
$related_posts = new WP_Query( $args ); ?>

<?php // Only display posts if there are more than 1 found
if ( $related_posts->have_posts() && $related_posts->found_posts > 1 ) : ?>
  <aside class="related-posts" data-equalizer data-equalize-on="medium">
    <?php
    while ( $related_posts->have_posts() ): $related_posts->the_post();
    ?>

      <?php get_template_part('templates/card-article'); ?>

    <?php endwhile; wp_reset_query(); ?>
  </aside>
<?php endif; ?>
