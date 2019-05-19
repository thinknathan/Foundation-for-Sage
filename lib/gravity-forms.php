<?php

namespace Roots\Sage\GravityForms;

/*
 * Changes Gravity Forms submit input to button
 * https://gist.github.com/mannieschumpert/8334811
 */
function form_submit_button ( $button, $form ){
  $button = str_replace( "input", "button", $button );
  $button = str_replace( "/", "", $button );
  $button .= "{$form['button']['text']}</button>";
  return $button;
}
add_filter( 'gform_submit_button', __NAMESPACE__ . '\\form_submit_button', 10, 5 );


/*
 * Enqueues jQuery when Gravity Forms in on the page
 * Not sure how stable this is, seems to make ajax forms buggy
 */
function add_jquery() {
  wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-1.12.4.min.js', array(), null, false );
}
add_action( 'gform_enqueue_scripts',  __NAMESPACE__ . '\\add_jquery', 10 );
