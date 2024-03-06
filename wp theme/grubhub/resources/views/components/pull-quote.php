<?php

/**
 * Pull Quote Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$pull_quote = call_user_func($field_or_subfield, 'pull_quote');
$pq_quotee = call_user_func($field_or_subfield, 'pq_quotee');
$quote_color = call_user_func($field_or_subfield, 'quote_color');
$pq_image = call_user_func($field_or_subfield, 'pq_image');
$pq_link = call_user_func($field_or_subfield, 'pq_link');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>
<style>
  .pull-quote-row::before,
  .pull-quote-row::after,
  .pull-quote::after,
  .quotee::after {
    color: <?php echo $quote_color; ?>;
  }
</style>


<section class="pull-quote" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
<?php $quote_color = get_sub_field('quote_color'); ?>
  <div class="row align-middle pull-quote-row <?php echo $quote_color; ?>" data-equalizer>
    <div class="columns image-column" >
      <img src="<?php echo $pq_image['url']; ?>" alt="<?php echo $pq_image['alt']; ?>"/>
    </div>
    <div class="columns" >
      <p class="head3-sub"><?php echo $pull_quote; ?></p>
      <p class="quotee"><?php echo $pq_quotee; ?></p>
      <?php if (get_sub_field('pq_link') || get_field('pq_link')): ?>
        <a class="text-link" href="<?php echo $pq_link['url']; ?>" target="<?php echo $pq_link['target']; ?>"><?php echo $pq_link['title']; ?></a>
      <?php endif; ?>
    </div>            
  </div>
</section>