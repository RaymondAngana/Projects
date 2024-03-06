<?php

/**
 * Tile with Stacked Links Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$headline = call_user_func($field_or_subfield, 'tile_headline') ? : 'Headline';
$ts_title = call_user_func($field_or_subfield, 'ts_title') ? : 'Title';
$ts_text = call_user_func($field_or_subfield, 'ts_text') ? : 'Text';
$ts_posts = call_user_func($field_or_subfield, 'ts_posts');
$ts_pipe_color = call_user_func($field_or_subfield, 'ts_pipe_color');
$ts_button = call_user_func($field_or_subfield, 'ts_button') ? : 'button';
$ts_background = call_user_func($field_or_subfield, 'ts_background_image');
$tile_position = call_user_func($field_or_subfield, 'tile_position');
$link = call_user_func($field_or_subfield, 'ts_button');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>

<section id="tile-stack-links" class="tile-stack-links gh-cards" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <div class="row align-center <?php echo $tile_position; ?>">
    <div class="card-col large-5 medium-6 small-12 columns">
        <div class="card" 
        style="background-image: url(<?php echo $ts_background; ?>);">
        <h2>
          <?php echo $ts_title;  ?>
        </h2>
        <div class="divider <?php echo $ts_pipe_color; ?>"></div>
        <?php if (get_field('ts_text') || get_sub_field('ts_text')): ?>
          <p class="head2-sub">
              <?php echo $ts_text  ?>
          </p>
        <?php endif ?>
        <?php if (get_field('ts_button') || get_sub_field('ts_button')): ?>
                <a href="<?php echo $link['url']; ?>" 
                target="<?php echo $link['target']; ?>" 
                aria-label="<?php echo $link['title']; ?>" class="arrow-link">
                <?php echo $link['title']; ?>
                </a>
            <?php endif ?>
        </div>
    </div>
    <div class="large-7 medium-6 small-12 columns">
      <?php
      if( $ts_posts ): ?>
        <?php foreach( $ts_posts as $ts_post ): 
          $permalink = get_permalink( $ts_post->ID );
          $title = get_the_title( $ts_post->ID );
          ?>
          <a href="<?php echo $permalink; ?>"  class="post-row">
              <div class="img">
                <?php echo get_the_post_thumbnail($ts_post->ID); ?>
              </div>
              <div class="columns">
                  <h3 class="head3-special"><?php echo mb_strimwidth($title, 0, 50, '...'); ?></h3>
                  <p><?php echo wp_trim_words(get_the_excerpt($ts_post->ID), 12, '...'); ?></p>
              </div>
          </a>
          <?php endforeach; ?>
        <?php endif; ?>
    </div>
  </div>
</section>