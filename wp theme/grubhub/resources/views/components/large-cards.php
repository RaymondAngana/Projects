<?php

/**
 * Large Card Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$headline = call_user_func($field_or_subfield, 'card_headline');
$align = call_user_func($field_or_subfield, 'headline_alignment');
?>

<section class="large-cards gh-cards">
  <div class="row align-center sm" data-equalizer>
    <div class="columns large-10 medium-11 small-12">
      <div class="row align-center align-middle">
        <div class="columns">
        <?php if (!empty($headline)): ?>
           <h2 <?php echo $align ? 'class="'. $align .'"' : ''; ?>><?php echo $headline; ?></h2>
          <?php endif ?>
        </div>
      </div>
      <div class="row">
        <?php if (have_rows('card_card')) : ?>
          <?php while (have_rows('card_card')) : the_row(); ?>
            <div class="card-col large-6 medium-6 small-12 columns <?php echo get_field('disable_animation') ? '' : 'card-anim' ?>">
              <div class="card <?php echo get_sub_field('headline_color'); ?>" 
                style="background-image: url(<?php the_sub_field('background_image') ?>);">
              <?php if (!empty(get_sub_field('title'))): ?>
                <h2 <?php echo get_sub_field('headline_alignment') === "center" ? 'class="text-center"' : 'class="text-left"'; ?>>
                  <?php the_sub_field('title'); ?>
                </h2>
              <?php endif; ?>
                <div class="divider <?php echo get_sub_field('pipe_color'); ?>"></div>
              <?php if (!empty(get_sub_field('text'))): ?>
                <p <?php echo get_sub_field('headline_alignment') === "center" ? 'class="text-center head2-sub"' : 'class="text-left head2-sub"'; ?>>
                  <?php the_sub_field('text'); ?>
                </p>
              <?php endif; ?>
                <?php if (get_sub_field('button')): ?>
                  <?php $link = get_sub_field('button'); ?>
                  <a href="<?php echo $link['url']; ?>" 
                    target="<?php echo $link['target']; ?>" 
                    aria-label="<?php echo $link['title']; ?>" class="arrow-link <?php echo get_sub_field('button_alignment') === "left" ? 'text-left' : 'text-right'; ?>">
                    <?php echo $link['title']; ?>
                  </a>
                <?php endif ?>
              </div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>