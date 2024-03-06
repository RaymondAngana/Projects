<?php

/**
 * FAQ Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$headline = call_user_func($field_or_subfield, 'test_headline');
$faqs = call_user_func($field_or_subfield, 'post_feed');
$footnote = call_user_func($field_or_subfield, 'footnote');
$bg = call_user_func($field_or_subfield, 'section_background_color');
$align = call_user_func($field_or_subfield, 'test_headline_align');
$multiple = call_user_func($field_or_subfield, 'allow_multiple');
$headline = call_user_func($field_or_subfield, 'test_headline');
$padding = call_user_func($field_or_subfield, 'custom_padding');

if( $faqs ): ?>
  <section class="faq-wrap <?php echo $bg; ?>" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
  <?php if (!empty($headline)): ?>
      <div class="row">
        <div class="columns">
          <p class="head2-sub <?php echo $align; ?>"><?php echo $headline; ?></p>
        </div>
      </div>
    <?php endif; ?>
    <div class="row">
      <div class="columns">
        <ul class="accordion" data-accordion data-allow-all-closed="true" data-multi-expand="<?php echo $multiple ? 'true' : 'false'; ?>">
          <?php $count = 0; foreach( $faqs as $faq ):
          $count++;
          $title = get_the_title( $faq->ID );
          $content = apply_filters('the_content', get_post_field('post_content', $faq->ID));
          ?>
          <li class="accordion-item <?php echo get_field('open_first') && $count === 1 ? 'is-active': ''; ?>" data-accordion-item>
            <a href="#" class="accordion-title"><?php echo $title; ?></a>

            <div class="accordion-content" data-tab-content>
              <?php echo $content; ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <?php if (!empty($footnote)): ?>
  <div class="row">
    <div class="columns">
      <p class="footnote"><?php echo $footnote; ?></p>  
    </div>
  </div>
  <?php endif; ?>
</section>

<?php 
  // Generate Structured Data
global $schema;
$schema = array(
  '@context'   => "https://schema.org",
  '@type'      => "FAQPage",
  'mainEntity' => array()
);
foreach( $faqs as $faq ): 
  $title = get_the_title( $faq->ID );
  $content = get_post_field('post_content', $faq->ID );
  $questions = array(
    '@type'          => 'Question',
    'name'           => $title,
    'acceptedAnswer' => array(
      '@type' => "Answer",
      'text' => $content
    ));
  array_push($schema['mainEntity'], $questions);
endforeach; ?>
<?php
if (!function_exists('gh_generate_faq_schema')) {
function gh_generate_faq_schema ($schema) {
  global $schema;
  echo '<script type="application/ld+json">'. json_encode($schema) .'</script>';
}
add_action( 'wp_footer', 'gh_generate_faq_schema', 100 );
}
?>
<?php endif; ?>
