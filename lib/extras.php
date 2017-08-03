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
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

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

/**
 * Foundation navigation menu
 */
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
		'menu_class' => 'dropdown menu',                // Adding custom nav class
		'items_wrap' => '<ul id="%1$s" class="%2$s" data-dropdown-menu role="navigation">%3$s</ul>',
		'theme_location' => 'primary_navigation',       // Where it's located in the theme
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
		'menu_class' => 'vertical menu',                // Adding custom nav class
		'items_wrap' => '<ul id="%1$s" class="%2$s" data-drilldown>%3$s</ul>',
		'theme_location' => 'primary_navigation',       // Where it's located in the theme
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

/**
 * Add defer and async attributes to enqueued scripts.
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
 * Change styles to use preload syntax ala loadCSS
 */
function style_loadCSS($html, $handle) {
	if (is_admin() || $GLOBALS['pagenow'] === 'wp-login.php') {
		return $html;
	}
  $originalHTML = $html;
  $html = str_replace('stylesheet','preload', $html);
  $html = str_replace(' href',' as="style" onload="this.rel=\'stylesheet\'" href', $html);
  $html = $html . '<noscript>' . $originalHTML . '</noscript>';
	return $html;
}
add_filter('style_loader_tag', __NAMESPACE__ . '\\style_loadCSS', 20, 2);

/**
 * Adds screen-reader content to Yoast breadcrumbs
 */
function custom_wpseo_breadcrumb_output( $output ){
  $from = '<span class="breadcrumb_last">'; 
  $to     = '<span class="breadcrumb_last"><span class="show-for-sr">Current: </span>';
  $output = str_replace( $from, $to, $output );
  return $output;
}
if ( function_exists('yoast_breadcrumb') ) {
  add_filter( 'wpseo_breadcrumb_output', __NAMESPACE__ . '\\custom_wpseo_breadcrumb_output' );
}

/**
 * WP LazySizes * https://github.com/aFarkas/wp-lazysizes * Alexander Farkas * GPL-2.0+
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

// Run this later, so other content filters have run, including image_add_wh on WP.com
add_filter('the_content', __NAMESPACE__ . '\\filter_images', 200 );
add_filter('post_thumbnail_html', __NAMESPACE__ . '\\filter_images', 200 );
add_filter('widget_text', __NAMESPACE__ . '\\filter_images', 200 );
add_filter('oembed_result', __NAMESPACE__ . '\\filter_iframes', 200 );
add_filter('embed_oembed_html', __NAMESPACE__ . '\\filter_iframes', 200 );
add_filter('get_avatar', __NAMESPACE__ . '\\filter_avatar', 200 );



/**
 * Utility function to trim text
 *
 * @param string   $text = string you want to trim
 * @param number   $length = length you want to arrive at
 * @param string   $length_type = words, or exact
 * @param string   $finish = word, or sentence
 * @return string  Filtered text
 *
 * Adapted from WP advanced_exerpt plugin
 */

function Snip( $text = '', $length = 50, $length_type = 'words', $finish = 'word' ) {
  $ellipsis = '&hellip;';
  $tokens = [];
  $allowed_tags = [
    'abbr', 'acronym', 'address', 'cite', 'code', 'del', 'ins', 'q', 's', 'strike', 'sub', 'sup', 'time'
  ];
  $tag_string = [];
  $out = '';
  $w = 0;
  $shortened = false;

  // From the default wp_trim_excerpt():
  // No shortcodes!
  $text = strip_shortcodes( $text );
  
  // From the default wp_trim_excerpt():
  // Some kind of precaution against malformed CDATA in RSS feeds I suppose
  $text = str_replace( ']]>', ']]&gt;', $text );

  // Make array of allowed tags
  $tag_string = '<' . implode( '><', $allowed_tags ) . '>';
      
  // Remove all but the allowed tags
  $text = strip_tags( $text, $tag_string );
  
  // Divide the string into tokens; HTML tags, or words, followed by any whitespace
  // (<[^>]+>|[^<>\s]+\s*)
  preg_match_all( '/(<[^>]+>|[^<>\s]+)\s*/u', $text, $tokens );
  foreach ( $tokens[0] as $t ) { // Parse each token
    if ( $w >= $length && 'sentence' != $finish ) { // Limit reached
      break;
    }
    if ( $t[0] != '<' ) { // Token is not a tag
      if ( $w >= $length && 'sentence' == $finish && preg_match( '/[\?\.\!]\s*$/uS', $t ) == 1 ) { // Limit reached, continue until ? . or ! occur at the end
        $out .= trim( $t );
        break;
      }
      if ( 'words' == $length_type ) { // Count words
        $w++;
      } else { // Count/trim characters
        $chars = trim( $t ); // Remove surrounding space
        $c = strlen( $chars );
        if ( $c + $w > $length && 'sentence' != $finish ) { // Token is too long
          $c = ( 'word' == $finish ) ? $c : $length - $w; // Keep token to finish word
          $t = substr( $t, 0, $c );
        }
        $w += $c;
      }
    }
    // Append what's left of the token
    $out .= $t;
  }
  
  // Check to see if any trimming took place
  if (strlen($out) < strlen($text)) {
    $shortened = true;
  }
  	
  // Trim whitespace
  $out = trim( force_balance_tags( $out ) );
    
  // Add the ellipsis if text has been shortened
  if ($shortened) {
    $out .= $ellipsis;
  }

  return $out;
}

