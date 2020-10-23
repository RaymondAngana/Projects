<?php
/**
 * All custom built shortcodes are defined in this file.
 */

require_once('includes/homepage_calendar_of_events.php');
require_once('includes/load_industry_news.php');
require_once('includes/shortcode_testimonials.php');

class CareerSource_shortcodes {
  /**
   * Constructor.
   */
  function __construct() {
  	add_shortcode('homepage_calendar_of_events', array($this, 'homepage_calendar_of_events'));
    add_shortcode('careersource_load_testimonials', array($this, 'pull_random_testimonial'));
    add_shortcode('careersource_load_industry_news', array($this, 'load_industry_news'));
  }

  /**
   * Simply call the shortcode [homepage_calendar_of_events] anywhere on the page.
   * It can also accept a parameter incase we need to scale this soon.
   * [homepage_calendar_of_events size=3] where 3 is the total number of events.
   */
  function homepage_calendar_of_events($attrs) {
    $attr = shortcode_atts(array(
      'size' => 3,
    ), $attrs);

    $args = array(
      'post_type'   => 'tribe_events',
      'showposts' => $attr['size'],
      'meta_query'  => array(
        // Query from custom created ACF field.
        array(
          'key' => 'publish_event_to_homepage',
          'value' => 'yes',
          'compare' => '=',
        ),
      ),
    );
    $query_posts = new WP_Query($args);
    return homepage_calendar_of_events($query_posts);

    // Always reset query as a best practice.
    wp_reset_query();
  }

  /**
   * Simply call the shortcode [careersource_load_industry_news] anywhere on the page.
   * It can accept 3 attribute tags and values: layout, cat and max.
   *    @layout - Predefined layouts. Defaults to 1 (2-column layout).
   *    @cat - The category of the post to pull from. Defaults to all categories.
   *    @max - The total number of latest posts to pull. Defaults to 2.
   */
  function load_industry_news($attrs) {
    $attr = shortcode_atts(array(
      'layout' => 3,
      'cat' => 'all',
      'max' => 2,
    ), $attrs);

    $args = array(
      'post_type' => 'industry-news',
      'posts_per_page' => (int) $attr['max'],
      'tax_query' => array(
        array(
          'taxonomy' => 'industry',
          'field' => 'slug',
          'terms' => $attr['cat'],
        ),
      ),
    );
    $query_posts = new WP_Query($args);
    return load_industry_news($query_posts);

    // Always reset query as a best practice.
    wp_reset_query();
  }

  /**
   * Simply call the shortcode [careersource_load_testimonials] anywhere on the page.
   */
  function pull_random_testimonial($attrs) {
    $args = array(
      'post_type'   => 'wm_testimonials',
      'post_status' => 'published',
      'posts_per_page' => 1,
      'orderby' => 'rand',
    );

    $query_posts = new WP_Query($args);
    return testimony($query_posts);

    // Always reset query as a best practice.
    wp_reset_query();
  }

}

// Instantiate shortcode call.
$careersource_shortcodes = new CareerSource_shortcodes();
