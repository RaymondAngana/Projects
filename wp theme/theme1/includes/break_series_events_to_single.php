<?php
class CareerSource_break_series_into_single {
  /**
   * Constructor.
   */
  function __construct() {
    if (!empty($_GET['break_event_series'])) {
      include_once (ABSPATH . 'wp-content/plugins/event-tickets/src/Tribe/RSVP.php');

      // Start building query to pull ONLY recurring events.
      $recurring_events = new WP_Query();
      $today = getdate();

      $recurring_events->query(array(
        'post_type' => 'tribe_events',
        'posts_per_page' => -1,
        'post_status' => array('publish', 'private'),
        'date_query' => array(
          array(
            'after' => $today,
            'inclusive' => true,
          )
        ),
        'meta_query' => array(
          array(
            'key'     => '_EventRecurrence',
            'compare' => 'EXISTS',
            ),
          ),
        )
      );

      // If a recurring event exist, process here.
      if ($recurring_events->have_posts()) {
        global $wpdb;
        while ($recurring_events->have_posts()) {
          $recurring_events->the_post();
          $id = get_the_ID();
          $parent_id = wp_get_post_parent_id($id);

          $ticket_post_id = $wpdb->get_var(
            $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s LIMIT 1",
              array('_tribe_rsvp_for_event', $parent_id)
            )
          );

          if (!empty($_GET['debug'])) {
            echo $id . ' <==> parent: ' . $parent_id;
            echo "<br>";
            echo "ticket id: $ticket_post_id";
            echo "<br><br>";
          }

          $this->_add_ticket_meta_info($id, $ticket_post_id, $parent_id);
        }
      }

      echo '<h1 style="background: green; padding: 10px; text-align: center;">
      Successfully converted all event series to a single event!</h1>';

      // VERY IMPORTANT: This ensures there will be no more duplicate events.
      wp_clear_scheduled_hook('tribe_events_pro_process_recurring_events');

      // Always reset query as a best practice.
      wp_reset_query();
    }
  }

  /**
   * Create metadata of the event.
   */
  function _add_ticket_meta_info($id, $ticket_post_id, $parent_id) {
    global $wpdb;

    // Exclude the original event in the series for meta key already exists.
    if ($parent_id != 0) {

      // Delete _EventRecurrence.
      $wpdb->query(
        $wpdb->prepare(
        "DELETE FROM $wpdb->postmeta WHERE post_id = %d AND meta_key LIKE %s",
          array($id, '_EventRecurrence')
        )
      );

      $ticket_title = get_the_title($ticket_post_id);
      $ticket_capacity = get_post_meta($ticket_post_id, '_tribe_ticket_capacity', true);
      $ticket_description = has_excerpt() ? get_the_excerpt($ticket_post_id) : '';

      // Set post_parent to 0
      wp_update_post(array(
          'ID'           => $id,
          'post_parent'   => 0,
        )
      );

      if (! metadata_exists('post', $id, '_tribe_rsvp_for_event')) {
        $args = array(
          'post_status'  => 'publish',
          'post_type'    => 'tribe_rsvp_tickets',
          'post_author'  => get_current_user_id(),
          'post_title'   => $ticket_title,
          'post_excerpt' => $ticket_description,
        );
        // Create new RSVP post and get the ID to associate a post meta values.
        $ticket_id = wp_insert_post($args);

        $post_meta_key_values = array(
          '_tribe_rsvp_for_event'           => $id,
          '_tribe_ticket_capacity'          => $ticket_capacity,
          '_stock'                          => $ticket_capacity,
          '_tribe_ticket_show_description'  => 'yes',
          '_manage_stock'                   => 'yes',
        );
        foreach ($post_meta_key_values as $key => $value) {
          // If no metadata exist, update_post_meta() will create it.
          update_post_meta($ticket_id, $key, $value);
        }
      }
    }
  }

// DO NOT DELETE.
}

$break_series = new CareerSource_break_series_into_single();
