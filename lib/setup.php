<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;
use Roots\Sage\Extras;

/**
 * Theme setup
 */
function setup() {
  // Indicate support for WooCommerce
  //add_theme_support( 'woocommerce' );

  // Custom logo support
  //add_theme_support( 'custom-logo' );

  // Enable features from Abettor plugin
  // https://github.com/thinknathan/wp-abettor
  add_theme_support('abet-clean-up'); // Cleaner WordPress markup
  add_theme_support('abet-nice-search');  // Convert search results from /?s=query to /search/query/
  add_theme_support('abet-disable-trackbacks'); // Disable trackbacks
  add_theme_support('abet-clean-admin-dashboard');  // Remove default dash widgets
  add_theme_support('abet-demarcate-development');  // Changes favicon of development sites
  add_theme_support('abet-disable-admin-bar');  // Hide top bar on front-end
  add_theme_support('abet-disable-backend-admin-bar'); // Hide top bar on back-end
  add_theme_support('abet-disable-comments'); // Turn off comments and back-end widgets
  add_theme_support('abet-gravity-forms-setup'); // Gravity Forms HTML5 output on & CSS output off
  add_theme_support('abet-gravity-forms-to-footer'); // Move Gravity Forms injected scripts to the footer
  add_theme_support('abet-tinymce-clean-paste'); //Remove cruft from text when pasting into the TinyMCE editor
  add_theme_support('abet-add-logout-link-admin-sidebar');  // Adds a Logout link to the admin sidebar
  add_theme_support('abet-add-view-site-admin-sidebar');  // Adds a View Site link to the admin sidebar


  // Disable custom colours in block editor
  // https://developer.wordpress.org/block-editor/developers/themes/theme-support/
  add_theme_support( 'disable-custom-colors' );
  add_theme_support( 'editor-color-palette', [] );

  // Disable custom font sizes in block editor
  add_theme_support( 'disable-custom-font-sizes' );
  add_theme_support( 'editor-font-sizes', [] );

  // Add theme support for Wide Alignment
  add_theme_support('align-wide');

  // Add responsive embed support in block editor
  add_theme_support( 'responsive-embeds' );

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  remove_image_size('medium');
  set_post_thumbnail_size( 480, 270, true );
  add_image_size( 'small', 480, 270, false );
  add_image_size( 'medium', 640, 360, false );
  add_image_size( 'card-thumbnail', 640, 360, false );
  add_image_size( 'large', 1280, 720, false );
  add_image_size( 'xlarge', 1920, 1080, false );

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Support Yoast SEO Breadcrumbs
  // https://kb.yoast.com/kb/implement-wordpress-seo-breadcrumbs/
  add_theme_support('yoast-seo-breadcrumbs');

  // ACF Options Page
  // https://www.advancedcustomfields.com/resources/acf_add_options_page/
  if( function_exists('acf_add_options_page') && function_exists('acf_add_options_sub_page') ) {
    acf_add_options_page([
      'page_title' => 'Sitewide Content',
      'icon_url' => 'dashicons-welcome-widgets-menus',
      'menu_slug' 	=> 'theme-sitewide-content',
      'position' => 33.1,
    ]);
    acf_add_options_sub_page([
      'page_title' 	=> 'Contact Info',
      'parent_slug'	=> 'theme-sitewide-content',
    ]);
    acf_add_options_sub_page([
      'page_title' 	=> 'Headers & Footers',
      'parent_slug'	=> 'theme-sitewide-content',
    ]);
    acf_add_options_sub_page([
      'page_title' 	=> '404 Page',
      'parent_slug'	=> 'theme-sitewide-content',
    ]);
  }

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'navigation_primary' => __('Primary Navigation', 'sage'),
    'navigation_navbar' => __('Mobile Navbar (Max 4 Links)', 'sage'),
  ]);

  // Custom Post Types
  // https://codex.wordpress.org/Function_Reference/register_post_type
  /*
  register_post_type( 'cpt_xxx',
    [
      'labels' => [
        'name'          => __( 'xxx' ),
        'singular_name' => __( 'xxx' )
      ],
      'public'            => true,
      'rewrite'           => [ 'slug' => 'xxx', 'with_front' => false ],
      'has_archive'       => true,
      'hierarchical'      => true,
      'menu_icon'         => 'dashicons-heart',
      'capability_type'   => 'page',
      'supports'          => [ 'title', 'editor', 'page-attributes', 'thumbnail' ],
    ]
  );
  */
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');


/**
 * Limit Gutenberg block types
 */
