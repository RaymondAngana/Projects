<?php

/**
 * All Accessibility-fixes script in one file.
 */
class CareerSource_accessibility_fixes {
  /**
   * Constructor.
   */
  function __construct() {
    // CWR-286: Modify the <META> tag add content attribute with value.
    add_action('after_setup_theme', array($this, 'modify_entry_top'));

    // CWR-278: Add trigger DIV in the footer and enqueue accessible script.
    add_action('tha_body_bottom', array($this, 'make_wp_livechat_accessible'));

    // CWR-276: Add h2 on top of all footer blocks.
    add_action('tha_footer_top', array($this, 'append_h2_heading_on_footer_top'), 101);

    // CWR-181: Update Logo output as required by remediation.
    add_filter('wmhook_polyclinic_tf_get_the_logo_output', array($this, 'alter_logo_output'));

    // CWR-181: Change ID of hovercard in WP LiveChat.
    add_filter('wplc_filter_hovercard_content', array($this, 'alter_duplicate_id'));

    // CWR-181: CWR-181: Set tabindex to the WPLivechat icon.
    add_filter('wplc_filter_live_chat_box_html_header_div_top', array($this, 'modify_wplc_header_top'));

    // CWR-279: Add screen-reader-text to wp-livechat-plugin.
    add_filter('wplc_filter_chat_header_under', array($this, 'add_screen_reader_text'), 2, 10);

    // CWR-276: Change h2 to h3 as per remediation request.
    add_filter('wmhook_shortcode_content_module_item_html', array($this, 'change_h2_to_h3'));
    add_filter('wmhook_shortcode_posts_item_html', array($this, 'change_h2_to_h3'));

    // CWR-288: Filter the location placeholder's value in calendar.
    add_filter('gettext', array($this, 'filter_location_in_tribe_events_filter'), 10, 3);

    // CWR-288: Modify title tag content on search results page.
    add_filter('pre_get_document_title', array($this, 'modify_title_on_search_results'), 999, 1);
  }

  function alter_logo_output($output) {
    if (is_front_page()) {
      // Set the h1 open/close tags to blank.
      $output[10] = $output[40] = '';
    }
    return $output;
  }

  function alter_duplicate_id($content) {
    $css = '
      <style type="text/css">
        #wplc_first_message_hovercard strong {
          display: block;
          clear: right;
        }
      </style>';

    return $css . str_replace('wplc_first_message', 'wplc_first_message_hovercard', $content);
  }

  function modify_wplc_header_top($output) {
    $alert_msg = '<div role="alert" class="success screen-reader-text"></div>';
    return $alert_msg . str_replace('wp-live-chat-header', 'wp-live-chat-header" role="button" tabindex="0', $output);
  }

  /**
   * CWR-278: Make WP-Live-chat-plugin accessible by adding a trigger div
   * and triggering it when the wp-live-chat-header DIV is clicked by checking
   * event.target.id through event bubble from the "body" as attaching event
   * directly into wp-live-chat-header ($.on()) wouldn't work.
   */
  function make_wp_livechat_accessible() {
    echo '<div id="wp-live-chat-header-trigger"></div>';
  }

  function add_screen_reader_text($msg) {
    return '<span class="screen-reader-text">Open/Close Live Chat</span>';
  }

  function append_h2_heading_on_footer_top() {
    $h2_heading = '<h2 class="screen-reader-text">Main Footer Area</h2>';
    echo $h2_heading;
  }

  function change_h2_to_h3($output) {
    // Ensure we're only replacing h2 with h3 in homepage.
    if (is_front_page()) {
      $output = preg_replace('/<h2(.*?)<\/h2>/si', '<h3$1</h3>', $output);
    }

    return $output;
  }

  function modify_entry_top() {
    // In remove_action(), the priority has to match EXACTLY as when it was previously defined.
    remove_action('tha_entry_top', 'polyclinic_entry_container_schema_meta', -10);
    add_action('tha_entry_top', function () {
      echo '<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" content="' . get_the_title() . '"/>';
    }, -10);
  }

  function filter_location_in_tribe_events_filter($text, $untranslated, $domain) {
    if ($text == "Location" && $domain == 'tribe-events-calendar-pro') {
      $text = "Location (i.e. City)";
    }

    return $text;
  }

  function modify_title_on_search_results($title) {
    if (is_search()) {
      global $wp_query;
      $total = $wp_query->found_posts;
      $title = 'Your ' . $title . ' returned ' . $total . ' results.';
    }
    return $title;
  }

// DO NOT DELETE.
}

// Instantiate widget call.
$careersource_widgets = new CareerSource_accessibility_fixes();

