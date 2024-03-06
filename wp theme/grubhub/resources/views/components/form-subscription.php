<?php

/**
 * Subscription Form Component.
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$orientation = call_user_func($field_or_subfield, 'orientation') ? : 'Orientation';
$headline = call_user_func($field_or_subfield, 'form_headline') ? : 'Headline';
$formID = call_user_func($field_or_subfield, 'form_id') ? : 'Form ID';
$theme = call_user_func($field_or_subfield, 'theme') ? : 'Theme';
$headlineFont = call_user_func($field_or_subfield, 'headline_font_size') ? : 'Headline Font Size';
$formAlign = call_user_func($field_or_subfield, 'form_alignment');
$headlineAlign = call_user_func($field_or_subfield, 'headline_align');
$btnAlign = call_user_func($field_or_subfield, 'button_inline');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>
<div class="subscription-form <?php echo $theme; ?>" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">>
  <?php if ($orientation === 'vertical'): ?>
    <div class="row vertical <?php echo $formAlign === 'center' ? 'align-center' : 'align-left' ?>">
      <div class="columns small-12">
        <h2 class="<?php echo $headlineFont; ?> <?php echo $headlineAlign; ?>"><?php echo $headline; ?></h2>
      </div>
      <div class="fw-v columns <?php echo $formAlign === 'center' ? 'large-8 medium-10 small-12' : 'small-12' ?>">
        <div <?php echo $btnAlign ? 'class="btn-inline"' : '' ?>>
          <?php
          if (get_field('form_id') || get_sub_field('form_id')) {
            inc_form($formID);
          } else {
            echo '<p class="no-form">No form selected.</p>';
          }
          ?>
        </div>
      </div>
    </div>
    <?php else: ?>
      <div class="row align-center align-middle hz">
        <div <?php echo $headlineFont === 'large' ? 'class="columns large-8 medium-10 small-12 horizontal-stack"' : 'class="columns flex"' ?>>
          <h2 <?php echo $headlineFont === 'large' ? 'class="text-center ' . $headlineFont .'"' : 'class="text-left ' . $headlineFont .'"' ?>><?php echo $headline; ?></h2>
          <div class="form-wrap">
            <?php
            if (get_field('form_id') || get_sub_field('form_id')) {
              inc_form($formID);
            } else {
              echo '<p class="no-form">No form selected.</p>';
            }
            ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>