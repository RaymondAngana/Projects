<?php

/**
 * Marquee Form Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

require_once('helper-functions.php');
$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$marq_headline = call_user_func($field_or_subfield, 'marq_headline');
$marq_subheadline = call_user_func($field_or_subfield, 'marq_subheadline');
$marquee_background_image = call_user_func($field_or_subfield, 'marquee_background_image') ? : '';
$marquee_mob_image = call_user_func($field_or_subfield, 'marquee_mob_image') ? : '';
$text_color = call_user_func($field_or_subfield, 'text_color') ? : '#189096';
$disable_animation = call_user_func($field_or_subfield, 'disable_animation') ? : '';
$showForm = call_user_func($field_or_subfield, 'show_form') ? : 'Show Form';
$formHeadline = call_user_func($field_or_subfield, 'form_headline');
$formSubheadline = call_user_func($field_or_subfield, 'form_subheadline');
$formFootHeadline = call_user_func($field_or_subfield, 'form_foot_headline');
$formFootSubheadline = call_user_func($field_or_subfield, 'form_foot_legal');
$formID = call_user_func($field_or_subfield, 'form_id') ? : 'Form ID';
?>
<style>
  .marq-col-content,
  .marq-col-content p {
    color: <?php echo $text_color; ?>
  }

  .marquee-bg {
    background-repeat: no-repeat;
    background-size: cover;
    background-image: none;
  }
  .marq-form-bg-mob {
    display: block;
    object-fit: cover;
    width: 100%;
    max-height: 60vw;
    object-position: top;
    padding-bottom: 0;
  }
  @media screen and (min-width: 768px) {
    .marq-form-bg-mob {
      max-height: 55vw;
    }
  }
  @media screen and (min-width: 1024px) {
    .marquee-bg {
      background-image: url(<?php echo $marquee_background_image; ?>);
      background-repeat: no-repeat;
      background-size: cover;
    }
    .marq-form-bg-mob {
      display: none;
    }
  }
</style>

<section id="marqForm" class="marq-form marquee-bg">
  <?php $marquee_background_image = get_field('marquee_background_image'); ?>
  <img src="<?php the_field('marquee_mob_image'); ?>" alt="" class="marq-form-bg-mob"/>
  <div class="marq-row  <?php echo get_field('disable_animation') ? '' : 'marq-anim' ?>">
    <div class="row align-center xlarge-justify">
      <div class="columns small-12 medium-12 marq-col-content <?php echo get_field('show_form') ? 'large-6' : 'large-12'; ?>">
        <?php print print_header($marq_headline, 'h1'); ?>
        <?php print print_header($marq_subheadline, 'p', ' class="head2-sub"'); ?>
      </div>
      <?php if (get_field('show_form')) :  ?>
        <div class="columns small-12 medium-12 large-5 column-form">
          <?php print print_header($formHeadline, 'h3', ' class="head3-special"'); ?>
          <?php print print_header($formSubheadline, 'p'); ?>
          <?php if (get_field('form_id')) {
            inc_form($formID);
          } else {
            echo '<p class="no-form">No form selected.</p>';
          }
          ?>
          <div class="bottom-form-text">
            <?php if (get_field('form_foot_headline')): ?>
              <span  class="bottom-form-head" ><?php the_field('form_foot_headline'); ?></span>
            <?php endif; ?>
            <?php if (get_field('form_foot_legal')): ?>
              <p><?php the_field('form_foot_legal'); ?></p> 
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
      <svg version="1.1" id="curve_overlay" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
      viewBox="0 0 1440 513" style="enable-background:new 0 0 1440 513;"  height="350px" width="100%" xml:space="preserve"  preserveAspectRatio="xMinYMin slice">
      <style type="text/css">
        .st0{fill:#FFFFFF;}
      </style>
      <path class="st0" d="M1440,198.8C1068.7,77.8,591.7,5,71.5,5C47.6,5,23.7,5.2,0,5.5V513h1440V198.8z"/>
    </svg>
    <svg id="curve_overlay_mobile" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 768 323.8136">
      <ellipse cx="6.5" cy="386" rx="974.5" ry="383" style="fill:#fff"/>
    </svg>
  </div>
</div>
</section>