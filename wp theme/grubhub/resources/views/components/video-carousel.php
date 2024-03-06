<?php

/**
 * Video Carousel Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

require_once('helper-functions.php');
// Create id attribute allowing for custom "anchor" value.

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$vc_headline = call_user_func($field_or_subfield, 'vc_headline');
$vc_text_color = call_user_func($field_or_subfield, 'vc_text_color') ? : '#189096';
$vc_video_carousel = call_user_func($field_or_subfield, 'vc_video_carousel') ? : 'vc_video_carousel';
$video_headline = call_user_func($field_or_subfield, 'video_headline');
$vc_quotee = call_user_func($field_or_subfield, 'vc_quotee');
$vc_call_to_action_button = call_user_func($field_or_subfield, 'vc_call_to_action_button');
$vc_call_to_action_button_style = call_user_func($field_or_subfield, 'vc_call_to_action_button_style');
$video_link = call_user_func($field_or_subfield, 'video_link');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>
<style>
  .vc-headline {
    color: <?php echo $vc_text_color; ?> 

  }
</style>

<section id="videoCarousel" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <div class="row">
    <div class="columns medium-8 large-12">
      <div class="video-carousel">
        <?php print print_header($vc_headline, 'h2', ' class="vc-headline"'); ?>
        <div class="slider" data-slick='{ "dotsClass":"slick-dots" }'>
          <?php 
          if (have_rows('vc_video_carousel')) : 
            $i = 0;  
            ?>
            <?php while (have_rows('vc_video_carousel')) : the_row(); $i++; ?>
              <div class="vid-wrap">
                <?php print print_header(get_sub_field('video_headline'), 'p', ' class="head2-sub vc-pull-quote"'); ?>
                <?php if (get_field('vc_quotee') || get_sub_field('vc_quotee')): ?>
                  <p class="quotee"><?php the_sub_field('vc_quotee'); ?></p>
                <?php endif; ?>
                <?php if (get_field('video_link') || get_sub_field('video_link')): ?>
                <?php $video_link = get_sub_field('video_link'); ?>
                    <a class="subhead story-link text-link" href="<?php echo $video_link['url']; ?>" 
                      target="<?php echo $video_link['target']; ?>" 
                      aria-label="<?php echo $video_link['title']; ?>">
                      <?php echo $video_link['title']; ?></a>
                <?php endif; ?>
              <div class="responsive-embed widescreen video-container">
                <?php if (get_field('video_thumbnail') || get_sub_field('video_thumbnail')): ?>
                <?php $embedcode = get_sub_field('video_id');  ?>
                <iframe id="video-<?php echo $i; ?>" class="has-label" width="560" height="315" src="https://www.youtube.com/embed/<?php the_sub_field('video_id'); ?>?enablejsapi=1" title="YouTube video player" data-yt="<?php echo $embedcode; ?>" frameborder="0" allow="autoplay; accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" tabindex="-1" allowfullscreen></iframe>
                <label role="button" class="videoplay" tabindex="0">
                  <?php $video_thumbnail = get_sub_field('video_thumbnail'); ?>
                  <img src="<?php echo esc_url($video_thumbnail['url']); ?>" alt="<?php echo $video_thumbnail['alt']; ?>"/>
                </label>
                <?php else: ?>
                  <iframe id="video-<?php echo $i; ?>" width="560" height="315" src="https://www.youtube.com/embed/<?php the_sub_field('video_id'); ?>?enablejsapi=1" title="YouTube video player" frameborder="0" allow="autoplay; accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" tabindex="-1" allowfullscreen></iframe>
                <?php endif; ?>
              </div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>       
      </div>
      <?php if (get_field('vc_call_to_action_button') || get_sub_field('vc_call_to_action_button')): ?>
      <a class="button <?php echo $vc_call_to_action_button_style; ?> " href="<?php echo $vc_call_to_action_button['url']; ?>" target="<?php echo $vc_call_to_action_button['target']; ?>" ><?php echo $vc_call_to_action_button['title']; ?></a>   
    <?php endif; ?>
  </div>
</div>
</div>
</section>