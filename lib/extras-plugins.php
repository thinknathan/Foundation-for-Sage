<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;


/**
 * Relevanssi & Yoast SEO compatibility
 */
function rlv_remove_meta_query( $query ) { 
  $query->query_vars['meta_query'] = null; 
  $query->meta_query = null; 
  return $query; 
}
add_filter( 'relevanssi_modify_wp_query', __NAMESPACE__ . '\\rlv_remove_meta_query', 999 ); 


**
 * Converts Yoast breadcrumbs to Foundation 6 breadcrumbs
 */
function custom_wpseo_breadcrumb_output( $output ){
  // Kill span closing tags
  $from = '</span>'; 
  $to     = '';
  $output = str_replace( $from, $to, $output );
  
  // Kill the wrapper
  $from = '<span xmlns:v="http://rdf.data-vocabulary.org/#">'; 
  $to     = '';
  $output = str_replace( $from, $to, $output );
  
  // Kill the individual items
  $from = '<span typeof="v:Breadcrumb">'; 
  $to     = '';
  $output = str_replace( $from, $to, $output );
  
  // Change the remaining span into a list item
  $from = '<span'; 
  $to     = '<li';
  $output = str_replace( $from, $to, $output );
  
  // Wrap the anchors with list items
  $from = '<a'; 
  $to     = '<li typeof="v:Breadcrumb"><a';
  $output = str_replace( $from, $to, $output );
  $from = '</a'; 
  $to     = '</li></a';
  $output = str_replace( $from, $to, $output );
  
  // Remove separators
  $from = '&raquo;'; 
  $to     = '';
  $output = str_replace( $from, $to, $output );
  
  // Screen reader text
  $from = '<li class="breadcrumb_last">'; 
  $to     = '<li class="last"><span class="show-for-sr">Current: </span>';
  $output = str_replace( $from, $to, $output );
  
  return $output;
}
if ( function_exists('yoast_breadcrumb') ) {
  add_filter( 'wpseo_breadcrumb_output', __NAMESPACE__ . '\\custom_wpseo_breadcrumb_output' );
}


/**
* Move Gravity Forms code to the footer
* Credit: https://gist.github.com/eriteric/5d6ca5969a662339c4b3
*/
add_filter( 'gform_init_scripts_footer', '__return_true' );

/**
* Delay gform functions until DOM is loaded
*/
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

/**
* Turn on Gravity Forms HTML5 output
*/
add_filter('pre_option_rg_gforms_enable_html5', '__return_true' );

/**
* Prevents scripts from Gravity Forms shortcodes from being printed, and instead enqueues the scripts.
*/
add_filter( 'gform_disable_print_form_scripts', '__return_true' );
