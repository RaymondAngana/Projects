@extends('layouts.app')
@section('content')
<?php $term = get_queried_object(); ?>
<section id="simpleMarq" class="simple-marq tax"></section>
<section class="article-body tax grey-bottom grid-cards gh-cards">
  <div class="row collapse article-main tax">
    <div class="columns small-12">
      <div class="row align-center gray">
        <div class="columns xlarge-12 large-11 medium-11 small-11 top">
          <h1><?php echo $term->name ?></h1>
        </div>
      </div>
    </div>
  </div>
  <div class="row align-center collapse">
    <div class="columns small-12">
      <div class="row" data-equalizer>
        <?php
        $args = array(
          'post_type' => array('gh_success', 'gh_resources', 'gh_help_center'),
          'posts_per_page' => -1,
          'paged' => $paged,
          'tax_query' => array(
            array(
              'taxonomy' => 'cattypes',
              'field' => 'slug',
              'terms' => array('guide')
            ),
          )
        );
        $taxLoop = new WP_Query( $args );
        if ( $taxLoop->have_posts() ) :
          while ( $taxLoop->have_posts() ) : $taxLoop->the_post();
            ?>
            <div class="card-col columns large-3 medium-6 small-12 <?php echo get_field('disable_animation') ? '' : 'card-anim' ?>" data-equalizer-watch>
              <div class="card img-card top-flush text-left">
                <a href="<?php the_permalink(); ?>">
                  <div class="img">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail(); ?>
                    <?php endif; ?>
                  </div>
                  <h3 class="subhead even"><?php echo limit_text(get_the_title(), 8); ?></h3>
                  <p><?php echo limit_text(get_the_excerpt(), 20); ?></p>
                </a>
              </div>
            </div>
            <?php 
          endwhile; wp_reset_query(); 
        else:
          ?>
          <p class="text-center">No posts found.</p>
          <?php endif; ?>
        </div>
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