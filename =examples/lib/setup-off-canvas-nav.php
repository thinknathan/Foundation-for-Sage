/**
 * Off-Canvas menu
 */
function off_canvas_nav() {
  wp_nav_menu([
    'theme_location' => 'mobile_navigation',        // Where it's located in the theme
    'container' => false,                           // Remove nav container
    'menu_class' => 'vertical menu',                // Adding custom nav class
    'items_wrap' => '<ul class="%2$s" data-drilldown data-auto-height="true" data-animate-height="true">%3$s</ul>',
    'depth' => 2,                                   // Limit the depth of the nav
    'fallback_cb' => false,                         // Fallback function (see below)
    'walker' => new Extras\off_canvas_nav_walker()
  ]);
}
