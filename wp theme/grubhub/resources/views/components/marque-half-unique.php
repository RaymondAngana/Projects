<?php
/**
 * Marquee Half & Half Unique Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
 $vc_headline = call_user_func($field_or_subfield, 'marq_headline') ? : 'Headline';
 $backgroundImg = call_user_func($field_or_subfield, 'm_background_img') ? : 'Background Image';
 $backgroundImgMob = call_user_func($field_or_subfield, 'm_background_img_mobile') ? : 'Background Mobile';
 ?>

<style>
.marq-bg {
  background-image: url(/wp-content/themes/GrubHub/dist/images/marq-half-mob.png);
  height: 300px;
  background-repeat: no-repeat;
  background-position: top;
  background-size: cover;
}
@media screen and (min-width: 768px) {
  .marq-bg {
    background-image: url(/wp-content/themes/GrubHub/dist/images/marq-half.png);
    height: 700px;
    background-repeat: no-repeat;
    background-position: right;
  }
}
 </style>


<section id="marqHalfUnique" class="marq-half-unique">
  <div class="row align-justify half-half">
      <div class="columns small-12 medium-12 large-5 marq-h-content">
      <div class="row">
              <ul class="article-info">
                <li class="duration">
                 <h4>5 minutes </h4>
                </li>
                <li>|</li>
                <li class="date">
                 <h4>August 4, 2021</h4>
                </li>
              </ul>
          </div>
        <h1>6 reasons independent restaurants partner with food delivery apps</h1>
        <div class="social-row">
          <div class="social-row-left">
              <ul class="left">
                <h4>Author Name</h4>
              </ul>
          </div>
          <div class="social-row-right">
              <?php include('./social-media-icons.php'); ?>
            </div>
          </div>
      </div>
      <div class="columns small-12 medium-12 large-6 marq-bg">
      </div>
    </div>  
  </div>

</section>