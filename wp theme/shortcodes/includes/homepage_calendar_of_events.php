<?php

/**
 * Display the homepage calendar of events accepting WP_Query argument.
 */
function homepage_calendar_of_events($query_posts) {
  if ($query_posts->have_posts()) {
    $html = '<div class="wm-row">';

    while ($query_posts->have_posts()) {
      $query_posts->the_post();

      // Get the event's Feature image.
      $featured_image = '';
      if (has_post_thumbnail(get_the_ID())) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()));
        $featured_image = '<p><img class="fl-photo-img wp-image-2119 size-full" src="' . $image[0] . '" alt="' . get_the_title() . ' image" title="' . get_the_title() . ' image" itemprop="image"></p>';
      }

      $ellipsis = strlen(get_the_content()) > 500 ? '...' : '';

      $html .= '
      <div class="wm-column width-1-3 with-margin">
        <div class="wm-content-module-element wm-html-element title">
          <h3>
            <span class="entry-title-primary"> <a href="' . get_permalink() . '">' . get_the_title() . '</a> </span>
          </h3>
        </div>
        <div class="wm-content-module-element wm-html-element content">' .
          '<p>' . tribe_get_start_date() . '</p>' .
          '<p>' . substr(get_the_content(), 0, 500) . $ellipsis . '</p>' . $featured_image .
          '<p><a aria-label="Read more about ' . get_the_title() . '" href="' . get_permalink() . '" class="blue-button"><strong>READ MORE</strong></a></p>
        </div>
      </div>';
    } // Endwhile.

    $html .= '</div>';
    return $html;
  } // Endif.
}
