<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;


/** 
 * Top nav menu walker
 * Adds Zurb Foundation class to submenus
 * @credit Brett Mason (https://github.com/brettsmason)
 *
 * Added is-dropdown-submenu to prevent FOUC, but might cause other issues if JS is disabled?
 */
class top_nav_walker extends \Walker_Nav_Menu {
  function start_lvl(&$output, $depth = 0, $args = Array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"menu vertical submenu is-dropdown-submenu\">\n";
  }
}

/** 
 * Off-Canvas menu walker
 * Adds Zurb Foundation classes to submenus
 */
class off_canvas_nav_walker extends \Walker_Nav_Menu {
  function start_lvl(&$output, $depth = 0, $args = Array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"menu vertical nested\">\n";
  }
}

/** 
 * Adds .is-dropdown-submenu-parent class to parent menu items
 * Only works with dropdown menus and not drilldown menus
 * @credit https://stackoverflow.com/questions/8448978/wordpress-how-do-i-know-if-a-menu-item-has-children
 */
function menu_set_dropdown( $sorted_menu_items, $args ) {
  // Stop unless it's the main dropdown menu
  if ($args->theme_location !== 'primary_navigation') {
    return $sorted_menu_items;
  }
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
 * https://www.davidtiong.com/using-defer-or-async-with-scripts-in-wordpress/
 */
function script_tag_defer($tag, $handle) {
	if (is_admin()) {
		return $tag;
	}
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.') !== false) {
		return $tag;
	} 
  if ($handle === 'sage/head') {
		return str_replace(' src',' async="async" src', $tag);
	}
	return str_replace(' src',' defer="defer" src', $tag);
}
add_filter('script_loader_tag', __NAMESPACE__ . '\\script_tag_defer', 10, 2);

/**
 * Adds preload syntax to enqueued stylesheets
 * Follows loadCSS setup
 * https://github.com/filamentgroup/loadCSS
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
 * Adds lazyloading syntax to images and iframes
 * https://github.com/aFarkas/wp-lazysizes
 * @credit Alexander Farkas
 * @license GPL-2.0+
 */
function filter_avatar( $content ) {
  if ( is_admin() || ( function_exists('is_amp_endpoint') && is_amp_endpoint() ) ) {
    return $content;
  }
  return filter_images( $content, 'noratio' );
}

function filter_iframes( $html ) {
  if ( is_admin() || ( function_exists('is_amp_endpoint') && is_amp_endpoint() ) ) {
    return $html;
  }
  if ( false === strpos( $html, 'iframe' ) ) {
    return $html;
  }
  return _add_class( $html, 'lazyload' );
}

function filter_images( $content, $type = 'ratio' ) {
  if ( is_admin() || ( function_exists('is_amp_endpoint') && is_amp_endpoint() ) ) {
    return $content;
  }
  
  if ( is_feed()
    || intval( get_query_var( 'print' ) ) == 1
    || intval( get_query_var( 'printpage' ) ) == 1
    || strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mini' ) !== false
  ) {
    return $content;
  }

  $respReplace = 'data-sizes="auto" data-srcset=';

  $matches = array();
  $skip_images_regex = '/class=".*lazyload.*"/';
  $placeholder_image = apply_filters( 'lazysizes_placeholder_image',
    'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' );
  preg_match_all( '/<img\s+.*?>/', $content, $matches );

  $search = array();
  $replace = array();

  foreach ( $matches[0] as $imgHTML ) {

    // Don't to the replacement if a skip class is provided and the image has the class.
    if ( ! ( preg_match( $skip_images_regex, $imgHTML ) ) ) {

      $replaceHTML = preg_replace( '/<img(.*?)src=/i',
        '<img$1src="' . $placeholder_image . '" data-src=', $imgHTML );

      $replaceHTML = preg_replace( '/srcset=/i', $respReplace, $replaceHTML );

      $replaceHTML = preg_replace( '/ sizes="(.*?)"/i', " ", $replaceHTML );

      $replaceHTML .= '<noscript>' . $imgHTML . '</noscript>';

      $replaceHTML = _add_class( $replaceHTML, 'lazyload' );

        if ( preg_match( '/width=["|\']*(\d+)["|\']*/', $imgHTML, $width ) == 1
          && preg_match( '/height=["|\']*(\d+)["|\']*/', $imgHTML, $height ) == 1 ) {

          $ratioBox = '<span class="intrinsic-ratio-box';
          if ( preg_match( '/(align(none|left|right|center))/', $imgHTML, $align_class ) == 1 ) {
            $ratioBox .= ' ' . $align_class[0];
            $replaceHTML = str_replace( $align_class[0], '', $replaceHTML );
          }

          $ratioBox .= '" style="max-width: ' . $width[1] . 'px; max-height: ' . $height[1] . 'px;';

          $ratioBox .= '"><span class="intrinsic-ratio-helper" style="padding-bottom: ';
          $replaceHTML = $ratioBox . (($height[1] / $width[1]) * 100) . '%;"></span>'
            . $replaceHTML . '</span>';
        }

      array_push( $search, $imgHTML );
      array_push( $replace, $replaceHTML );
    }
  }

  $content = str_replace( $search, $replace, $content );

  return $content;
}

