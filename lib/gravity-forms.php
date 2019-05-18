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
