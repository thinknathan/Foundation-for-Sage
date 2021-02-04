<?php

namespace Roots\Sage\Util;

use Roots\Sage\Setup;
use Roots\Sage\Extras;
use Roots\Sage\Assets;


/**
 * Displays pagination for archives and paginated posts
 * @credit chuckn246 + JointsWP
 * @link https://github.com/JeremyEnglert/JointsWP
 */
function pagination($before = '', $after = '') {
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
	echo $before.'<nav class="nav nav--entry"><ul class="pagination" role="navigation" aria-label="Pagination">'."";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = __( 'First', 'sage' );
		echo '<li><a href="'.get_pagenum_link().'" title="'.$first_page_text.'" aria-label="First page">'.$first_page_text.'</a></li>';
	}
	echo '<li class="pagination__previous">';
	previous_posts_link( __('Previous', 'sage') );
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="pagination--current"><span class="show-for-sr">You\'re on page</span> '.$i.' </li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'" aria-label="Page '.$i.'">'.$i.'</a></li>';
		}
	}
	echo '<li class="pagination__next">';
	next_posts_link( __('Next', 'sage'), 0 );
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = __( 'Last', 'sage' );
		echo '<li><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'" aria-label="Last page">'.$last_page_text.'</a></li>';
	}
	echo '</ul></nav>'.$after."";
}


/**
 * Utility function to trim text by character, word, or sentence
 *
 * @param string   $text = string you want to trim
 * @param number   $length = length you want to arrive at
 * @param string   $length_type = words, or exact
 * @param string   $finish = word, or sentence
 * @return string  Filtered text
 *
 * @credit Adapted from WP advanced_exerpt plugin
 */

function snip( $text = '', $length = 50, $length_type = 'words', $finish = 'word' ) {
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
 * Displays Yoast SEO breadcrumbs
 */
function breadcrumbs() {
	if ( function_exists('yoast_breadcrumb') ) {
    yoast_breadcrumb(
      '<nav aria-label="You are here:" role="navigation" xmlns:v="http://rdf.data-vocabulary.org/#"><ul class="breadcrumbs">',
      '</ul></nav>'
    );
  }
}


/**
 * Determines whether or not the current post is a paginated post
 * @return boolean    true if the post is paginated; false, otherwise
 */
function is_paginated_post() {
	global $multipage;
	return 0 !== $multipage;
}


/**
 * Outputs image from local Assets folder
 */
function local_image($filename, $width = '', $height = '', $alt = '', $classes = '') {
  return '<img src="'
      . Assets\asset_path('images/' . $filename) . '"'
      . ' class="' . $classes . '"'
      . ' width="' . $width . '"'
      . ' height="' . $height . '"'
      . ' alt="' . $alt . '"'
      . '>';
}
