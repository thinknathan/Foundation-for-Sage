<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;


/**
 * Limits items in bottom nav bar to 4
 * @credit https://www.isitwp.com/limit-amount-of-menu-items/
 */
function menu_limit_to_4($items, $args) {
  if ( $args->theme_location == 'navigation_navbar' ) {
    $toplinks = 0;
    foreach ( $items as $k => $v ) {
      if ( $v->menu_item_parent == 0 ) {
        $toplinks++;
      }
      if ( $toplinks > 4 ) {
        unset($items[$k]);
      }
    }
  }
  return $items;
}
add_filter( 'wp_nav_menu_objects', __NAMESPACE__ . '\\menu_limit_to_4', 10, 2 );


/** 
 * Top nav menu walker
 * Adds Zurb Foundation class to submenus
 * @credit Brett Mason (https://github.com/brettsmason)
 */
class walker_primary extends \Walker_Nav_Menu {
  function start_lvl(&$output, $depth = 0, $args = Array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"menu vertical submenu is-dropdown-submenu\">\n";
  }
}


/** 
 * Add `.button` class to anchors in Navbar Navigation
 */
function add_link_atts( $atts, $item, $args ) {
  if ( $args->theme_location == 'navigation_navbar' ) {
    $atts['class'] = "button";
  }
  return $atts;
}
add_filter( 'nav_menu_link_attributes', __NAMESPACE__ . '\\add_link_atts', 10, 3);


/** 
 * Adds .is-dropdown-submenu-parent class to parent menu items
 * @credit https://stackoverflow.com/questions/8448978/wordpress-how-do-i-know-if-a-menu-item-has-children
 */
function menu_set_dropdown( $sorted_menu_items, $args ) {
  $last_top = 0;
  foreach ( $sorted_menu_items as $key => $obj ) {
    // it is a top lv item?
    if ( 0 == $obj->menu_item_parent ) {
      // set the key of the parent
      $last_top = $key;
    } else {
      $sorted_menu_items[$last_top]->classes['is-dropdown-submenu-parent'] = 'is-dropdown-submenu-parent';
    }
  }
  return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', __NAMESPACE__ . '\\menu_set_dropdown', 10, 2 );


/**
 * Removes ID attributes from navigation menu items
 */
add_filter('nav_menu_item_id', '__return_null');


/**
 * Removes classes from navigation menu items
 * Adds Zurb Foundation active class to menu items
 */
function clean_nav_class($classes, $item) {
  $slug = sanitize_title($item->title);
  // Remove most core classes
  $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'menu-item-active', $classes);
  $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);
  // Re-add core `menu-item` class
  $classes[] = 'menu-item';
  // Add `menu-<slug>` class
  $classes[] = 'menu-' . $slug;
  // Formatting cleanup
  $classes = array_unique($classes);
  $classes = array_map('trim', $classes);
  return array_filter($classes);
}
add_filter('nav_menu_css_class', __NAMESPACE__ . '\\clean_nav_class', 10, 2);


/**
 * Adds post slug as a class to the <body>
 * Also adds class if sidebar is active
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }
  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');


/**
 * Adds aria labels to the pagination
 */
function prev_posts_link_attributes() {
  return 'aria-label="Previous page"';
}
add_filter('previous_posts_link_attributes', __NAMESPACE__ . '\\prev_posts_link_attributes');

function next_posts_link_attributes() {
  return 'aria-label="Next page"';
}
add_filter('next_posts_link_attributes', __NAMESPACE__ . '\\next_posts_link_attributes');


/**
 * Adds defer and async attributes to enqueued scripts
 * @credit David Tiong
 * @link https://www.davidtiong.com/using-defer-or-async-with-scripts-in-wordpress/
 */
function script_tag_defer($tag, $handle) {
	if (is_admin() || $GLOBALS['pagenow'] === 'wp-login.php') {
		return $tag;
	}
  if (function_exists('is_amp_endpoint') && is_amp_endpoint()) {
    return $tag;
  }
  if ($handle === 'jquery') {
    return $tag;
  }
  if ($handle === 'sage/js/priority') {
		return str_replace(' src',' async src', $tag);
	}
	return str_replace(' src',' defer src', $tag);
}
add_filter('script_loader_tag', __NAMESPACE__ . '\\script_tag_defer', 10, 2);


/**
 * Adds preload syntax to enqueued stylesheets
 * Follows loadCSS setup
 * @link https://github.com/filamentgroup/loadCSS
 */
function style_loadcss($html, $handle) {
	if (is_admin() || $GLOBALS['pagenow'] === 'wp-login.php') {
		return $html;
	}
  $originalHTML = $html;
  $html = str_replace('stylesheet', 'preload', $html);
  $html = str_replace(' href', ' as="style" onload="this.onload=null;this.rel=\'stylesheet\'" href', $html);
  $html = $html . '<noscript>' . $originalHTML . '</noscript>';
	return $html;
}
add_filter('style_loader_tag', __NAMESPACE__ . '\\style_loadcss', 20, 2);
