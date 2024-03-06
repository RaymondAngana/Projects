@extends('layouts.app')
@section('content')
<?php
$mh_text_color = get_field('ss_text_color', 'option');
$mh_backgroundImg = get_field('ss_background_img', 'option');
?>
<style>
  .marq-h-content h1 {
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
      background-position: right;
    }
  }
</style>
<section id="marqHalf">
  <div class="row align-justify align-middle half-half">
    <div class="columns small-12 medium-12 large-5 marq-h-content">
      @if (get_field('ss_headline', 'option'))
      <h1>{{ the_field('ss_headline', 'option') }}</h1>
      @endif
      @if (get_field('ss_subheadline', 'option'))
      <p class="head2-sub">{{ the_field('ss_subheadline', 'option') }}</p>
      @endif
      @if (get_field('ss_marquee_cta', 'option'))
      @php $link = get_field('ss_marquee_cta', 'option'); @endphp
      <a href="{{$link['url']}}" target="{{$link['target']}}" class="button primary nav-scroll">{{ $link['title'] }}</a>
      @endif
    </div>
    <div class="columns small-12 medium-12 large-6 marq-bg">
    </div>
  </div>
</section>
<section class="blog-wrap s-grid-cards gh-cards">
  <div class="row">
    <div class="columns text-center">
      <h2>More success stories</h2>
    </div>
  </div>
  <div class="row">
    @while (have_posts()) @php the_post() @endphp
    <div class="card-col columns large-4 medium-6 small-12" data-equalizer-watch>
      <a href="{{ the_permalink() }}" class="card-link">
        <div class="card img-card">
          <div class="img filler">
            @if(has_post_thumbnail())
            {{ the_post_thumbnail() }}
            @else
            <img src="@asset('images/gh-placeholder.jpg')">
            @endif
            @php echo do_shortcode('[read_meter]') @endphp
          </div>
          <h3 class="blueberry even head3-special">{!! wp_trim_words(the_title(), 10, '...') !!}</h3>
          <p>{!! wp_trim_words(get_the_excerpt(), 25, '...') !!}</p>
        </div>
      </a>
    </div>
    @endwhile
  </div>
  <div class="row">
    <div class="columns">
      <div class="pagination">
        {!! gh_numeric_pagination() !!}
      </div>
    </div>
  </div>
</section>

{{-- Non-gutenberg method of including ability to leverage our components --}}

<section class="components bp">
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

  if ( have_rows('ss_all_components', 'option') ) {
    while ( have_rows('ss_all_components', 'option') ) {
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
<?php if (get_field('enable_bug_alt', 'option')): ?>
<a href="#bottomForm" class="bug nav-scroll" tabindex="0" aria-label="Join Grubhub">
  <svg fill="none" viewBox="0 0 70 128" xmlns="http://www.w3.org/2000/svg">
    <g filter="url(#a)">
      <path d="M70 80L8 87.5288V119L70 112.55V80Z" fill="#FF8000"/>
      <path d="M70 0L8 7.52877V39L70 32.5498V0Z" fill="#FF8000"/>
      <rect x="8" y="10" width="62" height="101" fill="#FF8000"/>
      <path d="m26.02 22.459h-2.48v8.144c0 0.528-0.256 0.784-0.656 0.784h-0.544v2.32h0.8c1.952 0 2.88-0.896 2.88-2.88v-8.368zm7.2125-0.24c-3.328 0-5.904 2.336-5.904 5.84s2.576 5.84 5.904 5.84 5.904-2.336 5.904-5.84-2.576-5.84-5.904-5.84zm0 2.56c1.792 0 3.168 1.264 3.168 3.28s-1.376 3.28-3.168 3.28-3.168-1.264-3.168-3.28 1.376-3.28 3.168-3.28zm9.7004-2.32h-2.48v11.2h2.48v-11.2zm11.91 0h-2.48v6.928h-0.016l-5.36-6.928h-2.096v11.2h2.48v-6.896h0.016l5.344 6.896h2.112v-11.2z" fill="#fff"/>
      <g clip-path="url(#b)" fill="#fff">
        <path d="m32.652 67.722c0 0.7296-0.2919 4.0858-2.6996 4.8154-1.6781 0.5107-2.5537-0.8026-2.5537-3.794v-11.017c0-1.0214 0.073-2.6266 1.0215-3.7939 0.5837-0.7297 1.5322-1.3134 2.4077-1.3863 1.0215-0.073 1.897 0.8026 1.897 2.5536v1.6781c0 0.3649 0.2919 0.5837 0.6567 0.4378l4.1588-1.5322c0.1459-0.0729 0.2918-0.2189 0.2918-0.4377v-1.897c0-4.5236-3.9399-7.2232-8.1717-6.1288-5.7639 1.5322-7.6609 6.7854-7.6609 10.288v13.644c0 4.9614 3.4292 7.3691 6.4206 7.3691 4.3777 0 9.412-3.4291 9.412-10.798v-8.4636c0-0.4377-0.3648-0.5107-0.6566-0.4377l-6.7125 2.4807c-0.4377 0.1459-0.4377 0.3648-0.4377 0.6566v3.867c0 0.3648 0.2918 0.5837 0.6566 0.4377l1.97-0.7296v2.1889z"/>
        <path d="m55.343 93.476c0.3648 0.1459 0.6567-0.073 0.6567-0.4378v-28.601c0-0.2189-0.2189-0.4378-0.4378-0.5837l-4.2318-1.5322c-0.3648-0.1459-0.6566 0.073-0.6566 0.4378v11.09l-4.3777-1.6052v-11.309c0-0.2188-0.2189-0.4377-0.4378-0.5837l-4.2317-1.5321c-0.3648-0.146-0.6567 0.0729-0.6567 0.4377v28.528c0 0.2189 0.2189 0.4378 0.4378 0.5837l4.2318 1.5322c0.3648 0.1459 0.6566-0.073 0.6566-0.4378v-11.528l4.3777 1.6052v11.82c0 0.2189 0.2189 0.4378 0.4378 0.5837l4.2317 1.5322z"/>
      </g>
      <path d="M8 119.5V101L37.5 116L8 119.5Z" fill="#FF8000"/>
    </g>
    <defs>
      <filter id="a" x="0" y="0" width="70" height="127.5" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/>
        <feOffset dx="-4" dy="4"/>
        <feGaussianBlur stdDeviation="2"/>
        <feComposite in2="hardAlpha" operator="out"/>
        <feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
        <feBlend in2="BackgroundImageFix" result="effect1_dropShadow"/>
        <feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
      </filter>
      <clipPath id="b">
        <rect transform="translate(22 47)" width="34" height="46.476" fill="#fff"/>
      </clipPath>
    </defs>
  </svg>
</a>
<?php endif; ?>
@endsection