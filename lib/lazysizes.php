<?php

namespace Roots\Sage\Extras;

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

  $respReplace = 'data-sizes="auto" loading="lazy" data-srcset=';

  $matches = array();
  $skip_images_regex = '/class=".*lazyload.*"/';
  $placeholder_image = apply_filters( 'lazysizes_placeholder_image', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' );
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
