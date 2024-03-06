@extends('layouts.app')

@section('content')


<div class="error-page row">
      <div class="columns">
        <h4>
          {{ __('Page Not Found', 'sage') }}
        </h4>
        <p>It looks like nothing was found at this location. Maybe try a search?</p>
      </div>
    </div>
  @if (! have_posts())
    <div class="row align-center align-middle">
      <div class="columns">
        <h4 class=" text-center">
          Nothing to see here
        @php echo 'The page you were trying to view does not exist.' @endphp
          {{ __('The page you were trying to view does not exist.', 'sage') }}
        </h4>
      </div>
    </div>
  @endif
@endsection
