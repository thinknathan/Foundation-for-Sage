<?php

namespace Roots\Sage\Yoast;

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
  $to     = '<li class="breadcrumbs--last"><span class="show-for-sr">Current: </span>';
  $output = str_replace( $from, $to, $output );
  
  // Close final item
  $output = $output . '</li>';
  
  return $output;
}
if ( function_exists('yoast_breadcrumb') ) {
  add_filter( 'wpseo_breadcrumb_output', __NAMESPACE__ . '\\foundation_yoast_breadcrumb_output' );
}