function _add_class( $htmlString = '', $newClass ) {

  $pattern = '/class="([^"]*)"/';

  // Class attribute set.
  if ( preg_match( $pattern, $htmlString, $matches ) ) {
    $definedClasses = explode( ' ', $matches[1] );
      if ( ! in_array( $newClass, $definedClasses ) ) {
        $definedClasses[] = $newClass;
        $htmlString = str_replace(
          $matches[0],
          sprintf( 'class="%s"', implode( ' ', $definedClasses ) ),
          $htmlString
        );
      }

  // Class attribute not set.
  } else {
    $htmlString = preg_replace( '/(\<.+\s)/', sprintf( '$1class="%s" ', $newClass ), $htmlString );
  }

  return $htmlString;
}
add_filter('the_content',         __NAMESPACE__ . '\\filter_images', 200 );
add_filter('get_custom_logo',     __NAMESPACE__ . '\\filter_images', 200 );
add_filter('post_thumbnail_html', __NAMESPACE__ . '\\filter_images', 200 );
add_filter('widget_text',         __NAMESPACE__ . '\\filter_images', 200 );
add_filter('oembed_result',       __NAMESPACE__ . '\\filter_iframes', 200 );
add_filter('embed_oembed_html',   __NAMESPACE__ . '\\filter_iframes', 200 );
add_filter('get_avatar',          __NAMESPACE__ . '\\filter_avatar', 200 );
add_filter('acf_the_content',      __NAMESPACE__ . '\\filter_images', 200 );


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


/**
 * Converts Yoast breadcrumbs to Foundation 6 breadcrumbs
 */
function foundation_yoast_breadcrumb_output( $output ){
  // Kill span closing tags
  $from = '</span>'; 
  $to     = '';
  $output = str_replace( $from, $to, $output );
  
  // Kill the wrapper
  $from = '<span><span>'; 
  $to     = '<span>';
  $output = str_replace( $from, $to, $output );

  // Change the remaining span into a list item
  $from = '<span'; 
  $to     = '<li';
  $output = str_replace( $from, $to, $output );
  
  // Close list items after links
  $from = '</a>'; 
  $to     = '</a></li>';
  $output = str_replace( $from, $to, $output );

  // Screen reader text
  $from = '<li class="breadcrumb_last">'; 
  $to     = '<li class="last"><span class="show-for-sr">Current: </span>';
  $output = str_replace( $from, $to, $output );
  
  // Close final item
  $output = $output . '</li>';
  
  return $output;
}
if ( function_exists('yoast_breadcrumb') ) {
  add_filter( 'wpseo_breadcrumb_output', __NAMESPACE__ . '\\foundation_yoast_breadcrumb_output' );
}


/**
 * Changes .sticky class to .sticky-post for sticky posts
 * Zurb Foundation uses the .sticky class in its Sticky plugin
 * @credit https://github.com/brettsmason/croft/blob/master/inc/utility.php
 */
function sticky_post_class( $classes ) {
	if ( ( $key = array_search( 'sticky', $classes ) ) !== false ) {
		unset( $classes[$key] );
		$classes[] = 'sticky-post';
	}
	return $classes;
}
add_filter( 'post_class', __NAMESPACE__ . '\\sticky_post_class', 20 );


/**
 * Adds convenient titles for ACF Flexible Content
 * 'acf_section_title' is used as the title
 */
function acf_flex_title( $title, $field, $layout, $i ) {
	if($value = get_sub_field('acf_section_title')) {
      $return_value = $title . ': ' . '<strong>' . $value . '</strong>';
      return $return_value;
	} else {
		foreach($layout['sub_fields'] as $sub) {
			if($sub['name'] == 'acf_section_title') {
				$key = $sub['key'];
				if(array_key_exists($i, $field['value']) && $value = $field['value'][$i][$key])
					return $value;
			}
		}
	}
	return $title;
}
add_filter( 'acf/fields/flexible_content/layout_title', __NAMESPACE__ . '\\acf_flex_title', 10, 4);


/**
 * Fixes WooCommerce compatiblity with theme
 */
// Removes broken sidebar
remove_all_actions('woocommerce_sidebar');

// Removes breadcrumbs
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
