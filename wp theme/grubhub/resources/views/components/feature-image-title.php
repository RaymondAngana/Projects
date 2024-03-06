<?php

/**
 * Featured Image and Title.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$feature_title = call_user_func($field_or_subfield, 'feature_title') ? : 'Title';
$feature_text = call_user_func($field_or_subfield, 'feature_text') ? : 'Text';
$text_color = call_user_func($field_or_subfield, 'text_color') ? : '#000000';
$feature_image = call_user_func($field_or_subfield, 'feature_image');
$textAlign = call_user_func($field_or_subfield, 'text_align');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>
<style>
  .text-column,
  .text-column p {
    color: <?php echo $text_color; ?> 
  }

  .text-left {
    text-align: left;
  }

  .text-center {
    text-align: center;
  }
</style>


<section class="feature-image-title" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <div class="row align-middle feature-row" data-equalizer>
    <div class="columns image-column" >
      <?php if (get_field('feature_image') || get_sub_field('feature_image')): ?>
        <img src="<?php echo $feature_image['url']; ?>" alt="<?php echo $feature_image['alt']; ?>"/>
      <?php endif; ?>
    </div>
    <div class="columns text-column <?php echo $textAlign; ?>">
     <?php if (get_field('feature_title') || get_sub_field('feature_title')): ?>
      <h3><?php echo $feature_title; ?></h3>
    <?php endif; ?>
    <?php if (get_field('feature_text') || get_sub_field('feature_text')): ?>
      <p class="head3-sub"><?php echo $feature_text; ?></p>
    <?php endif; ?>
  </div>            
</div>
</section>