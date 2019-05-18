<?php

namespace Roots\Sage\WooCommerce;

/**
 * Fixes WooCommerce compatiblity with theme
 */
// Removes broken sidebar
remove_all_actions('woocommerce_sidebar');

// Removes breadcrumbs
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
