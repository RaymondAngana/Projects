@extends('layouts.app')

@section('content')
<section id="simpleMarq" class="simple-marq ss"></section>
<section class="article-body grey-bottom">
  <div class="row align-center collapse article-main ss">
    <div class="columns small-11 overlap">
      <div class="row align-center gray">
        <div class="columns xlarge-12 large-12 medium-12 small-12 top">
          <div class="row align-center align-middle hz">
            <div class="columns xlarge-12 large-12 medium-12 small-12">
              <h1><?php the_title(); ?></h1>
            </div>
          </div>
        </div>
      </div>
      <?php if (get_field('feature_image') || get_field('feature_title') || get_field('feature_text')): ?>
      <div class="row align-top align-center gray">
        <div class="columns xlarge-12 large-12 medium-12 small-12 feature-row">
          <div class="row">
            <div class="columns image-column">
              <?php 
              if (get_field('feature_image')): 
                $feature_image = get_field('feature_image');
                ?>
                <img src="<?php echo $feature_image['url']; ?>" alt="<?php echo $feature_image['alt']; ?>"/>
                <?php endif; ?>
              </div>
              <div class="columns text-column">
               <?php if (get_field('feature_title')): ?>
               <h3><?php the_field('feature_title'); ?></h3>
               <?php endif; ?>
               <?php if (get_field('feature_text')): ?>
               <p><?php the_field('feature_text') ?></p>
               <?php endif; ?>
             </div>     
           </div>
         </div>
       </div>
       <?php endif; ?>
       <div class="row collapse align-center">
        <div class="columns large-12 medium-12 small-12">
        <?php if (get_field('success_video_id')): 
              $embedcode = get_field('success_video_id');
              ?>
            <?php if (get_field('success_video_thumbnail')): 
              $video_thumb = get_field('success_video_thumbnail');
              ?>
                <div class="responsive-embed widescreen success-video">
                  <iframe id="video-<?php echo $embedcode; ?>" width="560" height="315" src="https://www.youtube.com/embed/<?php echo $embedcode; ?>?enablejsapi=1" title="YouTube video player" frameborder="0" allow="autoplay; accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" tabindex="-1" data-yt="<?php echo $embedcode; ?>" allowfullscreen></iframe>
                  <label role="button" class="videoplay" tabindex="0">
                    <img src="<?php echo esc_url($video_thumb['url']); ?>" alt="<?php echo $video_thumb['alt']; ?>"/>
                  </label>
                </div>
             <?php else: ?>
                  <div class="responsive-embed widescreen success-video no-thumb">
                    <iframe id="video-<?php echo $embedcode; ?>" width="560" height="315" src="https://www.youtube.com/embed/<?php echo $embedcode; ?>" title="YouTube video player" frameborder="0" allow="autoplay; accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"  tabindex="-1" allowfullscreen></iframe>
                  </div>
            <?php endif; ?>
          <?php endif; ?>
            </div>
          </div>
          <?php while (have_posts()) : the_post(); ?>
          <div class="row align-center gray">
            <div class="columns xlarge-12 large-12 medium-12 small-12 post">
              <div class="inner ss {{ get_field('rail_blocks') ? '' : 'expanded' }}">
                <?php the_content(); ?>
              </div>

              <?php if ( have_rows('rail_blocks')) : ?>
                <div class="right-rail">
                  <?php while ( have_rows('rail_blocks')) : the_row(); ?>
                    <?php if (get_sub_field('headline')) : ?>
                    <h3 class="head3-special"><?php the_sub_field('headline'); ?></h3>
                    <?php endif; ?>

                    <?php if ( have_rows('block')) : ?>
                      <?php while ( have_rows('block')) : the_row(); ?>
                        <div class="block">
                          <?php if (get_sub_field('headline_type') === 'static'): ?>
                            <h3 class="head3-special"><?php the_sub_field('headline'); ?></h3>
                          <?php endif; ?>

                          <?php if (get_sub_field('headline_type') === 'linked'): ?>
                            <?php $hLink = get_sub_field('headline_link'); ?>
                            <a href="<?php echo $hLink['url']; ?>" target="<?php echo $hLink['target']; ?>" class="rail-link"><?php echo $hLink['title']; ?></a>
                          <?php endif; ?>

                          <?php if (get_sub_field('block_type') === 'text'): ?>
                            <p><?php the_sub_field('text'); ?></p>
                          <?php endif; ?>

                            <?php if (have_rows('list')) : ?>
                              <ul>
                                <?php while (have_rows('list')) : the_row(); ?>
                                  <li><?php the_sub_field('list_item'); ?></li>
                                <?php endwhile; ?>
                              </ul>
                            <?php endif; ?>

                            <?php 
                              if (get_sub_field('link')):
                                $link = get_sub_field('link'); 
                              ?>
                              <a href="<?php echo $link['url']; ?>" class="button secondary" target="<?php echo $link['target']; ?>">
                                <?php echo $link['title']; ?>
                              </a>
                              <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                      <?php endif; ?>
                    <?php endwhile; ?>
                  </div>
                <?php endif; ?>  
            </div>
          </div>
          <?php endwhile; ?>
          <div class="row">
            <div class="columns">
              <section class='components'>
                <?php
                  $row_layout_component_config = [
                    'bottom_form_component' => 'bottom-form.php',
                    'centered_asset_+_text_with_cta' => 'centered-asset-text-cta.php',
                    'colored_stats_group_component' => 'colored-stats.php',
                    'faq_component' => 'faq.php',
                    'feature_component' => 'feature-components.php',
                    'grid_cards_component' => 'grid-cards.php',
                    'large_cards_component' => 'large-cards.php',
                    'pull_quote_component' => 'pull-quote.php',
                    'video_carousel' => 'video-carousel.php',
                    'subscription_form_component' => 'form-subscription.php',
                    'feed_cards_component' => 'feed-cards.php',
                    'feature_image_title' => 'feature-image-title.php',
                    'tile_stack_links' => 'tile-stack-links.php',
                    'component_wrap' => 'component-wrap.php',
                    'dual_cta' => 'dual-cta.php',
                    'general_content' => 'general-content.php',
                    'tab_component' => 'tab-component.php',
                  ];

                  if ( have_rows('ss_below_article_components') ) {
                    while ( have_rows('ss_below_article_components') ) {
                      the_row();
                      foreach ($row_layout_component_config as $layout => $fname) {
                        if (get_row_layout() == $layout) {
                          $is_flex = TRUE;
                          include get_template_directory() . '/views/components/' . $fname;
                        }
                      }
                    }
                  }
                  ?>
             </section>
            </div>
          </div>
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
              <h2 class="text-center">More success stories</h2>
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
              </div>
              <?php endforeach; ?>
              <?php endif; ?>  
            </div>
          </section>
          <?php else: ?>
          <section class="s-grid-cards gh-cards">
            <div class="row align-center align-middle">
              <div class="columns">
                <h2 class="text-center">More success stories</h2>
              </div>
            </div>
            <div class="row align-center align-top" data-equalizer>
              <?php
              $relargs = array(
                'post_type' => 'gh_success',
                'posts_per_page' => 4,
                'orderby' => 'rand',
                'post__not_in' => array( $post->ID )
              );
              $relloop = new WP_Query( $relargs );
              while ( $relloop->have_posts() ) : $relloop->the_post();
                ?>
                <div class="card-col columns large-3 medium-4 small-12 card-anim">
                  <div class="card transparent" data-equalizer-watch>
                    <div class="img">
                      <?php echo get_the_post_thumbnail($featured_post->ID); ?>
                    </div>
                    <h3 class="black text-center even subhead"><?php echo limit_text(get_the_title(), 8); ?></h3>
                    <p class="text-center space"><?php echo limit_text(get_the_excerpt(), 20); ?></p>
                    <a href="<?php the_permalink(); ?>" class="button secondary">Learn more</a>
                  </div>
                </div>
                <?php endwhile; wp_reset_query(); ?>
              </div>
            </section>
            <?php endif; ?>
            <section class='components'>
              <div class="row">
                <div class="columns">
                    <?php
                      $row_layout_component_config = [
                        'bottom_form_component' => 'bottom-form.php',
                        'centered_asset_+_text_with_cta' => 'centered-asset-text-cta.php',
                        'colored_stats_group_component' => 'colored-stats.php',
                        'faq_component' => 'faq.php',
                        'feature_component' => 'feature-components.php',
                        'grid_cards_component' => 'grid-cards.php',
                        'large_cards_component' => 'large-cards.php',
                        'pull_quote_component' => 'pull-quote.php',
                        'video_carousel' => 'video-carousel.php',
                        'subscription_form_component' => 'form-subscription.php',
                        'feed_cards_component' => 'feed-cards.php',
                        'feature_image_title' => 'feature-image-title.php',
                        'tile_stack_links' => 'tile-stack-links.php',
                        'component_wrap' => 'component-wrap.php',
                        'dual_cta' => 'dual-cta.php',
                        'general_content' => 'general-content.php',
                        'tab_component' => 'tab-component.php',
                      ];

                      if ( have_rows('ss_page_bottom_components') ) {
                        while ( have_rows('ss_page_bottom_components') ) {
                          the_row();
                          foreach ($row_layout_component_config as $layout => $fname) {
                            if (get_row_layout() == $layout) {
                              $is_flex = TRUE;
                              include get_template_directory() . '/views/components/' . $fname;
                            }
                          }
                        }
                      }
                      ?>
                </div>
              </div>
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
