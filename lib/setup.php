<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  //add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage'),
    'mobile_navigation' => __('Mobile Navigation', 'sage')
  ]);
  
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

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  //add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  //add_editor_style(Assets\asset_path('styles/main.css'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Top menu - Credit to chuckn246 + JointsWP Menu Code (https://github.com/JeremyEnglert/JointsWP)
 */
function top_nav() {
  wp_nav_menu([
    'container' => false,                           // Remove nav container
    'menu_class' => 'dropdown menu',                // Adding custom nav class
    'items_wrap' => '<ul id="%1$s" class="%2$s" data-dropdown-menu role="navigation">%3$s</ul>',
    'theme_location' => 'primary_navigation',       // Where it's located in the theme
    'depth' => 5,                                   // Limit the depth of the nav
    'fallback_cb' => false,                         // Fallback function (see below)
    'walker' => new Topbar_Menu_Walker()
  ]);
}

// Credit: Brett Mason (https://github.com/brettsmason)
class Topbar_Menu_Walker extends \Walker_Nav_Menu {
  function start_lvl(&$output, $depth = 0, $args = Array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"dropdown menu\">\n";
  }
}

/**
 * Off-Canvas menu - Credit to chuckn246 + JointsWP Menu Code (https://github.com/JeremyEnglert/JointsWP)
 */
function off_canvas_nav() {
  wp_nav_menu([
    'container' => false,                           // Remove nav container
    'menu_class' => 'vertical menu',                // Adding custom nav class
    'items_wrap' => '<ul id="%1$s" class="%2$s" data-drilldown>%3$s</ul>',
    'theme_location' => 'mobile_navigation',        // Where it's located in the theme
    'depth' => 5,                                   // Limit the depth of the nav
    'fallback_cb' => false,                         // Fallback function (see below)
    'walker' => new Off_Canvas_Menu_Walker()
  ]);
}

// Credit: Brett Mason (https://github.com/brettsmason)
class Off_Canvas_Menu_Walker extends \Walker_Nav_Menu {
  function start_lvl(&$output, $depth = 0, $args = Array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"vertical menu\">\n";
  }
}

/**
 * Add Foundation active class to menu
 */
function required_active_nav_class( $classes, $item ) {
  if ( $item->current == 1 || $item->current_item_ancestor == true ) {
    $classes[] = 'active';
  }
  return $classes;
}
add_filter('nav_menu_css_class', __NAMESPACE__ . '\\required_active_nav_class', 10, 2);

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'sage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);

  register_sidebar([
    'name'          => __('Footer', 'sage'),
    'id'            => 'sidebar-footer',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
//add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

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
