<?php

/**
 * Feature Contained Half Template.
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
$components = call_user_func($field_or_subfield, 'component_settings');
$padding = call_user_func($field_or_subfield, 'custom_padding');

if ($components) :
	$heading = $components['heading'];
	$text = $components['text'];
	$text_type = $components['text_type'];
	$bullet_items = $components['bullet_items'];
	$image = $components['image'];
	$cta = $components['cta'];
	$bg_color = $components['bg_color'];
	$txt = (!empty($text)) ? $text : 'Text Description';
	$is_animated = $components['animation'] ? '' : ' card-anim';

	$link_html = '';
	if (!empty($cta['text'])) {
		$link_html = '<div class="btn-wrap">' . print_cta($cta) . '</div>';
	}

	$column1 = '
		<div class="columns content-wrap small-12 large-6 text-center ' . $is_animated . '">
		  <div class="column align-center">' . print_header($heading, 'h3') .
			'<div class="text_content">' .
				print_text_or_bullet_items($text_type, $text, $bullet_items) .
			'</div>' . $link_html .
		  '</div>
		</div>';
	$column2 = '
		<div class="columns image-holder small-12 large-6 ' . $is_animated . '">
			<div class="circle-holder">
				<div class="circle ' . $bg_color . '"></div>
			</div>' . print_img($image) . 
		'</div>';
?>

<section class="feature-contained-half" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <div class="row align-middle contained <?=implode(' ', [$bg_color, $position]);?>">
	  <?php echo  $column1 . $column2; ?>
  </div>
</section>
<?php endif; ?>
