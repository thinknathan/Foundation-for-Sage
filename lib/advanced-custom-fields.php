<?php

namespace Roots\Sage\AdvancedCustomFields;

/**
 * Adds convenient titles for ACF Flexible Content
 * 'acf_section_title' is used as the title
 */
function acf_flex_title( $title, $field, $layout, $i ) {
	if($value = get_sub_field('acf_section_title')) {
      $return_value = $title . ': ' . '<strong>' . $value . '</strong>';
      return $return_value;
	} else {
		foreach($layout['sub_fields'] as $sub) {
			if($sub['name'] == 'acf_section_title') {
				$key = $sub['key'];
				if(array_key_exists($i, $field['value']) && $value = $field['value'][$i][$key])
					return $value;
			}
		}
	}
	return $title;
}
add_filter( 'acf/fields/flexible_content/layout_title', __NAMESPACE__ . '\\acf_flex_title', 10, 4);
