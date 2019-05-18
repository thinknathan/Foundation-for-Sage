/** 
 * Off-Canvas menu walker
 * Adds Zurb Foundation classes to submenus
 */
class off_canvas_nav_walker extends \Walker_Nav_Menu {
  function start_lvl(&$output, $depth = 0, $args = Array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"menu vertical nested\">\n";
  }
}
