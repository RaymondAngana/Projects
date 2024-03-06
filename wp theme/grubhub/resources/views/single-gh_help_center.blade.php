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
        <?php if (!get_field('hide_published_date')): ?>
        <li>|</li>
        <li class="date">
         <time class="updated" datetime="<?php echo get_post_time('c', true); ?>"><?php echo get_the_date(); ?></time>
       </li>
       <?php endif ?>
     </ul>
     <h1><?php the_title(); ?></h1>
     <div class="social-row">
      <div class="social-row-left">
        <?php if (!get_field('hide_author')): ?>
        <ul class="left">
          <?php $author_id = $post->post_author; ?>
          <h3 class="head3-special"><?php echo get_the_author_meta( 'display_name', $author_id ); ?></h3>
        </ul>
        <?php endif ?>
      </div>
      <div class="social-row-right">
       <?php include get_template_directory() . '/views/social-media-functions.php'; ?>
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
              <h2 class="text-left medium">Sign up for restaurant insights</h2>
              <div class="form-wrap">
                <?php inc_form(147); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php while (have_posts()) : the_post(); ?>
      <div class="row align-center gray">
        <div class="columns xlarge-12 large-11 medium-11 small-11 post">
          <div class="inner {{ get_field('show_right_rail') ? '' : 'expanded' }}">
            <?php the_content(); ?>
          </div>
          @if (get_field('show_right_rail'))
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
            @endif
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
  <section class="article-bottom">
    <div class="row align-middle align-center fw">
      <div class="columns small-12 medium-10 large-7">
        <h2 class="text-left">Sign up for restaurant insights</h2>
        <div class="form-wrap">
          <?php inc_form(147); ?>
        </div>
      </div>
    </div>
  </section>
  <?php 
  if (get_field('select_articles_for_inclusion')): 

    $cardAlign = get_field('card_text_alignment');
    $color = get_field('feed_card_headline_color');
    $featured_posts = get_field('feed_data');
    $cardStyle = get_field('card_style');
    $gridStyle = get_field('grid_style');
    ?>
    <section class="s-grid-cards gh-cards">
      <div class="row align-center align-top">
        <div class="columns">
          <h2 class="text-center">More articles like this</h2>
        </div>
      </div>
      <div class="row align-center align-top" data-equalizer>
        <?php
        if( $featured_posts ): ?>
        <?php foreach( $featured_posts as $featured_post ): 
          $permalink = get_permalink( $featured_post->ID );
          $title = get_the_title( $featured_post->ID );
          ?>
          <div class="card-col columns <?php echo $gridStyle === 'three-up' ? 'large-4 medium-6 small-12' : 'large-3 medium-6 small-12' ?> <?php echo get_field('disable_animation', $featured_post->ID) || get_sub_field('disable_animation', $featured_post->ID) ? '' : 'card-anim' ?>">
            <a href="<?php echo $permalink; ?>">
              <div class="card <?php echo $cardStyle === 'white' ? 'white' : 'transparent'; ?>" 
                <?php echo get_sub_field('button_type') === 'inline' ? 'onclick=location.href="'.$permalink.'"' : ''; ?> data-equalizer-watch>
                <?php if (get_sub_field('image_type') === 'icon'): ?>
                <div class="icon">
                  <?php echo get_the_post_thumbnail($featured_post->ID); ?>
                </div>
                <?php else: ?>
                <div class="img">
                  <?php echo get_the_post_thumbnail($featured_post->ID); ?>
                </div>
                <?php endif; ?>
                <h3 class="<?php echo $color .' '. $cardAlign; ?> subhead even"><?php echo limit_text($title, 8); ?></h3>
                <?php if (get_sub_field('button_type') === 'inline'): ?>
                <p class="<?php echo $cardAlign; ?> space"><?php echo limit_text(get_the_excerpt($featured_post->ID), 20); ?> <a href="<?php echo $permalink; ?>">&hellip;</a></p>
                <?php else: ?>
                <p class="<?php echo $cardAlign; ?> space"><?php echo limit_text(get_the_excerpt($featured_post->ID), 20); ?></p>
                <a href="<?php echo $permalink; ?>" class="button <?php echo get_sub_field('button_style'); ?>">Learn more</a>
                <?php endif ?>
              </div>
            </a>
          </div>
          <?php endforeach; ?>
          <?php endif; ?>  
        </div>
      </section>
      <?php else: ?>
      <section class="s-grid-cards gh-cards">
        <div class="row align-center align-middle">
          <div class="columns">
            <h2 class="text-center">More articles like this</h2>
          </div>
        </div>
        <div class="row align-center align-top" data-equalizer>
          <?php
          $relargs = array(
            'post_type' => 'gh_help_center',
            'posts_per_page' => 4,
            'orderby' => 'rand'
          );
          $relloop = new WP_Query( $relargs );
          while ( $relloop->have_posts() ) : $relloop->the_post();
            ?>
            <div class="card-col columns large-3 medium-6 small-12 card-anim">
              <div class="card transparent" data-equalizer-watch>
                <div class="img">
                  <?php echo get_the_post_thumbnail($featured_post->ID); ?>
                </div>
                <h3 class="black text-center even subhead"><?php echo limit_text(get_the_title(), 8); ?></h3>
                <p class="text-center space"><?php echo limit_text(get_the_excerpt(), 20); ?></p>
                <a href="<?php the_permalink(); ?>" class="button primary">Learn more</a>
              </div>
            </div>
            <?php endwhile; wp_reset_query(); ?>
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
               case 'dual_cta':
               include get_template_directory() . '/views/components/dual-cta.php';
               break;
               case 'general_content':
               include get_template_directory() . '/views/components/general-content.php';
               break;
               case 'tab_component':
               include get_template_directory() . '/views/components/tab-component.php';
               break;
               case 'tile_stack_links':
               include get_template_directory() . '/views/components/tile-stack-links.php';
               break;
             endswitch;  
           endwhile;
         endif;
         ?>
       </section>
       <section id="bottomForm" class="bottom-form">
        <div class="row align-justify align-middle">
          <div class="columns small-12 medium-12 large-6">
            <h2>Don't leave money on the table</h2>
            <h3>The faster you partner with Grubhub, the faster your business can grow.</h3>
          </div>
          <div class="columns small-12 medium-12 large-5">
            <p class="form-text-area">Join Grubhub Marketplace and get access to all the benefits that go with it. <b>All fields required</b></p>
            <?php inc_form('63'); ?>
            <p class="form-text-area">Already have an account?
              <a href="https://restaurant.grubhub.com/" target="_blank" aria-label="Sign in">Sign in</a></p>
            </div>
          </div>
        </section>
        @endsection
