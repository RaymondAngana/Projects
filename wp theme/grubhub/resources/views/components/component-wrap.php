<?php

/**
 * Component Wrap Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$bgStyle = get_field('wrapper_style');
$bg_style = isset($bgStyle) ? $bgStyle : 'white';
$add_decor = get_field('decoration') ? 'decoration' : '';
?>
<section class="component-wrap-outer">
  <?php if ($bgStyle === 'gray-curved'): ?>
    <div class="gray-curve"></div>
  <?php endif; ?>
  <div class="component-wrap <?php echo $bg_style; ?> <?php echo $add_decor; ?>">
    <InnerBlocks />
  </div>
  <?php if ($bgStyle === 'gray-curved'): ?>
    <div class="gray-bottom-curve"></div>
  <?php endif; ?>
</section>