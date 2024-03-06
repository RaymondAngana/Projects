{{--
  Template Name: Profit Calculator
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-profit-calc')
  @endwhile
@endsection
