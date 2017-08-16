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
    if ($fp) {
      fwrite( $fp, $json );
      fclose( $fp );
    }
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
 * Automatically add IDs to headings such as <h2></h2>
 * Credit: http://jeroensormani.com/
 */
function auto_id_headings( $content ) {
	$content = preg_replace_callback( '/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function( $matches ) {
		if ( ! stripos( $matches[0], 'id=' ) ) :
			$matches[0] = $matches[1] . $matches[2] . ' id="h-' . sanitize_html_class( $matches[3] ) . '">' . $matches[3] . $matches[4];
		endif;
		return $matches[0];
	}, $content );
    return $content;
}
add_filter( 'the_content', __NAMESPACE__ . '\\auto_id_headings' );
