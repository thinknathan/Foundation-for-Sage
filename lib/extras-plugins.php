<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;


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
* Turn on Gravity Forms no-conflict mode
*/
//add_filter('pre_option_gform_enable_noconflict', '__return_true' );

/**
* Prevents scripts from Gravity Forms shortcodes from being printed, and instead enqueues the scripts.
*/
add_filter( 'gform_disable_print_form_scripts', '__return_true' );
