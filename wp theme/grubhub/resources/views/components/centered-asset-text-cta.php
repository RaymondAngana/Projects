<?php

/**
 * Centered Asset + Text with CTA Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

require_once('helper-functions.php');
$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$center_headline = call_user_func($field_or_subfield, 'center_headline');
$center_text = call_user_func($field_or_subfield, 'center_text') ? : 'Text';
$center_align_style = call_user_func($field_or_subfield, 'center_align_style') ? : 'Left';
$background_image = call_user_func($field_or_subfield, 'background_image');
$video_thumb = call_user_func($field_or_subfield, 'center_video_thumbnail');
$center_image = call_user_func($field_or_subfield, 'center_image');
$embedcode = call_user_func($field_or_subfield, 'center_video_id');
$center_call_to_action_button = call_user_func($field_or_subfield, 'center_call_to_action_button');
$vertOrientation = call_user_func($field_or_subfield, 'vert_orientation');
$btnStyle = call_user_func($field_or_subfield, 'center_call_to_action_button_style');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>

<style>
    .text-center {
      text-align: center;  
    }
    .text-left {
        width: 100%;
        text-align: left;
    }
    .text-left  p {
      margin: inherit;
      padding-bottom: 0;
    }
</style>


<section class="centered-content" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <div class="row align-center">
    <div class="columns small-12 medium-12 large-12 <?php echo $center_align_style; ?>">
      <?php if ($vertOrientation === 'top'): ?>
        <div class="top">
        <?php if (get_field('center_headline') || get_sub_field('center_headline')): ?>
            <?php print print_header($center_headline); ?>
          <?php endif ?>
          <?php if ($center_text !== 'Text'): ?>
            <p class="head3-sub"><?php echo $center_text; ?></p>  
          <?php endif ?>
          <?php if (get_field('center_call_to_action_button') || get_sub_field('center_call_to_action_button')): ?>
            <a class="button <?php echo $btnStyle; ?>" href="<?php echo $center_call_to_action_button['url']; ?>" target="<?php echo $center_call_to_action_button['target']; ?>" ><?php echo $center_call_to_action_button['title']; ?></a>
          <?php endif ?>
        </div>
      <?php endif ?>
      <?php if (get_field('asset_type') === 'image' || get_sub_field('asset_type') === 'image'): ?>
        <div class="image">
          <img src="<?php echo esc_url($center_image['url']); ?>" alt="<?php echo $center_image['alt']; ?>"/>
        </div>
      <?php else: ?>
        <?php if (get_field('center_video_thumbnail') || get_sub_field('center_video_thumbnail')): ?>
          <?php if (get_field('center_video_id') || get_sub_field('center_video_id')): ?>
          <div class="responsive-embed widescreen video-container">
            <iframe id="video-<?php echo $embedcode; ?>" class="has-label" width="560" height="315" src="https://www.youtube.com/embed/<?php echo $embedcode; ?>?enablejsapi=1" title="YouTube video player" tabindex="-1" data-yt="<?php echo $embedcode; ?>" frameborder="0" allow="autoplay; accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              <label role="button" class="videoplay" tabindex="0">
                <img src="<?php echo esc_url($video_thumb['url']); ?>" alt="<?php echo $video_thumb['alt']; ?>"/>
              </label>
              <?php endif; ?>
            <?php else: ?>
            <iframe id="video-<?php echo $embedcode; ?>" width="560" height="315" src="https://www.youtube.com/embed/<?php echo $embedcode; ?>" title="YouTube video player" tabindex="-1" frameborder="0" allow="autoplay; accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          <?php endif; ?>
      <?php endif; ?>
      <?php if ($vertOrientation === 'bottom'): ?>
        <div class="btm">
          <?php if (get_field('center_headline') || get_sub_field('center_headline')): ?>
            <?php print print_header($center_headline, 'h2'); ?>
          <?php endif; ?>
          <?php if ($center_text !== 'Text'): ?>
            <p class="head3-sub"><?php echo $center_text; ?></p>  
          <?php endif; ?>
          <?php if (get_field('center_call_to_action_button') || get_sub_field('center_call_to_action_button')): ?>
            <a class="button <?php echo $btnStyle; ?>" href="<?php echo $center_call_to_action_button['url']; ?>" target="<?php echo $center_call_to_action_button['target']; ?>" ><?php echo $center_call_to_action_button['title']; ?></a>
          <?php endif ?>
        </div>
      <?php endif; ?>
      </div>
    </div>
  </section>