@extends('layouts.app')

@section('content')
<?php
$bg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
$text_color = get_field('text_color') ? : '#000000';
?>

<style>
  .header-color {
    color: <?php echo $text_color; ?> 
  }

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

     <h1 class="header-color"><?php the_title(); ?></h1>
     <div class="social-row">
      <div class="social-row-left">
        <?php if (!get_field('hide_author')): ?>
        <ul class="left">
          <?php $author_id = $post->post_author; ?>
          <h4><?php echo get_the_author_meta( 'display_name', $author_id ); ?></h4>
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
  <div class="row article-main align-center">
    <div class="columns small-11 ba-overlap">
      <div class="row align-center gray">
        <div class="columns xlarge-12 large-12 medium-12 small-12 subscription-form">
          <div class="row align-center align-middle hz">
            <div class="columns xlarge-12 large-12 medium-12 small-12 flex">
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
        <div class="columns xlarge-12 large-12 medium-12 small-12 post">
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
                <a href="<?php echo get_tag_link( $tag->term_id ); ?>"><?php echo $tag->name . ' '; ?></a>
                <?php endforeach; ?>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
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

                  if ( have_rows('blog_below_article_components') ) {
                    while ( have_rows('blog_below_article_components') ) {
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
  $headline = get_field('section_headline');
  $align = get_field('section_headline_alignment');

  if (get_field('select_articles_for_inclusion')): 

    $cardAlign = get_field('card_text_alignment');
    $color = get_field('feed_card_headline_color');
    $featured_posts = get_field('feed_data');
    $cardStyle = get_field('card_style');
    $gridStyle = get_field('grid_style');
    ?>
    <section class="s-grid-cards gh-cards">
      <div class="row align-center align-middle">
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
          <div class="card-col columns large-3 medium-6 small-12 <?php echo get_field('disable_animation', $featured_post->ID) ? '' : 'card-anim' ?>">
            <div class="card <?php echo $cardStyle === 'white' ? 'white' : 'transparent'; ?>" 
              <?php echo get_field('button_type') === 'inline' ? 'onclick=location.href="'.$permalink.'" onkeypress=location.href="'.$permalink.'"' : ''; ?> tabindex="0" data-equalizer-watch>
              <?php if (get_field('image_type') === 'icon'): ?>
              <div class="icon">
                <?php echo get_the_post_thumbnail($featured_post->ID); ?>
              </div>
              <?php else: ?>
              <div class="img">
                <?php echo get_the_post_thumbnail($featured_post->ID); ?>
              </div>
              <?php endif; ?>
              <h3 class="<?php echo $color .' '. $cardAlign; ?> subhead even"><?php echo limit_text($title, 8); ?></h3>
              <?php if (get_field('button_type') === 'inline'): ?>
              <p class="<?php echo $cardAlign; ?> space"><?php echo limit_text(get_the_excerpt($featured_post->ID), 20); ?> <a href="<?php echo $permalink; ?>">&hellip;</a></p>
              <?php else: ?>
              <p class="<?php echo $cardAlign; ?> space"><?php echo limit_text(get_the_excerpt($featured_post->ID), 20); ?></p>
              <a href="<?php echo $permalink; ?>" class="button <?php echo get_field('button_style'); ?>">Learn more</a>
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
            <h2 class="text-center">More articles like this</h2>
          </div>
        </div>
        <div class="row align-center align-top" data-equalizer>
          <?php
          $relargs = array(
            'post_type' => 'post',
            'posts_per_page' => 4,
            'orderby' => 'rand'
          );
          $relloop = new WP_Query( $relargs );
          while ( $relloop->have_posts() ) : $relloop->the_post();
            ?>
            <div class="card-col columns large-3 medium-6 small-12 card-anim">
              <div class="card transparent min-height" data-equalizer-watch>
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

                  if ( have_rows('blog_page_bottom_components') ) {
                    while ( have_rows('blog_page_bottom_components') ) {
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
