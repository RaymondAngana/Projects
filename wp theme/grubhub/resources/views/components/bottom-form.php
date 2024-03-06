<?php

/**
 * Bottom Form Template.
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$headline = call_user_func($field_or_subfield, 'bottom_headline') ? : 'Headline';
$subheadline = call_user_func($field_or_subfield, 'bottom_subheadline') ? : 'Sub Headline';
$formHeadline = call_user_func($field_or_subfield, 'form_headline') ? : 'Form Headline';
$formFoot = call_user_func($field_or_subfield, 'form_foot') ? : 'Form Bottom';
$formFootLink = call_user_func($field_or_subfield, 'form_foot_link') ? : 'Form Bottom Link';
$formID = call_user_func($field_or_subfield, 'form_id') ? : 'Form ID';

$formHeadline = str_replace('. All fields required.', '. <b>All fields required</b>.', $formHeadline);
?>
<section id="bottomForm" class="bottom-form">
  <div class="row align-justify align-middle">
    <div class="columns small-12 medium-12 large-6">
      <h2><?php echo $headline; ?></h2>
      <p class="head2-sub"><?php echo $subheadline; ?></p>
    </div>
    <div class="columns small-12 medium-12 large-5">
      <p class="form-text-area"><?php echo $formHeadline; ?></p>
      <?php
      if (isset($is_flex)) : 
        if (get_sub_field('form_id')) {
          inc_form($formID);
        } else {
          echo '<p class="no-form">No form selected.</p>';
        }
      else :
        if (get_field('form_id')) {
          inc_form($formID);
        } else {
          echo '<p class="no-form">No form selected.</p>';
        }
      endif;
      ?>
      <p class="form-text-area"><?php echo $formFoot; ?> <a href="<?php echo $formFootLink['url']; ?>" target="<?php echo $formFootLink['target']; ?>" aria-label="<?php echo $formFootLink['title']; ?>"><?php echo $formFootLink['title']; ?></a></p>
    </div>
  </div>
</section>