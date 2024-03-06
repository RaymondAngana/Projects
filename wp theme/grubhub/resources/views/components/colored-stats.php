<?php

/**
 * Colored Stats Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$cs_backgroundImage = call_user_func($field_or_subfield, 'cs_backgroundImage');
$background_color = call_user_func($field_or_subfield, 'background_color');
$text_align = call_user_func($field_or_subfield, 'text_align');
$tile_type = call_user_func($field_or_subfield, 'tile_type');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>
<style>
  .tile-image {
    background-image: url(<?php echo $cs_backgroundImage; ?>);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    min-height: 300px;
  }
  .text-left {
    text-align: left;
  }
  .text-center {
    text-align: center;
  }
</style>

<section id="coloredStats" class="colored-stats" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <div class="row align-center" data-equalizer>
    <?php if (have_rows('colored_stat')) : ?>
      <?php while (have_rows('colored_stat')) : the_row(); ?>
      <?php $background_color = get_sub_field('background_color') ?>
      <?php $background_image = get_sub_field('cs_backgroundImage') ?>
      <div class="stat-col columns <?php the_field('tile_width'); ?> <?php echo get_sub_field('tile_type') === 'tile-image' ? 'tile-image' : '' ?>" style="background-color:<?php echo get_sub_field('tile_type') === 'stat-tile' ? $background_color : '' ?>;background-image:url(<?php echo $background_image?>);">
          <div class="stat row align-center">
              <div class="stat-tiled">
                <?php if (get_sub_field('stat_item')): ?>
                  <h2 class="<?php the_sub_field('text_align'); ?>"><?php the_sub_field('stat_item'); ?></h2>
                <?php endif; ?>
                <?php if (get_sub_field('text')): ?>
                  <h3 class="head3-special <?php the_sub_field('text_align'); ?>"><?php the_sub_field('text'); ?></h3>
                  <?php endif; ?>
                </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
</div>
</section>