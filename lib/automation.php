<?php

namespace Roots\Sage\Extras;

/**
 * Creates a sitemap for gulp tasks to parse.
 * Only active in development environments.
 * Activates each time a post is saved.
 */
function create_sitemap() {
  $urls = array();

  // get all public post types
  // see: https://codex.wordpress.org/Function_Reference/get_post_types
  $post_types = get_post_types(array(
    'public' => true
  ), 'objects');
  // get all posts ordered by
  // descrending last modification date
  // // see: https://codex.wordpress.org/Function_Reference/get_posts
  $posts = get_posts(array(
    'numberposts' => -1,
    'post_type'   => array_keys($post_types),
    'orderby'     => 'modified',
    'order'       => 'DESC'
  ));
  // get all public taxonomies
  // see: https://codex.wordpress.org/Function_Reference/get_taxonomies
  $taxonomies = get_taxonomies(array(
    'public' => true
  ));
  // get all terms in public taxonomies
  // see: https://developer.wordpress.org/reference/functions/get_terms/
  $terms = get_terms(array(
    'taxonomy' => array_keys($taxonomies)
  ));
  // get all author users (user level greater than 0)
  // see: https://codex.wordpress.org/Function_Reference/get_users
  $users = get_users(array(
    // 'role' => '?',
    'orderby' => 'post_count',
    'order' => 'DESC',
    'who' => 'authors'
  ));

  // add home page location
  $urls[] = esc_url( home_url( '/' ) );

  // add 404 page
  $urls[] = esc_url( home_url( '/' ) . '404' );

  // add search page
  $urls[] = esc_url( home_url( '/' ) . 'search/new/' );

  // add all pages for public post types
  foreach( $posts as $post ) {
    $urls[] = get_permalink( $post->ID );
  }
  // add archive pages
  foreach ( $post_types as $post_type ) {
    if( $post_type->has_archive ) {
      $urls[] = get_post_type_archive_link($post_type->name);
    }
  }
  // add public terms pages
  foreach ( $terms as $term ) {
    $urls[] = get_term_link($term->term_id);
  }
  // finally add author pages
  foreach ( $users as $user ) {
    $urls[] = get_author_posts_url( $user->ID );
  }

  $json = json_encode($urls);
  $fp = fopen( get_stylesheet_directory() . '/sitemap.json', 'w' );
  if ($fp) {
    fwrite( $fp, $json );
    fclose( $fp );
  }
}
if (defined('WP_ENV') && WP_ENV === 'development') {
  add_action('save_post', __NAMESPACE__ . '\\create_sitemap');
}
