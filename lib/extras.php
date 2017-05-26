<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  /*
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }
  */

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

class Foundation_Nav_Menu extends \Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = Array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"menu\">\n";
    }
}

/**
 * Add aria labels to the pagination
 */
add_filter('previous_posts_link_attributes', __NAMESPACE__ . '\\prev_posts_link_attributes');
function prev_posts_link_attributes() {
  return 'aria-label="Previous page"';
}
add_filter('next_posts_link_attributes', __NAMESPACE__ . '\\next_posts_link_attributes');
function next_posts_link_attributes() {
  return 'aria-label="Next page"';
}


/**
 * Top menu and off-canvas menu - Credit to chuckn246 + JointsWP Menu Code (https://github.com/JeremyEnglert/JointsWP)
 */

// The Top Menu
function top_nav() {
	wp_nav_menu([
		'container' => false,                           // Remove nav container
		'menu_class' => 'dropdown menu',       // Adding custom nav class
		'items_wrap' => '<div class="hide-for-small-only"><ul id="%1$s" class="%2$s" data-dropdown-menu role="navigation">%3$s</ul></div>',
		'theme_location' => 'primary_navigation',        			// Where it's located in the theme
		'depth' => 5,                                   // Limit the depth of the nav
		'fallback_cb' => false,                         // Fallback function (see below)
		'walker' => new Topbar_Menu_Walker()
	]);
}

// Big thanks to Brett Mason (https://github.com/brettsmason) for the awesome walker
class Topbar_Menu_Walker extends \Walker_Nav_Menu {
	function start_lvl(&$output, $depth = 0, $args = Array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"menu\">\n";
	}
}
// The Off Canvas Menu
function off_canvas_nav() {
	wp_nav_menu([
		'container' => false,                           // Remove nav container
		'menu_class' => 'vertical menu',       // Adding custom nav class
		'items_wrap' => '<ul id="%1$s" class="%2$s" data-drilldown>%3$s</ul>',
		'theme_location' => 'primary_navigation',        			// Where it's located in the theme
		'depth' => 5,                                   // Limit the depth of the nav
		'fallback_cb' => false,                         // Fallback function (see below)
		'walker' => new Off_Canvas_Menu_Walker()
	]);
}

class Off_Canvas_Menu_Walker extends \Walker_Nav_Menu {
	function start_lvl(&$output, $depth = 0, $args = Array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"vertical menu\">\n";
	}
}

// Add Foundation active class to menu
function required_active_nav_class( $classes, $item ) {
	if ( $item->current == 1 || $item->current_item_ancestor == true ) {
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', __NAMESPACE__ . '\\required_active_nav_class', 10, 2 );

/**
 * Numeric Page Navi - Credit to chuckn246 + JointsWP Code (https://github.com/JeremyEnglert/JointsWP)
 */
function page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	echo $before.'<nav class="page-navigation"><ul class="pagination text-center" role="navigation" aria-label="Pagination">'."";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = __( 'First', 'sage' );
		echo '<li><a href="'.get_pagenum_link().'" title="'.$first_page_text.'" aria-label="First page">'.$first_page_text.'</a></li>';
	}
	echo '<li class="pagination-previous">';
	previous_posts_link( __('Previous', 'sage') );
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="current"><span class="show-for-sr">You\'re on page</span> '.$i.' </li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'" aria-label="Page '.$i.'">'.$i.'</a></li>';
		}
	}
	echo '<li class="pagination-next">';
	next_posts_link( __('Next', 'sage'), 0 );
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = __( 'Last', 'sage' );
		echo '<li><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'" aria-label="Last page">'.$last_page_text.'</a></li>';
	}
	echo '</ul></nav>'.$after."";
}
