<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')
<body @php body_class() @endphp>
  <?php the_field('body_scripts', 'option'); ?>
  @php do_action('get_header') @endphp
  @include('partials.header')
  <div class="wrap container" role="document">
    <main class="main">
      @yield('content')
    </main>
    <div id="bug-trigger"></div>
    <div class="nav-ol"></div>
  </div>
  @php do_action('get_footer') @endphp
  @include('partials.footer')
  @php wp_footer() @endphp
  <?php the_field('footer_scripts', 'option'); ?>
</body>
</html>