/**
 * Displays post meta - adapted from Twenty Fifteen theme
 */
function entry_meta($options = [
  'output_author'        => true,
  'output_publish_date'  => true,
  'output_modified_date' => true,
  'output_post_format'   => true,
  'output_categories'    => true,
  'output_tags'          => true
  ]) {
  
  // Author
  if ( $options['output_author'] ) {
    printf( '<span class="meta byline author vcard"><span class="screen-reader-text">%1$s </span><a rel="author" class="fn" href="%2$s">%3$s</a></span>',
      __('By', 'sage'),
      esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
      get_the_author()
    );
  }
  
  // Publish and Modified Date
  if ( $options['output_publish_date'] ) {
		$time_string = '<time class="meta published" datetime="%1$s">%2$s</time>';

		if ( $options['output_modified_date'] && get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="meta published" datetime="%1$s">%2$s</time><time class="meta updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		printf( '<span class="meta posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			__( 'Posted on', 'sage' ),
			esc_url( get_permalink() ),
			$time_string
		);
  }
  
  // Formats
	$format = get_post_format();
	if ( $options['output_post_format'] && current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="meta entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', __( 'Format', 'sage' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

  // List Categories
  $categories_list = get_the_category_list( ', ' );
  if ( $options['output_categories'] && $categories_list ) {
    printf( '<span class="meta cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
      __( 'Categories', 'sage' ),
      $categories_list
    );
  }

  // List Tags
  $tags_list = get_the_tag_list( ', ' );
  if ( $options['output_tags'] && $tags_list ) {
    printf( '<span class="meta tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
      __( 'Tags', 'sage' ),
      $tags_list
    );
  }
}

/**
 * Determines whether or not the current post is a paginated post.
 * @return boolean    true if the post is paginated; false, otherwise.
 */
function is_paginated_post() {
	global $multipage;
	return 0 !== $multipage;
}

/**
 * Creates a sitemap for gulp tasks to parse.
 * Only active in development environments.
 * Activates each time a post is saved.
 */
function create_sitemap() {
  if (WP_ENV === 'development') {
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
    fwrite( $fp, $json );
    fclose( $fp );
  }
}
add_action('save_post', __NAMESPACE__ . '\\create_sitemap');

/**
* Login page logo link to homepage instead of WP
*/
function login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', __NAMESPACE__ . '\\login_logo_url' );

/**
* Login page logo title text to website title
*/
function login_logo_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertitle', __NAMESPACE__ . '\\login_logo_title' );

/**
* Login page custom logo
*/
function login_logo() { ?>
  <style>
    #login h1 a, .login h1 a {
      background-image: url(<?= get_stylesheet_directory_uri(); ?>/dist/images/logo.svg);
      width: 320px;
      height: 80px;
      background-size: 320px 80px;
    }
  </style>
<?php }
add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\login_logo' );

/**
* Move Gravity Forms code to the footer
* Credit: https://gist.github.com/eriteric/5d6ca5969a662339c4b3
*/
add_filter( 'gform_init_scripts_footer', '__return_true' );

function wrap_gform_cdata_open( $content = '' ) {
  if ( ( defined('DOING_AJAX') && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
      return $content;
  }
  $content = 'document.addEventListener( "DOMContentLoaded", function() { ';
  return $content;
}
add_filter( 'gform_cdata_open', __NAMESPACE__ . '\\wrap_gform_cdata_open', 1 );

function wrap_gform_cdata_close( $content = '' ) {
  if ( ( defined('DOING_AJAX') && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
    return $content;
  }
  $content = ' }, false );';
  return $content;
}
add_filter( 'gform_cdata_close', __NAMESPACE__ . '\\wrap_gform_cdata_close', 99 );

/**
* Turn off Gravity Forms CSS
*/
add_filter( 'pre_option_rg_gforms_disable_css', '__return_true' );
