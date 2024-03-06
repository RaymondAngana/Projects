<?php
/**
 * Helper-functions.php is a consolidation of all reusable functions
 * that is primarily used in the components.
 */

/**
 * Print CTA link with attributes and values.
 * @param $cta
 * @return HTML markup of call-to-action
 */
function print_cta($cta) {
  $attr = '';
  $scroll = isset($cta['scroll_link']) ? ' nav-scroll' : '';
  $cta_tag_attr = [
    'class' => 'button ' . $cta['style'] . $scroll,
    'href' => esc_url($cta['url']),
    'aria-label' => esc_html($cta['text']),
  ];

  foreach($cta_tag_attr as $key => $value) {
    $attr .= $key . '="' . $value . '" ';
  }
  return "<a $attr><span>" . $cta['text'] . "</span></a>";
}

/**
 * Print H2 or H3 heading.
 * @param $heading
 * @return HTML markup of h2 or h3 headers.
 */
function print_header($heading, $style = 'h2', $attr = '') {
	$headline = is_array($heading) ? $heading['text'] : $heading;
	if (! empty($headline)) {
      return sprintf('<%1$s' . $attr . '>%2$s</%1$s>', $style, $headline);
    }
}

/**
 * Prints plain text or bullet items.
 * @param $text_type
 * @param $text
 * @param $bullet_items
 * @return HTML markup of the content.
 */
function print_text_or_bullet_items($text_type, $text, $bullet_items, $subheading = '') {
	$markup = '';
	if ($text_type != 'bullet' && $text != '') {
		$markup = "<p>$text</p>";
	}
	elseif ($text_type == 'bullet') {
        $markup = print_bullet_items($bullet_items, $subheading);
	}
	return $markup;
}

/**
 * Print bullet items.
 * @param $bullet_items
 * @param $subheading
 */
function print_bullet_items($bullet_items, $subheading) {
    $markup = $subheading != '' ? "<p class='subheading'>$subheading</p>" : "";
    $markup .= '<ul class="items">';
    foreach ($bullet_items as $item) {
        $markup .= '<li aria-level="1">';
        $markup .= array_key_exists('heading', $item) ? '<strong>' . $item['heading'] . '</strong>' : '';
        $markup .= $item['content'];
        $markup .= '</li>';
    }
    $markup .= '</ul>';
    return $markup;
}

/**
 * Returns image markup.
 * @param $image
 * @return string
 */
function print_img($image, $classes = []) {
    $class = (!empty($classes)) ? (' class="' . implode(' ', $classes) . '"') : '';
	if (isset($image)) {
		return '<img' . $class . ' src="' . esc_url($image['url']) . '" alt="' . $image['alt'] . '" />';
	}
}
