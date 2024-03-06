@extends('layouts.app')

@section('content')
  @php the_content() @endphp
  <section id="bottomForm" class="bottom-form force-padding">
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
