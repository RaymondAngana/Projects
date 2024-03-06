<?php

/**
 * Marquee Half & Half Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
require_once('helper-functions.php');
$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$mh_headline = call_user_func($field_or_subfield, 'mh_headline');
$mh_subheadline = call_user_func($field_or_subfield, 'mh_subheadline');
$mh_text_color = call_user_func($field_or_subfield, 'mh_text_color') ? : '#189096';
$mh_backgroundImg = call_user_func($field_or_subfield, 'mh_background_img') ? : 'Background Image';
$mh_backgroundImgMob = call_user_func($field_or_subfield, 'mh_backgroundImgMob') ? : 'Background Mobile';
$mh_show_form = call_user_func($field_or_subfield, 'mh_show_form') ? : 'Show Form';
$mh_form_headline = call_user_func($field_or_subfield, 'mh_form_headline');
$mh_button = call_user_func($field_or_subfield, 'mh_button') ? : 'Button';
$mh_button_style = call_user_func($field_or_subfield, 'mh_button_style') ? : 'Button';
$mh_button_scroll = call_user_func($field_or_subfield, 'mh_button_scroll') ? : 'Scroll';
?>

<style>
  .marq-h-content {
    color: <?php echo $mh_text_color; ?>
  }

  .marq-bg {
    background-image: url(<?php echo $mh_backgroundImg; ?>);
    height: 300px;
    background-repeat: no-repeat;
    background-position: top;
    background-size: cover;
  }
  @media screen and (min-width: 768px) {
    .marq-bg {
      height: 670px;
      background-repeat: no-repeat;
    }
  }

  @media screen and (min-width: 1024px) {
    .marq-bg {
      height: 670px;
      background-repeat: no-repeat;
    }
  }

</style>

<section id="marqHalf">
  <div class="row align-justify align-middle half-half">
    <div class="columns small-12 medium-12 large-5 marq-h-content">
      <?php if (get_field('headline_type') === 'text' || get_sub_field('headline_type')): ?>
      <?php print print_header($mh_headline, 'h1'); ?>
      <?php else: ?>
      <?php $headlineImage = get_field('mh_image_headline', $postID); ?>
      <img src="<?php echo $headlineImage['url']; ?>" alt="<?php echo $headlineImage['alt']; ?>">
      <?php endif; ?>
      <?php print print_header($mh_subheadline, 'p', ' class="head2-sub"'); ?>
      <?php if (get_field('mh_button')): ?>
        <?php $link = get_field('mh_button'); ?>
        <a href="<?php echo $link['url']; ?>" 
          target="<?php echo $link['target']; ?>" 
          aria-label="<?php echo $link['title']; ?>" class="button <?php the_field('mh_button_style'); ?> <?php echo $mh_button_scroll ? 'nav-scroll' : ''; ?>">
          <?php echo $link['title']; ?>
        </a>
      <?php endif ?>
      <div class="subscription-form">
        <?php if (get_field('mh_show_form')) :  ?>
          <?php print print_header(get_field('mh_form_headline'), 'h3', ' class="text-left medium head3-special"'); ?>
          <div class="form-wrap">
            <?php
            $mh_formID = get_field('mh_formID');
            if (get_field('mh_formID')) {
              inc_form($mh_formID);
            } else {
              echo '<p class="no-form">No form selected.</p>';
            }
            ?>
          </div>
        <?php endif; ?>
        <?php if (get_sub_field('button')): ?>
          <?php $link = get_sub_field('button'); ?>
          <a href="<?php echo $link['url']; ?>" 
            target="<?php echo $link['target']; ?>" 
            aria-label="<?php echo $link['title']; ?>" class="button <?php the_sub_field('mh_button_style'); ?>">
            <?php echo $link['title']; ?>
          </a>
        <?php endif ?>
      </div>
    </div>
    <div class="columns small-12 medium-12 large-6 marq-bg">
    </div>
  </div>
</section>



