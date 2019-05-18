<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;


/** 
 * Top nav menu walker
 * Adds Zurb Foundation class to submenus
 * @credit Brett Mason (https://github.com/brettsmason)
 */
class top_nav_walker extends \Walker_Nav_Menu {
  function start_lvl(&$output, $depth = 0, $args = Array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"menu vertical submenu is-dropdown-submenu\">\n";
  }
}


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
  $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes);
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
 * Cleans up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');


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


/**
 * Simplifies toolbar options in the TinyMCE editor
 * Also specifies text formats
 */
function configure_tinymce( $in ) {
  $in['toolbar1'] = 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,removeformat,wp_fullscreen ';
	$in['toolbar2'] = '';
  $in['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4';
  return $in;
}
add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\\configure_tinymce' );


/**
 * Simplifies toolbar options in the TinyMCE editor
 * Applies to WYSIWYG editor in Advanced Custom Fields
 */
function configure_tinymce_acf( $toolbars ) {
  $toolbars['Custom'] = array();
  $toolbars['Custom'][1] = array('formatselect', 'bold', 'italic', 'bullist', 'numlist', 'blockquote', 'alignleft', 'aligncenter', 'alignright', 'link', 'unlink', 'removeformat', 'wp_fullscreen' );
  // remove the 'Basic' toolbar completely
  unset( $toolbars['Basic' ] );
  // remove the 'Full' toolbar completely
  unset( $toolbars['Full' ] );
  // return $toolbars
  return $toolbars;
}
add_filter( 'acf/fields/wysiwyg/toolbars', __NAMESPACE__ . '\\configure_tinymce_acf' );
