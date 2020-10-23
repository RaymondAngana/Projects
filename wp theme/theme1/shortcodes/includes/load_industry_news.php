<?php
function load_industry_news($query_posts) {
  if ($query_posts->have_posts()) {
    $html = '';

    while ($query_posts->have_posts()) {
      $query_posts->the_post();

      $content = strip_tags(get_the_content());
      $ellipsis = strlen($content) > 500 ? '...' : '';

      $html .= '
         <div class="fl-col-group fl-col-group-nested shortcode_generated_industry_news">
          <div class="fl-col fl-col-width-custom" style="width: 66.98%">
            <div class="fl-col-content fl-node-content">
              <div class="fl-module fl-module-rich-text">
                <div class="fl-module-content fl-node-content">
                  <div class="fl-rich-text">
                    <h4> ' . get_the_title() . '</h4>
                    <p>' . substr($content, 0, 500) . $ellipsis . '</p>
                    <p style="margin-top: 10px;">
                      <a aria-label="Read more about ' . get_the_title() . '" href="' . esc_url(get_permalink()) . '" class="wm-button color-neutral size-medium button">
                      READ MORE</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      ';
    } // Endwhile.

    return $html;
  } // Endif.
}
