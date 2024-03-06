@extends('layouts.app')

@section('content')
<?php
$bg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
?>

<style>
  .marq-bg {
    background-image: url(<?php echo $bg[0]; ?>);
    height: 300px;
    background-repeat: no-repeat;
    background-position: top;
    background-size: cover;
    z-index: 1;
    position: relative;
  }
  @media screen and (min-width: 768px) {
    .marq-bg {
      background-image: url(<?php echo $bg[0]; ?>);
      height: 500px;
    }
  }
  @media screen and (min-width: 1024px) {
    .marq-bg {
      background-image: url(<?php echo $bg[0]; ?>);
      height: 800px;
      background-repeat: no-repeat;
      background-position: right;
    }
  }
</style>


<section id="marqHalfUnique" class="marq-half-unique">
  <div class="row align-right half-half">
    <div class="columns small-12 medium-12 large-5 marq-h-content">
      <ul class="article-info">
        <li class="duration">
          <?php echo do_shortcode('[read_meter]') ?>
        </li>
        <li>|</li>
        <?php if (!get_field('hide_published_date')): ?>
         <li class="date">
           <time class="updated" datetime="<?php echo get_post_time('c', true); ?>"><?php echo get_the_date(); ?></time>
         </li>
       <?php endif ?>
     </ul>
     <h1><?php the_title(); ?></h1>
     <div class="social-row">
      <div class="social-row-left">
        <ul class="left">
          <?php $author_id = $post->post_author; ?>
          <h4><?php echo get_the_author_meta( 'display_name', $author_id ); ?></h4>
        </ul>
      </div>
      <div class="social-row-right">
          <?php include('./social-media-icons.php'); ?>
      </div>
    </div>
  </div>
  <div class="columns small-12 medium-12 large-6 marq-bg"></div>
</div>  
</section>
<section class="article-body">
  <div class="row article-main">
    <div class="columns small-12 overlap">
      <div class="row align-center gray">
        <div class="columns xlarge-12 large-11 medium-11 small-11 subscription-form">
          <div class="row align-center align-middle hz">
            <div class="columns small-11 medium-11 large-12 flex">
              <h2 class="text-left medium"><?php the_field('form_headline'); ?></h2>
              <div class="form-wrap">
                <?php
                $formID = get_field('form_id');
                if (get_field('form_id')) {
                  inc_form($formID);
                } else {
                  echo '<p class="no-form">No form selected.</p>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php while (have_posts()) : the_post(); ?>
        <div class="row align-center gray">
          <div class="columns xlarge-12 large-11 medium-11 small-11 post">
            <div class="inner">
              <?php the_content(); ?>
            </div>
            <div class="right-rail">
              <?php dynamic_sidebar('sidebar-primary'); ?>
              <div class="tags">
                <?php
                $posttags = get_the_tags();
                if ($posttags) {
                  foreach($posttags as $tag) : ?>
                    <a href="<?php echo $tag->name . ' '; ?>"><?php echo $tag->name . ' '; ?></a>
                  <?php endforeach; ?>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php if (get_field('show_bottom_form')): ?>
  <section class="article-bottom">
    <div class="row align-middle align-center fw">
      <div class="columns small-12 medium-10 large-7">
        <h2 class="text-left"><?php the_field('bottom_form_headline') ?></h2>
        <div class="form-wrap">
          <?php
          $formID = get_field('bottom_form_id');
          if (get_field('form_id')) {
            inc_form($formID);
          } else {
            echo '<p class="no-form">No form selected.</p>';
          }
          ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>
<section class='components'>
  <?php
  if( have_rows('components')):
    while ( have_rows('components')) : the_row();
      switch (get_row_layout()) :
       case 'bottom_form_component':
           include get_template_directory() . '/views/components/bottom-form.php';
       break;
       case 'centered_asset_+_text_with_cta':
           include get_template_directory() . '/views/components/centered-asset-text-cta.php';
       break;
       case 'colored_stats_group_component':
           include get_template_directory() . '/views/components/colored-stats.php';
       break;
       case 'faq_component':
           include get_template_directory() . '/views/components/faq.php';
       break;
       case 'feature_component':
           include get_template_directory() . '/views/components/feature-components.php';
       break;
       case 'grid_cards_component':
           include get_template_directory() . '/views/components/grid-cards.php';
       break;
       case 'large_cards_component':
           include get_template_directory() . '/views/components/large-cards.php';
       break;
       case 'pull_quote_component':
           include get_template_directory() . '/views/components/pull-quote.php';
       break;
       case 'video_carousel':
           include get_template_directory() . '/views/components/video-carousel.php';
       break;
       case 'subscription_form_component':
           include get_template_directory() . '/views/components/form-subscription.php';
       break;
       case 'feed_cards_component':
           include get_template_directory() . '/views/components/feed-cards.php';
       break;
     endswitch;  
   endwhile;
 endif;
 ?>
</section>

@endsection
