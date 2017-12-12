<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;
use Roots\Sage\Extras;

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
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
  add_theme_support('abet-disable-comments');
  add_theme_support('abet-disable-yoast-admin-columns');
  add_theme_support('abet-gravity-forms-setup');
  add_theme_support('abet-gravity-forms-to-footer');
  add_theme_support('abet-tinymce-clean-paste');
  //add_theme_support('abet-default-setup');
  add_theme_support('abet-limit-revisions');
  //add_theme_support('abet-relevanssi-remove-meta');

  // Custom logo support
  //add_theme_support( 'custom-logo' );

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');
  
  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');
  
  remove_image_size('medium');
  set_post_thumbnail_size( 426, 265, true );
  add_image_size( 'tiny', 320, 380, false );
  add_image_size( 'small', 480, 480, false );
  add_image_size( 'medium', 640, 640, false );
  add_image_size( 'xlarge', 1200, 820, false );

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
  
  // Support Yoast SEO Breadcrumbs
  add_theme_support('yoast-seo-breadcrumbs');

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  //add_editor_style(Assets\asset_path('styles/main.css'));
  
  // ACF Options Page
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
  
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Top menu
 * Credit to chuckn246 + JointsWP Menu Code (https://github.com/JeremyEnglert/JointsWP)
 */
function top_nav() {
  wp_nav_menu([
    'theme_location' => 'primary_navigation',       // Where it's located in the theme
    'container' => false,                           // Remove nav container
    'menu_class' => 'dropdown menu',                // Adding custom nav class
    'items_wrap' => '<ul class="%2$s" data-dropdown-menu role="menubar">%3$s</ul>',
    'depth' => 3,                                   // Limit the depth of the nav
    'fallback_cb' => false,                         // Fallback function (see below)
    'walker' => new Extras\top_nav_walker()
  ]);
}

/**
 * Off-Canvas menu
 */
function off_canvas_nav() {
  wp_nav_menu([
    'theme_location' => 'mobile_navigation',        // Where it's located in the theme
    'container' => false,                           // Remove nav container
    'menu_class' => 'vertical menu',                // Adding custom nav class
    'items_wrap' => '<ul class="%2$s" data-drilldown>%3$s</ul>',
    'depth' => 5,                                   // Limit the depth of the nav
    'fallback_cb' => false,                         // Fallback function (see below)
    'walker' => new Extras\off_canvas_nav_walker()
  ]);
}


/**
 * Determine which pages should NOT display the sidebar
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
 * Theme assets
 */
function assets() {
  wp_enqueue_style('sage/fonts', Assets\asset_path('fonts/fonts.css'), false, null);
  
  wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css'), false, null);

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  // Internet Explorer JS and HTML polyfill 
  wp_enqueue_script('sage/headie', Assets\asset_path('scripts/head-ie.js'), array(), null, false);
  wp_script_add_data('sage/headie', 'conditional', 'IE');
  
  // Head script
  wp_enqueue_script('sage/head', Assets\asset_path('scripts/head.js'), array(), null, false);

  // jQuery
  wp_deregister_script('jquery');
  wp_enqueue_script('jquery', Assets\asset_path('scripts/jquery.js'), array(), null, true);
  
  // Queues jQuery functions until jQuery is loaded
  //$jquery_queue = '(function(a){a.jQuery||(a.jQueryQ=a.jQueryQ||[],a.$=a.jQuery=function(){a.jQueryQ.push(arguments)})})(window);';
  //wp_add_inline_script('jquery', $jquery_queue);
  
  // Theme script
  wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);

  // Internet Explorer CSS3 & Media Query polyfills
  wp_enqueue_script('sage/ie', Assets\asset_path('scripts/ie.js'), ['jquery'], null, true);
  wp_script_add_data('sage/ie', 'conditional', 'lt IE 9');
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

/**
 * Inline assets - Head - Before other scripts/styles have been queued
 */
function inline_assets_head_before() {
  echo '<style>';
  
  $fileToInline = get_template_directory() . '/dist/styles/' . basename(Assets\asset_path('styles/head-critical.css'));
  if ( file_exists($fileToInline) ) {
    readfile($fileToInline);
  }
  
  $fileToInline = get_template_directory() . '/dist/styles/' . basename(Assets\asset_path('styles/head-inline.css'));
  if ( file_exists($fileToInline) ) {
    readfile($fileToInline);
  }
  
  echo '</style>';
}
add_action('wp_head', __NAMESPACE__ . '\\inline_assets_head_before', 1);

/**
 * Inline assets - Head - After other scripts/styles have been queued
 */
function inline_assets_head_after() {
  $fileToInline = get_template_directory() . '/dist/scripts/' . basename(Assets\asset_path('scripts/head-inline.js'));
  
  if ( file_exists($fileToInline) ) {
    echo '<script>';
    readfile($fileToInline);
    echo '</script>';
  }
}
add_action('wp_head', __NAMESPACE__ . '\\inline_assets_head_after', 101);

/**
 * Inline assets - Footer - Before other scripts/styles have been queued
 */
function inline_assets_footer_before() {
  $fileToInline = get_template_directory() . '/dist/scripts/' . basename(Assets\asset_path('scripts/footer-inline.js'));
  
  if ( file_exists($fileToInline) && filesize($fileToInline) > 0 ) {
    echo '<script>';
    readfile($fileToInline);
    echo '</script>';
  }
}
add_action('wp_footer', __NAMESPACE__ . '\\inline_assets_footer_before', 1);

/**
 * Login page assets
 */
function login_assets() {
  wp_enqueue_style('sage/css', Assets\asset_path('styles/login.css'), false, null);
}
add_action('login_enqueue_scripts', __NAMESPACE__ . '\\login_assets', 10);
