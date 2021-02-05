<?php

namespace Roots\Sage\GravityForms;

/*
 * Enqueues jQuery when Gravity Forms in on the page
 * Not sure how stable this is, seems to make ajax forms buggy
 */
function add_jquery() {
  wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', array(), null, false );
}
add_action( 'gform_enqueue_scripts',  __NAMESPACE__ . '\\add_jquery', 10 );