function allowed_block_types( $allowed_blocks, $post ) {
  $allowed_blocks = [
    'core/block', // Reusable blocks
    'core/image',
    'core/paragraph',
    'core/heading',
    'core/list',
    'core/quote',
    'core/button',
    'core/embed',
    'core-embed/youtube',
    'core-embed/vimeo',
    'core-embed/instagram',
  ];

/*
  if( $post->post_type === 'page' ) {
      $allowed_blocks[] = 'core/shortcode';
  }
*/
  return $allowed_blocks;
}
add_filter( 'allowed_block_types', __NAMESPACE__ . '\\allowed_block_types', 10, 2 );


/**
 * Custom Resource Hinting
 * Removes DNS-Prefetch and adds Preconnect
 * @link https://www.keycdn.com/blog/resource-hints
 */
function resource_hints( $hints, $relation_type ) {
  if (is_admin() || $GLOBALS['pagenow'] === 'wp-login.php') {
    return $hints;
  }
	// Remove all dns-prefetch
	if ('dns-prefetch' === $relation_type) {
    return [];
  }
	// Add preconnect hints
  if ('preconnect' === $relation_type) {
    //$hints[] = 'https://www.google-analytics.com';
  }
  return $hints;
}
add_filter( 'wp_resource_hints', __NAMESPACE__ . '\\resource_hints', 10, 2 );


/**
 * Top menu
 * Credit to chuckn246 + JointsWP Menu Code
 * @link https://github.com/JeremyEnglert/JointsWP
 */
function menu_primary() {
  wp_nav_menu([
    'theme_location' => 'navigation_primary',       // Where it's located in the theme
    'container' => false,                           // Remove nav container
    'menu_class' => 'menu menu--primary',                // Adding custom nav class
    'items_wrap' => '<ul class="%2$s" id="menu--primary">%3$s</ul>',
    'depth' => 2,                                   // Limit the depth of the nav
    'fallback_cb' => false,                         // Fallback function
    'walker' => new Extras\walker_primary()
  ]);
}


/**
 * Offcanvas menu
 */
function menu_offcanvas() {
  wp_nav_menu([
    'theme_location' => 'navigation_primary',       // Where it's located in the theme
    'container' => false,                           // Remove nav container
    'menu_class' => 'menu menu--vertical menu--offcanvas',                // Adding custom nav class
    'items_wrap' => '<ul class="%2$s" id="menu--offcanvas">%3$s</ul>',
    'depth' => 2,                                   // Limit the depth of the nav
    'fallback_cb' => false,                         // Fallback function
    'walker' => new Extras\walker_primary()
  ]);
}


/**
 * Mobile navbar menu
 */
function menu_navbar() {
  wp_nav_menu([
    'theme_location' => 'navigation_navbar',       // Where it's located in the theme
    'container' => false,                           // Remove nav container
    'menu_class' => 'menu menu--navbar',                // Adding custom nav class
    'items_wrap' => '<ul class="%2$s" id="menu--navbar">%3$s</ul>',
    'depth' => 1,                                   // Limit the depth of the nav
    'fallback_cb' => false,                         // Fallback function
    'link_before'    => '<span>',
    'link_after'     => '</span>'
  ]);
}


/**
 * Determine which pages should display the sidebar
 */
function display_sidebar() {
  static $display;

  isset($display) || $display = in_array(true, [
    // The sidebar will be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    //is_404(),
    //is_front_page(),
    //is_archive(),
    //is_page_template('template-custom.php'),
  ]);

  return apply_filters('sage/display_sidebar', $display);
}


/**
 * Determine which pages should display breadcrumbs
 */
function display_breadcrumbs() {
  static $display;

  isset($display) || $display = in_array(true, [
    // The breadcrumbs will be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_single(),
    is_archive(),
    is_search(),
  ]);

  return apply_filters('sage/display_breadcrumbs', $display);
}


/**
 * Add CSS assets to front-end
 */
function css_assets() {
  // Add Main CSS
  wp_enqueue_style('sage/css/main', Assets\asset_path('styles/app.main.css'), false, null);

  // Remove Gutenberg CSS
  //wp_dequeue_style( 'wp-block-library' );
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\css_assets', 90);


/**
 * Add JS assets to front-end
 */
function js_assets() {
  // Add WP Comments JS
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  // Add Main script
  wp_enqueue_script('sage/js/main', Assets\asset_path('scripts/app.main.js'), array(), null, false);

  if (!is_admin() && $GLOBALS['pagenow'] !== 'wp-login.php') {
    // Remove jQuery script
    wp_deregister_script('jquery');
  }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\js_assets', 100);


/**
 * Login page assets
 */
function login_assets() {
  wp_enqueue_style('sage/css/main', Assets\asset_path('styles/app.main.css'), false, null);
}
add_action('login_enqueue_scripts', __NAMESPACE__ . '\\login_assets', 10);


/**
 * Add assets to block editor
 */
function block_editor_assets() {
  // Add editor CSS
  wp_enqueue_style('sage/css/editor', Assets\asset_path('styles/editor.css'), false, null);
}
add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\\block_editor_assets', 100);
