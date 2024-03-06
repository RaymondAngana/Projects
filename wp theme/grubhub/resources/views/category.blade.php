@extends('layouts.app')
@section('content')
<?php
$postID = 11178;
$mh_text_color = get_field('mh_text_color', $postID);
$mh_backgroundImg = get_field('mh_background_img', $postID);
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

  .marq-form-bg-mob {
    display: block;
  }
  @media screen and (min-width: 768px) {
    .marq-form-bg {
      background-image: url(/wp-content/themes/GrubHub/dist/images/marq-form-bg.png);
      background-repeat: no-repeat;
      background-size: contain;
    }
    .marq-form-bg-mob {
      display: none;
    }
  }
</style>
<section id="marqHalf">
  <div class="row align-justify align-middle half-half">
    <div class="columns small-12 medium-5 large-5 marq-h-content">
      @if (get_field('mh_headline', $postID))
      <h1>{{ the_field('mh_headline', $postID) }}</h1>
      @endif
      @if (get_field('mh_subheadline', $postID))
      <p class="head2-sub">{{ the_field('mh_subheadline', $postID) }}</p>
      @endif
      <div class="subscription-form">
        <h3 class="text-left medium head3-special">{{ the_field('mh_form_headline', $postID) }}</h3>
        <div class="form-wrap"> 
          @if (get_field('mh_formID', $postID)) 
          @php
          $mh_formID = get_field('mh_formID', $postID);
          inc_form($mh_formID);
          @endphp
          @else
          <p class="no-form">No form selected.</p>
          @endif
        </div>
      </div>
    </div>
    <div class="columns small-12 medium-6 large-6 marq-bg">
    </div>
  </div>
</section>
<section class="featured-post">
  @php
  $featured_posts_top = get_field('featured_article_top', $postID);
  $fpt = $featured_posts_top['featured_article'];
  $cta = $featured_posts_top['cta_text'] ?: 'Read the post';
  @endphp
  @if( $fpt )
  <div class="row align-middle align-justify">
    @foreach( $fpt as $featured_post_top )
    @php
    $permalink = get_permalink( $featured_post_top->ID );
    $title = get_the_title( $featured_post_top->ID );
    $excerpt = get_the_excerpt( $featured_post_top->ID );
    $img = get_the_post_thumbnail( $featured_post_top->ID );
    @endphp
    <div class="columns large-5 medium-12 small-12">
      {!! $img !!}
    </div>
    <div class="columns large-5 medium-12 small-12">
      <p class="eyebrow">Featured post</p>
      <h3>{{ $title }}</h3>
      <p>{!! $excerpt !!}</p>
      <a href="{{ $permalink }}" class="button primary">{{ $cta }}</a>
    </div>
    @endforeach
  </div>
  @endif 
</section>
<section class="blog-wrap s-grid-cards gh-cards">
  <div class="row">
    <div class="columns large-3 medium-12 small-12">
      <div class="left-rail">
        @php
        $alignment = get_field('heading_alignment', $postID);
        $color = get_field('heading_color', $postID);
        @endphp
        <h4 class="{{ $alignment }} {{ $color }}">{{ the_field('left_rail_heading', $postID) }}</h4>
        @php
        $category = get_category(get_query_var('cat'));
        $cat_id = $category->cat_ID;

        $categories = get_categories([
          'orderby' => 'name',
          'order'   => 'ASC',
          'parent'  => 0,
        ]);
        @endphp  
        <ul class="show-for-large">
          @foreach( $categories as $cat )
          <li class="{{ $cat->term_id === $cat_id ? 'active' : '' }}"><a href="{{ get_category_link($cat->term_id) }}?position=posts">{{ $cat->name }}</a></li>
          @endforeach
        </ul>
        <select name="categories" id="categories-mob" class="hide-for-large">
          @foreach( $categories as $cat )
            <option value="{{ get_category_link($cat->term_id) }}">{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="left-rail">
        <h4>{{ the_field('form_headline', $postID) }}</h4>
        @if (get_field('form_id', $postID)) 
        @php
        $formID = get_field('form_id', $postID);
        inc_form($formID);
        @endphp
        @else
        <p class="no-form">No form selected.</p>
        @endif
      </div>
    </div>
    <div class="columns large-9 medium-12 small-12">
      <div class="row" data-equalizer>
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
              <h3 class="subhead blueberry even">{!! wp_trim_words(get_the_title(), 7, '...') !!}</h3>
              <p>{!! wp_trim_words(get_the_excerpt(), 20, '...') !!}</p>
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
    </div>
  </div>
</section>
<section class="featured-post bottom">
  @php
    $featured_posts_bottom = get_field('featured_article_bottom', $postID);
    $fpb = $featured_posts_bottom['featured_article'];
    $cta = $featured_posts_bottom['cta_text'] ?: 'Read the post';
  @endphp
  @if( $fpb )
  <div class="row flex-dir-row-reverse align-middle align-justify">
    @foreach( $fpb as $featured_post_bottom )
    @php
    $permalink = get_permalink( $featured_post_bottom->ID );
    $title = get_the_title( $featured_post_bottom->ID );
    $excerpt = get_the_excerpt( $featured_post_bottom->ID );
    $img = get_the_post_thumbnail( $featured_post_bottom->ID );
    @endphp
    <div class="columns large-5 medium-12 small-12">
      {!! $img !!}
    </div>
    <div class="columns large-5 medium-12 small-12">
      <p class="eyebrow">Featured post</p>
      <h3>{{ $title }}</h3>
      <p>{!! $excerpt !!}</p>
      <a href="{{ $permalink }}" class="button primary">{{ $cta }}</a>
    </div>
    @endforeach
  </div>
  @endif 
</section>

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

  if ( have_rows('components', $postID) ) {
    while ( have_rows('components', $postID) ) {
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

@endsection