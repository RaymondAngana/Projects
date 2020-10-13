<?php

/**
 * Display a single published testimonial randomly.
 * Currently designed for /job-seekers/ page.
 */
function testimony($query_posts) {
  if ($query_posts->have_posts()) {
    $html = '';

    while ($query_posts->have_posts()) {
      $query_posts->the_post();

      // Get the Testimonial's Feature image.
      $featured_image = '';
      if (has_post_thumbnail(get_the_ID())) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()));
        $alt_title = ' alt="' . get_the_title() . ' image" title="' . get_the_title() . ' image" ';
        $featured_image = '<p><img class="alignleft size-full wp-image-2203 wm-testimonials-random" src="' . $image[0] . '"' . $alt_title . '></p>';
      }
      $html .= $featured_image . '
        <p><strong>' . get_the_title() . '</strong><br />' .
        get_field('work_title') . '</p>
        <p>' . get_the_content() . '</p>';
    } // Endwhile.

    return $html;
  } // Endif.
}
