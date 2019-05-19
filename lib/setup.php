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

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  //load_theme_textdomain('sage', get_template_directory() . '/lang');
  
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-relative-urls');
  add_theme_support('soil-disable-trackbacks');
  add_theme_support('soil-disable-asset-versioning');
  add_theme_support('soil-google-analytics', 'UA-XXXXX-Y');
  
  // Enable features from Abettor plugin
  // https://github.com/thinknathan/wp-abettor
  add_theme_support('abet-clean-admin-dashboard');
  add_theme_support('abet-demarcate-development');
  add_theme_support('abet-disable-admin-bar');
  add_theme_support('abet-disable-backend-admin-bar');
  add_theme_support('abet-disable-comments');
  add_theme_support('abet-gravity-forms-setup');
  add_theme_support('abet-gravity-forms-to-footer');
  add_theme_support('abet-tinymce-clean-paste');
  add_theme_support('abet-add-logout-link-admin-sidebar');
  add_theme_support('abet-add-view-site-admin-sidebar');

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
  if( function_exists('acf_add_options_page') ) {
    acf_add_options_page([
      'page_title' => 'Options',
      'icon_url' => 'dashicons-admin-generic'
    ]);
  }
  
  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage'),
    'mobile_navigation' => __('Mobile Navigation', 'sage')
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
function top_nav() {
  wp_nav_menu([
    'theme_location' => 'primary_navigation',       // Where it's located in the theme
    'container' => false,                           // Remove nav container
    'menu_class' => 'menu menu-primary',                // Adding custom nav class
    'items_wrap' => '<ul class="%2$s" id="menu-primary" role="menubar">%3$s</ul>',
    'depth' => 2,                                   // Limit the depth of the nav
    'fallback_cb' => false,                         // Fallback function (see below)
    'walker' => new Extras\top_nav_walker()
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
 * Add Theme CSS assets
 */
function css_assets() {
  // Add Main CSS
  wp_enqueue_style('sage/css', Assets\asset_path('styles/app.main.css'), false, null);
  
  if (!is_admin() && $GLOBALS['pagenow'] !== 'wp-login.php') {
    // Remove Gutenberg CSS
    wp_dequeue_style( 'wp-block-library' );
  }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\css_assets', 90);


/**
 * Add Theme JS assets
 */
function js_assets() {
  // Add WP Comments JS
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  // Add Priority script
  wp_enqueue_script('sage/js/priority', Assets\asset_path('scripts/app.priority.js'), array(), null, false);

  // Add Main script
  wp_enqueue_script('sage/js/main', Assets\asset_path('scripts/app.main.js'), array(), null, false);
  
  if (!is_admin() && $GLOBALS['pagenow'] !== 'wp-login.php') {
    // Remove jQuery script
    wp_deregister_script('jquery');
  }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\js_assets', 100);


/**
 * Inline CSS in Head
 * Before other assets have been queued
 */
function inline_assets_head_before() {
  $fileToInline = get_template_directory() . '/dist/styles/' . basename(Assets\asset_path('styles/critical.css'));
  if ( file_exists($fileToInline) ) {
    echo '<style>';
    readfile($fileToInline);
    echo '</style>';
  }
}
add_action('wp_head', __NAMESPACE__ . '\\inline_assets_head_before', 1);


/**
 * Inline JS in Head
 * After styles, before other scripts
 */
function inline_assets_head_after() {
  $fileToInline = get_template_directory() . '/dist/scripts/' . basename(Assets\asset_path('scripts/app.inline.js'));
  
  if ( file_exists($fileToInline) ) {
    echo '<script>';
    readfile($fileToInline);
    echo '</script>';
  }
}
add_action('wp_head', __NAMESPACE__ . '\\inline_assets_head_after', 8);


/**
 * Login page assets
 */
function login_assets() {
  wp_enqueue_style('sage/css', Assets\asset_path('styles/app.main.css'), false, null);
}
add_action('login_enqueue_scripts', __NAMESPACE__ . '\\login_assets', 10);
