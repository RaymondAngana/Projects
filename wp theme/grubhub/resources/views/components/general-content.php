<?php

/**
 * General Content
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$content = call_user_func($field_or_subfield, 'content') ? : 'Content';
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>


<section class="general" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <div class="row">
    <div class="columns">
      <?php echo $content; ?>
    </div>            
  </div>
</section>