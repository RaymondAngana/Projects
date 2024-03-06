@extends('layouts.app')

@section('content')

<section class="search-wrap">
  <div class="row">
    <div class="columns large-3 medium-12 small-12 small-order-2 medium-order-1">  
      <div class="left-rail">
        <h4>Top 10 searches</h4>
        <?php 
        $statistics = \SearchWP\Statistics::get_popular_searches( [
          'days'   => 10,
          'engine' => 'default',
        ] );

        \SearchWP\Statistics::display( $statistics );
        ?>
      </div>
    </div>
    <div class="columns large-9 medium-12 small-12 small-order-1 medium-order-2">
      <div class="row align-center">
        <div class="columns large-11 medium-12 small-12">
          @if (!have_posts())
          <?php $ids = array(); ?>
          <div class="term-wrap">
            <h4>Sorry, no results were found.</h4>
          </div>
          @else
          <div class="term-wrap">
            <h4>Results for &ldquo;{{ get_search_query() }}&rdquo;</h4>
          </div>
          @endif
          <h3>Top results</h3>
          <div class="top-results">
            @while (have_posts()) @php the_post() @endphp
            <?php  $ids[] = get_the_ID(); ?>
            <a href="{{ the_permalink() }}">
              <div class="row result">
                <div class="columns large-3 medium-3 small-3">
                  @if (has_post_thumbnail())
                  {{ the_post_thumbnail() }}
                  @else
                  <img src="@asset('images/gh-placeholder.jpg')">
                  @endif
                </div>
                <div class="columns large-9 medium-9 small-9">
                  <h4>{{ the_title() }}</h4>
                  <div class="excerpt">{{ get_the_excerpt() }} &hellip;</div>
                </div>
              </div>  
            </a>        
            @endwhile
          </div>
        </div>
      </div>
      <div class="row align-center">
        <div class="columns large-11 medium-12 small-12 tab-wrap">
          @php
          $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
          $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
          $keyword = basename($url);
          $allArgs = array(
            'post_type' => array('post', 'page', 'gh_products', 'gh_resources'),
            's' => $keyword,
            'posts_per_page' => -1,
            'orderby' => 'relevance',
            'post__not_in' => $ids,
            'order' => 'DESC',
            'paged' => $paged
          );
          $blogArgs = array(
            'post_type' => array('post'),
            's' => $keyword,
            'posts_per_page' => -1,
            'orderby' => 'relevance',
            'post__not_in' => $ids,
            'order' => 'DESC'
          );
          $resArgs = array(
            'post_type' => array('gh_resources'),
            's' => $keyword,
            'posts_per_page' => -1,
            'orderby' => 'relevance',
            'post__not_in' => $ids,
            'order' => 'DESC'
          );
          $allLoop = new WP_Query( $allArgs );
          $blogLoop = new WP_Query( $blogArgs );
          $resLoop = new WP_Query( $resArgs );
          $totalPosts = $allLoop->found_posts;
          $totalBlog = $blogLoop->found_posts;
          $totalRes = $resLoop->found_posts;
          @endphp
          <ul class="tabs" data-tabs id="post-specific-results">
            <li class="tabs-title is-active"><a href="#all" aria-selected="true">All Results <span>{{ $totalPosts }}</span></a></li>
            <li class="tabs-title"><a data-tabs-target="blog" href="#panel2">Blog <span>{{ $totalBlog }}</span></a></li>
            <li class="tabs-title"><a data-tabs-target="resources" href="#panel2">Resources <span>{{ $totalRes }}</span></a></li>
          </ul>
          <div class="tabs-content" data-tabs-content="post-specific-results">
            <div class="tabs-panel is-active" id="all">
              @while ( $allLoop->have_posts() ) @php $allLoop->the_post() @endphp
              <div class="row result">
                <div class="columns">
                  <a href="{{ the_permalink() }}">
                    <h4>{{ the_title() }}</h4>
                    <div class="excerpt">{{ get_the_excerpt() }} &hellip;</div>
                  </a>
                </div>
              </div>
              @endwhile @php wp_reset_query() @endphp 
              @php global $wp_query; @endphp
            </div>
            <div class="tabs-panel" id="blog">
              @while ( $blogLoop->have_posts() ) @php $blogLoop->the_post() @endphp
              <div class="row result">
                <div class="columns">
                  <a href="{{ the_permalink() }}">
                    <h4>{{ the_title() }}</h4>
                    <div class="excerpt">{{ get_the_excerpt() }} &hellip;</div>
                  </a>
                </div>
              </div>              
              @endwhile @php wp_reset_query() @endphp 
            </div>
            <div class="tabs-panel" id="resources">
              @while ( $resLoop->have_posts() ) @php $resLoop->the_post() @endphp
              <div class="row result">
                <div class="columns">
                  <a href="{{ the_permalink() }}">
                    <h4>{{ the_title() }}</h4>
                    <div class="excerpt">{{ get_the_excerpt() }} &hellip;</div>
                  </a>
                </div>
              </div>
              @endwhile @php wp_reset_query() @endphp
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
