<?php

/**
 * Feature Split Flushed Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

require_once('helper-functions.php');
$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$position = call_user_func($field_or_subfield, 'position');
$wrapper = call_user_func($field_or_subfield, 'wrapper_type');
$components = call_user_func($field_or_subfield, 'component_settings');
$padding = call_user_func($field_or_subfield, 'custom_padding');

if ($components) :
	$heading = $components['heading'];
  $is_caption = $heading['add_caption'];
  $caption = $heading['caption'];
  $text = $components['text'];
  $text_type = $components['text_type'];
  $bullet_items = $components['bullet_items'];
  $image = $components['image'];
  $cta = $components['cta'];

  $location = $heading['heading_location'];
  $is_animated = $components['animation'] ? '' : 'card-anim';

  $link_html = '';
  if (!empty($cta['text'])) {
    $link_html = '<div class="btn-wrap">' . print_cta($cta) . '</div>';
  }

  $markup = print_text_or_bullet_items($text_type, $text, $bullet_items);
  $content = [$markup, $link_html];
  if (!empty($heading['text'])) {
   $header = print_header($heading);
   $header = $is_caption ? ("<strong>$caption</strong>" . $header) : $header; 
 }
 if ($location != 'top') {
  array_unshift($content, $header);
}
$column1 = '<div class="columns image-holder small-12 large-6 ' . implode(' ', [$is_animated]) . '">' . print_img($image) . '</div>';
$column2 = '
<div class="content-wrap columns small-12 large-6 ' . implode(' ', [$is_animated]) . '" >' .
'<div class="text-wrap text-left">' .
implode('', $content) .
'</div>
</div>';
?>
<section class="feature-split-flushed" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <?php
  $html = '';
  $html .= ($location == 'top') ? "<div class='row heading-top'>$header</div>" : '';
  $html .= '<div class="row align-center collapse ' . (($location == 'top') ? 'content-top ' : 'align-middle ') . $wrapper . ' ' . $position . '">';
  $html .= $column1 . $column2;
  $html .= '</div>';
  print $html;
  ?>
</section>
<?php endif; ?>
