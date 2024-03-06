<?php

/**
 * Grid Card Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$headline = call_user_func($field_or_subfield, 'grid_headline');
$subheadline = call_user_func($field_or_subfield, 'grid_sub_headline');
$align = call_user_func($field_or_subfield, 'headline_alignment') ? : 'Headline Alignment';
$animation = call_user_func($field_or_subfield, 'disable_animation');
$type = call_user_func($field_or_subfield, 'grid_style');
$cols = call_user_func($field_or_subfield, 'tablet_grid_style');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>
<section class="grid-cards gh-cards" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <div class="row align-center align-middle">
    <div class="columns">
      <?php if (!empty($headline)): ?>
        <h2 class="<?php echo $align; echo $animation ? '' : ' card-anim'; ?>"><?php echo $headline; ?></h2>
      <?php endif; ?>
      <?php if (!empty($subheadline)): ?>
        <p class="head3-sub <?php echo $align; echo $animation ? '' : ' card-anim'; ?>"><?php echo $subheadline; ?></p>  
      <?php endif; ?>
    </div>
  </div>
  <div class="row align-center" data-equalizer>
    <?php if (have_rows('grid_card')) : ?>
      <?php while (have_rows('grid_card')) : the_row(); ?>
        <?php 
          $hdColor = get_sub_field('headline_color');
        ?>
        <div class="card-col columns <?php echo $type === 'three-up' ? 'large-4 ' : 'large-3 '; echo $cols === 'two-up-stacked' ? 'medium-6' : 'medium-10'; ?> small-12 <?php echo $animation ? '' : 'card-anim'; ?>" data-equalizer-watch>
          <div class="card <?php echo get_sub_field('card_style') === 'white' ? '' : (get_sub_field('card_style') === 'transparent' ? 'img-card' : ''); ?> <?php echo $hdColor; ?> <?php the_sub_field('image_only'); ?>">
            <?php $img = get_sub_field('image'); ?>
            <?php if (get_sub_field('image_type') === 'icon'): ?>
              <div class="icon <?php the_sub_field('image_size'); ?>">
                <img src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>" />
              </div>
              <?php else: ?>
                <div class="img">
                  <img src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>" />
                </div>
              <?php endif; ?>
              <?php if (get_sub_field('title')): ?>
                <h3  <?php echo get_sub_field('headline_alignment') === "center" ? 'class="text-center even subhead"' : 'class="text-left even subhead"'; ?>>
                  <?php the_sub_field('title'); ?>
                </h3>
              <?php endif; ?>
              <?php if (get_sub_field('text')): ?>
                <div <?php echo get_sub_field('headline_alignment') === "center" ? 'class="text-center p-even"' : 'class="text-left txt-pad p-even"'; ?>>
                  <?php the_sub_field('text'); ?>
                </div>
              <?php endif; ?>
              <?php if (get_sub_field('button')): ?>
                <?php $link = get_sub_field('button'); ?>
                <a href="<?php echo $link['url']; ?>" 
                  target="<?php echo $link['target']; ?>" 
                  aria-label="<?php echo $link['title']; ?>" class="button <?php the_sub_field('button_style'); ?>">
                  <?php echo $link['title']; ?>
                </a>
              <?php endif ?>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </section>