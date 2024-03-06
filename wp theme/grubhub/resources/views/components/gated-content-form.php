<?php

/**
 * Gated Content Form Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

require_once('helper-functions.php');
// Create id attribute allowing for custom "anchor" value.
$id = 'gc-' . $block['id'];
if( !empty($block['anchor']) ) {
  $id = $block['anchor'];
}

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$gc_form_image = call_user_func($field_or_subfield, 'gc_form_image') ? : '';
$formHeadline = call_user_func($field_or_subfield, 'gc_form_headline');
$formSubheadline = call_user_func($field_or_subfield, 'gc_form_subheadline');
$formFootHeadline = call_user_func($field_or_subfield, 'gc_form_foot_headline');
$formFootSubheadline = call_user_func($field_or_subfield, 'gc_form_foot_legal');
$formID = call_user_func($field_or_subfield, 'gc_form_id');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>

<section id="gcForm" class="gc-form" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
    <div class="row align-justify align-middle">
      <div class="columns small-12 medium-12 large-6">
        <?php $gc_form_image = get_field('gc_form_image'); ?>
        <img src="<?php echo esc_url($gc_form_image['url']); ?>" alt="<?php echo $gc_form_image['alt']; ?>"/>
      </div>
        <div class="columns small-12 medium-12 large-5  gc-form">
            <?php if (!empty($formHeadline)): ?>
            <h3 class="head3-special"><?php the_field('gc_form_headline'); ?></h3>
            <?php endif; ?>
            <?php if (!empty($formSubheadline)): ?>
            <p><?php the_field('gc_form_subheadline'); ?></p> 
            <?php endif; ?>
            <?php if (get_field('gc_form_id')) {
                inc_form($formID);
            } else {
                echo '<p class="no-form">No form selected.</p>';
            }
            ?>
            <div class="bottom-form-text">
            <?php if (get_field('gc_form_foot_legal')): ?>
            <p><?php the_field('gc_form_foot_legal'); ?></p> 
            <?php endif; ?>
          </div>
        </div>
  </div>
</section>